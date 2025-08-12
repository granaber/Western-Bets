<?
require_once 'set_stateenv.php';

$TYPE_VENTA = 1;
$TYPE_PREMIO = 2;
$TYPE_SALDO = 3;
$TYPE_REVERSO = 5;
$TYPE_PREMIO_REVERSO = 5;

$MSG_NO_AVALIBLE_CREDIT = 'No tiene credito DISPONIBLE';
$tokenAPICREDIT = 'eizah7pie3zeiboa0ies2go8doogiesohRea9jee';
// $API_REST = 'https://credito.betgambler.net:3145';

$API_REST = $mode == $PRODUCCION ?  'https://credito.betgambler.net:3145' : 'http://localhost:3145';
function BackendCredito($IDC, $Serial, $Monto, $Tipo, $sys = 0)
{
    global $MSG_NO_AVALIBLE_CREDIT, $API_REST;



    if (existeIDC($IDC)) :
        return ['err' => true, 'mensaje' => $MSG_NO_AVALIBLE_CREDIT];
    endif;


    global $TYPE_PREMIO;
    global $TYPE_VENTA;
    global $TYPE_SALDO;
    global $tokenAPICREDIT;
    global $API_REST;
    if ($Tipo == $TYPE_SALDO) :
        $API_SALDO = '/currentvalue';
        $URL = $API_REST . $API_SALDO . '/' . $IDC;
        $Response = endPoint($URL, 'GET', [], $tokenAPICREDIT);
    // if ($Tipo == $TYPE_VENTA || $Tipo == $TYPE_PREMIO || $Tipo == $TYPE_REVERSO):
    else :
        $API_VENTA = '/apply';
        $URL = $API_REST . $API_VENTA;
        $Data = [
            'idc' => $IDC,
            'monto' => $Monto,
            'serial' => $Serial,
            'tipo' => $Tipo,
            'sys' => $sys
        ];
        $Response = endPoint($URL, 'PUT', $Data, $tokenAPICREDIT);
    endif;

    $Error = $Response['err'];
    if (!$Error) {
        $Saldo = $Response['saldo'];
        $Moneda = $Response['moneda'] ?? "NA";
        return ['err' => false, 'saldo' => $Saldo, 'moneda' => $Moneda];
    }
    $Mensaje = $Response['msg'];
    return ['err' => true, 'mensaje' => $Mensaje];
}
function existeIDC($IDC)
{
    $IDCwithCredit = ListCredit();

    $key = array_search($IDC, $IDCwithCredit);

    return $key === false;
}
function ListCredit()
{
    global $tokenAPICREDIT;
    global $API_REST;
    $URL = $API_REST . '/list';
    $Data = [];
    $Response = endPoint($URL, 'GET', $Data, $tokenAPICREDIT);

    if (!isset($Response['err'])) return [];
    return $Response['data'] ?? [];
}
function ListTransacc($IDC)
{
    global $tokenAPICREDIT;
    global $API_REST;
    $URL = $API_REST . '/detalle/' . $IDC;
    $Data = [];
    $Response = endPoint($URL, 'GET', $Data, $tokenAPICREDIT);
    // print_r($Response);
    // if (isset($Response['err'])) return [];
    return $Response;
}
// function ListCredit()
// {
// 	global $token;
// 	global $API_REST;
// 	$URL = $API_REST . '/list';
// 	$Data = [];
// 	$Response = endPoint($URL, 'GET', $Data, $token);
// 	return $Response['data'] ?? [];
// }
function AssingCredit($IDC, $monto)
{
    global $tokenAPICREDIT;
    global $API_REST;
    $URL = $API_REST . "/activarcredito/$IDC/$monto/0";
    $Data = [];
    $Response = endPoint($URL, 'PUT', $Data, $tokenAPICREDIT);

    if (!isset($Response['error'])) return [];
    return $Response['data'] ?? [];
}
function AssingBono($IDC)
{
    // /applybono/:idc
    global $tokenAPICREDIT;
    global $API_REST;
    $URL = $API_REST . "/applybono/$IDC";
    $Data = [];
    $Response = endPoint($URL, 'PUT', $Data, $tokenAPICREDIT);

    if (!isset($Response['error'])) return [];
    return $Response['msg'] ?? [];
}
function ReverSerialWin($Serial, $Monto, $IDC)
{
    global $TYPE_PREMIO_REVERSO;
    global $MSG_NO_AVALIBLE_CREDIT;

    if (existeIDC($IDC)) :
        return ['err' => true, 'mensaje' => $MSG_NO_AVALIBLE_CREDIT];
    endif;

    $resul = BackendCredito($IDC, $Serial, $Monto, $TYPE_PREMIO_REVERSO);
    return $resul;
}
function endPoint($URL, $Method, $Data, $tokenAPICREDIT)
{
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => $URL,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $Method,
        CURLOPT_HTTPHEADER => [
            'cache-control: no-cache',
            'Content-Type: application/json',
            'Authorization: Bearer ' . $tokenAPICREDIT,
        ],
    ]);

    if ($Data) {
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($Data));
    }

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    $resp = json_decode($response, true);

    return $resp;
}
