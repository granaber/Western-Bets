<?
// ********** Creacion de archivo XML ************
require_once('prc_phpDUK.php');
global $serverD;
global $userD;
global $clvD;
global $dbD;

$link = mysqli_connect($serverD, $userD, $clvD);
mysqli_select_db($link, $dbD);

//echo $serverD;echo ' ';
//echo $userD;echo ' ';
//echo $clvD;echo ' ';
//echo $dbD;echo ' ';
$vermenu = $_REQUEST['idmenu'];

$sql = 'SELECT * FROM _tmenu where variable="' . $vermenu . '"';
//echo $sql;

$resultj = mysqli_query($link, $sql);
$Row = mysqli_fetch_array($resultj);
echo '<script> ';
echo $Row['Modulocomando'];
echo '</script>';