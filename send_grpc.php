<?php
require_once 'set_stateenv.php';
require_once dirname(__FILE__) . '/vendor/autoload.php';
$codeClient = "BETGAMBLER";
$hostname =   ($mode == $PRODUCCION) ? '10.136.242.179:50051' : 'localhost:50051';
$client = new Corerq\SayClient(
    $hostname,
    [
        'credentials' => Grpc\ChannelCredentials::createInsecure(),
    ]
);
function escrute_SERIAL($serial)
{
    global $codeClient, $client;
    $request = new Corerq\ParambySerial();
    $request->setThisSerial($serial);
    $request->setCodeclient($codeClient);
    list($reply, $status) = $client->scrutingSerial($request)->wait();
    $state = $reply->getState();
    $Resolve = $reply->getResolve();
    $Pay = $reply->getPay();
    return  array("State" => $state, "Respuesta" => $Resolve, "valorini" => $Pay);
}
function escrute_ALL($date)
{
    global $codeClient, $client;

    // Call all scrutting 
    $rqAll = new Corerq\ParamScruttinAll;
    $rqAll->setFecha($date);
    $rqAll->setCodeclient($codeClient);
    list($reply, $status) = $client->scrutingAll($rqAll)->wait();
    $state = $reply->getState();
    return $state;
}