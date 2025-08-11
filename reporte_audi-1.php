<?

require('prc_php.php');

$GLOBALS['link'] = Connection::getInstance();

require('fpdf.php');



class PDF extends FPDF

{



	function Header()

	{

		global $xpp;

		global $tt;

		global $ttex;

		global $ttex2;

		global $header;

		global $w;

		global $w1;



		$this->Sety(0);

		$this->Setx(0);

		$this->SetFont('Arial', 'I', 7);

		$this->text(10, 7, 'Reporte de Jugada Detallada');

		$this->text(10, 10, $ttex);

		$this->text(10, 20, $ttex2);

		$this->SetFont('Arial', 'B', 7);

		//***********************************

		$_xp = $this->Gety();

		$_xp = $_xp + 10;

		$this->Sety($_xp);

		$this->Setx($xpp);

		$this->Cell(30, 3, 'Fecha:' . date("d/n/Y"));

		$this->Sety($_xp + 3);

		$this->Setx($xpp);

		$va = $this->PageNo();

		$this->Cell(30, 3, 'Pagina No:' . $va);

		$this->Sety($_xp + 6);

		$this->Setx($xpp);

		$this->Cell(30, 3, 'Hora:' . Horareal($minutosa, "h:i:s A"));

		$this->rect(($xpp) - 1, 8, 39, 12, 'D');

		//**********************************

		$this->Ln();

		$this->Ln();

		$this->Ln();

		$this->SetFont('Arial', 'B', 7);

		$this->Setx(1);

		for ($i = 0; $i < count($header); $i++)

			$this->Cell($w[$i], 3, $header[$i], 1, 0, $w1[$i]);

		$this->Ln();
	}







	function registro($varlo, $w, $w1)

	{

		$this->SetFont('Arial', '', 7);

		$this->Setx(1);

		for ($i = 0; $i < count($varlo); $i++) {

			$this->Cell($w[$i], 4, $varlo[$i], 1, 0, $w1[$i]);
		}

		$this->Ln();
	}
}



$IDJ = $_REQUEST["IDJ"];

$gp = $_REQUEST["IDG"];

$add1 = '';

if ($gp != 0) :

	$add1 = " and IDC in (Select IDC From _tconsecionario where IDG=" . $gp . ")";

	$ttex2 = 'Grupo: ' . $gp;

endif;









$arreglolote = array();

$resultp = mysqli_query($GLOBALS['link'], "SELECT * FROM _partidosbb where IDJ=" . $IDJ . " Order by Hora,IDP");

$primerahora = 0;
$i = 0;

while ($rowp = mysqli_fetch_array($resultp)) {

	if (strcmp($primerahora, $rowp['Hora']) != 0) :

		$primerahora = $rowp['Hora'];

		$i++;

	endif;

	$result1 = mysqli_query($GLOBALS['link'], "Select * From _equiposbb Where IDE=" . $rowp['IDE1']);
	$row1 = mysqli_fetch_array($result1);
	$nequipo1 = $row1['Descripcion'];

	$result1 = mysqli_query($GLOBALS['link'], "Select * From _equiposbb Where IDE=" . $rowp['IDE2']);
	$row1 = mysqli_fetch_array($result1);
	$nequipo2 = $row1['Descripcion'];

	$arreglolote[] = $i . '|' . $rowp['IDP'] . '|' . $nequipo1 . '|' . $nequipo2 . '|' . $rowp['Hora'];
}



$listalote = explode(',', json_decode($_REQUEST['listalote'], true));



/********************************************************************************/

/*                 		  Encabezado del Reporte                               */

$xpp = 170;

$header = array();

$w = array();
$w1 = array();

$cuenta = 1;

$header[0] = 'ln';
$w[0] = 5;
$w1[0] = 'R';

$header[1] = 'Serial';
$w[1] = 15;
$w1[1] = 'L';

$header[2] = 'Hora';
$w[2] = 20;
$w1[2] = 'L';

$header[3] = '1';
$w[3] = 25;
$w1[3] = 'L';

$header[4] = '2';
$w[4] = 25;
$w1[4] = 'L';

$header[5] = '3';
$w[5] = 25;
$w1[5] = 'L';

$header[6] = '4';
$w[6] = 25;
$w1[6] = 'L';

$header[7] = '5';
$w[7] = 25;
$w1[7] = 'L';

$header[8] = 'Apuesta';
$w[8] = 15;
$w1[8] = 'R';

