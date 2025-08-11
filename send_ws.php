<?
define("TITLE", "*westernbets.pro*");
define("MONEDA", "$");
function SendMgs($Phone, $Msg)
{
    $THISURL = "https://ws.saamqx.net:8000/sendmsg";
    $ToketMSG = "$2b$10$/jqIuHS3Rcsw38h51QrFyuyQVYSQk7kjfzw1q.i9SzLw3apREXf86";

    $firts_digi = $Phone[0];
    $endCode = $firts_digi == "0" ? 4 : 3;
    $tcode = substr($Phone, 0, $endCode);
    $code = substr($tcode, -3);
    $phonenumber = substr($Phone, -1 * (strlen($Phone) - $endCode));

    if (strlen($code) == 3 && strlen($phonenumber) > 6) { //6494013

        $data = json_encode(array("code" => $code, "phone" => $phonenumber, "mensaje" => $Msg));

        $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $THISURL);
        // curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        //     "cache-control: no-cache",
        //     "Content-Type: application/json",
        //     "Authorization: Bearer $ToketMSG",
        //     "x-forwarded-for: 1.1.1.1"
        // ));

        curl_setopt_array($ch, array(
            CURLOPT_URL => $THISURL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Authorization: Bearer $ToketMSG",
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

    return json_encode(["error" => true, "mensageStates" => "Numero móvil errado, verifique! ($Phone)"]);
}
function MensajeforTDCRecarga($NoApro, $User,  $Fecha, $Status, $Monto, $dataForBono)
{
    $Title = TITLE;
    $TxtStatus = $Status ? "Aprobado" : "Rechazado";
    $TxtUsuario = $Status ? "Usuario:$User" : "";
    // $TxtForBono = $dataForBono['codebonotxt'] == 'NA' ? '' : ("\n*Bono (" . $dataForBono['codebonotxt'] . ")* " . MONEDA . $dataForBono['monto']);
    $MONEDA = MONEDA;
    $msg = "$Title\nPago via *TDC*\nNo. Aprobacion:$NoApro\nFecha:$Fecha\n*Monto Recarga:$MONEDA$Monto*\n\n*Recarga $TxtStatus*\n$TxtUsuario";

    return $msg;
}
function MensajeforTDC($NoApro, $User, $Clave, $Fecha, $Status, $Monto, $dataForBono)
{
    $Title = TITLE;
    $TxtStatus = $Status ? "Aprobado" : "Rechazado";
    $TxtUsuario = $Status ? "Usuario:$User" : "";
    $ShadowP = ShadownPassword($Clave);
    $TxtClave = $Status ? "Clave:$ShadowP" : "";
    $TxtForBono = $dataForBono['codebonotxt'] == 'NA' ? '' : ("\n*Bono (" . $dataForBono['codebonotxt'] . ")* " . MONEDA . $dataForBono['monto']);
    $MONEDA = MONEDA;
    $msg = "$Title\nPago via *TDC*\nNo. Aprobacion:$NoApro\nFecha:$Fecha\n*Monto:$MONEDA$Monto*$TxtForBono\n\n*Acceso $TxtStatus*\n$TxtUsuario\n$TxtClave";

    return $msg;
}
function MensajeforOTHERPay($TypeTrans, $NoRef, $User, $Clave, $Fecha, $Status, $Monto, $StatusAPR, $dataForBono)
{
    $Title = TITLE;
    $TxtStatus = $Status ? "Aprobado" : "Rechazado";
    $TxtUsuario = $Status ? "Usuario:$User" : "";
    $ShadowP = ShadownPassword($Clave);
    $TxtClave = $Status ? "Clave:$ShadowP" : "";
    $ShowState = $StatusAPR != "" ? "\n*Estado:$StatusAPR*" : "";
    $TxtForBono = $dataForBono['codebonotxt'] == 'NA' ? '' : ("\n*Bono (" . $dataForBono['codebonotxt'] . ")* " . MONEDA . $dataForBono['monto']);
    $MONEDA = MONEDA;

    $msg = "$Title\nPago via *$TypeTrans*\n#Referencia:$NoRef\nFecha:$Fecha\n*Monto:$MONEDA$Monto*$TxtForBono$ShowState\n\n*Acceso $TxtStatus*\n$TxtUsuario\n$TxtClave";

    return $msg;
}
function MensajeForAccess($User, $Clave,  $Status)
{
    $Title = TITLE;

    $TxtStatus = $Status ? "Aprobado" : "Rechazado";
    $TxtUsuario = $Status ? "Usuario:$User" : "";
    $ShadowP = ShadownPassword($Clave);
    $TxtClave = $Status ? "Clave:$ShadowP" : "";

    $msg = "$Title\n*Acceso $TxtStatus*\n$TxtUsuario\n$TxtClave";
    return $msg;
}
function ShadownPassword($Clave)
{
    $ShadownPwd = [];
    for ($i = 0; $i < strlen($Clave); $i++) {
        if ($i < 3) {
            $ShadownPwd[] = $Clave[$i];
        } else {
            $ShadownPwd[] = "*";
        }
    }

    return implode("", $ShadownPwd);
}
