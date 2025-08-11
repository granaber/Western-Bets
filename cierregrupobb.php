<?php

require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

?>
<style type="text/css">
  <!--
  .Estilo1 {
    font-size: 24px
  }
  -->
</style>


<table width="1044" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="235">
    </td>
    <td width="809">
      <div id="tabs2">
        <ul>
          <?php
          $idj = $_REQUEST["idj"];
          $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _gruposdd where Estatus=1 Order by grupo");
          if (mysqli_num_rows($result) != 0) :
            while ($row3 = mysqli_fetch_array($result)) {
              $op = "'cierrbb.php?idg=" . $row3['Grupo'] . "&idj=" . $idj . "'";

              echo '<li><a href="javascript:tick(' . $op . ');" title="' . $row3['Descripcion'] . '"><span>' . $row3['Descripcion'] . '</span></a></li>';
            }
          endif;
          ?>


        </ul>
    </td>
  </tr>

  <tr>
    <td width="235">&nbsp;</td>
    <td>
      <div id="ticke">
        <div align="center" class="Estilo1">&quot;Seleccione el Juego a Cerrar&quot; </div>
      </div>
    </td>
  </tr>
</table>