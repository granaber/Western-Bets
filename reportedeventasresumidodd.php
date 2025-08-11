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

		$this->text(10, 7, 'Reporte Resumido de Ventas Deporte');

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

		$this->Cell(30, 3, 'Hora:' . Horareal($GLOBALS['minutosh'], "h:i:s A"));

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
		$this->SetFont('Arial', 'B', 7);
		$this->Setx(1);
		$this->SetFillColor(205, 205, 205);
		for ($i = 0; $i < count($varlo); $i++) {
			$mv = isset($varlo[$i]) ? $varlo[$i] : '';
			$this->Cell($w[$i], 4, $mv, 1, 0, $w1[$i], $fill);
		}
		$this->Ln();
	}
}





$d1 = $_REQUEST['d1'];

$d2 = $_REQUEST['d2'];

$clsi = $_REQUEST['clsi'];

$gp = $_REQUEST['gp'];

$ttex2 = '';







$add = '';



$sihay = false;
$desdeIDC = 0;
$hastaIDC = 0;

//// Determin rango de Lectura de IDJ

$result = mysqli_query($GLOBALS['link'], "Select IDJ From _jornadabb Where STR_TO_DATE(Fecha,'%d/%m/%Y') BETWEEN STR_TO_DATE('" . $d1 . "','%d/%m/%Y') and STR_TO_DATE('" . $d2 . "','%d/%m/%Y') Group by IDJ Order by IDJ");

if (mysqli_num_rows($result) != 0) :
	/*$row = mysqli_fetch_array($result);
$desdeIDC=$row['IDJ']; */
	$sihay = true;
	$verdatos = '';
	$i = 1;
	while ($row = mysqli_fetch_array($result)) {
		/*$hastaIDC=$row['IDJ']; */
		$verdatos .= ' IDJ=' . $row['IDJ'];
		if ($i < mysqli_num_rows($result)) :
			$verdatos .= ' or ';
			$i++;
		endif;
	}
