<?php
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$descripcion = '';
$ops = 1;
$ops1 = 1;
$fdg = 1;
$mi = 0;
$mx = 0;
$opc = 'i';
$cb = '';
$clm = '';
$tdy = '';
$tdt = '';
$adt = '';
$tmc = 0;
$tdr = '';
$txr = '';
$eta = 1;
$ImpreTK = 0;
$tablaID = 0;
$procesoescrute = 0;
$logrosxdefecto = '';
if (!isset($_GET['grupo'])) :
  $resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbjuegodd Order by IDDD Desc");
  if (mysqli_num_rows($resultj) != 0) :
    $rowj = mysqli_fetch_array($resultj);
    $idg = $rowj["IDDD"] + 1;
  else :
    $idg = 1;
  endif;
else :
  $idg = $_REQUEST['grupo'];
  $resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbjuegodd where IDDD=" . $idg);
  $rowj = mysqli_fetch_array($resultj);
  $descripcion = $rowj['Descripcion'];
  $ops = $rowj['Grupo'];
  $ops1 = $rowj['Formato'];
  $fdg = $ops;
  $mi = $rowj['Minimas'];
  $mx = $rowj['Maximas'];
  $opc = $rowj['Opcion'];
  $cb = $rowj['noCombinar'];
  $clm = $rowj['Columnas'];
  $tdy = $rowj['TDisplay'];
  $tdt = $rowj['Tituloticket'];
  $adt = $rowj['AddTicket'];
  $tmc = $rowj['tmc'];
  $tdr = $rowj['reporte'];
  $txr = $rowj['textorfila'];
  $eta = $rowj['Estatus'];
  $ImpreTK = $rowj['ImpreTK'];
  $procesoescrute = $rowj['procesoescrute'];
  $logrosxdefecto = $rowj['logrosxdefecto'];
  $tablaID = $rowj['tabla'];
endif;
$ncl = $idg;
$ncl = str_repeat("0", 8 - strlen($ncl)) . $ncl;



?>
<style type="text/css">
  <!--
  .Estilo1 {
    color: #FFFF33
  }
  -->
</style>


