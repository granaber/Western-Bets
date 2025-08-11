<div class="accordion" id="accordionExample">

    <?
    include_once __DIR__ . '/../prc_php.php';
    $PosiDividendo = [0, 9, 10, 11];

    $linkAme = mysqli_connect($serverAME, $userAME, $clvAME);
    mysqli_select_db($linkAme, $dbAME);
    $fechaInitial = date('d/n/Y');

    $d1 = isset($_REQUEST['fecha']) ? $_REQUEST['fecha'] : $fechaInitial;


    $datos = getGamesActive();
    $games = $datos[0];
    $sticker = $datos[1];

    $sql = "SELECT _tconfjornadahi.fecha,_tconfjornadahi.IDCN,_hipodromoshi.siglas,_hipodromoshi.Descripcion FROM _tconfjornadahi,_hipodromoshi where   _tconfjornadahi.IDhipo=_hipodromoshi._IDhipo and fecha='" . $d1 . "' order by idcn ";
    $result = mysqli_query($linkAme, $sql);
    if (mysqli_num_rows($result) != 0) :
        while ($row = mysqli_fetch_array($result)) {
            $IDCN = $row['IDCN'];
            $descrip = $row['Descripcion'];
    ?>
            <div class="card text-white bg-dark">
                <div class="card-header" id="track-<?= $IDCN ?>">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                            data-target="#collapse-<?= $IDCN ?>" aria-expanded="true" aria-controls="collapse-<?= $IDCN ?>">
                            <?= $row['Descripcion'] . "(" . strtoupper($row["siglas"]) . ")" ?>
                        </button>
                    </h2>
                </div>

                <div id="collapse-<?= $IDCN ?>" class="collapse " aria-labelledby="track-<?= $IDCN ?>"
                    data-parent="#accordionExample">
                    <div class="card-body" style="overflow: auto;">
                        <?
                        include "reportedeconformes-1.php";
                        ?>
                    </div>
                </div>
            </div>




    <?   }

    endif;
    ?>

</div>


<?

function getGamesActive()
{
    global $linkAme;

    $sticker = ['', 'success', 'warning', 'info', 'dark', 'secondary', 'danger', 'warning', 'success'];
    $games = array();
    $calculo = array();
    $resultij = mysqli_query($linkAme, "select * from _tdjuegoshi where  1");
    while ($rowij = mysqli_fetch_array($resultij)) {
        $games[$rowij['IDJug']] = $rowij['Descrip'];
        $calculo[$rowij['IDJug']] = $rowij['calculo'];
    }

    return [$games, $sticker, $calculo];
}
?>