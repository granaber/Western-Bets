<?php
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$descripcion = '';
$sgl = '';
$gp1 = 0;
$gp2 = 0;
$gp = 0;
$fle1 = '';
$fle2 = '';
if (isset($_GET['grupo_nw'])) :
	$gp = $_GET['grupo_nw'];
endif;

if (!isset($_GET['grupo'])) :
	$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _equiposbb Order by IDE Desc");
	if (mysqli_num_rows($resultj) != 0) :
		$rowj = mysqli_fetch_array($resultj);
		$idg = $rowj["IDE"] + 1;
	else :
		$idg = 1;
	endif;
else :
	$idg = $_REQUEST['grupo'];
	$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _equiposbb where IDE=" . $idg);
	$rowj = mysqli_fetch_array($resultj);
	$descripcion = $rowj['Descripcion'];
	$sgl = $rowj['Siglas'];
	$gp = $rowj['Grupo'];
	$gp1 = $rowj['Grupo1'];
	$gp2 = $rowj['Grupo2'];
	$fle1 = 'eq' . $idg . '.png';

endif;
$ncl = $idg;
$ncl = str_repeat("0", 8 - strlen($ncl)) . $ncl;


?>
<style type="text/css">
	<!--
	.Estilo1 {
		color: #FFFFFF;
		font-weight: bold;
	}
	-->
</style>









<div id="box7">
	<table width="818" border="0">
		<tr>
			<th colspan="5" scope="col">Equipo <div id="estado"></div>
			</th>
		</tr>
		<tr>
			<td width="91">No. Equipo</td>
			<td colspan="2"> <samp id="IDE" lang="<?php echo $idg; ?>" style="color: #FFFF00; font-size:16px; "><strong><?php echo $ncl; ?></strong></samp></td>
			<td>&nbsp;</td>
			<td>
				<div align="center" class="Estilo1" style="background:#666666; font-size:12px">Pertenece al Deporte de:</div>
			</td>
		</tr>
		<tr>
			<td>
				<p>Descripcion</p>
				<p>Siglas:</p>
				<p>Imagen:</p>
			</td>
			<td colspan="2">
				<span id="Descrip">
					<input type="text" name="text2" id="Descripcion" value="<?php echo $descripcion; ?>" />
					<span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no valido.</span></span>
				<p><span id="Sig">
						<input type="text" name="text1" id="Siglas" value="<?php echo $sgl; ?>" />
						<span class="textfieldInvalidFormatMsg">Formato no valido.</span><span class="textfieldRequiredMsg">Se necesita un valor.</span></span> &nbsp;</p>
				<form id="fromiut" method="post" enctype="multipart/form-data" action="controlUpload3.php" target="iframeUpload">
					<input name="fileUpload" type="file" id="imagen" lang="<?php echo $fle1; ?>" onchange="uploadFile2(this);" value="<?php echo $fle1; ?>"><iframe name="iframeUpload" style="display:none"></iframe><img id='imgver' src="images/logo/<?php echo $fle1; ?>?<?php echo md5(time()); ?>" />
				</form> �
			</td>
			<td width="27"></td>
			<td width="333">
				<div id="CollapsiblePanel1" class="CollapsiblePanel">
					<div class="CollapsiblePanelTab" tabindex="0" style="font-size:14px; background:  #0099CC; color:#FFFFFF ">Deporte 1: </div>
					<div class="CollapsiblePanelContent"><?php
															$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _gruposdd Order by Grupo");
															$vri = "'Grupo'";
															while ($Row = mysqli_fetch_array($resultj)) {
																$vc = '';
																if ($Row['Grupo'] == $gp) :
																	$vc = 'checked';
																endif;
																echo '<input id="d1' . $Row['Grupo'] . '" name="r1" type="radio" onclick="$(' . $vri . ').value=$(this).value;" value="' . $Row['Grupo'] . '" ' . $vc . '/> <img  src="media/' . $Row['imagen'] . '"  height="32" width="32" />&nbsp;&nbsp;' . $Row['Descripcion'];
																echo '<br>';
															}

															?>
						<input id="Grupo" type="text" style="display:none" value="<?php echo $gp; ?>" />
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="2"> </td>
			<td>&nbsp;</td>
			<td>
				<div id="CollapsiblePanel2" class="CollapsiblePanel">
					<div class="CollapsiblePanelTab" tabindex="0" style="font-size:14px; background:  #99CC33; color:#FFFFFF ">Deporte 2: </div>
					<div class="CollapsiblePanelContent"><?php
															$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _gruposdd Order by Grupo");
															$vc = '';
															if (0 == $gp1) :
																$vc = 'checked';
															endif;
															echo '<input id="d20" name="r2" type="radio" value="" ' . $vc . '/>&nbsp;NO APLICA<br>';
															$vri = "'Grupo1'";
															while ($Row = mysqli_fetch_array($resultj)) {
																$vc = '';
																if ($Row['Grupo'] == $gp1) :
																	$vc = 'checked';
																endif;
																echo '<input id="d2' . $Row['Grupo'] . '" name="r2" type="radio"  onclick="$(' . $vri . ').value=$(this).value;" value="' . $Row['Grupo'] . '" ' . $vc . '/> <img  src="media/' . $Row['imagen'] . '"  height="32" width="32" />&nbsp;&nbsp;' . $Row['Descripcion'];
																echo '<br>';
															}

															?>
						<input id="Grupo1" type="text" style="display:none" value="<?php echo $gp1; ?>" />
					</div>
				</div>
			</td>
		</tr>


		<tr>
			<td>&nbsp;</td>
			<td colspan="2"> </td>
			<td>&nbsp;</td>
			<td>
				<div id="CollapsiblePanel3" class="CollapsiblePanel">
					<div class="CollapsiblePanelTab" tabindex="0" style="font-size:14px; background:#CC0033; color:#FFFFFF ">Deporte 3: </div>
					<div class="CollapsiblePanelContent"><?php
															$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _gruposdd Order by Grupo");
															$vc = '';
															if (0 == $gp2) :
																$vc = 'checked';
															endif;
															echo '<input id="d30" name="r3" type="radio" value="" ' . $vc . '/>&nbsp;NO APLICA<br>';
															$vri = "'Grupo2'";
															while ($Row = mysqli_fetch_array($resultj)) {
																$vc = '';
																if ($Row['Grupo'] == $gp2) :
																	$vc = 'checked';
																endif;
																echo '<input id="d2' . $Row['Grupo'] . '" name="" type="radio"  onclick="$(' . $vri . ').value=$(this).value;"  value="' . $Row['Grupo'] . '" ' . $vc . '/> <img  src="media/' . $Row['imagen'] . '"  height="32" width="32" />&nbsp;&nbsp;' . $Row['Descripcion'];
																echo '<br>';
															}

															?>
						<input id="Grupo2" type="text" style="display:none" value="<?php echo $gp2; ?>" />
					</div>
				</div>
			</td>
		</tr>
	</table>

