<style type="text/css">
	<!--
	/*- Menu Tabs 1--------------------------- */
	#tabs1 {
		float: left;
		width: 100%;
		background: #F4F7FB;
		font-size: 93%;
		line-height: normal;
		border-bottom: 1px solid #BCD2E6;
	}

	#tabs1 ul {
		margin: 0;
		padding: 0px 10px 0 0px;
		list-style: none;
	}

	#tabs1 li {
		display: inline;
		margin: 10;
		padding: 0;
	}

	#tabs1 a {
		float: left;
		background: url("tableft1.gif") no-repeat left top;
		margin: 0;
		padding: 0 0 0 4px;
		text-decoration: none;
	}

	#tabs1 a span {
		float: left;
		display: block;
		background: url("tabright1.gif") no-repeat right top;
		padding: 5px 15px 4px 6px;
		color: #627EB7;
	}

	/* Commented Backslash Hack hides rule from IE5-Mac \*/
	#tabs1 a span {
		float: none;
	}

	/* End IE5-Mac hack */
	#tabs a:hover span {
		color: #627EB7;
	}

	#tabs1 a:hover {
		background-position: 0% -42px;
	}

	#tabs1 a:hover span {
		background-position: 100% -42px;
	}

	.shadowcontainer {
		width: 500px;
		/* container width*/
		background-color: #d1cfd0;
	}

	.shadowcontainer2 {
		width: 428px;
		/* container width*/
		background-color: #d1cfd0;
	}

	.shadowcontainer .innerdiv {
		/* Add container height here if desired */
		background-color: white;
		border: 1px solid gray;
		padding: 6px;
		position: relative;
		left: -5px;
		/*shadow depth*/
		top: -5px;
		/*shadow depth*/

	}

	.shadowcontainer2 .innerdiv2 {
		/* Add container height here if desired */
		background-color: white;
		border: 1px solid gray;
		padding: 6px;
		position: relative;
		left: -5px;
		/*shadow depth*/
		top: -5px;
		/*shadow depth*/
	}

	.Estilo17 {
		font-family: Verdana, Arial, Helvetica, sans-serif;
		font-size: 12px;
		font-weight: bold;
		color: #FFFFFF
	}

	.Estilo23 {
		font-size: 12px;
		font-weight: bold;
		color: #FFFFFF
	}

	.Estilo50 {
		font-family: "Times New Roman", Times, serif;
		font-weight: bold;
		font-size: 14px;
		color: #FFFFFF
	}

	.Estilo51 {
		color: #FFFFFF;
		font-size: 12px;
		text-align: left
	}

	.EstiloCodigo {
		color: #FFFF00;
		font-size: 16px
	}

	.Estilo53 {
		color: #FFFFFF;
		font-weight: bold;
		font-size: 12px;
	}
	-->
</style>

</head>

<?php

$pfc = $_REQUEST['fc'];
/* parametros de FC
fc = 0 ... Incluir
fc >= 1 ... Busca el registo para modificar o eliminar si existe */

require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$idt = $_REQUEST['idt'];
$accesogp = accesolimitado($idt);


if ($pfc == 0) :

	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tusu Order by IDusu DESC ");

	if (mysqli_num_rows($result) != 0) :
		$row = mysqli_fetch_array($result);
		$idu = $row["IDusu"] + 1;
	else :
		$idu = 1;
	endif;
	$us = "";
	$nm = "";
	$clv = "";
	$rcl = "";
	$est = "";
	$tp = 1;
	$as = "";
	$es = "";
	$blq = $row["bloqueado"];
	$v = array();
	$v2 = array();
	$ip = 0;
else :


	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tusu where IDusu=" . $pfc);

	$row = mysqli_fetch_array($result);
	$idu = $row["IDusu"];
	$us = $row["Usuario"];
	$nm = $row["Nombre"];
	$clv = $row["clave"];
	$rcl = $row["clave"];
	$est = $row["Estacion"];
	$tp = $row["Tipo"];
	$as = $row["Asociado"];
	$es = $row["Estatus"];
	$blq = $row["bloqueado"];
	$v = explode("|", $row['Acceso']);
	$v2 = explode("-", $row['AccesoP']);
	if ($tp == 4) :  $ip = $row["AGrupo"];
	else : $ip = 0;
	endif;
