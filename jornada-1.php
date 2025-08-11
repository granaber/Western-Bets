<div id='parametrodeconfigu'>
  <?php
  $opc = $_REQUEST['opc'];

  require('prc_php.php');
  $GLOBALS['link'] = Connection::getInstance();


  if ($opc == -1) :

    $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfjornada order by IDCN DESC ");
    $row = mysqli_fetch_array($result);
    if ($result) :
      $numero = $row["IDCN"] + 1;
    else :
      $numero = 1;
    endif;
    $macuare = 0;
    $idhipo = 0;
    $NTDP4 = 0;
    $Ntdp = 0;
    $fc = "";
    $nc = 0;
    $Nest = 1;
  else :

    $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfjornada where IDCN=" . $opc);
    $row = mysqli_fetch_array($result);
    $numero = $row["IDCN"];
    $idhipo = $row["IDhipo"];
    $NTDP4 = $row["NTDP4"];
    $Ntdp = $row["NTDp"];
    $fc = $row["Fecha"];
    $nc = $row["Cantcarr"];
    $Nest = $row["Estatus"];
    $macuare = $row["Macuare"];
  endif
  ?>
  <p><b>Parámetros de la Jornada</b>
  </p>
  </p>
  <table border="0" cellpadding="3" cellspacing="0" width="805">
    <tbody>
      <tr>
        <td><strong style="color: #F90; font-size:16px">Jornada No.: <span id="nj" title="<?php echo $numero; ?>"><?php echo $numero; ?></span></strong></p>
        </td>
        <td width="37%"><span style="color:#FFFFFF; font-size:12px">Indique la Fecha:</span>
          <input type="text" name="fecha_2" id="fecha_2" size="10" maxlength="10" value="<?php echo $fc; ?>" onFocus="cargarcampos2();">
        </td>
        <td width="29%"><span style="color:#FFFFFF; font-size:12px">Hipodromo :</span>
          <select name="_hipod" id="_hipod">
            <?php $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _hipodromos order by _idhipo");
            while ($row = mysqli_fetch_array($result)) {
              if ($row["Estatus"] < 2) :
                echo "<option " . ($idhipo == $row["_idhipo"] ? " selected='selected'" : " ") . " value=" . $row["_idhipo"] . ">" . $row["Descripcion"] . "</option>";
              endif;
            }
            ?>
          </select>
        </td>
      </tr>
      <tr>
        <td width="34%"><span style="color:#FFFFFF; font-size:12px">Número de Carreras:</span></td>
        <td><select id="cmbCarreras">
            <option <?php echo ($nc == 0 ? " selected='selected'" : " "); ?> value="0">0</option>
            <option <?php echo ($nc == 1 ? " selected='selected'" : " "); ?> value="1">1</option>
            <option <?php echo ($nc == 2 ? " selected='selected'" : " "); ?>value="2">2</option>
            <option <?php echo ($nc == 3 ? " selected='selected'" : " "); ?>value="3">3</option>
            <option <?php echo ($nc == 4 ? " selected='selected'" : " "); ?>value="4">4</option>
            <option <?php echo ($nc == 5 ? " selected='selected'" : " "); ?>value="5">5</option>
            <option <?php echo ($nc == 6 ? " selected='selected'" : " "); ?>value="6">6</option>
            <option <?php echo ($nc == 7 ? " selected='selected'" : " "); ?>value="7">7</option>
            <option <?php echo ($nc == 8 ? " selected='selected'" : " "); ?>value="8">8</option>
            <option <?php echo ($nc == 9 ? " selected='selected'" : " "); ?>value="9">9</option>
            <option <?php echo ($nc == 10 ? " selected='selected'" : " "); ?>value="10">10 </option>
            <option <?php echo ($nc == 11 ? " selected='selected'" : " "); ?>value="11">11 </option>
            <option <?php echo ($nc == 12 ? " selected='selected'" : " "); ?>value="12">12 </option>
            <option <?php echo ($nc == 13 ? " selected='selected'" : " "); ?>value="13">13 </option>
            <option <?php echo ($nc == 14 ? " selected='selected'" : " "); ?>value="14">14 </option>
            <option <?php echo ($nc == 15 ? " selected='selected'" : " "); ?>value="15">15 </option>
            <option <?php echo ($nc == 16 ? " selected='selected'" : " "); ?>value="16">16 </option>
            <option <?php echo ($nc == 17 ? " selected='selected'" : " "); ?>value="17">17 </option>
            <option <?php echo ($nc == 18 ? " selected='selected'" : " "); ?>value="18">18 </option>
            <option <?php echo ($nc == 19 ? " selected='selected'" : " "); ?>value="19">19 </option>
            <option <?php echo ($nc == 20 ? " selected='selected'" : " "); ?>value="20">20 </option>
          </select> </td>
        <td><span style="color:#FFFFFF; font-size:12px">Estatus:</span>
          <select id="testatus">
            <option <?php echo ($Nest == 1 ? " selected='selected'" : " "); ?> value="1">Activo</option>
            <option <?php echo ($Nest == 2 ? " selected='selected'" : " "); ?> value="2">Cerrado</option>
          </select>
        </td>
      </tr>
      <!--JUEGOS QUE SE JUEGAN POR TANDAS -->
      <tr>
        <td width="34%"><span style="color:#FFFFFF; font-size:12px;display:none">Número de Tandas de Doble
            Perfecta</span>
          <!-- ^ Deshabilitado porque solamente es para MACUARE -->
          <span style="color:#FFFFFF; font-size:12px">Monto del Macuare 1x</span>
        </td>
        <!-- Cargamos los select correspondientes a cada juego que posea tandas  OnChange="cambiarFoco(document.forms[1].elements[])-->
        <td colspan="2"><select id="cmbTandas_1" name="cmbTandas_1" size="1" style="display:none">
            <option <?php echo ($Ntdp == 0 ? " selected='selected'" : " "); ?> value="0">0</option>
            <option <?php echo ($Ntdp == 1 ? " selected='selected'" : " "); ?> value="1">1</option>
            <option <?php echo ($Ntdp == 2 ? " selected='selected'" : " "); ?> value="2">2</option>
            <option <?php echo ($Ntdp == 3 ? " selected='selected'" : " "); ?> value="3">3</option>
            <option <?php echo ($Ntdp == 4 ? " selected='selected'" : " "); ?> value="4">4</option>
          </select>
          <span id="sprytextfield1">
            <input id="Macuare" type="text" value="<? echo $macuare; ?>" size="6" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span>
        </td>
      </tr>
      <tr>
        <td width="34%"><span style="color:#FFFFFF; font-size:12px;display:none">Número de Tandas de Triple
            Apuesta:</span></td>
        <!-- Cargamos los select correspondientes a cada juego que posea tandas  OnChange="cambiarFoco(document.forms[1].elements[])-->
        <td colspan="2"><select id="cmbTandas_2" name="cmbTandas_2" size="1" style="display:none">
            <option value="0">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
          </select> </td>
      </tr>
      <tr>
        <td width="34%"><span style="color:#FFFFFF; font-size:12px;display:none">Número de Tandas de Pool de
            4</span></td>
        <!-- Cargamos los select correspondientes a cada juego que posea tandas  OnChange="cambiarFoco(document.forms[1].elements[])-->
        <td colspan="2"><select id="cmbTandas_3" name="cmbTandas_3" size="1" style="display:none">
            <option <?php echo ($NTDP4 == 0 ? " selected='selected'" : " "); ?> value="0">0</option>
            <option <?php echo ($NTDP4 == 1 ? " selected='selected'" : " "); ?> value="1">1</option>
            <option <?php echo ($NTDP4 == 2 ? " selected='selected'" : " "); ?> value="2">2</option>
            <option <?php echo ($NTDP4 == 3 ? " selected='selected'" : " "); ?> value="3">3</option>
            <option <?php echo ($NTDP4 == 4 ? " selected='selected'" : " "); ?> value="4">4</option>
          </select> </td>
      </tr>
      <!-- Boton actualizar datos, solicitado despues de modificar los datos de los juegos por tandas -->
    </tbody>
  </table>
  <p class="Estilo39">
    <input type="submit" name="Submit" value="Actualizar Tabla" onclick="makeResEsp('jornada-2.php','tabladeconfiguracion')" /> <input type="submit" name="Submit" value="&lt;-Volver" onclick="javascript:makeRequestSP('jornada.php');" />
  </p>
</div>
<script type="text/javascript">
  var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {
    useCharacterMasking: true
  });
</script>