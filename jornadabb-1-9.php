<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();



if ($_REQUEST['op'] == 0) :

	$Dequipo = $_REQUEST['Dequipo'];
	$Grupo = $_REQUEST['Grupo'];
	$Liga = $_REQUEST['Liga'];
	$IDE = $_REQUEST['Asociado'];
	$RDequipo = $_REQUEST['RDequipo'];

	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _equiposbb Order by IDE DESC");
	$row = mysqli_fetch_array($result);
	$nIDE = $row['IDE'] + 1;

	if ($IDE == 0) :
		$respuesta[1] = $RDequipo;
		$result = mysqli_query($GLOBALS['link'], "Insert _equiposbb Values ($nIDE,'$RDequipo','000',$Grupo,0,0)");
		if ($Dequipo == $RDequipo) :
			$result = mysqli_query($GLOBALS['link'], "Insert _tbequixml Values ($nIDE,$Liga,'$RDequipo')");
		else :
			$result = mysqli_query($GLOBALS['link'], "Insert _tbequixml Values ($nIDE,$Liga,'$Dequipo')");
		endif;


	else :
		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _equiposbb where IDE=$IDE ");
		if (mysqli_num_rows($result) != 0) :
			$result = mysqli_query($GLOBALS['link'], "Insert _tbequixml Values ($IDE,$Liga,'$Dequipo')");
			$respuesta[1] = -1;
		else :
			$respuesta[1] = -2;
		endif;
	endif;

	$respuesta[0] = $result;
else :

	$EDevolver = $_REQUEST['EDevolver'];
	$Grupo = $_REQUEST['Grupo'];
	$Liga = $_REQUEST['Liga'];
	$Aequipo = $_REQUEST['Aequipo'];
	$delseleccion = $_REQUEST['seleccion'];

	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _equiposbb where Descripcion='$EDevolver' ");
	if (mysqli_num_rows($result) != 0) :
		$row = mysqli_fetch_array($result);
		$IDE = $row['IDE'];
		$result = mysqli_query($GLOBALS['link'], "Delete FROM _equiposbb where IDE=$IDE ");

		$result = mysqli_query($GLOBALS['link'], "Delete FROM _tbequixml where IDE=$IDE ");

	else :
		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _equiposbb where Descripcion='$Aequipo' ");
		if (mysqli_num_rows($result) != 0) :
			$row = mysqli_fetch_array($result);
			$IDE = $row['IDE'];
			if ($delseleccion == 0) :
				$result = mysqli_query($GLOBALS['link'], "Delete FROM _equiposbb where IDE=$IDE ");
			endif;
			$result = mysqli_query($GLOBALS['link'], "Delete FROM _tbequixml where IDE=$IDE ");
		endif;
	endif;

	$respuesta = $result;


endif;



echo json_encode($respuesta);
