<?

require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$idt = $_REQUEST['idt'];
$accesogp = accesolimitado($idt);




$verventas = 0;



?>

<div id="fromUsuarios" style="background:#BAC6D8;width:615px; height:1000px">
    <form id="from1" name="from1" method="POST" action="creartaquilla-1.php">

        <table width="600" border="0" cellspacing="0 ">
            <tr>
                <th colspan="6">
                    <div align="center"><span class="Estilo17">Crea Punto de Venta</span></div>
                </th>
            </tr>
            <tr>
                <th colspan="6" class="subHeader">
                    <div align="center"><span class="Estilo23">DATOS DEL PUNTO DE VENTA</span></div>
                </th>
            </tr>


            <tr>
                <th class="Estilo51">Letra P.Venta</th>
                <td colspan="3" class="ta_conc_td"><input name="c_idc" type="text" id="c_idc"
                        onKeyUp="this.value = this.value.toUpperCase(); pulsart(event,'direccion');  "
                        onkeypress="if (permite(event,'num_car2')) {return true;}else{return false;}" />
                    <font color="red">*</font>
                </td>
                <td width="37%" colspan="2" align="center" valign="middle" class="ta_conc_td"><label id="nomidcn"
                        style="font-size:14px"></label><samp id="IDC"></td>
            </tr>
            <tr>
                <th class="Estilo51">Direccion del P. Venta</th>
                <td colspan="5" class="ta_conc_td"><input name="direccion" type="text" id="direccion" />
                    <font color="red">*</font>
                </td>
            </tr>
            <tr>
                <th class="Estilo51">Grupo</th>
                <td colspan="5" class="ta_conc_td"><select name="grupo" size="1" id="grupo" onchange="cambiar_grupo();">
                        <?php

            if ($accesogp == 0) :
              $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tgrupo order by IDG ");
            else :
              $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tgrupo where IDG=" . $accesogp . " order by IDG ");
            endif;
            while ($row = mysqli_fetch_array($result)) {
              if ($row["Estatus"] < 2) :
                echo "<option  value=" . $row["IDG"] . ">" . $row["IDG"] . "</option>";
              endif;
            }
            ?>
                    </select></td>
            </tr>
            <tr>
                <th class="Estilo51"><span class="Estilo51">Nombre del Usuario</span></th>
                <td colspan="5" class="ta_conc_td">
                    <font color="red">
                        <input name="usuario" type="text" id="usuario" size="10" maxlength="10"
                            onkeyup="pulsart(event,'nombre'); "
                            onkeypress="if (permite(event,'num_car3')) {return true;}else{return false;}" />
                        *
                    </font> <img id="imgusuario" src="media/serro.png" height="16" width="16" style="display:none"
                        title="" />
                </td>
            </tr>
            <tr>
                <th class="Estilo51"><span class="Estilo51">Nombre</span></th>
                <td colspan="5" class="ta_conc_td">
                    <font color="red">
                        <input name="nombre" type="text" id="nombre" onkeyup="pulsart(event,'pVentas'); " />
                        *
                    </font> <img id="imgnombre" src="media/serro.png" height="16" width="16" style="display:none"
                        title="" />
                </td>
            </tr>
            <tr>
                <th class="Estilo51"><span class="Estilo51">Clave</span></th>
                <td colspan="5" class="ta_conc_td"><input name="" type="button" value="General"
                        onclick="GenerarClave()" />
                    <font color="red">*</font> <img id="imgclave" src="media/serro.png" height="16" width="16"
                        style="display:none" title="" /><span id='claveGenerada'></span>
                </td>
            </tr>
            <tr bgcolor="#999999" align="center">
                <th colspan="6" class="Estilo51" align="center">
                    <div align="center" style="color:#FFF;  font-size:12px">PORCENTAJES/ELIMINACION DE TICKET'S</div>
                </th>
            </tr>

            <tr>
                <th bgcolor="#999999">
                    <div align="right" class="Estilo2d">% de la Venta:</div>
                </th>
                <th>
                    <div id="box_1" style="background: #5F92C1"> <br />
                        <span id="sprytextfield2">

                            <label
                                style="color:#FFFFFF">Parlay&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                <input type="text" name="pVentas" id="pVentas" size="4" />% </label>

                            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span
                                class="textfieldInvalidFormatMsg">Formato no válido.</span></span><br />

                        <span id="sprytextfield8">

                            <label style="color:#FFFFFF">Por Derecho

                                <input type="text" name="pVentaspd" id="pVentaspd" size="4" />% </label>

                            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span
                                class="textfieldInvalidFormatMsg">Formato no válido.</span></span> <br /> <br />
                    </div>
                </th>
            </tr>
            <tr>

                <th bgcolor="#999999">
                    <div align="right"><span class="Estilo2d">Tiempo Maximo para Eliminar un Ticket!</span></div>
                </th>
                <th bgcolor="#999999"><span id="sprytextfield11">
                        <input id="Eminutos" name="Eminutos" type="text" size="4" />
                        <span class="textfieldRequiredMsg">Se necesita un valor.</span><span
                            class="textfieldInvalidFormatMsg">Formato no válido.</span></span>
                    Min</th>
            </tr>
            <tr bgcolor="#999999">

                <th width="163" bgcolor="#999999">
                    <div align="right"><span class="Estilo2d">Maximo Ticket a Eliminar*</span></div>
                </th>

                <th width="223" bgcolor="#999999"><span id="sprytextfield3">

                        <input type="text" id="cmaxelim" name="cmaxelim" size="4" />

                        <span class="textfieldRequiredMsg">Se necesita un valor.</span><span
                            class="textfieldInvalidFormatMsg">Formato no válido.</span><span class="Estilo1">*=0 Indica
                            Opcion no habilitada (NO PODRA ELIMNAR TICKET)</span></span></th>


            </tr>
        </table>



        <?php include('ver_listadeusuariodd-2.php') ?>
    </form>
