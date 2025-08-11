<?php

require('fpdf.php');

class PDF extends FPDF
{



	function Header()
	{
		global $xpp;
		global $tt;
		global $ttex;
		global $ttex2;
		global $ttex3;
		global $header;
		global $w;
		global $w1;

		$this->Sety(0);
		$this->Setx(0);
		$this->SetFont('Arial', 'I', 7);
		$this->text(10, 7, 'REPORTE SEMANAL PUNTO DE VENTA');
		$this->text(10, 10, $ttex);
		$this->text(10, 15, $ttex2);
		$this->text(10, 20, $ttex3);
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

	function registro($varlo, $w, $varlo2, $w1)
	{

		/*global $form;
    for($i=0;$i<count($varlo);$i++)
	  $this->Cell($w[$i],4,$varlo[$i],1,0,$w1[$i]);   
	
	if (count($w2)!=0):
	   
	endif;*/

		$this->SetFont('Arial', 'B', 8);
		$this->Setx(1);
		$this->SetFillColor(205, 205, 205);
		for ($i = 0; $i < count($varlo); $i++)
			if ($varlo[$i] != 0 || $varlo[$i] != '') :
				$this->Cell($w[$i], 4, $varlo[$i], 1, 0, $w1[$i], $fill);
			else :
				$this->Cell($w[$i], 4, '', 1, 0, $w1[$i], $fill);
			endif;
		$this->Ln();
		$this->Setx(1);
		for ($i = 0; $i < count($varlo2); $i++)
			if ($varlo2[$i] != 0) :
				$this->Cell($w[$i], 4, $varlo2[$i], 'LRB', 0, $w1[$i], 1);
			else :
				$this->Cell($w[$i], 4, '', 'LRB', 0, $w1[$i], 1);
			endif;
		$this->Ln();
	}
}



require('prc_php.php');
require('escruteshi.php');

$GLOBALS['link'] = Connection::getInstance();

$xpp = 170;
$desdeIDCN = 0;
$hastaIDCN = 0;
$desde = $_REQUEST['desde'];
$hasta = $_REQUEST['hasta'];
$IDC = $_REQUEST['IDC'];


$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfjornadahi where (STR_TO_DATE(Fecha,'%d/%m/%Y') BETWEEN STR_TO_DATE('" . $desde . "','%d/%m/%Y') and STR_TO_DATE('" . $hasta . "','%d/%m/%Y')) ");
if (mysqli_num_rows($result) != 0) :

	$add = ' and (';
	$totalderegistro =	mysqli_num_rows($result);

	$i = 1;
	while ($row = mysqli_fetch_array($result)) {
		$add .= ' _tconfighi.IDCN=' . $row['IDCN'];

		if (($totalderegistro) != $i) :
			$add .= ' or ';
			$i++;
		endif;
	}



	$add .= ")";
	$ttex = " Desde : " . $desde . " Hasta: " . $hasta;



	$add = $add . " and _tjugadahi.IDC='" . $IDC . "'";
	$ttex3 = " Letra: " . $IDC;




	$header2 = array();
	$w2 = array();
	$w1 = array();
	$aa = array();
	$bb = array();
	$row = mysqli_fetch_array($result);

	$diassemana = array('Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo');
	$header[0] = 'Concesionario';
	$w[0] = 25;
	$w1[0] = 'L';
	$w2[0] = 'L';
	$aa[0] = 0;
	$bb[0] = 0;
	$aat[0] = 'TOTALES';
	$bbt[0] = 0;
	for ($i = 1; $i <= 7; $i++) {
		$header[$i] = $diassemana[$i - 1];
		$w[$i] = 15;
		$w1[$i] = 'R';
		$w2[$i] = 'R';
		$aa[$i] = 0;
		$bb[$i] = 0;
		$aat[$i] = 0;
		$bbt[$i] = 0;
	}

	$header[$i] = 'TOTALES';
	$w[$i] = 20;
	$w1[$i] = 'R';
	$w2[$i] = 'L';
	$aa[$i] = 0;
	$bb[$i] = 0;
	$aat[$i] = 0;
	$bbt[$i] = 0;
	$header[$i + 1] = '%';
	$w[$i + 1] = 20;
	$w1[$i + 1] = 'R';
	$w2[$i + 1] = 'L';
	$aa[$i + 1] = 0;
	$bb[$i + 1] = 0;
	$aat[$i + 1] = 0;
	$bbt[$i + 1] = 0;
	$header[$i + 2] = 'DIFERENCIA';
	$w[$i + 2] = 20;
	$w1[$i + 2] = 'R';
	$w2[$i + 2] = 'L';
	$aa[$i + 2] = 0;
	$bb[$i + 2] = 0;
	$aat[$i + 2] = 0;
	$bbt[$i + 2] = 0;
	$header[$i + 3] = 'PARTICIPA';
	$w[$i + 3] = 20;
	$w1[$i + 3] = 'R';
	$w2[$i + 3] = 'L';
	$aa[$i + 3] = 0;
	$bb[$i + 3] = 0;
	$aat[$i + 3] = 0;
	$bbt[$i + 3] = 0;

