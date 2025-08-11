<style>
  .Estilo2d {
    font-size: 12px;
  }

  .Estilo1r {
    display: contents;
    font-size: 12px;
    color: #FFFFFF;
  }
</style>
<div id="box7" style="width:600px">
  <?php
  require('prc_php.php');
  $GLOBALS['link'] = Connection::getInstance();
  $idr = $_REQUEST['idr'];
  $result = mysqli_query($link, "SELECT * FROM _tconsecionario where IDC='$idr'");
  $row = mysqli_fetch_array($result);
  $idc = $row['IDC'];
  $result_b = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionariodd where IDC='" . $row['IDC'] . "'");
  if (mysqli_num_rows($result_b) != 0) :
    $row_b = mysqli_fetch_array($result_b);
    $partici1 = $row_b['Participacion1'];
    $partici2 = $row_b['Participacion2'];
    $IDB = $row_b['IDB'];
    $pventas = $row_b['pVentas'];
    $cmaxelim = $row_b['cmaxelim'];
    $mma = $row_b['mma'];
    $mmjpd = $row_b['mmjpd'];
    $mmjpp = $row_b['mmjpp'];
    $pventaspd = $row_b['pVentaspd'];
    $mmdp = $row_b['mmdp'];
    $porcentajextablad = $row_b['porcentajextablad'];
    $tipodev = $row_b['tipodev'];
    $cdpi = $row_b['cdpi'];
    $cjmp = $row_b['cjmp'];
    $Eminutos = $row_b['Eminutos'];
    $mxpjpd = $row_b['mxpjpd'];
    $pdrl = $row_b['pdrl'];
    $maxpremio = $row_b['maxpremio'];
    $idCnv = $row_b['idCnv'];
    $mma2 = $row_b['mma2'];
    $ventaMin = $row_b['ventaMin'];
    $cantBase = $row_b['cantBase'];

  else :
    $partici1 = 0;
    $partici2 = 0;
    $IDB = 0;
    $pventas = 0;
    $cmaxelim = 0;
    $mma = 0;
    $mmjpd = 0;
    $mmjpp = 0;
    $pventaspd = 0;
    $mmdp = 0;
    $porcentajextablad = 0;
    $tipodev = 1;
    $cdpi = 0;
    $cjmp = 0;
    $Eminutos = 0;
    $mxpjpd = 0;
    $maxpremio = 0;
    $idCnv = 0;
    $mma2 = 0;
    $ventaMin = 0;
    $cantBase = 0;
  endif;
  $verventas = 1;
  ?>


  <samp id="tipodev" lang="<? echo $tipodev; ?>"></samp>
  <table border="0" cellspacing="0">

    <tr bgcolor="#999999">

      <th bgcolor="#999999"></th>

      <th colspan="3" bgcolor="#999999">
        <div align="center" class="Estilo3">Configuracion de Concesionario de Deporte</div>
      </th>
    </tr>

    <tr bgcolor="#999999">

      <th bgcolor="#999999"></th>

      <th bgcolor="#999999">&nbsp;</th>

      <th bgcolor="#999999">&nbsp;</th>

      <th bgcolor="#999999"><samp id='estado'></samp></th>
    </tr>

    <tr bgcolor="#999999">

      <th bgcolor="#999999"></th>

      <th bgcolor="#999999">
        <div align="right" class="Estilo2d">Concesionario:</div>
      </th>

      <th bgcolor="#999999"><samp id="IDC" lang="<?php echo $row['IDC']; ?>"
          class="Estilo4d"><?php echo $row['IDC']; ?></samp></th>

      <th bgcolor="#999999">

        <input class="button-pv-standard-csc" type="submit" name="button" id="button" value="Grabar"
          onclick="grabar_cnf1(2,'IDC.lang|Participacion1.value|IDB.value|pVentas.value|cmaxelim.value|Participacion2.value|mmjpd.value|mma.value|mmjpp.value|pVentaspd.value|mmdp.value|tipodev.lang|porcentajextablad.value|cdpi.value|cjmp.value|Eminutos.value|pdrl.value|mxpjpd.value|maxpremio.value|idCnv.value|mma2.value|ventaMin.value|cantBase.value','_tconsecionariodd',true);" />
      </th>
    </tr>

    <tr bgcolor="#999999">

      <th bgcolor="#999999"></th>

      <th bgcolor="#999999">
        <div align="right" class="Estilo2d">Nombre:</div>
      </th>

      <th bgcolor="#999999"><samp class="Estilo4d"><?php echo $row['Nombre']; ?></samp></th>

      <th bgcolor="#999999"><input class="button-pv-standard-csc" style="background: darkgoldenrod;"
          type=" submit" name="button2" id="button2" value="&lt;- Regresar"
          onClick="opmenu('ver_listadeusuariodd.php');" /></th>
    </tr>

    <tr bgcolor="#999999">

      <th bgcolor="#999999"></th>

      <th bgcolor="#999999">
        <p align="right">Participacion:</p>
      </th>

      <th bgcolor="#999999"><span id="sprytextfield1">

          <label>Ganacia

            <input class="input-pv-standard-csc" type="text" id="Participacion1" size="4"
              value="<?php echo $partici1; ?>" />% </label>

          <br /><span class="textfieldRequiredMsg">Se necesita un valor.</span><span
            class="textfieldInvalidFormatMsg">Formato no valido.</span></span>

        <span id="sprytextfield4">Perdida&nbsp;

          <input class="input-pv-standard-csc" type="text" id="Participacion2" size="4"
            value="<?php echo $partici2; ?>" />%

          <br /><span class="textfieldRequiredMsg">Se necesita un valor.</span><span
            class="textfieldInvalidFormatMsg">Formato no valido.</span></span>
      </th>



      <th bgcolor="#999999">
    </tr>

    <tr bgcolor="#999999">
      <th bgcolor="#999999"></th>
      <th rowspan="2" bgcolor="#999999">
        <div align="right" class="Estilo2d">% de la Venta:</div>
      </th>
      <th rowspan="2">
        <div id="box_1" style="background: #5F92C1"> <br /><input type="radio" name="radio" id="radio"
            onclick="$('tipodev').lang=1;" value="radio" <? if ($tipodev == 1) : echo 'checked="checked"';
                                                          endif; ?> />
          <span style="color:#FFFFFF">Por Porcentaje</span> <br />
          <span id="sprytextfield2">

            <label style="color:#FFFFFF">Parlay&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

              <input class="input-pv-standard-csc" type="text" name="pVentas" id="pVentas" size="4"
                value="<?php echo $pventas; ?>" />%
            </label>

            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span
              class="textfieldInvalidFormatMsg">Formato no v�lido.</span></span><br />

          <span id="sprytextfield8">

            <label style="color:#FFFFFF">Por Derecho

              <input class="input-pv-standard-csc" type="text" name="pVentaspd" id="pVentaspd" size="4"
                value="<?php echo $pventaspd; ?>" />% </label>

            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span
              class="textfieldInvalidFormatMsg">Formato no v�lido.</span></span> <br /> <br />
        </div>
      </th>

      <th rowspan="2" bgcolor="#999999">&nbsp;</th>
    </tr>
    <tr bgcolor="#999999">

      <th bgcolor="#999999"></th>
    </tr>

    <tr bgcolor="#999999">
      <th bgcolor="#999999"></th>
      <th bgcolor="#999999">&nbsp;</th>
      <th bgcolor="#999999">
        <div id="box_2" style="background: #385B96">
          <samp id="IDC2" lang="<? echo $idc; ?>" xml:lang="<? echo $idc; ?>"></samp><br />
          <input type="radio" name="radio" id="radio2" value="radio" onclick="$('tipodev').lang=2;" <? if ($tipodev == 2) : echo 'checked="checked"';
                                                                                                    endif; ?> />
          <span style="color:#FFFFFF">Por Tabla</span> <img src="media/calendar_empty.png" width="24"
            height="24" title="Copiar Tabla Estandar"
            onclick="makeResultwin2('ver_listadeusuariodd-3.php?op=1&idc=<? echo $idc; ?>','esckk');" /><span>
            <span id="sprytextfield10">
              <label style="color:#FFFFFF">Por Derecho
                <input type="text" id="porcentajextablad" size="4"
                  value="<?php echo $porcentajextablad; ?>" />
                % </label>
              <span class="textfieldRequiredMsg">Se necesita un valor.</span><span
                class="textfieldInvalidFormatMsg">Formato no v&aacute;lido.</span></span></span><br />
          <br />
          <br />
          <span style="color: #0099CC">Desde:</span>
          <input id="MontoDesde" type="text" size="4" maxlength="10" />
          <span style="color: #0099CC">Hasta:</span>
          <input id="MontoHasta" type="text" size="4" maxlength="10" />
          <span style="color: #0099CC">Cobra:</span>
          <input id="aCobrar" type="text" size="3" maxlength="10" />
          <img src="media/edit_icon.gif" alt=""
            onclick="_grabarvalores6(IDC.lang,MontoDesde.value,MontoHasta.value,aCobrar.value);makeResultwin2('ver_listadeusuariodd-3.php?op=2&idc=<? echo $idc; ?>','esckk');$('MontoDesde').value='';$('MontoHasta').value='';$('aCobrar').value='';" /><br />
          <div id="esckk">
            <? include('ver_listadeusuariodd-3.php'); ?>
          </div>
      </th>
      <th bgcolor="#999999">&nbsp;</th>
    </tr>
    <tr bgcolor="#999999">

      <th width="5" bgcolor="#999999"></th>

      <th width="154" bgcolor="#999999">
        <div align="right"><span class="Estilo2d">Pretenece a la Banca:</span></div>
      </th>

      <th width="223" bgcolor="#999999"><span id="spryselect1">

          <label>

            <select name="select1" id="IDB">

              <option value="1">Banca</option>
            </select>
          </label>

          <span class="selectRequiredMsg">Seleccione un elemento.</span></span></th>

      <th width="160" bgcolor="#999999">&nbsp;</th>
    </tr>

    <tr bgcolor="#999999">
      <th bgcolor="#999999"></th>
      <th bgcolor="#999999">
        <div align="right"><span class="Estilo2d">Tiempo Maximo para Eliminar un Ticket!</span></div>
      </th>
      <th bgcolor="#999999"><span id="sprytextfield11">
          <input class="input-pv-standard-csc" id="Eminutos" type="text" value="<?php echo $Eminutos; ?>"
            size="4" />
          <span class="textfieldRequiredMsg">Se necesita un valor.</span><span
            class="textfieldInvalidFormatMsg">Formato no v�lido.</span></span>
        Min</th>
      <th bgcolor="#999999">&nbsp;</th>
    </tr>
    <tr bgcolor="#999999">

      <th width="5" bgcolor="#999999"></th>

      <th width="154" bgcolor="#999999">
        <div align="right"><span class="Estilo2d">Maximo Ticket a Eliminar*</span></div>
      </th>

      <th colspan="2" bgcolor="#999999"><span id="sprytextfield3">

          <input class="input-pv-standard-csc" type="text" name="textfield" id="cmaxelim"
            value="<?php echo $cmaxelim; ?>" size="4" />

          <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="Estilo1">*=0 Indica no
            habilitada</span></span></th>

      <th width="160" bgcolor="#999999">&nbsp;</th>
    </tr>
  </table>



</div> <br />

<div id='add'>

  <?php include('ver_listadeusuariodd-2.php') ?> </div>

<script>
  Nifty('div#box7', 'big');
  Nifty('div#box8', 'big');
  Nifty('div#box5', 'big');
  Nifty('div#box_1', 'big');
  Nifty('div#box_2', 'big');
</script>