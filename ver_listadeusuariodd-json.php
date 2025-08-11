<?
require('prc_php.php');
$link = Connection::getInstance();
$IDG = $_REQUEST['idg'];
$json_data = [];

$resultj = mysqli_query($link, "SELECT * FROM _tconsecionario where Estatus=1 and IDG=$IDG group by idc");

while ($Row = mysqli_fetch_array($resultj)) {

    $result_b = mysqli_query($link, "SELECT * FROM _tconsecionariodd where IDC='" . $Row['IDC'] . "'");

    $isactive = mysqli_num_rows($result_b) != 0;

    $json_data[] = array('idc' => $Row['IDC'], 'nom' => $Row['Nombre'], 'act' => $isactive);
}

echo json_encode($json_data);