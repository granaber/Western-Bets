<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$grupo = $_REQUEST['grupo'];
$columnas[] = "No";
$columnas[] = "Equipo";
$columnas[] = "Cant. Apuestas";
$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbjuegodd  where _tbjuegodd.grupo=$grupo Order by IDDD");
while ($row3 = mysqli_fetch_array($result)) {
	$columnas[] = $row3['Descripcion'];
}
echo json_encode($columnas);
