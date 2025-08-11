<?php

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
		$this->text(10, 7, 'Reporte Detallado de Ventas/Premio Por Carrera');
		$this->text(10, 10, $ttex);
		$this->text(10, 20, $ttex2);
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
		$this->Ln();
		$this->Ln();
		$this->Ln();
		$this->SetFont('Arial', 'B', 8);
		$this->Setx(1);

		for ($i = 0; $i < count($header); $i++)
			$this->Cell($w[$i], 3, $header[$i], 1, 0, $w1[$i]);
		$this->Ln();
	}



	function registro($varlo, $w, $w1, $b, $fill)
	{
		$this->SetFont('Arial', 'B', 8);
		$this->Setx(1);
		$this->SetFillColor(205, 205, 205);
		for ($i = 0; $i < count($varlo); $i++) {
			$this->Cell($w[$i], 4, $varlo[$i], $b, 0, $w1[$i], $fill);
		}
		$this->Ln();
	}
}

$op = $_REQUEST['op'];
$d1 = $_REQUEST['d1'];
$d2 = $_REQUEST['d2'];
$clsi = $_REQUEST['clsi'];
$gp = $_REQUEST['gp'];
$ttex2 = '';
$add = '';

if (true) :
	$add = "and  IDCN In (Select IDCN  From _tconfig Where STR_TO_DATE(_Fecha,'%d/%m/%Y') BETWEEN STR_TO_DATE('" . $d1 . "','%d/%m/%Y') and STR_TO_DATE('" . $d2 . "','%d/%m/%Y')) ";
	$ttex = " Desde : " . $d1 . " Hasta: " . $d2;
	$xpp = 170;
	$add1 = '';

	if ($op != 0) :
		$clsi = 2;
		$gp = $op;
	endif;

	switch ($clsi) {
		case 1:
			if ($gp != "0") :
				$add1 = " where IDC='" . $gp . "'";
				$ttex2 = 'Concesionarion : ' . $gp;
			endif;
			break;

		case 2:
			if ($gp != 0) :
				$add1 = " where IDG=" . $gp;
				$ttex2 = 'Grupo: ' . $gp;
			endif;
			break;
	}


	$header = array();
	$w = array();
	$w1 = array();
	$stotalv = array();
	$stotalp = array();
	$header[0] = 'Ltr';
	$w[0] = 10;
	$w1[0] = 'R';
	$header[1] = 'Vendedor';
	$w[1] = 35;
	$w1[1] = 'L';
	$header[2] = ' ';
	$w[2] = 3;
	$w1[2] = 'L';
	for ($i = 1; $i <= 14; $i++) {
		$header[2 + $i] = $i . 'C';
		$w[2 + $i] = 18;
		$w1[2 + $i] = 'R';
		$stotalv[2 + $i] = 0;
		$stotalp[2 + $i] = 0;
	}

	$header[2 + $i] = 'Total ';
	$w[2 + $i] = 22;
	$w1[2 + $i] = 'R';

	$pdf = new PDF('L', 'mm', 'Legal');

	$pdf->AddPage();
	$pdf->SetAutoPageBreak(true);
	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tdjuegos where Formato=5");
	$row = mysqli_fetch_array($result);
	$idj = $row['IDJug'];
	$sumatotaldeventas = 0;
	$sumatotaldepremios = 0;
	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionario " . $add1 . " Order By IDC");
	while ($row = mysqli_fetch_array($result)) {
		$totalgventas = 0;
		$totalgpremios = 0;
		$clventas = 0;
		$result2 = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tjugada  where IDC='" . $row['IDC'] . "'    and Anulado=0 and IDJug=" . $idj . "  " . $add);
		for ($i = 0; $i <= 17; $i++) {
			$aa[$i] = '';
			$bb[$i] = '';
		}
		while ($row2 = mysqli_fetch_array($result2)) {
			if ($row2['Valor_R'] == 0) :
				$clventas = calculo_tablasencero($row2['Jugada']);
				$aa[2 + $row2['carr']] += number_format($clventas, 0, '', '.');
				$totalgventas += $clventas;
				$stotalv[2 + $row2['carr']] += $clventas;
				$sumatotaldeventas += $clventas;
			else :
				$aa[2 + $row2['carr']] += number_format($row2['Valor_R'], 0, '', '.');
				$totalgventas += $row2['Valor_R'];
				$stotalv[2 + $row2['carr']] += $row2['Valor_R'];
				$sumatotaldeventas += $row2['Valor_R'];
			endif;

			$costo = array();
			$costo = escrutetablas($row2['Serial']);
			$bb[2 + $row2['carr']] +=  number_format($costo[0], 0, '', '.');;
			$totalgpremios	+= $costo[0];
			$stotalp[2 + $row2['carr']] +=	$costo[0];
			$sumatotaldepremios += $costo[0];
		}

		if ($totalgventas != 0) :
			$aa[0] = $row['IDC'];
			$aa[1] = $row['Nombre'];
			$aa[2] = 'V';
			$aa[17] = number_format($totalgventas, 0, '', '.');
			$bb[0] = '';
			$bb[1] = '';
			$bb[2] = 'P';
			$bb[17] = number_format($totalgpremios, 0, '', '.');
			$pdf->registro($aa, $w, $w1, 'L', false);
			$pdf->registro($bb, $w, $w1, 'BL', false);
		endif;
	}
	$stotalv[0] = '';
	$stotalv[1] = 'TOTAL GENERAL';
	$stotalv[2] = 'V';
	$stotalv[17] = number_format($sumatotaldeventas, 0, '', '.');
	$stotalp[0] = '';
	$stotalp[1] = '';
	$stotalp[2] = 'P';
	$stotalp[17] = number_format($sumatotaldepremios, 0, '', '.');
	$pdf->registro($stotalv, $w, $w1, 1, true);
	$pdf->registro($stotalp, $w, $w1, 1, true);


	$_xp = $pdf->Gety();
	$pdf->Sety($_xp + 3);
	$pdf->Setx($xpp - 20);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Ln(10);
	$pdf->SetFont('Arial', 'B', 4);
	$pdf->Cell(1, 1, date("d-m-y") . " " . date("g:i a"), 1, 0, "L");
	$pdf->Output();

else :

	echo "No Hay Informacion...";

endif;
