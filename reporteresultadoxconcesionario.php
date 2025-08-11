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
		$this->text(10, 7, 'Reporte de Ventas y Premios');

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
		$this->Ln();
	}

	function BasicTable($header, $w)
	{

		$this->SetFont('Arial', 'B', 8);
		for ($i = 0; $i < count($header); $i++)
			$this->Cell($w[$i], 3, $header[$i], 1, 0, 'C');


		$this->Ln();
	}

	function registro($varlo, $w, $w1, $fill)
	{
		// 
		global $form;
		$this->SetFillColor(197, 197, 197);
		for ($i = 0; $i < count($varlo); $i++) {

			$this->Cell($w[$i], 4, $varlo[$i], 1, 0, $w1[$i], $fill);
		}

		$this->Ln();
	}
}


require('prc_php.php');
$GLOBALS['link'] = Servidordual::getInstance();



$idcn = $_REQUEST['idcn'];
$idj = $_REQUEST['idj'];
$IDG = explode(',', $_REQUEST['grupos']);
$divi = $_REQUEST['div'];
$factor = $_REQUEST['fac'];
$concg = $_REQUEST['concg'];


$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tdjuegos where IDjug=" . $idj);
$row = mysqli_fetch_array($result);
$tt = $row['Descrip'];
$form = $row['Formato'];
$CantidadCarr = $row['CantidadCarr'];

$conesc = explode('-', $row['op4']);
$totaldeb = $CantidadCarr - $conesc[$concg];

$xpp = 140;
$pdf = new PDF('P', 'mm', 'Legal');
$pdf->SetAutoPageBreak(true);

for ($t = 0; $t <= count($IDG) - 1; $t++) {

	$ttex = 'Grupo No:' . $IDG[$t];

	$pdf->AddPage();

	$header2 = array();
	$w2 = array();
	$w1 = array();


	$header[0] = 'Letra';
	$w[0] = 20;
	$w1[0] = 'L';
	$header[1] = 'Ventas';
	$w[1] = 20;
	$w1[1] = 'R';
	$header[2] = 'Total de Premios';
	$w[2] = 30;
	$w1[2] = 'R';
	$header[3] = 'Partici.';
	$w[3] = 20;
	$w1[3] = 'R';
	$header[4] = 'P. Malos';
	$w[4] = 20;
	$w1[4] = 'R';
	$header[5] = 'Partici.';
	$w[5] = 20;
	$w1[5] = 'R';
	$header[6] = 'Total Premios';
	$w[6] = 30;
	$w1[6] = 'R';


	$pdf->BasicTable($header, $w);

	$result = mysqli_query($GLOBALS['link'], "SELECT _tjugada.* FROM _tjugada,_tconsecionario where _tjugada.IDC=_tconsecionario.IDC and _tconsecionario.IDG=" . $IDG[$t] . " and IDJug=" . $idj . " and idcn=" . $idcn . " and Anulado=0 Order by  _tconsecionario.IDC");



	$cabz = -1;
	$cuento = 0;
	$numx = 230;
	$sumxletra = 0;
	$sumxGrupo = 0;
	$inicio = true;
	$IDC = -1;
	$totalventas = 0;
	$tpremios = 0;
	$tpremiosB = 0;
	$tpremiosBP = 0;
	$tpremiosM = 0;
	$tpremiosMP = 0;
	$totaldepremios = 0;

	$TGV = 0;
	$TGP = 0;
	$TDP = 0;
	$TDPB = 0;
	$TDPM = 0;
	$TDPAM = 0;


	while ($row = mysqli_fetch_array($result)) {
		if ($IDC != $row['IDC']) :
			if ($IDC != -1) :
				// AQUIE DEBO IMPRIMIR  E INICIALIZAR
				$uu = 0;
				$aa[$uu] = $IDC;
				$aa[$uu + 1] = number_format($totalventas, 2, ',', '.');
				if ($totaldepremios != 0) :
					$aa[$uu + 2] = $tpremios;
					$aa[$uu + 3] = $tpremiosBP;
					$aa[$uu + 4] = $tpremiosM;
					$aa[$uu + 5] = $tpremiosMP;
					$aa[$uu + 6] = number_format($totaldepremios, 2, ',', '.');
				else :
					$aa[$uu + 2] = '';
					$aa[$uu + 3] = '';
					$aa[$uu + 4] = '';
					$aa[$uu + 5] = '';
					$aa[$uu + 6] = '';
				endif;

				$pdf->registro($aa, $w, $w1, 0);

				$totalventas = 0;
				$tpremios = 0;
				$tpremiosB = 0;
				$tpremiosBP = 0;
				$tpremiosM = 0;
				$tpremiosMP = 0;
				$totaldepremios = 0;
			endif;

			$IDC = $row['IDC'];

		endif;
		$arrayes = poolescrute($row['Serial']);
		$atp = contarenblanco($arrayes, 5);
		$totalventas += $row['Valor_J'];
		$TGV += $row['Valor_J'];

		if ($atp == $totaldeb) :
			if ($arrayes[2] != 0) : $parti = $arrayes[2];
			else : $parti = 1;
			endif;
			$tpremios++;
			$TDP++;
			$tpremiosB += $arrayes[0];
			$tpremiosBP += ($arrayes[0] * $parti);
			$TDPB += ($arrayes[0] * $parti);
			$tpremiosM += $arrayes[1];
			$TDPM += $arrayes[1];
			$tpremiosMP += ($arrayes[1] * $parti);
			$TDPAM += ($arrayes[1] * $parti);
			$pago = calculodepago($row['Valor_J'], $row['Valor_R'], $arrayes[0], $arrayes[1], $parti, $divi, $factor);
			$totaldepremios += $pago;
			$TGP += $pago;
		endif;
	}

	// AQUI DEBO IMPRIMIR  E INICIALIZAR
	$uu = 0;
	$aa[$uu] = $IDC;
	$aa[$uu + 1] = number_format($totalventas, 2, ',', '.');
	if ($totaldepremios != 0) :
		$aa[$uu + 2] = $tpremios;
		$aa[$uu + 3] = $tpremiosBP;
		$aa[$uu + 4] = $tpremiosM;
		$aa[$uu + 5] = $tpremiosMP;
		$aa[$uu + 6] = number_format($totaldepremios, 2, ',', '.');
	else :
		$aa[$uu + 2] = '';
		$aa[$uu + 3] = '';
		$aa[$uu + 4] = '';
		$aa[$uu + 5] = '';
		$aa[$uu + 6] = '';
	endif;

	$pdf->registro($aa, $w, $w1, 0);

	$pdf->SetFont('Arial', 'B', 8);
	$uu = 0;
	$aa[$uu] = 'TOTAL :';
	$aa[$uu + 1] = number_format($TGV, 2, ',', '.');
	$aa[$uu + 2] = $TDP;
	$aa[$uu + 3] = $TDPB;
	$aa[$uu + 4] = $TDPM;
	$aa[$uu + 5] = $TDPAM;
	$aa[$uu + 6] = number_format($TGP, 2, ',', '.');
	$pdf->registro($aa, $w, $w1, 1);
	$pdf->Ln();
	$pdf->Setx($xpp - 20);
} //<--- FIN DEL FOR....




$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 4);
$pdf->Cell(1, 1, date("d-m-y") . " " . date("g:i a"), 1, 0, "L");
$pdf->Output();
