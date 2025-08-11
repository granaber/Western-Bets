 <?php
  require('prc_php.php');
  $GLOBALS['link'] = Connection::getInstance();

  $fecha = date('d/n/Y');


  ?>
 <div id="box1" style="background: #333333; ">


   <table width="449" border="0" cellspacing="0">
     <tr>
       <th colspan="4">
         <div align="center" style="color:#FFFFFF; font-size:14px">Dividendos y Llegadas</div>
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

       <td><input type="submit" name="Submit3" value="Buscar" onClick=" makeResultwin('dividendosHI.php?fecha='+$('fc').value,'tablemenu');" /></td>

     </tr>
   </table>



   <script>
     Nifty('div#box1');
   </script>