endif;

?>

<div id="box1" style="width:415px; background:#069">
	<table width="412" border="0" cellspacing="0 ">
		<tr>
			<th colspan="6">
				<div align="center"><span class="Estilo17">Agregar Usuario</span></div>
			</th>
		</tr>
		<tr>
			<th colspan="6" class="subHeader">
				<div align="center"><span class="Estilo23">DATOS DEL USUARIOS</span></div>
			</th>
		</tr>
		<tr>
			<th width="163"><span class="Estilo51">Código</span></th>
			<td width="169" colspan="5" id="n_idu" title=" <?php echo $idu; ?>"><strong><span class="EstiloCodigo"><?php echo $idu; ?></span></strong></td>
		</tr>

		<tr>
			<th class="Estilo51"><span class="Estilo51">Nombre del Usuario</span></th>
			<td colspan="5" class="ta_conc_td">
				<font color="red">
					<input name="Usuario" type="text" id="usuario" size="10" maxlength="10" onchange="validar3(event)" onkeyup="pulsart(event,'nombre'); validar3(event);" value='<?php echo $us; ?>' onkeypress="if (permite(event,'num_car3')) {return true;}else{return false;}" />
					*
				</font> <img id="imgusuario" src="media/serro.png" height="16" width="16" style="display:none" title="" />
			</td>
		</tr>
		<tr>
			<th class="Estilo51"><span class="Estilo51">Nombre</span></th>
			<td colspan="5" class="ta_conc_td">
				<font color="red">
					<input name="Nombre" type="text" id="nombre" onchange="validar3(event)" onkeyup="pulsart(event,'clave'); validar3(event)" value='<?php echo $nm; ?>' />
					*
				</font> <img id="imgnombre" src="media/serro.png" height="16" width="16" style="display:none" title="" />
			</td>
		</tr>
		<tr>
			<th class="Estilo51"><span class="Estilo51">Clave</span></th>
			<td colspan="5" class="ta_conc_td"><input name="Clave" type="password" id="clave" onchange="validar3(event)" onkeyup="pulsart(event,'rep'); validar3(event)" value='<?php echo $clv; ?>' />
				<font color="red">*</font> <img id="imgclave" src="media/serro.png" height="16" width="16" style="display:none" title="" />
			</td>
		</tr>
		<tr>
			<th class="Estilo51"><span class="Estilo51">Repetir Clave</span></th>
			<td colspan="5" class="ta_conc_td"><input name="Clave" type="password" id="rep" onchange="clave(event)" onkeyup="pulsart(event,'estacion'); clave(event)" value='<?php echo $rcl; ?>' />
				<font color="red">*</font> <img id="imgrep" src="media/serro.png" style="display:none" title="" height="16" width="16" />
			</td>
		</tr>
		<tr>
			<th class="Estilo51"><span class="Estilo51">Estacion</span></th>
			<td colspan="5" class="ta_conc_td">
				<font color="red">
					<input name="Nombre" type="text" id="estacion" onfocus="" onchange="validar3(event)" onkeyup="pulsart(event,'estacion'); validar3(event)" value='<?php echo $est; ?>' />
					*
				</font> <img id="imgestacion" src="media/serro.png" style="display:none" height="16" width="16" title="" />
			</td>
		</tr>


		<tr>
			<th class="Estilo51"><span class="Estilo51">Tipo de Usuario </span></th>
			<td colspan="5" class="ta_conc_td">
				<font color="red">

					<select name="select2" id="tipo" onchange="cambiarperfil(<? echo $accesogp ?>);">
						<? if ($accesogp == 0) : ?>
							<option onclick="habilitar()" value="1" <?php echo ($tp == 1 ? " selected='selected'" : " "); ?>>Usuario</option>
							<option onclick="habilitar()" value="2" <?php echo ($tp == 2 ? " selected='selected'" : " "); ?>>Administrador</option>
							<option onclick="habilitar()" value="3" <?php echo ($tp == 3 ? " selected='selected'" : " "); ?>>Vendedor</option>
							<option onclick="habilitar()" value="4" <?php echo ($tp == 4 ? " selected='selected'" : " "); ?>>Admon. Grupo</option>
							<option onclick="habilitar()" value="5" <?php echo ($tp == 5 ? " selected='selected'" : " "); ?>>Sistema</option>
						<? else :
							$tp = 3;
						?>
							<option onclick="habilitar()" value="3" <?php echo ($tp == 3 ? " selected='selected'" : " "); ?>>Vendedor</option>
						<? endif; ?>
					</select>
				</font>
			</td>
		</tr>
		<tr>
			<th class="Estilo51"><span class="Estilo51">Asociado</span></th>
			<td colspan="5" class="ta_conc_td"><?php
												if ($tp == 3) {
													echo "<select name='select2' id='asoc' onchange='habilitar()'>";
													if ($accesogp == 0) :
														$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionario order by IDC");
													else :
														$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionario where IDG=" . $accesogp . " order by IDC");
													endif;
													while ($row = mysqli_fetch_array($result)) {
														echo "<option " . ($as == $row["IDC"] ? " selected='selected'" : " ") . " value=" . $row["IDC"] . ">" . $row["IDC"] . "</option>";
													}
													echo "</select>";
												} else {
													echo "<select name='select2' id='asoc' disabled='disabled' onchange='habilitar()'>";
													$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionario order by IDRow desc");
													while ($row = mysqli_fetch_array($result)) {
														echo "<option " . ($as == $row["IDC"] ? " selected='selected'" : " ") . " value=" . $row["IDC"] . ">" . $row["IDC"] . "</option>";
													}
													echo "</select>";
												}
												?></td>
		</tr>
		<tr>
			<th class="Estilo51">Estatus</th>
			<td colspan="5" bordercolor="#FFFFFF" class="ta_conc_td"><select name="select" size="1" id="estatus">
					<option value="1" <?php echo ($es == 1 ? " selected='selected'" : " "); ?>>Activo</option>
					<option value="2" <?php echo ($es == 2 ? " selected='selected'" : " "); ?>>Suspendido</option>
				</select></td>
		</tr>
		<tr>
			<th colspan="5" class="Estilo51"><input name='acceso' type='checkbox' id='acceso' onclick="if ($('tipo').value=='4') {if (this.checked) {$('GrupoK').style.display='';}else{$('GrupoK').style.display='none';} }else{ alert('Para Habilitar esta Opcion el Tipo de Usuario debe ser Administrador de  Grupo'); this.checked=false;}" <? if ($ip != 0) : echo 'checked="checked"';
																																																																																					endif; ?> />

				Administrador del Grupo</th>
			<th colspan="5" class="Estilo51"><select name="select" id="GrupoK" <? if ($ip == 0) : echo 'style="display:none"';
																				endif; ?>><?
																							$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tgrupo order by IDG ");
																							while ($row = mysqli_fetch_array($result)) {
																								echo "<option " . ($ip == $row["IDG"] ? " selected='selected'" : " ") . " value=" . $row["IDG"] . ">" . $row["IDG"] . '-' . $row["Descrip"] . "</option>";
																							} ?>
				</select>
			</th>
		</tr>
		<tr>
			<th colspan="6" class="Estilo51"><?php if (!$pfc == 0) :
													echo  "<input id='btnguardar'  value='Modificar' type='submit'  onclick='grabar_usuario();'/>";
													echo  "<input id='btneliminar'  value='Eliminar ' type='submit'  onclick='elimnar_usuario();'/>";
												else :
													echo  "<input id='btnguardar'  value='Guardar Nuevo Usuario' type='submit'  disabled='disabled'  onclick='grabar_usuario();'/>";
												endif;
												$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tdjuegos where Estatus=1 order by IDJug");

												?>
				<input name="submit_regresar22" value="&lt;-Volver" title="<?php echo $pfc; ?> " onclick="javascript:makeRequest('usuario-1-1.php');" type="button" />
			</th>
		</tr>
	</table>
	<p>&nbsp;</p>
