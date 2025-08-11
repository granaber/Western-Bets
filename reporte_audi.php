<?
require_once('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$fc = $_REQUEST["fc1"];


$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where Fecha='" . $fc . "'");
if (mysqli_num_rows($resultj) != 0) :
  $rowj = mysqli_fetch_array($resultj);
  $IDJ = $rowj["IDJ"];
else :
  $IDJ = 0;
endif;
?>
<div id="box8" style="width:800px; color:#FFF">
  <table width="734" border="0" cellspacing="0">
    <tr bgcolor="#666666">
      <th colspan="2" bgcolor="#666666" align="center">
        <div align="center" class="Estilo4">
          <div align="left">Indique la Fecha:
            <input name="fc" type="text" id="fc" lang="<?php echo $idj; ?>" size="10" value="<?php echo $fc; ?>" />
          </div>
      </th>
      <th width="112" rowspan="2" align="center" bgcolor="#666666">
        <p align="center"><img src="media/buscar.png" width="32" height="32" onClick="impresionaudi();" /></p>
        <p align="center" class="Estilo5">Ver Reporte</p>
      </th>
      <th width="108" rowspan="2" align="center" bgcolor="#666666">
        <p align="center">&nbsp;</p>
        <p align="center" class="Estilo5">&nbsp;</p>
      </th>
      <th width="224" rowspan="2" align="center" bgcolor="#666666">
        <p align="right" class="Estilo5">&nbsp;</p>
      </th>
    </tr>
    <tr bgcolor="#666666">
      <th colspan="2" bgcolor="#666666" align="center">
        <div align="left"><span class="Estilo5">
            Grupo:<span id="cns_1" align="left"> <select name="select" id="tidc">
                <?php
                echo "<option  value='0'>TODOS</option>";
                $result3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tgrupo  group by IDG");
                while ($row3 = mysqli_fetch_array($result3)) {
                  echo "<option  value='" . $row3["IDG"] . "'>" . $row3["IDG"] . '-' . $row3["Descrip"] . "</option>";
                }
                ?>
              </select></span>
          </span></div>
      </th>
    </tr>
  </table>



</div>

<br>
<div id="cortes">
  <? include("reporte_audi-2.php"); ?>
</div>
<script>
  Nifty('div#box8', 'big');
  cargarcampos_vreport();
  serial = 1;
  for (i = 1; i <= parseInt($('ultimo').lang); i++) {

    while (isset('e_' + i + '_' + serial)) {
      if ($('e_' + i + '_' + serial).lang == '0') {
        $('l' + i).disabled = "disabled";
        break;
      }
      serial++;
    }
    serial = 1;
  }
</script>