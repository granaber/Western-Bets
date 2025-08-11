<?php
date_default_timezone_set('America/Caracas');

require('prc_php.php');
require('fpdf.php');


class PDF extends FPDF
{

	function Header()
	{
		global $fecha_d;
		global $descripcion;

		$this->SetFont('Arial', 'I', 8);
		$this->Cell(10, 7, '..::Parlay En Linea::.  ' . $descripcion . '  Fecha:' . $fecha_d . ' Impreso:' . Fechareal($GLOBALS['minutosh'], "d-m-y") . " " . Horareal($GLOBALS['minutosh'], "h:i:s A"));
		//$this->Image('logo_pb.png',10,8,33);
		$this->SetFont('Arial', 'B', 7);
		$this->Ln();
	}

	/* function AcceptPageBreak()
{
		
    $this->Ln(5);
}
 */
	function BasicTable($header, $w)
	{
		for ($i = 0; $i < count($header); $i++)
			$this->Cell($w[$i], 3, $header[$i], 1, 0, 'C');



		$this->Ln();
	}

	function registro($varlo, $w, $w1, $t)
	{
		// 
		$cuadro = 'LR';
		if ($t == 0) :
			$cuadro = 'LRT';
		endif;

		for ($i = 0; $i < count($varlo); $i++) {

			$this->Cell($w[$i], 4, $varlo[$i], $cuadro, 0, $w1[$i]);
		}
		//

	}
	function registro2($varlo, $w, $w1, $t)
	{
		// 
		$cuadro = 'LR';

		if ($t == 1) :
			$cuadro = 'LRB';
		endif;
		for ($i = 0; $i < count($varlo); $i++) {

			$this->Cell($w[$i], 4, $varlo[$i], $cuadro, 0, $w1[$i]);
		}
		//	
	}
}



$GLOBALS['link'] = Connection::getInstance();


$idj = $_REQUEST['idj'];
$idg = explode(',', $_REQUEST['idg']);
$usu = $_REQUEST['usu'];
$IDB = $_REQUEST['IDB'];

$pdf = new PDF();

