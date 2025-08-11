<?
session_start();
$code_access = false;

$valores = ["true", "TEST1", 1, "*", date('d/n/y'), "-", 22141, 3, "", "", "|29723", 0, "TEST"];

if (isset($_REQUEST['code'])) :
    $valores = explode('||', base64_decode($_REQUEST['code']));
    $code_access = true;
endif;

$FlatPass = isset($valores[13]);


require_once('prc_php.php');
require_once 'set_stateenv.php';

$user_agent = $_SERVER['HTTP_USER_AGENT'];
$antiguio = false;
$explo = getBrowser($user_agent);
if ($explo[0] == 'Mozilla Firefox' &&  strpos($explo[1], '2.0.0.20') !== FALSE) {
    $antiguio = true;
}


$GLOBALS['link'] = Connection::getInstance();

$mode = modeDetect();

global $PRODUCCION;

$rndacces = 'iT9OoGah';

$urlAnimalitos = $mode == $PRODUCCION ? "https://lott.westernbets.pro" : "http://127.0.0.1:3001";
$urlAmericana = $mode == $PRODUCCION ? "https://ame.westernbets.pro" : "http://127.0.0.1:3002";
$urlNacionales = $mode == $PRODUCCION ? "https://nac.westernbets.pro" : "http://127.0.0.1:3003";

$timeHalf = -1;
$dark = 1;
// if ($mode == $PRODUCCION) {
if ($valores[12] != 'TEST') {

    $is_redirect = isset($valores[13]);

    $timeHalf = $is_redirect ? intval($valores[13]) : 0;
    // echo "***" . $timeHalf;

    $sql = "SELECT UNIX_TIMESTAMP(NOW()) as tm,hashtime  FROM `_tusu` WHERE `IDusu`=" . $valores[7];
    $query = mysqli_query($GLOBALS['link'], $sql);
    if (mysqli_num_rows($query) != 0) :
        $row = mysqli_fetch_array($query);

        $midle =    $timeHalf  != 0 ? ($row['tm'] - $timeHalf > 300) : ($row['tm'] - $row['hashtime'] > 10);
        // echo "***" . $row['tm'] ."**". $timeHalf;
        // echo "***" . $row['tm'] . "**". $row['hashtime'];


        $dark = isModeDart($valores[7]);



        if ($midle) {
            echo " <script>	window.location.replace('../intro.min.ventas.php'); </script>";
            exit;
        };
    else :
        echo " <script>	window.location.replace('../intro.min.ventas.php'); </script>";
        exit;
    endif;


    if ($is_redirect) {
        $query = mysqli_query($GLOBALS['link'], "Update snapshot set deleted=1 where deleted=0 and idusu = " . $valores[7]);
    }
    $rndacces = $valores[6];
}

