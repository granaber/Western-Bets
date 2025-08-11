<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$op = $_REQUEST["op"];
$Descripcion = '';
$Direccion = '';
$Telefono = '';
$Estatus = 1;
$Responsable = '';

if ($op == 1) :
  $resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tloteria_formato Order by Formato Desc");
else :
  $resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tloteria_formato where Formato=" . $_REQUEST["Formato"]);
endif;
if (mysqli_num_rows($resultj) != 0) :
  $rowj = mysqli_fetch_array($resultj);
  if ($op == 1) :
    $Formato = $rowj["Formato"] + 1;
  else :
    $Formato = $rowj["Formato"];
    $Descripcion = $rowj["Descripcion"];
    $Lista = $rowj["Lista"];
  endif;
else :
  $Formato = 1;
endif;

$Formato_str = str_repeat('0', 10 - strlen($Formato)) . $Formato;
?>



<div id="obj">
  <table width="606" border="0">
    <tr>
      <td width="148">Id Formato</td>
      <td width="193"><span id="Formato" lang="<? echo $Formato; ?>" style="font-size:14px; color:#C30"><? echo $Formato_str; ?></span></td>
      <td width="70" align="right">&nbsp;</td>
      <td width="87">&nbsp;</td>
      <td width="88"><strong><span id="estado" style="color:#900; font-size:14px"> </span></strong></td>
    </tr>
    <tr>
      <td>Nombre del Formato</td>

      <td><span id="sprytextfield1">
          <label>
            <input type="text" name="textfield" id="Descripcion" value="<? echo $Descripcion; ?>" />
          </label>
          <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
      <td align="right">&nbsp;</td>
      <td colspan="2"></td>
    </tr>
    <tr>
      <td>Listado</td>
      <td><label>
          <textarea name="textarea" id="Lista" cols="45" rows="5"><? echo $Lista; ?></textarea>
        </label></td>
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
      <td><input type="submit" name="button" id="button" value="Grabar" onclick="gem_general(1,'Formato.lang|Descripcion.value|Lista.value','_tloteria_formato',true);" /></td>
      <td colspan="2"><input type="submit" name="button2" id="button2" value="Salir" onclick="dhxWins2.window('w2').close(); refrecargrid('grid_Floteria.xml','SELECT * FROM _tloteria_formato Order by Formato','Formato|Descripcion|Lista');" /></td>
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
  var w2 = dhxWins2.createWindow("w2", 50, 120, 650, 300);
  w2.setText("Formato de Loterias");
  w2.attachObject('obj');
  //dhxWins2.setSkin("web");  
  dhxWins2.window("w2").setModal(true);
  var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
</script>