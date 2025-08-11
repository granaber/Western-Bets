<style type="text/css">
    .Estilo2d1 {
        color: #000000
    }

    .Estilo3d1 {
        color: #FFFF66;
        font-size: 10px;
    }

    .Estilo5d1 {
        color: #FFFFFF;
        font-size: 10px;
    }

    .Estilo4d1 {
        color: #FFFFFF;
        font-size: 14px
    }
</style>





<div id="box6" style="width:500px; background:#333">
    <?php

    require('prc_php.php');
    $GLOBALS['link'] = Connection::getInstance();

    $idt = $_REQUEST['idt'];
    $accesogp = accesolimitado($idt);

    ?>

    <table border="0" cellspacing="0" style="line-height: 22px;">
        <tr>
            <th></th>
            <th colspan="4">
                <div align="center" class="Estilo4d1">Reporte de Ventas y Ganacias Resumido por Fecha</div>
                <div align="right"></div>
            </th>
        </tr>
        <tr>
            <th></th>
            <th>&nbsp;</th>
            <th colspan="2">&nbsp;</th>
            <th>
                <div align="right"></div>
            </th>
        </tr>

        <tr>
            <th></th>
            <th class="Estilo3d1">
                <div align="right">Desde:</div>
            </th>
            <th width="144"><input class="input-pv-standard" name="fc" type="text" id="fc1" size="10" value="<?php echo date("d/n/Y"); ?>" /></th>
            <th width="137">
                <div align="right" class="Estilo3d1">Hasta:</div>
            </th>
            <th><input class="input-pv-standard" name="fc" type="text" id="fc2" size="10" value="<?php echo date("d/n/Y"); ?>" /></th>
        </tr>

        <tr>
            <th></th>
            <th>
                <div align="right" class="Estilo3d1">Clasificar Por:</div>
            </th>
            <th colspan="3">
                <form id="form2" name="form2" method="post" action="">
                    <label>
                        <input name="radio" type="radio" id="uno" onclick="$('tu').style.display='';$('tdc').style.display=''; $('td').style.display='none';$('tdg').style.display='none';$('tt').style.display='none';$('tdb').style.display='none';" value="radio" checked="checked" />
                    </label>
                    <span class="Estilo5d1">Concesionario</span>
                    <label>
                        <input type="radio" name="radio" id="dos" value="radio" onclick="$('tu').style.display='none';$('tdc').style.display='none'; $('td').style.display='';$('tdg').style.display='';$('tt').style.display='none';$('tdb').style.display='none';" />
                    </label>
                    <span class="Estilo5d1">Grupo</span>
                    <label>
                        <input type="radio" name="radio" id="tres" value="radio" onclick="$('tu').style.display='none';$('tdc').style.display='none'; $('td').style.display='none';$('tdg').style.display='none';$('tt').style.display='';$('tdb').style.display='';" />
                    </label>
                    <span class="Estilo5d1">Banca</span>
                </form>
            </th>
        </tr>
        <tr>
            <th></th>
            <th class="Estilo3d1">
                <div id="tu" align="right">Concesionario:</div>
                <div id="td" align="right" style="display:none">Grupo</div>
                <div id="tt" align="right" style="display:none">Banca</div>
            </th>
            <th colspan="2">
                <span id="spryselect1">
                    <label>
                        <div id="tdc" align="left">
                            <select id="Concesionario">
                                <option value="0">Todos</option>
                                <?php
                                if ($accesogp == 0) :
                                    $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionario order by IDC");
                                else :
                                    $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionario where IDG in (" . $accesogp . ") order by IDC");
                                endif;
                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<option value=" . $row["IDC"] . ">" . $row["IDC"] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div id="tdg" align="left" style="display:none">
                            <select size="1" id="grupo">
                                <option selected="selected" value="0">Todos</option>
                                <?php
                                if ($accesogp == 0) :
                                    $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tgrupo order by IDG");
                                else :
                                    $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tgrupo where  IDG in (" . $accesogp . ") order by IDG");
                                endif;

                                $idg = "";
                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<option " . ($idg == $row["IDG"] ? " selected='selected'" : " ") . " value=" . $row["IDG"] . ">" . $row["IDG"] .  "-" . $row['Descrip'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div id="tdb" align="left" style="display:none">
                            <select size="1" id="banca">
                                <option selected="selected" value="0">Todos</option>
                            </select>
                        </div>
                    </label>
                    <span class="selectRequiredMsg">Seleccione un elemento.</span></span>
            </th>
            <th>&nbsp;</th>
        </tr>
        <tr>
            <th></th>
            <th>&nbsp;</th>
            <th colspan="2">&nbsp;</th>
            <th>&nbsp;</th>
        </tr>
        <tr>
            <th width="1"></th>
            <th width="80">&nbsp;</th>
            <th colspan="2">&nbsp;</th>
            <th width="68">
                <button class="button-pv-standard" style="width: 95px;" onclick="imprimirredd('<? echo $accesogp; ?>');">Ver
                    Reporte</button>
            </th>
        </tr>
    </table>
</div>

<script>
    Nifty('div#box6', 'big');
    var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
    cargarcampos_ddes1();
    cargarcampos_ddes2();
</script>