<?php
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$descripcion = '';
$ops = 1;

if (!isset($_GET['grupo'])) :
  $resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _formatosbb Order by Formato Desc");
  if (mysqli_num_rows($resultj) != 0) :
    $rowj = mysqli_fetch_array($resultj);
    $idg = $rowj["Formato"] + 1;
  else :
    $idg = 1;
  endif;
else :
  $idg = $_REQUEST['grupo'];
  $resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _formatosbb where Formato=" . $idg);
  $rowj = mysqli_fetch_array($resultj);
  $descripcion = $rowj['Descripcion'];
  $ops = $rowj['Grupo'];

endif;
$ncl = $idg;
$ncl = str_repeat("0", 8 - strlen($ncl)) . $ncl;


?>
<div id="box7">
  <table width="445" border="0">
    <tr>
      <th colspan="4" scope="col">Grupos de Jugadas<samp id='estado'></samp></th>
    </tr>
    <tr>
      <td width="120">No. Formato</td>
      <td colspan="2"> <samp id="Formato" lang="<?php echo $idg; ?>" style="color: #FF0000; font-size:16px; "><strong><?php echo $ncl; ?></strong></samp></td>
      <td width="87">&nbsp;</td>
    </tr>
    <tr>
      <td>Descripcion</td>
      <td colspan="2">
        <input type="text" name="textfield" id="Descripcion" value="<?php echo $descripcion; ?>" />
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Pertenece al Deporte:</td>
      <td colspan="2"><select name="Grupo" id="Grupo">
          <option value=0>No Aplica</option>
          <?php
          $resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _gruposdd Order by grupo ");
          while ($row = mysqli_fetch_array($resultj)) {
            if ($ops == $row['Grupo']) :
              $secc = 'selected="selected"';
            else :
              $secc = '';
            endif;
            echo "<option  value=" . $row["Grupo"] . " " . $secc . " >" . $row["Descripcion"] . "</option>";
          }
          ?>
        </select></td>
      <td>&nbsp;</td>
    </tr>


    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>

</div>
<p>&nbsp;</p>
<div id="box8">
  <table width="500" border="0">
    <tr>
      <th width="274" scope="col">
        <input type="submit" name="button2" id="button2" onclick="opmenu('ver_gruposdejugada.php');" value="<--Regresar" />

      </th>
      <th width="216" colspan="3" scope="col">
        <div align="right">
          <input type="submit" name="button" id="button" value="Grabar" onclick="grabar_cnf1(2,'Formato.lang|Descripcion.value|Grupo.value','_formatosbb');" />
        </div>
      </th>
    </tr>
  </table>
</div>
<p>&nbsp;</p>
<script>
  Nifty('div#box7', 'big');
  Nifty('div#box8', 'big');
</script>