<?
require_once('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$row = $_REQUEST['row'];

$result1 = mysqli_query($GLOBALS['link'], "SELECT * FROM  _tbcondiciones  where id_tbcondiciones=$row");
$row1 = mysqli_fetch_array($result1);

echo json_encode(array($row1['nivel'], $row1['cod'], $row1['Ejemplar'], $row1['DF'], $row1['Premio'], $row1['Cupo']));
