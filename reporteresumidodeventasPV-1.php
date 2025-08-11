<style type="text/css">
  <!--
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
  -->
</style>





<div id="box1">
  <?php

  require('prc_php.php');
  $GLOBALS['link'] = Connection::getInstance();

  ?>

  <table width="440" border="0" cellspacing="0">
    <tr bgcolor="#333333">
      <th bgcolor="#333333"></th>
      <th colspan="4" bgcolor="#333333">
        <div align="center" class="Estilo4d1">Reporte de Ventas y Ganacias Detallado por Fecha</div>
        <div align="right"></div>
      </th>
    </tr>
    <tr bgcolor="#333333">
      <th bgcolor="#333333"></th>
      <th bgcolor="#333333">&nbsp;</th>
      <th colspan="2" bgcolor="#333333">&nbsp;</th>
      <th bgcolor="#333333">
        <div align="right"></div>
      </th>
    </tr>

    <tr bgcolor="#333333">
      <th bgcolor="#333333"></th>
      <th bgcolor="#333333" class="Estilo3d1">
        <div align="right">Desde:</div>
      </th>
      <th width="144" bgcolor="#333333"><input name="fc" type="text" id="fc1" onfocus="cargarcampos_ddes1();" size="10" value="<?php echo date("d/n/Y"); ?>" /></th>
      <th width="137" bgcolor="#333333">
        <div align="right" class="Estilo3d1">Hasta:</div>
      </th>
      <th bgcolor="#333333"><input name="fc" type="text" id="fc2" onfocus="cargarcampos_ddes2();" size="10" value="<?php echo date("d/n/Y"); ?>" /></th>
    </tr>

    <tr bgcolor="#333333">
      <th bgcolor="#333333"></th>
      <th bgcolor="#333333">&nbsp;</th>
      <th colspan="2" bgcolor="#333333">&nbsp;</th>
      <th bgcolor="#333333">&nbsp;</th>
    </tr>
    <tr bgcolor="#333333">
      <th width="1" bgcolor="#333333"></th>
      <th width="80" bgcolor="#333333">&nbsp;</th>
      <th colspan="2" bgcolor="#333333">&nbsp;</th>
      <th width="68" bgcolor="#333333"><img src="media/impripan.png" onclick="imprimirredtpv();" /><img src="media/imprireport.png" />&nbsp;&nbsp;</th>
    </tr>
  </table>
</div>

<script>
  Nifty('div#box1', 'big');
</script>