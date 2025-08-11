<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$result = mysqli_query($GLOBALS['link'], $_REQUEST['SqlStatus']);
