<?php
require('prc_php.php');

$GLOBALS['link'] = Connection::getInstance();

$fc = $_REQUEST["fc"];
$idc = $_REQUEST["idc"];
$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where Fecha='" . $fc . "'");
if (mysqli_num_rows($resultj) != 0) :
    $rowj = mysqli_fetch_array($resultj);
    $idj = $rowj["IDJ"];
else :
    $idj = 0;
    $idc = '';
endif;
$idt = $_REQUEST['idt'];
$accesogp = accesolimitado($idt);
$idb = accesolimitadobanca($idt);
$grupo = 0;
$addBanca = ' 1 ';
if ($idb != 0) :
    $addBanca = "  IDB=$idb ";
endif;
//echo $accesogp;
?>
<div id="box4" style="background: #036;width:60%">
    <div align="left" style="color:#FC0">Indique la Fecha: <span style="background:#666; color:#FFF"> DESDE:
            <input class="input-pv-standard" name="fc" type="text" id="fc" lang="<?php echo $idj; ?>" size="10"
                value="<?php echo $fc; ?>" />
            HASTA:
            <input class="input-pv-standard" name="fc1" type="text" id="fc1" lang="<?php echo $idj; ?>" size="10"
                value="<?php echo $fc; ?>" /></span>
        <samp>Banca:</samp>
        <select class="select-pv-standard" name="select" id="banca">
            <? if ($idb == 0) : ?>
            <option value="0">Todos</option>
            <? endif; ?>
            <?php

            $result3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbanca where $addBanca");
            while ($row3 = mysqli_fetch_array($result3))
                echo "<option  value='" . $row3["IDB"] . "'>" . $row3["IDB"] . '-' . $row3['NombreB'] . "</option>";

            ?>
        </select>
        <div id="divgrupos" style="display:inline">
            <? include "verjugadaxml-group.php" ?>
        </div>

        <input class="button-pv-standard" name="" type="button"
            onClick="makeResultwin('verjugadaxml-1.php?accesogp=<? echo $accesogp; ?>&grupo=' + $('grupos').value+'&idb='+ $('banca').value, 'resol');"
            value="Buscar">
        <span id="contador" style="font-size:14px; color:#FFF"></span>
    </div>
</div>
<br>
<br>

<div id='resol' style="margin: auto;width:54%">
    <? include "verjugadaxml-1.php" ?>
</div>

<script>
Nifty('div#box4', 'big');
cargarFechaForVer();
cargarFechaForVer1();



const idbanca = $('banca')
idbanca.addEventListener('change', function() {
    const idbanca = this.value


    handleChangeRecordGroup(idbanca, <?= $accesogp ?>)

}, false);
</script>