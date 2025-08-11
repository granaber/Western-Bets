<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
?>

<div id='fromBanca' align="center" style="background: #FFF; color:#000;width:450px">
    <div id="a_tabbar" align="center" style="width:550px; height:450px;" />

</div>
</div>
<div id='gridbox'></div>
<script>
var idRow = 0;
var lista = '<?= $lista ?? ''; ?>';
var ltexto = '<?= $ltexto ?? ''; ?>';

valoreslista = lista.split(',');
valoresltexto = ltexto.split(',');

function clicktoolBar(id) {
    switch (id) {
        case "Cerrar_":
            dhxWins1.window("w1").close();
            break;
        case "Agregar_":
            dhxWins1.window("w1").close();
            yq = true;
            makeRequest('banca.php?fc=0');
            break;
        case "Modificar_":
            if (idRow != 0) {
                dhxWins1.window("w1").close();
                makeResultwin('banca.php?fc=' + idRow, 'tablemenu');
            } else
                nalert('ERROR', 'DEBE SELECCIONAR PRIMERO EL USUARIO A MODIFICAR!!');
            break;

            //"ImprimirReporte2('reportedeventashipodromo-2.php');"
    }
}

function doOnCheck(rowId, cellInd, state) {
    if (state)
        estado = 1;
    else
        estado = 0;
    makeResultwin("chaceStatus.php?SqlStatus=Update _tbanca set Estatus=" + estado + " where IDB=" + rowId, "gridbox");
}

function doOnRowSelected(id) {
    idRow = id;
}

dhxWins1 = new dhtmlXWindows();
dhxWins1.setImagePath("codebase/imgs/");
w1 = dhxWins1.createWindow("w1", 350, 300, 370, 250);
w1.setText('Bancas');
w1.attachObject('fromBanca');
dhxWins1.window("w1").button('close').hide();
dhxWins1.window("w1").button('minmax1').hide();
dhxWins1.window("w1").button('minmax2').hide();
dhxWins1.window("w1").button('park').hide();
dhxWins1.window("w1").denyResize();
dhxWins1.window("w1").denyMove();
dhxWins1.window('w1').setModal(true);
var bar = w1.attachToolbar();
bar.addButton("Cerrar_", 4, "Cerrar", "images/close.gif", "images/close.gif");
bar.addButton("Agregar_", 1, "Agregar Banca", "media/user.png", "media/user.png");
bar.addButton("Modificar_", 1, "Modificar Banca", "images/page_setup.gif", "images/page_setup.gif");
bar.attachEvent("onClick", clicktoolBar);



mygrid = new dhtmlXGridObject("a_tabbar");
mygrid.setImagePath("codebase/imgs/");
mygrid.setHeader("ID Banca,Nombre de la Banca,Propietario,Estatus");
mygrid.setInitWidths("40,110,110,80")
mygrid.setColAlign("right,left,left,left")
mygrid.setColTypes("ro,ro,ro,ch");
mygrid.setSkin("dhx_skyblue");
mygrid.attachEvent("onRowSelect", doOnRowSelected);
mygrid.attachEvent("onCheckbox", doOnCheck);
mygrid.init();
mygrid.loadXML("banca-1-3.php")
</script>