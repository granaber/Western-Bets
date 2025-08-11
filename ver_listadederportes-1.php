<?php
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$descripcion = '';
$fle = '';
$est = 1;

if (!isset($_GET['grupo'])) :
  $resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _gruposdd Order by Grupo Desc");
  if (mysqli_num_rows($resultj) != 0) :
    $rowj = mysqli_fetch_array($resultj);
    $idg = $rowj["Grupo"] + 1;
  else :
    $idg = 1;
  endif;
else :
  $idg = $_REQUEST['grupo'];
  $resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _gruposdd where Grupo=" . $idg);
  $rowj = mysqli_fetch_array($resultj);
  $descripcion = $rowj['Descripcion'];
  $fle = $rowj['imagen'];
  $est = $rowj['Estatus'];
endif;
$ncl = $idg;
$ncl = str_repeat("0", 8 - strlen($ncl)) . $ncl;


?>
<div id="box7">
  <table width="416" border="0">
    <tr>
      <th colspan="2" scope="col">Deportes</th>
      <th scope="col"><samp id='estado'></samp></th>
    </tr>
    <tr>
      <td width="126">No. </td>
      <td width="229"> <samp id="Grupo" lang="<?php echo $idg; ?>" style="color:#0000FF; font-size:14px; "><strong><?php echo $ncl; ?></strong></samp></td>
      <td width="47"><img id="imgdp" src="media/<?php echo $fle; ?>" height="64" width="76" />&nbsp;</td>
    </tr>
    <tr>
      <td>Descripcion</td>
      <td>
        <input type="text" name="textfield" id="Descripcion" value="<?php echo $descripcion; ?>" />
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Imagen a Mostrar</td>
      <td>
        <form id="fromiut" method="post" enctype="multipart/form-data" action="controlUpload2.php" target="iframeUpload">
          <input name="fileUpload" type="file" id="imagen" lang="<?php echo $fle; ?>" onchange="uploadFile(this);"><iframe name="iframeUpload" style="display:none"></iframe>
        </form>
      </td>
      <td>&nbsp;</td>
    </tr>
  </table>

</div>
<p>&nbsp;</p>
<div id="box8">
  <table width="500" border="0">
    <tr>
      <th width="274" scope="col">
        <input type="submit" name="button2" id="button2" onclick="opmenu('ver_listadederportes.php');" value="<--Regresar" />

      </th>
      <th width="216" colspan="3" scope="col">
        <div align="right">
          <input id="Estatus" value="<?php echo $est; ?>" style="display:none" />
          <input type="submit" name="button" id="button" value="Grabar" onclick="grabar_cnf1(2,'Grupo.lang|Descripcion.value|Estatus.value|imagen.lang','_gruposdd',true);" />
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