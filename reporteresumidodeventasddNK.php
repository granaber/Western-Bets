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

    <table width="440" border="0" cellspacing="0">
        <tr>
            <th></th>
            <th colspan="4">
                <div align="center" class="Estilo4d1">Relacion General Multiple</div>
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
            <th width="144"><input name="fc" type="text" id="fc1" size="10" value="<?php echo date("d/n/Y"); ?>" /></th>
            <th width="137">
                <div align="right" class="Estilo3d1">Hasta:</div>
            </th>
            <th><input name="fc" type="text" id="fc2" size="10" value="<?php echo date("d/n/Y"); ?>" /></th>
        </tr>

        <tr>
            <th></th>
            <th style="display:none">
                <div align="right" class="Estilo3d1">Clasificar Por:</div>
            </th>
            <th colspan="3" style="display:none">
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
                <div id="td" align="right">Grupo</div>
            </th>
            <th colspan="2">
                <div id="tdg" align="left">
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
                            echo "<option " . ($idg == $row["IDG"] ? " selected='selected'" : " ") . " value=" . $row["IDG"] . ">" . $row["IDG"] . "</option>";
                        }
                        ?>
                    </select>
                </div>

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
            <th width="68"><img src="media/impripan.png" alt="Imprimir" onclick="imprimirreddNK(<? echo $accesogp; ?>);" />&nbsp;&nbsp;</th>
        </tr>
    </table>
</div>

<script>
    Nifty('div#box6', 'big');

    cargarcampos_ddes1();
    cargarcampos_ddes2();
</script>