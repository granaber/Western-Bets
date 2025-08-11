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

		$this->text(10, 7, 'Relacion General Multiple');

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



			$this->Cell($w[$i], 4, $varlo[$i], 1, 0, $w1[$i], $fill);
		}

		$this->Ln();
	}
}





$d1 = $_REQUEST['d1'];

$d2 = $_REQUEST['d2'];

$clsi = $_REQUEST['clsi'];

$gp = $_REQUEST['gp'];
$letra = $_REQUEST['ltr'];
$ttex2 = '';
$add1 = '';
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
	$totalg7 = 0;
	$totalg8 = 0;

	if ($gp == 0) :
		$ttex2 = 'Grupo : Todos';
	else :
		$ttex2 = 'Grupo : ' . $gp;
	endif;
	$order = ' IDC';
	$header[0] = 'Ltr';
	$w[0] = 30;
	$w1[0] = 'R';
	$header[1] = 'Nombre';
	$w[1] = 30;
	$w1[1] = 'L';
	$header[2] = 'Saldo';
	$w[2] = 20;
	$w1[2] = 'R';
	$header[3] = 'Part PV';
	$w[3] = 12;
	$w1[3] = 'R';
	$header[4] = 'R.Part.PV';
	$w[4] = 20;
	$w1[4] = 'R';
	$header[5] = 'A Cobrar PV';
	$w[5] = 25;
	$w1[5] = 'R';
	$header[6] = '1% Inter';
	$w[6] = 20;
	$w1[6] = 'R';
	$header[7] = 'A Cobrar Inter';
	$w[7] = 18;
	$w1[7] = 'R';
	$header[8] = 'Apartado 2%';
	$w[8] = 18;
	$w1[8] = 'R';
	$header[9] = 'Resul. Pote';
	$w[9] = 20;
	$w1[9] = 'R';



	if ($gp != 0) :
		$add1 = ' where IDG=' . $gp;
	endif;

	$pdf = new PDF('P', 'mm', 'Legal');
	$pdf->AddPage();
	$pdf->SetAutoPageBreak(true);




	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionario " . $add1 . " Order By " . $order);
	$grupo = 0;
	$fill = 1;
	$totalporcentajeGRUPO = 0;
	$totalParticipacionB = 0;
	$totalParticipacionI = 0;
	while ($row = mysqli_fetch_array($result)) {
		$totalventas = 0;
		$totalpremio = 0;
		$totalventas1 = 0;
		$totalpremio1 = 0;

		$result_grp = mysqli_query($GLOBALS['link'], "SELECT * FROM _tgrupo where IDG=" . $row['IDG']);
		$row_grp = mysqli_fetch_array($result_grp);

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
							$cod = k1escrute(unserialize($row2['escrute']));
						endif;
					else :
						$cod = vescrute($row2['serial']);
					endif;
				else :
					$cod = vescrute($row2['serial']);
				endif;
				////////////////////////////////////////////////////////////////////////////////////////

				$verderecho = explode('*', $row2['Jugada']);
				if (count($verderecho) == 2) :
					$totalventas1 += $row2['ap'];
					if ($cod == true) :
						$totalpremio1 += $row2['acobrar'];
					endif;
				else :
					$totalventas += $row2['ap'];
					if ($cod == true) :
						$totalpremio += $row2['acobrar'];
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

			$aa[0] = $row['IDC'];
			$aa[1] = $row['Nombre'];

			$TotalVENTASG = $totalventas + $totalventas1;
			$TotalPremios = $totalpremio1 + $totalpremio;
			$TotalPorcentajes = $totalgporce + $totalgporce1;

			$Saldo = $TotalVENTASG - $TotalPremios - $TotalPorcentajes;

			$aa[2] = number_format($Saldo, 2, '.', '');
			$totalg1 += $Saldo;

			if ($Saldo < 0) :
				$pr = $pdp1;
			else :
				$pr = $pdp;
			endif;

			$aa[3] = number_format($pr, 2, '.', '') . '%';
			$Parti = ($Saldo * $pr) / 100;
			$aa[4] = number_format($Parti, 2, '.', '');
			$totalg2 += $Parti;

			$aa[5] = number_format($Saldo - $Parti, 2, '.', '');
			$totalg3 += ($Saldo - $Parti);


			$Uno = ($TotalVENTASG * 1) / 100;

			$aa[6] = number_format($Uno, 2, '.', '');
			$totalg4 += $Uno;

			$aa[7] = number_format(($Saldo - $Parti - $Uno), 2, '.', '');
			$totalg5 += ($Saldo - $Parti - $Uno);

			$Dos = ($TotalVENTASG * 2) / 100;

			$aa[8] = number_format($Dos, 2, '.', '');
			$totalg6 += $Dos;

			$aa[9] = number_format(($Saldo - $Parti - $Uno - $Dos), 2, '.', '');
			$totalg7 += ($Saldo - $Parti - $Uno - $Dos);

			////////////////////////////////////////////////////////////////

			if ($totalventas1 != 0 || $totalventas != 0) :
				$pdf->registro($aa, $w, $w1, $fill);
				if ($fill == 0) : $fill = 1;
				else : $fill = 0;
				endif;
			endif;


		else :
			$Npasan[$np] = $row['IDC'];
			$Npasan1[$np] = $row['Nombre'];
			$np++;

		endif;
	}

	$pdf->Ln();

	$aa[0] = '';
	$aa[1] = 'TOTAL GENERAL:';
	$aa[2] = number_format($totalg1, 2, '.', '');
	$aa[3] = '';
	$aa[4] = number_format($totalg2, 2, '.', '');
	$aa[5] = number_format($totalg3, 2, '.', '');
	$aa[6] = number_format($totalg4, 2, '.', '');
	$aa[7] = number_format($totalg5, 2, '.', '');
	$aa[8] = number_format($totalg6, 2, '.', '');
	$aa[9] = number_format($totalg7, 2, '.', '');
	$pdf->registro($aa, $w, $w1, 1);
	$pdf->Ln(5);

	if ($clsi == 1) :
		for ($k = 0; $k <= $np - 1; $k++) {
			$aa[0] = $Npasan[$k];
			$aa[1] = $Npasan1[$k];
			for ($p = 2; $p <= 12; $p++) $aa[$p] = 'S/I';
			$aa[11] = '';
			$pdf->registro($aa, $w, $w1, 1);
		}
	endif;

	$pdf->Ln(5);
	$pdf->SetFont('Arial', 'B', 6);
	$pdf->Ln(8);
	$pdf->Cell(1, 1, date("d-m-y") . " " . date("g:i a"), 1, 0, "L");

	$pdf->Output();

else :

	echo "No Hay Informacion...";

endif;
