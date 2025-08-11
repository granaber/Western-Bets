<?php

/*$fc=$_REQUEST['fc'];*/


require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$tp = "";
$idg = "";

?>

<div id="box6" align="left" style="width:500px; background: #666">
	<div id='tpg2' class='tabPanelGroup'>
		<div class='tabGroup'>
			<?php
			$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tgrupo order by IDG ");
			while ($row = mysqli_fetch_array($result)) {
				echo "<a href='#tpg2" . $row['IDG'] . "' class='tabDefault' >" . $row['Descrip'] . "</a><span class='linkDelim'>&nbsp;|&nbsp;</span>";
			}
			?>
		</div>

		<?php
		$result_g = mysqli_query($GLOBALS['link'], "SELECT * FROM _tgrupo order by IDG ");

		while ($row_g = mysqli_fetch_array($result_g)) {
			echo "<div id='tpg2" . $row_g['IDG'] . "' class='tabPanel'>";
			include('ordenconc.php');
			echo "</div>";
		}
		?>
	</div>
</div>
</div>
<script>
	new xTabPanelGroup('tpg2', 495, 350, 40, 'tabPanel', 'tabGroup', 'tabDefault', 'tabSelected');
	Nifty('div#box4', 'big');
	Nifty('div#box6', 'big');
</script>