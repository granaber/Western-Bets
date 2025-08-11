<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$vermenu = $_REQUEST['idmenu'];
$sql = 'SELECT * FROM _tmenu where variable="' . $vermenu . '"';
$resultj = mysqli_query($GLOBALS['link'], $sql);
$Row = mysqli_fetch_array($resultj);
Logs($_REQUEST['idt'], $Row['IDM'], 'Menu Ejecutando', 1);
echo $Row['Modulocomando'];
