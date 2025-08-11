<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$desde = $_REQUEST['desde'];
$hasta = $_REQUEST['hasta'];

?>

<select id="Hipodromo">
	<?php $result = mysqli_query($GLOBALS['link'], "SELECT _hipodromoshi .* FROM _tconfjornadahi , _hipodromoshi  WHERE _tconfjornadahi.IDhipo = _hipodromoshi._idhipo AND (STR_TO_DATE(Fecha,'%d/%m/%Y') BETWEEN STR_TO_DATE('" . $desde . "','%d/%m/%Y') and STR_TO_DATE('" . $hasta . "','%d/%m/%Y')) group by _idhipo order by _idhipo");
	while ($row = mysqli_fetch_array($result)) {
		echo "<option value=" . $row["_idhipo"] . ">" . $row["Descripcion"] . "</option>";
	}
	?>
</select>