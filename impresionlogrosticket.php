<?php
date_default_timezone_set('America/Caracas');

require('prc_php.php');



echo '  <input name="" type="button" value="Imprimir" onclick="print();"/><input name="" type="button" value="Cerrar" onclick="window.close();"/><br><br>';


$GLOBALS['link'] = Connection::getInstance();


$idj = $_REQUEST['idj'];
$idg = explode(',', $_REQUEST['idg']);
$usu = $_REQUEST['usu'];
$IDB = $_REQUEST['IDB'];

for ($tg = 0; $tg <= count($idg) - 1; $tg++) {
	$acceso = false;
	if ($usu == -2) : $acceso = true;
	else :
		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbpublicaciones where IDJ=" . $idj . " and Grupo=" . $idg[$tg] . " and IDB=$IDB");
		if (mysqli_num_rows($result) != 0) :
			$row3 = mysqli_fetch_array($result);
			if ($row3['Publicar'] == 1) : 	$acceso = true;
			endif;
		endif;
	endif;

	if ($acceso) :
		$result2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _gruposdd where grupo=" . $idg[$tg]);
		$row = mysqli_fetch_array($result2);
		$descripcion = $row['Descripcion'];

		$resultp = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where IDJ=" . $idj . " and grupo=" . $idg[$tg] . " and IDB=$IDB");
		$row = mysqli_fetch_array($resultp);
		$fecha_d = $row['Fecha'];

		$i = 2;
		echo '..::Parlay En Linea::. ' . $descripcion . '  Fecha:' . $fecha_d . '<br>';
		echo 'Impreso:' . Fechareal($GLOBALS['minutosh'], "d-m-y") . " " . Horareal($GLOBALS['minutosh'], "h:i:s A") . '<br>';

		echo '<table border="1" cellpadding="0" cellspacing="0">';
		echo '<tr>';
		echo '<td>Hora</td>';
		echo '<td>Equipo</td>';
		$result2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbjuegodd where grupo=" . $idg[$tg] . " Order by Formato");
		while ($row = mysqli_fetch_array($result2)) {

			if ($row['ImpreTK'] == 0) :
				$newstr = str_replace(" ", ".", $row['Descripcion']);
				echo '<td>' . trim($newstr, '.') . '</td>';
				$i++;
			endif;
		}
		echo '</tr>';


		$np = $row['Partidos'];
		$inicio = true;

		if ($inicioenca) :
			$inicioenca = false;
		endif;
		$result_lo = mysqli_query($GLOBALS['link'], "SELECT _partidosbb.* FROM _partidosbb,_equiposbb  where _partidosbb.IDE1=_equiposbb.IDE and  _partidosbb.IDJ=" . $idj . " and _partidosbb.grupo=" . $idg[$tg] . " and  ( _equiposbb.Grupo=" . $idg[$tg] . " or _equiposbb.Grupo1=" . $idg[$tg] . " or _equiposbb.Grupo2=" . $idg[$tg] . ") order by _partidosbb.IDP");

		$t = 1;


		while ($row3 = mysqli_fetch_array($result_lo)) {


			$eq1 = $row3["IDE1"];
			$eq2 = $row3["IDE2"];
			$result2 = mysqli_query($GLOBALS['link'], "Select * From _equiposbb Where IDE=" . $eq1);
			$row2 = mysqli_fetch_array($result2);
			$sg1 = $row2["Descripcion"];
			$result3 = mysqli_query($GLOBALS['link'], "Select * From _equiposbb Where IDE=" . $eq2);
			$row = mysqli_fetch_array($result3);
			$sg2 = $row["Descripcion"];
			$sg = array();
			$pch = array();
			$gp = array();
			$efec = array();
			$pch[0] = $row3['PIDE1'];
			$pch[1] = $row3['PIDE2'];
			$gp[0] = $row3['JGP1'];
			$gp[1] = $row3['JGP2'];
			$efec[0] = $row3['EFEC1'];
			$efec[1] = $row3['EFEC2'];
			$sg[0] = $sg1;
			$sg[1] = $sg2;

			for ($j = 0; $j <= 1; $j++) {
				$aa = array();
				if ($j == 0) :
					$fho = explode(':', $row3['Hora']);
					if ($fho[0] < 12) :
						$ann = 'a';
					endif;
					if ($fho[0] == 12) :
						$ann = 'm';
					endif;
					if ($fho[0] > 12) :
						$ann = 'p';
						$horr = $fho[0] - 12;
					else :
						$horr = $fho[0];
					endif;
					$aa[0] = $horr . ':' . $fho[1] . $ann;
				else :
					$aa[0] = '';

				endif;
				if (strlen($sg[$j]) <= 5) :
					$aa[1] = $sg[$j];
				else :
					$aa[1] = substr($sg[$j], 0, 5);
				endif;
				$y = 2;
				$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _configuracionjugadabb,_tbjuegodd where _configuracionjugadabb.IDDD=_tbjuegodd.IDDD and _configuracionjugadabb.IDP=" . $t . " and  _configuracionjugadabb.IDJ=" . $idj . " and _configuracionjugadabb.grupo=" . $idg[$tg] . " and _tbjuegodd.grupo=" . $idg[$tg] . " and _configuracionjugadabb.IDB=$IDB Order by _tbjuegodd.Formato,_configuracionjugadabb.IDDD");

				//if ($columnasView[]==0):
				while ($row = mysqli_fetch_array($result)) {
					if ($row['ImpreTK'] == 0) :
						$llg = explode('|', $row['Valores']);
						$ta1 = '';
						if ($row['textorfila'] != '') :
							$ta = explode('|', $row['textorfila']);
							$ta1 = $ta[$j];

							if (strlen($ta1) > 1) : $ta1 = $ta1[0];
							endif;
						endif;
						if (count($llg) == 3) :
							if ($llg[$j] != '' && evaluarLogro($llg[$j])) :
								$aa[$y] = $ta1 . ' ' . convertirvtk($llg[$j], false, true);
							else :
								$aa[$y] = ' ';
							endif;
						else :
							$key = strpos($row['Columnas'], 'Ax');
							if ($key === false) :
								$ilos = true;
							else :
								$ilos = false;
							endif;
							if ($j == 0) :
								if ($llg[$j] != '' && evaluarLogro($llg[$j])) :
									$aa[$y] = $ta1 . ' ' . convertirvtk($llg[$j + 1], true, $ilos) . '    ' . convertirvtk($llg[$j], false, true);
								else :
									$aa[$y] = ' ';
								endif;
							endif;
							if ($j == 1) :
								if ($llg[$j + 1] != ''  && evaluarLogro($llg[$j + 1])) :
									$aa[$y] = $ta1 . ' ' . convertirvtk($llg[$j + 2], true, $ilos) . '    ' . convertirvtk($llg[$j + 1], false, true);
								else :
									$aa[$y] = ' ';
								endif;
							endif;
						endif;
						$y++;
					endif;
				}
				registro($aa);


				$aa2 = array();
				$aa2 = array_fill(0, $y, ' ');
				/*  $aa2[0]='';
   $aa2[1]=$pch[$j].' '.$gp[$j].' '.$efec[$j];
  

   $pdf->SetFont('Arial','I',5);  
   $pdf->registro2($aa2,$w,$w1,$j);   
   $pdf->ln();*/
				//endif;
			}


			$t++;
		}
		echo '</table><br /><br>';
	endif;
}




echo '*Nota: Estos logros pueden ser modificados sin previo aviso..! ';
echo Fechareal($GLOBALS['minutosh'], "d-m-y") . " " . Horareal($GLOBALS['minutosh'], "h:i:s A");


function registro($varlo)
{
	// 
	echo '<tr>';
	for ($i = 0; $i < count($varlo); $i++)
		echo '<td>' . $varlo[$i] . '</td>';
	//
	echo '</tr>';
}
