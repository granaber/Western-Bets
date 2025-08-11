<?

define('HOST_PRODUCTION_MAIN_1', 'https://westernbets.pro');
define('HOST_DEVELOMENT_MAIN_1', 'http://localhost:5200');


$FlatPass = true;
include "prc_php.php";
$link = Connection::getInstance();
$idusu = $_REQUEST['idusu'];

$host = HOST_PRODUCTION_MAIN_1; //: HOST_DEVELOMENT_MAIN_1;

$result = mysqli_query($link, "SELECT * FROM snapshot where idusu=" . trim($idusu) . " and deleted=0");
// echo "SELECT * FROM snapshot where idusu=" . trim($idusu) . " and deleted=0";
if (mysqli_num_rows($result) != 0) :
    $row = mysqli_fetch_array($result);

    // echo 'paso';
    // $code = [
    //     "true",
    //     "dealer48-6",
    //     1,
    //     "*",
    //     "27/9/2024",
    //     "-",
    //     29865,
    //     50,
    //     "op21|op26|op28|op62|op63|op66|op67|op68|op72|op71|op44|op45|op73|op75|op77|op78|op79|op80|op81|op82|op84|op1011|op10201|mf3|op85|op1022|mf2|op2021|op86|mf1",
    //     "",
    //     "|3587",
    //     "0",
    //     "grana.nuevo",
    //     "redirect"
    // ];

    // $_REQUEST['code'] =   $row['snapshotd']; // base64_encode(implode("||", $code));
    // header("Location: http://portal.westernbets.pro/portal?port=4&data=" . $d['data']);
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: $host/intro.min.ventas.php?code=" . $row['snapshotd']);
    exit;
else:
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: $host/intro.min.ventas.php");
endif;
