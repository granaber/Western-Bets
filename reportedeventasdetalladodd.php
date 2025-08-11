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



	function registro($varlo, $w, $w1)

	{

		$this->SetFont('Arial', 'B', 8);
		$this->Setx(1);
		for ($i = 0; $i < count($varlo); $i++) {
			if ($i == 0) :
				$this->SetFont('Arial', 'B', 6);
			else :
				$this->SetFont('Arial', 'B', 8);
			endif;
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

				$add1 = " where IDC in ('" . $gp . "')";

				$ttex2 = 'Concesionarion : ' . $gp;

			endif;

			break;



		case 2:

			if ($gp != 0) :

				$add1 = " where IDG in (" . $gp . ")";

				$ttex2 = 'Grupo: ' . $gp;

			endif;

			break;
	}



	$header = array();

	$w = array();

	$w1 = array();


	$header[0] = 'Ltr';
	$w[0] = 15;
	$w1[0] = 'R';
	$header[1] = 'Empresa';
	$w[1] = 35;
	$w1[1] = 'L';
	$header[2] = 'Dia-Fecha';
	$w[2] = 25;
	$w1[2] = 'R';
	$header[3] = 'Ventas';
	$w[3] = 18;
	$w1[3] = 'R';
	$header[4] = 'Premios';
	$w[4] = 18;
	$w1[4] = 'R';
	$header[5] = '%';
	$w[5] = 15;
	$w1[5] = 'R';
	$header[6] = 'Diferencia';
	$w[6] = 18;
	$w1[6] = 'R';
	$header[7] = '%Part.P.V';
	$w[7] = 15;
	$w1[7] = 'R';
	$header[8] = 'Monto P.V.';
	$w[8] = 18;
	$w1[8] = 'R';
	$header[9] = '%Part.Ban.';
	$w[9] = 20;
	$w1[9] = 'R';
	$header[10] = 'Mon.Banca';
	$w[10] = 18;
	$w1[10] = 'R';
	$header[11] = 'A';
	$w[11] = 2;
	$w1[11] = 'C';
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
		$totalgparticipacion1 = 0;
		$totalventas1 = 0;
		$totalpremio1 = 0;
		$primerdia = 0;
		$seccion = 1;
		$dpm = true;

		$result2 = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tjugadabb  where IDC='" . $row['IDC'] . "'    and activo=1 " . $add . " Order By IDJ");
		//echo "SELECT *  FROM _tjugadabb  where IDC='".$row['IDC']."'    and activo=1 ".$add." Order By IDJ" ;
		if (mysqli_num_rows($result2) != 0) :
			while ($row2 = mysqli_fetch_array($result2)) {
				if ($primerdia != $row2['IDJ']) :
					if ($primerdia != 0) :
						if ($dpm) :
							$aa[0] = $row['IDC'];
							$aa[1] = $row['Nombre'];
							$dpm = false;
						else :
							$aa[0] = '';
							$aa[1] = '';
						endif;

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
							$mm = asignacion($totalventas, $row['IDC']);
						else :

							$mm = ($totalventas * $pdv) / 100;
						endif;
						if ($pdv1 == -3) :
							$mm1 = 0;
						else :
							$mm1 = ($totalventas1 * $pdv1) / 100;
						endif;

						$resultdf = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where IDJ=" . $primerdia);
						if (mysqli_num_rows($resultdf) != 0) :
							$row3 = mysqli_fetch_array($resultdf);
							$fch = $row3['Fecha'];
						else :
							$fch = '';
						endif;

						/*Jugada Por Derecho*/
						$aa[2] = fecha_dia($fch) . ' ' . $fch . '**';
						$aa[3] = number_format($totalventas1, 2, '.', '');
						$aa[4] = number_format($totalpremio1, 2, '.', '');
						$aa[5] = number_format($mm1, 2, '.', '');
						$aa[6] = number_format((($totalventas1 - $aa[5]) - $totalpremio1), 2, '.', '');


						if ($aa[6] < 0) :
							$aa[7] = "(" . number_format($pdp1, 2, '.', '') . "%)";
							$aa[8] = number_format(($aa[6] * $pdp1) / 100, 2, '.', '');
							$aa[9] = "(" . number_format(100 - $pdp1, 2, '.', '') . "%)";
							$aa[10] = number_format(($aa[6] * (100 - $pdp1)) / 100, 2, '.', '');
							$w1[10] = 'R';
						else :
							$aa[7] = "(" . number_format($pdp, 2, '.', '') . "%)";
							$aa[8] = number_format(($aa[6] * $pdp) / 100, 2, '.', '');
							$aa[9] = "(" . number_format(100 - $pdp, 2, '.', '') . "%)";
							$aa[10] = number_format(($aa[6] * (100 - $pdp)) / 100, 2, '.', '');
							$w1[10] = 'R';
						endif;

						$totalgparticipacion += $aa[8];
						$totalgparticipacion1 += $aa[10];
						$totalgventas += $aa[3];
						$totalgpremios += $aa[4];
						$totalgporce += $aa[5];
						$totalgtotal += $aa[6];
						$aa[11] = 'D';
						$pdf->registro($aa, $w, $w1);

						/*Jugada Parlay*/
						$aa[0] = '';
						$aa[1] = '';
						$aa[2] = '';
						$aa[3] = number_format($totalventas, 2, '.', '');
						$aa[4] = number_format($totalpremio, 2, '.', '');
						$aa[5] = number_format($mm, 2, '.', ''); //($totalventas*$pdv)/100

						$aa[6] = number_format((($totalventas - $aa[5]) - $totalpremio), 2, '.', '');

						if ($aa[6] < 0) :
							$aa[7] = "(" . number_format($pdp1, 2, '.', '') . "%)";
							$aa[8] = number_format(($aa[6] * $pdp1) / 100, 2, '.', '');
							$aa[9] = "(" . number_format(100 - $pdp1, 2, '.', '') . "%)";
							$aa[10] = number_format(($aa[6] * (100 - $pdp1)) / 100, 2, '.', '');
							$w1[10] = 'R';
						else :
							$aa[7] = "(" . number_format($pdp, 2, '.', '') . "%)";
							$aa[8] = number_format(($aa[6] * $pdp) / 100, 2, '.', '');
							$aa[9] = "(" . number_format(100 - $pdp, 2, '.', '') . "%)";
							$aa[10] = number_format(($aa[6] * (100 - $pdp)) / 100, 2, '.', '');
							$w1[10] = 'R';
						endif;

						$totalgparticipacion += $aa[8];
						$totalgparticipacion1 += $aa[10];
						$totalgventas += $aa[3];
						$totalgpremios += $aa[4];
						$totalgporce += $aa[5];
						$totalgtotal += $aa[6];
						$aa[11] = 'P';
						$pdf->registro($aa, $w, $w1);
					endif;



					$primerdia = $row2['IDJ'];

					$totalventas = 0;
					$totalpremio = 0;
					$totalventas1 = 0;
					$totalpremio1 = 0;

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
						$totalpremio1 += $cod['acobrar'];
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

					$aa[0] = $row['IDC'];

					$aa[1] = $row['Nombre'];

					$dpm = false;

				else :

					$aa[0] = '';

					$aa[1] = '';

				endif;



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
					$mm = asignacion($totalventas, $row['IDC']);
				else :

					$mm = ($totalventas * $pdv) / 100;
				endif;
				if ($pdv1 == -3) :
					$mm1 = 0;
				else :
					$mm1 = ($totalventas1 * $pdv1) / 100;
				endif;

				$resultdf = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where IDJ=" . $primerdia);
				if (mysqli_num_rows($resultdf) != 0) :
					$row3 = mysqli_fetch_array($resultdf);
					$fch = $row3['Fecha'];
				else :
					$fch = '';
				endif;

				/*Jugada Por Derecho*/
				$aa[2] = fecha_dia($fch) . ' ' . $fch . '**';
				$aa[3] = number_format($totalventas1, 2, '.', '');
				$aa[4] = number_format($totalpremio1, 2, '.', '');
				$aa[5] = number_format($mm1, 2, '.', '');
				$aa[6] = number_format((($totalventas1 - $aa[5]) - $totalpremio1), 2, '.', '');


				if ($aa[6] < 0) :
					$aa[7] = "(" . number_format($pdp1, 2, '.', '') . "%)";
					$aa[8] = number_format(($aa[6] * $pdp1) / 100, 2, '.', '');
					$aa[9] = "(" . number_format(100 - $pdp1, 2, '.', '') . "%)";
					$aa[10] = number_format(($aa[6] * (100 - $pdp1)) / 100, 2, '.', '');
					$w1[10] = 'R';
				else :
					$aa[7] = "(" . number_format($pdp, 2, '.', '') . "%)";
					$aa[8] = number_format(($aa[6] * $pdp) / 100, 2, '.', '');
					$aa[9] = "(" . number_format(100 - $pdp, 2, '.', '') . "%)";
					$aa[10] = number_format(($aa[6] * (100 - $pdp)) / 100, 2, '.', '');
					$w1[10] = 'R';
				endif;

				$totalgparticipacion += $aa[8];
				$totalgparticipacion1 += $aa[10];
				$totalgventas += $aa[3];
				$totalgpremios += $aa[4];
				$totalgporce += $aa[5];
				$totalgtotal += $aa[6];
				$aa[11] = 'D';
				$pdf->registro($aa, $w, $w1);

				/*Jugada Parlay*/
				$aa[0] = '';
				$aa[1] = '';
				$aa[2] = '';
				$aa[3] = number_format($totalventas, 2, '.', '');
				$aa[4] = number_format($totalpremio, 2, '.', '');
				$aa[5] = number_format($mm, 2, '.', ''); //($totalventas*$pdv)/100

				$aa[6] = number_format((($totalventas - $aa[5]) - $totalpremio), 2, '.', '');

				if ($aa[6] < 0) :
					$aa[7] = "(" . number_format($pdp1, 2, '.', '') . "%)";
					$aa[8] = number_format(($aa[6] * $pdp1) / 100, 2, '.', '');
					$aa[9] = "(" . number_format(100 - $pdp1, 2, '.', '') . "%)";
					$aa[10] = number_format(($aa[6] * (100 - $pdp1)) / 100, 2, '.', '');
					$w1[10] = 'R';
				else :
					$aa[7] = "(" . number_format($pdp, 2, '.', '') . "%)";
					$aa[8] = number_format(($aa[6] * $pdp) / 100, 2, '.', '');
					$aa[9] = "(" . number_format(100 - $pdp, 2, '.', '') . "%)";
					$aa[10] = number_format(($aa[6] * (100 - $pdp)) / 100, 2, '.', '');
					$w1[10] = 'R';
				endif;

				$totalgparticipacion += $aa[8];
				$totalgparticipacion1 += $aa[10];
				$totalgventas += $aa[3];
				$totalgpremios += $aa[4];
				$totalgporce += $aa[5];
				$totalgtotal += $aa[6];
				$aa[11] = 'P';
				$pdf->registro($aa, $w, $w1);

				$lnn = $pdf->Gety();



				$pdf->line(0, $lnn, 340, $lnn);


				/*	$resultdf = mysqli_query($GLOBALS['link'],"SELECT *  FROM _tconsecionariodd  where IDC='".$row['IDC']."'");
	 			if(mysqli_num_rows($resultdf)!=0):
	 				$row3 = mysqli_fetch_array($resultdf);
	 				$pdp=$row3['Participacion1'];$pdv=$row3['pVentas'];$pdp1=$row3['Participacion2'];
					if ($row3['tipodev']==1):
						$pdv=$row3['pVentas'];
						$pdv1=$row3['pVentaspd'];
					else:
						$pdv=-3;
						if ($row3['porcentajextablad']==0):
							$pdv1=-3;
						else:
							$pdv1=$row3['porcentajextablad'];
						endif;
					endif;
				 else:
	 				$pdp=0;$pdp1=0;$pdv1=0;$pdv=0;
				endif;

				if ($pdv==-3):
		     	  	$totalgporce=asignacion($totalventas,$row['IDC']);
				else:
					$totalgporce=($totalventas*$pdv)/100;
    		    endif;
				if ($pdv1==-3):
		 			 $totalgporce1=0;
				else:
					$totalgporce1=($totalventas1*$pdv1)/100;
				endif; */




				$aa[1] = '';

				$aa[2] = 'Total Generals:';

				$aa[3] = number_format($totalgventas, 2, '.', '');

				$aa[4] = number_format($totalgpremios, 2, '.', '');

				$aa[5] = number_format($totalgporce, 2, '.', '');

				$totaldiferencia = $totalgventas  -  (($totalgporce) + $totalgpremios);

				$aa[6] = number_format($totaldiferencia, 2, '.', '');

				$aa[7] = '';
				if ($totaldiferencia < 0) :
					$aa[8] = number_format(($totaldiferencia * $pdp1) / 100, 2, '.', '');

					$aa[9] = '';

					$aa[10] = number_format(($totaldiferencia * (100 - $pdp1)) / 100, 2, '.', '');
					$w1[10] = 'R';

				else :

					$aa[8] = number_format(($totaldiferencia * $pdp) / 100, 2, '.', '');

					$aa[9] = '';

					$aa[10] = number_format(($totaldiferencia * (100 - $pdp)) / 100, 2, '.', '');
					$w1[10] = 'R';
				endif;
				$aa[11] = '';
				$pdf->registro($aa, $w, $w1);

				$pdf->Ln();

			endif;

		else :

			$aa[0] = $row['IDC'];
			$aa[1] = $row['Nombre'];
			for ($k = 2; $k <= 10; $k++) $aa[$k] = 'S/I';
			$aa[11] = '';
			$pdf->registro($aa, $w, $w1);
			$pdf->Ln();

		endif;
	}

	$pdf->Ln(5);
	$pdf->SetFont('Arial', 'B', 8);
	//$pdf->Cell(1,1,' **El Porcentaje no esta incluido en la Diferencia, solamente se toma en cuenta en el Total General. D = Jugada por Derecho, P = Jugada Parlay',1,0,"L");
	$pdf->SetFont('Arial', 'B', 4);
	$pdf->Ln(8);
	$pdf->Cell(1, 1, date("d-m-y") . " " . date("g:i a"), 1, 0, "L");

	$pdf->Output();

else :

	echo "No Hay Informacion...";

endif;