</div>

<br><br><br>
<div id="box12" style="width:415px; background: #333">
	<div id="TabbedPanels1" class="TabbedPanels">
		<ul class="TabbedPanelsTabGroup">
			<li class="TabbedPanelsTab" tabindex="0" style="font-size:12px"><span id="SPH" title="<?php echo mysqli_num_rows($result); ?>">HIPISMO</span></li>
			<li class="TabbedPanelsTab" tabindex="0" style="font-size:12px">Ganadores</li>
			<li class="TabbedPanelsTab" tabindex="0" style="font-size:12px">Deportes</li>
		</ul>
		<div class="TabbedPanelsContentGroup">
			<div class="TabbedPanelsContent">
				<?php
				$key = array_search('1', $v2);
				$check = 'checked="checked"';
				$sty = '';
				if ($key === false) :
					$check = '';
					$sty = 'style="display:none"';
				endif;
				?>
				<div style="font-size:12px" onclick="MM_effectHighlight(this, 1000, '#ffffff', '#ff0000', '#ffffff', true)">
					<input id="sph" name="" type="checkbox" value="" <?php echo $check; ?> onclick="if ($('lis1').style.display=='none') {$('lis1').style.display='';}else{$('lis1').style.display='none';}" />
					Habilitado
				</div>
				<div id="lis1" <?php echo $sty; ?>>
					<table width="486" cellspacing="0">
						<tr bgcolor="#F4F7FB">
							<th colspan="6" align="left" bgcolor="F4F7FB"> </th>
						</tr>
						<tr>
							<th width="126">
								<div align="center" style="color:#000000">Jugada</div>
							</th>
							<td width="47">&nbsp;</td>
							<th align="left">
								<div id="DatosSPH" title="<?php $result1 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tmenu where Modulo='SPH' ");
															echo  mysqli_num_rows($result1); ?>" align="center" style="color:#000000">Otros</div>
							</th>
							<td width="30" align="right" class="Estilo50">
								<div align="center"></div>
							</td>
						</tr>

						<?php
						switch ($tp) {
							case 1:
								$campo = 'Usuario';
								break;
							case 2:
								$campo = 'Administrador';
								break;
							case 3:
								$campo = 'Vendedor';
								break;
							case 4:
								$campo = 'Info';
								break;
							case 5:
								$campo = 'Sistema';
								break;
						}
						$totaldesph = mysqli_num_rows($result1);
						$arrn = 1;
						$cot = 1;
						$arra1 = array();
						$resultS = mysqli_query($GLOBALS['link'], " SELECT SUBMODULO  FROM _tmenu where Modulo='SPH' Group by SUBMODULO");
						while ($row = mysqli_fetch_array($resultS)) {


							$result1 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tmenu where Modulo='SPH' and Submodulo='" . $row['SUBMODULO'] . "'");
							$cj = 1;
							while ($row = mysqli_fetch_array($result1)) {
								$arra1[$arrn][$cj] = $row["Descripcion"] . "|o" . $cot . '|' . $row["variable"];
								$cj++;
								$cot++;
							}
							$arrn++;
						}


						$i = 1;
						$j = 1;
						$ji = 1;
						$rt = 1;
						$dete = true;
						while ($row = mysqli_fetch_array($result)) {
							if ($i == 1) :
								$bkcolor = '#E2E7EF';
								$i = 2;
							else :
								$bkcolor = '#FFFFFF';
								$i = 1;
							endif;
							$en = "checked";
							for ($ii = 0; $ii <= count($v) - 1; $ii++) {
								$nivel = substr($v[$ii], 2, 1);
								if ($nivel == '1') :
									$nivel = substr($v[$ii], 3);
									if ($nivel == $row["IDJug"]) :
										$en = '';
										break;
									endif;
								endif;
							}
							echo '<tr>';
							echo  '<th align="left" bgcolor="' . $bkcolor . '" style="color:#000000">' . $row["Descrip"] . '</th>';
							echo  '<th align="left" bgcolor="' . $bkcolor . '"  style="color:#000000"><div align="center">';
							echo  '<input type="checkbox" id="j' . $j . '"  title="' . $row["IDJug"] . '" value="checkbox" ' . $en . ' />';
							echo  '</div></th>';
							if ($dete) :
								$expo = explode('|', $arra1[$rt][$ji]);

								$resultMENU = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tmenu where variable='" . $expo[2] . "' and " . $campo . "=1");

								if (mysqli_num_rows($resultMENU) != 0) :
									$en = "checked";
								else :
									if (count($v) != 0) :
										$en = "checked";
									else :
										$en = '';
									endif;
								endif;
								for ($ii = 0; $ii <= count($v) - 1; $ii++) {
									if ($v[$ii] == $expo[2]) :
										$en = '';
										break;
									endif;
								}


								echo  '<td align="center" bgcolor="' . $bkcolor . '" style="color:#000000">' . $expo[0] . '</td>';
								echo  '<td align="center" bgcolor="' . $bkcolor . '" style="color:#000000"><div align="center">';
								echo  '<input type="checkbox" id="' . $expo[1] . '"  title="' . $expo[2] . '" value="checkbox" ' . $en . '/>';
								echo  '</div></th>';
							else :
								echo  '<td align="center" bgcolor="' . $bkcolor . '" ></td>';
								echo  '<td align="center" bgcolor="' . $bkcolor . '" ></td>';
							endif;
							//  echo  '<td align="center" bgcolor="'.$bkcolor.'" >&nbsp;</td>';		 
							//  echo '</tr>';
							if ($ji <= count($arra1[$rt]) - 1) :
								$ji++;
							else :
								if ($rt <= count($arra1) - 1) :
									$rt++;
									$ji = 1;
								else :
									$dete = false;
								endif;
							endif;
							$j++;
						}
						/*   print_r($arra1[2]);   */
						for ($uu = $rt; $uu <= (count($arra1[$rt])); $uu++) {
							if ($i == 1) :
								$bkcolor = '#E2E7EF';
								$i = 2;
							else :
								$bkcolor = '#FFFFFF';
								$i = 1;
							endif;
							echo '<tr>';
							echo  '<th align="left" bgcolor="' . $bkcolor . '" class="Estilo51"></th>';
							echo  '<th align="left" bgcolor="' . $bkcolor . '"  class="Estilo51"></th>';
							if ($dete) :
								$expo = explode('|', $arra1[$rt][$ji]);
								$resultMENU = mysqli_query($GLOBALS['link'], " SELECT *  FROM _tmenu where variable='" . $expo[2] . "' and " . $campo . "=1");
								if (mysqli_num_rows($resultMENU) != 0) :
									$en = "checked";
								else :
									if (count($v) != 0) :
										$en = "checked";
									else :
										$en = '';
									endif;
								endif;
								for ($ii = 0; $ii <= count($v) - 1; $ii++) {
									if ($v[$ii] == $expo[2]) :
										$en = '';
										break;
									endif;
								}
								echo  '<td align="center" bgcolor="' . $bkcolor . '" >' . $expo[0] . '</td>';
								echo  '<td align="center" bgcolor="' . $bkcolor . '" ><div align="center">';
								echo  '<input type="checkbox" id="' . $expo[1] . '"  title="' . $expo[2] . '" value="checkbox" ' . $en . '/>';
								echo  '</div></th>';
							else :
								echo  '<td align="center" bgcolor="' . $bkcolor . '" ></td>';
								echo  '<td align="center" bgcolor="' . $bkcolor . '" ></td>';
							endif;
							if ($ji <= count($arra1[$rt]) - 1) :
								$ji++;
							else :
								if ($rt <= count($arra1)) :
									$rt++;
									$ji = 1;
								else :
									$dete = false;
								endif;
							endif;
							$j++;
						}

						for ($uu = $rt; $uu <= (count($arra1[$rt])); $uu++) {
							if ($i == 1) :
								$bkcolor = '#E2E7EF';
								$i = 2;
							else :
								$bkcolor = '#FFFFFF';
								$i = 1;
							endif;
							echo '<tr>';
							echo  '<th align="left" bgcolor="' . $bkcolor . '" class="Estilo51"></th>';
							echo  '<th align="left" bgcolor="' . $bkcolor . '"  class="Estilo51"></th>';
							if ($dete) :
								$expo = explode('|', $arra1[$rt][$ji]);
								$resultMENU = mysqli_query($GLOBALS['link'], " SELECT *  FROM _tmenu where variable='" . $expo[2] . "' and " . $campo . "=1");
								if (mysqli_num_rows($resultMENU) != 0) :
									$en = "checked";
								else :
									if (count($v) != 0) :
										$en = "checked";
									else :
										$en = '';
									endif;
								endif;
								for ($ii = 0; $ii <= count($v) - 1; $ii++) {
									if ($v[$ii] == $expo[2]) :
										$en = '';
										break;
									endif;
								}
								echo  '<td align="center" bgcolor="' . $bkcolor . '" >' . $expo[0] . '</td>';
								echo  '<td align="center" bgcolor="' . $bkcolor . '" ><div align="center">';
								echo  '<input type="checkbox" id="' . $expo[1] . '"  title="' . $expo[2] . '" value="checkbox" ' . $en . '/>';
								echo  '</div></th>';
							else :
								echo  '<td align="center" bgcolor="' . $bkcolor . '" ></td>';
								echo  '<td align="center" bgcolor="' . $bkcolor . '" ></td>';
							endif;
							if ($ji <= count($arra1[$rt]) - 1) :
								$ji++;
							else :
								if ($rt <= count($arra1)) :
									$rt++;
									$ji = 1;
								else :
									$dete = false;
								endif;
							endif;
							$j++;
						}
						?>
					</table>
				</div>
			</div>
			<div class="TabbedPanelsContent">
				<?php
				$key = array_search('2', $v2);
				$check = 'checked="checked"';
				$sty = '';
				if ($key === false) :
					$check = '';
					$sty = 'style="display:none"';
				endif;
				?>
				<div style="font-size:12px" onclick="MM_effectHighlight(this, 1000, '#ffffff', '#ff0000', '#ffffff', true)">
					<input id="ganadores" name="" type="checkbox" value="" <?php echo $check; ?> onclick="if ($('lis2').style.display=='none') {$('lis2').style.display='';}else{$('lis2').style.display='none';}" />
					Habilitado
				</div>
				<div id="lis2" <?php echo $sty; ?>>



				</div>



			</div>


			<div class="TabbedPanelsContent">
				<?php
				$key = array_search('3', $v2);
				$check = 'checked="checked"';
				$sty = '';
				if ($key === false) :
					$check = '';
					$sty = 'style="display:none"';
				endif;
				?>
				<div style="font-size:12px" onclick="MM_effectHighlight(this, 1000, '#ffffff', '#ff0000', '#ffffff', true)">
					<input id="deportes" name="" type="checkbox" value="" <?php echo $check; ?> onclick="if ($('lis3').style.display=='none') {$('lis3').style.display='';}else{$('lis3').style.display='none';}" />
					Habilitado
				</div>
				<div id="lis3" <?php echo $sty; ?>>
					<table cellspacing="0">
						<tr>
							<th align="left" class="Estilo51">
								<div id="Deportesl" title="<?php $result1 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tmenu where Modulo='DEPORTES' ");
															echo mysqli_num_rows($result1); ?>" align="center" style="color:#000000">Menu</div>
							</th>
							<th width="30" align="right" class="Estilo50">
								<div align="center"></div>
							</th>
						</tr>
						<?php
						switch ($tp) {
							case 1:
								$campo = 'Usuario';
								break;
							case 2:
								$campo = 'Administrador';
								break;
							case 3:
								$campo = 'Vendedor';
								break;
							case 4:
								$campo = 'Info';
								break;
							case 5:
								$campo = 'Sistema';
								break;
						}
						$arrn = 1;
						$cot = 1;
						$arra1 = array();
						$resultS = mysqli_query($GLOBALS['link'], " SELECT SUBMODULO  FROM _tmenu where Modulo='DEPORTES' Group by SUBMODULO");
						while ($row = mysqli_fetch_array($resultS)) {


							$result1 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tmenu where Modulo='DEPORTES' and Submodulo='" . $row['SUBMODULO'] . "'");
							$cj = 1;
							while ($row = mysqli_fetch_array($result1)) {
								$arra1[$arrn][$cj] = $row["Descripcion"] . "|d" . $cot . '|' . $row["variable"];
								$cj++;
								$cot++;
							}
							$arrn++;
						}


						$i = 1;
						$j = 1;
						$ji = 1;
						$rt = 1;
						$dete = true;
						while ($row = mysqli_fetch_array($result)) {
							if ($i == 1) :
								$bkcolor = '#E2E7EF';
								$i = 2;
							else :
								$bkcolor = '#FFFFFF';
								$i = 1;
							endif;
							$en = "checked";
							for ($ii = 0; $ii <= count($v) - 1; $ii++) {
								$nivel = substr($v[$ii], 2, 1);
								if ($nivel == '1') :
									$nivel = substr($v[$ii], 3);
									if ($nivel == $row["IDJug"]) :
										$en = '';
										break;
									endif;
								endif;
							}

							if ($dete) :
								$expo = explode('|', $arra1[$rt][$ji]);

								$resultMENU = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tmenu where variable='" . $expo[2] . "' and " . $campo . "=1");

								if (mysqli_num_rows($resultMENU) != 0) :
									$en = "checked";
								else :
									if (count($v) != 0) :
										$en = "checked";
									else :
										$en = '';
									endif;
								endif;
								for ($ii = 0; $ii <= count($v) - 1; $ii++) {
									if ($v[$ii] == $expo[2]) :
										$en = '';
										break;
									endif;
								}

								if ($accesogp != 0) :
									$en2 = 'disabled="disabled"';
								else :
									$en2 = '';
								endif;
								echo  '<td align="center" bgcolor="' . $bkcolor . '" >' . $expo[0] . '</td>';
								echo  '<td align="center" bgcolor="' . $bkcolor . '" ><div align="center">';
								echo  '<input type="checkbox" id="' . $expo[1] . '"  title="' . $expo[1] . '" value="checkbox" ' . $en . ' ' . $en2 . '/>';
								echo  '</div></th>';
							else :
								echo  '<td align="center" bgcolor="' . $bkcolor . '" ></td>';
								echo  '<td align="center" bgcolor="' . $bkcolor . '" ></td>';
							endif;
							//  echo  '<td align="center" bgcolor="'.$bkcolor.'" >&nbsp;</td>';		 
							//  echo '</tr>';
							if ($ji <= count($arra1[$rt]) - 1) :
								$ji++;
							else :
								if ($rt <= count($arra1) - 1) :
									$rt++;
									$ji = 1;
								else :
									$dete = false;
								endif;
							endif;
							$j++;
						}

						for ($uu = $rt; $uu <= (count($arra1[$rt])); $uu++) {
							if ($i == 1) :
								$bkcolor = '#E2E7EF';
								$i = 2;
							else :
								$bkcolor = '#FFFFFF';
								$i = 1;
							endif;
							echo '<tr>';
							echo  '<th align="left" bgcolor="' . $bkcolor . '" class="Estilo51"></th>';
							echo  '<th align="left" bgcolor="' . $bkcolor . '"  class="Estilo51"></th>';
							if ($dete) :
								$expo = explode('|', $arra1[$rt][$ji]);


								$resultMENU = mysqli_query($GLOBALS['link'], " SELECT *  FROM _tmenu where variable='" . $expo[2] . "' and " . $campo . "=1");
								if (mysqli_num_rows($resultMENU) != 0) :
									$en = "checked";
								else :
									if (count($v) != 0) :
										$en = "checked";
									else :
										$en = '';
									endif;
								endif;
								for ($ii = 0; $ii <= count($v) - 1; $ii++) {
									if ($v[$ii] == $expo[2]) :
										$en = '';
										break;
									endif;
								}
								if ($accesogp != 0) :
									$en2 = 'disabled="disabled"';
								else :
									$en2 = '';
								endif;
								echo '<tr>';
								echo  '<td align="center" bgcolor="' . $bkcolor . '" >' . $expo[0] . '</td>';
								echo  '<td align="center" bgcolor="' . $bkcolor . '" ><div align="center">';
								echo  '<input type="checkbox" id="' . $expo[1] . '"  title="' . $expo[2] . '" value="checkbox" ' . $en . ' ' . $en2 . '/>';
								echo  '</div></tr>';
							else :
								echo '<tr>';
								echo  '<td align="center" bgcolor="' . $bkcolor . '" ></td>';
								echo  '<td align="center" bgcolor="' . $bkcolor . '" ></td>';
								echo  '</tr>';
							endif;
							if ($ji <= count($arra1[$rt]) - 1) :
								$ji++;
							else :
								if ($rt <= count($arra1) - 1) :
									$rt++;
									$ji = 1;
								else :
									$dete = false;
								endif;
							endif;
							$j++;
						}
						?>
					</table>
				</div>
			</div>
		</div>
	</div>

	<p id='estuu' class="Estilo13">&nbsp;</p>
</div>

<script type="text/javascript">
	Nifty('div#box1', 'big');
	Nifty('div#box12', 'big');
	var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
</script>