$header[9] = 'Paga';
$w[9] = 15;
$w1[9] = 'R';
$header[10] = 'L';
$w[10] = 10;
$w1[10] = 'R';


/********************************************************************************/



$pdf = new PDF('P', 'mm', 'letter');

$pdf->AddPage();

$pdf->SetAutoPageBreak(true);

$lista = array();

//print_r($listalote);

for ($t0 = 0; $t0 <= count($listalote) - 1; $t0++) {

	$la_lista_de_partidos = lotepartido($arreglolote, $listalote[$t0]);

	//print_r ($la_lista_de_partidos);
	$listadepartidoSQL = "";
	for ($t1 = 0; $t1 <= count($la_lista_de_partidos) - 1; $t1++) {
		$listadepartidoSQL .= " IDP=" . $la_lista_de_partidos[$t1];
		if ($t1 < (count($la_lista_de_partidos) - 1)) :
			$listadepartidoSQL .= " or ";
		endif;
	}
	//echo ("SELECT * FROM _partidosbb where IDJ=".$IDJ." and (".$listadepartidoSQL.") Order by Hora,IDP");


	$arregloequipos = array();
	$resultp0 = mysqli_query($GLOBALS['link'], "SELECT * FROM _partidosbb where IDJ=" . $IDJ . " and (" . $listadepartidoSQL . ") Order by Hora,IDP");

	while ($rowp = mysqli_fetch_array($resultp0)) {
		$arregloequipos[] = $rowp['IDE1'];
		$arregloequipos[] = $rowp['IDE2'];
		$horap = $rowp['Hora'];
	}

	//	echo ("SELECT * FROM _tjugadabb where IDJ=".$IDJ." and  STR_TO_DATE(hora,'%r')<=STR_TO_DATE('".convertirPMam($horap)."','%r') ".$add1." Order by STR_TO_DATE(hora,'%r')");

	$result_juga = mysqli_query($GLOBALS['link'], "SELECT * FROM _tjugadabb where IDJ=" . $IDJ . " and  STR_TO_DATE(hora,'%r')<=STR_TO_DATE('" . convertirPMam($horap) . "','%r') " . $add1 . " Order by STR_TO_DATE(hora,'%r')");
	while ($rowjuga = mysqli_fetch_array($result_juga)) {


		$result_procesado = mysqli_query($GLOBALS['link'], "SELECT * FROM _procesoauditoria where serial=" . $rowjuga['serial']);
		if (mysqli_num_rows($result_procesado) == 0) :
			/*if (diferenciadehoras('1/1/2001',convertirMilitar($rowjuga['hora']),	$rowp['Hora'])):*/
			$jud = $rowjuga['Jugada'];
			$jgdad = explode('*', $jud);

			for ($i = 0; $i <= count($jgdad) - 2; $i++) {

				$opcion = explode('|', $jgdad[$i]);

				$logro = $opcion[1];

				$opcion1 = explode('%', $opcion[0]);

				$carr = $opcion1[1];

				$opcion2 = explode('-', $opcion1[0]);

				$equi = $opcion2[0];

				$iddd = $opcion2[1];

				if (!(array_search($equi, $arregloequipos) === false)) :

					$resulisert = mysqli_query($GLOBALS['link'], "insert _procesoauditoria values (" . $rowjuga['serial'] . "," . $listalote[$t0] . ")");

					$arrk = jugadaver($rowjuga['serial'], $rowjuga['hora'], $rowjuga['Jugada'], $rowjuga['ap'], $rowjuga['acobrar'], $cuenta, $listalote[$t0], $IDJ);

					$pdf->registro($arrk, $w, $w1);
					$cuenta++;

					break;

				endif;
			}

		/* endif;*/

		else :
			$row_procesado = mysqli_fetch_array($result_procesado);
			if ($row_procesado['lote'] == $listalote[$t0]) :
				$arrk = jugadaver($rowjuga['serial'], $rowjuga['hora'], $rowjuga['Jugada'], $rowjuga['ap'], $rowjuga['acobrar'], $cuenta, $row_procesado['lote'], $IDJ);
				$pdf->registro($arrk, $w, $w1);
				$cuenta++;
			endif;

		endif;
	}
}





$pdf->SetFont('Arial', 'B', 8);

$pdf->Ln(10);

$pdf->SetFont('Arial', 'B', 4);

$pdf->Cell(1, 1, date("d-m-y") . " " . Horareal($minutosa, "h:i:s A"), 1, 0, "L");

$pdf->Output();





