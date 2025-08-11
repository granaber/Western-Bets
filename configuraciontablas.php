<?php
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfjornada where Estatus=1 and fecha='" . date("d/n/Y") . "' order by IDCN");
if (mysqli_num_rows($result) != 0) :
	$row = mysqli_fetch_array($result);
	$nc =  $row['Cantcarr'];
	$IDCN = $row['IDCN'];
else :
	$nc = 0;
endif;
?>
<div id="box5">
	<label style="color:#FFFFFF"> Indique la Fecha: </label> <input name="fc" type="text" id="fc" size="10" value="<?php echo date("d/n/Y"); ?>" /> <input name="" type="button" value="Grabar" onclick="grabartablas(<? echo $nc; ?>,<? echo $IDCN; ?>  )"><samp id="resultado" style="color:#FFFFFF"></samp>
</div>
<div id="respejem">
	<? include('configuraciontablas-1.php'); ?>
</div>