<?php

require('fpdf.php');

class PDF extends FPDF
{

	function Header()
	{
		global $xpp;
		global $tt;
		global $ttex;
		$this->Sety(0);
		$this->Setx(0);
		$this->SetFont('Arial', 'I', 7);
		$this->text(10, 7, 'Reporte Detallado de Ventas');

		//$this->Image('logo_pb.png',10,8,33);
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
		$this->Cell(30, 3, 'Hora:' . date("g:i a"));
		$this->rect(($xpp) - 1, 8, 39, 12, 'D');
		//**********************************

		$this->SetFont('Arial', 'B', 15);
		$this->Setx(0);
		$this->Sety(5);
		$this->Cell(30, 10, $tt, 0, 0, 'L');
		$this->Ln(5);
		$this->SetFont('Arial', 'B', 10);
		$this->Setx(7);
		$this->Cell(30, 10, $ttex, 0, 0, 'L');
		$this->Ln(10);
	}

	function BasicTable($header, $w, $header2, $w2)
	{
		for ($i = 0; $i < count($header); $i++)
			$this->Cell($w[$i], 3, $header[$i], 1, 0, 'C');

		if (count($header2) != 0) :
			$_xp = $this->Gety();

			$this->Sety($_xp + 3);
			$this->Setx(33);

			for ($i = 0; $i < count($header2); $i++)
				$this->Cell($w2[$i], 3, $header2[$i], 1, 0, 'C');

		endif;

		$this->Ln();
	}

	function registro($varlo, $w, $varlo2, $w2, $w1)
	{
		// 
		global $form;
		for ($i = 0; $i < count($varlo); $i++) {

			$this->Cell($w[$i], 4, $varlo[$i], 1, 0, $w1[$i]);
		}

		if (count($w2) != 0) :
			$_xp = $this->Gety();
			$this->Sety($_xp + 4);
			$this->Setx(33);
			for ($i = 1; $i < count($varlo2); $i++) {
				$a = 'L';
				if (is_numeric($varlo2[$i])) :
					$a = 'R';
				endif;
				$this->Cell($w2[$i - 1], 4, $varlo2[$i], 1, 0, $a);
			}
		endif;
	}
}

require('prc_php.php');
$GLOBALS['link'] = Servidordual::getInstance();


$tc = $_REQUEST['tc'];
$gp = $_REQUEST['gp'];
$d1 = $_REQUEST['d1'];
$d2 = $_REQUEST['d2'];
$org = $_REQUEST['org'];
$idj = $_REQUEST['idj'];
$clsi = $_REQUEST['clsi'];

//$idcn=34;


$idcn1 = explode('||', $d1);
$idcn2 = explode('||', $d2);;

$add = '';


$add = " and idcn BETWEEN " . $idcn1[0] . " and " . $idcn2[0];
$ttex = " Desde : " . $idcn1[1] . " Hasta: " . $idcn2[1];
switch ($clsi) {
	case 1:
		if ($gp != 0) :
			$add = $add . " and _tconsecionario.IDG=" . $gp;
		endif;
		break;

	case 2:
		if ($gp != '0') :
			$add = $add . " and _tjugada.IDC='" . $gp . "'";
		endif;
		break;
}

if ($org != 0) :
	$add = $add . " and _tjugada.org='" . $org . "'";
endif;

$add = $add . " and IDjug=" . $idj;




$header2 = array();
$w2 = array();
$w1 = array();
$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tdjuegos where IDjug=" . $idj);
$row = mysqli_fetch_array($result);
$tt = $row['Descrip'];
$form = $row['Formato'];

$header[0] = 'Serial';
$w[0] = 16;
$w1[0] = 'L';
$header[1] = 'Ori';
$w[1] = 7;
$w1[1] = 'L';
if ($row['CantidadCarr'] <= 6) :
	if ($form != 4) :
		$mc = $row['CantidadCarr'];
	else :
		$mc = 1;
	endif;
else :
	$mc = $row['CantidadCarr'];

	if ($form != 4) :
		for ($ttt = 6; $ttt <= $mc - 1; $ttt++) {
			$header2[$ttt - 6] = ($ttt + 1) . ' Valida';
			$w2[$ttt - 6] = 42;
			$w1[$ttt - 6] = 'L';
		}
		$mc = 6;
	else :
		$mc = 1;
	endif;

endif;

