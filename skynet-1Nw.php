<?php


/// Call Api colletion ///

$curl = curl_init();
// $MODULO = "ikronos";
// $THISURL ="https://saamqx.net:2124/status/parlayenlinea";
// curl_setopt_array($curl, array(
//   CURLOPT_URL => $THISURL,
//   CURLOPT_RETURNTRANSFER => true,
//   CURLOPT_TIMEOUT => 30,
//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//   CURLOPT_CUSTOMREQUEST => "GET",
//   CURLOPT_HTTPHEADER => array(
//     "cache-control: no-cache"
//   ),
// ));

// $response = curl_exec($curl);
// $err = curl_error($curl);
// curl_close($curl);
// $data = json_decode($response, true); 
// if ($data["status"]):
//   if ($data["suspend"]):
//     $versuspend=explode(",",$data["tosuspend"]);
//     for ($i=0;$i<count($versuspend);$i++){
//         if ($versuspend[$i]==$MODULO):
//             // include("./suspend/index.html");exit();
//             echo "<script>";
//             echo "window.location.replace('https://parlayenlinea.tk/suspend/index.html');";
//             echo "</script>";
//             exit();
//         endif;
//     }
//   endif;
// endif;

/////////////////////////

ini_set('display_errors', 'On');
ini_set('log_errors', 'On');
ini_set('error_log', 'error.log');
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once('prc_skynet.php');
require_once('graphql.php');
$endpointf = "http://parleybets.com:8910/serviceV2";
$query3 = <<<'GRAPHQL'
    query casinosLegue($lid:Int!){
            casinosLegue(lid:$lid){
            tp
            texto
        }
    }
GRAPHQL;

$spid = array(["spid" => 2, "texto" => "Soccer"], ["spid" => 3, "texto" => "Baseball"], ["spid" => 4, "texto" => "Football Americano"], ["spid" => 5, "texto" => "Basketball"], ["spid" => 6, "texto" => "Hockey"], ["spid" => 8, "texto" => "Tennis"], ["spid" => 9, "texto" => "Boxing"], ["spid" => 21, "texto" => "World Cup"]);
$meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
$skynet = mysqli_connect($server1, $user1, $clv1);
mysqli_select_db($skynet, $db1);
$fechaSR = date('Ymd');
$resultSK1 = mysqli_query($skynet, "SELECT * FROM _tbjornadaNT where fecha='$fechaSR'");
if (mysqli_num_rows($resultSK1) == 0) :
    $nidj = -1;
else :
    $row = mysqli_fetch_array($resultSK1);
    $nidj = $row['idj'];
    $sql = "Select _tbligasNTnw.idep,_tbligasNTnw.nombre,_tbJornadaNTnw.count,_tbligasNTnw.lid,_tbligasNTnw.spid,_TLigasNTnw.rid,_TLigasNTnw.ridnam from _tbligasNTnw,_tbJornadaNTnw,_TLigasNTnw where _TLigasNTnw.lid=_tbligasNTnw.lid and _tbligasNTnw.idj= _tbJornadaNTnw.idj and _tbligasNTnw.lid= _tbJornadaNTnw.lid  and  _tbJornadaNTnw.idj=$nidj order by _TLigasNTnw.ridnam, _TLigasNTnw.rid  ASC, _tbligasNTnw.spid DESC,_tbligasNTnw.nombre ASC;";
    $resultSK1 = mysqli_query($skynet, $sql);
endif;

?>
<!-- <div class="container">
<div class="alert alert-danger" role="alert">
<div class="row">
    <div class="col">
        <label  class="h1">
                SUSPENDED FOR SALE
        </label>
    </div>
    <div class="col">
    <a type="button" class="btn btn-danger" href="https://www.sportsbookreview.com/">Pay Now</a>
    </div>

</div>

