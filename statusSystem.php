<?
(PHP_SAPI !== 'cli' || isset($_SERVER['HTTP_USER_AGENT'])) && die('console only');
date_default_timezone_set('America/Caracas');
$server = '159.65.224.175'; //localhost;
$user = "plinea_root"; //"root";
$clv = '8I#q}*7sGWC]'; //intra//
$db = "plinea_parlayenlinea"; //

$GLOBALS['link'] = mysqli_connect($server, $user, $clv);
mysqli_select_db($GLOBALS['link'], $db);

/// Parlays 
/// Json:   [
///           *** Registro de la fecha Anterior    
///           {
///             dateTransacci : xx/xx/xx,    
///             ultimoTicket  : 999999 - hh:mm:ss:pp
///             cantidadTicket: 99999999            
///           },
///            *** Registro Actual 
///           {
///             dateTransacci : xx/xx/xx,    
///             ultimoTicket  : 999999 - hh:mm:ss:pp
///             cantidadTicket: 99999999    
///             LigasCaptadasIkronos: 9999
///             LigasManual: 99999        
///             LigasCaptadaLogros: 9999
///             PartidosClose: 9999
///           }
///          ]
$formatoDate = "d/n/Y";
$tablaJugada = '_tjugadabb';
$fechaAnteriorEpoch  = strtotime("-1 day", strtotime("now"));
$fechaAnterior = date($formatoDate, $fechaAnteriorEpoch);
$fechaActual = date($formatoDate);
//  Datos dia anterior!
$LastTicket = 'N/A';
$LastIdc = 'N/A';
$cantidadTicket = 0;
$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where Fecha='$fechaAnterior'");
if (mysqli_num_rows($result) != 0) :
    $row = mysqli_fetch_array($result);
    $IDJant = $row['IDJ'];
    $result = mysqli_query($GLOBALS['link'], "SELECT * from $tablaJugada where idj=$IDJant order by serial DESC  limit 1");
    $row = mysqli_fetch_array($result);
    $LastTicket =  $row['serial'] . '-' . $row['hora'];
    $LastIdc = $row['IDC'];
    $result = mysqli_query($GLOBALS['link'], "SELECT count(Serial) as cuenta from  $tablaJugada where idj=$IDJant ");
    $row = mysqli_fetch_array($result);
    $cantidadTicket = $row['cuenta'];
endif;
$lastTransaccion = array(
    'dateTransacci' => $fechaAnterior,
    'ultimoTicket' => $LastTicket,
    'cantidadTicket' => $cantidadTicket,
    'LastIdc' => $LastIdc
);

$LastTicket = 'N/A';
$LastIdc = 'N/A';
$cantidadTicket = 0;
$LigasCaptadasIkronos = 0;
$auto = 0;
$manual = 0;
$PartidosClose = 0;
$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where Fecha='$fechaActual'");
if (mysqli_num_rows($result) != 0) :

    while ($row = mysqli_fetch_array($result)) {
        $IDJ = $row['IDJ'];
        if ($row['auto'] == 1) $auto++;
        else $manual++;
    }

    $result = mysqli_query($GLOBALS['link'], "SELECT  count(linea) as cuenta FROM _agendaNT where  idj=$IDJ ");
    $row = mysqli_fetch_array($result);
    $LigasCaptadasIkronos = $row['cuenta'];

    $result = mysqli_query($GLOBALS['link'], "SELECT * from $tablaJugada where idj=$IDJ order by serial DESC  limit 1");
    $row = mysqli_fetch_array($result);
    $LastTicket =  $row['serial'] . '-' . $row['hora'];
    $LastIdc = $row['IDC'];
    $result = mysqli_query($GLOBALS['link'], "SELECT count(Serial) as cuenta from  $tablaJugada where idj=$IDJ ");
    $row = mysqli_fetch_array($result);
    $cantidadTicket = $row['cuenta'];

    $result = mysqli_query($GLOBALS['link'], "SELECT  count(IDP) as cuenta from _cierrebb where IDJ=$IDJ  ");
    $row = mysqli_fetch_array($result);
    $PartidosClose = $row['cuenta'];
endif;
$nowTransaccion = array(
    'dateTransacci' => $fechaActual,
    'ultimoTicket' => $LastTicket,
    'cantidadTicket' => $cantidadTicket,
    'LastIdc' => $LastIdc,
    'LigasCaptadasIkronos' => $LigasCaptadasIkronos,
    'LigasManual' => $manual,
    'LigasCaptadaLogros' => ($LigasCaptadasIkronos - $auto),
    'PartidosClose' => $PartidosClose
);

echo    json_encode(array(
    'system' => 'Deportes',
    'lastTransaccion' => $lastTransaccion,
    'nowTransaccion' => $nowTransaccion
));
