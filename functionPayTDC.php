<?
$FlatPass = true;
require_once './vendor/autoload.php';
require_once('prc_php.php');
require_once('prc_credit.php');
require_once("send_ws.php");
require_once("api_type.php");
include_once 'set_stateenv.php';



$GLOBALS['link'] = Connection::getInstance();


define('HOST_PRODUCTION', 'https://westernbets.pro');
define('HOST_DEVELOMENT', 'http://localhost:5200');

// API TEST
// define("stripeSecretKey", "sk_test_51EkZkZAxMaD5AMhFi2ZpubvcEjSxDbn0PicmvY7fzxsfMvklLKnZZGGKYWEskr2dVBfJuj9iYuGSYtgnFCQ9vlCU00uOwXwKIx");
// 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

// API PRODUCTION
define("stripeSecretKey", "null");


define("CODE_OK", 0);
define("CODE_ERR_TRANSA", 1);
define("CODE_ERR_COMUNI", 2);


define("TDC", "TDC");
define("TRANSFERENCIA", "TRANSFERENCIA");
define("WITHOUTPAY", "SOLO REGISTRO");
define("OTHER", "OTHER");


$ENTRAMITE = 0;
$COMPLETADO = 1;
$ELIMINADOXERROR = 3;

enum PayStatus: string
{
    case paid = 'paid';
    case unpaid = 'unpaid';
    case no_payment_required = 'no_payment_required';
}

