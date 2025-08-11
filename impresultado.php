<style type="text/css">
    .shadowcontainerx {
        width: 310px;
        /* container width*/
        background-color: #d1cfd0;
    }

    .shadowcontainerx .innerdivx {
        /* Add container height here if desired */
        background-color: white;
        border: 1px solid gray;
        padding: 6px;
        position: relative;
        left: -5px;
        /*shadow depth*/
        top: -5px;
        /*shadow depth*/
    }

    .Estilo2 {
        color: #FFFFFF
    }
</style>
<?php
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$fc = $_REQUEST["fc"];
$idj = 0;
$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where Fecha='" . $fc . "'");
if (mysqli_num_rows($resultj) != 0) :
    $rowj = mysqli_fetch_array($resultj);
    $idj = $rowj["IDJ"];
    $cant = $rowj["Partidos"];
endif;

?>

<div class="container mt-3">
    <div class="card text-white bg-dark m-3 shadow-lg" style="max-width: 25rem;">
        <div class="card-header mx-auto">
            <h2 class="mx-auto" style="font-size:16px"> Imprimir Resultado </h2>
        </div>

        <div>

            <div class="row">
                <div class="col ml-2">
                    <label>Indique la Fecha</label>
                </div>
                <div class="col">
                    <input class="input-pv-standard" name="fc" type="text" id="fc" lang="<?php echo $idj; ?>" onfocus="cargarcampos6();" size="10" value="<?php echo $fc; ?>" />
                </div>
            </div>
            <div class="row">
                <div class="col ml-2">
                    <label>Seleccione el Grupo</label>
                </div>
                <div class="col">
                    <div id="fromResultadosDeportes">
                        <?php

                        echo "<span style='color:#000000; background:#FFFFFF; font-size:11px'><input id='chk0' type='checkbox' value='0' onclick='marcat(0)'/>TODOS</span><br />";

                        $resultj = mysqli_query($GLOBALS['link'], "SELECT _gruposdd.* FROM _gruposdd,_jornadabb where _gruposdd.grupo=_jornadabb.grupo and _jornadabb.IDJ=$idj  Order by grupo ");
                        $y = 1;
                        while ($row = mysqli_fetch_array($resultj)) {
                            echo "<input id='chk0" . $y . "' type='checkbox' lang=" . $row["Grupo"] . " /><span class='text-warning' style='font-size:11px'>" . $row["Descripcion"] . '</span><br />';
                            $y++;
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col ml-2">
                    <label>Salida por</label>
                </div>
                <div class="col">
                    <select class="select-pv-standard" id="salida">
                        <option value="1">Impresora</option>
                        <option value="2">Tickera</option>
                    </select>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col ml-2">
                    <button id='btncargar' type="button" class="btn btn-primary" onclick="imprimirresultado();">
                        Imprimir
                    </button>
                    <input id="cant_p" type="text" style="display:none" />
                </div>
            </div>

        </div>
    </div>
</div>
<samp id="totalg" lang="<? echo $y; ?>"></samp>
<div id='coc'></div>