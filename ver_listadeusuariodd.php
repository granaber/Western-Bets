<?
require('prc_php.php');
$link = Connection::getInstance();
$grup = [];
if (isset($_REQUEST['idt'])) :
    $idt = $_REQUEST['idt'];
    $acceso = accesolimitado($idt);
else :
    $acceso = 0;
endif;
if ($acceso == 0) :
    $resultj = mysqli_query($link, "SELECT * FROM _tgrupo order by IDG");
else :
    $resultj = mysqli_query($link, "SELECT * FROM _tgrupo where IDG in (" . $acceso . ") order by IDG");
endif;
while ($Row = mysqli_fetch_array($resultj)) {
    if ($Row['IDG'] != 0)
        $grup[] = array('id' => $Row['IDG'], 'nom' => htmlentities($Row['Descrip'], ENT_QUOTES, "UTF-8"));
}


?>
<div id='point-user-list'>
</div>

<script>
    let lastCheck = 1

    function activeButtomtab(i, id) {
        const oBlastCheck = $('ireaxion-btn-' + lastCheck)
        if (oBlastCheck.classList.contains('ireaxion-active-tabs'))
            oBlastCheck.classList.remove('ireaxion-active-tabs')

        lastCheck = id
        const newOblastCheck = $('ireaxion-btn-' + lastCheck)
        newOblastCheck.classList.add('ireaxion-active-tabs')

        if (json_data[i]) {
            const {
                id
            } = json_data[i]
            const data = getData(id)
            setDataGrid(data)
        }

    }

    function setDataGrid(data) {
        clearAllGrid(gridIdc)
        data.forEach((o, i) => {
            const {
                idc,
                nom,
                act
            } = o

            const check = act ? createImage('images/check-cnf-idc.png') : ''

            addRowGrid(gridIdc, false, (o) => handleConfigIDC(o), check, idc, nom)
        })
    }

    function handleConfigIDC(obj) {
        const ch = obj.childNodes
        const idc = ch[1].innerText

        verlista5(idc)
    }

    function getData(idg) {
        const req = new Ajax.Request("ver_listadeusuariodd-json.php?idg=" + idg, {
            method: 'post',
            asynchronous: false,

            onFailure: function() {
                alert('No hubo comunicacion,Error!!')
            }
        })
        if (req._complete) {
            if (req.transport.status === 200) {
                try {
                    const data = JSON.parse(req.transport.response)
                    return data
                } catch (error) {
                    alert('Error en los datos, verique su conexión')
                }
            }
        }
    }
    const col = [{
        id: 0,
        text: '',
        width: '30px'
    }, {
        id: 1,
        text: 'Letra'
    }, {
        id: 2,
        text: 'Nombre'
    }]
    const json_data = <?= json_encode($grup) ?>;
    lastCheck = json_data[0].id;

    const [sc, bodytabs] = createTabs('point-user-list', 900, 580, 'Configuración de Punto de Venta', [])
    LayoutTabs(bodytabs, '2V', ['200px', '100%'])

    const buttons = loadJSONBtn(json_data, 'ireaxion-bts-tabs', (i, id) => activeButtomtab(i, id))
    setLayout('A', buttons)
    setTitleFrame('A', 'GRUPOS')
    addClassFramer('B', 'ireaxion-spc-grid-tabs')
    const gridIdc = createGrid('B', col)

    const firts = $('ireaxion-btn-1')
    firts.classList.toggle('ireaxion-active-tabs')
    const data = getData(json_data[0].id)
    setDataGrid(data)
</script>