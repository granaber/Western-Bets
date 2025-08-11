<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$aplica = $_REQUEST['app'];

switch ($aplica) {

	case '0':
		echo 'Seleccion:';
		break;
	case '1':
		echo 'Seleccion:<select  id="selApp2" onchange="frmChgCondicionesII(' . $_REQUEST['IDCN'] . ',' . $_REQUEST['nc'] . ')"> ';
		$result4 = mysqli_query($GLOBALS['link'], "SELECT * FROM `_tgrupo` where Estatus=1 Order by IDG ");
		while ($row4 = mysqli_fetch_array($result4))
			echo "<option value='" . $row4["IDG"] . "'>" . $row4["Descrip"] . "</option>";
		echo '</select>';
		break;
	case '2':
		echo 'Seleccion:<select  id="selApp2"  onchange="frmChgCondicionesII(' . $_REQUEST['IDCN'] . ',' . $_REQUEST['nc'] . ')""> ';
		$result4 = mysqli_query($GLOBALS['link'], "SELECT * FROM `_tbconcesionario` order by IDC");
		while ($row4 = mysqli_fetch_array($result4))
			echo "<option value='" . $row4["IDC"] . "'>" . $row4["IDC"] . "</option>";
		echo '</select>';
		break;
}