</div>
<script>
function clicktoolBar(id) {
    switch (id) {
        case "Cerrar_":
            dhxWins1.window("w1").close();
            break;
        case "Guardar_":


            $('from1').request({
                method: 'post',
                parameters: {
                    claveGenerada: $('claveGenerada').innerHTML,
                    nomidcn: $('nomidcn').innerHTML
                },
                onComplete: function(transport) {
                    var response = transport.responseText.evalJSON(true);
                    if (response[0]) {
                        nalert('INFORMACION', 'INFORMACION ALMACENADA')
                        dhxWins1.window("w1").close();
                    } else
                        nalert('ERROR', response[1])
                },
                onFailure: function() {
                    alert('No tengo respuesta Comuniquese con el Administrador!');
                }
            });


            break;
        case "Eliminar_":
            elimnar_usuario();
            break;
    }
}
dhxWins1 = new dhtmlXWindows();
dhxWins1.setImagePath("codebase/imgs/");
w1 = dhxWins1.createWindow("w1", 100, 100, 615, 800);
w1.setText('Crear Punto de Venta');
w1.attachObject('fromUsuarios');
dhxWins1.window("w1").button('close').hide();
dhxWins1.window("w1").button('minmax1').hide();
dhxWins1.window("w1").button('minmax2').hide();
dhxWins1.window("w1").button('park').hide();
dhxWins1.window("w1").denyResize();
dhxWins1.window("w1").denyMove();
dhxWins1.window('w1').setModal(true);
var bar = w1.attachToolbar();
bar.addButton("Cerrar_", 4, "Cerrar", "images/close.gif", "images/close.gif");
bar.addButton("Guardar_", 1, "Guardar ", "media/users.png", "media/users.png");
bar.attachEvent("onClick", clicktoolBar);




var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "integer", {
    validateOn: ["blur", "change"],
    useCharacterMasking: true
});
var sprytextfield3 = new Spry.Widget.ValidationTextField("cmaxelim", "integer", {
    validateOn: ["blur", "change"],
    useCharacterMasking: true
});
var sprytextfield11 = new Spry.Widget.ValidationTextField("sprytextfield11", "integer", {
    validateOn: ["blur", "change"],
    useCharacterMasking: true
});
</script>