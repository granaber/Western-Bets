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
		$this->text(10, 7, 'Reporte Resumido de Ventas/Premio/Diferencia');
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

	$header[0] = 'Vendedor';
	$w[0] = 35;
	$w1[0] = 'L';
	$header[1] = 'Venta';
	$w[1] = 18;
	$w1[1] = 'R';
	$header[2] = '%';
	$w[2] = 18;
	$w1[2] = 'R';
	$header[3] = 'Premios';
	$w[3] = 18;
	$w1[3] = 'R';
	$header[4] = 'Diferencia';
	$w[4] = 18;
	$w1[4] = 'R';
	$header[5] = 'Estatus';
	$w[5] = 18;
	$w1[5] = 'R';
	$header[6] = 'Acumulado';
	$w[6] = 18;
	$w1[6] = 'R';

	$pdf = new PDF('P', 'mm', 'Legal');
	$pdf->AddPage();
	$pdf->SetAutoPageBreak(true);
	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tdjuegos where Formato=5");
	$row = mysqli_fetch_array($result);
	$idj = $row['IDJug'];
	$totalventas = 0;
	$totalporcentaje = 0;
	$totalpremios = 0;
	$totaldiferencia = 0;
	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionario " . $add1 . " Order By IDC");
	while ($row = mysqli_fetch_array($result)) {
		$totalgventas = 0;
		$totalgpremios = 0;
		$clventas = 0;
		$result2 = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tjugada  where IDC='" . $row['IDC'] . "'    and Anulado=0 and IDJug=" . $idj . "  " . $add);
		while ($row2 = mysqli_fetch_array($result2)) {
			if ($row2['Valor_R'] == 0) :
				$clventas = calculo_tablasencero($row2['Jugada']);
				$totalgventas += $clventas;
			else :
				$totalgventas += $row2['Valor_R'];
			endif;
			$costo = array();
			$costo = escrutetablas($row2['Serial']);
			$totalgpremios	+= $costo[0];
		}
		$aa = array();
		if ($totalgventas != 0) :
			$aa[0] = $row['Nombre'];
			$aa[1] = number_format($totalgventas, 0, '', '.');
			$aa[2] = number_format($totalgventas * (4 / 100), 0, '', '.');
			$aa[3] = number_format($totalgpremios, 0, '', '.');
			$aa[4] = number_format($totalgventas - ($totalgpremios + ($totalgventas * (4 / 100))), 0, '', '.');
			$aa[5] = '';
			$aa[6] = '';
			$totalventas += $totalgventas;
			$totalporcentaje += ($totalgventas * (4 / 100));
			$totalpremios += $totalgpremios;

			$pdf->registro($aa, $w, $w1, 0, false);
		endif;
	}
	$bb = array();
	$bb[0] = 'TOTAL GENERAL';
	$bb[1] = number_format($totalventas, 0, '', '.');
	$bb[2] = number_format($totalporcentaje, 0, '', '.');
	$bb[3] = number_format($totalpremios, 0, '', '.');
	$bb[4] = number_format($totalventas - ($totalpremios + $totalporcentaje), 0, '', '.');
	$bb[5] = '';
	$bb[6] = '';
	$pdf->registro($bb, $w, $w1, 1, true);
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
