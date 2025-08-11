<div id="box12">
  <?php

  $pfc = $_REQUEST['fc'];
  /* parametros de FC
fc = 0 ... Incluir
fc >= 1 ... Busca el registo para modificar o eliminar si existe */

  require('prc_php.php');
  $GLOBALS['link'] = Connection::getInstance();
  if ($pfc == 0) :

    $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tdjuegos Order by IDJug DESC ");
    $row = mysqli_fetch_array($result);
    if ($result) :
      $numero = $row["IDJug"] + 1;
    else :
      $numero = 1;
    endif;

    $jn = "";
    $fc = 1;
    $am = 1;
    $td = 1;
    $es = 1;
    $cl = "";
    $ce = 14;
    $cc = 6;
    $pos = 'N';
    $tc = '1';
    $tf = '1';
    $rps = 0;
    $op1 = 0;
    $op2 = 0;
    $op3 = 0;
    $porcent = 0;
  else :
    $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tdjuegos where IDJug=" . $pfc);
    $row = mysqli_fetch_array($result);
    $numero = $row["IDJug"];
    $jn = $row["Descrip"];
    $fc = $row["Multip"];
    $am = $row["ApuestaMinima"];
    $td = $row["Tandas"];
    $es = $row["Estatus"];
    $cl = $row["Color"];
    $ce = $row["EjemxCarr"];
    $cc = $row["CantidadCarr"];
    $rps = $row["relpos"];
    $op1 = $row["op1"];
    $op2 = $row["op2"];
    $op3 = $row["op3"];
    $porcent = $row["porc"];
    if ($row["Config"] != '') :
      $pos = substr($row["Config"], strlen($row["Config"]) - 1, 1);
    else :
      $pos = 'N';
    endif;
    $tc = $row["calculo"];
    $tf = $row["Formato"];
  endif;

  ?><table width="456" cellpadding="0" cellspacing="0">
    <tbody>
      <tr>
        <td>
          <table>
            <tbody>
              <tr>
                <td><span style="color:#5F92C1; font-size:16px" align="center"><strong>AGREGAR JUEGO</strong></span></td>
              </tr>
            </tbody>
          </table>

          <table border="0" cellpadding="2" cellspacing="1" width="100%">

            <tbody>

              <tr>
                <td width="25%"><span style="color:#FFFFFF"><strong>Código</strong></span></td>
                <td width="35%" id="numerJ" class="ta_conc_td" title="<?php echo $numero; ?>"><span id="IDJug" lang="<?php echo $numero; ?>" style="color: #FFFF00; font-size:16px"><strong><?php echo $numero; ?></strong></span></td>
              </tr>
              <tr>
                <td><span style="color:#FFFFFF"><strong>Nombre Juego</strong></span></td>
                <td><input id="juego_nombre" value='<?php echo $jn; ?>' onChange="validar(event);" onKeyUp="pulsart(event,'factor')" type="text" />
                  <font color="red"> * </font> <img id="imgjuego_nombre" src="media/tray_err.ico" style="display:none" title="" />
                </td>
              </tr>

              <tr>
                <td><span style="color:#FFFFFF"><strong>Factor <br />
                      Multiplicación</strong></span></td>
                <td><input id="factor" value="<?php echo $fc; ?>" onChange="validar(event);" onKeyUp="pulsart(event,'juego_apuesta_minima')" type="text" />
                  <font color="red"> * </font> <img id="imgfactor" src="media/tray_err.ico" style="display:none" title="" />
                </td>
              </tr>
              <tr>
                <td><span style="color:#FFFFFF"><strong>Apuesta Mínima</strong></span></td>
                <td><input id="juego_apuesta_minima" value="<?php echo $am; ?>" onChange="validar(event);" onKeyUp="pulsart(event,'cantidadcarrera')" type="text" />
                  <font color="red"> * </font> <img id="imgjuego_apuesta_minima" src="media/tray_err.ico" style="display:none" title="" />
                </td>
              </tr>

              <tr>
                <td><span style="color:#FFFFFF"><strong>Tandas</strong></span></td>
                <td><select id="juego_tandas" size="1" onkeyup="pulsart(event,'juego_nombre')">
                    <option value="1" <?php echo ($td == 1 ? " selected='selected'" : " "); ?>>No</option>
                    <option value="2" <?php echo ($td == 2 ? " selected='selected'" : " "); ?>>Si</option>
                  </select> </td>
              </tr>

              <tr>
                <td><span style="color:#FFFFFF"><strong>Proporcional</strong></span></td>
                <td><select id="juego_proporcional" size="1">
                    <option value="1">Si</option>
                    <option value="2">No</option>
                  </select></td>
              </tr>
              <tr>
                <td><span style="color:#FFFFFF"><strong>Cantidad de Carreras</strong></td>
                <td><input id="cantidadcarrera" value="<?php echo $cc; ?>" onChange="validar(event);" onKeyUp="pulsart(event,'cantidadejemp')" type="text" />
                  <font color="red">*</font>
                </td>
              </tr>
              <tr>
                <td><span style="color:#FFFFFF"><strong>Cantidad de Ejem. x Carreras</strong></td>
                <td><input id="cantidadejemp" value="<?php echo $ce; ?>" onChange="validar(event);" onKeyUp="pulsart(event,'juego_nombre')" type="text" />
                  <font color="red">*</font>
                </td>
              </tr>
              <tr>
                <td><span style="color:#FFFFFF"><strong>Configuracion</strong></td>
                <td>
                  <font color="red">
                    <select id="juego_conf" size="1">
                      <option value="U" <?php echo ($pos == 'U' ? " selected='selected'" : " "); ?>>Ultimas</option>
                      <option value="P" <?php echo ($pos == 'P' ? " selected='selected'" : " "); ?>>Primeras</option>
                      <option value="T" <?php echo ($pos == 'T' ? " selected='selected'" : " "); ?>>Todas</option>
                      <option value="N" <?php echo ($pos == 'N' ? " selected='selected'" : " "); ?>>N/A</option>
                    </select>
                  </font>
                </td>
              </tr>
              <tr>
                <td><span style="color:#FFFFFF"><strong>Estatus</strong></td>
                <td><select name="juego_estatus" size="1" id="juego_estatus">
                    <option value="1" <?php echo ($es == 1 ? " selected='selected'" : " "); ?>>Activo</option>
                    <option value="2" <?php echo ($es == 2 ? " selected='selected'" : " "); ?>>Suspendido</option>
                  </select></td>
              </tr>
              <tr>
                <td><span style="color:#FFFFFF"><strong>Forma de Calculo</strong></td>
                <td>
                  <select id="fdc">
                    <option value="1" <?php echo ($tc == 1 ? " selected='selected'" : " "); ?>>Multiplicacion x Carrera</option>
                    <option value="2" <?php echo ($tc == 2 ? " selected='selected'" : " "); ?>>Multiplicacion x Ejemplar</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td><span style="color:#FFFFFF"><strong>Formato</strong></td>
                <td>
                  <select id="frm">
                    <option value="1" <?php echo ($tf == 1 ? " selected='selected'" : " "); ?>>Estandar (Ejemplar/Valida)</option>
                    <option value="2" <?php echo ($tf == 2 ? " selected='selected'" : " "); ?>>Por Carrera o Tanda</option>
                    <option value="3" <?php echo ($tf == 3 ? " selected='selected'" : " "); ?>>Dos Tanda o Carrera</option>
                    <option value="4" <?php echo ($tf == 4 ? " selected='selected'" : " "); ?>>Por Apuesta</option>
                    <option value="5" <?php echo ($tf == 5 ? " selected='selected'" : " "); ?>>Tablas</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td><span style="color:#FFFFFF"><strong>Posición Relacion </strong></td>
                <td><select name="select2" size="1" id="relpos">';
                    <?php
                    $result2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tdjuegos order by relpos ASC");
                    $i = 1;
                    while ($row2 = mysqli_fetch_array($result2)) {
                      $x = $row2["relpos"];
                      if ($x > 0) :
                        $rp[$i] = $x;
                        $i++;
                      endif;
                    }
                    $result3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tdjuegos order by IDJug");
                    $rp[$i] = 0;
                    $x = 1;
                    $j = 1;
                    $n = 1;

                    while ($row3 = mysqli_fetch_array($result3)) {
                      if ($j != $rp[$x]) :
                        $rpos[$n] = $j;
                        $j++;
                        $n++;
                      else :
                        $x++;
                        $j++;
                      endif;
                    }
                    $result4 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tdjuegos order by IDJug");
                    $t = $n;
                    $n = 1;
                    $i = 1;
                    $x = 0;
                    while ($row4 = mysqli_fetch_array($result4)) {
                      if ($n == $rps) {
                        echo "<option " . ($rps == $row4["IDJug"] ? " selected='selected'" : " ") . " value=" . $row4["IDJug"] . ">" . $row4["IDJug"] . "</option>";
                      } elseif ($x == 0) {
                        echo "<option>0</option>";
                        $x = -1;
                      }
                      if ($i < $t) :
                        if ($n == $rpos[$i]) {
                          echo "<option " . ($rps == $row4["IDJug"] ? " selected='selected'" : " ") . " value=" . $row4["IDJug"] . ">" . $row4["IDJug"] . "</option>";
                          $n++;
                          $i++;
                        } else {
                          $n++;
                        }
                      endif;
                    }
                    ?></select>
                </td>
              </tr>
              <tr>
                <td><span style="color:#FFFFFF"><strong>Color</strong></td>
                <td>
                  <form>
                    <div style="width:103px;width/* */:/**/100px;width: /**/100px;height:20px;border:1px solid #7F9DB9;">
                      <input type="text" id="color" maxlength="7" value="<?php echo $cl; ?>" style="width:80px;font-size:12px;height:17px;float:left;border:0px;padding-top:2px" name="rgb" size="10" />
                      <img style="float:right;padding-right:1px;padding-top:1px" src="images/select_arrow.gif" onMouseOver="this.src='images/select_arrow_over.gif'" onmouseout="this.src='images/select_arrow.gif'" onClick="showColorPicker(this,document.forms[0].rgb)" />
                    </div>
                  </form>
                </td>
              </tr>
            </tbody>
          </table>
          <p>
            <?php
            if (!$pfc == 0) :
              echo  "<input id='btnguardar'  value='Modificar' type='submit'  onclick='grabar_datosJuego();'/>";
              echo  "<input id='btneliminar'  value='Eliminar Juego' type='submit'  onclick='elimnar_datosJuego();'/>";
            else :
              echo  "<input id='btnguardar'  value='Guardar Nuevo Juego' type='submit'  disabled='disabled'  onclick='grabar_datosJuego();'/>";
            endif;
            ?>
            <input name="submit_regresar" value="<-Volver" title="<?php echo $pfc; ?> " onClick="javascript:makeRequestHIPI('agregarjuego-1-1.php');" type="button" />
          </p>
        </td>
      </tr>
      <tr>
        <td height="8"></td>
      </tr>
    </tbody>
  </table>
