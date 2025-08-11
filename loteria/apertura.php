<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$op = $_REQUEST["op"];

$Agencia = '';
$Usuario = '';
$MontodeApetura = 0;
$Acceso = 0;

$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tapertura where IDC=" . $_REQUEST["IDCtr"] . ' and IDJ=' . $_REQUEST["IDJ"]);

if (mysqli_num_rows($resultj) == 0) :
  /////////////// Procedimiento para la Verificacion del Cierre del Dia Anterior  //////////////////////
  $resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tapertura where IDC=" . $_REQUEST["IDCtr"] . ' order by IDAp Desc');
  if (mysqli_num_rows($resultj) != 0) :
    $rowj = mysqli_fetch_array($resultj); //_tbcuadre
    if ($_REQUEST["IDJ"] != $rowj["IDJ"]) :
      $ultimo = $rowj['IDAp'];
      $ultimoIDJ = $rowj["IDJ"];
      $resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbcuadre where IDAp=" . $ultimo);
      // echo ("SELECT * FROM _tbcuadre where IDAp=".$ultimo);
      if (mysqli_num_rows($resultj) == 0) :
        $Acceso = 1;
      endif;

    endif;
  endif;
  /////////////////////////////////////////////////////////////////////////////////////////////////////
  if ($Acceso == 0) :

    $resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tapertura Order by IDAp Desc");
    $rowj = mysqli_fetch_array($resultj);
    $IDAp = $rowj["IDAp"] + 1;
    $IDAp_str = str_repeat('0', 10 - strlen($IDAp)) . $IDAp;

    $resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tagencias where IDC=" . $_REQUEST["IDCtr"]);
    $rowj = mysqli_fetch_array($resultj);
    $Agencia = $rowj['Descripcion'];

    $resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tusu where IDusu=" . $_REQUEST["IDusu"]);
    $rowj = mysqli_fetch_array($resultj);
    $Usuario = $rowj['Nombre'];
  endif;
else :
  $Acceso = 2;
endif;



?>


<? if ($Acceso == 0) : ?>


  <div id="obj">
    <table width="508" border="0">
      <tr>
        <td width="139">Apertura No.</td>
        <td width="236"><span id="IDAp" lang="<? echo $IDAp; ?>" style="font-size:14px; color:#C30"><? echo $IDAp_str; ?></span></td>
        <td colspan="3" align="left"><strong><span id="estado" style="color:#900; font-size:14px"> </span></strong></td>
      </tr>
      <tr>
        <td>Nombre de la Agencia:</td>
        <td><span id="IDC" lang="<? echo  $_REQUEST["IDCtr"]; ?>"><? echo  $Agencia; ?></span></td>
        <td width="66" align="right">&nbsp;</td>
        <td colspan="2"></td>
      </tr>
      <tr>
        <td>Usuario:</td>
        <td><span id="IDusu" lang="<? echo  $_REQUEST["IDusu"]; ?>"><? echo  $Usuario; ?></span></td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td>Hora Apertura:</td>
        <td><input id="HoraApertura" name="" type="text" disabled size="12">&nbsp;&nbsp;<input id="FechaAp" name="" type="text" disabled size="12"></td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td>Fondo de Caja (Apertura):</td>
        <td><span id="sprytextfield1">
            <input type="text" name="textfield4" id="MontodeApetura" value="<? echo $MontodeApetura; ?>" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td>
        </td>
        <td></td>
        <td><input type="submit" name="button" id="button" value="Grabar" onclick="gem_general(1,'IDAp.lang|IDC.lang|IDusu.lang|HoraApertura.value|IDJ.lang|MontodeApetura.value','_tapertura',true);" /></td>
        <td colspan="2"><input type="submit" name="button2" id="button2" value="Salir" onclick="stop_func();dhxWins2.window('w2').close();" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
      </tr>
    </table>
    <samp id="IDJ" lang="<? echo $_REQUEST["IDJ"]; ?>"></samp>
  </div>
  <script>
    dhxWins2 = new dhtmlXWindows();
    dhxWins2.setImagePath("codebase/imgs/");
    var w2 = dhxWins2.createWindow("w2", 50, 120, 520, 250);
    w2.setText("Apertura de Agencia");
    w2.attachObject('obj');
    dhxWins2.window("w2").centerOnScreen();
    dhxWins2.window("w2").setModal(true);
    dhxWins2.window("w2").denyResize();
    dhxWins2.window("w2").denyMove();
    dhxWins2.window("w2").button("close").hide();
    horaestablecer("HoraApertura", "FechaAp");
    $('MontodeApetura').focus();
    $('MontodeApetura').select();
    var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {
      useCharacterMasking: true
    });
  </script>
  <? else :

  if ($Acceso == 1) :
  ?>
    <div id='FromRegistroGasto'>
      <div id="RegistroGasto"></div>
    </div>
    <script>
      alert(' El Cierre del Ultimo dia de Trabajo no fue Realizado !');
      if (confirm('Desea Realizarlo Ahora')) {
        CierreDeCaja(<? echo $ultimoIDJ; ?>);
      }
    </script>
  <?
  endif;
  if ($Acceso == 2) :
  ?>
    <script>
      alert(' La Apertura del Punto de Venta ya Fue Realizado ');
    </script>
<?
  endif;
endif;
?>