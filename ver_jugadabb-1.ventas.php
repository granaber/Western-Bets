<?
include_once('./prc_php.php');
require_once 'function_parameters_for_api.php';

$GLOBALS['link'] = Connection::getInstance();

$d1 = $fechaInitial ?? $_REQUEST['fecha'];

$rndusr = $_COOKIE['rndusr'];
$data = getParamUser($rndusr, $GLOBALS['link']);

$verdatos = '';
$Fecha = [];
$result = mysqli_query($GLOBALS['link'], "Select IDJ,Fecha From _jornadabb Where STR_TO_DATE(Fecha,'%d/%m/%Y') BETWEEN STR_TO_DATE('" . $d1 . "','%d/%m/%Y') and STR_TO_DATE('" . $d1 . "','%d/%m/%Y') Group by IDJ Order by IDJ");
if (mysqli_num_rows($result) != 0) :
    $i = 1;
    while ($row = mysqli_fetch_array($result)) {
        $verdatos .= ' IDJ=' . $row['IDJ'];
        $Fecha[$row['IDJ']] = $row['Fecha'];
        if ($i < mysqli_num_rows($result)) :
            $verdatos .= ' or ';
            $i++;
        endif;
    }
else :
    $verdatos = ' IDJ=0 ';
endif;
$ACTIVO = 'A';
$ANULADO = 'D';
$WINNER = 'W';
$LOSSER = 'L';

$ICONS = [$ACTIVO => 'normal.png', $ANULADO => 'anulado.png', $WINNER => 'winner.png', $LOSSER => 'losser.png'];



$listado = [];
$add1 = " (" . $verdatos . " ) ";
$sql = "Select * from _tjugadabb where $add1 and _tjugadabb.IDC='" . $data['IDC'] . "' order by serial DESC";

$result = mysqli_query($GLOBALS['link'], $sql);
if (mysqli_num_rows($result) != 0) :
    while ($row = mysqli_fetch_array($result)) {
        $status = $ACTIVO;

        if ($row['activo'] != 1) $status = $ANULADO;
        if ($row["escrute"] != '') :
            $arr = unserialize($row["escrute"]);
            $Escrute = vescruteBytree2($arr);
            if ($Escrute == $GANADOR) :
                $status = $WINNER;
            endif;
            if ($Escrute == $PERDEDOR) :
                $status = $LOSSER;
            endif;
        endif;

        $lh = explode(":", $row['hora']);
        $s = explode(" ", $lh[2]);
        $nh = $lh[0] . ":" . $lh[1] . $s[1];

        $listado[] = ["serial" => $row['serial'], "monto" => $data['moneda'] . $row['ap'], "cobra" => $data['moneda'] . $row['acobrar'], "hora" => $nh, "status" => $status];
    }
endif;
?>


<table class="table  table-responsive-sm table-hover table-striped">
    <thead class="bg-primary">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Serial</th>
            <th scope="col">Monto</th>
            <th scope="col">Paga</th>
            <th scope="col">Hora</th>

        </tr>
    </thead>
    <tbody>
        <? foreach ($listado as $clave => $valor) { ?>
            <tr onclick="verTicketDetall(<?= $valor['serial'] ?>)" class="point-cursor">
                <th scope="row">
                    <img id='img-state-<?= $valor['serial'] ?>' src="./media/<?= $ICONS[$valor['status']] ?>" alt="estatus"
                        class="icons-transacc">
                </th>
                <td><?= $valor['serial'] ?></td>
                <td><?= $valor['monto'] ?></td>
                <td><?= $valor['cobra'] ?></td>
                <td><?= $valor['hora'] ?></td>
            </tr>
        <? } ?>
    </tbody>
</table>

<div id='printer2'>
</div>
<div id='section2'>
</div>