<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
?>

<div id="obj">
    <table width="460" border="0">
        <tr>
            <td width="177"><span style="color:#000; font-size:12px">Nombre del Usuario:</span></td>
            <td width="273"><strong><span id="usuario" lang="" style="color: #F00; font-size:14px"></span></strong></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><span style="color:#000; font-size:12px">Introduzca su Clave Actual:</span></td>
            <td><input id="clave" name="input" type="password"></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </table>

</div>
<script>
function clicktoolBar(id) {
    switch (id) {
        case "continuar_":
            if (VerificarClave())
                makeResultwin2('newClave.php?usu=' + $('usu').lang, 'tablemenu')
            break;
        case "cerrar_":
            dhxWins2.window("w1").close();
            break;
    }
}

$('usuario').lang = $("usu").lang;
$('usuario').innerHTML = $("usu").lang;
dhxWins2 = new dhtmlXWindows();
dhxWins2.setImagePath("codebase/imgs/");
var w1 = dhxWins2.createWindow("w1", 50, 120, 350, 150);
w1.setText("Cambio de Clave");
w1.attachObject('obj');
w1.centerOnScreen();
dhxWins2.window("w1").button('close').hide();
dhxWins2.window("w1").button('minmax1').hide();
dhxWins2.window("w1").button('minmax2').hide();
dhxWins2.window("w1").button('park').hide();
dhxWins2.window("w1").denyResize();
dhxWins2.window("w1").denyMove();
dhxWins2.window("w1").setModal(true);

var bar = w1.attachToolbar();
bar.addButton("continuar_", 1, "Continuar", "media/down.ico", "media/down.ico");
bar.addButton("cerrar_", 1, "Cerrar", "images/close.gif", "images/close.gif");
bar.attachEvent("onClick", clicktoolBar);
$('clave').value = '';
$('clave').focus();
</script>