<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$IDRelacionado = explode('-', $_REQUEST['ID']);

$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tporcentajes where  Tipo=" . $IDRelacionado[0] . " and ID=" . $IDRelacionado[1]);
if (mysqli_num_rows($result) != 0) :
  $rowj = mysqli_fetch_array($result);
  $PorcentajeTerminal = $rowj['PorcentajeTerminal'];
  $PorcentajeTriple = $rowj['PorcentajeTriple'];
  $PorcentajeTerminalazo = $rowj['PorcentajeTerminalazo'];
  $PorcentajeTripletazo = $rowj['PorcentajeTripletazo'];
  $ParticipacionGana = $rowj['ParticipacionGana'];
  $ParticipacionPierde = $rowj['ParticipacionPierde'];
else :
  $PorcentajeTerminal = '';
  $PorcentajeTriple = '';
  $PorcentajeTerminalazo = '';
  $PorcentajeTripletazo = '';
  $ParticipacionGana = '';
  $ParticipacionPierde = '';
endif;

tabla_tipo($IDRelacionado[0], $tabla, $clave);

$result = mysqli_query($GLOBALS['link'], "SELECT * FROM " . $tabla . " where  " . $clave . "=" . $IDRelacionado[1]);
$rowTipo = mysqli_fetch_array($result);
?>


<samp id='Tipo' lang="<? echo $IDRelacionado[0]; ?>"></samp>
<table width="496" border="0">
  <tr>
    <td width="109">Porcentajes de:</td>
    <td colspan="4" id="ID" lang="<? echo $IDRelacionado[1]; ?>"><? echo $rowTipo['Descripcion']; ?></td>
  </tr>
  <tr>
    <td colspan="2" align="center" style="background:#069; color:#FFF">% Ventas</td>
    <td width="10">&nbsp;</td>
    <td colspan="2" align="center" style="background:#333; color:#FFF"><span style="background:#333; color:#FFF">Participaciones:</span></td>
  </tr>
  <tr>
    <td>Terminal</td>
    <td width="117"><span id="sprytextfield1">
        <label>
          <input name="textfield" type="text" id="PorcentajeTerminal" size="5" maxlength="3" value="<? echo $PorcentajeTerminal; ?>">
          %</label>
        <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span><span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span><span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span><span class="textfieldMinValueMsg">El valor introducido es inferior al mínimo permitido.</span><span class="textfieldMaxValueMsg">El valor introducido es superior al máximo permitido.</span></span></td>
    <td>&nbsp;</td>
    <td width="89">% Ganacias:</td>
    <td width="149"><span id="sprytextfield5">
        <input name="ParticipacionGana" type="text" id="ParticipacionGana" size="5" maxlength="3" value="<? echo $ParticipacionGana; ?>">
        <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span><span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span><span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span><span class="textfieldMinValueMsg">El valor introducido es inferior al mínimo permitido.</span><span class="textfieldMaxValueMsg">El valor introducido es superior al máximo permitido.</span></span></td>
  </tr>
  <tr>
    <td>Triple</td>
    <td><span id="sprytextfield2">
        <label>
          <input name="textfield2" type="text" id="PorcentajeTriple" size="5" maxlength="3" value="<? echo $PorcentajeTriple; ?>">
          %</label>
        <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span><span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span><span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span><span class="textfieldMinValueMsg">El valor introducido es inferior al mínimo permitido.</span><span class="textfieldMaxValueMsg">El valor introducido es superior al máximo permitido.</span></span></td>
    <td>&nbsp;</td>
    <td>% Perdidas:</td>
    <td><span id="sprytextfield6">
        <input name="ParticipacionPierde" type="text" id="ParticipacionPierde" size="5" maxlength="3" value="<? echo $ParticipacionPierde; ?>">
        <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span><span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span><span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span><span class="textfieldMinValueMsg">El valor introducido es inferior al mínimo permitido.</span><span class="textfieldMaxValueMsg">El valor introducido es superior al máximo permitido.</span></span></td>
  </tr>
  <tr>
    <td>Terminalazo</td>
    <td> <span id="sprytextfield3">
        <input name="textfield3" type="text" id="PorcentajeTerminalazo" size="5" maxlength="3" value="<? echo $PorcentajeTerminalazo; ?>">
        <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span><span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span><span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span><span class="textfieldMinValueMsg">El valor introducido es inferior al mínimo permitido.</span><span class="textfieldMaxValueMsg">El valor introducido es superior al máximo permitido.</span></span>%</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
  </tr>
  <tr>
    <td>Tripletazo</td>
    <td><span id="sprytextfield4">
        <input name="textfield4" type="text" id="PorcentajeTripletazo" size="5" maxlength="3" value="<? echo $PorcentajeTripletazo; ?>">
        <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span><span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span><span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span><span class="textfieldMinValueMsg">El valor introducido es inferior al mínimo permitido.</span><span class="textfieldMaxValueMsg">El valor introducido es superior al máximo permitido.</span></span>
      %</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong><span id="estado" style="color:#900; font-size:14px"> </span></strong></td>
    <td><label>
        <input type="submit" name="button" id="button" value="Grabar" onclick="gem_general(2,'ID.lang|Tipo.lang|PorcentajeTerminal.value|PorcentajeTriple.value|PorcentajeTerminalazo.value|PorcentajeTripletazo.value|ParticipacionGana.value|ParticipacionPierde.value','_tporcentajes',true);">
      </label></td>
  </tr>
</table>
<script type="text/javascript">
  <!--
  var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {
    useCharacterMasking: true,
    maxChars: 3,
    minChars: 1,
    minValue: 0,
    maxValue: 100
  });
  var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "integer", {
    useCharacterMasking: true,
    minChars: 1,
    maxChars: 3,
    minValue: 0,
    maxValue: 100
  });
  var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "integer", {
    minChars: 1,
    maxChars: 3,
    minValue: 0,
    maxValue: 100,
    useCharacterMasking: true
  });
  var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "integer", {
    minChars: 1,
    maxChars: 3,
    minValue: 0,
    maxValue: 100,
    useCharacterMasking: true
  });
  var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "integer", {
    minChars: 1,
    maxChars: 3,
    minValue: 0,
    maxValue: 300,
    useCharacterMasking: true
  });
  var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "integer", {
    minChars: 1,
    maxChars: 3,
    minValue: 0,
    maxValue: 100,
    useCharacterMasking: true
  });
  //
  -->
</script>