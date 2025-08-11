<?


require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$IDC = $_REQUEST['IDC'];

$resultij = mysqli_query($GLOBALS['link'], "Delete from _TmpCrediONE where IDC='$IDC'");
