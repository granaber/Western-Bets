<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$op = $_REQUEST["op"];
$CodigoAcceso = '';
$NombrePantalla = '';
$Estatus = 1;
$NombreTicket = '';
$Formato = 1;
$LA = 0;
$LH = '';
$MA = 0;
$MH = '';
$MIA = 0;
$MIH = '';
$JA = 0;
$JH = '';
$VA = 0;
$VH = '';
$SA = 0;
$SH = '';
$DA = 0;
$DH = '';
$imagen = '';
if ($op == 1) :
  $resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tloteria Order by IDLot Desc");
else :
  $resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tloteria where IDLot=" . $_REQUEST["IDlot"]);
endif;
if (mysqli_num_rows($resultj) != 0) :
  $rowj = mysqli_fetch_array($resultj);
  if ($op == 1) :
    $IDLot = $rowj["IDLot"] + 1;
  else :
    $IDLot = $rowj["IDLot"];
    $CodigoAcceso = $rowj["CodigoAcceso"];
    $NombrePantalla = $rowj["NombrePantalla"];
    $Estatus = $rowj["Estatus"];
    $NombreTicket = $rowj["NombreTicket"];
    $Formato = $rowj["Formato"];
    $LA = $rowj["LA"];
    $LH = $rowj["LH"];
    $MA = $rowj["MA"];
    $MH = $rowj["MH"];
    $MIA = $rowj["MIA"];
    $MIH = $rowj["MIH"];
    $JA = $rowj["JA"];
    $JH = $rowj["JH"];
    $VA = $rowj["VA"];
    $VH = $rowj["VH"];
    $SA = $rowj["SA"];
    $SH = $rowj["SH"];
    $DA = $rowj["DA"];
    $DH = $rowj["DH"];
    $imagen = $rowj["imagen"];
  endif;
else :
  $IDLot = 1;
endif;

$IDLot_str = str_repeat('0', 10 - strlen($IDLot)) . $IDLot;
?>

