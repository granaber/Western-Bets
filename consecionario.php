 <?php

  $pfc = $_REQUEST['fc'];
  /* parametros de FC
fc = 0 ... Incluir
fc >= 1 ... Busca el registo para modificar o eliminar si existe */

  require('prc_php.php');
  $GLOBALS['link'] = Connection::getInstance();


  if (isset($_REQUEST['idt'])) :
    $idt = $_REQUEST['idt'];
    $accesogp = accesolimitado($idt);
  else :
    $accesogp = 0;
  endif;

  if ($pfc == 0) :

    $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionario Order by IDRow DESC ");
    $row = mysqli_fetch_array($result);

    if (mysqli_num_rows($result) != 0) :
      $idr = $row["IDRow"] + 1;
    else :
      $idr = 1;
    endif;

    $idc = "";
    $nm = "";
    $dr = "";
    $est = "";
    $mup = "";
    $tel = "";
    $idg = "";
    $es = 1;
    $email = "";
    $cel = "";
    $resp = "";
    $tb = 0;
    $idm = 1;
  else :
    $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionario where IDRow=" . $pfc);
    $row = mysqli_fetch_array($result);
    $idr = $row["IDRow"];
    $idc = substr($row["IDC"], 0, strlen($row["IDC"]) - 1);
    $nm = $row["Nombre"];
    $dr = $row["Direccion"];
    $est = $row["Estado"];
    $mup = $row["Municipio"];
    $tel = $row["Telefono"];
    $idg = $row["IDG"];
    $es = $row["Estatus"];

    $email = $row["email"];
    $cel = $row["celular"];
    $resp = $row["Responsable"];
    $tb = $row["tb"];
    $idm = $row["idm"];

  endif;

  ?>
 <div id="fromConcesionario" style="background:#BAC6D8; height:1000px">
   <div align="center">
     <spam class="Estilo41"> DATOS DEL CONSECIONARIO </spam>
   </div>
   <table width="371" cellpadding="0" cellspacing="5">
     <tbody>
       <tr class="tr_cont_centro">
         <td width="362">
           <br />
           <table class="ta_conc" border="0" cellpadding="0" cellspacing="0" width="100%">

             <tbody>


               <tr class="ta_conc_tr" title="">
                 <td width="20%" class="Estilolg" style="font-size:16px"><strong>Codigo</strong></td>
                 <td colspan="2" style="color:#FF0000; font-size:16px" id="n_idr" title="<?php echo $idr; ?>"><strong><?php echo $idr; ?></strong></td>
               </tr>
               <tr>
                 <td class="Estilolg">Letra</td>
                 <td width="43%" class="ta_conc_td"><input name="text4" type="text" id="c_idc" onKeyUp="this.value = this.value.toUpperCase(); pulsart(event,'nombre'); validar2(event); " value='<?php echo $idc; ?>' onkeypress="if (permite(event,'num_car2')) {return true;}else{return false;}" />
                   <font color="red">*</font>
                   <img id="imgc_idc" src="media/tray_err.ico" style="display:none" title="" />
                 </td>
                 <td width="37%" align="center" valign="middle" class="ta_conc_td"><label id="nomidcn" style="font-size:14px"><?php echo $idc . '' . $idg; ?> </label></td>
               </tr>

               <tr>
                 <td class="Estilolg">Nombre</td>
                 <td colspan="2" class="ta_conc_td"><input name="text5" type="text" id="nombre" onChange="validar2(event);" onkeyup="pulsart(event,'direccion'); validar2(event);" value='<?php echo $nm; ?>' onkeypress="this.value = this.value.toUpperCase();" />
                   <font color="red"> *</font>
                   <img id="imgnombre" src="media/tray_err.ico" style="display:none" title="" />
                 </td>
               </tr>
               <tr>
                 <td class="Estilolg">Dirección</td>
                 <td colspan="2" class="ta_conc_td"><input name="text4" type="text" id="direccion" onChange="validar2(event);" onkeyup="pulsart(event,'estado'); validar2(event);" value='<?php echo $dr; ?>' />
                   <font color="red">*</font>
                   <img id="imgdireccion" src="media/tray_err.ico" style="display:none" title="" />
                 </td>
               </tr>

               <tr>
                 <td class="Estilolg">Estado</td>
                 <td colspan="2" class="ta_conc_td"><input name="text3" type="text" id="estado" onChange="validar2(event);" onkeyup="pulsart(event,'municipio'); validar2(event);" value='<?php echo $est; ?>' />
                   <font color="red">*</font>
                   <img id="imgestado" src="media/tray_err.ico" style="display:none" title="" />
                 </td>
               </tr>

               <tr>
                 <td class="Estilolg">Municipio</td>
                 <td colspan="2" class="ta_conc_td"><input name="text2" type="text" id="municipio" onChange="validar2(event);" onkeyup="pulsart(event,'cel'); validar2(event);" value='<?php echo $mup; ?>' />
                   <font color="red">*</font>
                   <img id="imgmunicipio" src="media/tray_err.ico" style="display:none" title="" />
                 </td>
               </tr>


               <tr>
                 <td class="Estilolg">Tabla(LG)</td>
                 <td colspan="2" class="ta_conc_td"><select id="tbl">
                     <option value="0" <? if ($tb == 0) echo " selected='selected'"; ?>>No Aplica</option>
                     <option value="1" <? if ($tb == 1) echo " selected='selected'"; ?>>20cnt</option>
                     <option value="2" <? if ($tb == 2) echo " selected='selected'"; ?>>30cnt</option>
                     <option value="3" <? if ($tb == 3) echo " selected='selected'"; ?>>40cnt</option>
                   </select></td>
               </tr>
               <tr>
                 <td class="Estilolg">Grupo</td>
                 <td colspan="2" class="ta_conc_td"><select name="select2" size="1" id="grupo" onChange="cambiar_grupo(); validar2(event);">
                     <?php

                      if ($accesogp == 0) :
                        $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tgrupo order by IDG ");
                      else :
                        $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tgrupo where IDG in (" . $accesogp . ") order by IDG ");
                      endif;
                      while ($row = mysqli_fetch_array($result)) {
                        if ($row["Estatus"] < 2) :
                          echo "<option " . ($idg == $row["IDG"] ? " selected='selected'" : " ") . " value=" . $row["IDG"] . ">" . $row["IDG"] . "</option>";
                        endif;
                      }
                      ?>
                   </select></td>
               </tr>
               <tr>
                 <td class="Estilolg">Moneda:</td>
                 <td colspan="2" class="ta_conc_td">
                   <select name="select" size="1" id="moneda">
                     <?
                      $result = mysqli_query($GLOBALS['link'], "SELECT * FROM sbmonedas  order by id ");
                      while ($row = mysqli_fetch_array($result))
                        echo "<option " . ($idm == $row["id"] ? " selected='selected'" : " ") . " value=" . $row["id"] . ">" . $row["moneda"] . "-" . $row["descripcion"] . "</option>";
                      ?>
                   </select>
                 </td>
               </tr>
               <tr>
                 <td class="Estilolg">Estatus</td>
                 <td colspan="2" class="ta_conc_td"><select name="select" size="1" id="estatus">
                     <option value="1" <?php echo ($es == 1 ? " selected='selected'" : " "); ?>>Activo</option>
                     <option value="2" <?php echo ($es == 2 ? " selected='selected'" : " "); ?>>Suspendido</option>
                   </select></td>
               </tr>
             </tbody>
           </table>
           <p>
           </p><br>
           <font color="red">*</font>= Campos Obligatorios
         </td>
       </tr>
     </tbody>
   </table>

   <div id="box7" style="width:290px; position:absolute; top:42px; left:343px; background: #036">
     <table width="335" cellpadding="0" cellspacing="0">
       <tr>
         <td height="26" colspan="3" class="Estilolg" style="color: #FC0">
           <div align="center">Informacion del Consecionario</div>
         </td>
       </tr>
       <tr class="ta_conc">
         <td class="Estilolg" style="color:#FFF">Celular</td>
         <td colspan="2" class="ta_conc_td"><input type="text" id="cel" value='<?php echo $cel; ?>' onkeyup="pulsart(event,'telefono');" /></td>
       </tr>
       <tr class="ta_conc">
         <td class="Estilolg" style="color:#FFF">Telefono fijo</td>
         <td colspan="2" class="ta_conc_td"><input type="text" id="telefono" value='<?php echo $tel; ?>' onKeyUp="pulsart(event,'email');" /></td>
       </tr>
       <tr>
         <td class="Estilolg" style="color:#FFF">Email</td>
         <td colspan="2" class="ta_conc_td"><input type="text" id="email" value='<?php echo $email; ?>' onkeyup="pulsart(event,'resp');" />
           <img id="imgtelefono" src="media/tray_err.ico" style="display:none" title="" />
         </td>
       </tr>
       <tr>
         <td class="Estilolg" style="color:#FFF">Contacto</td>
         <td><span class="ta_conc_td">
             <input type="text" id="resp" value='<?php echo  $resp; ?>' />
           </span></td>
       </tr>
     </table>
   </div>
 </div>
 <script>
   function clicktoolBar(id) {
     switch (id) {
       case "Cerrar_":
         dhxWins1.window("w1").close();
         makeRequest('consecionario-1-1.php');
         break;
       case "Guardar_":
         grabar_consecionario();
         break;
       case "Eliminar_":
         elimnar_consecionario();
         break;
     }
   }
   dhxWins1 = new dhtmlXWindows();
   dhxWins1.setImagePath("codebase/imgs/");
   w1 = dhxWins1.createWindow("w1", 300, 255, 730, 370);
   w1.setText('Concesionario');
   w1.attachObject('fromConcesionario');
   dhxWins1.window("w1").button('close').hide();
   dhxWins1.window("w1").button('minmax1').hide();
   dhxWins1.window("w1").button('minmax2').hide();
   dhxWins1.window("w1").button('park').hide();
   dhxWins1.window("w1").denyResize();
   dhxWins1.window("w1").denyMove();
   dhxWins1.window('w1').setModal(true);
   dhxWins1.window('w1').centerOnScreen();
   var bar = w1.attachToolbar();
   bar.addButton("Cerrar_", 4, "Volver", "images/redo.gif", "images/redo.gif");
   <? if (!$pfc == 0) : ?>
     bar.addButton("Guardar_", 1, "Guardar Concesionario", "media/users.png", "media/users.png");
     bar.addButton("Eliminar_", 3, "Eliminar Concesionario", "images/sample_close.gif", "images/sample_close.gif");
   <? else : ?>
     bar.addButton("Guardar_", 1, "Guardar Nuevo Concesionario", "media/users.png", "media/users.png");
   <? endif; ?>
   bar.attachEvent("onClick", clicktoolBar);
 </script>