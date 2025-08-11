<?

if (isset($_REQUEST['tidcn'])) :
	require('prc_php.php');
	$GLOBALS['link'] = Connection::getInstance();

	$idcn = $_REQUEST['tidcn'];
	$uno = $_REQUEST['uno'];
	$idcar = $_REQUEST['idcar'];
	$tj = $_REQUEST['tj'];
	$activo1 = $_REQUEST['activo1'];
	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tdjuegoshi where IDJug=" . $tj);
	$row = mysqli_fetch_array($result);

	$result4 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfighi where IDCN=" . $idcn);
	$row3 = mysqli_fetch_array($result4);
	$config = explode("|", $row3["_Jug"]);
	$cantcb = explode("|", $row3["_Fab"]);
	$retira = explode("|", $row3["_Ret"]);
	for ($k = 0; $k <= count($config) - 1; $k++) {
		$_tem = explode("*", $config[$k]);
		if ($_tem[0] == $tj) :
			break;
		endif;
	}
	$_xc = explode("-", $_tem[1]);
	$result3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfjornadahi where  IDCN=" . $idcn);

endif;


?>

<select id="carre_v <? echo $idcar ?> " name="carre_v" onChange="focoobjhi('valida',<?php echo $tj; ?>,<?php echo $idcn; ?>,<?php echo $row["Tandas"]; ?>);">
	<?php
	$pric = -1;
	if ($activo1 == 1) :
		$ct = 1;
		$result3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tdjuegoshi where IDJug=" . $tj);
		$row3 = mysqli_fetch_array($result3);
		for ($r = $uno; $r <= count($_xc) - 2; $r++) {
			if ($ct <= $row3['CantidadCarr']) :
				$result4 = mysqli_query($GLOBALS['link'], "SELECT * FROM _cierrehi where  IDJug=" . $tj . " and ct=" . $_xc[$r] . " and IDCN=" . $idcn);
				if (mysqli_num_rows($result4) == 0) :
					echo "<option " . $_xc[$r] . " value='" . $r . '||' . $_xc[$r] . "'>" . $_xc[$r] . "</option>";
					if ($pric == -1) :
						$pric = $r;
					endif;
				endif;
			endif;

			$ct++;
		}

	endif;		?>
</select>