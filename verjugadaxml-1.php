<?
if (isset($_REQUEST['grupo'])) :
    require('prc_php.php');
    $GLOBALS['link'] = Connection::getInstance();
    $grupo   = $_REQUEST['grupo'];
    $accesogp = $_REQUEST['accesogp'];
    $idb  = $_REQUEST['idb'] ?? 1;
endif;
?>
<div style="display:none">
    <div id="serial_box"><input size="6" type="100%" style="border:1px solid gray;"
            onClick="(arguments[0]||window.event).cancelBubble=true;" onKeyUp="filterBy()"></div>
    <div id="letra_box"><select style="width:100%" onclick="(arguments[0]||window.event).cancelBubble=true;"
            onChange="filterBy()"></select></div>
    <div id="serial_box1"><input size="6" type="100%" style="border:1px solid gray;"
            onClick="(arguments[0]||window.event).cancelBubble=true;" onKeyUp="filterBy1()"></div>
    <div id="letra_box1"><select style="width:100%" onclick="(arguments[0]||window.event).cancelBubble=true;"
            onChange="filterBy1()"></select></div>
    <div id="serial_box2"><input size="6" type="100%" style="border:1px solid gray;"
            onClick="(arguments[0]||window.event).cancelBubble=true;" onKeyUp="filterBy2()"></div>
    <div id="letra_box2"><select style="width:100%" onclick="(arguments[0]||window.event).cancelBubble=true;"
            onChange="filterBy2()"></select></div>
</div>

<div id="box5" style="background:#033; float:left">
    <br />
    <div align="center"><span style="color:#FC0; font-size:16px">** Ver Jugada **</span></div>
    <br />
    <div id="a_tabbar" style="width:705px; height:435px;" />
</div>
<div id="gridboxTP_tp">
    <div id="gridboxTP" height="390px" style="background-color:#FC0 "></div>
    <div id="pagingArea"></div>
</div>
<div id="gridboxTPG_tp">
    <div id="gridboxTPG" height="390px" style="background-color:#FC0 "></div>
    <div id="pagingArea1"></div>
</div>
<div id="gridboxTG_tp">
    <div id="gridboxTG" height="390px" style="background-color:#FC0 "></div>
    <div id="pagingArea2"></div>
</div>
<div id="gridboxTE_tp">
    <div id="gridboxTE" height="390px" style="background-color:#FC0 "></div>
    <div id="pagingArea3"></div>
</div>

<div id="box1" style="background: #999">
    <table border="0">
        <tr>
            <td><button class="button-pv-standard" style="margin-right: 2px;background: green;" id="BtnImprimir"
                    disabled>Imprimir</button></td>
            <td><button class="button-pv-standard" style="margin-right: 2px;background: #561414;" id="BtnEliminar"
                    disabled onClick="eliminarticketbbByAdmon($('idseleccionado').lang,1);">Eliminar </button></td>
            <td><button class="button-pv-standard" style="margin-right: 2px;" name=""
                    onClick="mygrid1.toPDF('codebase/server/generate.php');">Reporte </button></td>

            </td>
            <td>
                <?
                $textoMensaje = "  Este ticket no puede ser ANULADO, pero puedes introducir tu TOKEN asociado y ANULAR tickets por un tiempo valido de Diez (10) Minutos!";

                require './api-token/form.php'; ?>
            </td>
        </tr>
    </table>

</div>
</div>

<samp id="idseleccionado"></samp><samp id="TagSeleccionado" lang="a1"></samp>
<div id="verticket">
    <?php
    include('ticketbb-2.php');
    ?>
</div>

<samp id='newreq'></samp>
<script>
var idseleccionado = 0;
var accesogp = '<?= $accesogp; ?>';
var grupo = <?= $grupo; ?>;
var idb = <?= $idb; ?>;

function doOnRowSelected(id) {
    if (id < 0) id = id * -1;
    ByView(id, 2);
    $('idseleccionado').lang = id;
    $('BtnImprimir').disabled = '';
    $('BtnEliminar').disabled = '';
}

function my_func(idn, ido) {
    $('TagSeleccionado').lang = idn;
    return true;

};

function doOnCellEdit(stage, rowId, cellInd, newvalue) {

    if (stage == 2) {

        return grabarBycupoBygrupo(rowId, newvalue);

    }
}



