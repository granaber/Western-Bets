<?php

require('fpdf.php');

class PDF extends FPDF
{

	//Columna actual
	var $col = 0;
	//Ordenada de comienzo de la columna
	var $y0;

	function Header()
	{
		//Cabacera
		global $title;

		$this->SetFont('Arial', 'B', 10);
		$w = $this->GetStringWidth($title) + 6;
		$this->SetX((210 - $w) / 2);
		$this->SetDrawColor(15);
		$this->SetFillColor(230);
		//$this->SetTextColor(220,50,50);
		$this->SetLineWidth(1);
		$this->Cell($w, 9, $title, 1, 1, 'C', 1);
		$this->Ln(2);
		//Guardar ordenada
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

	function ChapterTitle($label)
	{
		//T�tulo
		$this->SetFont('Arial', 'B', 12);
		$this->SetFillColor(200, 220, 255);
		$this->MultiCell(0, 6, $label, 0, 1, 'L', 1);
		$this->Ln(1);
		//Guardar ordenada
		$this->y0 = $this->GetY();
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

	function piepag($line1, $line2, $line3, $line4)
	{

		//Fuente
		$this->SetFont('Times', 'B', 8);
		//Imprimir texto en una columna de 6 cm de ancho
		$this->Cell(20, 5, $line1);
		$this->Cell(15, 5, $line2);
		$this->Cell(20, 5, $line3);
		$this->MultiCell(15, 5, $line4);


		// $this->SetCol(1);
	}
}

$termine = true;
$GLOBALS['link'] = mysqli_connect("localhost", "sphonlin_root", "intra");
mysql_select_db("sphonlin_sphonline", $GLOBALS['link']);
$IDCN = $_REQUEST['idcn'];
$result = mysqli_query($GLOBALS['link'], "SELECT Fecha,_hipodromos.Descripcion FROM _tconfjornada,_hipodromos where _tconfjornada.IDhipo=_hipodromos._idhipo  and IDCN=" . $IDCN,  $GLOBALS['link']);
$row = mysqli_fetch_array($result);
$title = 'Relacion de fecha: ' . $row['Fecha'] . ' Hipodromo de :' . $row['Descripcion'];

$result = mysqli_query($GLOBALS['link'], "select * from  _relacion12 where IDCN=" . $IDCN . ' Order by IDJug,carr',  $GLOBALS['link']);
$pdf = new PDF();
$pdf->SetAutoPageBreak(true, 35);
$pdf->SetTopMargin(3);
$pdf->AddPage();

$pdf->SetLeftMargin(5);
$pdf->SetRightMargin(0);

while ($row = mysqli_fetch_array($result)) {
	if ($row['carr'] == 0) :
		$result2 = mysqli_query($GLOBALS['link'], "select * from  _tdjuegos where IDJug=" . $row['IDJug'],  $GLOBALS['link']);
		$row2 = mysqli_fetch_array($result2);
		$pdf->ChapterTitle('Resultado del ' . $row2['Descrip']);
		$result3 = mysqli_query($GLOBALS['link'], "select * from  _relacion where  IDJug=" . $row['IDJug'] . " and  IDCN=" . $IDCN . " order by IDJug,Posi",  $GLOBALS['link']);
		while ($row3 = mysqli_fetch_array($result3)) {
			$pdf->ChapterBody($row3['Posi'] . 'V.-', $row3['NomEjem'], '(' . $row3['Ejem'] . ')');
		}
		$pdf->piepag('ESCRUTINIO:', $row['es'], 'A.C.:', $row['ac']);
		$pdf->piepag('FACTOR:', $row['fac'], 'DIVIDENDO:', $row['diven']);

	//	$pdf->Ln();

	endif;
	if ($row['carr'] != 0) :
		$result2 = mysqli_query($GLOBALS['link'], "select * from  _tdjuegos where IDJug=" . $row['IDJug'],  $GLOBALS['link']);
		$row2 = mysqli_fetch_array($result2);

		$result3 = mysqli_query($GLOBALS['link'], "select * from  _relacion where  IDJug=" . $row['IDJug'] . " and  IDCN=" . $IDCN . " and carr=" . $row['carr'] . " order by IDJug,Posi",  $GLOBALS['link']);
		if (mysqli_num_rows($result3) != 0) :
			$pdf->ChapterTitle($row2['Descrip'] . ' Carr/Tan:' . $row['carr']);

			while ($row3 = mysqli_fetch_array($result3)) {
				$pdf->ChapterBody($row3['Posi'] . '�.-', $row3['NomEjem'], '(' . $row3['Ejem'] . ')');
			}

			$pdf->piepag('DIVIDENDO:', '', $row['diven'], ''); //$pdf->Ln();
		endif;
	endif;
}


$result3 = mysqli_query($GLOBALS['link'], "select * from  _relacion where  NomEjem='' and IDCN=" . $IDCN . "  order by IDJug,carr",  $GLOBALS['link']);

if (mysqli_num_rows($result3) != 0) :

	$dd = '';
	$carrr = 0;

	while ($row3 = mysqli_fetch_array($result3)) {
		$result2 = mysqli_query($GLOBALS['link'], "select * from  _tdjuegos where IDJug=" . $row3['IDJug'],  $GLOBALS['link']);
		$row2 = mysqli_fetch_array($result2);
		if ($dd != $row2['Descrip'] || $carrr != $row3['carr']) :
			$i = 1;
			$dd = $row2['Descrip'];
			$carrr = $row3['carr'];

			$pdf->ChapterTitle($dd . ' Carr/Tan:' . $row3['carr']);
		else :
			$i++;
		endif;

		$pdf->ChapterBody($i . '�.-', $row3['Ejem'], '');
	}

endif;

$termine = false;
$result2 = mysqli_query($GLOBALS['link'], "select * from  _relacion13 where IDCN=" . $IDCN,  $GLOBALS['link']);
$row2 = mysqli_fetch_array($result2);

$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(1, 1, date("d-m-y") . " " . date("g:i a"), 1, 0, "L");

$pdf->SetX(1);
$pdf->SetY(262);

$pdf->MultiCell(190, 5, $row2['Observa'], 1);
$pdf->Output();
