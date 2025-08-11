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

$ttex2 = '';







$add = '';

if (true) :



	$add = "and  IDJ In (Select IDJ From _jornadabb Where STR_TO_DATE(Fecha,'%d/%m/%Y') BETWEEN STR_TO_DATE('" . $d1 . "','%d/%m/%Y') and STR_TO_DATE('" . $d2 . "','%d/%m/%Y')) ";



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


	$totalg1 = 0;
	$totalg2 = 0;
	$totalg3 = 0;
	$totalg4 = 0;
	$totalg5 = 0;
	$totalg6 = 0;




	$header[0] = 'Ltr';
	$w[0] = 15;
	$w1[0] = 'R';
	$header[1] = 'Empresa';
	$w[1] = 40;
	$w1[1] = 'L';
	$header[2] = 'A';
	$w[2] = 5;
	$w1[2] = 'C';
	$header[3] = 'Ventas Bs.F.';
	$w[3] = 20;
	$w1[3] = 'R';
	$header[4] = '% Ventas';
	$w[4] = 15;
	$w1[4] = 'R';
	$header[5] = 'Premios Bs.F.';
	$w[5] = 20;
	$w1[5] = 'R';
	$header[6] = 'Sub. Total';
	$w[6] = 20;
	$w1[6] = 'R';
	$header[7] = '% Banca';
	$w[7] = 15;
	$w1[7] = 'R';
	$header[8] = 'Res.Banca';
	$w[8] = 20;
	$w1[8] = 'R';
	$header[9] = '% P.V.';
	$w[9] = 15;
	$w1[9] = 'R';
	$header[10] = 'Res.P.V.';
	$w[10] = 20;
	$w1[10] = 'R';

	$i = 0;
	$pdf = new PDF('P', 'mm', 'Letter');
	$pdf->AddPage();
	$pdf->SetAutoPageBreak(true);
	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionario " . $add1 . " Order By IDC");
	while ($row = mysqli_fetch_array($result)) {

		$totalventas = 0;
		$totalpremio = 0;
		$totalventas1 = 0;
		$totalpremio1 = 0;

		$result2 = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tjugadabb  where IDC='" . $row['IDC'] . "'    and activo=1 " . $add);
		/*  if(mysqli_num_rows($result2)==0):
	     $result2 = mysqli_query($GLOBALS['link'],"SELECT *  FROM _tjugadabbbk  where IDC='".$row['IDC']."'    and activo=1 ".$add." Order By IDJ" );
	endif; */
		if (mysqli_num_rows($result2) != 0) :
			$row2 = mysqli_fetch_array($result2);
			$resultcierre = mysqli_query($GLOBALS['link'], "SELECT * FROM _cierreescrute where IDJ=" . $row2['IDJ']);
			$pasar = true;
			if (mysqli_num_rows($resultcierre) == 0) : $pasar = false;
			endif;
			if ($pasar) :
				/// Calculo los premios Parlay
				$result2 = mysqli_query($GLOBALS['link'], "SELECT  sum(acobrar) as premios FROM _tjugadabb  where  premiado=1 and tipojugada=2  and IDC='" . $row['IDC'] . "'    and activo=1 " . $add);
				$row2 = mysqli_fetch_array($result2);
				$totalpremio += $row2['premios'];
				/// Calculo los premios Derecho
				$result2 = mysqli_query($GLOBALS['link'], "SELECT  sum(acobrar) as premios FROM _tjugadabb  where  premiado=1 and tipojugada=1  and IDC='" . $row['IDC'] . "'    and activo=1 " . $add);
				$row2 = mysqli_fetch_array($result2);
				$totalpremio1 += $row2['premios'];
				/// Calculo de Pago Parlay
				$result2 = mysqli_query($GLOBALS['link'], "SELECT  sum(ap) as parlay FROM _tjugadabb  where  tipojugada=2 and IDC='" . $row['IDC'] . "'    and activo=1 " . $add);
				$row2 = mysqli_fetch_array($result2);
				$totalventas += $row2['parlay'];
				/// Calculo de Pago por Derecho
				$result2 = mysqli_query($GLOBALS['link'], "SELECT  sum(ap) as derecho  FROM _tjugadabb  where  tipojugada=1 and IDC='" . $row['IDC'] . "'    and activo=1 " . $add);
				$row2 = mysqli_fetch_array($result2);
				$totalventas1 += $row2['derecho'];
			else :
				while ($row2 = mysqli_fetch_array($result2)) {
					if ($row2['tipojugada'] == 1) :
						$totalventas1 += $row2['ap'];
						if (vescrute($row2['serial']) == true) :
							$totalpremio1 += $row2['acobrar'];
						endif;
					else :
						$totalventas += $row2['ap'];
						if (vescrute($row2['serial']) == true) :
							$totalpremio += $row2['acobrar'];
						endif;
					endif;
				}
			endif;
			$result2 = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tconsecionariodd  where IDC='" . $row['IDC'] . "'");

			if (mysqli_num_rows($result2) != 0) :

				$row2 = mysqli_fetch_array($result2);

				$pdp = $row2['Participacion1'];
				$pdp1 = $row2['Participacion2'];
				if ($row2['tipodev'] == 1) :
					$pdv = $row2['pVentas'];
					$pdv1 = $row2['pVentaspd'];
				else :
					$pdv = -3;
					$pdv1 = -3;
					$mm = asignacion($totalventas, $row['IDC']);
					$mm1 = asignacion($totalventas1, $row['IDC']);
				endif;

			else :

				$pdp = 0;
				$pdv = 0;
				$pdp1 = 0;
				$pdv1 = 0;

			endif;

			$aa[0] = $row['IDC'];

			$aa[1] = $row['Nombre'];
			$aa[2] = 'D';

			$aa[3] = number_format($totalventas1, 2, '.', '');

			if ($pdv1 == -3) :
				$aa[4] = number_format($mm1, 2, '.', '');
			else :
				$aa[4] = number_format(($totalventas1 * $pdv1) / 100, 2, '.', '');
			endif;

			$aa[5] = number_format($totalpremio1, 2, '.', '');

			$aa[6] = number_format(($totalventas1 - $aa[4]) - $totalpremio1, 2, '.', '');

			if ((($totalventas1 - $aa[4]) - $totalpremio1) < 0) :

				$pr = $pdp1;

			else :

				$pr = $pdp;

			endif;

			$aa[7] = number_format((100 - $pr), 2, '.', '');

			$aa[8] = number_format(($aa[6] * $aa[7]) / 100, 2, '.', '');

			$aa[9] = number_format($pr, 2, '.', '');

			$aa[10] = number_format($aa[6] - $aa[8], 2, '.', '');

			$total3 = $aa[3];
			$total4 = $aa[4];
			$total5 = $aa[5];
			$total6 = $aa[6];
			$total7 = $aa[7];
			$total8 = $aa[8];
			$total9 = $aa[9];
			$total10 = $aa[10];


			if ($totalventas1 != 0 || $totalventas != 0) :

				$pdf->registro($aa, $w, $w1, 0);

			endif;



			$aa[0] = '';

			$aa[1] = '';
			$aa[2] = 'P';

			$aa[3] = number_format($totalventas, 2, '.', '');

			if ($pdv == -3) :
				$aa[4] = number_format($mm, 2, '.', '');
			else :
				$aa[4] = number_format(($totalventas * $pdv) / 100, 2, '.', '');
			endif;


			$aa[5] = number_format($totalpremio, 2, '.', '');

			$aa[6] = number_format(($totalventas - $aa[4]) - $totalpremio, 2, '.', '');

			if ((($totalventas - $aa[4]) - $totalpremio) < 0) :
				$pr = $pdp1;
			else :
				$pr = $pdp;
			endif;

			$aa[7] = number_format((100 - $pr), 2, '.', '');

			$aa[8] = number_format(($aa[6] * $aa[7]) / 100, 2, '.', '');

			$aa[9] = number_format($pr, 2, '.', '');

			$aa[10] = number_format($aa[6] - $aa[8], 2, '.', '');

			$total3 += $aa[3];
			$total4 += $aa[4];
			$total5 += $aa[5];
			$total6 += $aa[6];
			$total7 += $aa[7];
			$total8 += $aa[8];
			$total9 += $aa[9];
			$total10 += $aa[10];


			$totalg1 += $total3;
			$totalg2 += $total4;
			$totalg3 += $total5;
			$totalg4 += $total6;
			$totalg5 += $total8;
			$totalg6 += $total10;

			if ($totalventas1 != 0 || $totalventas != 0) :

				$pdf->registro($aa, $w, $w1, 0);

			endif;

			$aa[0] = '';

			$aa[1] = '';
			$aa[2] = 'T';

			$aa[3] = number_format($total3, 2, '.', '');

			$aa[4] = number_format($total4, 2, '.', '');

			$aa[5] = number_format($total5, 2, '.', '');

			$aa[6] = number_format($total6, 2, '.', '');

			$aa[7] = '';

			$aa[8] = number_format($total8, 2, '.', '');

			$aa[9] = '';

			$aa[10] = number_format($total10, 2, '.', '');

			if ($totalventas1 != 0 || $totalventas != 0) :

				$pdf->registro($aa, $w, $w1, 1);

			endif;
		endif;
		//if ($i==5): break; else: $i++; endif;
	}

	$pdf->Ln();

	$aa[0] = '';

	$aa[1] = 'TOTAL GENERAL:';
	$aa[2] = 'TG';

	$aa[3] = number_format($totalg1, 2, '.', '');

	$aa[4] = number_format($totalg2, 2, '.', '');

	$aa[5] = number_format($totalg3, 2, '.', '');

	$aa[6] = number_format($totalg4, 2, '.', '');

	$aa[7] = '';

	$aa[8] = number_format($totalg5, 2, '.', '');

	$aa[9] = '';

	$aa[10] = number_format($totalg6, 2, '.', '');

	$pdf->registro($aa, $w, $w1, 1);

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
