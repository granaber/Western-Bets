<?
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('content-type: application/json; charset=utf-8');
require_once("functionPayTDC.php");
require_once("api_type.php");
include_once 'set_stateenv.php';

$Rq = $_REQUEST['rq'];

define('HOST_PRODUCTION_MAIN', 'http://portal.westernbets.pro');
define('HOST_DEVELOMENT_MAIN', 'http://localhost:3000');

define('HOST_PRODUCTION_MAIN_1', 'https://westernbets.pro');
define('HOST_DEVELOMENT_MAIN_1', 'http://localhost:5200');



switch ($Rq) {
    case $CODE_FOR_PAY_RECARD;
    case $CODE_FOR_PAY:
        $code_user = $_REQUEST['code'];
        $List = explode("|", $_REQUEST['items']);
        $idb = $_REQUEST['idb'] ?? 1;
        $Items = [];
        foreach ($List as $data) {
            $des = explode("-", $data);
            $Items[] = ["Description" => $des[0], "Value" => $des[1]];
        }
        echo json_encode(handlePay($Items, $code_user,  $idb, $Rq == $CODE_FOR_PAY,));
        break;

    case $CODE_FOR_STATUS:
        $comprobante = $_REQUEST['comprobante'];
        $session_id = $_REQUEST['session_id'];
        $idb = $_REQUEST['idb'] ?? 1;

        $res =  handleCheckTranss($comprobante, $session_id,   $idb);
        $d = handleDataSave($res);
        header("HTTP/1.1 301 Moved Permanently");
        $mode = modeDetect();

        $host =  HOST_PRODUCTION_MAIN; //: HOST_DEVELOMENT_MAIN;
        // header("Location: http://portal.westernbets.pro/portal?port=4&data=" . $d['data']);
        header("Location: $host/portal?port=4&data=" . $d['data']);

        break;

    case $CODE_FOR_STATUS_RECARD:
        $comprobante = $_REQUEST['comprobante'];
        $session_id = $_REQUEST['session_id'];
        $idb = $_REQUEST['idb'] ?? 1;

        $res =  handleCheckTranss($comprobante, $session_id,   $idb);
        $d = addindRecardTDC($res);
        header("HTTP/1.1 301 Moved Permanently");
        $mode = modeDetect();

        $host =  HOST_PRODUCTION_MAIN_1; //: HOST_DEVELOMENT_MAIN_1;

        header("Location: $host/redirect-past.php?idusu=" . $d);
        break;

    case $CODE_FOR_CREATE_CLIENT:
        $id = $_REQUEST['id_factura'];
        $res = pasarellOtherpay($id);
        echo json_encode(["status" => $res]);
        break;
        $id = $_REQUEST['id_factura'];
    case $CODE_FOR_CREATE_CLIENT_WITHPAY:
        $id = $_REQUEST['id'];
        $idb = $_REQUEST['idb'] ?? 1;

        $res = CreateUserWithoutPay($id, $idb);
        echo json_encode(["status" => $res]);
        break;
    case $CODE_FOR_SEND_CREDENTIAL:
        $user_name = $_REQUEST['user_name'];
        $Resp = SendMensajesOL($user_name);
        echo json_encode($Resp);
        break;

    case $CODE_FOR_REQUEST_TOKET:
        $IDusu = $_REQUEST['IDusu'];
        $Resp = Send2fa($IDusu);
        echo json_encode($Resp);
        break;

    case $CODE_FOR_RESPONSE_TOKET:
        $IDusu = $_REQUEST['IDusu'];
        $Tk = $_REQUEST['Tk'];
        $Resp = Very2fa($IDusu, $Tk);
        echo json_encode($Resp);
        break;

    case $CODE_FOR_CREATE_USER:
        $IDusu = $_REQUEST['idusutemp'];
        $idb = $_REQUEST['idb'] ?? 1;
        $formatPay = 6;
        $idc = generalCreaterClient($IDusu, $formatPay, 0, $idb);
        if ($idc == '-1') {
            echo json_encode(["status" => 0, "message" => "Error al crear el cliente", "idc" => $idc]);
            break;
        }
        echo json_encode(["status" => 1, "message" => "ok", "idc" => $idc]);
        // case $TEST_CODE_FOR_STATUS:
        //     test();
        //     break;

        // case $TEST_CODE_FOR_PAY:
        //     $List = explode("|", $_REQUEST['items']);
        //     $Items = [];
        //     $monto = 0;
        //     $transs =  getIdTransaccion();
        //     foreach ($List as $data) {
        //         $des = explode("-", $data);
        //         $Items[] = ["Description" => $des[0], "Value" => $des[1]];
        //         $monto += intval($des[1]);
        //     }
        //     $data = ["codetranss" => $transs, "monto" => $monto];
        //     print_r($data);
        //     handleFirtsCreate($data);
        //     break;
}