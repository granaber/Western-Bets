<?

if (isset($_REQUEST['tidcn'])) :
	require('prc_php.php');
	$GLOBALS['link'] = Connection::getInstance();


	$result3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfjornadahi where   IDCN=" . $_REQUEST['tidcn']);
	if (mysqli_num_rows($result3) != 0) :

		if (mysqli_num_rows($result3) > 1) :
			$masde = true;
		endif;

		$row = mysqli_fetch_array($result3);
		$idhipo = $row["IDhipo"];
		$CantCarr = $row["Cantcarr"];
		$IDCN = $row["IDCN"];

		$result3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfighi where IDCN=" . $IDCN);
		if (mysqli_num_rows($result3) != 0) :
			$row = mysqli_fetch_array($result3);
			$caticabb = explode('|', $row['_Fab']);
			$retirado = explode('|', $row['_Ret']);
		endif;

	else :
		$CantCarr = 0;
	endif;

endif;

?>
<select id="carr" onchange="makeResultwinHI('jugadat4-1hit.php?IDCNt=<? echo $IDCN; ?>&primercarr='+$('carr').value,'box2');">
	<?php
	$primercarr = 0;
	for ($i = 1; $i <= $CantCarr; $i++) {
		$result3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _cierrehi where  ct=" . $i . " and IDCN=" . $IDCN);
		if (mysqli_num_rows($result3) == 0) :
			echo "<option " . ($i == 1 ? " selected='selected'" : " ") . " value=" . $i . ">" . $i . "</option>";
			if ($primercarr == 0) :
				$primercarr = $i;
			endif;
		endif;
	}
	?>
</select>