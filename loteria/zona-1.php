<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$op = $_REQUEST["op"];
$Descripcion = '';
$Direccion = '';
$Ubicacion = '';
$Estatus = 1;
$Responsable = '';

if ($op == 1) :
  $resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tzona Order by IDZ Desc");
else :
  $resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tzona where IDZ=" . $_REQUEST["IDZ"]);
endif;
if (mysqli_num_rows($resultj) != 0) :
  $rowj = mysqli_fetch_array($resultj);
  if ($op == 1) :
    $IDZ = $rowj["IDZ"] + 1;
  else :
    $IDZ = $rowj["IDZ"];
    $Descripcion = $rowj["Descripcion"];
    $Responsable = $rowj["Responsable"];
    $Direccion = $rowj["Direccion"];
    $Ubicacion = $rowj["Ubicacion"];
    $Estatus = $rowj["Estatus"];

  endif;
else :
  $IDZ = 1;
endif;

$IDZ_str = str_repeat('0', 10 - strlen($IDZ)) . $IDZ;
?>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />


<div id="obj">
  <table width="606" border="0">
    <tr>
      <td width="148">Id Zona</td>
      <td width="193"><span id="IDZ" lang="<? echo $IDZ; ?>" style="font-size:14px; color:#C30"><? echo $IDZ_str; ?></span></td>
      <td width="70" align="right">&nbsp;</td>
      <td width="87">&nbsp;</td>
      <td width="88"><strong><span id="estado" style="color:#900; font-size:14px"> </span></strong></td>
    </tr>
    <tr>
      <td>Nombre de la Zona</td>

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
      <td>Responsable</td>
      <td><span id="sprytextfield2">
          <label>
            <input type="text" name="textfield2" id="Responsable" value="<? echo $Responsable; ?>" />
          </label>
          <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>Direccion</td>
      <td><span id="sprytextfield2"><span id="sprytextfield5">
            <label>
              <input type="text" name="textfield3" id="Direccion" value="<? echo $Direccion; ?>" />
            </label>
            <span class="textfieldRequiredMsg">Se necesita un valor.</span></span><span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>Ubicacion</td>
      <td><span id="sprytextfield6">
          <label>
            <input type="text" name="textfield4" id="Ubicacion" value="<? echo $Ubicacion; ?>" />
          </label>
          <span class="textfieldRequiredMsg">Se necesita un valor.</span></span><span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
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
      <td><input type="submit" name="button" id="button" value="Grabar" onclick="gem_general(1,'IDZ.lang|Descripcion.value|Responsable.value|Direccion.value|Ubicacion.value|Estatus.lang','_tzona',true);" /></td>
      <td colspan="2"><input type="submit" name="button2" id="button2" value="Salir" onclick="dhxWins2.window('w2').close(); refrecargrid('grid_Zona.xml','SELECT * FROM _tzona Order by IDZ','IDZ|Descripcion|Responsable|Estatus');" /></td>
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
  var w2 = dhxWins2.createWindow("w2", 50, 120, 650, 250);
  w2.setText("Zonas");
  w2.attachObject('obj');
  //dhxWins2.setSkin("web");  
  dhxWins2.window("w2").setModal(true);
  var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
  var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");

  var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
  var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6");
</script>