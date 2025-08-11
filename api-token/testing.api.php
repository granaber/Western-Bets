<?

ini_set('display_errors', 'On');
ini_set('log_errors', 'On');
ini_set('error_log', 'error.log');
error_reporting(E_ERROR | E_WARNING | E_PARSE);

session_start();
date_default_timezone_set("America/Caracas");
require_once "../prc_php.php";


$GLOBALS['link'] = Connection::getInstance();

$rndusr = $_COOKIE['rndusr'];
$resultij = mysqli_query($GLOBALS['link'], "select * from _tusu where  bloqueado=$rndusr");
if (mysqli_num_rows($resultij) != 0) {
    $rowij = mysqli_fetch_array($resultij);
    $IDusu = $rowij['IDusu'];
    $hashtime = timeStamp();
    $resultij = mysqli_query($GLOBALS['link'], "select * from tokents where  idusu=$IDusu");
    if (mysqli_num_rows($resultij) == 0)
        echo json_response(404, 'No existe el Cookie Auth');
    else {
        $rowij = mysqli_fetch_array($resultij);
        $hashtime = timeStamp() - intval($rowij['timelast']);
        echo json_encode(array('date' => gmdate('r', $rowij['timelast']), 'diff' => $hashtime));
        $sql = "Update tokents set timelast='0'  where  idusu=$IDusu";
        $resultij = mysqli_query($GLOBALS['link'], $sql);
    }
} else
    echo json_response(406, 'No existe el Cookie Auth');
