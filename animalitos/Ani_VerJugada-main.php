<?
require_once('prc_phpDUK.php');
global $serverD;
global $userD;
global $clvD;
global $dbD;

$conexion = mysqli_connect($serverD, $userD, $clvD, $dbD);

$ranUsu = $_COOKIE["rndusr"];
$iGrupo = 0;
$result = mysqli_query($conexion, "SELECT * FROM _tusu where bloqueado='$ranUsu'");
if (mysqli_num_rows($result) == 0) :
    echo "<script> alert('Disculpe pero su usuario fue abierto en otro maquina! No puedo darle la opcion '); </script>";
    exit;
endif;
$row = mysqli_fetch_array($result);
if ($row['Tipo'] == 4 && $row['AGrupo'] != '0') {
    $iGrupo = $row['AGrupo'];
}

?>
<div id="Box5xAudi" style="background:#999;width:1000px; height:1000px;">
    <div style="float:left">
        <br />
        <div align="center"><span style="color:#000; font-size:16px">** Ver Jugada ANIMALITOS **</span></div>
        <br />
        <div id="a_tabbarVJ" style="width:705px; height:435px;"></div>

        <div id="gridboxTP_tpVJ">
            <div id="gridboxTPVJ" height="390px" style="background-color:#FC0 "></div>
            <div id="pagingAreaVJ"></div>
        </div>
        <div id="gridboxTPG_tpVJ">
            <div id="gridboxTPGVJ" height="390px" style="background-color:#FC0 "></div>
            <div id="pagingArea1VJ"></div>
        </div>
        <div id="gridboxTG_tpVJ">
            <div id="gridboxTGVJ" height="390px" style="background-color:#FC0 "></div>
            <div id="pagingArea2VJ"></div>
        </div>
        <div id="gridboxTE_tpVJ">
            <div id="gridboxTEVJ" height="390px" style="background-color:#FC0 "></div>
            <div id="pagingArea3VJ"></div>
        </div>

    </div>


    <samp id="idseleccionado"></samp><samp id="TagSeleccionado" lang="a1"></samp><br />
    <br />
    <br />
    <br />

    <div id="verticket">
        <div><samp id="nDatos" lang="-"></samp>
            <table height="420" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td rowspan="2">
                        <div style="margin-top:0px; margin-left:0px">
                            <div class="shadowcontainerx2">
                                <div class="innerdivx2">
                                    <div align="center" style="font-size:14px;color:#000"><strong>Ticket Virtual
                                        </strong></div>
                                    <table height="320" border="0" cellpadding="0" cellspacing="0">

                                        <tr>
                                            <td align="left"><samp id="printer3"></samp></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr> </tr>
            </table>
        </div>
    </div>
</div>
<samp id='newreq'></samp>
<div id="vista">
    <div id="obj2">
        <div id="Calen1" />
    </div>
</div>
</div>
<div id="wait-load" style="display: none;
    top: 0;
    z-index: 99;
    position: absolute;
    width: 100vw;
    height: 100vh;
    background: #adaecaad;">
    <h3 style="text-align: center;
    width: 100%;
    height: 100%;
    color: black;
    align-items: center;
    display: flex;
    justify-content: center;
    font-size: 22px;">
        Espere un momento...<samp id='wait-load-count'>0/4</samp>
    </h3>

