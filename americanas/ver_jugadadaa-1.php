<?
include_once __DIR__ . '/../prc_php.php';
$moneda = '';
$idc = '';
if (!isset($data)) {
    $rndusr = $_COOKIE['rndusr'];

    include_once __DIR__ . '/../function_parameters_for_api.php';

    $linkDepor = Connection::getInstance();
    $data = getParamUser($rndusr, $linkDepor);
    $idc = $data['IDC'];
    $moneda = $data['moneda'];
} else {
    $idc = $data['IDC'];
    $moneda = $data['moneda'];
}
$linkAme = mysqli_connect($serverAME, $userAME, $clvAME);
mysqli_select_db($linkAme, $dbAME);

$d1 = $fechaInitial ?? $_REQUEST['fecha'];



$hipodromosArray = array();
$codeHipo = array(); //echo '***'.$tempoAper;
$Fecha = [];
$sql = "SELECT _tconfjornadahi.fecha,_tconfjornadahi.IDCN,_hipodromoshi.siglas,_hipodromoshi.Descripcion FROM _tconfjornadahi,_hipodromoshi where   _tconfjornadahi.IDhipo=_hipodromoshi._IDhipo and _hipodromoshi.estatus=1 and fecha='" . $d1 . "' order by idcn ";

$result = mysqli_query($linkAme, $sql);
if (mysqli_num_rows($result) != 0) :
    while ($row = mysqli_fetch_array($result)) {
        $hipodromosArray[$row["IDCN"]] = strtoupper($row["siglas"]);
        $codeHipo[] = $row["IDCN"];
    }
else:
    $codeHipo[] = 0;
endif;
$ACTIVO = 'A';
$ANULADO = 'D';
$WINNER = 'W';
$LOSSER = 'L';

$ICONS = [$ACTIVO => 'normal.png', $ANULADO => 'anulado.png', $WINNER => 'winner.png', $LOSSER => 'losser.png'];



$listado = [];
$sql = "select * from _tjugadahi where IDC='" . $idc . "' and IDCN in (" . join(",", $codeHipo) . ") order by Serial DESC";

$result = mysqli_query($linkAme, $sql);
if (mysqli_num_rows($result) != 0) :
    while ($row = mysqli_fetch_array($result)) {
        $status = $ACTIVO;
        $premiotk = 0;
        if ($row['Anulado'] != 0):
            $status = $ANULADO;
        else:
            $sqlEs = "SELECT * FROM _tbjugadaesc where serial=" . $row['Serial'];
            $resultEs = mysqli_query($linkAme, $sqlEs);

            if (mysqli_num_rows($resultEs) != 0) :
                $rowEs = mysqli_fetch_array($resultEs);
                $Escrute = unserialize($rowEs['opcion']);
                $premiotk = $Escrute[1];
                if ($premiotk != 0) {
                    $status = $WINNER;
                } else {
                    $status = $LOSSER;
                }
            else:
                $resultclose = mysqli_query($linkAme, "SELECT * FROM _cierrehi where  IDCN=" . $row['IDCN'] . " and IDJug=1 and ct=" . $row['carr']);
                if (mysqli_num_rows($resultclose) != 0) :
                    $status = $LOSSER;
                endif;

            endif;
        endif;

        $lh = explode(":", $row['Hora']);
        $s = explode(" ", $lh[2]);
        $nh = $lh[0] . ":" . $lh[1] . $s[1];

        $hip = $hipodromosArray[$row['IDCN']] . "/" . $row['carr'];

        $listado[] = ["serial" => $row['Serial'], "monto" => $moneda . $row['Valor_J'], "hipcarr" =>    $hip, "cobra" => $moneda .  $premiotk, "hora" => $nh, "status" => $status];
    }
endif;
?>


<table class="table  table-responsive-sm table-hover table-striped">
    <thead class="bg-secondary">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Serial</th>
            <th scope="col">Monto</th>
            <th scope="col">Hip/Carr</th>
            <th scope="col">Paga</th>
            <th scope="col">Hora</th>

        </tr>
    </thead>
    <tbody>
        <? foreach ($listado as $clave => $valor) { ?>
            <tr onclick="verTicketDetallAmericana(<?= $valor['serial'] ?>)" class="point-cursor">
                <th scope="row">
                    <img id='img-state-<?= $valor['serial'] ?>' src="./media/<?= $ICONS[$valor['status']] ?>" alt="estatus"
                        class="icons-transacc">
                </th>
                <td><?= $valor['serial'] ?></td>
                <td><?= $valor['monto'] ?></td>
                <td><?= $valor['hipcarr'] ?></td>
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