	$result = mysqli_query($GLOBALS['link'], "SELECT _tjugadahi.*,_tconfighi._Fecha  FROM _tjugadahi,_tconfighi  where  _tjugadahi.IDCN=_tconfighi.IDCN  and  (anulado=0 or anulado=4 or anulado=3 )   " . $add . " order by IDC,IDJug,_tjugadahi.IDCN,carr,serial ");

	//echo("SELECT _tjugadahi.*,_tconsecionario.IDG,_tconfighi._Fecha  FROM _tjugadahi,_tconsecionario,_tconfighi  where  _tjugadahi.IDCN=_tconfighi.IDCN and _tconsecionario.estatus=1 and  anulado=0  ".$add." order by IDC,IDJug,IDG,_tjugadahi.IDCN,carr,serial " );

	$pdf = new PDF('P', 'mm', 'Legal');
	$pdf->AddPage();
	$pdf->SetAutoPageBreak(true);
	$IDC = '';

	while ($row = mysqli_fetch_array($result)) {
		if ($IDC != $row['IDC']) :
			if ($IDC != '') :
				$sumar1 = 0;
				$sumar2 = 0;
				for ($c = 1; $c <= count($aa) - 4; $c++) {
					$sumar1 += $aa[$c];
					$sumar2 += $bb[$c];
				}
				$aa[count($aa) - 4] = number_format($sumar1, 2, ',', '.');
				$bb[count($bb) - 4] = number_format($sumar2, 2, ',', '.');
				$aat[count($aat) - 4] += $sumar1;
				$bbt[count($bbt) - 4] += $sumar2;

				//// Porcentaje
				$datosr = verporcetajes($IDC);
				$aa[count($aa) - 3] = number_format(($sumar1 * $datosr[0]) / 100, 2, ',', '.') . '(' . $datosr[0] . '%)';
				$bb[count($bb) - 3] = 0;
				$aat[count($aat) - 3] += ($sumar1 * $datosr[0]) / 100;
				$bbt[count($bbt) - 3] += 0;
				//// Diferencia
				$diferencia = $sumar1 - (($sumar1 * $datosr[0]) / 100 + $sumar2);
				$aa[count($aa) - 2] = number_format($diferencia, 2, ',', '.');
				$bb[count($bb) - 2] = 0;
				$aat[count($aat) - 2] += $diferencia;
				$bbt[count($bbt) - 2] += 0;

				//// Participacion
				$aa[count($aa) - 1] = number_format(($diferencia * $datosr[1]) / 100, 2, ',', '.') . '(' . $datosr[1] . '%)';
				$bb[count($bb) - 1] = 0;
				$aat[count($aat) - 1] += ($diferencia * $datosr[1]) / 100;
				$bbt[count($bbt) - 1] += 0;

				$pdf->registro($aa, $w, $bb, $w1);
				for ($i = 0; $i <= count($aa) - 1; $i++) {
					$aa[$i] = 0;
					$bb[$i] = 0;
				}
			endif;
			$IDC = $row['IDC'];


			$aa[0] = $IDC;
			$bb[0] = '';
		endif;
		$fechaporparte = explode('/', $row['_Fecha']);
		$dia = (date("N", mktime(0, 0, 0, $fechaporparte[1], $fechaporparte[0], $fechaporparte[2])));
		if ($row['IDJug'] == 0) :
			//// 
			/* $premacion=EscrutarHI($row['Serial'],1);
     if ($premacion[1]>0):	
	    // Total Generales ///
 	 	$aa[$dia]+=$row['Valor_J']; $bb [$dia]+=$premacion[1];
	 	$aat[$dia]+=$row['Valor_J'];$bbt[$dia]+=$premacion[1];
	 else:
	 	$result_RESTORE = mysqli_query($GLOBALS['link'],"Select * from  _tjugadahi where Serial=".$row['Serial']);
		$row_Rest = mysqli_fetch_array($result_RESTORE);
		$aa[$dia]+=$row_Rest['Valor_J']; 
	 	$aat[$dia]+=$row_Rest['Valor_J'];
		$premacion=EscrutarHI($row['Serial'],1);
		if ($premacion[1]>=0):
			$bb [$dia]+=$premacion[1];
			$bbt[$dia]+=$premacion[1];
		endif;	
	 endif;*/

			$premacion = VerPremios($row['Serial'], 1, '');
			$aa[$dia] += $row['Valor_J'];
			$bb[$dia] += $premacion;
			$aat[$dia] += $row['Valor_J'];
			$bbt[$dia] += $premacion;

		/////
		else :
			/// Premiacion Exoticas
			/*	 $premacion=EscrutarHI($row['Serial'],1);
	 if (!$premacion[3]):
		 $aa[$dia]+=$row['Valor_J'];
		 $bb[$dia]+=$premacion[1];
	 
	 	 // Total Generales ///
	 	$aat[$dia]+=$row['Valor_J'];
	 	$bbt[$dia]+=$premacion[1];
	 else:
	   $result_RESTORE = mysqli_query($GLOBALS['link'],"Select * from  _tjugadahi  where Serial=".$row['Serial']);$row_Rest = mysqli_fetch_array($result_RESTORE);
	   if ($row_Rest['Anulado']==0 || $row_Rest['Anulado']==4):
	   	  $aa[$dia]+=$row_Rest['Valor_J'];
	 	  $bb[$dia]+=$premacion[1];
	 	  // Total Generales ///
	  	  $aat[$dia]+=$row_Rest['Valor_J'];
	   	  $bbt[$dia]+=$premacion[1];
	   endif;
	 endif;*/
			$premacion = VerPremios($row['Serial'], 2, '');
			if ($premacion != -1) :
				$aa[$dia] += $row['Valor_J'];
				$bb[$dia] += $premacion;
				$aat[$dia] += $row['Valor_J'];
				$bbt[$dia] += $premacion;
			endif;
		////////////////////////////////	 
		endif;
	}
	$sumar1 = 0;
	$sumar2 = 0;
	for ($c = 1; $c <= count($aa) - 4; $c++) {
		$sumar1 += $aa[$c];
		$sumar2 += $bb[$c];
	}
	$aa[count($aa) - 4] = number_format($sumar1, 2, ',', '.');
	$bb[count($bb) - 4] = number_format($sumar2, 2, ',', '.');
	$aat[count($aat) - 4] += $sumar1;
	$bbt[count($bbt) - 4] += $sumar2;

