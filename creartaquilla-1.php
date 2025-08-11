<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();


// Concesionario
$c_idc = $_REQUEST['c_idc'];
$direccion = $_REQUEST['direccion'];
$grupo = $_REQUEST['grupo'];
$nomidcn = $_REQUEST['nomidcn'];




// Usuario
$usuario = $_REQUEST['usuario'];
$nombre = $_REQUEST['nombre'];
$claveGenerada = $_REQUEST['claveGenerada'];

// Ventas  
$pVentas = $_REQUEST['pVentas'];
$pVentaspd = $_REQUEST['pVentaspd'];
$Eminutos = $_REQUEST['Eminutos'];
$cmaxelim = $_REQUEST['cmaxelim'];

$cdpi = $_REQUEST['cdpi'];
$cjmp = $_REQUEST['cjmp'];
$mma = $_REQUEST['mma'];
$mmdp = $_REQUEST['mmdp'];
$mmjpd = $_REQUEST['mmjpd'];
$mmjpp = $_REQUEST['mmjpp'];
$mxpjpd = $_REQUEST['mxpjpd'];
$pdrl = $_REQUEST['pdrl'];
$maxpremio = $_REQUEST['maxpremio'];

mysqli_query($GLOBALS['link'], "begin");
$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionario where IDC='$c_idc' ");
if (mysqli_num_rows($result) == 0) :
	//   if (true):
	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tusu where Usuario='$usuario' ");
	if (mysqli_num_rows($result) == 0) :
		//     if (true):

		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionario Order by IDRow DESC ");
		$row = mysqli_fetch_array($result);
		if (mysqli_num_rows($result) != 0) :
			$idr = $row["IDRow"] + 1;
		else :
			$idr = 1;
		endif;

		$result = mysqli_query($GLOBALS['link'], "INSERT INTO _tconsecionario  (IDRow,Nombre,Telefono,Estatus,Direccion,Estado,Municipio,IDG,IDC,celular,email,responsable) VALUES (" . $idr . ",'$c_idc','0',1,'$direccion','$direccion','$direccion',$grupo,'$nomidcn','','','')");

		if ($result) :

			$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tusu Order by IDusu DESC ");
			if (mysqli_num_rows($result) != 0) :
				$row = mysqli_fetch_array($result);
				$idu = $row["IDusu"] + 1;
			else :
				$idu = 1;
			endif;

			$result = mysqli_query($GLOBALS['link'], "INSERT INTO _tusu (IDusu,Estacion,Descripcion,clave,Usuario,Asociado,Estatus,Nombre,Acceso,Tipo,AccesoP,AGrupo,lastactivity,ABanca)  VALUES (" . $idu . ",1,'','$claveGenerada','$usuario','$nomidcn',1,'$nombre','" . listaacceso('Vendedor') . "',3,'3',0,0,0)");

			if ($result) :

				$result = mysqli_query($GLOBALS['link'], "INSERT INTO _tconsecionariodd  VALUES ('$nomidcn',0,1,$pVentas,$cmaxelim,0,$mmjpd,$mma,$mmjpp,$pVentaspd,$mmdp,1,0,$cdpi,$cjmp,$Eminutos,$pdrl,$mxpjpd,$maxpremio)");
				//		echo ("INSERT INTO _tconsecionariodd  VALUES ('$nomidcn',0,1,$pVentas,$cmaxelim,0,$mmjpd,$mma,$mmjpp,$pVentaspd,$mmdp,1,$cdpi,$cjmp,$Eminutos,$pdrl,$mxpjpd)");
				if ($result) :
					mysqli_query($GLOBALS['link'], "commit");
					$respuesta[] = true;
				else :
					mysqli_query($GLOBALS['link'], "rollback");
					$respuesta = error(5);
				endif;

			else :
				mysqli_query($GLOBALS['link'], "rollback");
				$respuesta = error(4);
			endif;

		else :
			mysqli_query($GLOBALS['link'], "rollback");
			$respuesta = error(3);
		endif;
	else :
		mysqli_query($GLOBALS['link'], "rollback");
		$respuesta = error(2);
	endif;
else :
	mysqli_query($GLOBALS['link'], "commit");
	$respuesta = error(1);
endif;

echo json_encode($respuesta);

function error($code_error)
{

	$rerror[] = false;
	switch ($code_error) {
		case 1:
			$rerror[] = 'La Letra del Concesionario YA EXISTE, Debe Cambiarlo';
			break;
		case 2:
			$rerror[] = 'El Nombre del Usuario YA EXISTE, Debe Cambiarlo';
			break;
		case 3:
			$rerror[] = 'Error en los Datos del Concesionario Verifique';
			break;
		case 4:
			$rerror[] = 'Error en los Datos del Usuario Verifique';
			break;
		case 5:
			$rerror[] = 'Error en los Datos del Concesionario Parametros para la Ventas Verifique';
			break;
	}
	return $rerror;
}


function listaacceso($cmp)
{

	$resultMENU = mysqli_query($GLOBALS['link'], " SELECT *  FROM _tmenu where  " . $cmp . "!=1");
	$en = '|';
	if (mysqli_num_rows($resultMENU) != 0) :
		$en = '';
		while ($row = mysqli_fetch_array($resultMENU))
			$en .= $row['variable'] . '|';
	endif;
	return $en;
}
