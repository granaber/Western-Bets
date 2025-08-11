<?
cors();
header('Content-Type: application/json');
define("LOTERRY", "L");
define("SORTEO", "S");
define("SAVETICKET", "T");
define("LOGIN", "I");
define("MODEDARK", "M");
define("VERSION", "0.0.2");






$request = $_REQUEST["r"];

$TYPE_NORMAL = 0;

include "functions.php";
include "../typedef.php";
require_once "../base_credit.php";


switch ($request) {
    case MODEDARK:
        $idusu = $_REQUEST["idusu"];
        echo isModeDark($idusu);
        break;
    case LOGIN:
        $rand = $_REQUEST["rand"];
        $version = $_REQUEST['v'];
        if ($version != VERSION) {
            echo json_encode(["IDusu" => "-1", "IDC" => 'test', "Tipo" => "0", "Nombre" => 'TEST', 'phone' => "", 'moneda' => "\$"]);
            break;
        }
        $data = getDataLogon($rand);
        echo $data;
        break;
    case LOTERRY:
        $data = getLotterias(1);
        echo $data;
        break;
    case SORTEO:
        $idl = $_REQUEST["idl"];

        $data = getSorteo($idl, 1);
        echo $data;
        break;

    case SAVETICKET:
        $content = file_get_contents("php://input");
        $decoded = json_decode($content, true);

        $descoprimir = explode("*", $decoded['jugada']);

        // print_r($descoprimir);

        // $jugada = json_decode(json_encode($decoded["jugada"], true));

        // // $extras = json_encode($decoded['extras']);
        // // print_r($extras);
        //({String numero, int sorteo, double monto, int modo});
        //"0|${l.monto.toString()}|$sorteo|${l.numberA}"
        $jugada = [];
        foreach ($descoprimir  as $key => $value) {
            $d = explode("|", $value);
            $esp = intval($d[4]);
            $add = [];
            if ($d[4] != $TYPE_NORMAL) {
                $split = explode("#", $d[2]);
                $addmont = true;
                foreach ($split as $n) {
                    $add = ["numero" => $n];
                    $baseJugada = ["modo" => intval($d[3]), "monto" => $addmont ? floatval($d[0]) : 0, "sorteo" => intval($d[1]),  "esp" => $d[4]];
                    $jugada[] = array_merge($baseJugada, $add);
                    $addmont = false;
                }
            } else {
                $add = ["numero" => $d[2]];
                $baseJugada = ["modo" => intval($d[3]), "monto" => floatval($d[0]), "sorteo" => intval($d[1]),  "esp" => $d[4]];
                $jugada[] = array_merge($baseJugada, $add);
            }
            // print_r($d);
        }
        $idc = $decoded['idc'];

        if ($idc == 'test' || $idc == "" || $idc == "none") {

            $reslval["info"] = false;
            $reslval["ticket"] = '7';
            $reslval["dataR"] = 'NO ACTIVO - Debe registrarse o en caso de tener usuario, debe logarse con el!';
            $reslval["dataT"] = "";
            $reslval = array_merge($reslval, $creditDat);

            echo json_encode($reslval);
            break;
        }

        $ided = explode(".", $decoded['deb']);
        $ded = isset($ided[1]) ? $ided[1] : AMBOS;

        $usu = getIdUsusFromIDC($idc);



        $data = saveData($idc, json_decode(json_encode($jugada)), "0", $usu, $ded);
        echo $data;
        break;

    default:
        # code...
        break;
}



function cors()
{
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: *');
    header('Access-Control-Allow-Headers: *');
    header('Access-Control-Max-Age: 86400');
}
