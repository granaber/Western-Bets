<?
// ********** Creacion de archivo XML ************
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$content = trim(file_get_contents("php://input"));
$decoded = json_decode($content, true);


$vermenu = $decoded['idmenu'];
$sql = 'SELECT * FROM _tmenu where variable="' . $vermenu . '"';

$resultj = mysqli_query($GLOBALS['link'], $sql);
$Row = mysqli_fetch_array($resultj);

$n = str_replace('.php', '.ventas.php', $Row['Modulocomando']);
$n = str_replace('tablemenu', 'options-menu', $n);
$d = explode(",", $n);
$d1 = explode("(", $d[0]);
echo json_encode(['src' => $d1[1]]);
