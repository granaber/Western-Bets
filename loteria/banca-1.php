<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$op = $_REQUEST["op"];
$Descripcion = '';
$Estatus = 1;
$Propietario = '';

if ($op == 1) :
  $resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbanca Order by IDB Desc");
else :
  $resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbanca where IDB=" . $_REQUEST["IDB"]);
endif;
if (mysqli_num_rows($resultj) != 0) :
  $rowj = mysqli_fetch_array($resultj);
  if ($op == 1) :
    $IDB = $rowj["IDB"] + 1;
  else :
    $IDB = $rowj["IDB"];
    $Descripcion = $rowj["Descripcion"];
    $Propietario = $rowj["Propietario"];
    $Estatus = $rowj["Estatus"];

  endif;
else :
  $IDB = 1;
endif;

$IDB_str = str_repeat('0', 10 - strlen($IDB)) . $IDB;
?>

<div id="obj">
  <table width="606" border="0">
    <tr>
      <td width="148">Id Banca</td>
      <td width="193"><span id="IDB" lang="<? echo $IDB; ?>" style="font-size:14px; color:#C30"><? echo $IDB_str; ?></span></td>
      <td width="70" align="right">&nbsp;</td>
      <td width="87">&nbsp;</td>
      <td width="88"><strong><span id="estado" style="color:#900; font-size:14px"> </span></strong></td>
    </tr>
    <tr>
      <td>Nombre de la Banca</td>

      <td><span id="sprytextfield1">
          <label>
            <input type="text" name="textfield" id="Descripcion" value="<? echo $Descripcion; ?>" />
          </label>
          <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
      <td align="right">Status</td>
      <td colspan="2">
        <samp id="Estatus" lang="<? echo $Estatus; ?>"></samp>
        <form>
          <input type="radio" name="radio" id="radio" value="radio" <? if ($Estatus == 1) : echo 'checked';
                                                                    endif; ?> onclick="$('Estatus').lang=1">
          Activo
          <input type="radio" name="radio" id="radio2" value="radio" <? if ($Estatus == 0) : echo 'checked';
                                                                      endif; ?> onclick="$('Estatus').lang=0">
          Desactivada
        </form>
      </td>
    </tr>
    <tr>
      <td>Propietario</td>
      <td><span id="sprytextfield2">
          <label>
            <input type="text" name="textfield2" id="Propietario" value="<? echo $Propietario; ?>" />
          </label>
          <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>
      </td>
      <td></td>
      <td><input type="submit" name="button" id="button" value="Grabar" onclick="gem_general(1,'IDB.lang|Descripcion.value|Propietario.value|Estatus.lang','_tbanca',true);" /></td>
      <td colspan="2"><input type="submit" name="button2" id="button2" value="Salir" onclick="dhxWins2.window('w2').close(); refrecargrid('grid_Banca.xml','SELECT * FROM _tbanca Order by IDB','IDB|Descripcion|Propietario|Estatus');" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
  </table>

</div>
<script>
  dhxWins2 = new dhtmlXWindows();
  dhxWins2.setImagePath("codebase/imgs/");
  var w2 = dhxWins2.createWindow("w2", 50, 120, 650, 200);
  w2.setText("Bancas");
  w2.attachObject('obj');
  //dhxWins2.setSkin("web");  
  dhxWins2.window("w2").setModal(true);
  var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
  var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
  var sprytextfield9 = new Spry.Widget.ValidationTextField("sprytextfield9", "time", {
    validateOn: ["blur", "change"],
    useCharacterMasking: true
  });
</script>