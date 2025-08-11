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

		$this->text(10, 7, 'Reporte Detallado de Ventas Deporte x Dias');

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



	function registro($varlo, $w, $w1)

	{

		$this->SetFont('Arial', 'B', 7);

		$this->Setx(1);

		for ($i = 0; $i < count($varlo); $i++) {



			$this->Cell($w[$i], 4, $varlo[$i], 0, 0, $w1[$i]);
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

if (true) :


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
	$add = "and  (" . $verdatos . " ) ";



	$ttex = " Desde : " . $d1 . " Hasta: " . $d2;





	$xpp = 170;



	$add1 = '';



	switch ($clsi) {

		case 1:

			if ($gp != "0") :

				$add1 = " where IDC='" . $gp . "'";

				$ttex2 = 'Concesionarion : ' . $gp;

			endif;

			break;
	}











	$header = array();

	$w = array();

	$w1 = array();











	$header[0] = 'Dia-Fecha';
	$w[0] = 20;
	$w1[0] = 'R';

	$header[1] = 'Ventas';
	$w[1] = 25;
	$w1[1] = 'R';

	$header[2] = 'Premios';
	$w[2] = 25;
	$w1[2] = 'R';

	$header[3] = '%';
	$w[3] = 17;
	$w1[3] = 'R';

	$header[4] = 'Total';
	$w[4] = 25;
	$w1[4] = 'R';

	$header[5] = 'Ventas-%';
	$w[5] = 25;
	$w1[5] = 'R';

	$header[6] = 'Premios+%';
	$w[6] = 25;
	$w1[6] = 'R';

	$header[7] = 'Diferencia';
	$w[7] = 25;
	$w1[7] = 'R';

	$header[8] = 'Participacion';
	$w[8] = 30;
	$w1[8] = 'L';



	$pdf = new PDF('P', 'mm', 'Legal');



	$pdf->AddPage();

	$pdf->SetAutoPageBreak(true);





	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionario " . $add1 . " Order By IDC");







	while ($row = mysqli_fetch_array($result)) {

		$totalgventas = 0;

		$totalgpremios = 0;

		$totalgporce = 0;

		$totalgtotal = 0;

		$totalgventaprocen = 0;

		$totalgpremioprocen = 0;

		$totalgdiferencia = 0;

		$totalgparticipacion = 0;

		$primerdia = 0;

		$dpm = true;

		$result2 = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tjugadabb  where IDC='" . $row['IDC'] . "'    and activo=1 " . $add . " Order By IDJ");


		// echo ("SELECT *  FROM _tjugadabb  where IDC='".$row['IDC']."'    and activo=1 ".$add." Order By IDJ" );


		while ($row2 = mysqli_fetch_array($result2)) {

			if ($primerdia != $row2['IDJ']) :

				if ($primerdia != 0) :

					if ($dpm) :

						$dpm = false;

					endif;



					$resultdf = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tconsecionariodd  where IDC='" . $row['IDC'] . "'");

					if (mysqli_num_rows($resultdf) != 0) :

						$row3 = mysqli_fetch_array($resultdf);

						$pdp = $row3['Participacion1'];
						$pdp1 = $row3['Participacion2'];
						if ($row3['tipodev'] == 1) :
							$pdv = $row3['pVentas'];
							$pdv1 = $row3['pVentaspd'];
						else :
							$pdv = -3;
							$pdv1 = -3;
							$mm = asignacion($totalventas, $row['IDC']);
						/*$mm1=asignacion($totalventas1,$row['IDC']);*/
						endif;

					else :

						$pdp = 0;
						$pdv = 0;
						$pdp1 = 0;

					endif;



					$resultdf = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where IDJ=" . $primerdia);



					if (mysqli_num_rows($resultdf) != 0) :

						$row3 = mysqli_fetch_array($resultdf);

						$fch = $row3['Fecha'];

					else :

						$fch = '';

					endif;

					if ($pdv == -3) :
						$mm = asignacion($totalventas, $row['IDC']);
					else :
						$mm = ($totalventas * $pdv) / 100;
					endif;
					if ($pdv1 == -3) :
						$mm1 = 0;
					else :
						$mm1 = ($totalventas1 * $pdv1) / 100;
					endif;

					$aa[0] = fecha_dia($fch) . ' ' . $fch;

					$aa[1] = number_format($totalventas + $totalventas1, 2, '.', '');

					$aa[2] = number_format($totalpremio, 2, '.', '');

					$aa[3] = number_format($mm + $mm1, 2, '.', '');




					$aa[4] = number_format(((($totalventas + $totalventas1) - $aa[3]) - $totalpremio), 2, '.', '');

					$aa[5] = number_format(($totalventas + $totalventas1) - $aa[3], 2, '.', '');

					$aa[6] = number_format($totalpremio + $aa[3], 2, '.', '');

					$aa[7] = number_format($aa[5] - $aa[6], 2, '.', '');

					if (((($totalventas + $totalventas1) - $aa[3]) - $totalpremio) < 0) :

						$pr = $pdp1;

					else :

						$pr = $pdp;

					endif;

					$aa[8] = "(" . number_format($pr, 2, '.', '') . "%) " . number_format(($aa[4] * $pr) / 100, 2, '.', '');
					$w1[8] = 'L';



					$totalgventas += $aa[1];

					$totalgpremios += $aa[2];

					$totalgporce += $aa[3];

					$totalgtotal += $aa[4];

					$totalgventaprocen += $aa[5];

					$totalgpremioprocen += $aa[6];

					$totalgdiferencia += $aa[7];

					$totalgparticipacion += ($aa[4] * $pr) / 100;





					$pdf->registro($aa, $w, $w1);
					$totalventas = 0;
					$totalventas1 = 0;

				endif;



				$primerdia = $row2['IDJ'];

				$totalventas = 0;
				$totalpremio = 0;

			endif;

			////////////////////////////////////////////////////////////////////////////////////////
			$resultOpen = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tbcierresemana  where IDJ=" . $row2['IDJ']);
			if (mysqli_num_rows($resultOpen) != 0) :
				$rowOpen = mysqli_fetch_array($resultOpen);
				if ($rowOpen['Cierre'] == 1) :
					if ($row2['escrute'] == '') :
						$cod = mescrute($row2['serial']);
					else :
						$cod = kescrute(unserialize($row2['escrute']), $row2['acobrar']);
					endif;
				else :
					$cod = mescrute($row2['serial']);
				endif;
			else :
				$cod = mescrute($row2['serial']);
			endif;
			////////////////////////////////////////////////////////////////////////////////////////


			$verderecho = explode('*', $row2['Jugada']);
			if (count($verderecho) == 2) :
				$totalventas1 += $row2['ap'];

				if ($cod['condicion'] == true) :
					$totalpremio += $cod['acobrar'];
				endif;
			else :
				$totalventas += $row2['ap'];

				if ($cod['condicion'] == true) :
					$totalpremio += $cod['acobrar'];
				endif;
			endif;
		}



		if ($primerdia != 0) :

			if ($dpm) :

				$dpm = false;

			endif;



			$resultdf = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tconsecionariodd  where IDC='" . $row['IDC'] . "'");

			if (mysqli_num_rows($resultdf) != 0) :

				$row3 = mysqli_fetch_array($resultdf);

				$pdp = $row3['Participacion1'];
				$pdp1 = $row3['Participacion2'];

				if ($row3['tipodev'] == 1) :
					$pdv = $row3['pVentas'];
					$pdv1 = $row3['pVentaspd'];
				else :
					$pdv = -3;
					$pdv1 = -3;
					$mm = asignacion($totalventas, $row['IDC']);
				/*$mm1=asignacion($totalventas1,$row['IDC']);*/
				endif;

			else :

				$pdp = 0;
				$pdv = 0;
				$pdp1 = 0;

			endif;

			$resultdf = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where IDJ=" . $primerdia);



			if (mysqli_num_rows($resultdf) != 0) :

				$row3 = mysqli_fetch_array($resultdf);

				$fch = $row3['Fecha'];

			else :

				$fch = '';

			endif;

			if ($pdv == -3) :
				$mm = asignacion($totalventas, $row['IDC']);
			else :
				$mm = ($totalventas * $pdv) / 100;
			endif;
			if ($pdv1 == -3) :
				$mm1 = 0;
			else :
				$mm1 = ($totalventas1 * $pdv1) / 100;
			endif;

			$aa[0] = fecha_dia($fch) . ' ' . $fch;

			$aa[1] = number_format($totalventas + $totalventas1, 2, '.', '');

			$aa[2] = number_format($totalpremio, 2, '.', '');

			$aa[3] = number_format($mm + $mm1, 2, '.', '');




			$aa[4] = number_format(((($totalventas + $totalventas1) - $aa[3]) - $totalpremio), 2, '.', '');

			$aa[5] = number_format(($totalventas + $totalventas1) - $aa[3], 2, '.', '');

			$aa[6] = number_format($totalpremio + $aa[3], 2, '.', '');

			$aa[7] = number_format($aa[5] - $aa[6], 2, '.', '');

			if (((($totalventas + $totalventas1) - $aa[3]) - $totalpremio) < 0) :

				$pr = $pdp1;

			else :

				$pr = $pdp;

			endif;

			$aa[8] = "(" . number_format($pr, 2, '.', '') . "%) " . number_format(($aa[4] * $pr) / 100, 2, '.', '');
			$w1[8] = 'L';



			$totalgventas += $aa[1];

			$totalgpremios += $aa[2];

			$totalgporce += $aa[3];

			$totalgtotal += $aa[4];

			$totalgventaprocen += $aa[5];

			$totalgpremioprocen += $aa[6];

			$totalgdiferencia += $aa[7];

			$totalgparticipacion += ($aa[4] * $pr) / 100;



			$pdf->registro($aa, $w, $w1);

			$lnn = $pdf->Gety();



			$pdf->line(0, $lnn, 340, $lnn);



			$aa[0] = 'Total General:';

			$aa[1] = number_format($totalgventas, 2, '.', '');

			$aa[2] = number_format($totalgpremios, 2, '.', '');

			$aa[3] = number_format($totalgporce, 2, '.', '');

			$aa[4] = number_format($totalgtotal, 2, '.', '');

			$aa[5] = number_format($totalgventaprocen, 2, '.', '');

			$aa[6] = number_format($totalgpremioprocen, 2, '.', '');

			$aa[7] = number_format($totalgdiferencia, 2, '.', '');

			$aa[8] = number_format($totalgparticipacion, 2, '.', '');
			$w1[10] = 'R';

			$pdf->registro($aa, $w, $w1);

			$pdf->Ln();

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

else :

	echo "No Hay Informacion...";

endif;