// }
if ($valores[0] === "true") {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<!-- "Thu, 01 Jan 2021 16:00:00 GMT" -->
<meta http-equiv="expires" content="0">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta charset="UTF-8">
<meta content="IE=Edge" http-equiv="X-UA-Compatible">
<meta name="description" content="A new Flutter project.">

<!-- iOS meta tags & icons -->
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-title" content="BetGambler">
<link rel="shortcut icon" type="image/x-icon" href="media/parlay.gif" />
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Western Bets</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="./css/bootstrap.min.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css2?family=Quicksand&family=Roboto&display=swap' rel='stylesheet' />

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <link type="text/css" rel="stylesheet" media="all" href="cometchat/css/cometchat2.css" />
    <link type="text/css" rel="stylesheet" media="all" href="css/intro.css" />

    <!-- <script type="text/javascript" src="cometchat/js/jquery.js"></script> -->
    <script src="bootstrap/jquery.slim.min.js"></script>

    <script src="bootstrap/bootstrap.bundle.min.js"></script>

    <? if ($antiguio) { ?>
    <script type="text/javascript" src="md5.js"></script>
    <script type="text/javascript" src="base64dc.js"></script>
    <script type="text/javascript" src="html2canvas.js"></script>
    <script type="text/javascript" src="prototype.js"></script>
    <? } ?>

    <? include './get_css.php' ?>
</head>
<style type="text/css">
.loadbar {
    margin-top: 300px;
}

.said-tmp {
    width: 600px;
    margin-left: 350px;
}
</style>

<body style="width: 100%; height: 100%; position: fixed; top: 0; left: 0;padding:5px "
    class=" <?= $dark ? 'add-dark' : 'bg-light' ?>  ">

    <div id="prossed_bar">
        <?
            if (!$code_access):
                require './wait-access.php';
            endif;
            ?>
    </div>



    <div id="content" style=" display:none" class="container layout-menu-fixed">
        <section class="layout-overlay layout-menu-toggle"> </section>

        <div>
            <div id="logo">
            </div>
        </div>
        <div id="header2" style="display:none">
            <div>
                <section>
                    <div class="<?= $dark ? 'add-dark' : 'bg-light'  ?>  ">
                        <!-- <div align="center">
                            <img src="main/image/betgambler4.png" class="logo-bg">
                        </div> -->

                        <div align="center" style="display: none;">
                            <span id="con" style="font-size: 20px; color:#e9ecef;display:none"></span>
                            &nbsp; &nbsp;
                            <span id="fch" style="color:#e9ecef;display:none"></span>&nbsp; &nbsp;
                            <span id="jnd" style="color:#e9ecef;display:none"></span>&nbsp; &nbsp;
                            <span id="usu" style="font-size: 20px;color:#e9ecef;display:none"></span>&nbsp;
                            &nbsp;
                            <span id="est" style="color:#e9ecef;display:none"></span>
                            <span id="cngfvendedor" lang=""></span>
                        </div>
                        <div id="topmenu" style="background:#666666"></div>
                        <div id="MenuTool" class="mb-1">
                            <!-- <img id='icons-menu-show' src="./media/menu.png" style="height: 20px;margin-left: 17px;" /> -->
                            <? require "./menu-client-draw.php" ?>
                        </div>
                        <div class="mb-2">
                            <ul id="myTab" class="nav nav-tabs <?= $dark ? 'dark' : '' ?>  justify-content-center">
                                <? require "./menu-client-systems.php" ?>
                            </ul>
                        </div>
                        <div id='stCredito' style="background: #FFFFFF; color:#000000;display:none">
                            <div align="center">
                                <span id="crd" style="font-size:16px">
                                    <? echo 'CREDITO:'; ?>
                                </span>&nbsp; &nbsp;
                                <span id="bln" style="font-size:16px; color: #F00">
                                    <? echo 'BALANCE:'; ?>
                                </span>&nbsp; &nbsp;
                                <span id="pnd" style="font-size:16px">
                                    <? echo 'PENDIENTE:'; ?>
                                </span>&nbsp; &nbsp;
                                <span id="dip" style="font-size:16px">
                                    <? echo 'DISPONIBLE:'; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </section>
                <div id='main-tab' class="tab-content" style="padding: 0px;">
                    <div class="tab-pane show active" id="tab-parlay" role="tabpanel" aria-labelledby="home-tab">
                        <div>
                            <div>
                                <div class="bg-light" style="height: 10000px;">
                                    <div class="row">
                                        <div class="col">
                                            <div id="options-menu" style="color:#FFF"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div id="tablemenu"
                                                style="color:<?= $dark ? '#14131a' : '#FFF' ?>;width:100%"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3">
                                            <div id="menu1"></div>

                                        </div>
                                        <div class="col-9">
                                            <div id="tablemenu-odds" style="color:#FFF"></div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab-animalito" role="tabpanel" aria-labelledby="profile-tab">
                        <div>
                            <div>
                                <div class="bg-light" style="height: 10000px;">
                                    <div class="row">
                                        <div class="col">
                                            <div id="options-menu-animalitos" style="color:#FFF"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div id="tablemenu-animalitos"
                                                style="color:<?= $dark ? '#14131a' : '#FFF' ?>;width:100%">
                                                <iframe src="<?= $urlAnimalitos; ?>/?r=<?= $rndacces ?>&m<?= 1 ?>"
                                                    style="height:83vh;" name="mcservani"
                                                    class="<?= $dark ? 'add-dark' : '' ?>"></iframe>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3">
                                            <div id="menu1-animalitos"></div>

                                        </div>
                                        <div class="col-9">
                                            <div id="tablemenu-odds-animalitos" style="color:#FFF"></div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab-americana" role="tabpanel" aria-labelledby="profile-tab">
                        <div>
                            <div>
                                <div class="bg-light" style="height: 10000px;">
                                    <div class="row">
                                        <div class="col">
                                            <div id="options-menu-americana" style="color:#FFF"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div id="tablemenu-americana"
                                                style="color:<?= $dark ? '#14131a' : '#FFF' ?>;width:100%">
                                                <iframe src="<?= $urlAmericana; ?>/?r=<?= $rndacces ?>&m<?= 1 ?>"
                                                    style="height:86vh;" name="mcservani"
                                                    class="<?= $dark ? 'add-dark' : '' ?>"></iframe>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3">
                                            <div id="menu1-americana"></div>

                                        </div>
                                        <div class="col-9">
                                            <div id="tablemenu-odds-americana" style="color:#FFF"></div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="tab-nacionales" role="tabpanel" aria-labelledby="profile-tab">
                        <div>
                            <div>
                                <div class="bg-light" style="height: 10000px;">
                                    <div class="row">
                                        <div class="col">
                                            <div id="options-menu-nacionales" style="color:#FFF"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div id="tablemenu-nacionales"
                                                style="color:<?= $dark ? '#14131a' : '#FFF' ?>;width:100%">
                                                <iframe src="<?= $urlNacionales; ?>/?r=<?= $rndacces ?>&m<?= 1 ?>"
                                                    style="height:86vh;" name="mcservani"
                                                    class="<?= $dark ? 'add-dark' : '' ?>"></iframe>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3">
                                            <div id="menu1-nacionales"></div>

                                        </div>
                                        <div class="col-9">
                                            <div id="tablemenu-odds-nacionales" style="color:#FFF"></div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="tablemenuANI" style="color:#FFF"></div>

        <div id="tablemenu2">
            <div class="main_table1" align="center"></div>
        </div>

    </div>

    <samp id="printer"></samp>
    <section id='respose-form'>
        <? require "./login-access.php" ?>
    </section>
    <section id='respose-info'>
        <? require "./windows_show_info.php" ?>
    </section>
    <div class='mc01p_modal' data-default='CERRAR'>
        <div class='mc01p_modal-content  <?= $dark ? 'add-dark' : '' ?>'>
            <span class='mc01p_modal-title'>tituLo</span>
            <span class='mc01p_modal_x'>&times;</span>
            <p class='mc01p_modal-texto'></p>
            <div class='mc01p_modal-footer'>
            </div>
        </div>
    </div>
    <div class='from-wait'>
        <div class='from-wait-content'>
            <div class="spinner-border text-warning" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
</body>

</html>



<? if ($antiguio) { ?>
<script type='text/javascript' src='x/lib/x_core.js'></script>
<script type='text/javascript' src='x/lib/xcardinalposition.js'></script>
<? } ?>
<? if ($antiguio) { ?>
<script type='text/javascript' src='x/lib/xaddeventlistener.js'></script>
<script type='text/javascript' src='x/lib/xtabpanelgroup.js'></script>
<? } ?>
<? if ($antiguio) { ?>
<script type="text/javascript" src="Scripts/calendar-nv-v2.js"></script>
<script type="text/javascript" src="lang/calendar-es-nv.js"></script>
<script type="text/javascript" src="Scripts/calendar-setup-nv.js"></script>
<? } ?>
<script type="text/javascript" src="prc-micro-svr-6.js?rnd=132"></script>
<script type="text/javascript" src="prc156x17k.ventas.js?rnd=132"></script>
<script type="text/javascript" src="prc-ventas-options-6.js?rnd=132"></script>

<? if ($antiguio) { ?>
<script type="text/javascript" src="chkOdds.js"></script>
<script type="text/javascript" src="niftycube.js"></script>
<script type="text/javascript" src="prc2x1msg.js"></script>
<script type="text/javascript" src="prcjuegos.js"></script>
<script type="text/javascript" src="prc2.js"></script>
<? } ?>

<? if (!$antiguio) { ?>
<script type="text/javascript"
    src="/min/?f=md5.js,base64dc.js,html2canvas.js,prototype.js,chkOdds.js,niftycube.js,prc2x1msg.js,prcjuegos.js,prc2.js,animalitos/prcJsX4v9.js,x/lib/x_core.js,x/lib/xcardinalposition.js,x/lib/xaddeventlistener.js,x/lib/xtabpanelgroup.js,Scripts/calendar-nv-v2.js,lang/calendar-es-nv.js,Scripts/calendar-setup-nv.js">
</script>
<? } ?>
<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryAccordion.js" type="text/javascript"></script>
<script src="SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="SpryAssets/SpryEffects.js" type="text/javascript"></script>
<script src="codebase/dhtmlxcommon.js?rnd=132"></script>
<script src="codebase/dhtmlxmenu.js?rnd=132"></script>
<? if (true) { ?>
<script src="codebase/dhtmlxgrid.js?rnd=132"></script>
<script src="codebase/dhtmlxgridcell.js?rnd=132"></script>
<script src="codebase/dhtmlxtoolbar.js?rnd=132"></script>
<script src="codebase/dhtmlxtree.js?rnd=132"></script>
<? } ?>

<script src="codebase/dhtmlxtabbar.js?rnd=132"></script>
<script src="codebase/dhtmlxtabbar_start.js?rnd=132"></script>
<script src="codebase/dhtmlxwindows.js?rnd=132"></script>
<script src="codebase/dhtmlxlayout.js?rnd=132"></script>
<script src="codebase/dhtmlxcalendar.js?rnd=132"></script>
<script src="codebase/dhtmlxcontainer.js?rnd=132"></script>

<!--Actualizacion 10-->
<? if (true) { ?>
<script src="codebase/dhtmlxform.js?rnd=132"></script>
<script src="codebase/ext/dhtmlxform_item_upload.js?rnd=132"></script>
<script src="codebase/ext/swfobject.js?rnd=132"></script>
<? } ?>


<? if (true) { ?>
<script src="codebase/dhtmlxcombo.js?rnd=132"></script>
<script src="codebase/ext/dhtmlxcombo_extra.js?rnd=132"></script>
<script src="codebase/ext/dhtmlxmenu_ext.js?rnd=132"></script>
<? } ?>


<? if (true) { ?>
<script src='codebase/ext/dhtmlxgrid_pgn.js?rnd=132'></script>
<script src="codebase/ext/dhtmlxgrid_math.js?rnd=132"></script>
<script src="codebase/ext/dhtmlxgrid_filter.js?rnd=132"></script>
<script src='codebase/php/connector.js?rnd=132'></script>
<? } ?>
<script type="text/javascript" src="adapter/ext/ext-base.js"></script>
<script type="text/javascript" src="ext-all-debug.js"></script>
<script type="text/javascript" src="examples.js"></script>

<script src="./modal.js"> </script>



<!--Actualizacion 10-->



<script src="./ireaxion/ireaxion.v001.js"> </script>






<!--Actualizacion 10-->
<? include "upgrade.php"; ?>
<!--CARGA DE CSS!-->
<script>
var MODE = "<?= $mode == $PRODUCCION ? "PROD" : "DEV" ?>";
var isaccess = <?= $timeHalf  ?>;

function handleLoad() {
    /// --> WS call
    script = document.createElement('script');
    script.type = 'text/javascript';
    script.async = true;
    script.src = './linkws-1.3.js';
    document.getElementsByTagName('head')[0].appendChild(script);
    /// -->


    $('prossed_bar').innerHTML = "";
    var response =
        "<?= isset($_REQUEST['code']) ? base64_decode($_REQUEST['code']) : implode("||", $valores) ?>";
    var arrInfo = response.split("||");
    if (arrInfo[10] != 0) {
        var idusuario = arrInfo[12];
        document.cookie = "sessionhash=0; max-age=" + (60 * 60 * 24 * 4);
        Ext.BLANK_IMAGE_URL = 'resources/images/default/s.gif';

        $('tablemenu2').style.display = "none";
        $('header2').style.display = "";
        $('logo').style.display = "none";

        $("con").innerHTML = arrInfo[1];

        $("cngfvendedor").lang = arrInfo[11];
        $("con").title = arrInfo[1];
        $("con").style.display = "";
        $("fch").innerHTML = 'Fecha:' + arrInfo[4];
        $("fch").title = arrInfo[4];
        $("jnd").innerHTML = 'Jornada:' + arrInfo[5];
        $("jnd").title = arrInfo[5];
        $("usu").style.display = "";
        $("usu").innerHTML = 'Usuario:' + idusuario;
        $("usu").title = arrInfo[7];
        $("usu").lang = idusuario;
        $("est").innerHTML = 'Estacion:' + arrInfo[2];
        $("est").title = arrInfo[2];
        setCookie('rndusr', arrInfo[6]);
        document.cookie = "sessionhash=" + arrInfo[7] + "; max-age=" + (60 * 60 * 24 * 4);
        $("header2").lang = arrInfo[8];
        var element = $("topmenu");
        var element2 = $("menu1");
        $("header2").style.display = "";
        $("tablemenu").style.display = "";
        initMenu($("header2").lang);
        $('content').style.display = "";
        if (idusuario === 'TEST') {
            loginVentas()
        }
        // if (isaccess !== -1) {
        //     showWindowInfo()
        // }
    } else
        makeResultwin2('newClave.php?usu=' + idusuario, 'repuesta')

    return
}
<?php if (!$code_access): ?>
const video = document.querySelector("video");
video.onended = (event) => {
    handleLoad()
};
<?php else : ?>
handleLoad()
<?php endif; ?>

$('myTab').addEventListener('click', function(e) {
    event.preventDefault()
    console.log(e)
    if (e.target.tagName === 'A') {
        const a = $('myTab')
        a.childNodes.forEach((e) => {
            if (e.nodeName === 'LI') {
                e.children[0].classList.remove("active")
            }
        })
        e.target.classList.add('active')
        const context = e.target.dataset['context']
        const id = `tab-${context}`

        const idmain = 'main-tab'
        const classOver = ["active", "show"];
        $(idmain).childNodes.forEach((e) => {
            if (e.nodeName === 'DIV') {
                e.classList.remove(...classOver)
            }
        })
        $(id).classList.add(...classOver)
    }
})
// .on('click', function(event) {
//     event.preventDefault()
//     $(this).tab('show')
// })
</script>
<?
} else
    echo $respuesta;




