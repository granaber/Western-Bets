<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$new = $_REQUEST['newi'];


$result = mysqli_query($GLOBALS['link'], "DELETE FROM _tbvalidarlogros  where Idval=$new ");
if ($result) :
  $respuesta = true;
else :
  $respuesta = error(1);
endif;

echo json_encode($respuesta);