/*if ($hastaIDC==0): $hastaIDC=$desdeIDC; endif;*/
endif;
if ($sihay) :
	$add = "and  (" . $verdatos . " ) ";





	$ttex = " Desde : " . $d1 . " Hasta: " . $d2;





	$xpp = 170;



	$add1 = '';
	$Npasan = array();
	$Npasan1 = array();
	$np = 0;
	$header = array();
	$w = array();
	$w1 = array();
	$totalg1 = 0;
	$totalg2 = 0;
	$totalg3 = 0;
	$totalg4 = 0;
	$totalg5 = 0;
	$totalg6 = 0;
	$totalgB = 0;

	switch ($clsi) {

		case 1:
			if ($gp != "0") :
				$add1 = " where IDC='" . $gp . "'";
				$ttex2 = 'Concesionarion : ' . $gp;
			endif;
			$order = ' IDC';
			$header[0] = 'Ltr';
			$w[0] = 20;
			$w1[0] = 'R';
			$header[1] = 'Empresa';
			$w[1] = 25;
			$w1[1] = 'L';
			break;



		case 2:

			if ($gp != 0) :
				$add1 = " where IDG in (" . $gp . ")";
				$ttex2 = 'Grupo: ' . $gp;
				$clsi = 1;
			endif;
			$order = ' IDG';
			$header[0] = 'Grupo';
			$w[0] = 15;
			$w1[0] = 'R';
			$header[1] = 'Nombre';
			$w[1] = 25;
			$w1[1] = 'L';
			break;
	}






	$header[2] = 'A';
	$w[2] = 5;
	$w1[2] = 'C';
	$header[3] = 'Ventas';
	$w[3] = 20;
	$w1[3] = 'R';
	$header[4] = '% Ventas';
	$w[4] = 15;
	$w1[4] = 'R';
	$header[5] = 'Premios';
	$w[5] = 20;
	$w1[5] = 'R';

	$header[6] = 'Bonos';
	$w[6] = 15;
	$w1[6] = 'R';

	$header[7] = 'Diferencia';
	$w[7] = 20;
	$w1[7] = 'R';
	$header[8] = '% Banca';
	$w[8] = 15;
	$w1[8] = 'R';
	$header[9] = 'Res.Banca';
	$w[9] = 20;
	$w1[9] = 'R';
	$header[10] = '% P.V.';
	$w[10] = 15;
	$w1[10] = 'R';
	$header[11] = 'Res.P.V.';
	$w[11] = 20;
	$w1[11] = 'R';
	$w[12] = 20;
	$w1[12] = 'R';

	$pdf = new PDF('P', 'mm', 'Legal');
	$pdf->AddPage();
	$pdf->SetAutoPageBreak(true);
	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionario " . $add1 . " Order By " . $order);

	$grupo = 0;
	while ($row = mysqli_fetch_array($result)) {

		$totalventas = 0;
		$totalpremio = 0;
		$totalventas1 = 0;
		$totalpremio1 = 0;
		$totalBonos1 = 0;
		$totalBonos2 = 0;

		if ($clsi == 2) :
			if ($grupo != $row['IDG']) :
				if ($grupo != 0) :
					$result_grp = mysqli_query($GLOBALS['link'], "SELECT * FROM _tgrupo where IDG=$grupo");
					$row_grp = mysqli_fetch_array($result_grp);
					$aa[0] = $grupo;
					$aa[1] = $row_grp['Descrip'];
					$aa[2] = 'D';
					$aa[3] = number_format($totalventasGD, 2, '.', '');
					$aa[4] = number_format($totalporcentajeGD, 2, '.', '');
					$aa[5] = number_format($totalpremioGD, 2, '.', '');
					$aa[7] = number_format(($totalventasGD - $totalporcentajeGD) - $totalpremioGD, 2, '.', '');
					$aa[8] = number_format(0, 2, '.', '');
					$aa[9] = number_format(0, 2, '.', '');
					$aa[10] = number_format(0, 2, '.', '');
					$aa[11] = number_format(0, 2, '.', '');
					$pdf->registro($aa, $w, $w1, 0);
					$aa[0] = '';
					$aa[1] = '';
					$aa[2] = 'P';
					$aa[3] = number_format($totalventasGP, 2, '.', '');
					$aa[4] = number_format($totalporcentajeGP, 2, '.', '');
					$aa[5] = number_format($totalpremioGP, 2, '.', '');
					$aa[7] = number_format(($totalventasGP - $totalporcentajeGP) - $totalpremioGP, 2, '.', '');
					$aa[8] = number_format(0, 2, '.', '');
					$aa[9] = number_format(0, 2, '.', '');
					$aa[10] = number_format(0, 2, '.', '');
					$aa[11] = number_format(0, 2, '.', '');
					$pdf->registro($aa, $w, $w1, 0);
					$aa[0] = '';
					$aa[1] = '';
					$aa[2] = 'T';
					$aa[3] = number_format($totalventasGP + $totalventasGD, 2, '.', '');
					$aa[4] = number_format($totalporcentajeGP + $totalporcentajeGD, 2, '.', '');
					$aa[5] = number_format($totalpremioGP + $totalpremioGD, 2, '.', '');
					$diferencia1 = ($totalventasGD - $totalporcentajeGD) - $totalpremioGD;
					$diferencia2 = ($totalventasGP - $totalporcentajeGP) - $totalpremioGP;
					$aa[7] = number_format($diferencia1 + $diferencia2, 2, '.', '');
					$aa[8] = number_format(0, 2, '.', '');
					$aa[9] = number_format(0, 2, '.', '');
					$aa[10] = number_format(0, 2, '.', '');
					$aa[11] = number_format(0, 2, '.', '');
					$pdf->registro($aa, $w, $w1, 1);
				endif;
				$totalventasGD = 0;
				$totalpremioGD = 0;
				$totalporcentajeGD = 0;
				$totalventasGP = 0;
				$totalpremioGP = 0;
				$totalporcentajeGP = 0;
				$grupo = $row['IDG'];
			endif;
		endif;
		$result2 = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tjugadabb  where IDC='" . $row['IDC'] . "'    and activo=1 " . $add);

		if (mysqli_num_rows($result2) != 0) :

			while ($row2 = mysqli_fetch_array($result2)) {

				////////////////////////////////////////////////////////////////////////////////////////
				$resultOpen = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tbcierresemana  where IDJ=" . $row2['IDJ']);
				if (mysqli_num_rows($resultOpen) != 0) :
					$rowOpen = mysqli_fetch_array($resultOpen);
					if ($rowOpen['Cierre'] == 1) :
						if ($row2['escrute'] == '') :
							$cod = vescrute($row2['serial']);
						else :
							// 	 echo $row2['serial'].'-'.$row2['escrute'];
							// 	 print_r(unserialize($row2['escrute']));
							$cod = k1escrute(unserialize($row2['escrute']));
						endif;
					else :
						$cod = vescrute($row2['serial']);
					endif;
				else :
					if ($row2['escrute'] == '') :
						$cod = vescrute($row2['serial']);
					else:
						$cod = k1escrute(unserialize($row2['escrute']));
					endif;
				endif;
				////////////////////////////////////////////////////////////////////////////////////////

				$isDataBono = isTicketBono($row2['serial']);
				$verderecho = explode('*', $row2['Jugada']);
				if (count($verderecho) == 2) :
					$totalventas1 += $row2['ap'];
					if ($cod == true) :
						$totalpremio1 += $row2['acobrar'];
					endif;
					if ($isDataBono[0]) :
						$totalBonos1 += $isDataBono[1];
					endif;
				else :
					$totalventas += $row2['ap'];
					if ($cod == true) :
						$totalpremio += $row2['acobrar'];
					endif;
					if ($isDataBono[0]) :
						$totalBonos2 += $isDataBono[1];
					endif;
				endif;
			}

			$resultdf = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tconsecionariodd  where IDC='" . $row['IDC'] . "'");

			if (mysqli_num_rows($resultdf) != 0) :
				$row3 = mysqli_fetch_array($resultdf);
				$pdp = $row3['Participacion1'];
				$pdv = $row3['pVentas'];
				$pdp1 = $row3['Participacion2'];
				if ($row3['tipodev'] == 1) :
					$pdv = $row3['pVentas'];
					$pdv1 = $row3['pVentaspd'];
				else :
					$pdv = -3;
					if ($row3['porcentajextablad'] == 0) :
						$pdv1 = -3;
					else :
						$pdv1 = $row3['porcentajextablad'];
					endif;
				endif;
			else :
				$pdp = 0;
				$pdp1 = 0;
				$pdv1 = 0;
				$pdv = 0;
			endif;

			if ($pdv == -3) :
				$totalgporce = asignacion($totalventas, $row['IDC']);
			else :
				$totalgporce = ($totalventas * $pdv) / 100;
			endif;
			if ($pdv1 == -3) :
				$totalgporce1 = 0;
			else :
				$totalgporce1 = ($totalventas1 * $pdv1) / 100;
			endif;

			switch ($clsi) {
				case 1:
					$aa[0] = $row['IDC'];
					$aa[1] = $row['Nombre'];
					$aa[2] = 'D';
					$aa[3] = number_format($totalventas1, 2, '.', '');

					if ($pdv1 == -3) :
						$aa[4] = number_format(0, 2, '.', '');
					else :
						$aa[4] = number_format(0, 2, '.', '');
					endif;

					$aa[5] = number_format($totalpremio1, 2, '.', '');
					$aa[6] = number_format($totalBonos1, 2, '.', '');

					$aa[7] = number_format(($totalventas1 - $totalBonos1 - $aa[4]) - $totalpremio1, 2, '.', '');
					if ((($totalventas1 - $aa[4]) - $totalpremio1) < 0) :
						$pr = $pdp1;
					else :
						$pr = $pdp;
					endif;
					$aa[8] = number_format((100 - $pr), 2, '.', '');
					$aa[9] = number_format(($aa[7] * $aa[8]) / 100, 2, '.', '');
					$aa[10] = number_format($pr, 2, '.', '');
					$aa[11] = number_format($aa[7] - $aa[9], 2, '.', '');
					$total3 = $aa[3];
					$total4 = $aa[4];
					$total5 = $aa[5];
					$totalB = $aa[6];
					$total6 = $aa[7];
					$total7 = $aa[8];
					$total8 = $aa[9];
					$total9 = $aa[10];
					$total10 = $aa[11];
					$aa[7] = $aa[7] . '**';
					if ($totalventas1 != 0 || $totalventas != 0) :
						$pdf->registro($aa, $w, $w1, 0);
					endif;
					$aa[0] = '';
					$aa[1] = '';
					$aa[2] = 'P';
					$aa[3] = number_format($totalventas, 2, '.', '');
					if ($pdv == -3) :
						$aa[4] = number_format(0, 2, '.', '');
					else :
						$aa[4] = number_format(0, 2, '.', '');
					endif;
					$aa[5] = number_format($totalpremio, 2, '.', '');
					$aa[6] = number_format($totalBonos2, 2, '.', '');
					$aa[7] = number_format(($totalventas - $totalBonos2 - $aa[4]) - $totalpremio, 2, '.', '');
					if ((($totalventas - $aa[4]) - $totalpremio) < 0) :
						$pr = $pdp1;
					else :
						$pr = $pdp;
					endif;
					$aa[8] = number_format((100 - $pr), 2, '.', '');
					$aa[9] = number_format(($aa[7] * $aa[8]) / 100, 2, '.', '');
					$aa[10] = number_format($pr, 2, '.', '');
					$aa[11] = number_format($aa[7] - $aa[9], 2, '.', '');
					$total3 += $aa[3];
					$total4 += $aa[4];
					$total5 += $aa[5];
					$total6 += $aa[7];
					$total7 += $aa[8];
					$total8 += $aa[9];
					$total9 += $aa[10];
					$total10 += $aa[11];
					$totalB += $aa[6];

					$aa[7] = $aa[7] . '**';
					if ($totalventas1 != 0 || $totalventas != 0) :
						$pdf->registro($aa, $w, $w1, 0);
					endif;

					$aa[0] = '';
					$aa[1] = '';
					$aa[2] = 'T';
					$aa[3] = number_format($total3, 2, '.', '');
					$aa[4] = number_format($totalgporce + $totalgporce1, 2, '.', ''); //Porcentaje
					$totaldiferencia = $total3  -  (($totalgporce1 + $totalgporce + $totalB) + $total5);
					$aa[5] = number_format($total5, 2, '.', '');
					$aa[6] = number_format($totalB, 2, '.', '');
					$aa[7] = number_format($totaldiferencia, 2, '.', '');
					$aa[8] = '';
					if ($totaldiferencia < 0) :
						$aa[9] = number_format(($totaldiferencia * (100 - $pdp1)) / 100, 2, '.', '');
						$aa[10] = '';
						$aa[11] = number_format(($totaldiferencia * $pdp1) / 100, 2, '.', '');
					else :
						$aa[9] = number_format(($totaldiferencia * (100 - $pdp)) / 100, 2, '.', '');
						$aa[10] = '';
						$aa[11] = number_format(($totaldiferencia * $pdp) / 100, 2, '.', '');
					endif;
					if ($totalventas1 != 0 || $totalventas != 0) :
						$pdf->registro($aa, $w, $w1, 1);
					endif;
					$totalg1 += $aa[3];
					$totalg2 += $aa[4];
					$totalg3 += $aa[5];
					$totalg4 += $aa[7];
					$totalg5 += $aa[9];
					$totalg6 += $aa[11];
					$totalgB += $aa[6];
					break;
				case 2:
					$totalventasGD += $totalventas1;
					$totalpremioGD += $totalpremio1;
					$totalporcentajeGD += $totalgporce1;

					$totalventasGP += $totalventas;
					$totalpremioGP += $totalpremio;
					$totalporcentajeGP += $totalgporce;


					$diferencia1 = ($totalventas1 - $totalpremio1) - $totalgporce1;
					$diferencia2 = ($totalventas - $totalpremio) - $totalgporce;


					$totalg1 += $totalventas1 + $totalventas;
					$totalg2 += $totalgporce1 + $totalgporce;
					$totalg3 += $totalpremio1 + $totalpremio;
					$totalg4 += $diferencia1 + $diferencia2;
					$totalg5 += 0;
					$totalg6 += 0;
					break;
				case 3:
					break;
			}
		else :
			$Npasan[$np] = $row['IDC'];
			$Npasan1[$np] = $row['Nombre'];
			$np++;

		endif;
	}

	if ($clsi == 2) :
		$result_grp = mysqli_query($GLOBALS['link'], "SELECT * FROM _tgrupo where IDG=$grupo");
		$row_grp = mysqli_fetch_array($result_grp);
		$aa[0] = $grupo;
		$aa[1] = $row_grp['Descrip'];
		$aa[2] = 'D';
		$aa[3] = number_format($totalventasGD, 2, '.', '');
		$aa[4] = number_format($totalporcentajeGD, 2, '.', '');
		$aa[5] = number_format($totalpremioGD, 2, '.', '');
		$aa[7] = number_format(($totalventasGD - $totalporcentajeGD) - $totalpremioGD, 2, '.', '');
		$aa[8] = number_format(0, 2, '.', '');
		$aa[9] = number_format(0, 2, '.', '');
		$aa[10] = number_format(0, 2, '.', '');
		$aa[11] = number_format(0, 2, '.', '');
		$pdf->registro($aa, $w, $w1, 0);
		$aa[0] = '';
		$aa[1] = '';
		$aa[2] = 'P';
		$aa[3] = number_format($totalventasGP, 2, '.', '');
		$aa[4] = number_format($totalporcentajeGP, 2, '.', '');
		$aa[5] = number_format($totalpremioGP, 2, '.', '');
		$aa[7] = number_format(($totalventasGP - $totalporcentajeGP) - $totalpremioGP, 2, '.', '');
		$aa[8] = number_format(0, 2, '.', '');
		$aa[9] = number_format(0, 2, '.', '');
		$aa[10] = number_format(0, 2, '.', '');
		$aa[11] = number_format(0, 2, '.', '');
		$pdf->registro($aa, $w, $w1, 0);
		$aa[0] = '';
		$aa[1] = '';
		$aa[2] = 'T';
		$aa[3] = number_format($totalventasGP + $totalventasGD, 2, '.', '');
		$aa[4] = number_format($totalporcentajeGP + $totalporcentajeGD, 2, '.', '');
		$aa[5] = number_format($totalpremioGP + $totalpremioGD, 2, '.', '');
		$diferencia1 = ($totalventasGD - $totalporcentajeGD) - $totalpremioGD;
		$diferencia2 = ($totalventasGP - $totalporcentajeGP) - $totalpremioGP;
		$aa[7] = number_format($diferencia1 + $diferencia2, 2, '.', '');
		$aa[8] = number_format(0, 2, '.', '');
		$aa[9] = number_format(0, 2, '.', '');
		$aa[10] = number_format(0, 2, '.', '');
		$aa[11] = number_format(0, 2, '.', '');
		$pdf->registro($aa, $w, $w1, 1);
	endif;
	$pdf->Ln();

	$aa[0] = '';

	$aa[1] = 'TOTAL GENERAL:';
	$aa[2] = 'TG';

	$aa[3] = number_format($totalg1, 2, '.', '');

	$aa[4] = number_format($totalg2, 2, '.', '');

	$aa[5] = number_format($totalg3, 2, '.', '');

	$aa[6] = number_format($totalgB, 2, '.', '');


	$aa[7] = number_format($totalg4, 2, '.', '');

	$aa[8] = '';

	$aa[9] = number_format($totalg5, 2, '.', '');

	$aa[10] = '';

	$aa[11] = number_format($totalg6, 2, '.', '');

	$pdf->registro($aa, $w, $w1, 1);

	$pdf->Ln(5);

	if ($clsi == 1) :
		for ($k = 0; $k <= $np - 1; $k++) {
			$aa[0] = $Npasan[$k];
			$aa[1] = $Npasan1[$k];
			for ($p = 2; $p <= 10; $p++) $aa[$p] = 'S/I';
			$aa[12] = '';
			$pdf->registro($aa, $w, $w1, 1);
		}
	endif;

	$pdf->Ln(5);
	$pdf->SetFont('Arial', 'B', 6);
	$pdf->Cell(1, 1, ' **El Porcentaje no esta incluido en la Diferencia, solamente se toma en cuenta en el Total Subtotal y Total General', 1, 0, "L");
	$pdf->Ln(3);
	$pdf->Cell(1, 1, ' D = Jugada por Derecho, P = Jugada Parlay, T=Total de Punto de Venta, TG=Total General del Reporte', 1, 0, "L");
	$pdf->SetFont('Arial', 'B', 4);
	$pdf->Ln(8);
	$pdf->Cell(1, 1, date("d-m-y") . " " . date("g:i a"), 1, 0, "L");

	$pdf->Output();

else :

	echo "No Hay Informacion...";

endif;