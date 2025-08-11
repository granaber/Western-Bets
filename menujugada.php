<style type="text/css">
	<!--
	.Estilo4 {
		font-size: 12pt;
		font-family: "Times New Roman", Times, serif;
	}

	.Estilo6 {
		color: #FFFFFF
	}

	.arrowlistmenu {
		width: 180px;
		background-color: white;
		/*width of menu*/
	}
	-->
</style>
<div id="noborder" align="center"><span id="btn" style="display:none">
		<input name="submit" type="submit" class="boton1" id="btnlg" onClick="javascript:popunnew();" value="Entrar al Sistema">
	</span> <span id="btn2" style="display:none">
		<input name="submit2" type="submit" class="boton1" id="btnlg2" onClick="javascript:logouto();" value="Salir del Sistema">
	</span></div>
<div id="menu1" class="arrowlistmenu" onmousemove="document.getElementById('printerver').style.display='none';">
	<h3 class="headerbar">Jugadas<img src="media/fle.gif" onclick="despliega(1)" height="9" width="9" /></h3>
	<ul id="mp1" lang="0"><?php
							$cng = $_REQUEST['cng'];
							$vacng = explode('|', $cng);

							require('prc_php.php');
							$GLOBALS['link'] = Connection::getInstance();
							$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tdjuegos where Estatus=1 order by IDJug");
							while ($row = mysqli_fetch_array($result)) {
								$key = array_search('op1' . $row["IDJug"], $vacng);
								if (!is_int($key)) :
									$a = "'jugadat" . $row["Formato"] . ".php?tj=" . $row["IDJug"] . "'";
									echo '<li id="op1' . $row["IDJug"] . '" class="Estilo4" style="font-size:12px"><a href="javascript: makeRequestjug(' . $a . ');" class="Estilo6">' . $row["Descrip"] . '</a></li>';
								endif;
							}
							?>

	</ul>
	<?php
	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tmenu where Modulo='SPH' order by  SUBMODULO,variable");
	$subme = '';
	$op = 2;
	while ($row = mysqli_fetch_array($result)) {
		if ($subme == '') :
			$subme = $row['SUBMODULO'];
			echo '    <h3 class="headerbar" >' . $row['SUBMODULO'] . '<img src="media/fle.gif" onclick="despliega(' . $op . ')"  height="9" width="9"/></h3> <ul  id="mp' . $op . '">';
			$op++;
		endif;
		$key = array_search($row['variable'], $vacng);

		if (!is_int($key)) :
			if ($subme == $row['SUBMODULO']) :
				echo '<li  id="' . $row['variable'] . '" class="Estilo4"  style="font-size:12px"><a href="' . $row['Modulocomando'] . '" >' . $row['Descripcion'] . '</a></li>';
			else :
				$subme = $row['SUBMODULO'];
				echo '  </ul>  <h3 class="headerbar">' . $row['SUBMODULO'] . '<img src="media/fle.gif" onclick="despliega(' . $op . ')"  height="9" width="9"/></h3> <ul  id="mp' . $op . '">';
				$op++;
				echo '<li  id="' . $row['variable'] . '" class="Estilo4" style="font-size:12px"><a href="' . $row['Modulocomando'] . '" >' . $row['Descripcion'] . '</a></li>';
			endif;
		endif;
	}
	echo "</ul>";
	?>

</div>