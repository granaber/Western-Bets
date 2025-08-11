 <?php
  require('prc_php.php');
  $GLOBALS['link'] = Connection::getInstance();

  $fecha = date('d/n/Y');


  ?>
 <div id="box1" style="background: #333333; width:450px">


   <table width="449" border="0" cellspacing="0">
     <tr>
       <th colspan="4">
         <div align="center" style="color:#FFFFFF; font-size:14px">Cierre</div>
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
       <td width="118" align="center" valign="top">
         <div id="selej" style="color:#FFFFFF; font-size:12px"><strong>Jornada:</strong>
           <select id="sjornada">
             <?
              $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfjornada where fecha='" . $fecha . "'");
              if (mysqli_num_rows($result) != 0) :
                while ($row = mysqli_fetch_array($result)) {
                  echo "<option value='" . $row['IDCN'] . "'>" . $row['IDCN'] . "</option>";
                }
              endif;
              ?>
           </select>
         </div>
       </td>
       <td><input type="submit" name="Submit3" value="Buscar" onClick="  $('btncierre').style.display=''; datoscierresph();" /></td>
       <td><input type="submit" id="btncierre" value="Activar Cierre" lang="2" onClick="btnstopsph();" style="display:none" /></td>
     </tr>
   </table>
   <div id='lganadores' title="">
   </div>

 </div>
 <div id='ver'> </div>


 <script>
   Nifty('div#box1');
 </script>