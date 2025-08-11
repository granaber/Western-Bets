<?php

require('prc_php.php');
require('fpdf.php');

class PDF extends FPDF
{

	function Header()
	{
		global $fecha_d;
		global $descripcion;
		$this->SetFont('Arial', 'I', 8);
		$this->text(10, 7, '..::Parlay En Linea::. Resultado de: ' . $descripcion . '  Fecha:' . Fechareal(-26, "d-m-y"));
		//$this->Image('logo_pb.png',10,8,33);
		$this->SetFont('Arial', 'B', 7);
		$this->Ln();
	}

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

	function Header2()
	{
		global $fecha_d;
		global $descripcion;
		$this->SetFont('Arial', 'I', 8);

		$this->Cell(10, 7, '..::Parlay En Linea::.  Resultado de: ' . $descripcion . '  Fecha:' . Fechareal(-26, "d-m-y"));
		//$this->Image('logo_pb.png',10,8,33);
		$this->SetFont('Arial', 'B', 7);
		$this->Ln();
	}
}


$pdf = new PDF();
$pdf->SetAutoPageBreak(true);
$GLOBALS['link'] = Connection::getInstance();
$idj = $_REQUEST['idj'];
$usu = $_REQUEST['usu'];
if ($usu == -2) : $acceso = true;
else : $acceso = false;
endif;
$idg = explode(',', $_REQUEST['idg']);
$inicioenca = true;
for ($tg = 0; $tg <= count($idg) - 1; $tg++) {
	$result2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _gruposdd where grupo=" . $idg[$tg]);
	$row = mysqli_fetch_array($result2);
	$descripcion = $row['Descripcion'];

	$header = array();
	$w = array();
	$sw1 = array();


	$header[0] = 'Hora';
	$w[0] = 15;
	$w1[0] = 'L';
	$header[1] = 'Equipo';
	$w[1] = 30;
	$w1[1] = 'L';
	$i = 2;

	$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _cngescrute order by posicion");
	while ($Row = mysqli_fetch_array($resultj)) {
		$IDDD = explode('|', $Row['IDDD_AESC']);
		for ($l = 0; $l <= count($IDDD) - 1; $l++) {
			$resultj2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbjuegodd where grupo=" . $idg[$tg] . " and IDDD=" . $IDDD[$l]);
			if (mysqli_num_rows($resultj2) != 0) :
				$header[$i] = $Row['Descripcion'];
				$w[$i] = 24;
				$w1[$i] = 'L';
				$i++;
				break;
			endif;
		}
	}

	$resultp = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where IDJ=" . $idj . " and grupo=" . $idg[$tg]);
	$row = mysqli_fetch_array($resultp);
	$fecha_d = $row['Fecha'];



	$inicio = true;


	$result_lo = mysqli_query($GLOBALS['link'], "SELECT _partidosbb.* FROM _partidosbb,_equiposbb  where _partidosbb.IDE1=_equiposbb.IDE and  _partidosbb.IDJ=" . $idj . " and _partidosbb.grupo=" . $idg[$tg] . " and  ( _equiposbb.Grupo=" . $idg[$tg] . " or _equiposbb.Grupo1=" . $idg[$tg] . " or _equiposbb.Grupo2=" . $idg[$tg] . ")");
	if ($inicioenca) :
		$pdf->AddPage();
		$inicioenca = false;
	else :
		if (mysqli_num_rows($result_lo) != 0) : 		$pdf->Header2();
		endif;
	endif;
	$t = 1;
	$le = 1;
	while ($row3 = mysqli_fetch_array($result_lo)) {
		if ($acceso) :
			$entrar = true;
		else :
			$resulpubli = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbpubliresultados where IDJ=" . $idj . " and Grupo=" . $idg[$tg]);
			$entrar = mysqli_num_rows($resulpubli) != 0;
		endif;
		if ($entrar) :
			if ($acceso) :
				$entrar2 = true;
			else :
				$rowPublic = mysqli_fetch_array($resulpubli);
				$entrar2 = $rowPublic['Publicar'] == 1;
			endif;
			if ($entrar2) :
				if ($inicio == true) :
					$pdf->Ln(2);
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
				$sg1 = $row3['CodEq1'] . '-' . substr($row2["Descripcion"], 0, 10);
				$dep1 = $row2["Descripcion"];
				$result3 = mysqli_query($GLOBALS['link'], "Select * From _equiposbb Where IDE=" . $eq2);
				$row = mysqli_fetch_array($result3);
				$sg2 = $row3['CodEq2'] . '-' . substr($row["Descripcion"], 0, 10);
				$dep2 = $row["Descripcion"];
				$sg = array();
				$pch = array();
				$gp = array();
				$efec = array();
				if ($row3['PIDE1'] == 'null') $pch[0] = $dep1;
				else $pch[0] = $row3['PIDE1'];
				if ($row3['PIDE2'] == 'null') $pch[1] = $dep2;
				else $pch[1] = $row3['PIDE2'];

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

					$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbescrute where IDJ=" . $idj . " and Grupo=" . $idg[$tg] . " and IDP=" . $row3['IDP']);
					if (mysqli_num_rows($resultj) != 0) :
						$row = mysqli_fetch_array($resultj);
						$escrute = $row['Escrute'];
						$valores = explode('|', $escrute);
						/* 1|!-!-|2|!-!-|3|!-!-|*/
						if ($le == 1) :
							$le = 0;
						else :
							$le = 1;
						endif;

						for ($l = 1; $l <= count($valores) - 1; $l += 2) {
							$val1 = explode('-', $valores[$l]);
							if ($val1[$le] != '!') :
								$resultj3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _cngescrute where  IDCNGE=" . $valores[$l - 1]);
								$rowj3 = mysqli_fetch_array($resultj3);

								if ($rowj3['Formato'] == 2) :
									if ($le == 0 and $val1[$le] == 1) :
										$aa[$y] = 'SI';
									else :
										if ($le == 1 and $val1[$le] == 1) :
											$aa[$y] = 'NO';
										else :
											$aa[$y] = '-';
										endif;
									endif;
								else :
									$aa[$y] = $val1[$le];
								endif;
							else :
								$aa[$y] = 'SUSPENDIDO!';
							endif;
							$y++;
						}


					endif;
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
			endif;
		endif;

		$t++;
	}
}
$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 12);
/* $pdf->Cell(1,1,'*Nota: Estos logros pueden ser modificados sin previo aviso..! ',1,0,"L"); */

$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(1, 1, Fechareal(-26, "d-m-y") . " " . Horareal(-26, "h:i:s A"), 1, 0, "L");
$pdf->Output();
