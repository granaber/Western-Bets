<?php
// Test CVS

require_once 'reader.php';
require('prc_php.php');


$GLOBALS['link'] = Connection::getInstance();

$name = $_REQUEST['file'];
//$nc=$_REQUEST['nc'];
$dir = 'arch/';
$grupo = 2;

$data = new Spreadsheet_Excel_Reader();


$data->setOutputEncoding('CP1251');

$data->read($dir . $name);




/*echo  $data->sheets[0]['numRows'];
 $data->sheets[0]['numCols'] - count columns
 $data->sheets[0]['cells'][$i][$j] - data from $i-row $j-column

 $data->sheets[0]['cellsInfo'][$i][$j] - extended info about cell
    
    $data->sheets[0]['cellsInfo'][$i][$j]['type'] = "date" | "number" | "unknown"
        if 'type' == "unknown" - use 'raw' value, because  cell contain value with format '0.00';
    $data->sheets[0]['cellsInfo'][$i][$j]['raw'] = value if cell without format 
    $data->sheets[0]['cellsInfo'][$i][$j]['colspan'] 
    $data->sheets[0]['cellsInfo'][$i][$j]['rowspan'] 
*/

error_reporting(E_ALL ^ E_NOTICE);
$j = 0;
$t = 0;
$contarfilas = true;
$mifecha = '';
$fechanueva = '';
$contarpartido = 0;
$idj = 0;
$idioma = 0; /* 1= Ingles 2 = Espanol */
$linea = 2;
$arreg = array(array());
for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
	//$result = mysqli_query($GLOBALS['link'],'Select * From _tbunidades Where Descripcion="'.ucwords($data->sheets[0]['cells'][$i][3]).'"'); 		// if (mysqli_num_rows($result)!=0):
	//$row = mysqli_fetch_array($result); 
	//$iduni=$row['idunin'];
	//$descrip=str_replace('|',' ',$descrip);
	if ($idioma == 1) : $linea = 2;
	endif;
	if ($idioma == 2) : $linea = 1;
	endif;

	if ($contarfilas) :
		for ($c = 1; $c <= $data->sheets[0]['numCols']; $c++) {

			$descrip = str_replace(',', ' ', $data->sheets[0]['cells'][$i][$c]);
			$descrip = str_replace('.', '', $descrip);
			$descrip = str_replace("'", ' ', $descrip);
			//echo $descrip.'  ';
			if (estoesfecha($descrip)) :
				if ($fechanueva != '') :
					anexarequipo($idj, $arreg, $grupo, $fechanueva, $_REQUEST['minutos']);
					$arreg = array(array());
					$j = 0;
				endif;
				echo $descrip;
				$fechanueva = fecharea2l($descrip);
				$contarfilas = false;
				$idj = veridj($fechanueva);
			else :
				$arreg[$j][$c] =	 $descrip;
			endif;
		}
		$j++;

	else :
		if ($t == $linea) :  $t = 0;
			$contarfilas = true;
		else : $t++;
		endif;
	endif;
	//$result = mysqli_query($GLOBALS['link'],'Insert _tbproyecto_partidas values ('.$i.',"'.$nc.'","'.$data->sheets[0]['cells'][$i][1].'","'.$descrip.'",'.$iduni.",".number_format($data->sheets[0]['cells'][$i][4],2,'.','').',1)');
	//if ($result):
	//	$t++;
	//endif;
	//if (ucwords($data->sheets[0]['cells'][$i][3])!=''):
	// $j++;
	//endif;

}

//$idj=veridj($fechanueva);
anexarequipo($idj, $arreg, $grupo, $fechanueva, $_REQUEST['minutos']);
echo '<span  style="color:#FF0; font-size:16px; text-decoration:blink">Proceso Concluido</span>';

function veridj($fecha)
{
	$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where Fecha='" . $fecha . "' order by Grupo");
	if (mysqli_num_rows($resultj) != 0) :
		$rowj = mysqli_fetch_array($resultj);
		$idj = $rowj["IDJ"];
		$cant = $rowj["Partidos"];
		$grp = $rowj["Grupo"];
	else :
		$cant = 0;
		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb Order by IDJ DESC ");
		$row = mysqli_fetch_array($result);
		if ($result) :
			$idj = $row["IDJ"] + 1;
		else :
			$idj = 1;
		endif;

	endif;
	return $idj;
}


function convertirMilitar($Hora)
{
	$PMAM = explode(" ", $Hora);
	$horaM = explode(":", $PMAM[0]);
	if (strtoupper($PMAM[1]) == 'PM') :
		if (intval($horaM[0]) != 12) :
			$horaM[0] = intval($horaM[0]) + 12;
		endif;
	endif;
	return implode(':', $horaM);;
}