<div id="obj">
  <table width="606" border="0">
    <tr>
      <td width="148">Id Loteria</td>
      <td width="193"><span id="IDLot" lang="<? echo $IDLot; ?>" style="font-size:14px; color:#C30"><? echo $IDLot_str; ?></span></td>
      <td width="70" align="right">Asignacion de Tecla</td>
      <td width="87"><label>
          <select name="select2" id="CodigoAcceso">
            <?
            for ($Letra = 65; $Letra <= 90; $Letra++) {
              if ($CodigoAcceso == $Letra) :
                echo "<option value='" . $Letra . "' selected='selected'>" . chr($Letra) . "</option>";
              else :
                echo "<option value='" . $Letra . "'>" . chr($Letra) . "</option>";
              endif;
            }


            ?>
          </select>
        </label></td>
      <td width="88"><strong><span id="estado" style="color:#900; font-size:14px"> </span></strong></td>
    </tr>
    <tr>
      <td>Nombre de la Loteria</td>

      <td><span id="sprytextfield1">
          <label>
            <input type="text" name="textfield" id="NombrePantalla" value="<? echo $NombrePantalla; ?>" />
          </label>
          <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
      <td align="right">Status</td>
      <td colspan="2">
        <samp id="Estatus" value="<? echo $Estatus; ?>"></samp>
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
      <td>Texto para el Ticket</td>
      <td><span id="sprytextfield2">
          <label>
            <input type="text" name="textfield2" id="NombreTicket" value="<? echo $NombreTicket; ?>" />
          </label>
          <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
      <td>&nbsp;</td>
      <td colspan="2"><img id='imgver' src="images/logo/<?php echo $imagen; ?>?<?php echo md5(time()); ?>" height="30px" width="60px" /></td>
    </tr>
    <tr>
      <td>Formato de la Loteria</td>
      <td><select name="select" id="Formato">
          <?
          $resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tloteria_formato ");
          while ($row = mysqli_fetch_array($resultj)) {
            if ($Formato == $row["Formato"]) :
              echo "<option value='" . $row["Formato"] . "' selected='selected'>" . $row["Descripcion"] . "</option>";
            else :
              echo "<option value='" . $row["Formato"] . "'>" . $row["Descripcion"] . "</option>";
            endif;
          }
          //".($idg==$row["IDG"]?" selected='selected'":" ")." 
          ?>
        </select>
      </td>
      <td>Logo:</td>
      <td colspan="2">
        <form id="fromiut" method="post" enctype="multipart/form-data" action="controlUpload3.php" target="iframeUpload">
          <input name="fileUpload" type="file" id="imagen" lang="<?php echo $imagen; ?>" onchange="uploadFile2(this.id);" value="<?php echo $imagen; ?>"><iframe name="iframeUpload" style="display:none"></iframe>
        </form>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" align="center"><strong><span style="font-size:14px">Dias de Jugada y Cierre</span></strong></td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>Activo/Dias</td>
      <td>Hora de Cierre</td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td><label>
          <input type="checkbox" name="checkbox" id="LA" <? if ($LA == 1) : echo 'checked="checked"';
                                                          endif; ?>>
        </label> Lunes</td>
      <td><span id="sprytextfield3">
          <label>
            <input type="text" name="textfield3" id="LH" size="8" value="<? echo $LH; ?>" />
          </label>
          <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no valido.</span></span></td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td><input type="checkbox" name="checkbox2" id="MA" <? if ($MA == 1) : echo 'checked="checked"';
                                                          endif; ?>>
        Martes</td>
      <td><span id="sprytextfield4">
          <input type="text" name="textfield4" id="MH" size="8" value="<? echo $MH; ?>" />
          <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v�lido.</span></span></td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td><input type="checkbox" name="checkbox3" id="MIA" <? if ($MIA == 1) : echo 'checked="checked"';
                                                            endif; ?>>
        Miercoles
      </td>
      <td><span id="sprytextfield5">
          <input type="text" name="textfield5" id="MIH" size="8" value="<? echo $MIH; ?>" />
          <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v�lido.</span></span></td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td><input type="checkbox" name="checkbox4" id="JA" <? if ($JA == 1) : echo 'checked="checked"';
                                                          endif; ?>>
        Jueves
      </td>
      <td><span id="sprytextfield6">
          <input type="text" name="textfield6" id="JH" size="8" value="<? echo $JH; ?>" />
          <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v�lido.</span></span></td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td><input type="checkbox" name="checkbox5" id="VA" <? if ($VA == 1) : echo 'checked="checked"';
                                                          endif; ?>>
        Viernes
      </td>
      <td><span id="sprytextfield7">
          <input type="text" name="textfield7" id="VH" size="8" value="<? echo $VH; ?>" />
          <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v�lido.</span></span></td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td><input type="checkbox" name="checkbox6" id="SA" <? if ($SA == 1) : echo 'checked="checked"';
                                                          endif; ?>>
        Sabado</td>
      <td><span id="sprytextfield8">
          <input type="text" name="textfield8" id="SH" size="8" value="<? echo $SH; ?>" />
          <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v�lido.</span></span></td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td><input type="checkbox" name="checkbox7" id="DA" <? if ($DA == 1) : echo 'checked="checked"';
                                                          endif; ?>>
        Domingo
      </td>
      <td><span id="sprytextfield9">
          <input type="text" name="textfield9" id="DH" size="8" value="<? echo $DH; ?>" />
          <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v�lido.</span></span></td>
      <td><input type="submit" name="button" id="button" value="Grabar" onclick="gem_general(1,'IDLot.lang|NombrePantalla.value|NombreTicket.value|Formato.value|Estatus.lang|CodigoAcceso.value|LA.checked|LH.value|MA.checked|MH.value|MIA.checked|MIH.value|JA.checked|JH.value|VA.checked|VH.value|SA.checked|SH.value|DA.checked|DH.value|imagen.lang','_tloteria',false);" /></td>
      <td colspan="2"><input type="submit" name="button2" id="button2" value="Salir" onclick="dhxWins2.window('w2').close(); refrecargrid('grid.xml','SELECT * FROM _tloteria Order by IDLot','IDLot|NombrePantalla|NombreTicket|CodigoAcceso|Estatus|DATA!imagen');" /></td>
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
  var w2 = dhxWins2.createWindow("w2", 50, 120, 650, 500);
  w2.setText("Loterias");
  w2.attachObject('obj');
  //dhxWins2.setSkin("web");  
  dhxWins2.window("w2").setModal(true);
  var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
  var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
  var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "time", {
    useCharacterMasking: true,
    validateOn: ["blur", "change"]
  });
  var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "time", {
    validateOn: ["blur", "change"],
    useCharacterMasking: true
  });
  var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "time", {
    validateOn: ["blur", "change"],
    useCharacterMasking: true
  });
  var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "time", {
    validateOn: ["blur", "change"],
    useCharacterMasking: true
  });
  var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "time", {
    validateOn: ["blur", "change"],
    useCharacterMasking: true
  });
  var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8", "time", {
    validateOn: ["blur", "change"],
    useCharacterMasking: true
  });
  var sprytextfield9 = new Spry.Widget.ValidationTextField("sprytextfield9", "time", {
    validateOn: ["blur", "change"],
    useCharacterMasking: true
  });
</script>