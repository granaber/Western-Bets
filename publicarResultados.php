<style>
    html {
        --head-table-resul: #124559;
        --row-table-resul: #a3a3acc2;
    }

    .tb-public-result-head {
        background: var(--head-table-resul);
        height: 30px;
        font-size: 17px;

    }

    .tb-public-result-head th h5 {
        margin: 2px;
        color: aliceblue
    }

    .tb-public-resul-row {
        font-size: 14px;
        color: #000;
    }

    .tb-public-resul-row th {
        color: inherit;
    }

    .tb-public-resul-row:nth-child(even) {
        background: var(--row-table-resul);
    }
</style>

<?

$fc = $_REQUEST["fc"];
?>
<div id="fromJornada" style=" width: 100%; height: 100%; overflow: auto; display: none; font-family: Tahoma; font-size: 11px;">
    <? include('publicarResultados-1.php'); ?>
</div>

</div>
<div id="vista">
    <div id="obj2">
        <div id="Calen1" />
    </div>
</div>
</div>
<script>
    var fecha = '<?= $fc; ?>';

    function publicarResultados_new2(t, n) {
        new Ajax.Request('procierre.php?op=20&idj=' + t + '&grupo=' + n, {
            method: 'get',
            asynchronous: false,
            onSuccess: function(e) {
                var t = e.responseText.evalJSON(!0)
                if (!t) {
                    alert('No pude procesar su configuración de Publicar Resultado!! ')
                }
            },
            onFailure: function() {
                alert('No tengo respuesta Comuniquese con el Administrador!')
            }
        })
    }

    function calendario() {
        dhxWins2 = new dhtmlXWindows();
        dhxWins2.setImagePath("codebase/imgs/");
        var w2 = dhxWins2.createWindow("w2", 620, 300, 190, 210);
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
        setCookie('FechaCookie', fecha);
        bar.setItemText('TextoFecha', 'Fecha: ' + fecha);
        dhxWins2.window("w2").close();
        w1.attachURL('publicarResultados-1.php?fc=' + fecha, true);
    }

    function clicktoolBar(id) {

        switch (id) {
            case "Cerrar_":
                info = $('info-data')
                idj = info.dataset.idj;
                ln = info.dataset.ln;

                listGrupos = []
                for (i = 0; i <= ln; i++) {
                    id = `im${idj}_${i}`
                    if (isset(id)) {
                        e = $(id)
                        if (e.checked) {
                            gp = e.dataset.gp
                            listGrupos.push(Number(gp))
                        }
                    }
                }
                if (Number(idj) !== 0)
                    publicarResultados_new2(idj, `${listGrupos.join(',')}`)
                dhxWins1.window("w1").close();
                break;
            case "Calendario_":
                calendario();
                break;

        }
    }

    dhxWins1 = new dhtmlXWindows();
    dhxWins1.setImagePath("codebase/imgs/");
    w1 = dhxWins1.createWindow("w1", 520, 255, 550, 570);
    w1.setText(' Publicar RESULTADOS ');
    w1.attachObject('fromJornada');
    dhxWins1.window("w1").button('close').hide();
    dhxWins1.window("w1").button('minmax1').hide();
    dhxWins1.window("w1").button('minmax2').hide();
    dhxWins1.window("w1").button('park').hide();
    dhxWins1.window('w1').setModal(true);
    // dhxWins1.window("w1").centerOnScreen();
    var bar = w1.attachToolbar();
    bar.addButton("Cerrar_", 4, "Salir", "images/close.gif", "images/close.gif");

    bar.addSeparator('', 3);
    bar.addText('TextoFecha', 4, 'Fecha:<?= $fc; ?>');
    bar.addButton("Calendario_", 5, "", "images/dhtmlxcalendar_icon.gif", "images/dhtmlxcalendar_icon.gif");
    bar.addSeparator('', 6);


    bar.attachEvent("onClick", clicktoolBar);
</script>