function OperaciondeHora($minutos, $hora, $fecha, $fm)/*"h:i:s A"*/
{
	echo $fecha . '*';
	$horaM   = explode(":", convertirMilitar($hora));

	$fechaMK = explode("/", $fecha);
	$fechaMK2 =  mktime($horaM[0], $horaM[1], $horaM[2], $fechaMK[1], $fechaMK[0], $fechaMK[2]);
	$x = date("H i s m d Y", $fechaMK2);
	$fecha = explode(" ", $x);
	$fecha[1] = $fecha[1] + $minutos;
	$fecha2 = date($fm, mktime($fecha[0], $fecha[1], $fecha[2], $fecha[3], $fecha[4], $fecha[5]));
	return $fecha2;
}

function anexarequipo($idj, $a, $grupo, $fecha, $operacionHora)
{
	if (count($a[0]) != 0) :
		$result = mysqli_query($GLOBALS['link'], "Select * from _jornadabb where IDJ=" . $idj . " and Grupo=" . $grupo);
		if (mysqli_num_rows($result) == 0) :
			$result = mysqli_query($GLOBALS['link'], "INSERT INTO _jornadabb (IDJ,LogroSN,LogroAB,Fecha,Partidos,Grupo) VALUES (" . $idj . ",0,0,'" . $fecha . "'," . (count($a) - 1) . "," . $grupo . ")");
		else :
			$result = mysqli_query($GLOBALS['link'], "Update _jornadabb set Partidos=" . (count($a) - 1) . " where  IDJ=" . $idj . " and Grupo=" . $grupo);
		endif;
		$resultp = mysqli_query($GLOBALS['link'], "SELECT * FROM _partidosbb where  IDJ=" . $idj . " and Grupo=" . $grupo . " Order by IDP ");

		if (mysqli_num_rows($resultp) != 0) :
			$rowp = mysqli_fetch_array($resultp);
			$ini_p =  $rowp['IDP'];
		else :
			$resultp = mysqli_query($GLOBALS['link'], "SELECT * FROM _partidosbb Order by IDP Desc");
			if (mysqli_num_rows($resultp) == 0) :
				$ini_p = 1;
			else :
				$rowp = mysqli_fetch_array($resultp);
				$ini_p =  $rowp['IDP'] + 1;
			endif;
		endif;
		$igual = 0;
		$contar = count($a) - 1;
		$i = 1;
		for ($j = 1; $j <= $contar; $j++) {
			$np[$i] = $ini_p;
			$eq11[$i] = buscarcodigo($a[$j][1], $grupo);
			if ($igual != $eq11[$i]) :
				$igual = $eq11[$i];
				$eq21[$i] = buscarcodigo($a[$j][2], $grupo);
				$hrx1[$i] = OperaciondeHora($operacionHora, $a[$j][3], $fecha, 'H:i');
				$picher = explode('(', $a[$j][4]);
				$picher1 = explode('(', $a[$j][5]);

				//$efec=explode('-',$picher[1]);$efec1=explode('-',$picher1[1]);

				$efec = str_replace(')', ' ', $picher[1]);
				$efec1 = str_replace(')', ' ', $picher1[1]);

				$pide11[$i] = $picher[0];
				$pide21[$i] = $picher1[0];
				$JGP11[$i] = $efec;
				$JGP21[$i] = $efec1;
				$efec11[$i] = '';
				$efec21[$i] = '';
				$ini_p++;
				$i++;
			endif;
		}


		for ($j = 1; $j <= (count($np)); $j++) {

			$idp = $j + 1;

			$eq1 = $eq11[$j];
			$eq2 = $eq21[$j];

			$pep1 = $pide11[$j];
			$pep2 = $pide21[$j];

			$egp1 = $JGP11[$j];
			$egp2 = $JGP21[$j];

			$ee1 = $efec11[$j];
			$ee2 = $efec21[$j];

			$hrx = $hrx1[$j];

			$result2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _partidosbb where IDP=" . $np[$j] . " and IDJ=" . $idj . " and Grupo=" . $grupo);

			if (mysqli_num_rows($result2) == 0) :

				$result2 = mysqli_query($GLOBALS['link'], "Insert _partidosbb values (" . $np[$j] . "," . $eq1 . "," . $eq2 . "," . $idj . ",'" . $hrx . "','" . $pep1 . "','" . $pep2 . "','" . $egp1 . "','" . $egp2 . "','" . $ee1 . "','" . $ee2 . "'," . $grupo . ")");
			else :
				$result2 = mysqli_query($GLOBALS['link'], "Update _partidosbb  Set  IDE1=" . $eq1 . ",IDE2=" . $eq2 . ",Hora='" . $hrx . "',PIDE1='" . $pep1 . "',PIDE2='" . $pep2 . "',JGP1='" . $egp1 . "',JGP2='" . $egp2 . "',EFEC1='" . $ee1 . "',EFEC2='" . $ee2 . "' where IDj=" . $idj . " and IDP=" . $np[$j] . " and Grupo=" . $grupo);
			endif;
		}

		$result = mysqli_query($GLOBALS['link'], "Update _jornadabb set Partidos=" . count($np) . " where  IDJ=" . $idj . " and Grupo=" . $grupo);

	endif;
}

