<?
require_once('prc_skynet.php');
require('prc_php.php');
$minutos = 210;
$GLOBALS['link'] = Connection::getInstance();

$Liga = $_REQUEST['liga'];
$fc = $_REQUEST["fc"];
$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbligaxml where Liga=$Liga");
// echo ("SELECT * FROM _tbligaxml where Liga=$Liga" );
if (mysqli_num_rows($resultj) == 0) :

	$fc1 = explode("/", $fc);
	if (strlen($fc1[1]) == 1) : $fc1[1] = '0' . $fc1[1];
	endif;
	if (strlen($fc1[0]) == 1) : $fc1[0] = '0' . $fc1[0];
	endif;
	$fechaactual = $fc1[2] . $fc1[1] . $fc1[0];

	$GLOBALS['link'] = Skynet::getInstance();

	$result = mysqli_query($GLOBALS['link'], "Select * From _tbjornada  Where gmdt='$fechaactual'");

	$row = mysqli_fetch_array($result);
	$IDJsk = $row['IDJsk'];


	$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbligas where Liga=$Liga and IDJsk=$IDJsk");
	$row = mysqli_fetch_array($resultj);

	$respuesta[] = true;
	$respuesta[] = $row['Descripcion'];
	$respuesta[] = $row['IdSport'];
else :
	$respuesta[] = false;
endif;

echo json_encode($respuesta);