function populateSelectWithAuthors(selObj) {
    selObj.options.add(new Option("Todos", ""))
    var usedAuthAr = new dhtmlxArray();
    for (var i = 0; i < mygrid.getRowsNum(); i++) {
        var authNm = mygrid.cells2(i, 1).getValue();
        if (usedAuthAr._dhx_find(authNm) == -1) {
            selObj.options.add(new Option(authNm, authNm))
            usedAuthAr[usedAuthAr.length] = authNm;
        }
    }
}

function populateSelectWithAuthors1(selObj) {
    selObj.options.add(new Option("Todos", ""))
    var usedAuthAr = new dhtmlxArray();
    for (var i = 0; i < mygrid1.getRowsNum(); i++) {
        var authNm = mygrid1.cells2(i, 1).getValue();
        if (usedAuthAr._dhx_find(authNm) == -1) {
            selObj.options.add(new Option(authNm, authNm))
            usedAuthAr[usedAuthAr.length] = authNm;
        }
    }
}

function populateSelectWithAuthors2(selObj) {
    selObj.options.add(new Option("Todos", ""))
    var usedAuthAr = new dhtmlxArray();
    for (var i = 0; i < mygrid2.getRowsNum(); i++) {
        var authNm = mygrid2.cells2(i, 1).getValue();
        if (usedAuthAr._dhx_find(authNm) == -1) {
            selObj.options.add(new Option(authNm, authNm))
            usedAuthAr[usedAuthAr.length] = authNm;
        }
    }
}
//	function doOnEnter(rowId,cellInd){ 
//		alert('Aqui');
//	
//		} 

Nifty('div#box5', 'big');
Nifty('div#box6', 'big');


//// **************************   TABS de los GRID ***************************

tabbar = new dhtmlXTabBar("a_tabbar", "top");

tabbar.attachEvent('onSelect ', my_func);
tabbar.setImagePath("codebase/imgs/");
tabbar.setSkinColors("#FCFBFC", "#F4F3EE", "#FCFBFC");
tabbar.addTab("a1", "Ticket Perdedores", "150px");
tabbar.addTab("a2", "Ticket Posibles a Ganar", "150px");
tabbar.addTab("a3", "Ticket Ganadores (premios)", "150px");
tabbar.addTab("a4", "Ticket Eliminados", "150px");
//tabbar.setStyle("modern");
tabbar.setTabActive("a1");
tabbar.setContent("a1", "gridboxTP_tp");
tabbar.setContent("a2", "gridboxTPG_tp");
tabbar.setContent("a3", "gridboxTG_tp");
tabbar.setContent("a4", "gridboxTE_tp");

dimCol = "60,130,100,100,100,100,100,100,100";
// Llamar para crear XML   
// mientrasProceso('Escrutando', 'Procesando')
// makeResultwin2('procierre.php?op=30&IDJ=' + $('fc').lang + '&accesogp=' + accesogp + '&grupo=' + grupo + '&IDJ1=' + $(
//     'fc1').lang, 'newreq');

// El primer GRID con tickets Perdedores
// makeResultwin2('procierre.php?op=30&IDJ='+$('fc').lang,'newreq');

mygrid = new dhtmlXGridObject('gridboxTP');
mygrid.setImagePath("codebase/imgs/");
mygrid.setHeader("Serial,Letra,Usuario,Hora,Fecha,Apuesta,Cobra,IP,Serial Electronico,esc");
mygrid.setInitWidths(dimCol)
mygrid.setColAlign("right,left,left,right,right,center,left,left,center,center")
mygrid.setColTypes("ro,ed,ro,ro,ro,ro,ro,ro,ro,ro");
mygrid.attachHeader("#connector_text_filter,#connector_select_filter")
mygrid.setColSorting("int,str,str,str,date,int,int,str,str,str")
mygrid.attachEvent("onRowSelect", doOnRowSelected);
mygrid.setSkin("dhx_skyblue");
mygrid.enablePaging(true, 50, 10, "pagingArea", true);
mygrid.setPagingSkin("bricks");
mygrid.init();
mygrid.attachFooter("Total de Ticket (P):{#stat_count},#cspan,#cspan,#cspan,Venta Bsf.: {#stat_total}");
mygrid.setSizes();
mygrid.loadXML("verjugadaxml-3.php?IDJ=" + $('fc').lang + "&tipo=1&activo=1&accesogp=" + accesogp + '&grupo=' + grupo +
    '&IDJ1=' + $('fc1').lang + '&idb=' + idb);