function getBrowser($user_agent)
{
    $version = "";
    $datos = explode('/', $user_agent);
    // print_r($datos);
    $explo = '0';
    for ($i = 0; $i < count($datos); $i++) {
        if (strpos($datos[$i], 'MSIE') !== FALSE)
            $explo = 'Internet explorer';
        elseif (strpos($datos[$i], 'Edge') !== FALSE) //Microsoft Edge
            $explo = 'Microsoft Edge';
        elseif (strpos($datos[$i], 'Trident') !== FALSE) //IE 11
            $explo = 'Internet explorer';
        elseif (strpos($datos[$i], 'Opera Mini') !== FALSE)
            $explo = "Opera Mini";
        elseif (strpos($datos[$i], 'Opera') || strpos($datos[$i], 'OPR') !== FALSE)
            $explo = "Opera";
        elseif (strpos($datos[$i], 'Firefox') !== FALSE)
            $explo = 'Mozilla Firefox';
        elseif (strpos($datos[$i], 'Chrome') !== FALSE)
            $explo = 'Google Chrome';
        elseif (strpos($datos[$i], 'Safari') !== FALSE)
            $explo = "Safari";

        if ($explo != '0') {
            $version = $datos[$i + 1];
            break;
        }
    }

    return array($explo, $version);
}
?>