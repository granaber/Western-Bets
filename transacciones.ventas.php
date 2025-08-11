<?
include_once('./prc_php.php');
include_once('./prc_credit.php');
require_once 'function_parameters_for_api.php';


$GLOBALS['link'] = Connection::getInstance();
$rndusr = $_COOKIE['rndusr'];
$data = getParamUser($rndusr, $GLOBALS['link']);
$dark = isModeDart($data['IDusu']);

$data = ListTransacc($data['IDC']);
// print_r($data);
$listado = $data['data'] ?? [];
$ACREDIT = 1;
$REVERSE = 2;
$DEACREDIT = 3;
$PROCESSETIQ = ['Saldo' => $ACREDIT, 'Venta' => $DEACREDIT, 'Premio' => $ACREDIT, 'Retiro' => $DEACREDIT, 'Reverso' => $REVERSE];
$ICONS = [$ACREDIT => 'plus.png', $REVERSE => 'reverse.png', $DEACREDIT => 'less.png'];
?>
<h4 class="<?= $dark ? 'text-white' : 'text-dark' ?> mb-3 text-center">Transacciones</h4>

<table class="table  table-responsive-sm table-hover table-striped">
    <thead class="bg-primary">
        <th scope="col">#</th>
        <th scope="col">Fecha</th>
        <th scope="col">Proceso</th>
        <th scope="col">Monto</th>
        <th scope="col">Saldo</th>
    </thead>
    <tbody>
        <? foreach ($listado as $clave => $valor) {

            $thisProceso = $valor['Proceso'];
            $IconsEvent = $ACREDIT;
            foreach ($PROCESSETIQ as $idx => $v) {
                if (str_contains($thisProceso, $idx)) {
                    $IconsEvent = $v;
                    break;
                }
            }
            //sáb 05/ago. 23 - 08:31 p. m.
            $f = str_replace('&nbsp;', ' ', $valor['Fecha']);
            $it = explode(" ", str_replace(".", "", $f));
            $am = explode("m", $it[5]);
            $hresponsive = $it[1] . " " . $it[4] . $am[0];
        ?>
            <tr class="point-cursor">
                <th scope="row">
                    <img src="./media/<?= $ICONS[$IconsEvent] ?>" alt="suma" class="icons-transacc">
                </th>
                <td><samp class="d-none d-sm-block"> <?= $valor['Fecha'] ?></samp>
                    <samp class="d-lg-none d-xl-block"><?= $hresponsive ?></samp>
                </td>
                <td><?= $valor['Proceso'] ?></td>
                <td><?= $valor['Monto'] ?></td>
                <td><?= $valor['Saldo'] ?></td>
            </tr>
        <? } ?>
    </tbody>
</table>