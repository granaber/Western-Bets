<?php
include('class.ezpdf.php');
require_once('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();


class Creport extends Cezpdf
{

	var $reportContents = array();

	function Creport($p, $o)
	{
		$this->Cezpdf($p, $o);
	}

	function rf($info)
	{
		// this callback records all of the table of contents entries, it also places a destination marker there
		// so that it can be linked too
		$tmp = $info['p'];
		$lvl = $tmp[0];
		$lbl = rawurldecode(substr($tmp, 1));
		$num = $this->ezWhatPageNumber($this->ezGetCurrentPageNumber());
		$this->reportContents[] = array($lbl, $num, $lvl);
		$this->addDestination('toc' . (count($this->reportContents) - 1), 'FitH', $info['y'] + $info['height']);
	}

	function dots($info)
	{
		// draw a dotted line over to the right and put on a page number
		$tmp = $info['p'];
		$lvl = $tmp[0];
		$lbl = substr($tmp, 1);
		$xpos = 520;

		switch ($lvl) {
			case '1':
				$size = 16;
				$thick = 1;
				break;
			case '2':
				$size = 12;
				$thick = 0.5;
				break;
		}

		$this->saveState();
		$this->setLineStyle($thick, 'round', '', array(0, 10));
		$this->line($xpos, $info['y'], $info['x'] + 5, $info['y']);
		$this->restoreState();
		$this->addText($xpos + 5, $info['y'], $size, $lbl);
	}
}

function hiline($line)
{
	global  $pdf;
	$tmp = substr($line, 2, strlen($line) - 3);
	// add a grey bar, highlighting the change
	$tmp2 = $tmp . '<C:rf:2' . rawurlencode($tmp) . '>';
	$pdf->transaction('start');
	$ok = 0;
	while (!$ok) {
		$thisPageNum = $pdf->ezPageCount;
		$pdf->saveState();
		$pdf->setColor(0, 0, 0);
		$pdf->filledRectangle($pdf->ez['leftMargin'], $pdf->y - $pdf->getFontHeight(10) + $pdf->getFontDecender(10), $pdf->ez['pageWidth'] - $pdf->ez['leftMargin'] - $pdf->ez['rightMargin'], $pdf->getFontHeight(10));
		$pdf->restoreState();
		$pdf->setColor(1, 1, 1);
		$pdf->ezText($line, 10, array('justification' => 'center'));
		if ($pdf->ezPageCount == $thisPageNum) {
			$pdf->transaction('commit');
			$ok = 1;
		} else {
			// then we have moved onto a new page, bad bad, as the background colour will be on the old one
			$pdf->transaction('rewind');
			$pdf->ezNewPage();
		}
	}
}
$pdf = new Creport('LETTER', 'portrait');
//$pdf =& new Cezpdf();
$pdf->selectFont('fonts/Helvetica.afm');

$pdf->addPngFromFile('media/logoreporte.png', 1, 8, 25);
$idj = $_REQUEST['idj'];
$idg = explode(',', $_REQUEST['idg']);
$usu = $_REQUEST['usuL'];
$IDB = $_REQUEST['IDB'];
$textOptions = array('justification' => 'full');
$size = 12;

$inicioenca = true;
for ($tg = 0; $tg <= count($idg) - 1; $tg++) {
	$acceso = false;
	if ($usu == -2) : $acceso = true;
	else :
		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbpublicaciones where IDJ=" . $idj . " and Grupo=" . $idg[$tg] . " and IDB=$IDB");
		if (mysqli_num_rows($result) != 0) :
			$row3 = mysqli_fetch_array($result);
			if ($row3['Publicar'] == 1) : 	$acceso = true;
			endif;
		endif;
	endif;

	if ($acceso) :
		$result2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _gruposdd where grupo=" . $idg[$tg]);
		$row = mysqli_fetch_array($result2);
		$descripcion = $row['Descripcion'];


		$header = array();
		$w = array();
		$sw1 = array();
		$data = array();
		$show = array();
		$aa = array();

		//=array('Serial'=>$row2['Serial'],'Letra'=>$row2['IDC'],'Precio'=> $row2['Valor_R'],'Pago'=>$row2['Valor_J'],'Escrute'=>$escrutinio,'Premio'=>number_format($verescrute['premio'],'2','.',''));

		$header[0] = 'Hora';
		$w[0] = 10;
		$w1[0] = 'L';
		$show['Hora'] = 'Hora';
		$header[1] = 'Equipo';
		$w[1] = 22;
		$w1[1] = 'L';
		$show['Equipo'] = 'Equipo';

		if ($idg[$tg] == 2) : $w[1] = 22;
		else : $w[1] = 55;
		endif;
		if ($idg[$tg] == 1000) : 	$w[1] = 150;
		else : 	$w[1] = 30;
		endif;
		$i = 2;


		$result2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbjuegodd where grupo=" . $idg[$tg] . " Order by Formato,IDDD");
		while ($row = mysqli_fetch_array($result2)) {

			$header[$i] = $row['reporte'];
			$w[$i] = 16;
			$w1[$i] = 'L';
			$show[$row['reporte']] = str_replace(' ', '', $row['reporte']);
			$i++;
		}




		$resultp = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where IDJ=" . $idj . " and grupo=" . $idg[$tg] . " and IDB=$IDB");
		$row = mysqli_fetch_array($resultp);
		$fecha_d = $row['Fecha'];


		$result3x = mysqli_query($GLOBALS['link'], "Select * from $prefijoPH._tconfighi where _Fecha='$fecha_d'");
		if (mysqli_num_rows($result3x) != 0) :
			$row3x = mysqli_fetch_array($result3x);
			$IDCN = $row3x['IDCN'];
			$_idhipo = $row3x['_idhipo'];
			$canti = explode('|', $row3x['_Fab']);
			$Retir = explode('|', $row3x['_Ret']);
		endif;

		$np = $row['Partidos'];
		$inicio = true;

		$result_lo = mysqli_query($GLOBALS['link'], "SELECT _partidosbb.* FROM _partidosbb,_equiposbb  where _partidosbb.IDE1=_equiposbb.IDE and  _partidosbb.IDJ=" . $idj . " and _partidosbb.grupo=" . $idg[$tg] . " and  ( _equiposbb.Grupo=" . $idg[$tg] . " or _equiposbb.Grupo1=" . $idg[$tg] . " or _equiposbb.Grupo2=" . $idg[$tg] . ") order by _partidosbb.IDP ");
		/*  echo    "SELECT _partidosbb.* FROM _partidosbb,_equiposbb  where _partidosbb.IDE1=_equiposbb.IDE and  _partidosbb.IDJ=".$idj." and _partidosbb.grupo=".$idg." and  ( _equiposbb.Grupo=".$idg." or _equiposbb.Grupo1=".$idg." or _equiposbb.Grupo2=".$idg." )";  */
		$t = 1;
		while ($row3 = mysqli_fetch_array($result_lo)) {

			$eq1 = $row3["IDE1"];
			$eq2 = $row3["IDE2"];
			$result2 = mysqli_query($GLOBALS['link'], "Select * From _equiposbb Where IDE=" . $eq1);
			$row2 = mysqli_fetch_array($result2);
			if ($row2["Grupo"] == 1000) : $sg1 = $t . '-' . $row2["Descripcion"];
			else : $sg1 = $row3['CodEq1'] . '-' . $row2["Descripcion"];
			endif;
			$result3 = mysqli_query($GLOBALS['link'], "Select * From _equiposbb Where IDE=" . $eq2);
			$row = mysqli_fetch_array($result3);
			if ($row["Grupo"] == 1000) : $sg2 = $t . '-' . $row["Descripcion"];
			else : $sg2 = $row3['CodEq2'] . '-' . $row["Descripcion"];
			endif;
			$sg = array();
			$pch = array();
			$gp = array();
			$efec = array();
			$codi[0] = $row3['CodEq1'];
			$codi[1] = $row3['CodEq2'];
			$pch[0] = $row3['PIDE1'];
			$pch[1] = $row3['PIDE2'];
			$gp[0] = $row3['JGP1'];
			$gp[1] = $row3['JGP2'];
			$efec[0] = $row3['EFEC1'];
			$efec[1] = $row3['EFEC2'];

			if ($row["Grupo"] == 1000) :
				$w[1] = 150;
				$sg1 .= '=';
				$ina = '';
				$numero = array();
				$retirCar = explode('-', $Retir[($t - 1)]);
				for ($cx = 1; $cx <= $canti[($t - 1)]; $cx++) {
					if (array_search($cx, $retirCar) === false) :
						$numero[$cx] = $cx;
					else :
						$numero[$cx] = '';
					endif;
				}



				$resultq = mysqli_query($GLOBALS['link'], "Select * from _tbselectph where IDJ=" . $idj . " and Carr=$t and Grupo=1");
				if (mysqli_num_rows($resultq) != 0) :
					$rowq = mysqli_fetch_array($resultq);
					if ($rowq['Ejemplar'] != '') :
						$checkup1 = explode(',', $rowq['Ejemplar']);
						for ($xt = 0; $xt <= count($checkup1) - 1; $xt++) {
							if ($checkup1[$xt] == '') : $checkup1[$xt] = 1;
							else : $checkup1[$xt] = $checkup1[$xt] + 1;
							endif;
							$resultq = mysqli_query($GLOBALS['link'], "Select * from $prefijoPH._tablaejempleareshi where IDCN=$IDCN and Carr=" . ($t) . " and Noeje=" . $checkup1[$xt]);
							if (mysqli_num_rows($resultq) != 0) :
								$rowq = mysqli_fetch_array($resultq);
								$sg1 .= $rowq['Noeje'] . '-' . str_replace("'", " ", htmlentities($rowq['Nombre'])) . ',';
								$eje1 .= $rowq['Noeje'] . '-';
								$numero[$rowq['Noeje']] = '';
							else :
								$sg1 .= $checkup1[$xt] . '-ND';
								$eje1 .= $checkup1[$xt] . '-' . ',';
								$numero[$checkup1[$xt]] = '';
							endif;
						}
					endif;
				endif;
				$sg2 .= '=';
				$resultq = mysqli_query($GLOBALS['link'], "Select * from _tbselectph where IDJ=" . $idj . " and Carr=$t and Grupo=2");
				if (mysqli_num_rows($resultq) != 0) :
					$rowq = mysqli_fetch_array($resultq);
					if ($rowq['Ejemplar'] != '') :
						$checkup1 = explode(',', $rowq['Ejemplar']);
						for ($xt = 0; $xt <= count($checkup1) - 1; $xt++) {
							if ($checkup1[$xt] == '') : $checkup1[$xt] = 1;
							else : $checkup1[$xt] = $checkup1[$xt] + 1;
							endif;
							$resultq = mysqli_query($GLOBALS['link'], "Select * from $prefijoPH._tablaejempleareshi where IDCN=$IDCN and Carr=" . ($t) . " and Noeje=" . $checkup1[$xt]);
							if (mysqli_num_rows($resultq) != 0) :
								$rowq = mysqli_fetch_array($resultq);
								$sg2 .= $rowq['Noeje'] . '-' . str_replace("'", " ", htmlentities($rowq['Nombre'])) . ',';
								$eje1 .= $rowq['Noeje'] . '-';
								$numero[$rowq['Noeje']] = '';
							else :
								$sg2 .= $checkup1[$xt] . '-ND';
								$eje1 .= $checkup1[$xt] . '-' . ',';
								$numero[$checkup1[$xt]] = '';
							endif;
						}
					endif;
				endif;

				$numero = array_filter($numero, "enblancoA");

				$inv = join(",", $numero);
				if ($inv == '') :
					$pch[1] = 'X= NO HAY';
				else :
					$pch[1] = 'X=' . $inv;
				endif;
			else :
				$w[1] = 30;
			endif;
			$sg[0] = $sg1;
			$sg[1] = $sg2;

			for ($j = 0; $j <= 1; $j++) {
				$aa = array();
				if ($j == 0) :
					$fho = explode(':', $row3['Hora']);
					if ($fho[0] < 12) :
						$ann = 'a';
					endif;
					if ($fho[0] == 12) :
						$ann = 'm';
					endif;
					if ($fho[0] > 12) :
						$ann = 'p';
						$horr = $fho[0] - 12;
					else :
						$horr = $fho[0];
					endif;
					$aa['Hora'] = $horr . ':' . $fho[1] . $ann;
				else :
					$aa['Hora'] = '';

				endif;
				$aa['Equipo'] = $sg[$j];

				$y = 2;
				$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _configuracionjugadabb,_tbjuegodd where _configuracionjugadabb.IDDD=_tbjuegodd.IDDD and _configuracionjugadabb.IDP=" . $t . " and  _configuracionjugadabb.IDJ=" . $idj . " and _configuracionjugadabb.grupo=" . $idg[$tg] . " and _tbjuegodd.grupo=" . $idg[$tg] . " and _configuracionjugadabb.IDB=$IDB Order by _tbjuegodd.Formato,_configuracionjugadabb.IDDD");

				while ($row = mysqli_fetch_array($result)) {

					$llg = explode('|', $row['Valores']);
					$ta1 = '';
					if ($row['textorfila'] != '') :
						$ta = explode('|', $row['textorfila']);
						$ta1 = $ta[$j];
					endif;

					if (count($llg) == 3) :
						if ($llg[$j] != ''  && evaluarLogro($llg[$j])) :
							$aa[$header[$y]] = $ta1 . ' ' . convertir($llg[$j], false, true);
						else :
							if ($llg[$j] == '') :
								$aa[$header[$y]] = ' ';
							else :
								$aa[$header[$y]] = 'ERR';
							endif;
						endif;
					else :
						$key = strpos($row['Columnas'], 'Ax');
						if ($key === false) :
							$ilos = true;
						else :
							$ilos = false;
						endif;

						if ($j == 0) :
							if ($llg[$j] != '' && evaluarLogro($llg[$j]) && $llg[$j + 1] != '') :
								$aa[$header[$y]] = $ta1 . '' . convertir($llg[$j + 1], true, $ilos) . convertir($llg[$j], false, true);
							else :
								if ($llg[$j] == '' ||  $llg[$j + 1] == '') :
									$aa[$header[$y]] = ' ';
								else :
									$aa[$header[$y]] = 'ERR';
								endif;
							endif;
						endif;


						if ($j == 1) :
							if ($llg[$j + 1] != '' && evaluarLogro($llg[$j + 1]) && $llg[$j + 2] != '') :
								$aa[$header[$y]] = $ta1 . ' ' . convertir($llg[$j + 2], true, $ilos) . convertir($llg[$j + 1], false, true);
							else :
								if ($llg[$j + 1] == '' ||  $llg[$j + 2] == '') :
									$aa[$header[$y]] = ' ';
								else :
									$aa[$header[$y]] = 'ERR';
								endif;
							endif;
						endif;

					endif;

					$y++;
				}
				$data[] = $aa;

				/* $aa2=array();
   $aa2= array_fill(0, $y, ' ');
   $aa2[0]='';
   $aa2[1]=$pch[$j].' '.$gp[$j].' '.$efec[$j];
  
   $data[]=$aa2;*/
			}


			$t++;
		}
		if (count($data) != 0) :
			hiline($descripcion);
			$pdf->ezTable($data, $show, '', array('fontSize' => 8, 'showLines' => 0, 'xPos' => 35, 'xOrientation' => 'right', 'rowGap' => 1));
		endif;
	endif;
}
$pdf->ezStream();
//echo 1;
/*$pdf->Ln(2);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(1,1,'*Nota: Estos logros pueden ser modificados sin previo aviso..! ',1,0,"L");

$pdf->Ln(10);
$pdf->SetFont('Arial','B',12);$tmt =strtotime("now")-30;
$pdf->Cell(1,1,Fechareal($GLOBALS['minutosh'],"d-m-y")." ".Horareal($GLOBALS['minutosh'],"h:i:s A"),1,0,"L");
$pdf->Output();*/
