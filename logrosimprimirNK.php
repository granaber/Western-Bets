 <?php

	if (isset($_REQUEST['xfc'])) :
		require('prc_php.php');
		$GLOBALS['link'] = Connection::getInstance();

		$fc = $_REQUEST["xfc"];
		$idj = 0;
		$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where Fecha='" . $fc . "'");
		if (mysqli_num_rows($resultj) != 0) :
			$rowj = mysqli_fetch_array($resultj);
			$idj = $rowj["IDJ"];
			$cant = $rowj["Partidos"];
		endif;

	endif;
	$y = 0;
	echo "<span style='color:#000000; background:#FFFFFF; font-size:12px'><input id='chk0' type='checkbox' value='0' onclick='marcat(0)'/>TODOS</span><br />";

	$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _gruposdd where  Estatus=1 Order by grupo ");
	$y = 1;
	while ($row = mysqli_fetch_array($resultj)) {
		$resultj2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where Grupo=" . $row["Grupo"] . " and IDJ=" . $idj);
		if (mysqli_num_rows($resultj2) != 0) {
			echo "<input id='chk0" . $y . "' type='checkbox' lang=" . $row["Grupo"] . " /><span style='color:#FFFFFF'>" . $row["Descripcion"] . '</span><br />';
			$y++;
		}
	}
	?>
 <samp id="totalg" lang="<? echo $y; ?>"></samp>