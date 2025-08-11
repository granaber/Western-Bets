<?
date_default_timezone_set('America/Caracas');
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$masde = false;
$result3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfjornadahi where Estatus=1 and fecha='" . Fechareal(0, "d/n/Y") . "' order by IDCN");
if (mysqli_num_rows($result3) != 0) :


	if (mysqli_num_rows($result3) > 1) :
		$masde = true;
	endif;

	$row = mysqli_fetch_array($result3);
	$idhipo = $row["IDhipo"];
	$CantCarr = $row["Cantcarr"];
	$IDCN = $row["IDCN"];

	$result3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfighi where IDCN=" . $IDCN);
	if (mysqli_num_rows($result3) != 0) :
		$row = mysqli_fetch_array($result3);
		$caticabb = explode('|', $row['_Fab']);
		$retirado = explode('|', $row['_Ret']);
	endif;

else :
	$CantCarr = 0;
endif;
$hipodromosArray = array();
$codeHipo = array();
?>
<style type="text/css">
	.dhx_toolbar_base_dhx_skyblue {
		height: 80px !important;
		background-image: url(common/toolbar33/dhxtoolbar_bg_33px.gif);
	}

	-->
</style>
<div id="fromGanadores" style="font-size:16px; background: #CCC; height:1000px">


	<samp id="TIDCN" lang="<? echo $IDCN; ?>" align="center" style="color: #FFFFFF; font-size:17px"></samp>

	<table width="180" border="0" cellspacing="4" cellpadding="4">
		<tr>
			<td>
				<div id="fromDatos" style="background: #069">
					<table width="180" border="0" cellspacing="4" cellpadding="4">
						<tr>
							<td><span style="color:#FFCC00">Ticket: </span></td>
							<td><span id='numet' title="" style="color: #FFCC00"> </span></td>
						</tr>
						<?php
						//	echo "<tr><td> <div  style='color: #FFCC00; font-size:12px'> Seleccione la Jornada: </td><td><select  size='1' id='jndv'  onChange='cambiodejornadahiGPS();' >"; if ($masde==true): 
						$result4 = mysqli_query($GLOBALS['link'], "SELECT _tconfjornadahi.fecha,_tconfjornadahi.IDCN,_hipodromoshi.siglas,_hipodromoshi.Descripcion FROM _tconfjornadahi,_hipodromoshi where _tconfjornadahi.IDhipo=_hipodromoshi._IDhipo and _hipodromoshi.estatus=1 and fecha='" . date("d/n/Y") . "' order by idcn ");
						while ($row4 = mysqli_fetch_array($result4)) {
							$hipodromosArray[] = $row4["Descripcion"];
							$codeHipo[] = $row4["IDCN"];
							//		echo "<option value='".$row4["IDCN"]."'>".$row4["fecha"].'-'.$row4["siglas"]."</option>";
						}
						//echo "</select></div></td></tr>";		endif;

						?>




						<tr>
							<td><span style="color:#FFF"> Carrera: </span></td>
							<td>
								<div id='b_carr'> <select id="carr" onchange=" makeResultwinHI('jugadat4-1hit.php?IDCNt=<? echo $IDCN; ?>&primercarr='+$('carr').value,'inclcarr');">
										<?php
										$primercarr = 0;
										for ($i = 1; $i <= $CantCarr; $i++) {
											$result3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _cierrehi where  ct=" . $i . " and IDCN=" . $IDCN);
											if (mysqli_num_rows($result3) == 0) :
												echo "<option " . ($i == 1 ? " selected='selected'" : " ") . " value=" . $i . ">" . $i . "</option>";
												if ($primercarr == 0) :
													$primercarr = $i;
												endif;
											endif;
										}
										?>
									</select></div>
							</td>
						</tr>
						<tr>
							<td><span style="color:#FFFFFF"> Ejemplar: </span></td>
							<td><span id="sprytextfield1">
									<input id="eje" type="text" size="3" onkeyup="accesogps(event,true,1);" onkeypress="" />
									<span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v�lido.</span></span></td>
						</tr>
						<tr>
							<td><span style="color:#FFFFFF">Total BsF.</span></td>
							<td><input id="totalg" type="text" style="background:#FFF; color:#F90; font-size:18px" disabled="disabled" size="8"></td>
						</tr>
						<tr>
							<td></td>
							<td></td>
						</tr>

						<tr>
							<td></td>
							<td><input id="btn" type="button" value="Imprimir" onclick="x_grabargameganahi();"></td>
						</tr>
						<tr>
							<td></td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td><span style="color:#FFF; font-size:16px">Faltan:</span></td>
							<td><span style="color: #FC0; font-size:16px" id="minrestan">min</span></td>
						</tr>
					</table>
				</div>
			</td>
			<td>
				<div id="box2" style="font-size:16px">
					<div id="inclcarr">

						<? include('jugadat4-1hit.php'); ?>

					</div>
				</div>


			</td>
		</tr>
	</table>
	<samp id="inicioCarr" lang="-1"></samp>
</div>
<script type="text/javascript">
	var hipodromosArray = '<? echo implode(',', $hipodromosArray); ?>';
	var codeHipo = '<? echo implode(',', $codeHipo); ?>';

	valorescodeHipo = codeHipo.split(',');
	/*  Nifty('div#box1');
	  Nifty('div#box2');$hipodromosArray=array();$codeHipo=array();
	  Nifty('div#box16');*/

	function clicktoolBar(id) {
		switch (id) {
			case "Cerrar_":
				stop_func();
				dhxWins1.window("w1").close();
				break;
		}
	}


	function clicktoolBar_SelectHipo(id, state) {
		stop_func();
		barSelectHipo.forEachItem(function(itemId) {
			if (id != itemId)
				barSelectHipo.setItemState(itemId, 0);
		});
		id_A = id.split('_');

		cambiodejornadahiGPS(valorescodeHipo[id_A[1]]);
		EstableTime();
	}

	dhxWins1 = new dhtmlXWindows();
	dhxWins1.setImagePath("codebase/imgs/");
	w1 = dhxWins1.createWindow("w1", 170, 270, 670, 670);
	w1.setText("Ganadores/Place/Show");
	w1.attachObject('fromGanadores');
	dhxWins1.window("w1").button('close').hide();
	//dhxWins1.window("w1").button('minmax1').hide();
	//dhxWins1.window("w1").button('minmax2').hide();
	dhxWins1.window("w1").button('park').hide();
	//dhxWins1.window("w1").denyResize();
	//dhxWins1.window("w1").denyMove();
	dhxWins1.window("w1").centerOnScreen();
	/*var bar = w1.attachToolbar();
	bar.addButton("Cerrar_", 4, "Cerrar", "images/close.gif", "images/close.gif"); 
	*/

	var barSelectHipo = w1.attachToolbar();
	cantidadHipo = hipodromosArray.split(',');
	barSelectHipo.addButton("Cerrar_", 0, "Cerrar", "images/close.gif", "images/close.gif");
	for (i = 0; i <= cantidadHipo.length - 1; i++) {
		//toolbar.setWidth("spacer", 200);
		barSelectHipo.addButtonTwoState("hipo_" + i, i + 1, cantidadHipo[i], "images/hipodromo.png", "images/hipodromo.png");
	}
	barSelectHipo.setItemState("hipo_0", !barSelectHipo.getItemState("hipo_0"));
	barSelectHipo.attachEvent("onStateChange", clicktoolBar_SelectHipo);
	barSelectHipo.attachEvent("onClick", clicktoolBar);
	EstableTime();
	ticketassig();
	var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {
		useCharacterMasking: true
	});
	$('eje').focus();
</script>