for ($ttt = 1; $ttt <= $mc; $ttt++) {
	if ($form != 4) :
		$header[$ttt + 1] = $ttt . ' Valida';
		$w[$ttt + 1] = 42;
		$w1[$ttt + 1] = 'L';
	else :
		$header[$ttt + 1] = '(Jugada)';
		$w[$ttt + 1] = 100;
		$w1[$ttt + 1] = 'L';
		break;
	endif;
}
$ctc = $row['CantidadCarr'];
$header[$mc + 2] = 'Monto Jugada';
$w[$mc + 2] = 15;
$w1[$mc + 2] = 'R';
$header[$mc + 3] = 'Monto Pagado';
$w[$mc + 3] = 15;
$w1[$mc + 3] = 'R';
$header[$mc + 4] = 'Nom/Fax/Bol';
$w[$mc + 4] = 20;
$w1[$mc + 4] = 'R';
$header[$mc + 5] = 'Hora';
$w[$mc + 5] = 20;
$w1[$mc + 5] = 'R';

if ($row['Formato'] == 2) :
	$header[$mc + 6] = 'Tanda/Carr';
	$w[$mc + 6] = 10;
	$w1[$mc + 6] = 'L';
endif;


$result = mysqli_query($GLOBALS['link'], "SELECT _tjugada.*,_tconsecionario.IDG  FROM _tjugada,_tconsecionario  where _tjugada.IDC=_tconsecionario.IDC    and  _tconsecionario.estatus=1 and  anulado=0  " . $add . " order by _tconsecionario.IDG,IDC,serial,carr");
$primeralinea = 0;
if ($ctc >= 5) :
	$xpp = 280;
else :
	$xpp = 220;
endif;


$pdf = new PDF('L', 'mm', 'Legal');

$pdf->AddPage();
$pdf->SetAutoPageBreak(true);

