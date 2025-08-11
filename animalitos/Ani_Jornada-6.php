<?php
require_once('prc_phpDUK.php');
$link = ConnectionAnimalitos::getInstance();

$num = -1;
$premio = 0;
$modo = 0;
$op = 6;
$l = 0;
if ($_REQUEST['op'] == 2) :
  $resultj = mysqli_query($link, "Select * from _Conf_premio where l=" . $_REQUEST['l']);
  $Row = mysqli_fetch_array($resultj);
  $l = $_REQUEST['l'];
  $num = $Row['numero'];
  $premio = $Row['logro'];
  $modo = $Row['modo'];
  $op = 5;
endif;

?>
<div id="fromPremioJornadaMOD">
  <table width="278" border="0">
    <tr>
      <td>
        <p style="font-weight: bold;">Animalito:</p>
      </td>
      <td><select id='Animalito'>
          <option value="-1" <? echo ($num == -1 ? 'selected' : ''); ?>>Todos</option>
          <?
          $sql = "Select * from _NumeroAnimatios where Activo=1 order by num";
          $resultj = mysqli_query($link, $sql);
          while ($Row = mysqli_fetch_array($resultj)) {
            echo '<option value="' . $Row['num'] . '" ' . ($num == $Row['num'] ? 'selected' : '') . '>' . $Row['nombre'] . '</option>';
          }

          ?>
        </select><br></td>
    </tr>
    <tr>
      <td>
        <p style="font-weight: bold;">Premio:</p>
      </td>
      <td><input id="logro" type="text" size="10" maxlength="10" value="<? echo $premio; ?>" /></td>
    </tr>
    <tr>
      <td>
        <p style="font-weight: bold;">Modo:</p>
      </td>
      <td><select id='Modo'>
          <option value="0" <? echo ($modo == 0 ? 'selected' : ''); ?>>Terminal</option>
          <option value="1" <? echo ($modo == 1 ? 'selected' : ''); ?>>Combina 2</option>
          <option value="2" <? echo ($modo == 2 ? 'selected' : ''); ?>>Combina 3</option>
        </select><br></td>
    </tr>
  </table>
</div>
<div id='cco3'></div>
<script>
  var idRow = 0;

  function clicktoolBarPrem2(id) {
    switch (id) {
      case "Cerrar_":
        dhxWinsPrem2.window("wPrem2").close();
        break;
      case "Grabar_":
        _callBackGENDUK('Ani_Jornada-3.php', '|op=<? echo $op; ?>|ID=<? echo $_REQUEST['ID']; ?>|modo=' + $('Modo').value + '|logro=' + $('logro').value + '|numero=' + $('Animalito').value + '|l=<? echo $l; ?>', "cco3");
        mygridPrem.clearAll();
        mygridPrem.loadXML("animalitos/Ani_Jornada-5.php?ID=<? echo $_REQUEST['ID']; ?>");
        dhxWinsPrem2.window("wPrem2").close();
        break;
    }
  }



  dhxWinsPrem2 = new dhtmlXWindows();
  dhxWinsPrem2.setImagePath("codebase/imgs/");
  wPrem2 = dhxWinsPrem2.createWindow("wPrem2", 350, 255, 335, 200);
  wPrem2.setText('Configuracion de Premios por Sorteo');
  wPrem2.attachObject('fromPremioJornadaMOD');
  dhxWinsPrem2.window("wPrem2").button('close').hide();
  dhxWinsPrem2.window("wPrem2").button('minmax1').hide();
  dhxWinsPrem2.window("wPrem2").button('minmax2').hide();
  dhxWinsPrem2.window("wPrem2").button('park').hide();
  dhxWinsPrem2.window('wPrem2').setModal(true);
  var barPrem2 = wPrem2.attachToolbar();
  barPrem2.addButton("Cerrar_", 1, "Cerrar", "animalitos/icons/noun_1042920_cc.png", "animalitos/icons/noun_1042920_cc.png");
  barPrem2.addButton("Grabar_", 2, "Grabar ", "animalitos/icons/noun_976547_cc.png", "animalitos/icons/noun_976547_cc.png");
  barPrem2.attachEvent("onClick", clicktoolBarPrem2);
</script>