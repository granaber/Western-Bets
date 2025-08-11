<?php
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$tj = $_REQUEST['tj'];
$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfjornada where Estatus=1 and fecha='" . date("d/n/Y") . "' order by IDCN");
if (mysqli_num_rows($result) != 0) :
	$row = mysqli_fetch_array($result);
	$IDCN = $row['IDCN'];
	$tc = $row['Cantcarr'];
else :
	$tc = 0;
endif;

if ($tc != 0) :
	for ($t = 1; $t <= $tc; $t++) {
		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tabladetablascnf where Estatus=1 and idcn=" . $IDCN . " and carr=" . $t);
		if (mysqli_num_rows($result) != 0) :
			$row = mysqli_fetch_array($result);
			$nc =  $row['Carr'];
		else :
			$nc = 0;
		endif;
		if ($nc != 0) :
			$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _cierre where  idcn=" . $IDCN . " and ct=" . $nc);
			if (mysqli_num_rows($result) != 0) :
				$nc = 0;
			else :
				break;
			endif;
		endif;
	}
else :
	$nc = 0;
endif;

?>
<? if ($nc != 0) : ?>
	<div id="box5">
		<label id="tj" style="color:#FFFFFF; font-size:14px" title="<? echo $tj; ?>"> Carrera Activa No <?php echo $nc; ?></label><span id="carrera" lang="<?php echo $nc; ?>"> </span> <samp id="resultado" style="color:#FFFFFF"></samp>
	</div>
	<div id="respejem">
		<? include('tjugadatablas-1.php'); ?>
	</div>
<? else : ?>
	<div id="box7" align="center">
		<label style="color:#FFFFFF; font-size:14px">LO SIENTO NO HAY CARRERAS ACTIVAS EN ESTE MOMENTO</label>
	</div>
	<script>
		Nifty('div#box7', 'big');
	</script>
<? endif; ?>