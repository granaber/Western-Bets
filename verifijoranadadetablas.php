

<?php
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();


$tipo = $_REQUEST['tipo'];


if ($tipo == 1) :
	$fecha = $_REQUEST['fecha'];
	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfjornada where fecha='" . $fecha . "'");
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

	$result = mysqli_query($GLOBALS['link'], "INSERT INTO _ganadorestablas (IDCN,ganadores) VALUES (" . $IDCN . ",'" . $ganadores . "')");

endif;

if ($tipo == 4) :
	$idcn = $_REQUEST['idcn'];

	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfjornada where idcn=" . $idcn);

	if (mysqli_num_rows($result) != 0) :
		$row = mysqli_fetch_array($result);
		echo '<table width="400" border="0" cellspacing="0">';
		echo '<tr >';
		echo '<th bgcolor="#FFFFFF"></th>';
		echo '<th bgcolor="#FFFFFF"><div align="center">Carrera</div></th>';
		echo '<th bgcolor="#FFFFFF"><div align="center">P1</div></th>';
		echo '<th  bgcolor="#FFFFFF"><div align="center">Estatus</div></th>';
		echo '<th bgcolor="#FFFFFF"></th>';

		echo '</tr>';

		for ($i = 1; $i <= $row['Cantcarr']; $i++) {
			if (fmod($i, 2) == 0) :
				$colort = '#385B96';
			else :
				$colort = '';
			endif;
			$result2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _ganadorestablas where idcn=" . $idcn . " and carr=" . $i);
			if (mysqli_num_rows($result2) != 0) :
				$row2 = mysqli_fetch_array($result2);
				$pp = explode("|", $row2['ganadores']);
			else :
				$pp = array(0, 0, 0, 0);
			endif;
			$result3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _cierre where idcn=" . $idcn . " and ct=" . $i);
			if (mysqli_num_rows($result3) != 0) :
				$row3 = mysqli_fetch_array($result3);
				$cr = 1;
				$en = '';
			else :
				$cr = 0;
				$en = 'disabled="disabled"';
			endif;
			$b1 = "'p" . $i . "2'";
			$b2 = "'p" . $i . "3'";
			$b3 = "'p" . $i . "4'";
			$b4 = "'p" . ($i + 1 <= $row['Cantcarr'] ? ($i + 1) : '1') . "1'";
			echo ' <tr id="c' . $i . '" bgcolor="' . $colort . '">
			   <th> <img src="media/estrella.png" width="16" height="16" onclick="grabarganadores_tablas(1);"/> </th>
              <th ><div align="center" style="color:#FFFFFF; font-size:14px"  >' . $i . '</div></th>
              <th  width="26" ><input id="p' . $i . '1" type="text" size="5" value="' . $pp[0] . '" onkeyup="pulsart(event,' . $b1 . ');" ' . $en . '></th>';
			if ($cr != 1) :
				echo ' <th width="200" ><img  id=ch' . $i . ' src="media/unlock.png" lang="0" title="Carrera Abierta" /></th>';
			else :
				echo ' <th width="200" ><img id=ch' . $i . ' src="media/lock.png" lang="1" title="Carrera Cerrada"/></th>';
			endif;
			echo '<th></th>
		    </tr>';
		}
		echo '</table>
	<br />
	<br />
	<div align="center" style="color:#FFFFFF; font-size:14px" ><img src="media/estrella.png" width="16" height="16" />= Click para Grabar Ganadores</div>';
	endif;


	echo '<samp id="ncarr" title=' . $row['Cantcarr'] . '></samp>';
endif;

?>
