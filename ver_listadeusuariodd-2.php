<style>
    .Estilo1r {
        display: contents;
        font-size: 12px;
        color: #FFFFFF;
    }
</style>
<div id="box5" style="width:600px">
    <table width="513" border="0">

        <tr>

            <th colspan="4" scope="col">
                <div align="center"><span class="Estilo1r">RESTRICCION DE CONCESIONARIO</span></div>
            </th>
        </tr>

        <tr>

            <th colspan="4" scope="col">&nbsp;</th>
        </tr>

        <tr>

            <th colspan="2" scope="col"><span class="Estilo1r">1:Monto Maximo de Jugada por Derecho</span></th>

            <th width="98" colspan="2" scope="col">
                <div align="left"><span id="sprytextfield5">

                        <input class="input-pv-standard-csc" type="text" name="mmjpd" id="mmjpd" size="8" maxlength="8"
                            value="<?php echo $mmjpd ?? 0;  ?>">

                        <span class="textfieldRequiredMsg">Se necesita un valor.</span><span
                            class="textfieldInvalidFormatMsg">Formato no válido.</span></span></div>
            </th>
        </tr>

        <tr>
            <th colspan="2" scope="col"><span class="Estilo1r">7:Monto Maximo de Perdida en Jugada por Derecho</span>
            </th>
            <th colspan="2" scope="col"> <input class="input-pv-standard-csc" type="text" name="mxpjpd" id="mxpjpd"
                    size="8" maxlength="8" value="<?php echo $mxpjpd ?? 0; ?>"></th>
        </tr>
        <tr>

            <th colspan="2" scope="col"><span class="Estilo1r">6:Monto Maximo de Jugada por Derecho(RL)</span></th>

            <th width="98" colspan="2" scope="col">
                <div align="left"><span id="sprytextfield5">

                        <input class="input-pv-standard-csc" type="text" name="pdrl" id="pdrl" size="8" maxlength="8"
                            value="<?php echo $pdrl ?? 0; ?>">

                        <span class="textfieldRequiredMsg">Se necesita un valor.</span><span
                            class="textfieldInvalidFormatMsg">Formato no válido.</span></span></div>
            </th>
        </tr>
        <tr>

            <th colspan="2" scope="col"><span class="Estilo1r">Monto Maximo de la Apuesta del Ticket</span></th>

            <th colspan="2" scope="col">
                <div align="left"><span id="sprytextfield6">

                        <input class="input-pv-standard-csc" type="text" name="mma" id="mma" size="8" maxlength="8"
                            value="<?php echo $mma ?? 0; ?>">

                        <span class="textfieldRequiredMsg">Se necesita un valor.</span><span
                            class="textfieldInvalidFormatMsg">Formato no válido.</span></span></div>
            </th>
        </tr>


        <tr>

            <th colspan="2" scope="col"><span class="Estilo1r">2:Monto Maximo de Jugada por Parlay</span></th>

            <th scope="col">
                <div align="left"><span id="sprytextfield7">

                        <input class="input-pv-standard-csc" type="text" name="mmjpp" id="mmjpp" size="8" maxlength="8"
                            value="<?php echo $mmjpp ?? 0; ?>">

                        <span class="textfieldRequiredMsg">Se necesita un valor.</span><span
                            class="textfieldInvalidFormatMsg">Formato no válido.</span></span></div>
            </th>
            <th scope="col">
                <? if ($verventas == 1) : ?><input class="button-pv-standard-csc"
                        style="padding: 0px 2px;background: #0c3926;width: 120px;" type=" button" id="button3"
                        value="4:Ventas Maximas"
                        onclick="makeResultwin('ver_listadeusuariodd-5.php?IDC='+$('IDC').lang,'resul2xp')" />
                <? endif; ?>
            </th>
        </tr>
        <tr>
            <th colspan="2" scope="col"><span class="Estilo1r">3:Monto Maximo del Premio .:</span></th>
            <th colspan="2" scope="col">
                <div align="left"><span id="sprytextfield9">

                        <input class="input-pv-standard-csc" type="text" name="maxpremio" id="maxpremio" size="8"
                            value="<?php echo $maxpremio ?? 0; ?>">

                        <span class="textfieldRequiredMsg">Se necesita un valor.</span><span
                            class="textfieldInvalidFormatMsg">Formato no válido.</span></div>
            </th>
        </tr>
        <tr>
            <th colspan="2" scope="col"><span class="Estilo1r">3:Monto Maximo del Premio:</span></th>
            <th colspan="2" scope="col">
                <div align="left"><span id="sprytextfield9">

                        <span class="Estilo1r" style="font-size:16px">1x</span><input class="input-pv-standard-csc"
                            type="text" name="mmdp" id="mmdp" size="4" maxlength="4" value="<?php echo $mmdp ?? 0; ?>">

                        <span class="textfieldRequiredMsg">Se necesita un valor.</span><span
                            class="textfieldInvalidFormatMsg">Formato no válido.</span></span></div>
            </th>
        </tr>
        <tr>
            <th colspan="2" scope="col"><span class="Estilo1r">10:Cantidad de Parlay (IGUALES) Permitidos:</span></th>
            <th colspan="2" scope="col"><span id="sprytextfield1">
                    <input class="input-pv-standard-csc" type="text" name="cdpi" id="cdpi" size="4" maxlength="4"
                        value="<?php echo $cdpi ?? 0; ?>" />
                    <span class="textfieldRequiredMsg">Se necesita un valor.</span><span
                        class="textfieldInvalidFormatMsg">Formato no válido.</span></span>
                <span class="Estilo1r">de .</span><span id="sprytextfield6">
                    <input class="input-pv-standard-csc" type="text" name="mma2" id="mma2" size="8" maxlength="8"
                        value="<?php echo $mma2 ?? 0; ?>">
                    <span class="textfieldRequiredMsg">Se necesita un valor.</span><span
                        class="textfieldInvalidFormatMsg">Formato no válido.</span></span>


                <!--  <th colspan="2" scope="col"><span class="Estilo1r">Cantidad de Parlay (IGUALES) Permitidos:</span></th>
      <th colspan="2" scope="col"><span id="sprytextfield1">
      <input class="input-pv-standard-csc" type="text"  name="cdpi" id="cdpi" size="4" maxlength="4" value="<?php echo $cdpi ?? 0; ?>" />
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></th>
      <span class="Estilo1r">de  .</span><span id="sprytextfield6">
      <input class="input-pv-standard-csc" type="text" name="mma2" id="mma2" size="8" maxlength="8" value="<?php echo $mma2 ?? 0; ?>">
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span>
-->
        </tr>
        <tr>
            <th colspan="2" scope="col"><span class="Estilo1r">5:Cantidad de Jugadas Maximas Permitidas:</span></th>
            <th scope="col">
                <input class="input-pv-standard-csc" type="text" name="cjmp" id="cjmp" size="4" maxlength="4"
                    value="<?php echo $cjmp ?? 0; ?>" />
            </th>
        </tr>

        <tr>
            <th colspan="2" scope="col"><span class="Estilo1r">8:Tabla DonBest:</span></th>
            <th scope="col">
                <input class="input-pv-standard-csc" type="text" name="idCnv" id="idCnv" size="4" maxlength="4"
                    value="<?php echo $idCnv ?? 0; ?>" />
            </th>
        </tr>
        <tr>
            <th colspan="2" scope="col"><span class="Estilo1r">11:Monto Minimo de venta :</span></th>
            <th scope="col">
                <input class="input-pv-standard-csc" type="text" name="ventaMin" id="ventaMin" size="10" maxlength="10"
                    value="<?php echo $ventaMin ?? 0; ?>" />
            </th>
        </tr>
        <tr>
            <th colspan="2" scope="col"><span class="Estilo1r">12:Cantidad de Tickets con Base Repetida :</span></th>
            <th scope="col">
                <input class="input-pv-standard-csc" type="text" name="cantBase" id="cantBase" size="10" maxlength="10"
                    value="<?php echo $cantBase ?? 0; ?>" />
            </th>
        </tr>
        <tr>

            <th width="216" scope="col"> </th>

            <th width="185" scope="col"> </th>

            <th colspan="2" scope="col"></th>
        </tr>
    </table>



</div>
<div id="resul2xp"></div>