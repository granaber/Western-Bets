<?

require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$fc = $_REQUEST["fc"];

$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where Fecha='" . $fc . "'");
if (mysqli_num_rows($resultj) != 0) :
	$rowj = mysqli_fetch_array($resultj);
	$idj = $rowj["IDJ"];
else :
	$idj = 0;
endif;
?>

<div id="box4" style="background: #036">
	<div align="left" style="color:#FC0">Indique la Fecha:
		<input name="fc" type="text" id="fc" lang="<?php echo $idj; ?>" size="10" value="<?php echo $fc; ?>" />

		<samp> Deporte:</samp>
		<select name="select" id="deporte">
			<?php
			$result3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _gruposdd Where Estatus=1");
			while ($row3 = mysqli_fetch_array($result3))
				echo "<option  value='" . $row3["Grupo"] . "'>" . $row3['Descripcion'] . "</option>";

			?>
		</select>


		<input name="" type="button" onClick="CkeckEstadistica();" value="Buscar">
		<input id="B1" name="" type="button" onClick="AutoRefress(1);$('B1').style.display='none';$('B2').style.display='';" value="Refrescar">
		<input id="B2" name="" type="button" onClick="AutoRefress(2);$('B2').style.display='none';$('B1').style.display='';" value="Parar" style="display:none">
		<span id="contador" style="font-size:14px; color:#FFF"></span>
	</div>
</div>
<div id="resul_estadistica"></div>
<script>
	Nifty('div#box4', 'big');
	cargarFechaForVer();
</script>