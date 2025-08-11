<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
?>
<div id="box4" style="background: #333">
  <table width="449" border="0" cellspacing="0">
    <tr>
      <th colspan="4">
        <div align="center" style="color:#FFFFFF; font-size:14px">Winners/PastPerform/Resultados</div>
      </th>
      <th>
        <div id="ver" align="center" style="color: #F90; font-size:10px"></div><img id="pro" src="media/proceso.gif" width="16" height="16" style="display:none" />
      </th>
    </tr>
    <tr>
      <th width="43">
        <div align="center" style="color:#FFFFFF; font-size:12px"><strong>Fecha:</strong></div>
      </th>
      <td width="72"><input name="fc" type="text" id="fc" onFocus="cargarcampos3();" size="10" value="<? echo  $fecha; ?>" /> </td>

      <td><input type="submit" name="Submit3" value="Buscar" onClick="  MakeRespK1('fromWinnersResultados-1.php?fecha='+$('fc').value,'respuestaPDF');" /></td>

    </tr>
  </table>

</div>
<div id="respuestaPDF"></div>

<script>
  Nifty('div#box4', 'big');
</script>