enum StatusSession: string
{
    case open = 'open';
    case complete = 'complete';
    case expired = 'expired';
}
function handlePay($Items, $code_user, $idb,  $registre = true)
{

    global $CODE_FOR_STATUS, $CODE_FOR_STATUS_RECARD,  $PRODUCCION;

    $stripe = new \Stripe\StripeClient(stripeSecretKey);
    $monto = 0;
    $line_items = [];
    //prod_QtOYRpij12unZp
    foreach ($Items as $key => $value) {
        $item = $key + 1;
        $price = searchPrice($value['Value']);
        $line_items[] = [
            'price' => $price,
            'quantity' => $item
        ];
        $monto += intval($value['Value']);
    }
    $transs =  getIdTransaccion();
    $data = ["codetranss" => $transs, "monto" => $monto, "code_user" => $code_user];
    $rq = $registre ? $CODE_FOR_STATUS : $CODE_FOR_STATUS_RECARD;

    handleFirtsCreate($data, $rq);

    // $mode = modeDetect();
    $host = HOST_PRODUCTION; // HOST_DEVELOMENT; //  ; //: ;

    $YOUR_DOMAIN = "$host/apipay.php?rq=$rq&comprobante=$transs&session_id={CHECKOUT_SESSION_ID}&idb=$idb";
    // $YOUR_DOMAIN = "https://westernbets.pro/apipay.php?rq=STATUS&comprobante=$transs&session_id={CHECKOUT_SESSION_ID}";



    // $checkout_session = $stripe->checkout->sessions->create([
    //     'ui_mode' => 'embedded',
    //     'line_items' => $line_items,
    //     'mode' => 'payment',
    //     'return_url' => $YOUR_DOMAIN . '/return.html?session_id={CHECKOUT_SESSION_ID}',
    // ]);


    $linkspay = $stripe->paymentLinks->create([
        'line_items' => $line_items,
        ['metadata' => ['order_id' => $transs]],
        'after_completion' => [
            'type' => 'redirect',
            'redirect' => ['url' => $YOUR_DOMAIN],
        ],
    ]);
    $status = $linkspay->active;
    $redirect =  $linkspay->url;

    if ($status) {
        header("Location:$redirect ");
        return [true, CODE_OK, '', $transs];
    }
    return [false, CODE_ERR_TRANSA, '', $transs];
}
function searchPrice($price)
{
    $base = 100;
    $mont = $price * $base;
    $stripe = new \Stripe\StripeClient(stripeSecretKey);
    $search = $stripe->prices->all(['limit' => 50]);
    $data = $search->data;
    $id = 'none';
    foreach ($data as $key => $value) {
        $unit_amount = $value->unit_amount;

        if ($unit_amount == $mont) {
            $id = $value->id;
            break;
        }
    }

    if ($id == 'none') {
        $info = $stripe->prices->create([
            'currency' => 'usd',
            'unit_amount' => $price * $base,
            'product_data' => ['name' => 'Producto $' . $price],
        ]);
        return $info->id;
    }
    return $id;
}
function searchOrderIdPayLinks($orderId)
{
    $stripe = new \Stripe\StripeClient(stripeSecretKey);
    $search = $stripe->paymentLinks->all(['limit' => 3]);
    $data = $search->data;
    foreach ($data as $key => $value) {
        # code...
        $metadata = $value->metadata;
        $order_id = $metadata->order_id;
        if ($order_id == $orderId) {
            return $value->id;
        }
    }
    return 'none';
}
function disablePaayLinks($orderId)
{
    $idPl = searchOrderIdPayLinks($orderId);
    if ($idPl != 'none') {
        $stripe = new \Stripe\StripeClient(stripeSecretKey);
        $stripe->paymentLinks->update(
            $idPl,
            ['active' => false]
        );
    }
}
function test()
{
    $base = 100;
    $price = 20;
    $orderId = 70;
    $stripe = new \Stripe\StripeClient(stripeSecretKey);
    $search = $stripe->checkout->sessions->all(['limit' => 3]);
    // $search = $stripe->paymentLinks->all(['limit' => 3]);

    print_r($search);
    // $data = $search->data;
    // foreach ($data as $key => $value) {
    //     # code...
    //     $metadata = $value->metadata;
    //     $order_id = $metadata->order_id;
    //     if ($orderId ==  $order_id) {
    //         $id = $value->id;
    //         echo $id;
    //         $stripe->paymentLinks->update(
    //             $id,
    //             ['active' => false]
    //         );
    //         break;
    //     }
    // }
    // $info = $stripe->prices->create([
    //     'currency' => 'usd',
    //     'unit_amount' => $price * $base,
    //     'product_data' => ['name' => 'Produto $' . $price],
    // ]);
    // print_r($info);
}
function handleCheckTranss($comprobante, $session_id, $idb)
{
    $base = ["codetranss" => $comprobante, "token" => $session_id];

    $stripe = new \Stripe\StripeClient(stripeSecretKey);
    $session = $stripe->checkout->sessions->retrieve($session_id);
    // $customer = $stripe->customers->retrieve($session->customer);

    $payStatus = $session->payment_status;
    $status = $session->status;

    // print_r($session);
    // echo "****    $payStatus ,  $status";
    // echo "****   " . PayStatus::paid->value . "  " . StatusSession::complete->value;

    if ($payStatus == PayStatus::paid->value) {
        if ($status == StatusSession::complete->value) {
            $numero_aprobacion_pg = $session_id;
            $fecha_cobro = convertEpochToDate($session->created);
            disablePaayLinks($comprobante);
            return array_merge(["err" => false, "code" => CODE_OK, "text" => '', "noapro" => $numero_aprobacion_pg, "datecobro" => $fecha_cobro, "idb" => $idb], $base);
        } else {
            return array_merge(["err" => true, "code" => CODE_ERR_TRANSA, "text" => "Pago no completado", "noapro" => 'NA', "datecobro" => 'NA', "idb" => $idb], $base);
        }
    }


    // $Pagadito = new Pagadito(UID, WSK);
    // if (AMBIENTE_SANDBOX) {
    //     $Pagadito->mode_sandbox_on();
    // }
    // if ($Pagadito->connect()) {
    //     if ($Pagadito->get_status($Token)) {
    //         $estado = $Pagadito->get_rs_status();
    //         if ($estado == "COMPLETED") {
    //             $numero_aprobacion_pg = $Pagadito->get_rs_reference();
    //             $fecha_cobro = $Pagadito->get_rs_date_trans();
    //             return array_merge(["err" => false, "code" => CODE_OK, "text" => '', "noapro" => $numero_aprobacion_pg, "datecobro" => $fecha_cobro], $base);
    //         } else {
    //             return array_merge(["err" => true, "code" => $Pagadito->get_rs_code(), "text" => $Pagadito->get_rs_message(), "noapro" => 'NA', "datecobro" => 'NA'], $base);
    //         }
    //     }
    // }
    return array_merge(["err" => true, "code" => 0, "text" =>  "", "noapro" => 'NA', "datecobro" => 'NA', "idb" => $idb], $base);
}
function handleFirtsCreate($data, $origin)
{
    $FORMATPAY = 'TDC';
    $fields = "(IDFacturas,Toket,lasttime,monto,formatpay,error,code,texterr,fechadecobro,noapro,idu,origin)";
    $IDFacturas = $data['codetranss'];
    $monto = $data['monto'];
    $code_user = $data['code_user'];
    $formatpay = getFormatPay($FORMATPAY);

    $insert_data = "( $IDFacturas,'',NOW(),$monto, $formatpay,0,'','','','',$code_user,'$origin')";
    $result_d = mysqli_query($GLOBALS['link'], "Insert _transac_portal_pay   $fields values $insert_data");
    return $result_d;
}
function handleDataSave($data)
{

    $IDFacturas = $data['codetranss'];
    $Token = $data['token'];

    $error = $data['err'] ? 1 : 0;
    $code = $data['code'];
    $texterr = $data['text'];

    $fechadecobro = $data['datecobro'];
    $noapro = $data['noapro'];

    $update_data = "Toket='$Token',error=$error,code='$code',texterr='$texterr',fechadecobro='$fechadecobro',noapro='$noapro'";
    mysqli_query($GLOBALS['link'], "Update  _transac_portal_pay  set $update_data  where IDFacturas=$IDFacturas");
    createrUserforPortal($data, TDC);

    return ["error" => $error, "data" => $IDFacturas];
}
function pasarellOtherpay($id)
{
    $data = ['id' => $id, 'err' => false];
    $res = createrUserforPortal($data, OTHER);
    return $res;
}
function addindRecardTDC($data)
{
    // Datos de facturacion de TDC
    $IDFacturas = $data['codetranss'];
    $Token = $data['token'];

    $error = $data['err'] ? 1 : 0;
    $code = $data['code'];
    $texterr = $data['text'];

    $fechadecobro = $data['datecobro'];
    $noapro = $data['noapro'];

    $update_data = "Toket='$Token',error=$error,code='$code',texterr='$texterr',fechadecobro='$fechadecobro',noapro='$noapro'";
    mysqli_query($GLOBALS['link'], "Update  _transac_portal_pay  set $update_data  where IDFacturas=$IDFacturas");


    //Proceso de Registro de Recarga
    $sqltrans = "Select * from  _transac_portal_pay   where IDFacturas=$IDFacturas";
    $field_usu = 'idu';
    $update_data = 'error=1,texterr="error check de Portal de pago!"';
    $sqlPortalPay = "Update  _transac_portal_pay  set $update_data  where IDFacturas=$IDFacturas";

    $result = mysqli_query($GLOBALS['link'], $sqltrans);
    if (mysqli_num_rows($result) != 0) {
        $row = mysqli_fetch_array($result);
        $code_user = $row[$field_usu];
        $monto = $row['monto'];
        if (!$data['err']) {
            $result = mysqli_query($GLOBALS['link'], "Select Asociado from _tusu where IDusu=$code_user");
            if (mysqli_num_rows($result) != 0) {
                $row = mysqli_fetch_array($result);
                $IDC = $row['Asociado'];
                AssingCredit($IDC, $monto);
                PredMessenger($data, $monto, TDC, $code_user, 2, false, $IDC, true);
                return $code_user;
            } else {
                $update_data = 'error=1,texterr="No existe usuario asociado"';
                $sqlPortalPay = "Update  _transac_portal_pay  set $update_data  where IDFacturas=$IDFacturas";
                mysqli_query($GLOBALS['link'], $sqlPortalPay);
            }
        } else {
            mysqli_query($GLOBALS['link'], $sqlPortalPay);
        }
    }
    return -1;
}
function createrUserforPortal($data, $formatpay)
{
    global $ELIMINADOXERROR;

    switch ($formatpay) {
        case TDC:
            $IDFacturas = $data['codetranss'];
            $sqltrans = "Select * from  _transac_portal_pay   where IDFacturas=$IDFacturas";
            $field_usu = 'idu';
            $update_data = 'error=1,texterr="Usuario ya creado / con error check!"';
            $sqlPortalPay = "Update  _transac_portal_pay  set $update_data  where IDFacturas=$IDFacturas";
            break;
        case OTHER:
            $IDFacturas = $data['id'];
            $sqltrans = "Select * from  _transac_portal_register where id=$IDFacturas";
            $field_usu = 'idusu_temp';
            $update_data = 'errortext="Usuario ya creado / con error check!"';
            $sqlPortalPay = "Update  _transac_portal_register  set $update_data  where id=$IDFacturas";
    }

    $result = mysqli_query($GLOBALS['link'], $sqltrans);
    if (mysqli_num_rows($result) != 0) {
        $idb = $data['idb'] ?? 1;
        $row = mysqli_fetch_array($result);
        $code_user = $row[$field_usu];
        $monto = $row['monto'];
        if (!checkStateUserPortal($code_user)) {
            if ($formatpay === TDC) mysqli_query($GLOBALS['link'], $sqlPortalPay);
            return true;
        }
        if (!$data['err']) {
            $IDC =    generalCreaterClient($code_user, $row['formatpay'], $monto, $idb);
            if ($IDC != "-1") {
                AssingCredit($IDC, $monto);
                AssingBono($IDC);
                PredMessenger($data, $monto, $formatpay, $code_user, $row['formatpay'], false, $IDC);
                return true;
            } else {
                return false;
            }
        } else {
            mysqli_query($GLOBALS['link'], "Update  _transac_portal_tempdata set register_complet=$ELIMINADOXERROR where id=$code_user");
            return false;
        }
    }
    return false;
}
function CreateUserWithoutPay($id, $idb)
{
    $sqltrans = "Select * from  _transac_portal_tempdata where id=$id";
    $result = mysqli_query($GLOBALS['link'], $sqltrans);
    if (mysqli_num_rows($result) != 0) {
        $row = mysqli_fetch_array($result);
        $formatpay =  getFormatPay(TRANSFERENCIA);
        $IDC = generalCreaterClient($id, $formatpay, 0, $idb);
        if ($IDC != "-1") {
            AssingCredit($IDC, 0);
            AssingBono($IDC);
            PredMessenger([], 0, WITHOUTPAY, $id, TRANSFERENCIA, false, $IDC);
            return true;
        }
    }
    return false;
}
function SendMensajesOL($user_name)
{
    $result_1 = mysqli_query($GLOBALS['link'], "Select * from  _transac_portal_tempdata   where user='$user_name'");
    if (mysqli_num_rows($result_1) != 0) {
        $row_1 = mysqli_fetch_array($result_1);
        $Status = $row_1['register_complet'];
        $Phone = $row_1['tel'];
        $User = $user_name;
        $Clave = "NOO";
        if ($Status) {
            $result_1 = mysqli_query($GLOBALS['link'], "Select * from  _tusu   where Usuario='$User'");
            $row_1 = mysqli_fetch_array($result_1);
            $Clave = $row_1['clave'];
        }
        $Msg = MensajeForAccess($User, $Clave,  $Status);
        $Response = SendMgs($Phone, $Msg);
        return $Response;
    }
    // $sendmsg = $Response['error'] ? 1 : 0;
    // $codestate = $Response['mensageStates'];
    return ["error" => true, "mensageStates" => "No existe el usuario"];
}

