<?php

require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$idj = $_REQUEST["idj"];
$cant = $_REQUEST["cant"];
$dp = $_REQUEST["dp"];
$IDB = $_REQUEST["IDB"];

$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbpublicaciones where IDJ=" . $idj . " and Grupo=" . $dp . " and IDB=$IDB");
if (mysqli_num_rows($result) != 0) :
	$row3 = mysqli_fetch_array($result);
	$entrar = ($row3['Publicar'] == 2);
else :
	$entrar = true;
endif;

if ($entrar) :

	$resultp = mysqli_query($GLOBALS['link'], "SELECT * FROM _partidosbb where IDJ=" . $idj . " and Grupo=" . $dp . " and IDB=$IDB Order by IDP");

	if (mysqli_num_rows($resultp) != 0) :
		$i = 0;
		while ($rowp = mysqli_fetch_array($resultp)) {
			$i++;
			$np[$i] = $rowp["IDP"];
			$eq1[$i] = $rowp["IDE1"];
			$eq2[$i] = $rowp["IDE2"];
			$pide1[$i] = $rowp["PIDE1"];
			$pide2[$i] = $rowp["PIDE2"];
			$JGP1[$i] = $rowp["JGP1"];
			$JGP2[$i] = $rowp["JGP2"];
			$efec1[$i] = $rowp["EFEC1"];
			$efec2[$i] = $rowp["EFEC2"];
			$hrx[$i] = $rowp["Hora"];
		}
		if ($i != $cant) :

			$resultp = mysqli_query($GLOBALS['link'], "SELECT * FROM _partidosbb  where  IDB=$IDB Order by IDP Desc");
			if (mysqli_num_rows($resultp) != 0) :
				$rowp = mysqli_fetch_array($resultp);
				$ini_p =  $rowp['IDP'] + 1;
			else :
				$ini_p = 1;
			endif;
			for ($j = $i + 1; $j <= $cant; $j++) {
				$np[$j] = $ini_p;
				$eq1[$j] = "1";
				$eq2[$j] = "1";
				$hrx[$j] = "";
				$pide1[$j] = '';
				$pide2[$j] = '';
				$JGP1[$j] = '';
				$JGP2[$j] = '';
				$efec1[$j] = '';
				$efec2[$j] = '';
				$ini_p++;
			}
		endif;

	else :
		$resultp = mysqli_query($GLOBALS['link'], "SELECT * FROM _partidosbb   where  IDB=$IDB  Order by IDP Desc");
		if (mysqli_num_rows($resultp) != 0) :
			$rowp = mysqli_fetch_array($resultp);
			$ini_p =  $rowp['IDP'] + 1;
		else :
			$ini_p = 1;
		endif;
		for ($i = 1; $i <= $cant; $i++) {
			$np[$i] = $ini_p + ($i - 1);
			$eq1[$i] = "1";
			$eq2[$i] = "1";
			$hrx[$i] = "";
			$pide1[$i] = '';
			$pide2[$i] = '';
			$JGP1[$i] = '';
			$JGP2[$i] = '';
			$efec1[$i] = '';
			$efec2[$i] = '';
		}
	endif;

