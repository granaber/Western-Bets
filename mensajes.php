<?php
require_once('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$msg = array();
$resultp = mysqli_query($GLOBALS['link'], "SELECT * FROM _tablademensajes ");
if (mysqli_num_rows($resultp) == 0) :
  $msg[0] = 'NaN';
  $msg[1] = 'Bienvenidos al SuperPool Hipico Web...';
else :
  $row2 = mysqli_fetch_array($resultp);
  $msg[0] = $row2['fecha'];
  $msg[1] = $row2['Mensaje'];
  $msg[2] = $row2['Mensajemcu'];
endif;



?>
<style type="text/css">
  <!--
  .Estilo1 {
    font-size: 18px;
    color: #FFFFFF;
  }
  -->
</style>

<div id="box5">
  <samp id='fecha' style="color:#CCCCCC" lang="<?php echo date("h_i_s A");  ?>"><?php echo date("h:i:s A");  ?></samp>
  <samp id='idmsj' lang="0"></samp>
  <table width="375" border="0" cellspacing="0">
    <tr>
      <th height="63" colspan="3" scope="col">
        <div align="center" class="Estilo1">Mensajes Online.</div>
      </th>
    </tr>
    <tr>
      <td height="142"><samp style="color:#FFFFFF">Informacion del Macuare:</samp></td>
      <td colspan="2"><textarea name="mnsg2" cols="50" rows="10" id="Mensajemcu"><?php echo $msg[2]; ?></textarea></td>
    </tr>
    <tr>
      <td width="66" height="142"><samp style="color:#FFFFFF">Editar Informacion Adicional:</samp></td>
      <td colspan="2">
        <textarea name="mnsg" cols="50" rows="10" id="Mensaje"><?php echo $msg[1]; ?></textarea>
      </td>
    </tr>
    <tr>
      <td height="108">&nbsp;</td>
      <td width="162"><samp id='estado'></samp></td>
      <td width="141">
        <input type="submit" name="button" id="button" value="Grabar Mensaje" onClick="grabar_cnf1(2,'idmsj.lang|fecha.lang|Mensaje.value|Mensajemcu.value','_tablademensajes',true);var today=new Date();$('fecha').lang=today.getSeconds(); ">
      </td>
    </tr>
  </table>
</div>
<script>
  Nifty('div#box5', 'big');
</script>