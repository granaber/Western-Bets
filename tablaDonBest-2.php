<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$ID = $_REQUEST['id'];
$iDCampo = $_REQUEST['Campo'] - 3;
$Valor = $_REQUEST['valor'];


$aCampos = array('A20M', 'A20H', 'A30M', 'A30H', 'A40M', 'A40H', 'AMacho', 'BHembra', 'ApreMedM', 'ApreMedH', 'ApreUnM', 'ApreUnH', 'ApreUnMedM', 'ApreUnMedH', 'MoneyLM', 'MoneyLH', 'Logro5inM', 'Logro5inH');




$result3 = mysqli_query($GLOBALS['link'], "Update _DBconver Set " . $aCampos[$iDCampo] . "=" . $Valor . " where IDC=$ID");

echo json_encode($result3);
