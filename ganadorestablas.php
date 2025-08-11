 <?php
  date_default_timezone_set('America/Caracas');
  require('prc_php.php');
  $GLOBALS['link'] = Connection::getInstance();

  $fecha = date('d/n/Y');


  ?>
 <div id="box1" style="background: #333333; width:405px">


   <table width="400" border="0" cellspacing="0">
     <tr>
       <th colspan="3">
         <div align="center" style="color:#FFFFFF; font-size:14px"> Ganadores para las TABLAS</div>
       </th>
       <th>
         <div id="ver" align="center" style="color: #F90; font-size:9px"></div>
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
       <td width="159"><input type="submit" name="Submit3" value="Buscar" onClick="datosganadorestabla();" /></td>
     </tr>
   </table>
   <div id='lganadores' title="">
   </div>

 </div>
 <div id='ver'> </div>


 <script>
   Nifty('div#box1');
 </script>