</div><br /><br /><br />

<div id="box15">
  <table width="536" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td colspan="2"><span style="color: #FFFF00; font-size:16px" align="center"><strong>Configuracion del Juego para el Escrute</strong></span> </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><span style="color: #FFFFFF; font-size:14px">Numero de Puestos a Escrutar </span></td>
      <td>
        <div id="box13" style="width:310px"> <span style="color: #0099CC; font-size:14px">No Ejem.:</span><span id="sprytextfield1">
            <input id="NumeroEje" type="text" size="3" maxlength="3" />
            <span class="textfieldInvalidFormatMsg">Formato no válido.</span></span>&nbsp;&nbsp;<span style="color: #0099CC; font-size:14px">Escrutar:</span><span id="sprytextfield2">
            <input id="NumeroPuesto" type="text" size="3" maxlength="3" />
            <span class="textfieldInvalidFormatMsg">Formato no válido.</span></span>&nbsp; <span style="color: #0099CC; font-size:14px">Puesto</span>&nbsp;<img src="media/edit_icon.gif" onclick="grabar_cnf1(6,'IDJug.lang|NumeroEje.value|NumeroPuesto.value','_tdjuegos_escrute',true);makeResultwin('agregarjuego-1-3.php?idjug=<? echo $numero; ?>','esc');$('NumeroEje').value='';$('NumeroPuesto').value='';" /><br />
          <br />
          <div id="esc">
            <? include('agregarjuego-1-3.php'); ?>
          </div>
      </td>
    </tr>
    <tr>
      <td width="164">
        <div align="justify" style="color: #FFFFFF; font-size:14px">% a Acumular</div>
      </td>
      <td width="372"><span id="sprytextfield3">
          <input id="porcent" type="text" size="3" maxlength="3" value="<?php echo $porcent; ?>" /><span align="justify" style="color: #FFFFFF; font-size:14px">%</span>
          <span class="textfieldInvalidFormatMsg">Formato no válido.</span><span class="textfieldMaxValueMsg">El valor introducido es superior al máximo permitido.</span></span></td>
    </tr>
    <tr>
      <td width="164">
        <div align="justify" style="color: #FFFFFF; font-size:14px">Repatir Acumulado en Caso de no haber Premios</div>
      </td>
      <td width="372"><input id="op1" type="checkbox" <? if ($op1 == 1) : echo 'checked="checked"';
                                                      endif; ?> /></td>
    </tr>
    <tr>
      <td width="164">
        <div align="justify" style="color: #FFFFFF; font-size:14px">Calcular Factor</div>
      </td>
      <td width="372"><input id="op2" type="checkbox" <? if ($op2 == 1) : echo 'checked="checked"';
                                                      endif; ?> /></td>
    </tr>
    <tr>
      <td width="164">
        <div align="justify" style="color: #FFFFFF; font-size:14px">Calcular Dividendo</div>
      </td>
      <td width="372"><input id="op3" type="checkbox" <? if ($op3 == 1) : echo 'checked="checked"';
                                                      endif; ?> /></td>
    </tr>
  </table>

</div>

<script>
  Nifty('div#box12', 'big');
  Nifty('div#box15', 'big');
  Nifty('div#box13', 'big');
  new xTabPanelGroup('tpg2', 310, 150, 0, 'tabPanel', 'tabGroup', 'tabDefault', 'tabSelected');
  var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {
    validateOn: ["blur", "change"],
    useCharacterMasking: true,
    isRequired: false
  });
  var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "integer", {
    useCharacterMasking: true,
    validateOn: ["blur", "change"],
    isRequired: false
  });
  var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "integer", {
    minValue: 0,
    maxValue: 100,
    useCharacterMasking: true,
    validateOn: ["blur", "change"],
    isRequired: false
  });
</script>