function buscarcodigo($nombre, $grupo)
{
	$equipo = mysqli_query($GLOBALS['link'], "SELECT * FROM _equiposbb where UCASE(Descripcion)='" . strtoupper($nombre) . "' and ( _equiposbb.Grupo=" . $grupo . " or _equiposbb.Grupo1=" . $grupo . " or _equiposbb.Grupo2=" . $grupo . " )");

	$rowequi = mysqli_fetch_array($equipo);
	return ($rowequi['IDE']);
}
function estoesfecha($datos)
{
	global $idioma;
	$fechaE = explode(' ', trim($datos));
	//print_r( $fechaE);
	if (count($fechaE) == 6) :
		$mes = 0;
		$idioma = 1;
		switch (strtoupper($fechaE[2])) {
			case 'JAN':
				$mes = '1';
				break;
			case 'FEB':
				$mes = '2';
				break;
			case 'MAR':
				$mes = '3';
				break;
			case 'APR':
				$mes = '4';
				break;
			case 'MAY':
				$mes = '5';
				break;
			case 'JUNE':
				$mes = '6';
				break;
			case 'JULY':
				$mes = '7';
				break;
			case 'AUG':
				$mes = '8';
				break;
			case 'SEP':
				$mes = '9';
				break;
			case 'OCT':
				$mes = '10';
				break;
			case 'NOV':
				$mes = '11';
				break;
			case 'DEC':
				$mes = '12';
				break;
		}
		if ($mes != 0) :
			return true;
		else :
			return false;
		endif;
	endif;
	if (count($fechaE) == 7) :
		$idioma = 2;

		switch (strtoupper($fechaE[4])) {
			case 'ENE':
				$mes = '1';
				break;
			case 'FEB':
				$mes = '2';
				break;
			case 'MAR':
				$mes = '3';
				break;
			case 'ABR':
				$mes = '4';
				break;
			case 'MAY':
				$mes = '5';
				break;
			case 'JUN':
				$mes = '6';
				break;
			case 'JUL':
				$mes = '7';
				break;
			case 'AGO':
				$mes = '8';
				break;
			case 'SEP':
				$mes = '9';
				break;
			case 'OCT':
				$mes = '10';
				break;
			case 'NOV':
				$mes = '11';
				break;
			case 'DIC':
				$mes = '12';
				break;
		}

		if ($mes != 0) :
			return true;
		else :
			return false;
		endif;
	endif;

	return false;
}
function fecharea2l($lectura)
{
	$mes = 0;
	$fechaE = explode(' ', $lectura);
	echo ($lectura);
	switch (strtoupper($fechaE[2])) {
		case 'JAN':
			$mes = '1';
			break;
		case 'FEB':
			$mes = '2';
			break;
		case 'MAR':
			$mes = '3';
			break;
		case 'APR':
			$mes = '4';
			break;
		case 'MAY':
			$mes = '5';
			break;
		case 'JUNE':
			$mes = '6';
			break;
		case 'JULY':
			$mes = '7';
			break;
		case 'AUG':
			$mes = '8';
			break;
		case 'SEP':
			$mes = '9';
			break;
		case 'OCT':
			$mes = '10';
			break;
		case 'NOV':
			$mes = '11';
			break;
		case 'DEC':
			$mes = '12';
			break;
	}

	if ($mes == 0) :
		switch (strtoupper($fechaE[4])) {
			case 'ENE':
				$mes = '1';
				break;
			case 'FEB':
				$mes = '2';
				break;
			case 'MAR':
				$mes = '3';
				break;
			case 'ABR':
				$mes = '4';
				break;
			case 'MAY':
				$mes = '5';
				break;
			case 'JUN':
				$mes = '6';
				break;
			case 'JUL':
				$mes = '7';
				break;
			case 'AGO':
				$mes = '8';
				break;
			case 'SEP':
				$mes = '9';
				break;
			case 'OCT':
				$mes = '10';
				break;
			case 'NOV':
				$mes = '11';
				break;
			case 'DIC':
				$mes = '12';
				break;
		}
		if (intval($fechaE[2]) <= 9) : $fechaE[2] = '0' . $fechaE[2];
		endif;

		return ($fechaE[2] . '/' . $mes . '/' . $fechaE[6]);
	else :
		if (intval($fechaE[3]) <= 9) : $fechaE[3] = '0' . $fechaE[3];
		endif;
		return ($fechaE[3] . '/' . $mes . '/' . $fechaE[5]);
	endif;
}
