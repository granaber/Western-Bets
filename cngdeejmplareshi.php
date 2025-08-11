<?php
require('prc_php.php');
$GLOBALS['link'] = Servidordual::getInstance();

$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfjornadahi where Estatus=1 and fecha='" . date("d/n/Y") . "' order by IDCN");
if (mysqli_num_rows($result) != 0) :
	$row = mysqli_fetch_array($result);
	$nc =  $row['Cantcarr'];
	$IDCN = $row['IDCN'];
	$hipo = $row['IDhipo'];
else :
	$nc = 0;
endif;
?>
<div id="box3">
	<label style="color:#FFFFFF"> Indique la Fecha: </label> <input name="fc" type="text" id="fc" size="10" value="<?php echo date("d/n/Y"); ?>" />

	<label style="color:#FFFFFF"> Indique el Hipodromo: </label> <select id="_hipod" onchange="jsonvaloresHI($('fc').value);">
		<?php $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _hipodromoshi order by _idhipo");
		while ($row = mysqli_fetch_array($result)) {
			if ($row["Estatus"] < 2) :
				echo "<option " . ($idhipo == $row["_idhipo"] ? " selected='selected'" : " ") . " value=" . $row["_idhipo"] . ">" . $row["Descripcion"] . "</option>";
			endif;
		}
		?>
	</select><input name="" type="button" value="Grabar" onclick="grabarejemplareshi(<? echo $nc; ?>  ,<? echo $IDCN; ?>  )"> <span id="resultado"></span>
</div>
<div id="respejem">
	<? include('cfngdeportes-1hi.php'); ?>
</div>