<?

require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$IDBlq = $_REQUEST['IDBlq'];

if ($IDBlq != 0) :

  $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbbloqueo WHERE IDBlq=  $IDBlq");
  $row = mysqli_fetch_array($result);

  $SFecha = $row['Select1'];
  $Fecha = $row['Fecha'];
  $Aplicar = $row['Aplicar'];
  $numero = $row['numero'];
  $IDLot = $row['IDLot'];
  $Adicional = $row['Adicional'];
  $SBloq = $row['Select2'];
  $Monto = $row['Monto'];

  switch ($row['tipo']) {

    case 1:
      $sql = 'SELECT * FROM _tbanca where 	IDB=' . $Aplicar;
      break;
    case 2:
      $sql = 'SELECT * FROM _tzona where IDZ=' . $Aplicar;
      break;
    case 3:
      $sql = 'SELECT * FROM _tintermediario where IDI=' . $Aplicar;
      break;
    case 4:
      $sql = 'SELECT * FROM _tagencias where IDC=' . $Aplicar;
      break;
  }
  $resultjBusq = mysqli_query($GLOBALS['link'], $sql);
  $RowBusq = mysqli_fetch_array($resultjBusq);
  $RealAplicar = $RowBusq['Descripcion'];
  $iDApli = $Aplicar . '-' . $row['tipo'];

else :
  $SFecha = 1;
  $Fecha = date("d/n/Y");
  $Aplicar = '';
  $numero = '';
  $IDLot = 0;
  $Adicional = 0;
  $SBloq = 1;
  $Monto = 0;
  $iDApli = '';
endif;

?>
<input name="" type="text" id="idBlq" value="<? echo $IDBlq; ?>" style="display:none" />
<table width="656" border="0" cellpadding="0" cellspacing="0" style="font-size:12px">
  <tr>
    <td width="94">Fecha:</td>
    <td width="198">
      <input type="radio" name="radio" id="radio1" value="radio" checked onclick="Select1()" <? if ($SFecha == 1) : echo 'checked="checked"';
                                                                                              endif; ?>> <input name="fc" type="text" id="fc1" size="10" value="<?php echo $Fecha; ?>" />
      <br>
      <input type="radio" name="radio" id="radio2" value="radio" onclick="Select1()" <? if ($SFecha == 2) : echo 'checked="checked"';
                                                                                      endif; ?>> Todos los Dias
    </td>
    <td width="25">&nbsp;</td>
    <td width="78">&nbsp;</td>
    <td width="75">&nbsp;</td>
    <td width="48">&nbsp;</td>
    <td width="138">&nbsp;</td>
  </tr>
  <tr bgcolor="#CCCCCC">
    <td>Aplicar a:</td>
    <td colspan="3"><label>
        <input type="text" name="textfield2" id="iAplicar" disabled="disabled" value="<? echo $RealAplicar; ?>" lang="<? echo $iDApli; ?>">
      </label><input name="" type="button" value="..." onclick="SelecTree()"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Numero:</td>
    <td><input type="text" name="textfield3" id="iNumero" value="<? echo $numero; ?>"></td>
    <td>&nbsp;</td>
    <td>Loteria:</td>
    <td><select name="select" id="iloteria" onChange=" iVerAdd() ">
        <option value="0" <? if ($IDLot == 0) : echo 'selected="selected"';
                          endif; ?>>Todos</option>
        <?
        $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tloteria WHERE Estatus=1");
        while ($row = mysqli_fetch_array($result)) {
          if ($IDLot == $row['IDLot']) : $iSele = 'selected="selected"';
            $iAddSel = $row['Formato'];
          else : $iSele = '';
          endif;
          echo '   <option value="' . $row['IDLot'] . '|' . $row['Formato'] . '" ' . $iSele . ' >' . $row['NombrePantalla'] . '</option>';
        }

        ?>
      </select></td>
    <td>Adicional</td>
    <td>
      <div id='iAdd'><?
                      if ($Adicional != 0) :
                        echo '	<select name="select2" id="iAddcional">
 			 <option value="0">Todos</option>';

                        $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tloteria_formato WHERE Formato=  $iAddSel");
                        $row = mysqli_fetch_array($result);

                        $IFormx = explode('|',  $row['Lista']);

                        for ($i = 0; $i <= count($IFormx) - 1; $i++) {
                          if (($i + 1) == $Adicional) : $iSele = 'selected="selected"';
                          else : $iSele = '';
                          endif;
                          echo '   <option value="' . ($i + 1) . '" ' . $iSele . '>' . $IFormx[$i] . '</option>';
                        }
                        echo ' </select>';

                      endif;

                      ?></div>
    </td>
  </tr>

  <tr bgcolor="#CCCCCC">
    <td>Bloqueado por:</td>
    <td><input type="radio" name="radio1" id="radio3" value="radio" <? if ($SBloq == 1) : echo 'checked="checked"';
                                                                    endif; ?> onclick="Select2()">
      Monto
      <input type="text" name="textfield4" id="iMonto" size="10" value="<? echo $Monto;  ?>">
      <br>
      <input type="radio" name="radio1" id="radio4" value="radio" onclick="Select2()" <? if ($SBloq == 2) : echo 'checked="checked"';
                                                                                      endif; ?>>
      No Vender
    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input name="input" type="button" value="Grabar" onclick="GrabarBlq()"></td>
  </tr>
</table>

<script>
  cal1 = new dhtmlxCalendarObject('fc1');
  cal1.setOnClickHandler(mSelectDate);
</script>