</div>
<p>&nbsp;</p>
<div id="box8">
	<table width="500" border="0">
		<tr>
			<th width="274" scope="col">
				<input type="submit" name="button2" id="button2" onclick="opmenu('listadeequipos.php');" value="<--Regresar" />
			</th>
			<th width="216" colspan="3" scope="col">
				<div align="right">
					<input type="submit" name="button" id="button" value="Grabar" onclick="grabar_cnf1(4,'IDE.lang|Descripcion.value|Siglas.value|Grupo.value|Grupo1.value|Grupo2.value|imagen.lang','_equiposbb');" />
				</div>
			</th>
		</tr>
	</table>
</div>
<p>&nbsp;</p>
<script>
	Nifty('div#box7', 'big');
	Nifty('div#box8', 'big');
	var sprytextfield1 = new Spry.Widget.ValidationTextField("Sig", "custom", {
		validateOn: ["blur", "change"],
		pattern: "AAA",
		useCharacterMasking: true
	});
	var sprytextfield2 = new Spry.Widget.ValidationTextField("Descrip", "custom", {
		validateOn: ["blur", "change"],
		useCharacterMasking: true
	});

	var CollapsiblePanel1 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel1");
	var CollapsiblePanel2 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel2", {
		contentIsOpen: false
	});
	var CollapsiblePanel3 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel3", {
		contentIsOpen: false
	});
	$('Descripcion').focus();
	$('Descripcion').select();
</script>