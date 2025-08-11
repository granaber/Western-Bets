<?
require_once('prc_phpDUK.php');
$link = ConnectionAnimalitos::getInstance();

$IDL = $_REQUEST['IDL'];
$Nombre = $_REQUEST['Nombre'];
$Icono = $_REQUEST['logo'];
$activo = $_REQUEST['Activa'];
$AutoSorteo = $_REQUEST['AutoSorteo'];
$Code = $_REQUEST['Code'];

$minimalNumber = $_REQUEST['minimalNumber'];
$procentajeSplit = $_REQUEST['procentajeSplit'];

$resultj = mysqli_query($link, "SELECT * FROM _Loterias  Where IDL=" . $_REQUEST['IDL']);
if (mysqli_num_rows($resultj) == 0) :
	$resultj = mysqli_query($link, "Insert _Loterias  values ($IDL,'$Nombre',$activo,'0',$AutoSorteo,'$Code');");
else :
	// echo "Update _Loterias  set Nombre='$Nombre',Activa=$activo,logo='0',xFun=$AutoSorteo,Code='$Code',minimalNumber=$minimalNumber,procentajeSplit=$procentajeSplit Where IDL=$IDL";
	$resultj = mysqli_query($link, "Update _Loterias  set Nombre='$Nombre',Activa=$activo,logo='0',xFun=$AutoSorteo,Code='$Code',minimalNumber=$minimalNumber,procentajeSplit=$procentajeSplit Where IDL=$IDL");
endif;
//echo ("Update _Loterias  set Nombre='$Nombre',Activa=$activo,logo='$Icono',xFun=$AutoSorteo,Code='$Code' Where IDL=$IDL");
echo json_encode($resultj);