function PredMessenger($data, $monto, $formatpay, $code_user, $idformatpay, $stateShow, $IDC, $Recarga = false)
{
    $sql = $Recarga
        ? "Select * from  _tusu   where IDusu=$code_user"
        : "Select * from  _transac_portal_tempdata   where id=$code_user";
    $result_1 = mysqli_query($GLOBALS['link'], $sql);
    $row_1 = mysqli_fetch_array($result_1);
    $NoApro = '';
    $User =  $Recarga ? $row_1['Usuario'] : $row_1['user'];
    $Clave = $Recarga ? "" : $row_1['pwd'];
    $Status = $Recarga ? 1 : $row_1['register_complet'];
    $Phone = $Recarga ? "" : $row_1['tel'];

    if ($Recarga) {
        $q = mysqli_query($GLOBALS['link'], "Select * from _tconsecionario where IDC='$IDC'");
        $r = mysqli_fetch_array($q);
        $Phone = $r['celular'];
    }

    $dataForBono = getDataBono($IDC);

    if ($formatpay == TDC) {
        $NoApro = $data['noapro'];
        $Fecha = $data['datecobro'];
        $Msg = $Recarga
            ? MensajeforTDCRecarga($NoApro, $User, $Fecha, $Status, $monto, $dataForBono)
            : MensajeforTDC($NoApro, $User, $Clave, $Fecha, $Status, $monto, $dataForBono);
        $Response = SendMgs($Phone, $Msg);
        $resp = SaveStateMsg($Response, $code_user, $Phone);
        return $resp;
    }
    if ($formatpay == WITHOUTPAY) {
        $Fecha = date("F j, Y");
        $Msg = MensajeforOTHERPay(WITHOUTPAY, 'SIN REFERENCIA', $User, $Clave, $Fecha, $Status, $monto, 'PERMITIDO', $dataForBono);
        $Response = SendMgs($Phone, $Msg);
        $resp = SaveStateMsg($Response, $code_user, $Phone);
        return $resp;
    }

    $TypeTrans = getTXTPay($idformatpay);
    $result_2 = mysqli_query($GLOBALS['link'], "Select * from  _transac_portal_register   where idusu_temp=$code_user");
    $row_2 = mysqli_fetch_array($result_2);
    $NoRef = $row_2['code_confirm'];
    $Fecha = $row_2['date_confirm'];
    $StatusAPR = $stateShow ? $row_2['status'] : "";

    $Msg = MensajeforOTHERPay($TypeTrans, $NoRef, $User, $Clave, $Fecha, $Status, $monto, $StatusAPR, $dataForBono);
    $Response = SendMgs($Phone, $Msg);
    $resp = SaveStateMsg($Response, $code_user, $Phone);
    return $resp;
}

