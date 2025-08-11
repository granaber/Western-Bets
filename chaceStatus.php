<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$result = mysqli_query($GLOBALS['link'], stripcslashes($_REQUEST['SqlStatus']));
