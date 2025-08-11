<?php
if (isset($_REQUEST['fc1'])) :
	require('prc_php.php');
	$GLOBALS['link'] = Connection::getInstance();
	$fc1 = $_REQUEST['fc1'];
	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfjornada where Estatus=1 and fecha='" . $fc1 . "' order by IDCN");
	if (mysqli_num_rows($result) != 0) :
		$row = mysqli_fetch_array($result);
		$nc =  $row['Cantcarr'];
		$IDCN = $row['IDCN'];
	else :
		$nc = 0;
	endif;
endif;
?>
<br /><br />
<div id="box4">
	<div id='tpg2' class='tabPanelGroup'>
		<div class='tabGroup'>
			<?php

			$i = 1;
			echo "<a href='#tpg2" . $i . "' class='tabDefault' >Carrera No. " . $nc . "</a><span class='linkDelim' >&nbsp;|&nbsp;</span>"
			?>
		</div>
		<?php

		$result2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfig where IDCN=" . $IDCN);
		$row2 = mysqli_fetch_array($result2);
		$canteje = explode('|', $row2['_Fab']);
		$retirados = explode('|', $row2['_Ret']);
		echo "<div id='tpg2" . $i . "' class='tabPanel' >";
		include('tjugadatablas-1-1.php');
		echo "</div> ";

		?>
	</div>
</div>
<br />
<div id="box6">
	<label style="color:#FFFFFF; font-size:14px" d>Monto TOTAL Vendido en esta Carrera Bsf.:</label><label id='totalgeneral' style="color: #000000; font-size:16px; font-style:inherit"></label>
</div>
<script>
	Nifty('div#box4', 'big');
	Nifty('div#box5', 'big');
	Nifty('div#box6', 'big');
	new xTabPanelGroup('tpg2', 525, 480, 40, 'tabPanel', 'tabGroup', 'tabDefault', 'tabSelected');
	ticketassig();
	subtotaldetablas();
	conteodetablas();
	verestatustabla(1);
</script>