<div id="box9" style="width:824px">
  <table width="823" border="0">
    <tr>
      <th colspan="5" scope="col">Configuracion de Juegos</th>
      <th scope="col" align="left"><samp id='estado'></samp></th>
    </tr>
    <tr>
      <td width="159">Id</td>
      <td colspan="2"> <samp id="IDDD" lang="<?php echo $idg; ?>" style="color: #FF0000; font-size:16px; "><strong><?php echo $ncl; ?></strong></samp></td>
      <td width="33">&nbsp;</td>
      <td width="129">&nbsp;</td>
      <td width="249">&nbsp;</td>
    </tr>
    <tr>
      <td>Descripcion</td>
      <td colspan="2">
        <input type="text" name="textfield" id="Descripcion" value="<?php echo $descripcion; ?>" />
      </td>
      <td>&nbsp;</td>
      <td colspan="2" bgcolor="#666666" style="border:#666666">
        <div align="center" style="color:#FFFFFF; font-size:16px">Configuracion de Sistema*</div>
      </td>
    </tr>
    <tr>
      <td>Pertenece al Deporte:</td>
      <td colspan="2"><select name="Grupo" id="Grupo" onchange="vista_jnc(this,<?php echo $idg; ?> );">
          <?php
          $resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _gruposdd Order by grupo ");
          while ($row = mysqli_fetch_array($resultj)) {
            if ($ops == $row['Grupo']) :
              $secc = 'selected="selected"';
            else :
              $secc = '';
            endif;
            echo "<option  value=" . $row["Grupo"] . " " . $secc . " >" . $row["Descripcion"] . "</option>";
          }
          ?>
        </select></td>
      <td>&nbsp;</td>
      <td bgcolor="#999999">
        <div align="right">Columnas (Datos):</div>
      </td>
      <td bgcolor="#999999"><input type="text" id="Columnas" value="<?php echo $clm; ?>" /> </td>
    </tr>
    <tr>
      <td>Asociado al Formato:</td>
      <td colspan="2">
        <div id='asf'><select name="Formato" id="Formato">
            <?php
            $resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _formatosbb where Grupo=" . $ops . " Order by formato ");
            while ($row = mysqli_fetch_array($resultj)) {
              if ($ops1 == $row['Formato']) :
                $secc = 'selected="selected"';
              else :
                $secc = '';
              endif;
              echo "<option  value=" . $row["Formato"] . " " . $secc . " >" . $row["Descripcion"] . "</option>";
            }
            ?>
          </select></div>
      </td>
      <td>&nbsp;</td>
      <td bgcolor="#999999">
        <div align="right">Texto en Pantalla:</div>
      </td>
      <td bgcolor="#999999"><input type="text" id="TDisplay" value="<?php echo $tdy; ?>" /></td>
    </tr>
    <tr>
      <td>Cantidad de Jugadas x Ticket</td>
      <td width="102">
        <div align="right">Minimas:
          <input type="text" id="Minimas" size="4" maxlength="4" value="<?php echo $mi; ?>" onkeypress="return permite(event, 'num');" />
        </div>
      </td>
      <td width="125">
        <div align="right">Maximas:
          <input type="text" id="Maximas" size="4" maxlength="4" value="<?php echo $mx; ?>" onkeypress="return permite(event, 'num');" />
        </div>
      </td>
      <td>&nbsp;</td>
      <td bgcolor="#999999">
        <div align="right">Titulo del Ticket:</div>
      </td>
      <td bgcolor="#999999"><input type="text" id="Tituloticket" value="<?php echo $tdt; ?>" /></td>
    </tr>
    <tr>
      <td>Formato de Juego:</td>
      <td colspan="2"><select id="Opcion">
          <option value="o" <?php if ($opc == 'o') : echo 'selected="selected"';
                            endif; ?>>Opcion Dependiente</option>
          <option value="i" <?php if ($opc == 'i') : echo 'selected="selected"';
                            endif; ?>>Opcion Independiente</option>
        </select></td>
      <td>&nbsp;</td>
      <td bgcolor="#999999">
        <div align="right">Texto Adicional por renglon:</div>
      </td>
      <td bgcolor="#999999"><input type="text" id="AddTicket" value="<?php echo $adt; ?>" /></td>
    </tr>
    <tr>
      <td>Logros por Defecto:</td>
      <td colspan="2"> <input type="text" id="logrosxdefecto" value="<? echo $logrosxdefecto; ?>" />
      </td>
      <td>&nbsp;</td>
      <td bgcolor="#999999">
        <div align="right">Tama&ntilde;o de la columna en pantalla:</div>
      </td>
      <td bgcolor="#999999"> <input type="text" id="tmc" value="<?php echo $tmc; ?>" onkeypress="return permite(event, 'num');" /></td>
    </tr>
    <tr>
      <td>Tomar encuenta para impresion de logro en el Ticket</td>
      <td colspan="2"><select id="ImpreTK">
          <option value="0" <? if ($ImpreTK == 0) : echo 'selected="selected"';
                            endif; ?>>SI</option>
          <option value="1" <? if ($ImpreTK == 1) : echo 'selected="selected"';
                            endif; ?>>NO</option>
        </select></td>
      <td>&nbsp;</td>
      <td bgcolor="#999999">Tipo de Escrute:</td>
      <td bgcolor="#999999"><select id="procesoescrute">
          <option value="1" <? if ($procesoescrute == 1) : echo 'selected="selected"';
                            endif; ?>>A Ganar</option>
          <option value="2" <? if ($procesoescrute == 2) : echo 'selected="selected"';
                            endif; ?>>Alta y Baja</option>
          <option value="3" <? if ($procesoescrute == 3) : echo 'selected="selected"';
                            endif; ?>>RunLine</option>
          <option value="4" <? if ($procesoescrute == 4) : echo 'selected="selected"';
                            endif; ?>>Si y No</option>
          <option value="5" <? if ($procesoescrute == 5) : echo 'selected="selected"';
                            endif; ?>>A Ganar (Empate Pierde)</option>
        </select></td>
    </tr>

    <tr>
      <td>Asignacion de Tabla (Logros Auto):</td>
      <td colspan="2"><select id="tabla">
          <option value="0" <? if ($tablaID == 0) : echo 'selected="selected"';
                            endif; ?>>No Seleccion</option>
          <option value="1" <? if ($tablaID == 1) : echo 'selected="selected"';
                            endif; ?>>20ct</option>
          <option value="2" <? if ($tablaID == 2) : echo 'selected="selected"';
                            endif; ?>>30ct</option>
          <option value="3" <? if ($tablaID == 3) : echo 'selected="selected"';
                            endif; ?>>40ct</option>
          <option value="4" <? if ($tablaID == 4) : echo 'selected="selected"';
                            endif; ?>>A/B</option>
          <option value="5" <? if ($tablaID == 5) : echo 'selected="selected"';
                            endif; ?>>0.5 Punto</option>
          <option value="6" <? if ($tablaID == 6) : echo 'selected="selected"';
                            endif; ?>>1 Punto</option>
          <option value="7" <? if ($tablaID == 7) : echo 'selected="selected"';
                            endif; ?>>1.5 Punto</option>
          <option value="8" <? if ($tablaID == 8) : echo 'selected="selected"';
                            endif; ?>>MoneyLine</option>
          <option value="9" <? if ($tablaID == 9) : echo 'selected="selected"';
                            endif; ?>>5to inning</option>


        </select></td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>

    <tr>
      <td>Este Juego no Combina con:</td>
      <td colspan="2">
        <div id="cdsf"><?php
                        $resultj = mysqli_query($GLOBALS['link'], "SELECT _tbjuegodd.*,_gruposdd.imagen,_gruposdd.descripcion as Desjuego,_formatosbb.descripcion as Desform FROM _tbjuegodd,_gruposdd,_formatosbb where _tbjuegodd.Grupo=_gruposdd.Grupo and _tbjuegodd.Formato=_formatosbb.Formato and _formatosbb.Grupo=" . $fdg . " Order by Formato,IDDD  ASC ");
                        $j = 1;
                        $dm = explode('|', $cb);
                        while ($Row = mysqli_fetch_array($resultj)) {
                          $key = array_search($j, $dm);
                          $tea = 'checked';
                          if ($key === false) :
                            $tea = '';
                          endif;
                          echo  '<input type="checkbox"  id="io' . $j . '" onclick="combina_click();" ' . $tea . '/>' . $Row['Descripcion'] . '(' . $Row['Desform'] . ')';
                          echo '<br>';
                          $j++;
                        }
                        echo '<samp  id="tdc_c" lang="' . $j . '" style="display:none">';
                        echo '<samp  id="noCombinar" lang="' . $cb . '" style="display:none">';

                        ?>

        </div>
      </td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2" bgcolor="#666666">
        <div align="center" style="color:#FFFFFF; font-size:16px">Configuracion de Reporte de Logros*</div>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td bgcolor="#999999">
        <div align="right">Texto del Reporte:</div>
      </td>
      <td bgcolor="#999999">
        <input type="text" id="reporte" value="<?php echo $tdr; ?>" />
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td bgcolor="#999999">
        <div align="right">Texto x Renglon:</div>
      </td>
      <td bgcolor="#999999"><input type="text" id="textorfila" value="<?php echo $txr; ?>" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <samp id="Estatus" lang="<?php echo $eta; ?>" style="display:none">
</div>
<p>&nbsp;</p>
<div id="box8" style="width:824px">
  <table width="823" border="0">
    <tr>
      <th width="274" scope="col">
        <div align="justify" class="Estilo1">* Es recomendable ser modificado o introducido por el Administrador del Sistema</div>
      </th>
      <th width="539" colspan="3" scope="col">
        <div align="right">
          <input type="submit" name="button2" id="button2" onclick="opmenu('cnfjuegosdd.php');" value="<--Regresar" />
          <input type="submit" name="button" id="button" value="Grabar" onclick="grabar_cnf1(2,'IDDD.lang|Descripcion.value|Formato.value|Grupo.value|Columnas.value|Minimas.value|Opcion.value|Estatus.lang|TDisplay.value|Tituloticket.value|AddTicket.value|Maximas.value|noCombinar.lang|reporte.value|textorfila.value|tmc.value|procesoescrute.value|logrosxdefecto.value|ImpreTK.value|tabla.value','_tbjuegodd',false);" />
        </div>
      </th>
    </tr>
  </table>
</div>
<p>&nbsp;</p>
<script>
  Nifty('div#box9', 'big');
  Nifty('div#box8', 'big');
</script>