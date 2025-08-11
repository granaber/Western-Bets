<?
$FlatPass = true;

include "prc_php.php";
$link = Connection::getInstance();

$content = trim(file_get_contents("php://input"));
$decoded = json_decode($content, true);

$usu = $decoded['idusu'];
$result = mysqli_query($link, "SELECT *,UNIX_TIMESTAMP(NOW()) as timesnap FROM _tusu where IDusu=" . trim($usu));
if (mysqli_num_rows($result) != 0) :
    $jor = "-";
    $eminutos = 0;

    $row = mysqli_fetch_array($result);
    $rnd = $row["bloqueado"];
    $idex = rand(1, 32560);

    //Array ( [0] => true [1] => dealer48-6 [2] => 1 [3] => * [4] => 28/9/2024 [5] => 0 [6] => 1169 [7] => 50 [8] => op21|op26|op28|op62|op63|op66|op67|op68|op72|op71|op44|op45|op73|op75|op77|op78|op79|op80|op81|op82|op84|op1011|op10201|mf3|op85|op1022|mf2|op2021|op86|mf1 [9] => [10] => |1169  [11] => 0 [12] => grana.nuevo [13] => 1727549880 )
    //Array ( [0] => true [1] => dealer48-6 [2] => 1 [3] => * [4] => 28/9/2024 [5] => - [6] => 1169 [7] => 50 [8] => op21|op26|op28|op62|op63|op66|op67|op68|op72|op71|op44|op45|op73|op75|op77|op78|op79|op80|op81|op82|op84|op1011|op10201|mf3|op85|op1022|mf2|op2021|op86|mf1 [9] => [10] => |22914 [11] => 0 [12] => grana.nuevo )
    $snap = base64_encode("true||" . $row["Asociado"] . "||" . $row["Estacion"] . "||" . $row["Descripcion"] . "||" . date("d/n/Y") . "||" . $jor . "||" . $rnd . "||" . $row["IDusu"] . "||" . $row["Acceso"] . "||" . $row["AccesoP"] . "||" . $row["bloqueado"] . "||" . $eminutos . "||" . $row['Usuario'] . "||" . $row['timesnap'] . "||" . $idex);
    mysqli_query($link, "DELETE from snapshot  where  idusu =  $usu");
    mysqli_query($link, "INSERT snapshot (idusu,snapshotd,deleted,idex) values ($usu,'$snap',0,$idex)");
endif;