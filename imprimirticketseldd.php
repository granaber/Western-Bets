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
		$this->text(10, 7, 'Reporte de Ticket�s');
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

	function registro($varlo, $w, $w1, $fill)
	{
		$this->SetFont('Arial', 'B', 8);
		$this->Setx(1);
		$this->SetFillColor(180, 139, 175);
		for ($i = 0; $i < count($varlo); $i++) {

			$this->Cell($w[$i], 4, $varlo[$i], 0, 0, $w1[$i], $fill);
		}
		$this->Ln();
	}
}
$sql = $_REQUEST['sql'];
$tipo = $_REQUEST['tipo'];

$xpp = 130;
$header = array();
$w = array();
$w1 = array();
if ($tipo == 1) :
	$ttex = 'Ticket Impresos';
else :
	$ttex = 'Ticket Premiados';
endif;



$header[0] = 'Serial';
$w[0] = 20;
$w1[0] = 'R';
$header[1] = 'Ltr';
$w[1] = 15;
$w1[1] = 'L';
$header[2] = 'Dia-Fecha';
$w[2] = 25;
$w1[2] = 'R';
$header[3] = 'Hora';
$w[3] = 25;
$w1[3] = 'R';
$header[4] = 'Apuesta';
$w[4] = 20;
$w1[4] = 'R';
$header[5] = 'Monto Ticket';
$w[5] = 20;
$w1[5] = 'R';
$header[6] = 'Terminal';
$w[6] = 15;
$w1[6] = 'R';
$header[7] = 'Estatus';
$w[7] = 15;
$w1[7] = 'L';


$pdf = new PDF('P', 'mm', 'Legal');

$pdf->AddPage();
$pdf->SetAutoPageBreak(true);

$sttt = str_replace(chr(92), ' ', $sql);
$result = mysqli_query($GLOBALS['link'], $sttt);



while ($row = mysqli_fetch_array($result)) {
	if ($tipo == 1) :
		$acc = true;
	else :
		$acc = vescrute($row['serial']);
	endif;
	if ($acc == true) :
		$aa[0] = $row['serial'];
		$result_f = mysqli_query($GLOBALS['link'], "SELECT Fecha FROM _jornadabb where IDJ=" . $row['IDJ']);
		$Rowf = mysqli_fetch_array($result_f);
		$aa[1] = $row['IDC'];
		$aa[2] = fecha_dia($Rowf['Fecha']) . '-' . $Rowf['Fecha'];
		$aa[3] = $row['hora'];
		$aa[4] = number_format($row['ap'], 2, '.', '');
		$aa[5] = number_format($row['acobrar'], 2, '.', '');
		$aa[6] = $row['terminal'];
		if ($row['activo'] == 1) :
			$aa[7] = 'Activo';
			$pdf->registro($aa, $w, $w1, false);
		else :
			$aa[7] = 'Eliminado';
			$pdf->registro($aa, $w, $w1, true);
		endif;


	endif;
}




$_xp = $pdf->Gety();
$pdf->Sety($_xp + 3);
$pdf->Setx($xpp - 20);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 4);
$pdf->Cell(1, 1, date("d-m-y") . " " . date("g:i a"), 1, 0, "L");
$pdf->Output();
