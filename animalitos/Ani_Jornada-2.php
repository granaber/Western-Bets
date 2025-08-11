<?php
/*  date_default_timezone_set('America/Caracas'); */

require_once('prc_phpDUK.php');
$link = ConnectionAnimalitos::getInstance();

$HoraCierre = '';
$CantidadNumero = '';
$Activo = 0;
$ID = 0;
$fc = $_REQUEST['fc'];
switch ($_REQUEST['op']) {
  case '2':
    $ID = $_REQUEST['ID'];
    $sql = "Select * from _Jornada where  ID=" . $ID . "   order by ID";
    $resultj = mysqli_query($link, $sql);
    $rowj = mysqli_fetch_array($resultj);
    $HoraCierre = convertirNormal($rowj['HoraCierre']);
    $Dhora = explode(' ', $HoraCierre);
    $am = $Dhora[count($Dhora) - 1];
    $Dhora = explode(':', $HoraCierre);
    $h = $Dhora[0];
    $m = $Dhora[1];
    $CantidadNumero = $rowj['CantidadNum'];
    $Activo = $rowj['Activa'];
    $loteria = 'Animalitos';
    $sql = "Select * from _Loterias where  IDL=" . $rowj['IDL'];
    $resultj = mysqli_query($link, $sql);
    if (mysqli_num_rows($resultj) != 0) :
      $rowj = mysqli_fetch_array($resultj);
      $loteria = $rowj['Nombre'];
    endif;
    break;

  default:
    # code...
    break;
}
?>
<div id="fromJornadaCNG" style="background:#BAC6D8;width:415px; height:1000px">

  <table border="0">
    <tr>
      <th height="30" scope="col" align="left"><span style="color:#000; font-size:12px">Hora del Sorteo:</span></th>
      <th width="150" scope="col" align="left"><select id="h">
          <?
          for ($i = 1; $i <= 12; $i++)
            echo "<option  value='" . $i . "' " . ($h == $i ? 'selected' : '') . " >" . $i . "</option>";
          ?>
        </select> :
        <select id="m">
          <?
          for ($i = 0; $i <= 59; $i++)
            echo "<option  value='" . $i . "' " . ($m == $i ? 'selected' : '') . "  >" . $i . "</option>";
          ?>
        </select>:
        <select id="am">
          <?
          echo "<option  value='AM' " . ($am == 'am' ? 'selected' : '') . " >AM</option>";
          echo "<option  value='PM' " . ($am == 'pm' ? 'selected' : '') . " >PM</option>";
          ?>
        </select>

      </th>
    </tr>
    <tr>
      <th height="28" scope="col" align="left"><span style="color:#000; font-size:12px">Cantidad de Animalitos:</span></th>
      <th scope="col" align="left"><input id="CantidadNumero" type="text" size="8" maxlength="5" value='<?php echo $CantidadNumero; ?>' />
      </th>
    </tr>
    <tr>
      <th scope="col" align="left"><span style="color:#000; font-size:12px">Activo:</span></th>
      <th scope="col" align="left">
        <select id="Activo">
          <?
          echo "<option  value='0' " . ($Activo == '0' ? 'selected' : '') . " >No</option>";
          echo "<option  value='1' " . ($Activo == '1' ? 'selected' : '') . " >Si</option>";
          ?>
        </select>
      </th>
    </tr>
    <tr>
      <th scope="col" align="left"><span style="color:#000; font-size:12px">Loteria:</span></th>
      <th scope="col" align="left"><input id="Loteria" type="text" size="30" maxlength="30" value='<? echo $loteria; ?>' disabled /></th>
    </tr>


  </table>

</div>
<div id='coc'></div>

<script>
  var fc = '<? echo $fc; ?>';

  function clicktoolBar(id) {
    switch (id) {
      case "Cerrar_":
        dhxWins2.window("w2").close();
        break;
      case "Procesar_":
        horac = $('h').value + ':' + $('m').value + ' ' + $('am').value;
        _utxprm = bna('filephp=Ani_Jornada-3.php|op=1|ID=<? echo $ID; ?>|HoraCierre=' + horac + '|CantidadNumero=' + $('CantidadNumero').value + '|Activo=' + $('Activo').value + '|usu=' + $('usu').title, this);
        new Ajax.Request('animalitos/L!p¡-.php', {
          parameters: {
            uid: _utxprm
          },
          method: 'post',
          asynchronous: false,
          onComplete: function(transport) {
            //new Ajax.Request('animalitos/sorteo-1.php',{ parameters: {iSord:sorteoCheck,usu:$('usu').title},method:'post',asynchronous:false,	onComplete: function(transport){
            var response = transport.responseText.evalJSON(true);
            if (response[0]) {
              alert('Informacion Almacenada');
              mygrid.clearAll();
              mygrid.loadXML("animalitos/Ani_Jornada-1.php?Fee=" + fc);
              dhxWins2.window("w2").close();
            } else {
              respuesta = response[2].split('-');
              nalert(respuesta[0], respuesta[1]);
            }
          },
          onFailure: function() {
            alert('No tengo respuesta Comuniquese con el Administrador!');
          }
        });

        break;

        //"ImprimirReporte2('reportedeventashipodromo-2.php');"
    }
  }

  dhxWins2 = new dhtmlXWindows();
  dhxWins2.setImagePath("codebase/imgs/");
  w2 = dhxWins2.createWindow("w2", 350, 250, 330, 250);
  w2.setText('Configuracion de Jornada ');
  w2.attachObject('fromJornadaCNG');
  dhxWins2.window("w2").button('close').hide();
  dhxWins2.window("w2").button('minmax1').hide();
  dhxWins2.window("w2").button('minmax2').hide();
  dhxWins2.window("w2").button('park').hide();

  dhxWins2.window('w2').setModal(true);
  var bar = w2.attachToolbar();
  bar.addButton("Cerrar_", 4, "Cerrar", "animalitos/icons/noun_1042920_cc.png", "animalitos/icons/noun_1042920_cc.png");
  bar.addButton("Procesar_", 1, "Grabar", "animalitos/icons/noun_976547_cc.png", "animalitos/icons/noun_976547_cc.png");
  bar.attachEvent("onClick", clicktoolBar);
</script>