<?php
/*  date_default_timezone_set('America/Caracas'); */

require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();


$fc = date("d/n/Y");
$grp = 0;
$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where Fecha='" . $fc . "' order by Grupo");
if (mysqli_num_rows($resultj) != 0) :
	$rowj = mysqli_fetch_array($resultj);
	$idjA = $rowj["IDJ"];

else :

	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb Order by IDJ DESC ");
	$row = mysqli_fetch_array($result);
	if ($result) :
		$idjA = $row["IDJ"] + 1;
	else :
		$idjA = 1;
	endif;

endif;


?>
<div id="fromCaptar" style="background:#BAC6D8;width:415px; height:1000px">

	<div align="center" style="color: #F00; font-size:14px"> Este Modulo permite la copia de logros del dia <? echo date("d/n/Y"); ?>
	</div>

	<br />


	<div align="center" style="color: #333; font-size:12px"> Indique el Juego a Copiar: <select name="Grupo" id="Grupo">
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
	</div>
	<br>
	<div align="center"> <input name="" type="button" value="Iniciar Captura" onclick="captural('<? echo date("d/n/Y"); ?>',<? echo $idjA ?>);"></div>
	<br>
	<div id="resultado" align="center" style="color: #036; font-size:14px"></div>
</div>

<script>
	function clicktoolBar(id) {
		switch (id) {
			case "Cerrar_":
				dhxWins1.window("w1").close();
				break;
			case "Guardar_":
				grabar_usuario();
				break;
			case "Eliminar_":
				elimnar_usuario();
				break;
		}
	}
	dhxWins1 = new dhtmlXWindows();
	dhxWins1.setImagePath("codebase/imgs/");
	w1 = dhxWins1.createWindow("w1", 300, 255, 415, 200);
	w1.setText('Captar Logros');
	w1.attachObject('fromCaptar');
	dhxWins1.window("w1").button('close').hide();
	dhxWins1.window("w1").button('minmax1').hide();
	dhxWins1.window("w1").button('minmax2').hide();
	dhxWins1.window("w1").button('park').hide();
	dhxWins1.window("w1").denyResize();
	dhxWins1.window("w1").denyMove();
	dhxWins1.window('w1').setModal(true);
	var bar = w1.attachToolbar();
	bar.addButton("Cerrar_", 4, "Cerrar", "images/close.gif", "images/close.gif");
	bar.attachEvent("onClick", clicktoolBar);
</script>