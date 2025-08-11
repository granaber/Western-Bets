<?
include_once '../prc_php.php';
include_once __DIR__ . '/../function_parameters_for_api.php';
$rndusr = $_COOKIE['rndusr'];
$serial = $_REQUEST['serial'];

$link = Connection::getInstance();
$data = getParamUser($rndusr, $link);

$linkAme = mysqli_connect($serverAME, $userAME, $clvAME);
mysqli_select_db($linkAme, $dbAME);





$result = mysqli_query($linkAme, "SELECT _tjugadahi.*,_tconsecionario.Direccion FROM _tjugadahi,_tconsecionario where _tjugadahi.IDC=_tconsecionario.IDC  and serial=" . $serial);
$prem = array(false, 0, 0, 0, 0);
$ticket = [];
if (mysqli_num_rows($result) != 0) :
    $row = mysqli_fetch_array($result);
    if ($row['IDJug'] == 0) :
        $premacion = EscrutarHI($row['Serial'], 1);
        // $prem[2] = 0;
        if (count($premacion) != 0) {
            if (floatval($premacion[1]) > 0) :
                $prem[0] = true; //8
                $prem[1] = $premacion[1]; //9
                $prem[2] = $premacion[0]; //10
                $prem[3] = $premacion[2]; //11
                $prem[4] = 0; //12
            else :
                $prem[0] = false; //8
                $prem[1] = 0; //9
                $prem[2] = 0; //10
                $prem[3] = 0; //11
                $prem[4] = -1; //12
            endif;
        }

    endif;

    $ticket[] = $row['Fecha']; //0
    $ticket[] = $row['Hora']; //1
    $ticket[] = $row['Jugada']; //2
    $ticket[] = $row['se']; //3
    $ticket[] = $row['Direccion']; //4

    $resulthiop = mysqli_query($linkAme, "SELECT _hipodromoshi.Descripcion FROM _hipodromoshi,_tconfjornadahi where _hipodromoshi._idhipo=_tconfjornadahi.IDhipo  and  IDCN=" . $row['IDCN']);
    $rowhip = mysqli_fetch_array($resulthiop);

    $ticket[] = $rowhip['Descripcion']; //5
    $ticket[] = $row['carr']; //6

    $ticket[] = iNameHorse($row['IDCN'], $row['carr'], $row['Jugada']); //7

    $ticket = array_merge($ticket, $prem);

    $ticket[] = $data['moneda']; //13
    $ticket[] = $row['Valor_J']; //14
    $ticket[] = $row['Valor_R']; //15


endif;

echo json_encode($ticket);


function iNameHorse($IDCN, $carr, $Jugada)
{
    global $linkAme;
    $cheHorse = array();
    $Ejem = explode('|', $Jugada);
    for ($e = 0; $e < count($Ejem) - 1; $e++) {
        $iHorse = explode('-', $Ejem[$e]); //100-0-0
        if (intval($iHorse[0]) != 0 || intval($iHorse[1]) != 0 || intval($iHorse[2]) != 0) :
            $result = mysqli_query($linkAme, " SELECT * FROM `_tablaejempleareshi`  where IDCN=$IDCN and Carr=$carr and Noeje=" . ($e + 1));
            //echo (" SELECT * FROM `_tablaejempleareshi`  where IDCN=$IDCN and Carr=$carr and Noeje=$e" );
            if (mysqli_num_rows($result) !== 0) :
                $row = mysqli_fetch_array($result);
                $cheHorse[] = $row['Nombre'];
            else :
                $cheHorse[] = '0';
            endif;
        else :
            $cheHorse[] = '0';
        endif;
    }
    return implode("|", $cheHorse);
}



function EscrutarHI($serial, $opcion, $escrut = true)
{
    global $linkAme;
    $result = mysqli_query($linkAme, 'Select * from _tjugadahi where Serial=' . $serial);
    if (mysqli_num_rows($result) != 0) :
        $row = mysqli_fetch_array($result);
        switch ($row['IDJug']) {
            case 0:

                $fecha = explode("/", $row['Fecha']);
                $fecha1 = "20" . $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
                $fechaticket = date_create($fecha1);
                $fechaNow = new DateTime("now");

                $fechaDif = date_diff($fechaticket, $fechaNow);

                $pass = $escrut ? $fechaDif->days > 1 : true;


                if ($pass) {
                    $result = mysqli_query($linkAme, 'Select * from _tbjugadaesc where serial=' . $serial);
                    if (mysqli_num_rows($result) != 0) :
                        $row = mysqli_fetch_array($result);
                        $es_opcion = $row['opcion'] != '' ? unserialize($row['opcion']) : [];
                        $es_escrute = $row['escrute'] != '' ? unserialize($row['escrute']) : [];

                        if ($opcion == 1) {
                            return ($es_opcion);
                        } else {
                            return ($es_escrute);
                        }
                    else :
                        $d = callEscrute($serial);
                        if (count($d) == 0) {
                            return [];
                        }
                        $es_opcion = $d[0];
                        $es_escrute = $d[1];
                    endif;
                } else {

                    $d = callEscrute($serial);
                    if (count($d) == 0) {
                        return [];
                    }
                    $es_opcion = $d[0];
                    $es_escrute = $d[1];
                }
                if ($opcion == 1) {
                    return ($es_opcion);
                } else {
                    return ($es_escrute);
                }
        }
    endif;
    return [];
}

function callEscrute($serial)
{
    global $mode, $PRODUCCION;


    $urlescrute = ($mode == $PRODUCCION) ? "http://10.136.240.56:9800" : "http://127.0.0.1:9801"; //
    $data = endPoint("$urlescrute/get/escrutarhi/BETGAMBLER/$serial", 'GET', [], "");
    if ($data['mode'] == "_NOHAYDIVIDENDO" || $data['mode'] == '_ANULADO') {
        return [];
    }
    $es_opcion = unserialize($data['opcion']);
    $es_escrute = unserialize($data['escrute']);

    return [$es_opcion, $es_escrute];
}


function endPoint($URL, $Method, $Data, $token)
{
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => $URL,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $Method,
        CURLOPT_HTTPHEADER => [
            'cache-control: no-cache',
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token,
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
