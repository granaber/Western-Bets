<style type="text/css">
    .dhx_toolbar_base_dhx_skyblue div.dhx_toolbar_text {
        color: #fb2250 !important;
        font-size: 15px !important;
    }
</style>

<?
require_once('prc_phpDUK.php');
global $MODE_PRODUCTION;
$link = ConnectionAnimalitos::getInstance();
// Para Activar el Modo DEPLOY solo tiene que crear un acrhivo llamado "deploy.env" en la raiz del proyecto
$mode = modeDetectAnimalitos(); // 0= Modo produccion, bloqueos de Seguridad, 1= Modo Desarrollo, Libre SuperUsuarios
//////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($mode == $MODE_PRODUCTION) {
    $resultj = mysqli_query($link, "SELECT * FROM _Concesionario_Ani  Where IDC='" . $_REQUEST['IDC'] . "'");
    if (mysqli_num_rows($resultj) != 0) :
        $rowj = mysqli_fetch_array($resultj);
        $iTkPagar = $rowj['iTkPagar'];
        if ($rowj['iHb'] != 1) :
            echo '<script>alert("Disculpe! Pero ustede no esta habilitado para vender Animalitos!")</script>';
            exit;
        endif;
    else :
        echo '<script>alert("Disculpe! Pero ustede no esta habilitado para vender Animalitos!")</script>';
        exit;
    endif;
}

$ListaA = array();
$ListaB = array();
$Color = [];
$BgColor = [];
$resultj = mysqli_query($link, "SELECT * FROM _Loterias  Where Activa=1 order by Ord");
while ($row = mysqli_fetch_array($resultj)) {
    $aceptar = false;
    if ($row['IDL'] == 1) :
        $resultjN1 = mysqli_query($link, "SELECT * FROM _Concesionario_Ani  Where IDC='" . $_REQUEST['IDC'] . "'");
        $rowjN1 = mysqli_fetch_array($resultjN1);
        if ($rowjN1['iPremio'] > 0) : $aceptar = true;
        endif;
    else :
        $resultjN1 = mysqli_query($link, "SELECT * FROM _Concesionario_Ani_2  Where IDL=" . $row['IDL'] . " and IDC='" . $_REQUEST['IDC'] . "'");
        if (mysqli_num_rows($resultjN1) != 0) :
            $rowjN1 = mysqli_fetch_array($resultjN1);
            if ($rowjN1['iPremio'] > 0) : $aceptar = true;
            endif;
        endif;
    endif;
    if ($aceptar) :
        $ListaA[] = $row['IDL'];
        $ListaB[] = $row['Nombre'];
        $Color[] = $row['colors'];
        $BgColor[] = $row['bg'];
    endif;
}

?>

<div id='fromventas'>

</div>

