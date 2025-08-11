<?php




require('fpdf.php');

class PDF extends FPDF
{
	//Columna actual
	var $col = 0;
	//Ordenada de comienzo de la columna
	var  $y0;

	function Header()
	{
		global $xpp;
		global $tt;
		global $ttex;
		$this->Sety(0);
		$this->Setx(0);
		$this->SetFont('Arial', 'I', 7);
		$this->text(10, 7, 'Reporte Resumido de Ventas');

		//$this->Image('logo_pb.png',10,8,33);
		$this->SetFont('Arial', 'B', 7);
		//***********************************
		$this->SetXY($xpp, $_xp);
		$this->Cell(30, 3, 'Fecha:' . date("d/n/Y"));
		$this->SetXY($xpp, $_xp + 3);
		$va = $this->PageNo();
		$this->Cell(30, 3, 'Pagina No:' . $va);
		$this->SetXY($xpp, $_xp + 6);

		$this->Cell(30, 3, 'Hora:' . date("g:i a"));

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
		$this->y0 = $this->GetY();
	}
	function SetCol($col)
	{
		//Establecer la posici�n de una columna dada
		$this->col = $col;
		$x = 15 + $col * 65;
		$this->SetLeftMargin($x);
		$this->SetX($x);
	}
	function AcceptPageBreak()
	{
		global $termine;
		//M�todo que acepta o no el salto autom�tico de p�gina
		if ($termine == true) :
			if ($this->col < 2) {
				//Ir a la siguiente columna
				$this->SetCol($this->col + 1);
				//Establecer la ordenada al principio
				$this->SetY(15);
				//Seguir en esta p�gina
				return false;
			} else {

				return false;
			}
		else :

			$this->SetLeftMargin(1);
			$this->SetCol(0);
			return false;
		endif;
	}



	function ChapterBody($line1, $line2, $line3)
	{

		//Fuente
		$this->SetFont('Times', '', 10);
		//Imprimir texto en una columna de 6 cm de ancho
		$this->Cell(10, 5, $line1);
		$this->Cell(40, 5, $line2);
		$this->MultiCell(20, 5, $line3);
		$this->y0 = $this->GetY();
		//$this->SetCol(0);
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
		$this->y0 = $this->GetY();
	}

	function registro($varlo, $w, $varlo2, $w2, $w1)
	{
		// 	
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
		$this->y0 = $this->GetY();
	}
}


require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$termine = true;
$xpp = 170;
$_xp = 15;
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

$header[0] = 'Conces';
$w[0] = 16;
$w1[0] = 'L';
$header[1] = 'Ventas';
$w[1] = 25;
$w1[1] = 'R';



$result = mysqli_query($GLOBALS['link'], "SELECT sum(_tjugada.Valor_J) as sumajugada,_tjugada.IDC,_tconsecionario.IDG FROM _tjugada,_tconsecionario where _tjugada.IDC=_tconsecionario.IDC and _tconsecionario.estatus=1 and anulado=0  " . $add . " group by _tjugada.IDC order by _tconsecionario.IDG,_tjugada.IDC,serial,carr");

$primeralinea = 0;



$pdf = new PDF();


$pdf->SetAutoPageBreak(true, 15);
$pdf->SetTopMargin(0);
$pdf->AddPage();

$pdf->SetLeftMargin(15);
$pdf->SetRightMargin(0);

$sumxGrupo = 0;
$inicio = true;
$grupo = -1;
while ($row = mysqli_fetch_array($result)) {
	if ($inicio == true) :
		$pdf->SetFont('Arial', 'I', 7);
		$pdf->text(10, 7, 'Reporte Resumido de Ventas');
		$pdf->SetFont('Arial', 'B', 7);
		$pdf->MultiCell(50, 3, 'Grupo:' . $row['IDG']);
		$pdf->SetFont('Arial', 'B', 4);
		$pdf->BasicTable($header, $w, $header2, $w2);
		$pdf->SetFont('Arial', 'B', 8);
		$inicio = false;
	endif;

	if ($grupo == -1) :
		$grupo = $row['IDG'];
	endif;
	$aa2 = array();
	$aa[0] = $row['IDC'];
	$aa[1] = number_format($row['sumajugada'], 2, ',', '.');


	if ($grupo == $row['IDG']) :
		$sumxGrupo += $row['sumajugada'];
		$pdf->registro($aa, $w, $aa2, $w2, $w1);
		$pdf->Ln();
	else :
		$pdf->SetFont('Arial', 'B', 8);
		$pdf->MultiCell(100, 3, 'Total Ventas Grupo(' . $grupo . ') : ' . number_format($sumxGrupo, 2, ',', '.'));
		$sumxGrupo = 0;
		$grupo = $row['IDG'];
		$pdf->Ln();
		$pdf->SetFont('Arial', 'B', 7);
		$pdf->MultiCell(50, 3, 'Grupo:' . $row['IDG']);
		$pdf->SetFont('Arial', 'B', 4);
		$pdf->BasicTable($header, $w, $header2, $w2);
		$pdf->SetFont('Arial', 'B', 8);
		$pdf->registro($aa, $w, $aa2, $w2, $w1);
		$sumxGrupo += $row['sumajugada'];
		$pdf->Ln();
	endif;
}

$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(100, 3, 'Total Ventas Grupo(' . $grupo . ') : ' . number_format($sumxGrupo, 2, ',', '.'));
$sumxGrupo = 0;
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 4);
$pdf->Cell(1, 1, date("d-m-y") . " " . date("g:i a"), 1, 0, "L");
$pdf->Output();