$inicioenca = true;
$pdf->SetAutoPageBreak(true);

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


		$header = array();
		$w = array();
		$sw1 = array();


		$header[0] = 'Hora';
		$w[0] = 12;
		$w1[0] = 'L';
		$header[1] = 'Equipo';
		$w[1] = 30;
		$w1[1] = 'L';
		$i = 2;


		$result2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbjuegodd where grupo=" . $idg[$tg] . " Order by IDDD,Formato");
		while ($row = mysqli_fetch_array($result2)) {
			$header[$i] = $row['reporte'];
			$w[$i] = 30;
			$w1[$i] = 'L';
			$i++;
		}

		$resultp = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where IDJ=" . $idj . " and grupo=" . $idg[$tg] . " and IDB=$IDB");
		$row = mysqli_fetch_array($resultp);
		$fecha_d = $row['Fecha'];

		$np = $row['Partidos'];
		$inicio = true;

		if ($inicioenca) :
			$pdf->AddPage();
			$inicioenca = false;
		else :
			if (mysqli_num_rows($resultp) != 0) : 	if ($pdf->Gety() <= 240) :	$pdf->Header();
				endif;
			endif;
		endif;
		$result_lo = mysqli_query($GLOBALS['link'], "SELECT _partidosbb.* FROM _partidosbb,_equiposbb  where _partidosbb.IDE1=_equiposbb.IDE and  _partidosbb.IDJ=" . $idj . " and _partidosbb.grupo=" . $idg[$tg] . " and  ( _equiposbb.Grupo=" . $idg[$tg] . " or _equiposbb.Grupo1=" . $idg[$tg] . " or _equiposbb.Grupo2=" . $idg[$tg] . ") order by _partidosbb.IDP ");
		/*  echo    "SELECT _partidosbb.* FROM _partidosbb,_equiposbb  where _partidosbb.IDE1=_equiposbb.IDE and  _partidosbb.IDJ=".$idj." and _partidosbb.grupo=".$idg." and  ( _equiposbb.Grupo=".$idg." or _equiposbb.Grupo1=".$idg." or _equiposbb.Grupo2=".$idg." )";  */
		$t = 1;
		while ($row3 = mysqli_fetch_array($result_lo)) {

			if ($inicio == true) :

				$_xp = $pdf->Gety();
				$pdf->Sety($_xp);
				$pdf->Setx(10);
				$pdf->SetFont('Arial', 'B', 4);
				$pdf->BasicTable($header, $w);
				$pdf->SetFont('Arial', 'B', 9);
				$inicio = false;
			endif;
			$eq1 = $row3["IDE1"];
			$eq2 = $row3["IDE2"];
			$result2 = mysqli_query($GLOBALS['link'], "Select * From _equiposbb Where IDE=" . $eq1);
			$row2 = mysqli_fetch_array($result2);
			$sg1 = $row3['CodEq1'] . '-' . $row2["Descripcion"];
			$result3 = mysqli_query($GLOBALS['link'], "Select * From _equiposbb Where IDE=" . $eq2);
			$row = mysqli_fetch_array($result3);
			$sg2 = $row3['CodEq2'] . '-' . $row["Descripcion"];
			$sg = array();
			$pch = array();
			$gp = array();
			$efec = array();
			$codi[0] = $row3['CodEq1'];
			$codi[1] = $row3['CodEq2'];
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
				$aa[1] = $sg[$j];

				$y = 2;
				$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _configuracionjugadabb,_tbjuegodd where _configuracionjugadabb.IDDD=_tbjuegodd.IDDD and _configuracionjugadabb.IDP=" . $t . " and  _configuracionjugadabb.IDJ=" . $idj . " and _configuracionjugadabb.grupo=" . $idg[$tg] . " and _tbjuegodd.grupo=" . $idg[$tg] . " and _configuracionjugadabb.IDB=$IDB Order by _tbjuegodd.Formato,_configuracionjugadabb.IDDD");

				while ($row = mysqli_fetch_array($result)) {

					$llg = explode('|', $row['Valores']);
					$ta1 = '';
					if ($row['textorfila'] != '') :
						$ta = explode('|', $row['textorfila']);
						$ta1 = $ta[$j];
					endif;

					if (count($llg) == 3) :
						if ($llg[$j] != ''  && evaluarLogro($llg[$j])) :
							$aa[$y] = $ta1 . ' ' . convertir($llg[$j], false, true);
						else :
							if ($llg[$j] == '') :
								$aa[$y] = ' ';
							else :
								$aa[$y] = 'ERR';
							endif;
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
								$aa[$y] = $ta1 . convertir($llg[$j + 1], true, $ilos) . ' ' . convertir($llg[$j], false, true);
							else :
								if ($llg[$j] == '') :
									$aa[$y] = ' ';
								else :
									$aa[$y] = 'ERR';
								endif;
							endif;
						endif;


						if ($j == 1) :
							if ($llg[$j + 1] != '' && evaluarLogro($llg[$j + 1])) :
								$aa[$y] = $ta1 . convertir($llg[$j + 2], true, $ilos) . ' ' . convertir($llg[$j + 1], false, true);
							else :
								if ($llg[$j + 1] == '') :
									$aa[$y] = ' ';
								else :
									$aa[$y] = 'ERR';
								endif;
							endif;
						endif;

					endif;

					$y++;
				}

				$pdf->SetFont('Arial', 'B', 9);
				$pdf->registro($aa, $w, $w1, $j);
				$pdf->ln(3);

				$aa2 = array();
				$aa2 = array_fill(0, $y, ' ');
				$aa2[0] = '';
				$aa2[1] = $pch[$j] . ' ' . $gp[$j] . ' ' . $efec[$j];


				$pdf->SetFont('Arial', 'I', 5);
				$pdf->registro2($aa2, $w, $w1, $j);
				$pdf->ln();
			}


			$t++;
		}
	endif;
	$pdf->ln(5);
}

$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(1, 1, '*Nota: Estos logros pueden ser modificados sin previo aviso..! ', 1, 0, "L");

$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$tmt = strtotime("now") - 30;
$pdf->Cell(1, 1, Fechareal($GLOBALS['minutosh'], "d-m-y") . " " . Horareal($GLOBALS['minutosh'], "h:i:s A"), 1, 0, "L");
$pdf->Output();
