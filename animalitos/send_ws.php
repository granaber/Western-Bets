<?

include_once "prc_phpDUK.php";
global $serverD;
global $userD;
global $clvD;
global $dbD;
$coneccion = mysqli_connect($serverD, $userD, $clvD, $dbD);

DEFINE("maxLinesMsg", 24);



function formatTicketforMesseger($nameApp, $linesForMsg, $serial, $IDC, $Nombre, $Fecha, $Hora)
{
    $encambezados = [];
    $encambezados[] = "             :: *$nameApp* ::";
    $encambezados[] = "*Cliente:* $IDC-$Nombre";
    $encambezados[] = "*Fecha-Hora:* $Fecha-$Hora";
    $encambezados[] = "*Serial:* $serial";
    $encambezados[] = "Tu Jugada es:";
    $encambezados[] = str_repeat("=", maxLinesMsg);
    $datatickets = join("\n", $encambezados) . "\n" . join("\n", $linesForMsg);

    return $datatickets;
}

function MakeTicketVirtualAnimalitos($serial, $IDC, $Hora, $Fecha, $se, $dataWS)
{
    // $dataWs[] = ["level" => 1, "title" => "Premio", "info1" => $myPremio];

    $linesForMsg = [];
    $newln = false;
    foreach ($dataWS as  $value) {

        $level = $value['level'];
        $title = $value['title'];
        $info1 = $value['info1'];
        $info2 = $value['info2'];


        switch ($level) {
            case 0:
                if ($newln) {
                    $linesForMsg[] = "";
                }
                $linesForMsg[] = "   *$info1*";
                $newln = true;
                break;
            case 1:
                $linesForMsg[] = "-- *$title  $info1* --";
                break;
            case 2:
                $linesForMsg[] = "$info1  #$info2#";
                break;
            case 3:
                $linesForMsg[] = str_repeat("=", maxLinesMsg);
                $linesForMsg[] = "*$title*  $info1";
                break;
        }
    }

    $linesForMsg[] = "Electronico : *$se*";
    $data = getPhoneSend($IDC);
    $messenger = formatTicketforMesseger("Animalitos", $linesForMsg, $serial, $IDC, $data['nombre'], $Fecha, $Hora);
    if ($data['celular'] == '0') {
        return ["err" => true, "errText" => 'No tengo numero movil, para enviar el ticket!'];
    }
    return sendMesseger($messenger, $data['celular']);
}

function getPhoneSend($IDC)
{
    global $coneccion;
    $q = mysqli_query($coneccion, "SELECT * FROM _tconsecionario where IDC='$IDC'");
    if (mysqli_num_rows($q) == 0) {
        return ["celular" => "0", "nombre" => ""];
    }
    $r = mysqli_fetch_array($q);
    return ["celular" => $r['celular'], "nombre" => $r['Nombre']];
}

function sendMesseger($messenger, $phone)
{
    $URL = "https://ws.saamqx.net:8000/sendmsg";
    $TOKET = "$2b$10$/jqIuHS3Rcsw38h51QrFyuyQVYSQk7kjfzw1q.i9SzLw3apREXf86";

    $nPhone = $phone[0] == '0' ? substr($phone, 1) : $phone;
    $code = substr($nPhone, 0, 3);

    $Data = [
        'code' => $code,
        'phone' => substr($nPhone, 3),
        'mensaje' => $messenger,
    ];


    $response = ifechtmsg($URL,  $Data, $TOKET);

    return array("err" => $response['error'], "errText" => $response["mensageStates"]);
}


function ifechtmsg($URL, $Data, $toket)
{
    $ch = curl_init();

    curl_setopt_array($ch, array(
        CURLOPT_URL => $URL,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => json_encode($Data),
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "Authorization: Bearer $toket",
            "x-forwarded-for: 1.1.1.1"
        ),
    ));

    $response = curl_exec($ch);
    $err = curl_error($ch);
    // $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    return $data;
}