<script>
    const valid = windowShow()
    if (!valid) {
        _iLkDUK()
        if (lCloudSorteos.length == 0) {
            alert('No esta disponible la venta en este momento, intente mas tarde... gracias!!')
            exit
        }
        TicketCloud = new Array();
        ArrSort = new Array();
        lCloud = 0;
        ModoIng = 0;
        ObjVnt = 0;
        let TextoLote = ''
        var L1 = '<?= implode(',', $ListaA); ?>';
        var L2 = '<?= implode(',', $ListaB); ?>';
        var CL = '<?= implode(',', $Color); ?>';
        var BL = '<?= implode(',', $BgColor); ?>';
        Rl1 = L1.split(',');
        Rl2 = L2.split(',');
        iIDL = Rl1[0];
        const $lisColorsLottery = CL.split(',');
        const $lisBGLottery = BL.split(',');
        _utxprm = bna('filephp=venta_animalitos-4.php', this);
        new Ajax.Request('animalitos/L!p¡-.php', {
            parameters: {
                uid: _utxprm
            },
            method: 'post',
            asynchronous: false,
            onComplete: function(transport) {
                var response = transport.responseText;
                $('fromventas').innerHTML = response;
            },
            onFailure: function() {
                alert('No tengo respuesta Comuniquese con el Administrador!');
            }
        });

        function clickBar1DUK(id) {
            var Txtnumero = '';
            switch (id) {
                case "All_":
                    for (i = 0; i <= mygridANI.getRowsNum() - 1; i++) {
                        mygridANI.cells2(i, 0).setValue(1);
                        Txtnumero = Txtnumero + mygridANI.cells2(i, 1).getValue();
                    }
                    $('ImpNumero').value = Txtnumero;
                    break;
                case "Clear_":
                    mygridANI.uncheckAll();
                    $('ImpNumero').value = ''
                    break;

            }

        }



        function clickBar2DUK(id) {
            const e = getElementLayout('C')
            e.forEach(o => {
                if (id === 1)
                    o.classList.add('active')
                else
                    o.classList.remove('active')
            })
        }

        function clickBar3DUK(id) {
            switch (id) {
                case 1:
                    selectedId = getSelectedRowId(tBodyGrid)
                    selectedId.forEach(o => {
                        const idx = getIdCol(o)
                        if (idx) {
                            const index = idx - 1
                            TicketCloud[index] = undefined;
                        }
                    })
                    TicketCloud = TicketCloud.compact()
                    TicketCloud.sort(function(a, b) {
                        return a.sorteo - b.sorteo
                    })

                    _restarTicketDUK()
                    break;
                case 2:
                    clearAllGrid(tBodyGrid)
                    TicketCloud = new Array();
                    ArrSort = new Array();
                    lCloud = 0;
                    $('nrsumt').innerHTML = '0';
                    break;

            }
            focus('ImpNumero')

        }

        function doOnCheckAnimalitos(layout) {
            const Txtnumero = [];
            const e = getElementLayout(layout)
            e.forEach(element => {
                if (element.classList.contains('active')) {
                    const [, , n] = element.id.split('-')
                    Txtnumero.push(n)
                }
            })
            $('ImpNumero').value = Txtnumero.join('');
            focus('ImpNumero')
        }

        function handleAnimalitos(iIDL) {
            _utxprm = bna('filephp=animalitos-json.php|IDL=' + iIDL, this);
            const data = handleJson(_utxprm)
            const bspecial = data.esp
            // [{
            // 	id: "23",
            // 	clas: 'ireaxion-btn-extra'
            // }]
            const buttons = loadJSONBtn(data.data, 'ireaxion-btn-spc', handleClickAnimalitos, bspecial)
            setLayout('A', buttons)
        }

        function handleSorteos(iIDL) {
            _utxprm = bna('filephp=sorteos-json.php|usu=' + $('usu').title + '|IDL=' + iIDL, this);
            const data = handleJson(_utxprm)
            const sorteos = loadJSONBtn(data, 'ireaxion-btn-spc-2', handleClickSorteos)
            setLayout('C', sorteos)
            const e = getElementLayout('C')
            if (e.length !== 0) {
                e[0].classList.add('active')
            }
        }

        function handleClickSorteos(i, idx, o) {
            const sorteoCheck = idx
            const obj = o
            _chek_sorteoDUK(sorteoCheck, obj)
            focus('ImpNumero')
        }

        function handleClickAnimalitos(i, idx, o) {
            o.classList.toggle('active')
            doOnCheckAnimalitos('A')
        }

        function handlenClick(id, texto) {
            setText(TextoLote, texto)
            changeColorFrame($lisColorsLottery[id], $lisBGLottery[id])
            const nIDL = Rl1[id]
            handleAnimalitos(nIDL)
            handleSorteos(nIDL)
            _valida1('<?= $_REQUEST['IDC']; ?>', nIDL)
            $('ImpNumero').value = ""
            $('ImpMonto').value = ""
            focus('ImpNumero')

        }

        function clicktoolBar(id) {
            switch (id) {
                case "Cerrar_":
                    windowHidden()
                    break;
                case "Imprimir_":
                    mygrid3 = getRowsGrid(tBodyGrid)
                    if (mygrid3.length !== 0)
                        _grabarJugadaDUK()
                    else
                        alert('No hay nada que Imprimir!')

                    break;
                case "Ver_":
                    _callBackDUK('animalitos/ver_jugada-pv.php')
                    break;
                case "Pagar_":
                    _callBackDUK('animalitos/Ani_PagarTk-1.php')
                    break;
                case "id1":
                    _callBackDUK('animalitos/Ani_ReportePV-1.php')
                    break;
                case "id2":
                    _callBackDUK('animalitos/Ani_ReportePVDT-1.php')
                    break;
                case "id3":
                    _callBackDUK('animalitos/Ani_ReportePVTP-1.php')
                    break;
                case "id4":
                    _callBackDUK('animalitos/Ani_Resultados.php')
                    break;
            }
            // }
        }

        _valida1('<?= $_REQUEST['IDC']; ?>', iIDL)
        const winx = createwindow('ANIMALITOS', '1000px', '750px', <?= $mode != $MODE_PRODUCTION ?>)
        toolBar = attachToolbar(winx)
        addButton(toolBar, 'animalitos/icons/icons8-eliminar-30.png', null, 'Cerrar', function a() {
            clicktoolBar('Cerrar_')
        })
        addButton(toolBar, 'animalitos/icons/icons8-enviar-a-la-impresora-30.png', null, 'Imprimir', function a() {
            clicktoolBar('Imprimir_')

        })
        // addButton(toolBar, 'animalitos/icons/icons8-copiar-30.png', null, 'Copiar Ticket', function a() {
        // 	clicktoolBar('_Cerrar')

        // })
        addButton(toolBar, 'animalitos/icons/icons8-busqueda-de-propiedad-30.png', null, 'Ver Jugadas', function a() {
            clicktoolBar('Ver_')
        })

        addButton(toolBar, 'animalitos/icons/icons8-paga-30.png', null, 'Pagar Ticket', function a() {
            clicktoolBar('Pagar_')
        })
        const opts = [{
                text: 'Ventas Resumida',

                cb: function() {
                    clicktoolBar('id1')
                }
            }, {
                text: 'Ventas Detalladas',
                cb: () => clicktoolBar('id2')
            },
            {
                text: 'Ticket Pagados',
                cb: () => clicktoolBar('id3')
            },
            {
                text: 'Resultados',
                cb: () => clicktoolBar('id4')
            }
        ]
        addButtonSelect(toolBar, 'animalitos/icons/icons8-informe-de-ganancias-30.png', 'Reportes', opts)
        const opts2 = [];
        for (i = 0; i < Rl2.size(); i++) {
            const d = Rl1[i]
            opts2.push({
                text: Rl2[i],
                colorvi: $lisColorsLottery[i],
                cb: (idx, texto) => handlenClick(idx, texto)
            })

        }

        changeColorFrame($lisColorsLottery[0], $lisBGLottery[0])

        addButtonSelect(toolBar, 'animalitos/icons/icons8-hand-drag-30.png', 'Animalitos', opts2)
        TextoLote = addText(toolBar, Rl2[0], '#fff700', 18, '26%')
        Layout(winx, '3V', ['33%', '33%', '26%'])
        const toolBarC = attachToolbarLayout('C')

        addButton(toolBarC, null, null, 'Todos', function a() {
            clickBar2DUK(1)
        })
        addButton(toolBarC, null, null, 'Limpiar', function a() {
            clickBar2DUK(2)
        })
        handleAnimalitos(iIDL)

        handleSorteos(iIDL)
        addClassFramer("B", "ireaxion-class-fmr-ventas")
        attachObjectFramer("B", "fromventas", winx)
        const optb = [{
                text: 'Eliminar Linea',
                cb: () => {
                    clickBar3DUK(1)
                }
            },
            {
                text: 'Limpiar',
                cb: () => {
                    clickBar3DUK(2)
                }
            },

        ]
        createrSubFramer('B', 'ireaxion-class-frm-tk', 'Ticket Virtual', optb)
        const col = [{
            id: 1,
            text: 'Ln',
            width: 0
        }, {
            id: 2,
            text: 'Jugada',
            width: 0
        }, {
            id: 3,
            text: 'Monto',
            width: 0
        }, ]
        tBodyGrid = createGrid('B', col)
        addFooterGrid('B',
            "<h5 style='display:inline-block;color:white;width:35%;margin:1px 2px'>Total Ticket</h5><div id='nrsumt' style='display:inline-block;font-size:18px;color:yellow'>0</div>"
        )
        focus('ImpNumero')
    } else {
        handleSorteos(iIDL)
        $('ImpNumero').focus()
        xCampACT = 'ImpNumero';
    }
</script>