	$datosr = verporcetajes($IDC);

	$aa[count($aa) - 3] = number_format(($sumar1 * $datosr[0]) / 100, 2, ',', '.') . '(' . $datosr[0] . '%)';
	$bb[count($bb) - 3] = 0;
	$aat[count($aat) - 3] += ($sumar1 * $datosr[0]) / 100;
	$bbt[count($bbt) - 3] += $bb[count($bb) - 3];

	//// Diferencia
	$diferencia = $sumar1 - (($sumar1 * $datosr[0]) / 100 + $sumar2);
	$aa[count($aa) - 2] = number_format($diferencia, 2, ',', '.');
	$bb[count($bb) - 2] = 0;
	$aat[count($aat) - 2] += $diferencia;
	$bbt[count($bbt) - 2] += 0;

	//// Participacion
	$aa[count($aa) - 1] = number_format(($diferencia * $datosr[1]) / 100, 2, ',', '.') . '(' . $datosr[1] . '%)';
	$bb[count($bb) - 1] = 0;
	$aat[count($aat) - 1] += ($diferencia * $datosr[1]) / 100;
	$bbt[count($bbt) - 1] += 0;
	$pdf->registro($aa, $w, $bb, $w1);

	for ($c = 1; $c <= count($aa) - 1; $c++) {
		$aat[$c] = number_format($aat[$c], 2, ',', '.');
		$bbt[$c] = number_format($bbt[$c], 2, ',', '.');
	}

	$bbt[0] = '';
	$pdf->registro($aat, $w, $bbt, $w1);

	$pdf->Ln(10);
	$pdf->SetFont('Arial', 'B', 4);
	$pdf->Cell(1, 1, date("d-m-y") . " " . date("g:i a"), 1, 0, "L");
	$pdf->Output();

else :
	echo ' NO existe la INFORMACION SOLICITADA!!';
endif;
