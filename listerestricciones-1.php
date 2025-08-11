<?php
$idc = $_REQUEST['idc'];

require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();




$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionario where IDC='" . $idc . "'");
$row = mysqli_fetch_array($resultj);
$nom = $row['Nombre'];
?>

<div id="box3">
  <table width="371" border="0" cellspacing="0">
    <tr>
      <th colspan="2" scope="col">
        <div align="center" style="color: #FFFF00; font-size:14px">Restricciones</div>
      </th>
    </tr>
    <tr>
      <th width="148" scope="col">&nbsp;</th>
      <th width="219" scope="col">
        <div id="estado" align="right" style="color: #FF3300; font-size:14px"></div>
      </th>
    </tr>
    <tr>
      <th scope="col">
        <div align="right" style="color:#FFFFFF">Letra:</div>
      </th>
      <th scope="col">
        <div id="IDC" align="left" lang="<?php echo $idc; ?>" style="color: #FFFF33; font-size:12px"><?php echo $idc; ?></div>
      </th>
    </tr>
    <tr>
      <th scope="col">
        <div align="right" style="color:#FFFFFF">Nombre:</div>
      </th>
      <th scope="col">
        <div id="IDJ" lang="4" align="left" style="color: #FFFF33; font-size:12px"><?php echo $nom; ?></div>
      </th>
    </tr>
    <tr>
      <?php
      $listadejugadas = '1';
      $lljj = explode(',', $listadejugadas);
      $k = 0;
      for ($k = 0; $k <= count($lljj) - 1; $k++) {
        echo '<tr>';
        $resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tdjuegos where IDJug=" . $lljj[$k]);
        $row = mysqli_fetch_array($resultj);
        echo '<th scope="col"><div align="right" style="color:#FFFFFF">' . $row['Descrip'] . '</div></th>';
        $resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbrestricionessph where IDC='" . $idc . "' and IDJ=" . $lljj[$k]);
        if (mysqli_num_rows($resultj) != 0) :
          $row = mysqli_fetch_array($resultj);
          $mmm = $row['mmxj'];
        else :
          $mmm = 0;
        endif;
        echo '<th scope="col"><input type="text" name="textfield" lang="' . $lljj[$k] . '" id="mmxj' . ($k + 1) . '" value="' . $mmm . '"></th>';
        echo '</tr>';
      }
      echo '<samp id="tdr" lang="' . count($lljj) . '"></samp>';
      ?>
    <tr>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
    </tr>
    <tr>
      <th scope="col">&nbsp;</th>
      <th scope="col">
        <input type="submit" name="button2" id="button2" value="Grabar" onclick="grabarrestricciones();">
        <input type="button" id="button" value="<-Regresar" onclick="makeRequestSP('listerestricciones.php');">

      </th>
    </tr>
  </table>


</div>

<script>
  Nifty('div#box3', 'big');
  var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {
    validateOn: ["blur", "change"],
    useCharacterMasking: true
  });
</script>