function SaveStateMsg($Response, $code_user, $tel)
{
    $sendmsg = $Response['error'] ? 1 : 0;
    $codestate = $Response['mensageStates'];
    $fields = "(sendmsg,codestate,code_user,tel)";
    $values = "($sendmsg,'$codestate',$code_user,'$tel')";
    $result = mysqli_query($GLOBALS['link'], "Insert _transac_portal_check  $fields values $values");
    return $result;
}
function generalCreaterClient($code_user, $formatpay, $monto, $idb)
{
    global $COMPLETADO;

    $result_1 = mysqli_query($GLOBALS['link'], "Select * from  _transac_portal_tempdata   where id=$code_user");
    if (mysqli_num_rows($result_1) != 0) {
        $row_1 = mysqli_fetch_array($result_1);

        mysqli_begin_transaction($GLOBALS['link']);

        $user = $row_1['user'];
        $pwd = $row_1['pwd'];
        $email = $row_1['email'];
        $tel = $row_1['tel'];

        $state = createIDCPortal($user, $email, $tel, $formatpay, $idb); // Creation IDC client 
        if ($state[0]) {
            $IDC = $state[1];
            $state2 = createUserPortal($user, $pwd, $IDC); // Create User access 
            if ($state2[0]) {
                $IDusu = $state2[1];
                $state3 = createSettingPortal($IDC); // Create Limit for sales in client user
                if ($state3) {
                    mysqli_query($GLOBALS['link'], "Update  _transac_portal_tempdata set register_complet=$COMPLETADO where id=$code_user");
                    mysqli_query($GLOBALS['link'], "Update  _transac_portal_asign_bonos set IDusu=$IDusu where id_temp=$code_user");
                    mysqli_commit($GLOBALS['link']);
                    return $IDC;
                }
            }
        }
        mysqli_rollback($GLOBALS['link']);
        return "-1";
    }
    return "-1";
}
function  checkStateUserPortal($code_user)
{
    global $ENTRAMITE;
    $result = mysqli_query($GLOBALS['link'], "Select * from  _transac_portal_tempdata   where  register_complet=$ENTRAMITE and id=$code_user");
    return mysqli_num_rows($result) != 0;
}
//$formatpay
// 2 = TDC $
// 3 = ZELLE $
// 4 = BINANCE $
// 5 = PM = Bs
// 6 = TRANS = Bs
function getFormatPay($TypeText)
{
    $result = mysqli_query($GLOBALS['link'], "Select * from _transac_portal_formpay where text='$TypeText' ");
    if (mysqli_num_rows($result) != 0) {
        $row = mysqli_fetch_array($result);
        return $row['formatpay'];
    }
    return 1;
}
function getIDM($formatpay)
{
    $result = mysqli_query($GLOBALS['link'], "Select * from _transac_portal_formpay where formatpay=$formatpay ");
    if (mysqli_num_rows($result) != 0) {
        $row = mysqli_fetch_array($result);
        return $row['idm'];
    }
    return 1;
}
function getTXTPay($formatpay)
{
    $result = mysqli_query($GLOBALS['link'], "Select * from _transac_portal_formpay where formatpay=$formatpay ");
    if (mysqli_num_rows($result) != 0) {
        $row = mysqli_fetch_array($result);
        return $row['text'];
    }
    return 'TDC';
}
function createUserPortal($user, $pwd, $IDC)
{
    $Acceso = 'op21|op26|op28|op62|op63|op66|op67|op68|op72|op71|op44|op45|op73|op75|op77|op78|op79|op80|op81|op82|op84|op1011|op10201|mf3|op85|op1022|mf2|op2021|op86|mf1|';
    $result = mysqli_query($GLOBALS['link'], "Select IDusu from _tusu  order by IDusu Desc limit 1 ");
    $row = mysqli_fetch_array($result);
    $idUsuNext = $row['IDusu'] + 1;
    $fields = "(IDusu,Estacion,Descripcion,clave,Usuario,Asociado,Estatus,Nombre,Acceso, Tipo,bloqueado, AccesoP, Agrupo,lastactivity,Abanca,impremsg,hashtime)";
    $values = "($idUsuNext,1,'*','$pwd','$user','$IDC',1,'$user','$Acceso',3,0,'',0,'',0,0,0)";
    $result = mysqli_query($GLOBALS['link'], "Insert  _tusu  $fields values $values");

    return [$result, $idUsuNext];
}
function createIDCPortal($user, $email, $tel, $formatpay, $idb)
{
    // echo "IDB: $idb\n";
    // echo "Format: $formatpay\n";
    // $Level = $idb == 1 ? 0 : (($idb - 1) * 6);
    // echo "Level: $Level\n";
    // $IDGDefault = $formatpay + (($idb - 1) * $Level);
    if ($idb >= 1 && $idb <= 5) {
        $IDGDefault = $formatpay + 6 * ($idb - 1);
    } else {
        $IDGDefault = $formatpay;
    }
    // echo "IDGDefault: $IDGDefault\n";
    $result = mysqli_query($GLOBALS['link'], "Select IDRow from _tconsecionario  order by IDRow Desc limit 1 ");
    $row = mysqli_fetch_array($result);
    $idNext = $row['IDRow'] + 1;

    $IDC = "dealer$idNext-$IDGDefault";
    $idm = getIDM($formatpay);
    // (IDRow,Nombre,Telefono,Estatus,Direccion,Estado,Municipio,IDG,IDC,celular,email,responsable,tb,idm)
    $fields = "(IDRow,Nombre,Telefono,Estatus,Direccion,Estado,Municipio,IDG,Motivo,Fecha_Suspension,IDC,celular,email,Responsable,tb,idm)";
    $values = "($idNext,'$user','$tel',1,'*','*','*',$IDGDefault,'*','*','$IDC','$tel','$email','*',1,$idm)";

    $result = mysqli_query($GLOBALS['link'], "Insert  _tconsecionario  $fields values $values");

    return [$result, $IDC];
}
function createSettingPortal($IDC)
{

    $Participacion1 = 0;
    $IDB = 1;
    $pVentas = 0;
    $cmaxelim = 10;
    $Participacion2 = 0;
    $Participacion2 = 0;
    $mmjpd = 100;
    $mma = 100;
    $mmjpp = 100;
    $pVentaspd = 0;
    $mmdp = 50;
    $tipodev = 0;
    $porcentajextablad = 0;
    $cdpi = 0;
    $cjmp = 10;
    $Eminutos = 0;
    $pdrl = 100;
    $mxpjpd = 100;
    $maxpremio = 0;
    $idCnv = 0;
    $mma2 = 0;
    $ventaMin = 1;
    $cantBase = 2;

    $fields = "(IDC, Participacion1, IDB, pVentas, cmaxelim, Participacion2, mmjpd, mma, mmjpp, pVentaspd, mmdp, tipodev, porcentajextablad, cdpi, cjmp, Eminutos, pdrl, mxpjpd, maxpremio, idCnv, mma2, ventaMin,cantBase)";
    $values = "('$IDC', $Participacion1, $IDB, $pVentas, $cmaxelim, $Participacion2, $mmjpd, $mma, $mmjpp, $pVentaspd, $mmdp, $tipodev, $porcentajextablad, $cdpi, $cjmp, $Eminutos, $pdrl, $mxpjpd, $maxpremio, $idCnv, $mma2, $ventaMin,$cantBase)";

    $result = mysqli_query($GLOBALS['link'], "Insert  _tconsecionariodd  $fields values $values");

    return [$result];
}
function getIdTransaccion()
{
    mysqli_begin_transaction($GLOBALS['link']);
    $result2 = mysqli_query($GLOBALS['link'], "SELECT IDFacturas  FROM _conteo_facturas_tdc Where  id =1 FOR UPDATE");
    $result2 = mysqli_query($GLOBALS['link'], "UPDATE _conteo_facturas_tdc SET IDFacturas = LAST_INSERT_ID(IDFacturas + 1) Where id =1");
    $result2 = mysqli_query($GLOBALS['link'], "SELECT LAST_INSERT_ID() as IDFacturas;");
    $row2 = mysqli_fetch_array($result2);
    mysqli_commit($GLOBALS['link']);
    $tik = $row2["IDFacturas"];

    return $tik;
}
function Send2fa($IDusu)
{
    $uid = getCode2fa($IDusu);
    $Resp = SendMessageforCODE($uid);

    return $Resp;
}

function Very2fa($IDusu, $Tk)
{
    $uid = getCode2fa($IDusu);
    $resp =  VerifiToketSend($uid, $Tk);
    return $resp;
}

function getDataBono($IDC)
{
    $result = mysqli_query($GLOBALS['link'], "select * from _tbbono,_transac_portal_listbono where _tbbono.codebono = _transac_portal_listbono.codebono and _tbbono.IDC = '$IDC'");
    if (mysqli_num_rows($result) != 0) {
        $row = mysqli_fetch_array($result);
        return ["codebonotxt" => $row['codigo'], "monto" => $row['saldo']];
    }
    return ["codebonotxt" => "NA", "monto" => 0];
}