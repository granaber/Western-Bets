<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$IDDD = $_REQUEST['Grupo'];
$new = $_REQUEST['inew'];



if ($new != 0) :
  $resultj = mysqli_query($GLOBALS['link'], 'SELECT * FROM _tbvalidarlogros  where Idval=' . $new);
  $row = mysqli_fetch_array($resultj);

  $opcionesOpt = $row['op'];
  $IDDD = $row['IDDD'];
  $rangl = explode('|', $row['rangoLogro']);
  $DesdeLog = $rangl[0];
  $HastaLog = $rangl[1];
  $rangc = explode('|', $row['rangoCarrera']);
  $DesdeCarr = $rangc[0];
  $HastaCarr = $rangc[1];
  $EVE = $row['EVE'];
  $logValidar = $row['IDDDcmp'];


else :

  $opcionesOpt = 1;
  $DesdeLog = 0;
  $HastaLog = 0;
  $DesdeCarr = 0;
  $HastaCarr = 0;
  $EVE = 0;
  $logValidar = 0;

endif;

$resultj = mysqli_query($GLOBALS['link'], 'SELECT * FROM _tbjuegodd  where IDDD=' . $IDDD);
$row = mysqli_fetch_array($resultj);
$Descripcion = $row['Descripcion'];
$Grupo = $row['Grupo'];
$resultj2 = mysqli_query($GLOBALS['link'], 'SELECT * FROM _formatosbb  where 	Formato=' . $row['Formato']);
$row2 = mysqli_fetch_array($resultj2);
$Descripcion .= '-' . $row['Descripcion'];


?>
<input id='Grupoxp' type="text" value="<? echo $Grupo; ?>" style="display:none" />
<form id="from1" name="from1" method="POST" action="chkOdds-2.php">
  <div id="FromMM">

    <input id='new' name="new" type="text" value="<? echo $new; ?>" style="display:none" /><input id='IDDD' name="IDDD" type="text" value="<? echo $IDDD; ?>" style="display:none" />
    <table border="0">
      <tr>
        <td colspan="3" align="center" style="background:#4B79A7; color:#FFF">
          <div align="center" style="font-size:16px"><? echo $Descripcion; ?></div>
        </td>
      </tr>
      <tr>
        <td colspan="2">Opcion a validar:</td>
        <td width="544">

          <select id='opcionesOpt' name="opcionesOpt" onchange="chkOddOpt($(this.id).value)">
            <option value="1" <? echo ($opcionesOpt == 1) ? 'selected="selected"' : ''; ?>>Logros Diferentes Signo, (No toma en cuenta los dos negativos)</option>
            <option value="2" <? echo ($opcionesOpt == 2) ? 'selected="selected"' : ''; ?>>Carrera/Puntos Validar con otro logro (Logro Negativo, Carreraje Negativo)</option>
            <option value="3" <? echo ($opcionesOpt == 3) ? 'selected="selected"' : ''; ?>>Rango de Logro</option>
            <option value="4" <? echo ($opcionesOpt == 4) ? 'selected="selected"' : ''; ?>>Rango de Carreraje</option>
            <option value="6" <? echo ($opcionesOpt == 6) ? 'selected="selected"' : ''; ?>>Tienen que ser Signos Diferentes. En caso de ser iguales el sistema alertar y pide autorizacion</option>
          </select>
        </td>
      </tr>
      <tr>
        <td width="99">&nbsp;</td>
        <td width="4">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><span id="txEVE" <? echo ($opcionesOpt == 1) ? '' : 'style="display:none"'; ?>>Logro EVE:</span><span id="txValidar" <? echo ($opcionesOpt == 2) ? '' : 'style="display:none"'; ?>>Apuesta a Validar: </span> <span id="txRangoLogros" <? echo ($opcionesOpt == 3) ? '' : 'style="display:none"'; ?>>Rango de Logros: </span> <span id="txRangoCarr" <? echo ($opcionesOpt == 4) ? '' : 'style="display:none"'; ?>>Rango de Carreraje: </span></td>
        <td> <span id="cpEVE" <? echo ($opcionesOpt == 1) ? '' : 'style="display:none"'; ?>> <input type="text" name="EVE" id="EVE" size="5" value="<? echo $EVE; ?>" /></span>
          <span id="cpValidar" <? echo ($opcionesOpt == 2) ? '' : 'style="display:none"'; ?>>
            <select id='logValidar' name="logValidar">
              <?
              echo '<option value="0"></option>';
              $resultj = mysqli_query($GLOBALS['link'], 'SELECT * FROM _tbjuegodd  where Grupo=' . $Grupo);
              while ($row = mysqli_fetch_array($resultj)) {
                if ($logValidar == $row['IDDD']) :  $seleck = 'selected="selected"';
                else : $seleck = "";
                endif;
                echo '<option value="' . $row['IDDD'] . '"  ' . $seleck . ' >' . $row['Descripcion'] . '</option>';
              }
              ?>
            </select>
          </span>
          <span id="cpRangoLogros" <? echo ($opcionesOpt == 3) ? '' : 'style="display:none"'; ?>> <input name="DesdeLog" id="DesdeLog" type="text" size="6" value="<? echo $DesdeLog; ?>" /> - <input id="HastaLog" name="HastaLog" type="text" size="6" value="<? echo $HastaLog; ?>" /></span>
          <span id="cpRangoCarr" <? echo ($opcionesOpt == 4) ? '' : 'style="display:none"'; ?>> <input name="DesdeCarr" id="DesdeCarr" type="text" size="6" value="<? echo $DesdeCarr; ?>" /> - <input id="HastaCarr" name="HastaCarr" type="text" size="6" value="<? echo $HastaCarr; ?>" /></span>
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>
          <input type="button" name="button" id="btnGrabar" value="Grabar" onclick="GrabarchkOdds();" />
          <? if ($new != 0) : ?>
            <input type="button" name="button" id="btnElimar" value="Eliminar" onclick="EliminarchkOdds();" />
          <? endif; ?>
        </td>
      </tr>
      <tr>
        <td colspan="3">
          <div>
            <div id='gridboxDRC' style="background-color:#FC0 "></div>
          </div>
        </td>
      </tr>
    </table>
  </div>
</form>
<script>
  Camposl[1] = "EVE";
  Camposl[2] = "Validar";
  Camposl[3] = "RangoLogros";
  Camposl[4] = "RangoCarr";
</script>