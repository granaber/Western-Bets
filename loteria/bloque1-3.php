<?


require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$idBlq = $_REQUEST['idBlq'];
if ($idBlq >= 0) :
	$fecha = $_REQUEST['fecha'];
	$selec1 = $_REQUEST['selec1'];
	$monto = $_REQUEST['monto'];
	$selec2 = $_REQUEST['selec2'];
	$Numero = $_REQUEST['Numero'];
	$Aplicar = $_REQUEST['Aplicar'];
	$loteria = explode('|', $_REQUEST['loteria']);
	$Adicional = $_REQUEST['Adicional'];
	$idAplicar = $_REQUEST['idAplicar'];

	$dsidAplicar = explode('-', $idAplicar);


	$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbbloqueo where IDBlq=$idBlq");
	if (mysqli_num_rows($resultj) == 0) :

		$result = mysqli_query($GLOBALS['link'], "INSERT INTO _tbbloqueo  (Select1, Fecha, Aplicar, numero, IDLot, Adicional, Select2, Monto,tipo) VALUES ($selec1,'$fecha'," . $dsidAplicar[1] . ",'$Numero'," . $loteria[0] . ",$Adicional,$selec2,$monto," . $dsidAplicar[0] . ")");


	else :
		$result = mysqli_query($GLOBALS['link'], "Update  _tbbloqueo  set Select1=$selec1, Fecha='$fecha', Aplicar=" . $dsidAplicar[1] . ", numero='$Numero', IDLot=" . $loteria[0] . ", Adicional=$Adicional, Select2=$selec2, Monto=$monto , tipo=" . $dsidAplicar[0] . " where  IDBlq=$idBlq");

	//	echo ("Update  _tbbloqueo  set Select1=$selec1, Fecha='$fecha', Aplicar=".$dsidAplicar[1].", numero='$Numero', IDLot=,".$loteria[0].", Adicional=$Adicional, Select2=$selec2, Monto=$monto , tipo=".$dsidAplicar[0]." where  IDBlq=$idBlq");
	endif;

else :
	$idBlq = $idBlq * -1;
	$result = mysqli_query($GLOBALS['link'], "Delete  from _tbbloqueo  where  IDBlq=$idBlq");

endif;
echo json_encode($result);
