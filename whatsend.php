<?php
// require('prc_skynet.php');
// $GLOBALS['link'] = Skynet::getInstance();
// $numero=$_REQUEST['phsnd'];
// $idc=$_REQUEST['idc'];


// //Asignamos variables
// if (is_numeric($numero)):
// 	$PhoneNumber = '58'.$numero;
// else:
// 	echo json_encode(array(0));
// 	exit;
// endif;
// $tk=$_REQUEST['tk'];
// $serial=$_REQUEST['serial'];
// // 2018-02-11 07:25:00
// $HR=date("Y-m-d H:i:s",time());
// //$newtk=str_replace("%%", "\n",$tk);
// $result = mysqli_query($GLOBALS['link'],"insert iwhatsapp (txt,telefono,idc,idclient,env,hr,he,serial)  values('".$tk."','".$PhoneNumber."','".$idc."',".$IDCLIENT.",0,'".$HR."','0000-00-00 00:00:00',".$serial.");" );
// echo "insert iwhatsapp (txt,telefono,idc,idclient,env,hr,he)  values('".$tk."','".$PhoneNumber."','".$idc."',".$IDCL.",0,'".$HR."','0000-00-00 00:00:00');";


// echo json_encode(false);
$numero = $_REQUEST['phsnd'];
if (is_numeric($numero)) :
    $PhoneNumber = '58' . $numero;
else :
    echo json_encode(array(0));
    exit;
endif;

$data = [
    'phone' => $PhoneNumber, // Receivers phone
    'body' =>  html_entity_decode(str_replace("%%", "\n", $_REQUEST['tk'])), // Message
];
$json = json_encode($data); // Encode data to JSON
// URL for request POST /message
$url = 'https://eu63.chat-api.com/instance72580/sendMessage?token=cr6cjtn6tbao9e07';
// Make a POST request
$options = stream_context_create([
    'http' => [
        'method'  => 'POST',
        'header'  => 'Content-type: application/json',
        'content' => $json
    ]
]);
// Send a request
$result = file_get_contents($url, false, $options);
if ($result['sent']) $rsp = false;
else  $rsp = true;
echo json_encode($rsp);
