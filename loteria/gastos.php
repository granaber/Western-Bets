<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$op = $_REQUEST['op'];
$Descripcion = '';
$Monto = 0;

if ($op == 1) :
  $resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tgastos Order by IDGas Desc");
else :
  $resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tgastos where IDGas=" . $_REQUEST["IDGas"]);
endif;

if (mysqli_num_rows($resultj) != 0) :
  $rowj = mysqli_fetch_array($resultj);

  if ($op == 1) :
    $IDGas = $rowj["IDGas"] + 1;
  else :
    $IDGas = $rowj["IDGas"];
    $Descripcion = $rowj["Descripcion"];
    $Monto = $rowj["Monto"];
  endif;

else :
  $IDGas = 1;
endif;
$IDGas_str = str_repeat('0', 10 - strlen($IDGas)) . $IDGas;
?>


<table width="309" border="0" cellpadding="0" cellspacing="0">
  <tr bgcolor="#BCD5FE">
    <td width="143"><span>Id Gasto:</span></td>

    <td width="94"><span id='IDGas' lang="<? echo $IDGas; ?>"><? echo $IDGas_str; ?></span></td>
    <td width="72">&nbsp;</td>
  </tr>
  <tr>
    <td>Descripcion del Gasto:</td>

    <td><span id="sprytextfield1">
        <input id='Descripcion' type="text" size="15" value="<? echo $Descripcion; ?>" />
        <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#BCD5FE">
    <td>Monto:</td>

    <td><span id="sprytextfield2">
        <input id='Monto' type="text" size="15" value="<? echo $Monto; ?>" />
        <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>

    <td></td>
    <td></td>
  </tr>
  <tr>
    <td><input name="" type="button" value="Registrar" onClick="RegistraGasto()" /></td>

    <td><input name="" type="button" value="Eliminar" onClick="EliminarGasto()" /></td>
    <td></td>
  </tr>
</table>
<script type="text/javascript">
  <!--
  var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
  var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "integer", {
    useCharacterMasking: true
  });

  //
  -->
</script>