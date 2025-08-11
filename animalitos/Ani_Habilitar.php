<?
require('prc_phpDUK.php');
global $serverD;
global $userD;
global $clvD;
global $dbD;
$link = mysqli_connect($serverD, $userD, $clvD, $dbD);

$op = 1; //$_REQUEST['op'];
$rndusr = $_COOKIE['rndusr'] ?? -1;
$accesoBanca = getAccessByCookie($rndusr);
if ($accesoBanca == -1) {
    echo "<script>alert('No tiene acceso a esta opción');</script>";
    exit;
}
?>
<style>
    .input-habilitar {
        padding: 2px;
        font-size: 13px;
        width: 110px;
        border-radius: 4px;
        border: 1px solid #ccc;
        margin: 2px 0px;
    }

    .input-habilitar:focus {
        outline: auto #99bbe8;
    }

    .select-habilitar {

        margin-top: 3px;

        height: 22px;
        border: none;
        border-radius: 4px;
    }
</style>
<div id="obj">

</div>
<div id="coc">

</div>

<div id="cocN1">

</div>
<div id="from_General">
    <div id="get_div_content"></div>
</div>
<div id="wait-load-hb" style="display: none;
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
        Espere un momento...
    </h3>

</div>

<script>
    var IDC;
    var IDG;
    var idRowBAN = 0;
    var idRowGRU = 0;
    var $Nivel = '';


    function handlenChangeGeneral() {
        async function handlerBarWindowChange(id) {

            switch (id) {
                case "Cerrar_":
                    dhxChangeWindows.window("w2").close();
                    const div_content = document.getElementById('get_div_content')
                    if (div_content === null) {
                        const div = document.createElement('div')
                        div.id = "get_div_content"
                        const main_content = document.getElementById('from_General')
                        main_content.appendChild(div)
                    }
                    break;
                case "Asignar_":
                    document.getElementById('wait-load-hb').style['display'] = 'block'
                    save_Datt()
                    break

            }
        }

        const dhxChangeWindows = new dhtmlXWindows();
        dhxChangeWindows.setImagePath("codebase/imgs/");
        const w2 = dhxChangeWindows.createWindow("w2", 100, 270, 470, 450);
        w2.setText("Configuración GENERAL");
        w2.attachObject('get_div_content');
        dhxChangeWindows.window("w2").button('close').hide();
        dhxChangeWindows.window("w2").button('minmax1').hide();
        dhxChangeWindows.window("w2").button('minmax2').hide();
        dhxChangeWindows.window("w2").button('park').hide();
        dhxChangeWindows.window('w2').setModal(true);
        dhxChangeWindows.window("w2").centerOnScreen();
        const barChange = w2.attachToolbar();
        barChange.addButton("Cerrar_", 1, "Cerrar", "animalitos/icons/noun_1042920_cc.png",
            "animalitos/icons/noun_1042920_cc.png");
        barChange.addButton("Asignar_", 2, "Asignar", "animalitos/icons/noun_976547_cc.png",
            "animalitos/icons/noun_976547_cc.png");
        barChange.attachEvent("onClick", handlerBarWindowChange);

        new Ajax.Request('animalitos/Ani_Habilitar_General.php', {
            parameters: {
                uid: _utxprm
            },
            method: 'post',
            asynchronous: false,
            onComplete: function(transport) {
                const response = transport.responseText;

                $('get_div_content').innerHTML = response
                response.evalScripts();
            },
            onFailure: function() {
                alert('No tengo respuesta Comuniquese con el Administrador!');
            }
        });
    }

    function clicktoolBar(id) {

        switch (id) {
            case "Cerrar_":
                dhxWins1.window("w1").close();
                break;
            case "Change_":
                handlenChangeGeneral()
        }
    }

    function Asignacion(id) {
        switch (id) {
            case 'Asignar_':
                if (IDC != -1 && IDG != -1) {
                    if ($('iHb').checked) iHb = 1;
                    else iHb = 0;
                    if ($('iTkPagar').checked) iTkPagar = 1;
                    else iTkPagar = 0;
                    //IDC,IDL,iPremio,iMontSort,iMontMin,iMontMax
                    LCloud = new Array();
                    lCloud = 0;
                    iIDL = parseInt($('cIDL').lang);
                    for (i = 1; i <= iIDL; i++) {
                        uno = 0;
                        dos = 0;
                        tres = 0;
                        if (isset('iPremio' + i + '_1')) uno = $('iPremio' + i + '_1').value;
                        if (isset('iPremio' + i + '_2')) dos = $('iPremio' + i + '_2').value;
                        if (isset('iPremio' + i + '_3')) tres = $('iPremio' + i + '_3').value;
                        lineaOBJ = {
                            IDL: i,
                            iPremio1: uno,
                            iPremio2: dos,
                            iPremio3: tres,
                            iMontMin: $('iMinimo' + i).value,
                            iMontMax: $('iMaximo' + i).value,
                            iMontSort: $('iMontSort' + i).value,
                            iAceptoPorcentaje: $('iAceptoPorcentaje' + i).value,
                            iPVentas: $('iPVentas' + i).value,
                            iMontMaxTripleta: isset('iMontMaxTripleta' + i) ? $('iMontMaxTripleta' + i).value : 0,
                            iPremioTripleta: isset('iPremioTripleta' + i) ? $('iPremioTripleta' + i).value : 0,
                            iPremioProx: $('iPremioProx' + i).value

                        }
                        LCloud[lCloud] = lineaOBJ;
                        lCloud++;
                    }
                    // +'|iPremio='+$('iPremio').value+'|iMontMin='+$('iMinimo').value+'|iMontMax='+$('iMaximo').value+'|iMontSort='+$('iMontSort').value
                    _callBackGENDUK('Ani_Habilitar-3.php', '|op=1|IDC=' + IDC + '|iTkPagar=' + iTkPagar + '|iHb=' + iHb +
                        '|iPVenta=' + $('iVenta').value + '|iPParti=' + $('iParti').value + '|iPParti2=' + $('iParti2')
                        .value + '|iTkElim=' + $('iTkElim').value + '|iAceptoPorcentaje=' + $('iAceptoPorcentaje')
                        .value + '|Datos=' + Object.toJSON(
                            LCloud), "coc");
                } else
                    nalert('Error', 'Debe Indicar a que Elemento (Banca,Grupo,Punto de Venta)');
                break;
            case "Asignar2_":
                LCloud = new Array();
                lCloud = 0;
                iIDL = parseInt($('cIDL').lang);
                for (i = 1; i <= iIDL; i++) {
                    lineaOBJ = {
                        IDL: i,
                        iMontSort: $('iMontSort' + i).value,
                        iMontMaxNum: $('iMontMaxNum' + i).value,
                    }
                    LCloud[lCloud] = lineaOBJ;
                    lCloud++;
                }
                _callBackGENDUK('Ani_Habilitar-3.php', '|op=9|IDG=' + IDG + '|Datos=' + Object.toJSON(
                    LCloud), "coc");
                break
            case "Animalitos_":
                if ($Nivel == 'B') {
                    if (idRowBAN != 0) {
                        _callBackGENDUK('Ani_Habilitar-6.php', '|id=' + idRowBAN + '|sor=' + mygrid1.cells(idRowBAN, 1)
                            .getValue(), "coc");
                    } else
                        nalert('ERROR', 'DEBE SELECCIONAR PRIMERO EL SORTEO !');
                }
                if ($Nivel == 'G') {
                    if (idRowGRU != 0) {
                        _callBackGENDUK('Ani_Habilitar-8.php', '|IDG=' + IDG + '|id=' + idRowGRU + '|sor=' + mygrid1.cells(
                            idRowGRU, 1).getValue(), "coc");
                    } else
                        nalert('ERROR', 'DEBE SELECCIONAR PRIMERO EL SORTEO !');
                }

                break;
        }

    }

    function doOnRowSelected(id, col, status) {
        col = col - 3;

        // Cambio Coordenadas;
        idchg = Encabezados[4][col];
        colcng = Encabezados[5][id];

        mygrid.cellById(idchg, colcng + 3).setValue(status);

    }


    function doSelectRow(id) {
        IdSelecJx = id;
        Texto1Jx = mygrid.cellById(id, 1).getValue();
        Texto2Jx = mygrid.cellById(id, 2).getValue();
    }

    function tonclick(id) {
        vernivel = id.split('$');
        switch (vernivel[0]) {
            case '1':
                $Nivel = 'G';
                IDC = 0;
                IDG = vernivel[1];
                dhxLayout.cells("b").setText('( Grupo ' + IDG + ' ' + tree.getItemText(id) + ' )');
                dhxLayout.cells("b").setText('(BANCA GENERAL)');
                dhxLayout.cells("b").showToolbar();
                barGri.showItem("Asignar2_");
                barGri.hideItem("Asignar_");

                const _utxprmG = bna('filephp=Ani_Habilitar-2-G.php|IDG=' + IDG, this);
                new Ajax.Request('animalitos/_.php', {
                    parameters: {
                        uid: _utxprmG
                    },
                    method: 'post',
                    asynchronous: false,
                    onComplete: function(transport) {
                        var response = transport.responseText;
                        dhxLayout.cells("b").attachHTMLString(response);
                    },
                    onFailure: function() {
                        alert('No tengo respuesta Comuniquese con el Administrador!');
                    }
                });

                // mygrid1 = dhxLayout.cells("b").attachGrid();
                // mygrid1.setImagePath("codebase/imgs/");
                // mygrid1.setHeader("No,Sorteo,Maximo de Venta");
                // mygrid1.setInitWidths("40,200,120")
                // mygrid1.setColAlign("left,left,right")
                // mygrid1.setColTypes("ro,ro,ed");
                // mygrid1.setSkin("dhx_skyblue");
                // mygrid1.attachEvent("onRowSelect", doOnRowSelectedGRU);
                // mygrid1.init();
                // mygrid1.loadXML("animalitos/Ani_Habilitar-5.php?IDG=" + IDG);
                // mygrid1.attachEvent("onEditCell", function(stage, rId, cInd, nValue, oValue) {

                //     if (stage == 2) {
                //         _callBackGENDUK('Ani_Habilitar-3.php', '|op=3|IDG=' + IDG + '|IDS=' + rId + '|Tope=' +
                //             nValue, 'coc');
                //         return true;
                //     }
                // });
                break;
            case 'Banca':
                $Nivel = 'B';
                IDC = 0;
                IDG = 0;
                dhxLayout.cells("b").setText('(BANCA GENERAL)');
                dhxLayout.cells("b").showToolbar();
                barGri.hideItem("Asignar_");
                barGri.showItem("Asignar2_");
                mygrid1 = dhxLayout.cells("b").attachGrid();
                mygrid1.setImagePath("codebase/imgs/");
                mygrid1.setHeader("No,Sorteo,Maximo de Venta");
                mygrid1.setInitWidths("40,200,120")
                mygrid1.setColAlign("left,left,right")
                mygrid1.setColTypes("ro,ro,ed");
                mygrid1.setSkin("dhx_skyblue");
                mygrid1.attachEvent("onRowSelect", doOnRowSelectedBAN);
                mygrid1.init();
                mygrid1.loadXML("animalitos/Ani_Habilitar-4.php");
                mygrid1.attachEvent("onEditCell", function(stage, rId, cInd, nValue, oValue) {

                    if (stage == 2) {

                        _callBackGENDUK('Ani_Habilitar-3.php', '|op=2|IDS=' + rId + '|Tope=' + nValue, 'coc');
                        return true;
                    }
                });

                break;
            default:
                IDC = vernivel[0];
                IDG = 0;
                dhxLayout.cells("b").setText('( Concesionario ' + tree.getItemText(id) + ' )');
                dhxLayout.cells("b").showToolbar();
                barGri.showItem("Asignar_");
                barGri.hideItem("Asignar2_");
                const _utxprm = bna('filephp=Ani_Habilitar-2.php|IDC=' + IDC + '|usu=' + $('usu').title, this);
                new Ajax.Request('animalitos/_.php', {
                    parameters: {
                        uid: _utxprm
                    },
                    method: 'post',
                    asynchronous: false,
                    onComplete: function(transport) {
                        var response = transport.responseText;
                        dhxLayout.cells("b").attachHTMLString(response);
                    },
                    onFailure: function() {
                        alert('No tengo respuesta Comuniquese con el Administrador!');
                    }
                });
        }

    }

    function doOnRowSelectedBAN(id) {
        idRowBAN = id;
    }

    function doOnRowSelectedGRU(id) {
        idRowGRU = id;
    }

    function clickNuevaRegla() {
        if (deport != 0 && (IDC != -1 || IDG != -1))
            makeResultwin2("reglamentoI-3.php?Grupo=" + deport + "&IDC=" + IDC + "&IDG=" + IDG, 'porcentaje');
        else
            nalert('Error', 'Debe Indicar a que Elemento (Banca,Grupo,Punto de Venta) va Asignar el Reglamento');


    }

    function clickNuevaReglaJugadas() {
        if (deport != 0 && (IDC != -1 || IDG != -1))
            makeResultwin2("reglamentoI-5.php?Grupo=" + deport + "&IDC=" + IDC + "&IDG=" + IDG + '&IDDD=' + IdSelecJx,
                'porcentaje');
        else
            nalert('Error',
                'Debe Indicar a que Elemento (Banca,Grupo,Punto de Venta) va Asignar el Reglamento y Ademas la Apuesta que va asignar el tope'
            );


    }
    dhxWins1 = new dhtmlXWindows();
    dhxWins1.setImagePath("codebase/imgs/");
    w1 = dhxWins1.createWindow("w1", 100, 270, 830, 1000);
    w1.setText("Configuracion de Puntos de Venta");
    dhxWins1.window("w1").button('close').hide();
    dhxWins1.window("w1").button('minmax1').hide();
    dhxWins1.window("w1").button('minmax2').hide();
    dhxWins1.window("w1").button('park').hide();
    dhxWins1.window('w1').setModal(true);
    dhxWins1.window("w1").centerOnScreen();
    var bar = w1.attachToolbar();
    bar.addButton("Cerrar_", 1, "Cerrar", "animalitos/icons/noun_1042920_cc.png", "animalitos/icons/noun_1042920_cc.png");
    <?php if ($accesoBanca == 0) { ?>
        bar.addButton("Change_", 2, "Cambios Generales", "animalitos/icons/noun_502136.png",
            "animalitos/icons/noun_502136.png");
    <?php } ?>
    bar.attachEvent("onClick", clicktoolBar);
    dhxLayout = new dhtmlXLayoutObject(w1, "2U");
    dhxLayout.cells("a").setText("Puntos de Ventas/Grupos");
    dhxLayout.cells("b").setText("Configuracion");



    var tree = dhxLayout.cells("a").attachTree();
    tree.setImagePath("animalitos/icons/csh_vista/");
    tree.enableDragAndDrop(1, 0);
    tree.setOnClickHandler(tonclick);
    tree.loadXML("animalitos/Ani_Habilitar-1.php?op=<?= $op; ?>&accesoBanca=<?= $accesoBanca ?>");

    barGri = dhxLayout.cells("b").attachToolbar();
    barGri.addButton("Asignar_", 1, "Asignar", "animalitos/icons/noun_976547_cc.png",
        "animalitos/icons/noun_976547_cc.png");
    barGri.addButton("Asignar2_", 2, "Asignar", "animalitos/icons/noun_1060376_cc.png",
        "animalitos/icons/noun_1060376_cc.png");
    barGri.attachEvent("onClick", Asignacion);
    dhxLayout.cells("b").hideToolbar();
</script>