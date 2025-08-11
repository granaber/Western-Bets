<?
/*session_start();
if ($_SESSION['ejecutado']!==md5('O9plm1m91lk')):  echo 'ACCESO NEGADO/ACCESS DENIED/Zugriff verweigert'; exit; else: $_SESSION['ejecutado']=0;  endif;
*/ ?>

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

  .Estilo3 {
    color: #000000
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
$idc = $_REQUEST['idc'];
?>
<br>
<br>

<div id="box16" style="width:300px">
  <table width="292" height="145" border="0">
    <tr>
      <th height="27" colspan="2" align="center" bgcolor="#333333" scope="col">
        <div align="center"><span class="Estilo2">Imprimir Logros</span></div>
      </th>
    </tr>
    <tr>
      <th height="30" scope="col"><span style="color:#FFFFFF">Indique la Fecha:</span></th>
      <th width="129" scope="col"><input class="input-pv-standard" name="fc" type="text" id="fc" lang="<?php echo $idj; ?>" onfocus="camposImpLog();" size="10" value="<?php echo $fc; ?>" /></th>
    </tr>
    <tr>
      <th height="28" scope="col"><span style="color:#FFFFFF">Seleccione el Grupo:</span></th>
      <th scope="col">
        <div id='verligrup'>
          <? include "logrosimprimirNK.php" ?>
        </div>
      </th>
    </tr>
    <tr>
      <th scope="col"><span style="color:#FFFFFF">Salida por:</span></th>
      <th scope="col"><select class="select-pv-standard" id="salida">
          <option value="1">Impresora</option>
          <option value="2">Tickera</option>
        </select></th>
    </tr>
    <? if ($idc == -2 || $idc == -1) : ?>
      <tr>
        <th scope="col"><span style="color:#FFFFFF; font-size:12px">Indique la Banca:</span></th>
        <th scope="col"> <select class="select-pv-standard" name="select2" id="IDB">
            <?
            $result_g = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbanca Order by IDB ");
            while ($row_g = mysqli_fetch_array($result_g)) {
              if ($row_g['Estatus'] == 1) :
                echo "<div id='tpg_" . $row_g['IDB'] . "'  style='height:430px; '>";
                echo '<option value="' . $row_g['IDB'] . '">' . $row_g['IDB'] . '-' . $row_g['NombreB'] . '</option>';
              endif;
            }
            ?>
          </select></th>
      </tr>
    <? else :

      if ($idc == -4) :
        $idusu = $_REQUEST['idt'];
        $IDB = WhatBancaByUsuario($idusu);
      else :
        $IDB = WhatBanca($idc);
      endif;
    ?>
      <input id="IDB" type="text" value="<? echo  $IDB; ?>" style="display:none" />
    <? endif; ?>
    <tr>
      <th scope="col"><input class="button-pv-standard" type="submit" id='btncargar' value="Imprimir" onclick="imprimirlogro($('totalg').lang);" /><input id="cant_p" type="text" style="display:none" />
      </th>
      <th scope="col">&nbsp;</th>
    </tr>
  </table>

  <div id='coc'></div>
  <div id='vista2k'></div>
</div>


<script>
  Nifty('div#box16', 'big');
</script>