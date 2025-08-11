 <?
	require('prc_php.php');
	$GLOBALS['link'] = Servidordual::getInstance();
	$fecha = $_REQUEST['fecha'];
	$tipo = 4;

	$resulthip = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfjornadahi where fecha='" . $fecha . "'");
	if (mysqli_num_rows($resulthip) != 0) :
		while ($rowhi = mysqli_fetch_array($resulthip)) {

			$resultNomhip = mysqli_query($GLOBALS['link'], "SELECT * FROM _hipodromoshi where _idhipo=" . $rowhi['IDhipo']);
			$rowhiN = mysqli_fetch_array($resultNomhip);

			$idcn = $rowhi['IDCN'];
			echo ' <td><div style="background:#036"><span style="background:#036; color:#FFF; font-size:16px">HIPODROMO:' . $rowhiN['Descripcion'] . '</span>';

			include "cierresph2hi.php";
			echo "</div>&nbsp;</td>";
		}
	endif;

	?>