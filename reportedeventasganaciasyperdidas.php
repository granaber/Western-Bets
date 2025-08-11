<?php
ini_set('display_errors', 'On');
ini_set('log_errors', 'On');
ini_set('error_log', 'error.log');
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require 'prc_php.php';
$link = Connection::getInstance();
require 'fpdf.php';
class PDF extends FPDF
{

	public function Header()
	{

		global $xpp;

		global $tt;

		global $ttex;

		global $ttex2;

		global $header;

		global $w;

		global $w1;

		global $conces;

		$this->Sety(0);

		$this->Setx(0);

		$this->SetFont('Arial', 'I', 7);

		$this->text(10, 7, 'Reporte entre Fechas de Ganacias y Perdidas Detallado');

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

		// $this->Cell(30, 3, 'Hora:' . date("g:i a"));

		$this->rect(($xpp) - 1, 8, 39, 12, 'D');

		//**********************************

		$this->Ln();

		$this->Ln();

		$this->Ln();

		$this->SetFont('Arial', 'B', 8);

		$this->Setx(1);

		$this->Cell(30, 3, 'Concesionario:' . $conces);

		$this->Ln();

		$this->Setx(1);

		for ($i = 0; $i < count($header); $i++) {
			$this->Cell($w[$i], 3, $header[$i], 1, 0, $w1[$i]);
		}

		$this->Ln();
	}

	public function registro($varlo, $w, $w1)
	{

		$this->SetFont('Arial', 'B', 8);

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

	$result = mysqli_query($link, "Select IDJ From _jornadabb Where STR_TO_DATE(Fecha,'%d/%m/%Y') BETWEEN STR_TO_DATE('" . $d1 . "','%d/%m/%Y') and STR_TO_DATE('" . $d2 . "','%d/%m/%Y') Group by IDJ Order by IDJ");

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

				$ttex2 = '';

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

	$header[0] = 'Dia-Fecha';
	$w[0] = 25;
	$w1[0] = 'R';

	$header[1] = 'Ganacia';
	$w[1] = 30;
	$w1[1] = 'R';

	$header[2] = 'Perdidas';
	$w[2] = 30;
	$w1[2] = 'R';

	$pdf = new PDF('P', 'mm', 'Legal');

	$inicio = true;

	$pdf->SetAutoPageBreak(true);
	$pdf->AddPage();
	$result = mysqli_query($link, "SELECT * FROM _tconsecionario " . $add1 . " Order By IDC");

	while ($row = mysqli_fetch_array($result)) {

		$primerdia = 0;
		$dpm = true;
		$totalganacias = 0;
		$totalperdidas = 0;
		$totalgeneral = 0;
		$conces = $row['IDC'];
		$result2 = mysqli_query($link, "SELECT *  FROM _tjugadabb  where IDC='" . $row['IDC'] . "'    and activo=1 " . $add . " Order By IDJ");
		if (mysqli_num_rows($result2) != 0) :
			$pdf->AddPage();
		endif;
		while ($row2 = mysqli_fetch_array($result2)) {
			if ($primerdia != $row2['IDJ']) :
				if ($primerdia != 0) :
					$resultdf = mysqli_query($link, "SELECT *  FROM _tconsecionariodd  where IDC='" . $row['IDC'] . "'");
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

					$resultdf = mysqli_query($link, "SELECT * FROM _jornadabb where IDJ=" . $primerdia);
					if (mysqli_num_rows($resultdf) != 0) :
						$row3 = mysqli_fetch_array($resultdf);
						$fch = $row3['Fecha'];
					else :
						$fch = '';
					endif;
					$aa[0] = fecha_dia($fch) . ' ' . $fch;

					if ($pdv1 == -3 || $pdv == -3) :
						$ganacias1 = ($totalventas1 - ($mm1 + $totalpremio1));
						$ganacias2 = ($totalventas - ($mm + $totalpremio));
					else :
						$ganacias1 = ($totalventas1 - (($totalventas1 * $pdv1) / 100) - $totalpremio1);
						$ganacias2 = ($totalventas - (($totalventas * $pdv) / 100) - $totalpremio);
					endif;

					$totalgeneral = $ganacias1 + $ganacias2;

					if ($totalgeneral >= 0) :
						$aa[1] = number_format($totalgeneral, 2, ',', '.');
						$totalganacias += $totalgeneral;
						$aa[2] = '';
					endif;
					if ($totalgeneral < 0) :
						$aa[2] = number_format($totalgeneral, 2, ',', '.');
						$totalperdidas += $totalgeneral;
						$aa[1] = '';
					endif;
					$pdf->registro($aa, $w, $w1);
					$totalgeneral = 0;
				endif;
				$primerdia = $row2['IDJ'];
				$totalventas = 0;
				$totalpremio = 0;
				$totalventas1 = 0;
				$totalpremio1 = 0;
			endif;
			////////////////////////////////////////////////////////////////////////////////////////
			$resultOpen = mysqli_query($link, "SELECT *  FROM _tbcierresemana  where IDJ=" . $row2['IDJ']);
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
			$resultdf = mysqli_query($link, "SELECT *  FROM _tconsecionariodd  where IDC='" . $row['IDC'] . "'");
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

			$resultdf = mysqli_query($link, "SELECT * FROM _jornadabb where IDJ=" . $primerdia);

			if (mysqli_num_rows($resultdf) != 0) :
				$row3 = mysqli_fetch_array($resultdf);
				$fch = $row3['Fecha'];
			else :
				$fch = '';
			endif;

			$aa[0] = fecha_dia($fch) . ' ' . $fch;
			if ($pdv1 == -3 || $pdv == -3) :
				$ganacias1 = ($totalventas1 - ($mm1 + $totalpremio1));
				$ganacias2 = ($totalventas - ($mm + $totalpremio));
			else :
				$ganacias1 = ($totalventas1 - (($totalventas1 * $pdv1) / 100) - $totalpremio1);
				$ganacias2 = ($totalventas - (($totalventas * $pdv) / 100) - $totalpremio);
			endif;

			$totalgeneral = $ganacias1 + $ganacias2;

			if ($totalgeneral >= 0) :
				$aa[1] = number_format($totalgeneral, 2, ',', '.');
				$totalganacias += $totalgeneral;
				$aa[2] = '';
			endif;

			if ($totalgeneral < 0) :
				$aa[2] = number_format($totalgeneral, 2, ',', '.');
				$totalperdidas += $totalgeneral;
				$aa[1] = '';
			endif;

			$pdf->registro($aa, $w, $w1);

			$totalgeneral = 0;

		endif;
		// $primerdia = $row2['IDJ'];
		$lnn = $pdf->Gety();
		// $pdf->line(0, $lnn, 90, $lnn);
		$aa[0] = 'Total General:';
		$aa[1] = number_format($totalganacias, 2, ',', '.');
		$aa[2] = number_format($totalperdidas, 2, ',', '.');
		$pdf->registro($aa, $w, $w1);
		$pdf->ln();
		$pdf->ln();
		$aa[0] = 'Diferencia:';
		$aa[1] = number_format(($totalganacias + $totalperdidas), 2, ',', '.');
		$aa[2] = '';
		$pdf->registro($aa, $w, $w1);
	}
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Ln(10);
	$pdf->SetFont('Arial', 'B', 4);
	$pdf->Cell(1, 1, date("d-m-y") . " " . date("g:i a"), 1, 0, "L");
	$pdf->Output();
else :
	echo "No Hay Informacion...";
endif;
