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





<div id="fromReporte" style=" height:1000px;width:500px; background:  #4B79A7">
  <?php

  require('prc_php.php');
  $GLOBALS['link'] = Connection::getInstance();

  ?>

  <table width="440" border="0" cellspacing="0">
    <tr>
      <th width="1"></th>
      <th colspan="4">
        <div align="center" class="Estilo4d1">Verificacion/Pago de Premio</div>
        <div align="right"></div>
      </th>
    </tr>
    <tr>
      <th></th>
      <th width="80">&nbsp;</th>
      <th colspan="2">&nbsp;</th>
      <th width="68">
        <div align="right"></div>
      </th>
    </tr>

    <tr>
      <th></th>
      <th class="Estilo3d1">
        <div align="right">Serial Premiado:</div>
      </th>
      <th width="144"><input name="fc" type="text" id="ticket" size="10" /></th>
      <th width="137"><input name="input" type="button" value="Buscar" onclick=" pagapremio($('ticket').value)" /></th>
      <th>&nbsp;</th>
    </tr>

    <tr>
      <th></th>
      <th>&nbsp;</th>
      <th colspan="2">&nbsp;</th>
      <th>&nbsp;</th>
    </tr>
  </table>
  <div align="center">
    <div id="tittulo" style="height:40px; width:300px; background:#036; border:medium; color:#FFF" align="center">Ver Ticket No.<input name="" id="vertik" type="text" size="14" disabled="disabled" /><input id="btnpagar" name="" type="button" value="Pagar" onclick=" pagarticket($('vertik').value)" /></div>
    <div id="verticket" style="height:400px; width:300px; background:#FFF; border:medium"></div>
  </div>
</div>

<script>
  function clicktoolBar(id) {
    switch (id) {
      case "Cerrar_":
        dhxWins1.window("w1").close();
        break;


        //"ImprimirReporte2('reportedeventashipodromo-2.php');"
    }
  }
  dhxWins1 = new dhtmlXWindows();
  dhxWins1.setImagePath("codebase/imgs/");
  w1 = dhxWins1.createWindow("w1", 360, 270, 480, 650);
  w1.setText('Verificacion/Pago de Premio');
  w1.attachObject('fromReporte');
  dhxWins1.window("w1").button('close').hide();
  dhxWins1.window("w1").button('minmax1').hide();
  dhxWins1.window("w1").button('minmax2').hide();
  dhxWins1.window("w1").button('park').hide();
  dhxWins1.window("w1").denyResize();
  dhxWins1.window("w1").denyMove();
  var bar = w1.attachToolbar();
  bar.addButton("Cerrar_", 4, "Cerrar", "images/close.gif", "images/close.gif");
  //bar.addButton("ImprimiR_", 1, "Imprimir Reporte", "images/print.gif", "images/print.gif"); 
  //bar.addButton("Imprimit_", 2, "Imprimir Ticket", "images/print_dis.gif", "images/print_dis.gif"); 
  bar.attachEvent("onClick", clicktoolBar);
  $('ticket').focus();
</script>