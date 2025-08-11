<style type="text/css">
  .shadowcontainerx {
    width: 310px;
    /* container width*/
    background-color: #d1cfd0;
  }

  .shadowcontainerx .innerdivx {
    /* Add container height here if desired */
    background-color: white;
    border: 1px solid gray;
    padding: 6px;
    position: relative;
    left: -5px;
    /*shadow depth*/
    top: -5px;
    /*shadow depth*/
  }

  .Estilo2 {
    color: #FFFFFF
  }
</style>
<?php
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$fc = $_REQUEST["fc"];
$idj = 0;
$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _jornadabb where Fecha='" . $fc . "'");
if (mysqli_num_rows($resultj) != 0) :
  $rowj = mysqli_fetch_array($resultj);
  $idj = $rowj["IDJ"];
  $cant = $rowj["Partidos"];
endif;

?>
<br>
<br>
<div id='box1' style="color:#3399CC; width:300px">
  <table border="0" width="299px">
    <tr>
      <th height="27" colspan="2" align="center" bgcolor="#333333" scope="col">
        <div align="center"><span class="Estilo2">Cierre de Jugada</span></div>
      </th>
    </tr>
    <tr>
      <th height="30" scope="col"><span style="color:#FFCC00; font-size:11px">Fecha:</span></th>
      <th width="129" scope="col" align="left"><input name="fc" type="text" id="fc" lang="<?php echo $idj; ?>" onfocus="cargarcampos6();" size="10" value="<?php echo $fc; ?>" /></th>
    </tr>
    <tr>
      <th height="28" scope="col"></th>
      <th scope="col" align="left">



      </th>
    </tr>
    <tr>
      <th colspan="2" scope="col"><input type="submit" id='btncargar' value="Cargar" onclick="cargarcierre()" /><input id="cant_p" type="text" style="display:none" /></th>
    </tr>
  </table>
</div>
</<br />
<br />

<div id='coc'>
</div>
<script>
  Nifty('div#box1', 'big');
</script>