?>
	<div id="fromLogros" style="background:#BAC6D8;height:1000px">
		<table border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td></td>
			</tr>
			<tr>
				<td id="n_idc" title="<?php echo $idj; ?>"></td>
			</tr>
			<tr>
				<td>
					<div id="partidos">
						<table border="0" cellspacing="0" cellpadding="0">
							<tr style="background:#3366CC">
								<td width="38" height="45px">
									<div align="center" style="color:#FFFFFF"><strong>N.P</strong></div>
								</td>
								<td width="110">
									<div align="center" style="color:#FFFFFF"><strong>Hora<br />(HH:MM) </strong></div>
								</td>
								<td width="58">
									<div align="center" style="color:#FFFFFF"><strong>Equipo(1)</strong></div>
								</td>
								<td width="13">&nbsp;</td>
								<td width="61">
									<div align="center" style="color:#FFFFFF"><strong>Equipo(2)</strong></div>
								</td>

								<td width="1000" rowspan="<? echo $cant + 1; ?>" valign="top">
									<div style="" id="TabbedPanels1" class="TabbedPanels">
										<ul class="TabbedPanelsTabGroup">
											<?php
											$permitirmod = permitemodif($dp, $idj);
											$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _formatosbb where Grupo=" . $dp . " Order by Formato");
											if (mysqli_num_rows($result) != 0) :
												$cc = 1;
												while ($row3 = mysqli_fetch_array($result)) {
													$result2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbjuegodd where Formato=" . $row3['Formato']);
													while ($row2 = mysqli_fetch_array($result2)) {

														echo '<li class="TabbedPanelsTab" tabindex="0" ><div align="center"  style="color:#000000"><samp id="c' . $row2['IDDD'] . '"/></samp><br /><strong>' . $row3['Descripcion'] . '</strong><br /><strong  style="color:#FFCC00">' . $row2['Descripcion'] . '</strong></div></li>';
													}
													$cc++;
												}
												echo '<li class="TabbedPanelsTab" tabindex="0" ><div align="center"  style="color:#000000"><br /><strong>Pichers/Efectividad</strong><br /><strong  style="color:#FFCC00">Juegos</strong></div></li>';
											endif;
											echo '</ul><div class="TabbedPanelsContentGroup">';
											$k = 1;
											$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _formatosbb  where Grupo=" . $dp . "  Order by Formato");
											if (mysqli_num_rows($result) != 0) :
												$listdv = '';

												while ($row3 = mysqli_fetch_array($result)) {


													$result2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbjuegodd where Formato=" . $row3['Formato']);
													while ($row2 = mysqli_fetch_array($result2)) {
														echo '<div class="TabbedPanelsContent" ><table border="0" cellspacing="0" cellpadding="0"> ';
														for ($i = 1; $i <= $cant; $i++) {
															if (($i % 2) == 0) :
																$bkcolor = "#3366CC";
															else :
																$bkcolor = "#333333";
															endif;


															$col = explode('|', $row2['Columnas']);


															echo '<tr valign="middle">   <td  valign="middle" height="40px"> <div  id=j"' . $row2['IDDD'] . '" lang="' . count($col) . '" style=" background:' . $bkcolor . '">';

															$key = strpos($row2['Columnas'], 'RU');

															if ($key === false) :
																$evaluar = 0;
																$coleval = "''";
															else :
																$evaluar = 1;
																$coleval = "'" . $row2['Columnas'] . "'";
															endif;
															if ($evaluar == 0) :
																$key = strpos($row2['Columnas'], 'Ax');
																if ($key === false) :
																	$evaluar = 0;
																	$coleval = "''";
																else :
																	$evaluar = 2;
																	$coleval = "'" . $row2['Columnas'] . "'";
																endif;
															endif;
															for ($ii = 0; $ii <= count($col) - 1; $ii++) {


																$subcol = explode('-', $col[$ii]);
																//echo count($subcol);
																if (count($subcol) == 1) :
																	$tm = 4;
																	$nomc = $col[$ii];
																	$stl = '';
																else :
																	$pos = strpos($subcol[1], 'car');

																	if ($pos == 0) :
																		$stl = "background-color: #ADD5F1";
																	else :
																		$stl = '';
																	endif;

																	$tm = $subcol[0];
																	$nomc = $subcol[1];
																endif;

																$result5 = mysqli_query($GLOBALS['link'], "SELECT * FROM _configuracionjugadabb where IDP=" . $i . " and IDJ=" . $idj . " and IDDD=" . $row2['IDDD'] . " and Grupo=" . $dp);
																if (mysqli_num_rows($result5) != 0) :
																	$row5 = mysqli_fetch_array($result5);
																	$valoresdd = explode('|', $row5['Valores']);
																	$cualv = $valoresdd[$ii];
																else :
																	$cualv = '';
																endif;
																$listdv[$i] = $listdv[$i] . '|' . $nomc . '' . $i;
																$ty = "'num'";
																$asiacc = "$('obc" . $row2['IDDD'] . $i . "').lang='" . $nomc . "'";
																//*******************************************************//
																if ($cualv == '' && $row2['logrosxdefecto'] != '') :
																	$valoresdd = explode('|', $row2['logrosxdefecto']);
																	if ($ii == 0) : $cualv = $valoresdd[$ii];
																	endif;
																	if (count($col) == 4) :
																		if ($ii == 2) : $cualv = $valoresdd[1];
																		endif;
																	endif;
																	if (count($col) == 2) :
																		if ($ii == 1) : $cualv = $valoresdd[1];
																		endif;
																	endif;
																endif;
																//*******************************************************//

																echo '<input id="' . $nomc . '' . $i . '" lang="' . $row2['IDDD'] . '" type="text" size="' . $tm . '" maxlength="' . $tm . '" style="' . $stl . '" onkeyup="focusobjbb(event,' . $i . ')" onkeypress="return permitebb(event,' . $ty . ',' . $evaluar . ',' . $coleval . ',' . $i . ');" onclick="' . $asiacc . '" value="' . $cualv . '"/>';
															}
															echo '<img id="obc' . $row2['IDDD'] . $i . '" title="' . $i . '" src="media/add.png" width="16" height="16"  onclick="copiarvaloresjsonbb(event)"/></div></td></tr>';
														}
														echo '</table>';
														echo '</div>';
													}
												}
												echo '<div class="TabbedPanelsContent" ><table border="0" cellspacing="0" cellpadding="0"> <tr > ';
												echo '<td  style="color:#333;background:#BEC8D8 "><div align="center" style="color:#333;font-size:9px"><strong>Pichers</strong></div></td>';
												echo '<td  style="color:#333;"><div align="center" style="color:#333;font-size:9px"><strong>G-P</strong></div></td>';
												echo '<td  style="color:#333;background:#BEC8D8  "><div align="center" style="color:#333;font-size:9px "><strong>Efectividad</strong></div></td> </tr> ';
												for ($i = 1; $i <= $cant; $i++) {
													$n = $i + $cant;
													if (($i % 2) == 0) :
														$bkcolor = "#3366CC";
													else :
														$bkcolor = "#333333";
													endif;
													$ssg1 = "'pc2" . $n . "'";
													$ssg2 = "'GP1" . $i . "'";
													echo ' <tr height="35px"  valign="middle" style=" background:' . $bkcolor . '">';
													echo   '<td style="color:#FFFFFF"> <input id="pc1' . $i . '" type="text" style="background-color:#BEC8D8 " size=10 value="' . $pide1[$i] . '" onkeyup="focusobjbb2(event,' . $ssg1 . ')"/><input id="pc2' . $n . '"  style="background-color:#BEC8D8 "type="text" size=10 value="' . $pide2[$i] . '" onkeyup="focusobjbb2(event,' . $ssg2 . ')"/></td>';
													$ssg1 = "'GP2" . $n . "'";
													$ssg2 = "'efe1" . $i . "'";
													echo   '<td style="color:#FFFFFF"><input id="GP1' . $i . '"  type="text" size=3 value="' . $JGP1[$i] . '" onkeyup="focusobjbb2(event,' . $ssg1 . ')" /><input id="GP2' . $n . '" type="text" size=3 value="' . $JGP2[$i] . '" onkeyup="focusobjbb2(event,' . $ssg2 . ')"/></td>';
													$ssg1 = "'efe2" . $n . "'";
													$ssg2 = "'pc1" . $i . "'";
													echo   '<td style="color:#FFFFFF"><input id="efe1' . $i . '" type="text" size=3 style="background-color:#BEC8D8 " value="' . $efec1[$i] . '" onkeyup="focusobjbb2(event,' . $ssg1 . ')"/><input id="efe2' . $n . '" type="text" size=3  style="background-color:#BEC8D8 " value="' . $efec2[$i] . '" onkeyup="focusobjbb2(event,' . $ssg2 . ')"/></td></tr>';
												}
												echo '</table></div>';
											endif;
											for ($t = 0; $t <= count($listdv); $t++) {
												echo '<samp id="cv' . $t . '" lang="' . $listdv[$t] . '"></samp>';
											}

											echo '<samp id="ntc" lang="' . $cc . '"></samp></tr>';
											///// EQUIPOS /////
											?>

						</table>
					</div>




					<div id="fromEquipos" style="width: 100%; height: 100%; overflow: auto; display: none; font-family: Tahoma; font-size: 11px;">
						<table border="0" cellspacing="100px" cellpadding="100px">
							<?
							for ($i = 1; $i <= $cant; $i++) {
								if (($i % 2) == 0) :
									$bkcolor = "#3366CC";
								else :
									$bkcolor = "#BAC6D8";
								endif;
								echo '<tr bgcolor="' . $bkcolor . '"> ';
								echo '<td><div id="np' . $i . '"  lang="' . $np[$i] . '" align="center" style="color:#FFFFFF">' . $np[$i] . '</div><br /></td>';
								$uno = "'min" . $i . "'";
								$dos = "'hora" . $i . "'";
								//  if ($permitirmod): $dis=""; else: $dis="disabled"; endif; 
								echo ' <td>';
								if ($i <= count($hrx)) :
									$hos = explode(':', $hrx[$i]);
									if (count($hos) != 1) :
										echo '<input id="hora' . $i . '" name="textfield"  type="text" size="2" maxlength="2" value="' . $hos[0] . '" onkeypress="focusobjbbg(event,' . $uno . ',1);"  ' . $dis . '>:';
										echo '<input id="min' . $i . '"  name="textfield" type="text" size="2" maxlength="2" value="' . $hos[1] . '"  onkeypress="focusobjbbg(event,' . $dos . ',2);"  ' . $dis . '>';
									else :
										echo '<input id="hora' . $i . '" name="textfield" type="text" size="2" maxlength="2"  onkeypress="focusobjbbg(event,' . $uno . ',1);"  ' . $dis . '>:';
										echo '<input id="min' . $i . '"  name="textfield" type="text" size="2" maxlength="2"  onkeypress="focusobjbbg(event,' . $dos . ',2);"  ' . $dis . '>';
									endif;
								else :

									echo '<input id="hora' . $i . '" name="textfield"  type="text" size="2" maxlength="2" value="" onkeypress="focusobjbbg(event,' . $uno . ',1);"  ' . $dis . '>:';
									echo '<input id="min' . $i . '"  name="textfield" type="text" size="2" maxlength="2" value=""  onkeypress="focusobjbbg(event,' . $dos . ',2);"  ' . $dis . '>';

								endif;
								echo '<br /></td>';
								echo '<td>';
								echo '<div align="center"><select name="select2" size="1" id="equipo' . $i . '" >';
								$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _equiposbb where  ( _equiposbb.Grupo=" . $dp . " or _equiposbb.Grupo1=" . $dp . " or _equiposbb.Grupo2=" . $dp . " ) order by IDE");
								while ($row = mysqli_fetch_array($result)) {
									if ($i <= count($eq1)) {
										echo "<option " . ($eq1[$i] == $row["IDE"] ? " selected='selected'" : " ") . " value=" . $row["IDE"] . ">" . $row["Descripcion"] . "</option>";
									} else {
										echo "<option value=" . $row["IDE"] . ">" . $row["Descripcion"] . "</option>";
									}
								}
								$n = $i + $cant;
								echo  '</select> </div><br /></td><td>
         <div align="center" style="color:#FFFFFF"><strong>vs</strong></div><br /></td>
         <td>
		 <div align="center">
             <select name="select2" size="1" id="equipo' . $n . '" >';
								$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _equiposbb where  ( _equiposbb.Grupo=" . $dp . " or _equiposbb.Grupo1=" . $dp . " or _equiposbb.Grupo2=" . $dp . " ) order by IDE");
								while ($row = mysqli_fetch_array($result)) {
									if ($i <= count($eq2)) {
										echo "<option " . ($eq2[$i] == $row["IDE"] ? " selected='selected'" : " ") . " value=" . $row["IDE"] . ">" . $row["Descripcion"] . "</option>";
									} else {
										echo "<option  value=" . $row["IDE"] . ">" . $row["Descripcion"] . "</option>";
									}
								}
								echo '</select></div>';
								echo '<br /></td>';
								echo '</tr>';
							}



							?>
						</table>
					</div>

					<div id="fromJornada"></div>
					<script>
						function clicktoolBar(id) {
							switch (id) {
								case "Cerrar_":
									dhxWins1.window("w1").close();
									break;
								case "Agregar_":
									dhxWins1.window("w1").close();
									makeResultwin('usuario.php?fc=0&idt=<? echo $idt; ?>', 'tablemenu');
									break;
								case "Modificar_":
									if (idRow != 0) {
										dhxWins1.window("w1").close();
										makeResultwin('usuario.php?fc=' + idRow + '&idt=<? echo $vc; ?>', 'tablemenu');
									} else
										nalert('ERROR', 'DEBE SELECCIONAR PRIMERO EL USUARIO A MODIFICAR!!');
									break;

									//"ImprimirReporte2('reportedeventashipodromo-2.php');"
							}
						}

						function doOnCheck(rowId, cellInd, state) {
							if (state)
								estado = 1;
							else
								estado = 0;
							makeResultwin("chaceStatus.php?SqlStatus=Update _tusu set Estatus=" + estado + " where IDusu=" + rowId, "gridbox");
						}

						function doOnRowSelected(id) {
							idRow = id;
						}

						dhxWins1 = new dhtmlXWindows();
						dhxWins1.setImagePath("codebase/imgs/");
						w1 = dhxWins1.createWindow("w1", 350, 450, 970, 450);
						w1.setText('Configuracion de Jornada BANCA:<? echo $IDB; ?>');
						w1.attachObject('fromJornada');
						dhxWins1.window("w1").button('close').hide();
						/*dhxWins1.window("w1").button('minmax1').hide();
						dhxWins1.window("w1").button('minmax2').hide();*/
						dhxWins1.window("w1").button('park').hide();
						dhxWins1.window('w1').setModal(true);
						var bar = w1.attachToolbar();
						bar.addButton("Cerrar_", 4, "Cerrar", "images/close.gif", "images/close.gif");
						bar.addButton("Agregar_", 1, "Agregar Usuario", "media/user.png", "media/user.png");
						bar.addButton("Modificar_", 1, "Modificar Usuario", "images/page_setup.gif", "images/page_setup.gif");
						bar.attachEvent("onClick", clicktoolBar);

						dhxLayout = w1.attachLayout("2U");
						dhxLayout.cells("a").setText("Partidos");
						dhxLayout.cells("a").setWidth(320);
						dhxLayout.cells("a").attachObject("fromEquipos");
						dhxLayout.cells("b").setText("Logros");

						var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
					</script>
				<?
			else :
				?>
					<script>
						/// Alerta de LLamada no poder acceder!
						nalert('Publicacion ', 'La Publicacion Esta Activada No Puede Modifcar los Logros');
					</script>
				<?
			endif;
				?>