<?
include_once('prc_phpDUK.php');
include_once __DIR__ . '/../function_parameters_for_api.php';

global $serverD;
global $userD;
global $clvD;
global $dbD;
$coneccion = mysqli_connect($serverD, $userD, $clvD, $dbD);
$rndusr = $_COOKIE['rndusr'];
$data = getParamUser($rndusr, $coneccion);

$link = ConnectionAnimalitos::getInstance();

if (isset($_REQUEST['fecha'])) :
    $IDJ = _FechaDUK($_REQUEST['fecha']);
    $dfecha = $_REQUEST['fecha'];
else :
    $IDJ = _FechaDUK();
    $dfecha = FecharealAnimalitos($minutosho, "d/n/Y");
endif;







$ACTIVO = 'A';
$ANULADO = 'D';
$WINNER = 'W';
$LOSSER = 'L';

$ICONS = [$ACTIVO => 'normal.png', $ANULADO => 'anulado.png', $WINNER => 'winner.png', $LOSSER => 'losser.png'];



$listado = [];

$add = " and IDC='" . $data['IDC'] . "'";
$sql = "Select * from _Jugada_ani where IDJ=" . $IDJ . $add . "   order by serial";
$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result) != 0) :
    while ($Row = mysqli_fetch_array($result)) {

        $op = 0;
        $Premio = 0;

        $resultj2n = mysqli_query($link, "Select * from _Jugada_ani_prem where serial=" . $Row['serial']);
        if (mysqli_num_rows($resultj2n) == 0 && $Row['down'] == 0) {
            $op = 1;
        } else {
            if (mysqli_num_rows($resultj2n) != 0) {
                $row2n = mysqli_fetch_array($resultj2n);
                $Premio = $row2n['premio'];
                $APremios = unserialize(decoBaseK($row2n['Jpremio']));
                $NumerodePremio = array();
                if ($APremios != '') :
                    $op = 2;
                    for ($i = 0; $i <= count($APremios) - 1; $i++) {
                        // echo $APremios[$i]['n'];
                        $resultj3n = @mysqli_query($link, "SELECT * FROM _Jornada  Where  ID=" . $APremios[$i]['l']);
                        $row3n = mysqli_fetch_array($resultj3n);
                        $nLis = _verAnimalito($APremios[$i]['n'], $row3n['IDL']);
                        $NumerodePremio[] = implode(',', $nLis);
                    }
                endif;
            }
            if ($Row['down'] == 1) {
                $op = 3;
            }
        }

        if ($Row['Activo'] != 1) {
            $op = 4;
        }



        switch ($op) {
            case 1:
                $status = $ACTIVO;
                break;
            case 2:
                $status = $WINNER;
                break;
            case 3:
                $status = $LOSSER;
                break;
            default:
                $status = $ANULADO;
                break;
        }



        $lh = convertirNormal($Row['hora']);
        $listado[] = ["serial" => $Row['serial'], "monto" => $data['moneda'] . $Row['monto'], "cobra" => $data['moneda'] . $Premio, "hora" => $lh, "status" => $status, "op" => $op];
    }
endif;
?>


<table class="table  table-responsive-sm table-hover table-striped">
    <thead class="bg-warning">
        <tr>
            <th scope="col" style="color:black">#</th>
            <th scope="col" style="color:black">Serial</th>
            <th scope="col" style="color:black">Monto</th>
            <th scope="col" style="color:black">Paga</th>
            <th scope="col" style="color:black">Hora</th>

        </tr>
    </thead>
    <tbody>
        <? foreach ($listado as $clave => $valor) { ?>
            <tr onclick="verTicketDetallAnimalito(<?= $valor['serial'] ?>,<?= $valor['op'] ?>,<?= $data['IDusu'] ?>)"
                class="point-cursor">
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