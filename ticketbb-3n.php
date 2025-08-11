<?php

if (isset($_REQUEST['xidj'])) :
	require('prc_php.php');
	$GLOBALS['link'] = Connection::getInstance();
	global $prefijoPH;

	$idj = $_REQUEST["xidj"];
	$idg = $_REQUEST["idp"];
	$tdl = $_REQUEST["tdl"];
	$IDB = $_REQUEST['IDB'];
endif;
$alink = 'center';
$texto1 = 'N.P';

if ($idg == 1000) :


	$alink = 'left';
	$texto1 = 'Carr.';

endif;
?>


<table id="fortt<?php echo $idg; ?>" lang="<?php echo $idj; ?>" title="<?php echo $idg; ?>" border="0" cellspacing="0" style="color:#000">
	<tr>
		<td bgcolor="#FFFFFF">&nbsp;</td>
		<td bgcolor="#FFFFFF">&nbsp;</td>
		<td bgcolor="#FFFFFF">&nbsp;</td>
		<td bgcolor="#FFFFFF">&nbsp;</td>
		<?

		$logrounico = 0;
		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _formatosbb where grupo=" . $idg . "  Order by Formato");
		if (mysqli_num_rows($result) != 0) :
			while ($row3 = mysqli_fetch_array($result)) {
				$result3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbjuegodd  where Estatus=1 and grupo=" . $idg . " and Formato=" . $row3['Formato'] . " Order by IDDD");
				echo '<td colspan="' . mysqli_num_rows($result3) . '" bgcolor="#FFFFFF"  style="border-left:outset;color:#000" ><div align="center"><strong>' . $row3['Descripcion'] . '</strong></div></td>';
			}
		endif;
		?>

	</tr>
	<tr>
		<td bgcolor="#000">
			<div align="center" style="font-size:14px;color:#FFF"><strong>
					<? echo  $texto1; ?>
				</strong></div>
		</td>
		<td bgcolor="#000">
			<div align="center" style="font-size:14px;color:#FFF"><strong>Equipo1</strong></div>
		</td>
		<td bgcolor="#000">
			<div align="center" style="font-size:14px;color:#FFF"><strong>Equipo2</strong></div>
		</td>
		<td bgcolor="#000" width="20px"></td>
		<?php
		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbjuegodd  where Estatus=1 and grupo=" . $idg . " Order by Formato,IDDD");

		if (mysqli_num_rows($result) != 0) :
			$i = 1;
			$euie = 0;
			$lin = '';
			while ($row3 = mysqli_fetch_array($result)) {
				if ($euie != $row3['Formato']) :
					$lin = 'style="border-left:outset"';
					$euie = $row3['Formato'];
				else :
					$lin = '';
				endif;
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////
				if ($IDG != 0) :
					$resultCmb = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbreglas_1  where IDC='$IDC'  and IDDD=" . $row3['IDDD']);
					if (mysqli_num_rows($resultCmb) != 0) :
						$rowCmb = mysqli_fetch_array($resultCmb);
						$noCombinar = $rowCmb['noCombinar'];
					else :
						$resultCmb = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbreglas_1  where IDG=$IDG and IDC='0'  and IDDD=" . $row3['IDDD']);
						if (mysqli_num_rows($resultCmb) != 0) :
							$rowCmb = mysqli_fetch_array($resultCmb);
							$noCombinar = $rowCmb['noCombinar'];
						else :
							$noCombinar = $row3['noCombinar'];
						endif;
					endif;
				else :
					$noCombinar = $row3['noCombinar'];
				endif;
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////
				echo '<td width="81" bgcolor="#000" ' . $lin . '><div id ="c' . $row3['IDDD'] . '" lang="' . $row3['Formato'] . '%' . $row3['Columnas'] . '%' . $row3['Minimas'] . '-' . $row3['Maximas'] . '-' . $row3['Opcion'] . '-' . $noCombinar . '" align="center" title="' . $row3['Tituloticket'] . '"><strong><span style="font-size:9px;color:#FFF">' . $row3['Descripcion'] . '</span></strong></div><a id="nc_' . $i . '_' . $idg . '" lang="' . $row3['Columnas'] . '"></a></td>';

				$i++;
			}
			$iii = $i;
		endif;

		?>
	</tr>

	<?php
	$i = 1;
	$b = 1;
	$euie = 0;
	$lin = '';
	$columasv = '';
	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbpublicaciones where IDJ=" . $idj . " and Grupo=" . $idg . " and IDB=$IDB");
	if (mysqli_num_rows($result) != 0) :
		$row3 = mysqli_fetch_array($result);
		if ($row3['Publicar'] == 1) :

			$result = mysqli_query($GLOBALS['link'], "SELECT _partidosbb.* FROM _partidosbb,_equiposbb  where _partidosbb.IDE1=_equiposbb.IDE and  _partidosbb.IDJ=" . $idj . " and _partidosbb.Grupo=" . $idg . " and  ( _equiposbb.Grupo=" . $idg . " or _equiposbb.Grupo1=" . $idg . " or _equiposbb.Grupo2=" . $idg . " ) Order by IDP");
			//echo "SELECT _partidosbb.* FROM _partidosbb,_equiposbb  where _partidosbb.IDE1=_equiposbb.IDE and  _partidosbb.IDJ=".$idj." and _partidosbb.Grupo=".$idg." and  ( _equiposbb.Grupo=".$idg." or _equiposbb.Grupo1=".$idg." or _equiposbb.Grupo2=".$idg." ) Order by IDP";
			if (mysqli_num_rows($result) != 0) :

				while ($row3 = mysqli_fetch_array($result)) {

					$resultp = mysqli_query($GLOBALS['link'], "SELECT * FROM _cierrebb where IDJ=" . $idj . " and IDP=" . $row3['IDP'] . " and Grupo=" . $idg);
					if (mysqli_num_rows($resultp) == 0) :
						$ddd = '';
					else :
						$ddd = 'style="display:none"';
					endif;

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
					$idd_x = $row3["IDP"];
					$eq1 = $row3["IDE1"];
					$eq2 = $row3["IDE2"];
					$result2 = mysqli_query($GLOBALS['link'], "Select * From _equiposbb Where IDE=" . $eq1);
					$row2 = mysqli_fetch_array($result2);
					$sg1 = $row2["Descripcion"];
					$result3 = mysqli_query($GLOBALS['link'], "Select * From _equiposbb Where IDE=" . $eq2);
					$row = mysqli_fetch_array($result3);
					$sg2 = $row["Descripcion"];
					$eje1 = '';
					$eje2 = '';
					if ($idg == 1000) :
						// $sg1=$sg1.'(C'.$i.')';
						$numero = array();
						$Xph = '';
						$retirCar = explode('-', $Retir[($i - 1)]);
						for ($cx = 1; $cx <= $canti[($i - 1)]; $cx++) {
							if (array_search($cx, $retirCar) === false) :
								$numero[$cx] = $cx;
							else :
								$numero[$cx] = '';
							endif;
						}
						//	print_r($numero);
						$resultq = mysqli_query($GLOBALS['link'], "Select * from _tbselectph where IDJ=" . $idj . " and Carr=$i and Grupo=1");
						if (mysqli_num_rows($resultq) != 0) :
							$rowq = mysqli_fetch_array($resultq);
							if ($rowq['Ejemplar'] != '') :
								$checkup1 = explode(',', $rowq['Ejemplar']);
								for ($t = 0; $t <= count($checkup1) - 1; $t++) {
									if ($checkup1[$t] == '') : $checkup1[$t] = 1;
									else : $checkup1[$t] = $checkup1[$t] + 1;
									endif;
									$resultq = mysqli_query($GLOBALS['link'], "Select * from $prefijoPH._tablaejempleareshi where IDCN=$IDCN and Carr=" . ($i) . " and Noeje=" . $checkup1[$t]);
									if (mysqli_num_rows($resultq) != 0) :
										$rowq = mysqli_fetch_array($resultq);
										$sg1 .= '<br>' . $rowq['Noeje'] . '-' . str_replace("'", " ", htmlentities($rowq['Nombre']));
										$eje1 .= $rowq['Noeje'] . '-';
										$numero[$rowq['Noeje']] = '';
									else :
										$sg1 .= '<br>' . $checkup1[$t] . '-ND';
										$eje1 .= $checkup1[$t] . '-';
										$numero[$checkup1[$t]] = '';
									endif;
								}
							endif;
						endif;
						$eje1 = $i . '*' . $eje1;
						// $sg2=$sg2.'(C'.$i.')';
						$resultq = mysqli_query($GLOBALS['link'], "Select * from _tbselectph where IDJ=" . $idj . " and Carr=$i and Grupo=2");
						if (mysqli_num_rows($resultq) != 0) :
							$rowq = mysqli_fetch_array($resultq);
							if ($rowq['Ejemplar'] != '') :
								$checkup1 = explode(',', $rowq['Ejemplar']);
								for ($t = 0; $t <= count($checkup1) - 1; $t++) {
									if ($checkup1[$t] == '') : $checkup1[$t] = 1;
									else : $checkup1[$t] = $checkup1[$t] + 1;
									endif;
									$resultq = mysqli_query($GLOBALS['link'], "Select * from $prefijoPH._tablaejempleareshi where IDCN=$IDCN and Carr=" . ($i) . " and Noeje=" . $checkup1[$t]);
									if (mysqli_num_rows($resultq) != 0) :
										$rowq = mysqli_fetch_array($resultq);
										$sg2 .= '<br>' . $rowq['Noeje'] . '-' . str_replace("'", " ", htmlentities($rowq['Nombre']));
										$eje2 .= $rowq['Noeje'] . '-';
										$numero[$rowq['Noeje']] = '';
									else :
										$sg2 .= '<br>' . $checkup1[$t] . '-ND';
										$eje2 .= $checkup1[$t] . '-';
										$numero[$checkup1[$t]] = '';
									endif;
								}
							endif;
						endif;
						$eje2 = $i . '*' . $eje2;

						$numero = array_filter($numero, "enblancoA");
						$inv = join(",", $numero);
						if ($inv == '') :
							$Xph = 'X= NO HAY';
						else :
							$Xph = 'X=' . $inv;
						endif;

					else :
						$eje1 = '1';
						$eje2 = '1';
					endif;


					$line = $sg1 . ' vs ' . $sg2;
					if ($b == 1) :
						$color = "#FFFFFF";
						$b = 2;
					else :
						//$color="#E2E7EF";
						$color = "#CCC";
						$b = 1;
					endif;



					echo '<ul id="rro_2_' . $row3['IDP'] . '" lang="rro' . $i . '_' . $idg . '" style="display:none"></ul>';
					echo '<tr id="rro' . $i . '_' . $idg . '" ' . $ddd . '><samp id="ipdc' . $i . '_' . $idg . '" style="display:none"></samp> ';

					echo '<td width="31" bgcolor="' . $color . '" ><div id="part_x' . $tdl . '" lang="' . $idg . '" ></div><div id="part' . $i . '_' . $idg . '" lang="0" title="' . $line . '"  align="center" style="font-size:10px;background-color:' . $color . '"> </div><br><div id="ipd' . $i . '_' . $idg . '"  lang="' . $row3['IDP'] . '" align="center" style="font-size:14px;color:#000"><strong>';



					if ($idg != 1000) :	echo $row3['IDP'] . '</strong></div></td>';
					else : echo ($i) . '</strong></div></td>';
					endif;
					$nombrea = "images/logo/eq" . $row3['IDE1'] . ".png";
					if (!file_exists($nombrea)) {
						$nombrea = $default[$idg];
					}

					echo '  <td width="78" bgcolor="' . $color . '"><div id="st_' . $i . '_' . $idg . '" lang="" align="' . $alink . '" style="font-size:10px;color:#000">' . $sg1 . '</div><div align="center">';
					echo '<div id="ExPh' . $i . '_' . $idg . '_' . $eq1 . '" lang="' . $eje1 . '"></div>';
					if ($idg != 1000) :		echo ' <img id="imgl' . $i . '" src="' . $nombrea . '?' . md5(time()) . '" height="32" width="48"/>';
					endif;
					echo '</div>';

					if ($idg == 1000) : echo '<br><br>';
						echo '<strong><span id="Xph_2_' . $i . '_' . $idg . '" lang=""  style="color:#000" >' . $Xph . '</span></strong><br>';
					endif;


					echo '<strong><span id="part_2_' . $i . '_' . $idg . '" lang=""  style="color:#000" >' . $horr . ':' . $fho[1] . $ann . '</span></strong>';
					echo '</td>';
					$nombrea = "images/logo/eq" . $row3['IDE2'] . ".png";
					if (!file_exists($nombrea)) {
						$nombrea = $default[$idg];
					}
					echo '  <td  bgcolor="' . $color . '"  ><div  align="' . $alink . '" style="font-size:10px;color:#000">' . $sg2 . '</div><div align="center">';
					echo '<div id="ExPh' . $i . '_' . $idg . '_' . $eq2 . '" lang="' . $eje2 . '"></div>';
					if ($idg != 1000) :		echo '<img id="imgr' . $i . '" src="' . $nombrea . '?' . md5(time()) . '" height="32" width="48"/>';
					endif;

					echo '</div></td>';
					echo '  <td bgcolor="' . $color . '"><span id="' . $row3['IDE1'] . '">' . $row3['CodEq1'] . '</span><br><br><span id="' . $row3['IDE2'] . '">' . $row3['CodEq2'] . '</span></td>';
					$result3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbjuegodd  where Estatus=1 and grupo=" . $idg . "  Order by formato,IDDD");
					$logrounico = 0;
					while ($row4 = mysqli_fetch_array($result3)) {
						$col = explode('|', $row4['Columnas']);
						$dis = explode('|', $row4['TDisplay']);
						if ($row4['TDisplay'] == '') :
							$verif = true;
						else :
							$verif = false;
						endif;
						$ssadi = true;

						if (strpos($row4['Columnas'], '-') == 0) :
							$ssadi = false;
						endif;
						if ($euie != $row4['Formato']) :
							$lin = 'style="border-left:outset"';
							$euie = $row4['Formato'];
						else :
							$lin = '';
						endif;
						echo '  <td bgcolor="' . $color . '"  ' . $lin . ' ><div  style="width:' . $row4['tmc'] . 'px">';

						$ncv = -1;
						$colocado = 0;
						$nuevoLogro = 0;
						$modo = 0;
						for ($ii = 0; $ii <= count($col) - 1; $ii++) {
							$logrounico = 0;
							$valoresdd = array();
							$result5 = mysqli_query($GLOBALS['link'], "SELECT * FROM _configuracionjugadabb where IDP=" . $i . " and IDJ=" . $idj . " and IDDD=" . $row4['IDDD'] . " and Grupo=" . $idg . " and IDB=$IDB Order by IDP");
							if (mysqli_num_rows($result5) != 0) :
								$row5 = mysqli_fetch_array($result5);
								$valoresdd = explode('|', $row5['Valores']);
								$arrayNOdds = array();
								if ($colocado == 0) :
									echo  '<span id="' . $row5['IDDD'] . '_' . $i . '_Act" lang="' . $row5['actualizado'] . '"></span>';
									$colocado = 1;
								endif;
								//////////////
								/* $cua0=0;
			  for ($n=0;$n<=count($valoresdd)-1;$n++)
				if  (  $valoresdd[$n]==0 ) $cua0++;
			  
			  echo '**'.$cua0.'**';*/

								$key = strpos($row4['Columnas'], 'Ax');

								if ($key === false) : $eAB = false;
								else : $eAB = true;
								endif;

								if ($auto == 1) :
									if ($nuevoLogro == 0) :
										if ($valoresdd[1] != '') :
											switch (count($valoresdd)) {

												case 3:
													if ($valoresdd[1] < 0) :
														$LogroM = $valoresdd[1];
														$macho = 1;
													else :
														$LogroM = $valoresdd[0];
														$macho = 0;
													endif;
													$modo = 3;
													break;

												case 5:
													//-130|1.5|110|-1.5|
													if ($valoresdd[2] < 0) :
														$LogroM = $valoresdd[2];
														$macho = 2;
													else :
														$LogroM = $valoresdd[0];
														$macho = 0;
													endif;
													$modo = 5;
													break;
											}
											//echo '<br>';//print_r($valoresdd);
											//echo '*****'.$idCnv.'|'.$LogroM.'|'.$modo.'|'.$macho.'|'.$eAB.'<=';echo '<br>';
											if ($modo != 0) $arrayNOdds = DBconver($idCnv, $LogroM, $modo, $macho, $eAB, 1);
										/*if ($eAB):
					echo $LogroM;
					print_r($arrayNOdds);
					endif;*/
										endif;
									endif;
									$valordysplay = '';
								endif;

								/////////////
								if ($valoresdd[$ii] != '') :
									$valorss = $valoresdd[$ii];
									$lgo = $valoresdd[$ii];
									$subcol = explode('-', $col[$ii]);
									$pos = strpos($subcol[1], 'car');

									if ($pos === false) :
										if (abs($valorss) <= 99) :
											$valordysplay = $valorss;
											$r = fmod($valoresdd[$ii], 1);
										else :
											$valordysplay = $valorss / 10;
											$r = fmod($valoresdd[$ii], 10);
										endif;

									else :
										$valordysplay = $valorss;
										$r = fmod($valoresdd[$ii], 1);

									endif;

									if ($r != 0) :
										if ($valorss < 0) :
											$valordysplay = $valordysplay + .5;
											if ($valordysplay == 0) : $valordysplay = '-';
											endif;
										else :
											$valordysplay = ($valordysplay - .5);
										endif;
										if ($valordysplay == 0) :
											$menos = '';
											if ($valorss < 0) : $menos = '-';
											endif;
											$valordysplay = $menos . "&frac12;";
										else :
											$valordysplay = $valordysplay . "&frac12;";
										endif;

									endif;

									$anexo = '';
									$key = strpos($row4['Columnas'], 'Ax');
									if ($key === false) :
										if ($valorss > 0) :
											$anexo = '+';
										endif;
									endif;
									$valordysplay = $anexo . $valordysplay;
								/* $valorsss=$valordysplay; 0424-147.2541 yeinny*/

								else :
									$valordysplay = '';
									$valorsss = '';
									$lgo = '';
								endif;
							else :
								$valordysplay = '';
								$valorsss = '';
								$lgo = '';
							endif;

							if (!$verif) :
								$valordysplay = $dis[$ii];
								$logrounico = $valoresdd[$ii];
								$lgo = '';
								$equ = $i . '||' . $line;
							else :
								if ($ncv == -1) :
									$equ = $eq1 . '||' . $sg1;
								else :
									$equ = $eq2 . '||' . $sg2;
								endif;
							endif;
							$stl = true;

							if (count($subcol) == 1) :
								$nomc = $col[$ii];
							else :


								if ($pos == 0) :
									$stl = false;
								endif;
								$nomc = $subcol[1];
							endif;
							if ($valoresdd[$ii] != '' && $stl) :
								if (!evaluarLogro($valoresdd[$ii])) :  $valoresdd[$ii] = 'ERR!';
									$valordysplay = 'ERR!';
									$stl = false;
								endif;
							//echo $valoresdd[$ii];
							endif;

							// if ($IDB==3):
							if ($valorss != '') :
								//echo $nuevoLogro; 
								if ($arrayNOdds[$nuevoLogro] == 0) :
									$valordysplay = $valorss;
								else :
									if ($eAB) :
										$valordysplay = $arrayNOdds[$nuevoLogro];
										$lgo = $arrayNOdds[$nuevoLogro];
									else :
										$valordysplay = $arrayNOdds[$nuevoLogro];
										$lgo = $arrayNOdds[$nuevoLogro];
									endif;
								endif;
								$nuevoLogro++;
							endif;
							// endif;

							if ($valoresdd[$ii] != '') :
								$columasv = $columasv . $valoresdd[$ii] . '|';
								if ($stl) :
									$ncv++;

									echo '<span  id="' . $nomc . '_' . $i . 'k" style="font-size:11px"><span id="' . $nomc . '_' . $i . 'b"  title="' . $logrounico . '" lang="' . $ncv . '|' . $row4['IDDD'] . '"></span><span id="' . $nomc . '_' . $i . 'a" lang="' . $equ . '"></span> <input id="' . $nomc . '_' . $i . '" type="checkbox" title="' . $lgo . '" value="" onclick="valiDD(' . $i . ',' . $ncv . ',' . $row4['IDDD'] . ',' . $idg . ',' . $IDB . ',' . $row5['IDDD'] . ');"  /><span id="' . $nomc . '_' . $i . 'dy"  style="font-size:10px;color:#000">' . $valordysplay . '</span></span>';
									if ($ssadi == false) :
										echo '<span id="a2_' . $row4['IDDD'] . '_' . $ncv . '_' . $i . '"  title="" lang="' . $row4['AddTicket'] . '|"></span>';
										if ($euie >= 2) :
											echo '<br><br>';
										endif;
									endif;
								else :
									echo '<span id="a2_' . $row4['IDDD'] . '_' . $ncv . '_' . $i . '" title="' . $valorss . '" lang="' . $row4['AddTicket'] . '|' . $valordysplay . '"></span>(<span id="a2_' . $row4['IDDD'] . '_' . $ncv . '_' . $i . 'dy" style="font-size:9px;color:#000" >' . $valordysplay . '</span>)';
									echo '<br><br>';
								endif;

								if (!$verif) :
									echo '<span style="font-size:9px">(' . $valorsss . ')</span>';
									echo '<br><br>';
								endif;
							//************************************************	

							else :
								if ($stl) :
									$ncv++;
									echo '<span id="' . $nomc . '' . $i . 'a" lang="' . $equ . '"></span> <input id="' . $nomc . '' . $i . '" type="checkbox" title="' . $lgo . '" style="display:none"/>';
									if ($ssadi == false) :
										echo '<span id="a2_' . $row4['IDDD'] . '_' . $ncv . '_' . $i . '"></span>';
									endif;
								else :
									echo '<span id="a2_' . $row4['IDDD'] . '_' . $ncv . '_' . $i . '"></span>';
								endif;
								echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";

							endif;
						}
						echo '</div></td>';
					}

					echo '</tr>';

					$i++;
					$tdl++;
				}
			endif;
		endif;
	endif;
	?>
</table>

<a id="tl<?php echo $idg; ?>" lang="<?php echo $i; ?>"></a><a id="nctd<?php echo $idg; ?>" lang="<?php echo $iii - 1; ?>"></a><a id="lgrunico<?php echo $idg; ?>" lang="<?php echo $logrounico; ?>"></a>
<div id="items"></div>