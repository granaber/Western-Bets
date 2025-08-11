

<?php
require_once('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

if (isset($_REQUEST['tipor'])) :
	$tipo = $_REQUEST['tipor'];
endif;


if ($tipo == 1) :
	$fecha = $_REQUEST['fecha'];
	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfjornadahi where fecha='" . $fecha . "'");
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


	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfjornadahi where idcn=" . $idcn);

	if (mysqli_num_rows($result) != 0) :
		$row = mysqli_fetch_array($result);
		$result1 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfighi where idcn=" . $idcn);
		$row1 = mysqli_fetch_array($result1);
		$horat = explode('|', $row1['_hora']);
		echo '<table width="400" border="0" cellspacing="0">';
		echo '<tr >';
		echo '<th bgcolor="#FFFFFF"></th>';
		echo '<th bgcolor="#FFFFFF"><div align="center">Carrera</div></th>';
		echo '<th width="26" bgcolor="#FFFFFF"><div align="center">Hora</div></th>';
		echo '<th width="200" bgcolor="#FFFFFF"><div align="center">Estatus</div></th>';
		echo '<th bgcolor="#FFFFFF"></th>';

		echo '</tr>';

		for ($i = 1; $i <= $row['Cantcarr']; $i++) {
			if (fmod($i, 2) == 0) :
				$colort = '#385B96';
			else :
				$colort = '';
			endif;
			$result2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _cierrehi where idcn=" . $idcn . " and ct=" . $i);
			if (mysqli_num_rows($result2) != 0) :
				$row2 = mysqli_fetch_array($result2);
				$cr = 1;
			else :
				$cr = 0;
			endif;
			$horacierre = '0:0';
			$tiempo = str_split($horat[$i - 1]);
			if (count($tiempo) > 0) :
				switch (count($tiempo)) {

					case 4:
						$hora = $tiempo[0] . $tiempo[1];
						$minuto = $tiempo[2] . $tiempo[3];
						break;
					case 3:
						$hora = $tiempo[0] . $tiempo[1];
						$minuto = $tiempo[2];
						break;
					case 2:
						$hora = $tiempo[0] . $tiempo[1];
						$minuto = 0;
						break;
					case 1:
						$hora = $tiempo[0];
						$minuto = 0;
						break;
				}
				$horacierre = $hora . ':' . $minuto;
			endif;


			echo ' <tr id="c' . $i . '" bgcolor="' . $colort . '">
			   <th> <img src="media/estrella.png" width="16" height="16"/> </th>
              <th ><div align="center" style="color:#FFFFFF; font-size:14px"  >' . $i . '</div></th>
              <th  width="26" ><p id="h' . $i . '" value="' . $pp[0] . '" align="right" style="color:#FC0; font-size:12px" >' . $horacierre . '</p></th>';
			if ($cr != 1) :
				echo ' <th width="200" align="center" ><div align="center" ><img  id="ch' . $i . '-' . $idcn . '" src="media/unlock.png" lang="0" onclick="cambiarest(event,' . $i . ',' . $idcn . ');" /></div></th>';
			else :
				echo ' <th width="200" align="center" ><div align="center" ><img id="ch' . $i . '-' . $idcn . '" src="media/lock.png" lang="1" onclick="cambiarest(event,' . $i . ',' . $idcn . ');"/></div></th>';
			endif;
			echo '<th></th>
		    </tr>';
		}
		echo '</table>
	<br />
	<br />';
	endif;


	echo '<samp id="ncarr-' . $idcn . '" title="' . $row['Cantcarr'] . '"></samp>';
	echo '<samp id="sjornada-' . $idcn . '" title="' . $idcn . '"></samp>';
endif;

?>
