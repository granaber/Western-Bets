<?php
/*  date_default_timezone_set('America/Caracas'); */

require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$Abanca = 0;
$idt = $_REQUEST['idt'];
$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tusu where IDusu=$idt");
$rowj = mysqli_fetch_array($resultj);
$Abanca = $rowj['ABanca'];

$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where Fecha='" . $fc . "' order by Grupo");

$fc = $_REQUEST["fc"];
$grp = 0;
$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where Fecha='" . $fc . "' order by Grupo");
if (mysqli_num_rows($resultj) != 0) :
	$rowj = mysqli_fetch_array($resultj);
	$idj = $rowj["IDJ"];
	$cant = $rowj["Partidos"];
	$grp = $rowj["Grupo"];
else :
	$cant = 0;
	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb Order by IDJ DESC ");
	$row = mysqli_fetch_array($result);
	if ($result) :
		$idj = $row["IDJ"] + 1;
	else :
		$idj = 1;
	endif;

endif;

?>
<div id="fromJornadaCNG" style="background:#BAC6D8;width:415px; height:1000px">

	<table width="292" height="129" border="0">
		<tr>
			<th height="30" scope="col" align="left"><span style="color:#000; font-size:12px">Fecha:</span></th>
			<th width="129" scope="col" align="left"><span id="fc" lang="<?php echo $idj; ?>"><?php echo $fc; ?></span></th>
		</tr>
		<tr>
			<th height="28" scope="col" align="left"><span style="color:#000; font-size:12px">Indique el Deporte:</span></th>
			<th scope="col" align="left"><select name="Grupo" id="Grupo" onchange="jsonvalores3(<?php echo $idj; ?>);">
					<?php
					$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _gruposdd where  Estatus=1 Order by grupo ");
					while ($row = mysqli_fetch_array($resultj)) {
						if ($row["Grupo"] == $grp) :  $acc = 'selected="selected"';
						else : $acc = "";
						endif;

						echo "<option  value=" . $row["Grupo"] . " " . $acc . " >" . $row["Descripcion"] . "</option>";
					}
					?>
					<option </select>
			</th>
		</tr>
		<tr>
			<th scope="col" align="left"><span style="color:#000; font-size:12px">Cantidad de Partidos:</span></th>
			<th scope="col" align="left"><input id="cant_p" type="text" size="8" maxlength="5" value='<?php echo $cant; ?>' /></th>
		</tr>
		<? if ($Abanca == 0) : ?>
			<tr>
				<th height="24" scope="col"><span style="color:#000; font-size:12px">Indique la Banca:</span></th>
				<th scope="col"> <select name="select2" id="IDB">
						<?
						$result_g = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbanca Order by IDB ");
						while ($row_g = mysqli_fetch_array($result_g)) {
							if ($row_g['Estatus'] == 1) :
								echo "<div id='tpg_" . $row_g['IDB'] . "'  style='height:430px; '>";
								echo '<option value="' . $row_g['IDB'] . '">' . $row_g['IDB'] . '-' . $row_g['NombreB'] . '</option>';
							endif;
						}
						?>
					</select></th>
			</tr>
		<? else : ?>
			<input id="IDB" type="text" value="<? echo $Abanca; ?>" style="display:none" />
		<? endif; ?>

	</table>

</div><br />
<br />

<div id='coc'></div>

<script>
	function clicktoolBar(id) {
		switch (id) {
			case "Cerrar_":
				dhxWins2.window("w2").close();
				break;
			case "Procesar_":
				cargarpartidos(-1);
				dhxWins2.window("w2").close();
				break;

				//"ImprimirReporte2('reportedeventashipodromo-2.php');"
		}
	}

	dhxWins2 = new dhtmlXWindows();
	dhxWins2.setImagePath("codebase/imgs/");
	w2 = dhxWins2.createWindow("w2", 350, 250, 330, 250);
	w2.setText('Configuracion de Jornada ');
	w2.attachObject('fromJornadaCNG');
	dhxWins2.window("w2").button('close').hide();
	dhxWins2.window("w2").button('minmax1').hide();
	dhxWins2.window("w2").button('minmax2').hide();
	dhxWins2.window("w2").button('park').hide();
	dhxWins2.window('w2').setModal(true);
	var bar = w2.attachToolbar();
	bar.addButton("Cerrar_", 4, "Cerrar", "images/close.gif", "images/close.gif");
	bar.addButton("Procesar_", 1, "Porcesar...", "images/copy.gif", "images/copy.gif");
	bar.attachEvent("onClick", clicktoolBar);
</script>