$cabz = -1;
$cuento = 0;
$numx = 230;
$sumxletra = 0;
$sumxGrupo = 0;
$inicio = true;
$grupo = -1;
while ($row = mysqli_fetch_array($result)) {
	if ($inicio == true) :
		$pagina++;
		$pdf->SetFont('Arial', 'I', 7);
		$pdf->text(10, 7, 'Reporte Detallado de Ventas');
		$_xp = $pdf->Gety();
		$pdf->Sety($_xp);
		$pdf->Setx(10);
		$pdf->SetFont('Arial', 'B', 7);
		$pdf->MultiCell(50, 3, 'Grupo:' . $row['IDG']);
		$pdf->MultiCell(100, 3, 'Concesionario:' . $row['IDC']);
		$pdf->SetFont('Arial', 'B', 4);
		$pdf->BasicTable($header, $w, $header2, $w2);
		$pdf->SetFont('Arial', 'B', 8);
		$inicio = false;
	else :
		$_xp = $pdf->Gety();
		if ($_xp >= $numx) :
			$pdf->Ln(2);
			$_xp = $pdf->Gety();
			$pdf->Sety($_xp);
			$pdf->Setx(10);
			$pdf->SetFont('Arial', 'B', 7);
			$pdf->MultiCell(50, 3, 'Grupo:' . $row['IDG']);
			$pdf->MultiCell(100, 3, 'Concesionario:' . $row['IDC']);
			$pdf->SetFont('Arial', 'B', 4);
			$pdf->BasicTable($header, $w, $header2, $w2);
			$pdf->SetFont('Arial', 'B', 8);
		endif;
	endif;

	if ($cabz == -1) :
		$cabz = $row['IDC'];
		$grupo = $row['IDG'];
	endif;
	$aa2 = array();
	$aa[0] = $row['Serial'];
	switch ($row['org']) {
		case 1:
			$aa[1] = 'Tel';
			break;
		case 2:
			$aa[1] = 'Bol';
			break;
		case 3:
			$aa[1] = 'Fax';
			break;
		case 4:
			$aa[1] = 'Onl';
			break;
		default:
			$aa[1] = 'Onl';
			break;
	}
	if ($form != 4) :
		$jg = explode('|', $row['Jugada']);
	else :
		$jg = str_replace('|', '-', substr($row['Jugada'], 1));
	endif;
	if ($ctc <= 6) :
		if ($form != 4) :
			$mc = $ctc;
		else :
			$mc = 1;
		endif;
	else :
		if ($form != 4) :
			for ($uu = 1; $uu <= $ctc - 5; $uu++)
				$aa2[$uu] = ordenar($jg[$uu + 6]);
			$mc = 6;
		else :
			$mc = 1;
		endif;
	endif;

	for ($uu = 1; $uu <= $mc; $uu++) {
		if ($form != 4) :
			$aa[$uu + 1] = ordenar($jg[$uu]);
		else :
			$aa[$uu + 1] = ordenart2($jg);
		endif;
	}
	$aa[$uu + 1] = number_format($row['Valor_R'], 2, ',', '.');
	$aa[$uu + 2] = number_format($row['Valor_J'], 2, ',', '.');
	switch ($row['org']) {
		case 1:
			$aa[$uu + 3] = $row['nom'];
			break;
		case 2:
			$aa[$uu + 3] = $row['nom'];
			break;
		case 3:
			$aa[$uu + 3] = $row['nom'];
			break;
		case 4:
			$aa[$uu + 3] = 'Onl';
			break;
		default:
			$aa[$uu + 3] = 'Onl';
			break;
	}
	$aa[$uu + 4] = $row['Hora'];
	if ($form == 2) :
		$aa[$uu + 5] = $row['carr'];
	endif;

	if (strcmp($cabz, $row['IDC']) == 0) :
		$pdf->registro($aa, $w, $aa2, $w2, $w1);
		$sumxletra += $row['Valor_J'];
		$sumxGrupo += $row['Valor_J'];
		$pdf->Ln();
	else :
		$_xp = $pdf->Gety();
		$pdf->Sety($_xp + 3);
		$pdf->Setx($xpp - 20);
		$pdf->SetFont('Arial', 'B', 8);
		$pdf->MultiCell(100, 3, 'Total Ventas(' . $cabz . ') : ' . number_format($sumxletra, 2, ',', '.'));
		if ($grupo != $row['IDG']) :
			$pdf->Ln();
			$pdf->Setx($xpp - 20);
			$pdf->MultiCell(100, 3, 'Total Ventas Grupo(' . $grupo . ') : ' . number_format($sumxGrupo, 2, ',', '.'));
			$sumxGrupo = 0;
			$grupo = $row['IDG'];
		endif;
		$cabz = $row['IDC'];
		$sumxletra = 0;

		$pdf->Ln();
		$pdf->Ln();
		$_xp = $pdf->Gety();
		$pdf->Sety($_xp);
		$pdf->Setx(10);
		$pdf->SetFont('Arial', 'B', 7);
		$pdf->MultiCell(50, 3, 'Grupo:' . $row['IDG']);
		$pdf->MultiCell(100, 3, 'Concesionario:' . $row['IDC']);
		$pdf->SetFont('Arial', 'B', 4);
		$pdf->BasicTable($header, $w, $header2, $w2);
		$pdf->SetFont('Arial', 'B', 8);
		$pdf->registro($aa, $w, $aa2, $w2, $w1);
		$sumxletra += $row['Valor_J'];
		$sumxGrupo += $row['Valor_J'];
		$pdf->Ln();
	endif;
}

$_xp = $pdf->Gety();
$pdf->Sety($_xp + 3);
$pdf->Setx($xpp - 20);
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(100, 3, 'Total Ventas(' . $cabz . ') : ' . number_format($sumxletra, 2, ',', '.'));
$pdf->Ln();
$pdf->Setx($xpp - 20);
$pdf->MultiCell(100, 3, 'Total Ventas Grupo(' . $grupo . ') : ' . number_format($sumxGrupo, 2, ',', '.'));
$sumxGrupo = 0;
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 4);
$pdf->Cell(1, 1, date("d-m-y") . " " . date("g:i a"), 1, 0, "L");
$pdf->Output();

function ordenar($s)
{
	$val = explode('-', $s);
	$stf = '';
	for ($ii = 1; $ii <= 14; $ii++) {
		$en = true;
		for ($jj = 0; $jj <= count($val) - 1; $jj++) {
			if ($val[$jj] == $ii) :
				$stf = $stf . $val[$jj] . ' ';
				$en = false;
				break;
			endif;
		}
		if ($en) :
			if ($ii > 9) :
				$stf = $stf . '    ';
			else :
				$stf = $stf . '   ';
			endif;
		endif;
	}
	return $stf;
}

function ordenart2($s)
{
	$val = explode('-', $s);
	$stf = '';
	for ($ii = 0; $ii <= count($val) - 1; $ii++) {
		if (floatval($val[$ii]) > 9) :
			$stf = $stf . $val[$ii] . '  ';
		else :
			$stf = $stf . '  ' . $val[$ii] . '  ';
		endif;
	}
	return $stf;
}
