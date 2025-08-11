<style type="text/css">
	<!--
	.Estilo2 {
		color: #3399FF
	}
	-->
</style>
<div id="box1">
	<div id='tpg2' class='tabPanelGroup'>
		<div class='tabGroup'>

			<?php

			require('prc_php.php');
			$GLOBALS['link'] = Connection::getInstance();

			$conse = $_REQUEST['cs'];
			$idcn = $_REQUEST['idcn'];
			$idj = $_REQUEST['idj'];
			switch ($idcn) {
				case -1:
					$serial = $idj;
					echo "<a href='#tpg21' class='tabDefault' >Resultado de Busqueda por Serial:" . $serial . "</a><span class='linkDelim' >&nbsp;|&nbsp;</span>";
					echo '</div>';
					$k = 1;
					echo "<div id='tpg2" . $k . "' class='tabPanel' >";
					include('ver_jugada-1-3.php');
					echo "</div> ";
					break;


				default:
					if ($idcn != 0) :
						//echo ($conse);
						$k = 1;
						if ($conse != -2 && $conse != -1) :
							echo "<a href='#tpg21' class='tabDefault' >Jugada del Concesionario:" . $conse . "</a><span class='linkDelim' >&nbsp;|&nbsp;</span>";
						else :
							$result = mysqli_query($GLOBALS['link'], "SELECT IDC FROM _tjugada where IDCN=" . $idcn . " and IDJug=" . $idj . " Group by IDC Order by IDC");
							while ($row = mysqli_fetch_array($result)) {
								$arr1 = str_split($row['IDC']);
								$ltr = '';
								for ($g = 0; $g <= count($arr1) - 1; $g++)
									$ltr = $ltr . $arr1[$g] . '<br>';

								echo "<a href='#tpg2" . $k . "' class='tabDefault' title='" . $row['IDC'] . "'  >" . $ltr . "</a><span class='linkDelim' ></span>";
								$k++;
							}
						endif;
						echo '</div>';
						$modo = 0;
						$k = 1;
						if ($conse != -2 && $conse != -1) :
							echo "<div id='tpg2" . $k . "' class='tabPanel' >";
							$conse1 = $conse;
							$modo = 1;
							include('ver_jugada-1-3.php');
							echo "</div> ";
						else :
							$resultgrupo = mysqli_query($GLOBALS['link'], "SELECT IDC FROM _tjugada where IDCN=" . $idcn . " and IDJug=" . $idj . " Group by IDC Order by IDC");
							while ($rowgrupo = mysqli_fetch_array($resultgrupo)) {
								echo "<div id='tpg2" . $k . "' class='tabPanel' >";
								$conse1 = $rowgrupo['IDC'];
								$modo = 2;
								include('ver_jugada-1-3.php');
								echo "</div> ";
								$k++;
							}
						endif;
					endif;
			}
			?>
		</div>
	</div>
</div>
<div id='xTooltip'></div>
<script>
	Nifty('div#box1', 'big');
	new xTabPanelGroup('tpg2', 1150, 580, 70, 'tabPanel', 'tabGroup', 'tabDefault', 'tabSelected');
	ticketassig();
</script>