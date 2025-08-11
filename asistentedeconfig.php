<style type="text/css">
  .Estilo17 {
    font-family: Verdana, Arial, Helvetica, sans-serif;
    font-size: 18px;
    font-weight: bold;
  }

  .EstiloA {
    font-size: 18px;
    color: #FFF;
  }

  .EstiloB {
    color: #F00;
    font-size: 16px
  }

  .EstiloC {
    color: #CC0;
    font-size: 16px
  }
</style>
<?php
/*  date_default_timezone_set('America/Caracas'); */

require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$minutos = -30;

?>

<div id="box12" style="width:580px; background:#333">
  <table width="570" border="0">
    <tr align="center">
      <td colspan="2" align="center"><span class="EstiloA">Configuracion Automatica</span></td>
    </tr>
    <tr>
      <td width="249">&nbsp;</td>
      <td width="229">&nbsp;</td>
    </tr>
    <tr>
      <td><span class="EstiloC">Paso 1.-</span> <span class="EstiloB">Selecciones el Deporte a Configurar</span></td>
      <td><select name="Grupo" id="Grupo" onchange="jsonvalores3(<?php echo $idj; ?>);">
          <?php
          $resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _gruposdd where  Estatus=1 Order by grupo ");
          while ($row = mysqli_fetch_array($resultj)) {
            if ($row["Grupo"] == $grp) :  $acc = 'selected="selected"';
            else : $acc = "";
            endif;

            echo "<option  value=" . $row["Grupo"] . " " . $acc . " >" . $row["Descripcion"] . "</option>";
          }
          ?>
          <option </select>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><span class="EstiloC">Paso 2.-</span> <span class="EstiloB">Subir Archivo de Excel</span></td>
      <td>
        <form id="fromiut" method="post" enctype="multipart/form-data" action="controlUploadexcel.php" target="iframeUpload">
          <input name="fileUpload" type="file" id="archivo" lang="<?php echo $fle; ?>" onchange="uploadFileExcel(this);"><iframe name="iframeUpload" style="display:none"></iframe>
        </form>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><span class="EstiloC">Paso 4. </span><span class="EstiloB">Indique el Numero de Minutos a Disminuir(-) o Aumentar</span></td>
      <td><span id="sprytextfield1">
          <input type="text" id="_minutos" value="<? echo $minutos; ?>" />
          <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v�lido.</span></span><span class="EstiloC">Minutos</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><span class="EstiloC">Paso 3. </span><span class="EstiloB">Click para procesar el archivo</span></td>
      <td>
        <input type="submit" name="button" id="button" value="Procesar" onclick="makeResultwin('proceslectexcel.php?file='+$('archivo').lang+'&minutos='+$('_minutos').value,'resultado');">
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><span id="resultado"></span></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>

  </table>
</div>

<script>
  Nifty('div#box12', 'big');
  var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {
    useCharacterMasking: true
  });
</script>