</div>
</div>
<? // exit; 
?> --->
<div class="container">
    <div class="card text-white bg-dark mb-3">
        <div class="card-header">
            <h2> iKronos </h2>
        </div>
        <div class="card-body">
            <div class="row">

                <div class="col-sm">

                    <? if ($nidj == -1) : ?>
                        <div class="alert  alert-danger" role="alert">
                            <h4 class="alert-heading">No tenemos Configuracion</h4>
                            <p>Lamentablemente hasta ahora no tenemos la Configuracion de esta Jornada disponible.</p>
                            <p class="mb-0">Puede intentar mas tarde, Por favor!</p>
                        </div>
                    <? else : ?>
                        <div class="list-group">
                            <button type="button" class="list-group-item bg-primary  active  " onclick="onclick_sport('0',false)">
                                Deportes para hoy
                                <? echo $meses_ES[date("n") - 1] . date(" j, Y"); ?>
                            </button>
                            <?
                            $nivel = 0;
                            $rid = 0;
                            $lis_id = array();
                            $includeDiv = false;
                            while ($row2 = mysqli_fetch_array($resultSK1)) {
                                if ($rid != $row2['rid'])
                                    if ($rid !== 0)
                                        echo "</div>";

                                if ($nivel != $row2['spid']) {
                                    $nivel = $row2['spid'];
                                    $found_key = array_search($nivel, array_column($spid, "spid"));


                            ?>
                                    <button type="button" onclick="onclick_sport(<? echo $nivel; ?>,true)" class=" btn-warning" style="font-size:14px; height: 25px;padding-top: 3;">
                                        <? echo $spid[$found_key]['texto']; ?>
                                    </button>
                                <?
                                }
                                if ($rid != $row2['rid']) {
                                    $rid = $row2['rid'];
                                    $includeDiv = true;
                                ?>
                                    <button type="button" class="btn-secondary" data-toggle="collapse" data-target="#<? echo 'colap' . $rid; ?>" aria-expanded="true" aria-controls="<? echo 'colap' . $rid; ?>" style="height: 20px;padding-top: 3;">
                                        <? echo $row2['ridnam']; ?>
                                    </button>
                                    <div id="<? echo 'colap' . $rid; ?>">
                                    <?

                                }
                                // spind - idep
                                $lis_id[] = $nivel . '-' . $row2['idep'];

                                $rgraql = graphqlQueryLB($endpointf, $query3, ['lid' => intval($row2['lid'])]);
                                $textToolTip = array();
                                $data = $rgraql->data->casinosLegue;
                                foreach ($data as $regis) {
                                    $row1 = json_decode(json_encode($regis), True);
                                    $textToolTip[] = '*' . $row1['texto'];
                                }
                                if (count($textToolTip) == 0)  $textToolTip[] = 'Ningun casinos tiene logros';
                                    ?>
                                    <button type="button" data-toggle="tooltip" data-placement="right" data-html="true" title="<? echo join(' ', $textToolTip) ?>" class="list-group-item list-group-item-action" onclick="onclick_sport('<? echo $nivel . '-' . $row2['idep']; ?>',false)">
                                        <input type="checkbox" class="form-check-input" id="ckec<? echo $nivel . '-' . $row2['idep']; ?>">
                                        <span class="badge badge-primary badge-pill">
                                            <? echo $row2['count']; ?>
                                        </span>
                                        <? echo $row2['nombre']; ?>
                                    </button>
                            <?

                            }
                            echo "</div>";
                        endif;
                        if ($includeDiv) {
                            echo "</div>";
                        }
                            ?>
                                    </div>
                                    <div class="col-sm">
                                        <? if ($nidj != -1) : ?>
                                            <div class="list-group ">
                                                <button type="button" class="list-group-item text-white bg-warning" onclick="javascript:onclick_casino(0)">
                                                    Casinos validados
                                                </button>
                                                <?
                                                $lis_cs = array();
                                                $resultSK1 = mysqli_query($skynet, "Select * from _tbcasinoNTnw where enabled=1  order by  name ");
                                                while ($row2 = mysqli_fetch_array($resultSK1)) {
                                                    $lis_cs[] = $row2['paid'];
                                                ?>
                                                    <button type="button" class="list-group-item list-group-item-action" onclick="onclick_casino(<? echo $row2['paid']; ?>)">
                                                        <input type="checkbox" class="form-check-input" id="casino-<? echo $row2['paid']; ?>">
                                                        <? echo $row2['name'] ?>
                                                    </button>

                                                <?  } ?>
                                            </div>
                                        <? endif; ?>
                                    </div>
                                    <div class="col-sm">
                                        <? if ($nidj != -1) : ?>
                                            <div class="card border-success mb-3" style="max-width: 18rem;">
                                                <div class="card-header text-white bg-primary mb-3">Monitor de Procesos</div>
                                                <div class="card-body text-success">
                                                    <h5 class="card-title"> <button type="button" class="btn btn-primary" style="width: 220px;height: 40px;" onclick="captarOdds(<? echo $nidj; ?>)">Inicar Captura</button> </h5>
                                                </div>
                                                <hr>
                                                <div id="coc" class="card-body  text-dark  bg-light mb-3" style="height: 290px; overflow:scroll;">

                                                </div>
                                            </div>
                                        <? endif; ?>
                                    </div>
                        </div>
                </div>
                <div class="card-body">
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Informacion!</h4>
                        <p>Debe marca por lo menos algun deporte(s) antes de comenzar la captura, por defecto los
                            casinos
                            estan seleccionado todos, es decir a pesar que las casillas no estan marcadas, el sistema
                            toma
                            todos los casino para buscar sus logros!</p>
                        <hr>
                        <p class="mb-0">La Captura de todos los CASINOS, permitira a <strong>iKronos</strong> hacer un
                            MODA
                            (es decir el que mas se repite entre los casinos),entre ellos para optar con un logro
                            definitivo
                            para la venta!</p>
                        <p class="mb-1">Esta informacion <span class="badge badge-primary badge-pill">99</span> indica
                            que
                            cantidad de partidos tiene ese deporte!</p>
                    </div>
                </div>
            </div>
        </div>
        <script>
            var lista = '<? echo join(",", $lis_id); ?>';
            lista_id = lista.split(',');
            var listacs = '<? echo join(",", $lis_cs); ?>';
            listacs_id = listacs.split(',');
        </script>