<?
include_once('./prc_php.php');
require_once 'prc_credit.php';

$RETIROTOTAL = 'TOTAL';

$GLOBALS['link'] = Connection::getInstance();
$content = trim(file_get_contents("php://input"));
$decoded = json_decode($content, true);

$mode = $decoded['mode'];
$idusu_temp = $decoded['idusutemp'];
$Monto = $decoded['monto'];
$Referencia = $decoded['referencia'];
$formatpay = $decoded['formatpay'];
$tel_user = $decoded['teluser'];
$idban = $decoded['idban'];
$passport = $decoded['passport'];


if ($mode == $RECARGA) {
    $response = setReportPay('', $idusu_temp, $Monto, $Referencia, $formatpay, $tel_user, $idban);
    echo json_encode(['status' => $response[0], 'voucher' => $response[1]]);
    exit;
}
if ($mode == $RETIRO) {
    $typemonto = $decoded['typemonto'];
    $Saldo = getSaldoDisponible($idusu_temp);
    if ($Saldo == 0) {
        echo json_encode(['status' => false, 'voucher' => 0]);
        exit;
    }
    if ($typemonto == $RETIROTOTAL) {
        $Monto = $Saldo;
    } else {
        if ($Monto > $Saldo) {
            echo json_encode(['status' => false, 'voucher' => 0]);
            exit;
        }
    }
    $response =  setReportRet('', $idusu_temp, $Monto, $Referencia, $formatpay, $tel_user, $idban, $passport);
    echo json_encode(['status' => $response[0], 'voucher' => $response[1]]);
    exit;
}

function getSaldoDisponible($idusu_temp)
{
    global  $TYPE_SALDO;

    $resultij = mysqli_query($GLOBALS['link'], "select * from _tusu where IDusu=$idusu_temp");
    if (mysqli_num_rows($resultij) != 0) {
        $rowij = mysqli_fetch_array($resultij);
        $resp = BackendCredito($rowij['Asociado'], 0, 0, $TYPE_SALDO);
        if (!$resp['err']) {
            return $resp['saldo'];
        }
    }
    return 0;
}