function lote($arreglolote, $idp)

{

	for ($i = 0; $i <= count($arreglolote) - 1; $i++) {

		$lote = explode('|', $arreglolote[$i]);



		if ($lote[1] == $idp) :

			$ellotees = $lote[0];

		endif;
	}

	return $ellotees;
}





function lotepartido($arreglolote, $loteaver)

{

	$arreglodepartidos = array();

	for ($i = 0; $i <= count($arreglolote) - 1; $i++) {

		$lotea = explode('|', $arreglolote[$i]);



		if ($lotea[0] == $loteaver) :

			$arreglodepartidos[] = $lotea[1];

		endif;
	}

	return $arreglodepartidos;
}

function jugadaver($serial, $hora, $jugada, $apuesta, $pago, $cuenta, $lote, $IDJ)
{
	$jgdad = explode('*', $jugada);
	$Lineaticket = array();
	for ($u = 0; $u <= count($jgdad) - 2; $u++) {
		$opcion = explode('|', $jgdad[$u]);
		$logro = $opcion[1];
		$opcion1 = explode('%', $opcion[0]);

		$carr = $opcion1[1];

		$opcion2 = explode('-', $opcion1[0]);

		$equi = $opcion2[0];

		$iddd = $opcion2[1];



		$result1 = mysqli_query($GLOBALS['link'], "Select * From _equiposbb Where IDE=" . $equi);
		$row1 = mysqli_fetch_array($result1);

		$result2 = mysqli_query($GLOBALS['link'], "Select * From _partidosbb Where (IDE1=" . $equi . " or IDE2=" . $equi . ") and IDJ=" . $IDJ);
		$row2 = mysqli_fetch_array($result2);

		$result3 = mysqli_query($GLOBALS['link'], "Select * From _tbjuegodd Where IDDD=" . $iddd);
		$row3 = mysqli_fetch_array($result3);

		if ($row2['IDE1'] == $equi) :

			$y = 0;

		endif;

		if ($row2['IDE2'] == $equi) :

			$y = 1;

		endif;

		$cln = explode('|', $row3['AddTicket']);

		if (count($cln) == 1) :

			$valoaad = $row3['AddTicket'];

		else :

			$valoaad = $cln[$y];

		endif;

		$Lineaticket[$u + 1] = $row1['Siglas'] . ' ' . convertirtk($carr, true) . ' ' . $valoaad; //.' '.convertirtk($logro,false)



	}

	$a = array();



	$a[0] = $cuenta;

	$a[1] = $serial;

	$a[2] = $hora;

	for ($i = 1; $i <= 5; $i++) {

		if ($i <= count($Lineaticket)) :

			$a[2 + $i] = $Lineaticket[$i];

		else :

			$a[2 + $i] = '';

		endif;
	}



	$a[8] = $apuesta;

	$a[9] = $pago;

	$a[10] = $lote;


	return $a;
}



function convertirMilitar($Hora)

{

	$PMAM = explode(" ", $Hora);

	$horaM = explode(":", $PMAM[0]);

	if (strtoupper($PMAM[1]) == 'PM') :

		$horaM[0] = intval($horaM[0]) + 12;

	endif;

	return implode(':', $horaM);;
}



function convertirPMam($Hora)

{



	$horaM = explode(":", $Hora);



	if (intval($horaM[0]) > 12) :

		$horaM[0] = intval($horaM[0]) - 12;

		$horaM[count($horaM)] = '00PM';

	else :

		if (intval($horaM[0]) == 12) :

			$horaM[count($horaM)] = '00PM';

		else :

			$horaM[count($horaM)] = '00AM';

		endif;

	endif;





	return implode(':', $horaM);;
}



function diferenciadehoras($fecha, $hora1, $hora2)

{

	$horaM = explode(":", $hora1);

	$fechaMK = explode("/", $fecha);

	if ($horaM[2] == '') : $horaM[2] = 0;
	endif;

	$fechaMK1 = mktime($horaM[0], $horaM[1], $horaM[2], $fechaMK[1], $fechaMK[0], $fechaMK[2]);



	$horaM = explode(":", $hora2);

	$fechaMK = explode("/", $fecha);

	if ($horaM[2] == '') : $horaM[2] = 0;
	endif;

	$fechaMK2 =  mktime($horaM[0], $horaM[1], $horaM[2], $fechaMK[1], $fechaMK[0], $fechaMK[2]);



	$respuesta = $fechaMK1 <= $fechaMK2;



	return $respuesta;
}
