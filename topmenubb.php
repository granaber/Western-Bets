<?php
$fc = $_REQUEST['fc'];
$op = explode('|', $_REQUEST['op']);

require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();


$resultx = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where Fecha='" . $fc . "'");
$rowx = mysqli_fetch_array($resultx);

$idj = $rowx["IDJ"];

?>


<div id="menucontainer" align="left" lang="<?php echo $idj; ?> " style="background: #333">
	<div id="menunav" style="background: #069">
		<ul>
			<?php
			$resultm = mysqli_query($GLOBALS['link'], "SELECT * FROM _tmenu where MODULO='DEPORTES' Order by IDM");
			while ($row = mysqli_fetch_array($resultm)) {
				$key = array_search($row["variable"], $op);
				if ($key === false) :
					echo '<li style="background:#333" ><a href="' . $row["Modulocomando"] . '" ><span>' . $row["Descripcion"] . '</span></a></li>';
				endif;
			}
			?>


		</ul>
	</div>
</div>

</div>