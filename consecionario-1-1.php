<?php

/*$fc=$_REQUEST['fc'];*/


require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

if (isset($_REQUEST['idt'])) :
    $idt = $_REQUEST['idt'];
    $accesogp = accesolimitado($idt);
else :
    $accesogp = 0;
endif;
$tp = "";
$idg = "";
$lista = "";
$ltexto = "";
?>
<div id='fromConcesionario' align="center" style="background: #FFF; color:#000;width:650px">

    <div id="a_tabbar" align="center" style="width:650px; height:300px;" />
    <?
    if ($accesogp == 0) :

        $result_b = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbanca order by IDB ");
        while ($row_b = mysqli_fetch_array($result_b)) {
            $result_g = mysqli_query($GLOBALS['link'], "SELECT * FROM _tgrupo where IDB=" . $row_b['IDB'] . " order by IDG ");
            while ($row_g = mysqli_fetch_array($result_g)) {
                $lista .= $row_g['IDG'] . ',';
                $ltexto .= $row_g['Descrip'] . ',';
                echo "<div id='tpg_" . $row_g['IDG'] . "'  style='height:250px; '>";
                echo "</div>";
            }
        }


    else :
        $result_g = mysqli_query($GLOBALS['link'], "SELECT * FROM _tgrupo where IDG in (" . $accesogp . ") order by IDG ");

        $lista = '';
        $ltexto = '';
        while ($row_g = mysqli_fetch_array($result_g)) {
            $lista .= $row_g['IDG'] . ',';
            $ltexto .= $row_g['Descrip'] . ',';
            echo "<div id='tpg_" . $row_g['IDG'] . "'  style='height:250px; '>";
            //	include('ordenconc.php'); 
            echo "</div>";
        }
    endif;
    ?>
</div>
</div>
<script>
var idRow = 0;
var lista = '<?= $lista; ?>';
var ltexto = '<?= $ltexto; ?>';

var listab = '<?= $listaB??''; ?>';
var ltextob = '<?= $ltextoB??''; ?>';

valoreslista = lista.split(',');
valoresltexto = ltexto.split(',');
valoreslistaB = listab.split(',');
valoresltextoB = ltextob.split(',');

function clicktoolBar(id) {
    switch (id) {
        case "Cerrar_":
            dhxWins1.window("w1").close();
            break;
        case "Agregar_":
            dhxWins1.window("w1").close();
            makeResultwin('consecionario.php?fc=0&idt=<? echo $idt ?>', 'tablemenu');
            break;
        case "Modificar_":
            if (idRow != 0) {
                dhxWins1.window("w1").close();
                makeResultwin('consecionario.php?fc=' + idRow + '&idt=<? echo $idt ?>', 'tablemenu');
            } else
                nalert('ERROR', 'DEBE SELECCIONAR PRIMERO EL CONCESIONARIO A MODIFICAR!!');
            break;

            //"ImprimirReporte2('reportedeventashipodromo-2.php');"
    }
}

function doOnRowSelected(id) {
    idRow = id;
}

dhxWins1 = new dhtmlXWindows();
dhxWins1.setImagePath("codebase/imgs/");
w1 = dhxWins1.createWindow("w1", 350, 100, 670, 350);
w1.setText('Concesionario');
w1.attachObject('fromConcesionario');
dhxWins1.window("w1").button('close').hide();
dhxWins1.window("w1").button('minmax1').hide();
dhxWins1.window("w1").button('minmax2').hide();
dhxWins1.window("w1").button('park').hide();
dhxWins1.window("w1").denyResize();
dhxWins1.window("w1").denyMove();
dhxWins1.window('w1').setModal(true);
dhxWins1.window('w1').centerOnScreen();
var bar = w1.attachToolbar();
bar.addButton("Cerrar_", 4, "Cerrar", "images/close.gif", "images/close.gif");
bar.addButton("Agregar_", 1, "Agregar Concesionario", "media/users.png", "media/users.png");
bar.addButton("Modificar_", 1, "Modificar Concesionario", "images/page_setup.gif", "images/page_setup.gif");
bar.attachEvent("onClick", clicktoolBar);


tabbar1 = new dhtmlXTabBar("a_tabbar", "top");
tabbar1.setStyle("winbiscarf");
tabbar1.setImagePath("codebase/imgs/");
tabbar1.enableAutoReSize(true);
for (i = 0; i <= valoreslista.length - 2; i++) {
    tabbar1.addTab("a_" + valoreslista[i], valoresltexto[i], "150px");
    tabbar1.setContent("a_" + valoreslista[i], "tpg_" + valoreslista[i]);
}

tabbar1.enableScroll(true);
tabbar1.setTabActive("a_" + valoreslista[0]);

for (i = 0; i <= valoreslista.length - 2; i++) {
    mygrid = new dhtmlXGridObject("tpg_" + valoreslista[i]);
    mygrid.setImagePath("codebase/imgs/");
    mygrid.setHeader("Letra,Nombre Asignado,Direccion,Estado,Municipio,Estatus");
    mygrid.setInitWidths("100,110,110,110,110,80")
    mygrid.setColAlign("right,left,left,left,left,left")
    mygrid.setColTypes("ro,ro,ro,ro,ro,ch");
    mygrid.setColSorting("str,str,str,str,str,str")
    mygrid.setSkin("dhx_skyblue");
    mygrid.attachEvent("onRowSelect", doOnRowSelected);
    mygrid.init();
    mygrid.loadXML("consecionario-1-3.php?IDG=" + valoreslista[i])

}
</script>