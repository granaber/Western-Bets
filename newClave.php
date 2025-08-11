<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$usuario = $_REQUEST['usu'];
?>

<div id="obj">
  <table width="460" border="0">
    <tr>
      <td width="177"><span style="color:#000; font-size:12px">Nombre del Usuario:</span></td>
      <td width="273"><strong><span id="usuario" lang="<? echo $usuario; ?>" style="color: #F00; font-size:14px"><? echo $usuario; ?></span></strong></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><span style="color:#000; font-size:12px">Nueva Clave:</span></td>
      <td><input id="nwclave" name="input" type="password"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><span style="color:#000; font-size:12px">Repita la Clave:</span></td>
      <td><input id="re_nwclave" name="input" type="password"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>

</div>
<script>
  function clicktoolBar(id) {
    switch (id) {
      case "Cerrar_":
        ClaveNueva();
        break;
    }
  }
  dhxWins2 = new dhtmlXWindows();
  dhxWins2.setImagePath("codebase/imgs/");
  var w1 = dhxWins2.createWindow("w1", 50, 120, 350, 250);
  w1.setText("Cambio de Clave");
  w1.attachObject('obj');
  w1.centerOnScreen();
  dhxWins2.window("w1").button('close').hide();
  dhxWins2.window("w1").button('minmax1').hide();
  dhxWins2.window("w1").button('minmax2').hide();
  dhxWins2.window("w1").button('park').hide();
  dhxWins2.window("w1").denyResize();
  dhxWins2.window("w1").denyMove();
  dhxWins2.window("w1").setModal(true);

  var bar = w1.attachToolbar();
  bar.addButton("Cerrar_", 1, "Continuar", "media/down.ico", "media/down.ico");
  bar.attachEvent("onClick", clicktoolBar);
  $('nwclave').focus();
</script>