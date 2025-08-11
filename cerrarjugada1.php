


<?php

$tipo = $_REQUEST['tipo'];


if ($tipo == 1) :
	$fecha = $_REQUEST['fecha'];
	$GLOBALS['link'] = mysqli_connect("localhost", "sphonlin_root", "intra");
	mysql_select_db("sphonlin_sphonline", $GLOBALS['link']);

	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfjornada where fecha='" . $fecha . "'",  $GLOBALS['link']);
	if (mysqli_num_rows($result) != 0) :
		echo "<strong>Jornada:</strong><select  id='sjornada'>";
		while ($row = mysqli_fetch_array($result)) {
			echo "<option value='" . $row['IDCN'] . "'>" . $row['IDCN'] . "</option>";
		}
		echo "</select>";
	else :
		echo "<strong>Jornada:</strong> <select  id='sjornada'>";
		echo "<option value=''></option>";
		echo "</select>";
	endif;
endif;

if ($tipo == 2) :
	$jornada = $_REQUEST['jornada'];
	$fecha = $_REQUEST['fecha'];
endif;


if ($tipo == 3) :
	$idcn = $_REQUEST['idcn'];
	$ganadores = $_REQUEST['ganadores'];
	$cierres = $_REQUEST['cierres'];

	$result = mysqli_query($GLOBALS['link'], "INSERT INTO _ganadores (IDCN,ganadores) VALUES (" . $IDCN . ",'" . $ganadores . "')");

endif;

if ($tipo == 4) :
	$idcn = $_REQUEST['idcn'];
	$GLOBALS['link'] = mysqli_connect("localhost", "sphonlin_root", "intra");
	mysql_select_db("sphonlin_sphonline", $GLOBALS['link']);
	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfjornada where idcn=" . $idcn,  $GLOBALS['link']);

	if (mysqli_num_rows($result) != 0) :
		$row = mysqli_fetch_array($result);

		echo '<table width="400" border="0" cellspacing="0">';
		echo '<tr bgcolor="#0066FF">';
		echo '<th bgcolor="#FFFFFF"><div align="center">Carrera</div></th>';
		echo '<th width="155" bgcolor="#FFFFFF"><div align="left">Estatus</div></th>';
		echo '</tr>';
		$j = 1;
		for ($i = 1; $i <= $row['Cantcarr']; $i++) {
			if ($j == 1) :
				$bg = "#D4DAE6";
				$j = 2;
			else :
				$bg = "#FFFFFF";
				$j = 1;
			endif;
			echo '<tr bgcolor="' . $bg . '">';
			echo '<th ><div align="center">' . $i . '</div></th>';
			echo '<th width="50" ><div align="left">----</div></th>';
			echo '</tr>';
		}

		echo '</table>';

	endif;


endif;
?>