// El primer GRID con tickets Posibles GANADORES
mygrid1 = new dhtmlXGridObject('gridboxTPG');
mygrid1.setImagePath("codebase/imgs/");
mygrid1.setHeader("Serial,Letra,Usuario,Hora,Fecha,Apuesta,Cobra,IP,Serial Electronico");
mygrid1.setInitWidths(dimCol)
mygrid1.setColAlign("right,left,left,left,right,center,left,center,left,center")
mygrid1.setColTypes("ed,ed,ro,ro,ro,ro,ro,ro,ro,ro");
mygrid1.attachHeader("#connector_text_filter,#connector_select_filter")
mygrid1.setColSorting("connector,connector")
mygrid1.setColSorting("int,str,str,str,date,int,int,str,str,str")
mygrid1.attachEvent("onRowSelect", doOnRowSelected);
mygrid1.setSkin("dhx_skyblue");
mygrid1.enablePaging(true, 50, 10, "pagingArea1", true);
mygrid1.setPagingSkin("bricks");

mygrid1.init();
mygrid1.attachFooter(
    "Total de Ticket (SE):{#stat_count},#cspan,#cspan,#cspan,Venta Bsf.: {#stat_total},Premio Bsf.: {#stat_total}");
mygrid1.loadXML("verjugadaxml-3.php?IDJ=" + $('fc').lang + "&tipo=2&activo=1&accesogp=" + accesogp + '&grupo=' + grupo +
    '&IDJ1=' + $('fc1').lang + '&idb=' + idb);


// El primer GRID con tickets GANADORES
mygrid2 = new dhtmlXGridObject('gridboxTG');
mygrid2.setImagePath("codebase/imgs/");
mygrid2.setHeader("Serial,Letra,Usuario,Hora,Fecha,Apuesta,Cobra,IP,Serial Electronico");
mygrid2.setInitWidths(dimCol)
mygrid2.setColAlign("right,left,left,left,right,center,left,center,left,center")
mygrid2.setColTypes("ro,ro,ro,ro,ro,ro,ro,ro,ro");
mygrid2.attachHeader("#connector_text_filter,#connector_select_filter")
mygrid2.setColSorting("int,str,str,str,date,int,int,str,str,str")
mygrid2.attachEvent("onRowSelect", doOnRowSelected);
mygrid2.setSkin("dhx_skyblue");
mygrid2.enablePaging(true, 50, 10, "pagingArea2", true);
mygrid2.setPagingSkin("bricks");
mygrid2.init();
mygrid2.attachFooter(
    "Total de Ticket (G):{#stat_count},#cspan,#cspan,#cspan,Venta Bsf.: {#stat_total},Premio Bsf.: {#stat_total}");
mygrid2.loadXML("verjugadaxml-3.php?IDJ=" + $('fc').lang + "&tipo=3&activo=1&accesogp=" + accesogp + '&grupo=' + grupo +
    '&IDJ1=' + $('fc1').lang + '&idb=' + idb);



// El primer GRID con tickets GANADORES
mygrid3 = new dhtmlXGridObject('gridboxTE');
mygrid3.setImagePath("codebase/imgs/");
mygrid3.setHeader("Serial,Letra,Usuario,Hora,Fecha,Apuesta,Cobra,IP,Serial Electronico");
mygrid3.setInitWidths(dimCol)
mygrid3.setColAlign("right,left,left,left,right,center,left,center,left,center")
mygrid3.setColTypes("ro,ro,ro,ro,ro,ro,ro,ro,ro,ro");
mygrid3.attachHeader("#connector_text_filter,#connector_select_filter")
mygrid3.setColSorting("int,str,str,str,date,int,int,str,str,str")
mygrid3.attachEvent("onRowSelect", doOnRowSelected);
mygrid3.setSkin("dhx_skyblue");
mygrid3.enablePaging(true, 50, 10, "pagingArea3", true);
mygrid3.setPagingSkin("bricks");
mygrid3.init();
mygrid3.attachFooter(
    "Total de Ticket (E):{#stat_count},#cspan,#cspan,#cspan,Eliminados Bsf.: {#stat_total},#cspan,#cspan,#cspan,#cspan"
);
mygrid3.loadXML("verjugadaxml-3.php?IDJ=" + $('fc').lang + "&tipo=3&activo=2&accesogp=" + accesogp + '&grupo=' + grupo +
    '&IDJ1=' + $('fc1').lang + '&idb=' + idb);
</script>