</div>
<script>
    var fc = '<?= FecharealAnimalitos($minutosh, "d/n/Y"); ?>';
    var SerialSelec = 0
    var IDG = '<?= $iGrupo; ?>';
    var IDL = 0;
    var iWaitList = []

    function doOnRowSelected(id) {
        SerialSelec = id;
        ByViewDUK(id, 2);
    }

    function my_func(idn, ido) {
        $('TagSeleccionado').lang = idn;
        return true;
    }

    function doOnCellEdit(stage, rowId, cellInd, newvalue) {
        if (stage == 2) {
            return grabarycupoBygrupo(rowId, newvalue);
        }
    }

    function calendario() {
        dhxWins2 = new dhtmlXWindows();
        dhxWins2.setImagePath("codebase/imgs/");
        var w2 = dhxWins2.createWindow("w2", 450, 110, 190, 210);
        w2.clearIcon();
        dhxWins2.window("w2").button('close').hide();
        dhxWins2.window("w2").button('minmax1').hide();
        dhxWins2.window("w2").button('minmax2').hide();
        dhxWins2.window("w2").button('park').hide();
        w2.setText("");
        w2.attachObject('obj2');
        mCal = new dhtmlxCalendarObject('Calen1');
        mCal.attachEvent("onClick", mSelectDate);
        mCal.setSkin("dhx_black");
        mCal.loadUserLanguage('es');
        mCal.draw();
    }

    function mSelectDate(date) {
        $('vista').innerHTML = '<div id="obj2"><div id="Calen1"/></div></div>';
        fecha = mCal.getFormatedDate("%d/%c/%Y", date);
        barVer.setItemText('TextoFecha', 'Fecha: ' + fecha);
        fc = fecha
        dhxWins2.window("w2").close();
        CallGridNew();
    }

    function CallGridNew() {
        iWaitList = []
        document.getElementById('wait-load').style['display'] = 'block'
        mygridV1.clearAll();

        mygridV1.loadXML("animalitos/ver_jugada-Adm.php?op=1&fecc=" + fc + "&Activo=1&IDG=" + IDG + "&IDL=" + IDL +
            "&connector=true&dhx_colls=1",
            function() {
                waitOff(1)
            });
        mygridV2.clearAll();
        mygridV2.loadXML("animalitos/ver_jugada-Adm.php?op=2&fecc=" + fc + "&Activo=1&IDG=" + IDG + "&IDL=" + IDL +
            "&connector=true&dhx_colls=1,2",
            function() {
                waitOff(2)
            });
        mygridV2.refreshFilters();

        mygridV3.clearAll();
        mygridV3.loadXML("animalitos/ver_jugada-Adm.php?op=3&fecc=" + fc + "&Activo=1&IDG=" + IDG + "&IDL=" + IDL +
            "&connector=true&dhx_colls=1",
            function() {
                waitOff(3)
            });
        mygridV4.clearAll();
        mygridV4.loadXML("animalitos/ver_jugada-Adm.php?op=4&fecc=" + fc + "&Activo=0&IDG=" + IDG + "&IDL=" + IDL +
            "&connector=true&dhx_colls=1",
            function() {
                waitOff(id)
            });

    }

    function waitOff(id) {
        if (iWaitList.length >= 3) {
            iWaitList = []
            document.getElementById('wait-load').style['display'] = 'none'
            return
        }
        iWaitList.push(id)
        document.getElementById('wait-load-count').innerHTML = iWaitList.length + '/4'

    }

    function clicktoolBarVer(id) {
        ver = id.split('-');

        if (ver.size() !== 3) {
            switch (id) {
                case "Cerrar_":
                    dhxWinsVer.window("wVer1").close();
                    break;
                case "Calendario_":
                    calendario();
                    break;
                case "Anular_":
                    Anular_ticket(SerialSelec);
                    break;
                case "ImpCopy_":
                    ReimprimirTK(SerialSelec, 2);
                    break;
                case "All":
                    barVer.setItemText('IDse', 'Todos');
                    IDG = 0;
                    CallGridNew();
                    break;
                case "AllLot":
                    IDL = 0;
                    barVer.setItemText('IDlot', 'Todos');
                    CallGridNew();
                    break;
            }
            return
        }
        if (ver[0] === 'G') {
            IDG = ver[1];
            barVer.setItemText('IDse', ver[1] + '-' + ver[2]);
            CallGridNew()
            return
        }
        barVer.setItemText('IDlot', ver[1] + '-' + ver[2]);
        IDL = ver[1];
        CallGridNew()
    }


    dhxWinsVer = new dhtmlXWindows();
    dhxWinsVer.setImagePath("codebase/imgs/");
    wVer1 = dhxWinsVer.createWindow("wVer1", 220, 100, 980, 760);
    wVer1.setText("Ver Jugada");
    wVer1.attachObject('Box5xAudi');
    dhxWinsVer.window("wVer1").button('close').hide();
    dhxWinsVer.window("wVer1").button('minmax1').hide();
    dhxWinsVer.window("wVer1").button('minmax2').hide();
    dhxWinsVer.window("wVer1").button('park').hide();
    dhxWinsVer.window('wVer1').setModal(true);

    var barVer = wVer1.attachToolbar();
    barVer.loadXML("animalitos/docbuttomVP.php?IDG=<?= $iGrupo; ?>&etc=" + new Date().getTime(), function() {
        barVer.addText('TextoFecha', 4, 'Fecha:' + fc);
        barVer.addButton("Calendario_", 5, "", "animalitos/icons/noun_932012_cc.png",
            "animalitos/icons/noun_932012_cc.png");
    });
    barVer.attachEvent("onClick", clicktoolBarVer);
    //// **************************   TABS de los GRID ***************************

    tabbarVer = new dhtmlXTabBar("a_tabbarVJ", "top");

    tabbarVer.attachEvent('onSelect ', my_func);
    tabbarVer.setImagePath("codebase/imgs/");
    tabbarVer.setSkinColors("#FCFBFC", "#F4F3EE", "#FCFBFC");
    tabbarVer.addTab("a1VJ", "Ticket Impresos", "150px");
    tabbarVer.addTab("a2VJ", "Ticket Ganadores", "150px");
    tabbarVer.addTab("a3VJ", "Ticket Perdedores", "150px");
    tabbarVer.addTab("a4VJ", "Ticket Eliminados", "150px");
    //tabbar.setStyle("modern");
    tabbarVer.setTabActive("a1VJ");
    tabbarVer.setContent("a1VJ", "gridboxTP_tpVJ");
    tabbarVer.setContent("a2VJ", "gridboxTPG_tpVJ");
    tabbarVer.setContent("a3VJ", "gridboxTG_tpVJ");
    tabbarVer.setContent("a4VJ", "gridboxTE_tpVJ");

    dimCol = "60,100,80,80,100,120,100,180,0";
    // Llamar para crear XML

    // El primer GRID con tickets Impreso
    // makeResultwin2('procierre.php?op=30&IDJ='+$('fc').lang,'newreq');

    mygridV1 = new dhtmlXGridObject('gridboxTPVJ');
    mygridV1.setImagePath("codebase/imgs/");
    mygridV1.setHeader("Serial,Punto de Venta,Hora,Fecha,Monto,Cantidad de Numeros");
    mygridV1.setInitWidths(dimCol)
    mygridV1.setColAlign("right,left,right,right,right,left,left")
    mygridV1.setColTypes("ro,ro,ro,ro,ro,ro,ro");
    mygridV1.attachHeader("#connector_text_filter,#connector_select_filter")
    mygridV1.setColSorting("int,str,str,date,int,int")
    mygridV1.attachEvent("onRowSelect", doOnRowSelected);
    mygridV1.setSkin("dhx_skyblue");
    mygridV1.enablePaging(true, 50, 10, "pagingAreaVJ", true);
    mygridV1.setPagingSkin("bricks");
    mygridV1.init();
    mygridV1.attachFooter("Total de Ticket (P):{#stat_count},#cspan,#cspan,#cspan,Venta Bsf.: {#stat_total}");
    mygridV1.setSizes();
    mygridV1.loadXML("animalitos/ver_jugada-Adm.php?op=1&Activo=1&IDG=" + IDG + "&IDL=" + IDL);


    // El primer GRID con tickets  GANADORES
    mygridV2 = new dhtmlXGridObject('gridboxTPGVJ');
    mygridV2.setImagePath("codebase/imgs/");
    mygridV2.setHeader("Serial,Pagado,Punto de Venta,Hora,Fecha,Monto,Premio,Gano con..,Detalles de Pago");
    mygridV2.setInitWidths("60,70,100,80,80,100,120,180,150")
    mygridV2.setColAlign("right,left,left,left,left,right,left,left,left")
    mygridV2.setColTypes("ro,ro,ro,ro,ro,ro,ro,ro,ro");
    mygridV2.attachHeader("#connector_text_filter,#connector_select_filter,#connector_select_filter")
    mygridV2.setColSorting("int,str,str,str,date,int,int,str")
    mygridV2.attachEvent("onRowSelect", doOnRowSelected);
    mygridV2.setSkin("dhx_skyblue");
    mygridV2.enablePaging(true, 50, 10, "pagingArea1VJ", true);
    mygridV2.setPagingSkin("bricks");
    mygridV2.init();
    mygridV2.attachFooter(
        "Total de Ticket (SE):{#stat_count},#cspan,#cspan,#cspan,#cspan,Venta Bsf.: {#stat_total},Premio Bsf.: {#stat_total}"
    );
    mygridV2.loadXML("animalitos/ver_jugada-Adm.php?op=2&Activo=1&IDG=" + IDG + "&IDL=" + IDL);

    // El primer GRID con tickets PERDEDORES
    mygridV3 = new dhtmlXGridObject('gridboxTGVJ');
    mygridV3.setImagePath("codebase/imgs/");
    mygridV3.setHeader("Serial,Punto de Venta,Hora,Fecha,Monto,Cantidad de Numeros");
    mygridV3.setInitWidths(dimCol)
    mygridV3.setColAlign("left,left,left,left,right,right")
    mygridV3.setColTypes("ro,ro,ro,ro,ro,ro,ro");
    mygridV3.attachHeader("#connector_text_filter,#connector_select_filter")
    mygridV3.attachEvent("onRowSelect", doOnRowSelected);
    mygridV3.setSkin("dhx_skyblue");
    mygridV3.enablePaging(true, 50, 10, "pagingArea2VJ", true);
    mygridV3.setPagingSkin("bricks");
    mygridV3.init();
    mygridV3.attachFooter("Total de Ticket (P):{#stat_count},#cspan,#cspan,#cspan,Venta Bsf.: {#stat_total}");
    mygridV3.loadXML("animalitos/ver_jugada-Adm.php?op=3&Activo=1&IDG=" + IDG + "&IDL=" + IDL);


    // El primer GRID con tickets ELIMINADOS
    mygridV4 = new dhtmlXGridObject('gridboxTEVJ');
    mygridV4.setImagePath("codebase/imgs/");
    mygridV4.setHeader("Serial,Punto de Venta,Hora,Fecha,Monto,Cantidad de Numeros,Hora de Eliminacion");
    mygridV4.setInitWidths("60,100,80,80,100,120,130")
    mygridV4.setColAlign("right,left,left,right,right,right,left,right")
    mygridV4.setColTypes("ro,ro,ro,ro,ro,ro,ro,ro");
    mygridV4.attachHeader("#connector_text_filter,#connector_select_filter")
    mygridV4.setColSorting("int,str,str,date,int,int,str")
    mygridV4.attachEvent("onRowSelect", doOnRowSelected);
    mygridV4.setSkin("dhx_skyblue");
    mygridV4.enablePaging(true, 50, 10, "pagingArea3VJ", true);
    mygridV4.setPagingSkin("bricks");
    mygridV4.init();
    mygridV4.attachFooter("Total de Ticket (P):{#stat_count},#cspan,#cspan,#cspan,Venta Bsf.: {#stat_total}");
    mygridV4.loadXML("animalitos/ver_jugada-Adm.php?op=4&Activo=0&IDG=" + IDG + "&IDL=" + IDL);
</script>