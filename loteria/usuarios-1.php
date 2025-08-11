<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$op = $_REQUEST["op"];
$Nombre = '';
$Usuario = '';
$Clave = '';
$Asociado = 0;
$Estatus = 1;
$Acceso = '';
$Tipo = 1;
$servidor = 1;

if ($op == 1) :
  $sql = ("SELECT * FROM _tusu Order by IDusu Desc");

else :
  $sql = ("SELECT * FROM _tusu where IDusu=" . $_REQUEST["IDusu"]);
endif;
$resultj = mysqli_query($GLOBALS['link'], $sql);
if (mysqli_num_rows($resultj) != 0) :
  $rowj = mysqli_fetch_array($resultj);
  if ($op == 1) :
    $IDusu = $rowj["IDusu"] + 1;
  else :
    $IDusu = $rowj["IDusu"];
    $Nombre = $rowj["Nombre"];
    $Usuario = $rowj["Usuario"];
    $Clave = $rowj["clave"];
    $Asociado = $rowj["Asociado"];
    $Estatus = $rowj["Estatus"];
    $Acceso = $rowj["Acceso"];
    $Tipo = $rowj["Tipo"];
    $servidor = $rowj["servidor"];
  endif;
else :
  $IDusu = 1;
endif;

$IDusu_str = str_repeat('0', 10 - strlen($IDusu)) . $IDusu;
?>

<div id="obj">
  <table width="656" border="0">
    <tr>
      <td width="169">Id Usuario</td>
      <td width="200"><span id="IDusu" lang="<? echo $IDusu; ?>" style="font-size:14px; color:#C30"><? echo $IDusu_str; ?></span></td>
      <td width="55" align="right">&nbsp;</td>
      <td width="84">&nbsp;</td>
      <td width="126"><strong><span id="estado" style="color:#900; font-size:14px"> </span></strong></td>
    </tr>
    <tr>
      <td> Usuario:</td>

      <td><span id="sprytextfield1">
          <label>
            <input type="text" name="Usuario" id="Usuario" value="<? echo $Usuario; ?>" />
          </label>
          <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
      <td align="right">Estatus:</td>
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
      <td>Clave:</td>
      <td><span id="sprytextfield2">
          <label>
            <input type="password" name="textfield" id="Clave" value="<? echo $Clave; ?>" />
          </label>
          <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>Nombre del Usuario:</td>
      <td><label>
          <input type="text" name="textfield3" id="Nombre" value="<? echo $Nombre; ?>" />
        </label></td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>Tipo de Usuario:</td>
      <td><label>
          <select name="select" id="Tipo" onchange="clickChangeUser(this.value,<? echo  $Asociado; ?>);">
            <option value="1" <? if ($Tipo == 1) : echo 'selected="selected"';
                              endif; ?>>Agencia</option>
            <option value="2" <? if ($Tipo == 2) : echo 'selected="selected"';
                              endif; ?>>Intermediario</option>
            <option value="3" <? if ($Tipo == 3) : echo 'selected="selected"';
                              endif; ?>>Zona</option>
            <option value="4" <? if ($Tipo == 4) : echo 'selected="selected"';
                              endif; ?>>Banca</option>
            <option value="5" <? if ($Tipo == 6) : echo 'selected="selected"';
                              endif; ?>>Usuario</option>
            <option value="6" <? if ($Tipo == 5) : echo 'selected="selected"';
                              endif; ?>>Administrador</option>
          </select>
        </label></td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>Se Encuentra Asociado a:</td>
      <td><label id="lblAsociado">
          <select name="select2" id="Asociado">
            <option value="0">a</option>
          </select>
        </label></td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>Debe Acceder al Servidor:</td>
      <td><select name="select2" id="servidor">
          <option value="1">Principal</option>
        </select></td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>
      </td>
      <td></td>
      <td><input type="submit" name="button" id="button" value="Grabar" onclick="gem_general(1,'IDusu.lang|Clave.value|Usuario.value|Asociado.value|Estatus.lang|Nombre.value|Acceso.lang|Tipo.value|servidor.value','_tusu',true);" /></td>
      <td><input type="submit" name="button2" id="button2" value="Salir" onclick="dhxWins2.window('w2').close(); refrecargridPHP('usuarios-2.php');" /></td>
      <td><input type="submit" name="button3" id="button3" value="Avanzado &gt;&gt;" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
  </table>

</div>
<samp id="Acceso" lang="0"></samp>
<div id='accesos'>
  <table width="606" border="0">
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>

</div>
<script>
  phpTipo = <? echo $Tipo; ?>;
  phpAsociado = <? echo $Asociado; ?>;

  dhxWins2 = new dhtmlXWindows();
  dhxWins2.setImagePath("codebase/imgs/");
  var w2 = dhxWins2.createWindow("w2", 50, 120, 650, 270);
  w2.setText("Usuarios");
  w2.attachObject('obj');

  dhxWins2.window("w2").setModal(true);

  clickChangeUser(phpTipo, phpAsociado);

  var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
  var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
  var sprytextfield9 = new Spry.Widget.ValidationTextField("sprytextfield9", "time", {
    validateOn: ["blur", "change"],
    useCharacterMasking: true
  });
</script>