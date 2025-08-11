<?
$Serial = $_REQUEST['Serial'];
$IDCN = $_REQUEST['IDCN'];
$fecha = date("d/m/y");
$IDJugada = $_REQUEST['IDJugada'];
$Valor_R = 0;
$Valor_J = $_REQUEST['Valor_J'];
$terminal = $_REQUEST['terminal'];
$IDusu = $_REQUEST['IDusu'];
$jugada = $_REQUEST['jugada'];
$hora = date("h:i:s A");
$IDC = $_REQUEST['idc'];
$multi = 0;
$carr = $_REQUEST['carr'];
$org = $_REQUEST['org'];
$nom = '';

$se = rand(1, $Serial) . '' . rand() . '' . rand(1, $terminal) . '' . $Serial . '' . rand(1, $IDCN) . '' . $IDCN;

$result = mysqli_query($GLOBALS['link'], "INSERT INTO _tjugada  (Serial,IDCN,Fecha,Hora,Jugada,IDJug,Valor_R,Valor_J,Terminal,IDusu,Anulado,IDC,carr,carr1,nom,org,se) VALUES (" . $Serial . "," . $IDCN . ",'" . $fecha . "','" . $hora . "','" . $jugada . "'," . $IDJugada . "," . $Valor_R . "," . $Valor_J . "," . $terminal . "," . $IDusu . ",0,'" . $IDC . "'," . $carr . ",0,'" . $nom . "'," . $org . ",'" . $se . "')");
if ($result == false) {

    $result2 = mysqli_query($GLOBALS['link'], "INSERT INTO _tjugada2  (Serial,IDCN,Fecha,Hora,Jugada,IDJug,Valor_R,Valor_J,Terminal,IDusu,Anulado,IDC,carr,carr1,nom,org,se) VALUES (" . $Serial . "," . $IDCN . ",'" . $fecha . "','" . $hora . "','" . $jugada . "'," . $IDJugada . "," . $Valor_R . "," . $Valor_J . "," . $terminal . "," . $IDusu . ",0,'" . $IDC . "'," . $carr . ",0,'" . $nom . "'," . $org . ",'" . $se . "')");
}
$k_jug = explode("|", $jugada);
$valor_de_ins = $result;
