<?
require_once('prc_skynet.php');
require('prc_php.php');
$Liga = $_REQUEST['liga'];

$ch = curl_init('http://parlayenlinea.tk:7890/liga?Liga=' . $Liga);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$feed = curl_exec($ch);

$minutos = 210;
$GLOBALS['link'] = Connection::getInstance();


$Grupo = '';
$Formato = '';
$Apuestas = '';
$Escrute = '';
$Relacion = '';

$resultado = array(true);
$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbligaxml where Liga=$Liga");
if (mysqli_num_rows($resultj) == 0) :
	//	echo ("SELECT * FROM _tbligaxml where Liga=$Liga" );

	$Tipo = $_REQUEST['IdSport'];
	$Firma = substr($_REQUEST['Nom'], 0, 3) . '_' . $Liga . '_';
	$Descripcion = str_replace('-', '', $_REQUEST['Nom']);
	$Ainiciales = explode(' ', $Descripcion);
	//  print_r($Ainiciales);
	$InicTicket = $Tipo;
	$InicTicket .= substr($Ainiciales[0], 0, 5);
	for ($i = 1; $i <= count($Ainiciales) - 1; $i++) {
		$InicTicket .= ' ';
		$InicTicket .= substr($Ainiciales[$i], 0, 2);
	}
	$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _gruposdd ORDER BY Grupo DESC");
	$row = mysqli_fetch_array($resultj);
	$ValorG = $row['Grupo'] + 1;

	$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _formatosbb ORDER BY Formato DESC");
	$row = mysqli_fetch_array($resultj);
	$Valor1 = $row['Formato'] + 1;

	$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbjuegodd ORDER BY IDDD DESC");
	$row = mysqli_fetch_array($resultj);
	$ValorJ1 = $row['IDDD'] + 1;
	$ok = false;

	include('skynet-creatorDB.php');


	if ($ok) :
		/*echo $Grupo;
		echo $Formato;
	   	echo $Apuestas;
		echo $Relacion;
		echo $Escrute;	*/


		mysqli_query($GLOBALS['link'], "begin");

		$resultj1 = mysqli_query($GLOBALS['link'], $Grupo);
		$resultj2 = mysqli_query($GLOBALS['link'], $Formato);
		$resultj3 = mysqli_query($GLOBALS['link'], $Apuestas);
		$resultj4 = mysqli_query($GLOBALS['link'], $Relacion1);
		$resultj5 = mysqli_query($GLOBALS['link'], $Relacion2);
		for ($i = 0; $i <= count($Escrute) - 1; $i++) $resultjk = mysqli_query($GLOBALS['link'], $Escrute[$i]);

		if ($resultjk && $resultj1 && $resultj2 && $resultj3 && $resultj4 && $resultj5) :
			mysqli_query($GLOBALS['link'], "commit");
			$resultado[0] = true;
		else :
			mysqli_query($GLOBALS['link'], "rollback");
			$resultado[0] = false;
			if (!$resultjk) :  $resultado[] = 'E';
			endif;
			if (!$resultj1) : $resultado[] = 'G';
			endif;
			if (!$resultj2) : $resultado[] = 'F';
			endif;
			if (!$resultj3) : $resultado[] = 'A';
			endif;
			if (!$resultj4) : $resultado[] = 'R1';
			endif;
			if (!$resultj5) : $resultado[] = 'R2';
			endif;
		endif;

	/*  $GLOBALS['link'] = Skynet::getInstance(); 
	  $resultj = mysqli_query($GLOBALS['link'],"SELECT * FROM _robotx_skynet where Tipo='$Tipo'" );
	  if (mysqli_num_rows($resultj)!=0):
	    $row = mysqli_fetch_array($resultj);
	   	$SQLGrupo=$row['Grupo'];
		echo $SQLGrupo;
	    echo "	INSERT INTO `_gruposdd` (`Grupo`, `Descripcion`, `Estatus`, `imagen`) VALUES($Liga, '$Descripcion', 1, '$Liga.png');";	*/
	else :
		$resultado[0] = false;
	endif;

endif;

echo json_encode($resultado);
