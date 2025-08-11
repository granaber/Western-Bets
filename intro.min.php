<?
session_start();
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

$valores = explode('||', base64_decode($_REQUEST['code']));
if ($mode == $PRODUCCION) {
    $sql = "SELECT UNIX_TIMESTAMP(NOW())-hashtime as tm FROM `_tusu` WHERE `IDusu`=" . $valores[7];
    $query = mysqli_query($GLOBALS['link'], $sql);
    if (mysqli_num_rows($query) != 0) :
        $row = mysqli_fetch_array($query);
        if ($row['tm'] > 10) {
            echo " <script>	 window.close(); </script>";
            exit;
        };
    else :
        echo " <script>	 window.close(); </script>";
        exit;
    endif;
}
if ($valores[0] === "true") {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<!-- "Thu, 01 Jan 2021 16:00:00 GMT" -->
<meta http-equiv="expires" content="Thu, 01 Jan 2021 16:00:00 GMT">
<link rel="shortcut icon" type="image/x-icon" href="media/parlay.gif" />
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Western Bets</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <link type="text/css" rel="stylesheet" media="all" href="cometchat/css/cometchat2.css" />
    <script type="text/javascript" src="cometchat/js/jquery.js"></script>
    <? if ($antiguio) { ?>
    <script type="text/javascript" src="md5.js"></script>
    <script type="text/javascript" src="base64dc.js"></script>
    <script type="text/javascript" src="html2canvas.js"></script>
    <script type="text/javascript" src="prototype.js"></script>
    <? } ?>
    <script type="text/javascript" src="api-token/form-1-min.js"></script>
    <link type="text/css" rel="stylesheet" media="all" href="api-token/form.min.css" />
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

<body style="background: #121212 ;  height:2000px ">
    <div id="prossed_bar">
        <div class="row justify-content-md-center loadbar <? if ($antiguio) echo " said-tmp"; ?>">
            <div class="col-md-8 col-lg-6 col-12 ">
                <div class="progress">
                    <div id="b_progress" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0"
                        aria-valuemin="0" aria-valuemax="100">0%</div>
                </div>
                <div id="b_progress_listo" style="display:none">
                    <h4 class="text-warning">Listo..</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row  ">
        <div class="col-sm-11 col-lg-10 col-xl-7 col-10">
            <table id="content" style=" display:none">
                <tr>
                    <td>
                        <table style="width:766px; margin:0px 0px 0px 25px">
                            <tr>
                                <td align="center">
                                    <div id="logo">
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div id="header2" style="display:none" align="center">
                            <table style="width:100vw;" bgcolor="#000" cellspacing="0" cellpadding="0">
                                <tr>
                                    <th colspan="2" align="center" class="bg-gradient-red-ocean">
                                        <div align="center">
                                            <img src="main-admin/image/westernbets.pro.orange.png" align="top"
                                                style="width: 20%;">
                                        </div>
                                        <div id="Cinti" style=" color:#FFF" align="center">

                                            <div class="marquee">
                                                <div class="track">
                                                    <div id="MensajeTXT" class="content-marquee"></div>
                                                </div>
                                            </div>

                                        </div>
                                        <div align="center">
                                            <span id="con" style=" color:#fff;display:none"></span> &nbsp; &nbsp;
                                            <span id="fch" style="color:#fff;display:none"></span>&nbsp; &nbsp;
                                            <span id="jnd" style="color:#fff;display:none"></span>&nbsp; &nbsp;
                                            <span id="usu" style="color:#fff;display:none"></span>&nbsp; &nbsp;
                                            <span id="est" style="color:#fff;display:none"></span>
                                            <span id="cngfvendedor" lang=""></span>
                                        </div>
                                        <div id="topmenu" style="background:#666666"></div>
                                        <div id="MenuTool">
                                            <div id="contextArea"></div>
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
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="2">
                                        <div class="container-fluid bg-secondary" style="height: 10000px;">
                                            <div class="row">
                                                <div class="col">
                                                    <div id="tablemenu" style="color:#FFF"></div>

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
                                    </th>
                                </tr>
                            </table>
                        </div>
                        <div id="tablemenuANI" style="color:#FFF"></div>

                        <div id="tablemenu2">
                            <table class="main_table1" align="center"></table>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <samp id="printer"></samp>
</body>

</html>


<script type="text/javascript">
$('b_progress').innerHTML = '10%';
$('b_progress').style.width = $('b_progress').innerHTML;
</script>
<? if ($antiguio) { ?>
<script type='text/javascript' src='x/lib/x_core.js'></script>
<script type='text/javascript' src='x/lib/xcardinalposition.js'></script>
<? } ?>
<script type="text/javascript">
$('b_progress').innerHTML = '15%';
$('b_progress').style.width = $('b_progress').innerHTML;
</script>
<? if ($antiguio) { ?>
<script type='text/javascript' src='x/lib/xaddeventlistener.js'></script>
<script type='text/javascript' src='x/lib/xtabpanelgroup.js'></script>
<? } ?>
<script type="text/javascript">
$('b_progress').innerHTML = '25%';
$('b_progress').style.width = $('b_progress').innerHTML;
</script>
<? if ($antiguio) { ?>
<script type="text/javascript" src="Scripts/calendar-nv-v2.js"></script>
<script type="text/javascript" src="lang/calendar-es-nv.js"></script>
<script type="text/javascript" src="Scripts/calendar-setup-nv.js"></script>
<? } ?>
<script type="text/javascript">
$('b_progress').innerHTML = '30%';
$('b_progress').style.width = $('b_progress').innerHTML;
</script>
<script type="text/javascript" src="prc-micro-svr-6.js?rnd=132"></script>
<? if ($antiguio) { ?>
<script type="text/javascript" src="chkOdds.js"></script>
<script type="text/javascript" src="niftycube.js"></script>
<script type="text/javascript" src="prc156x14k.js?rnd=132"></script>
<script type="text/javascript" src="prc2x1msg.js"></script>
<script type="text/javascript" src="prcjuegos.js"></script>
<script type="text/javascript" src="prc2.js"></script>
<? } ?>
<script type="text/javascript">
$('b_progress').innerHTML = '40%';
$('b_progress').style.width = $('b_progress').innerHTML;
</script>

<!--Animalitos-->
<? if ($antiguio) { ?>
<script type="text/javascript" src="animalitos/prcJsX4v9.js"></script>
<? } ?>
<!--Animalitos-->
<? if (!$antiguio) { ?>
<script type="text/javascript"
    src="/min/index.php?f=md5.js,base64dc.js,html2canvas.js,prototype.js,chkOdds.js,niftycube.js,prc156x14k.js,prc2x1msg.js,prcjuegos.js,prc2.js,animalitos/prcJsX4v9.js,x/lib/x_core.js,x/lib/xcardinalposition.js,x/lib/xaddeventlistener.js,x/lib/xtabpanelgroup.js,Scripts/calendar-nv-v2.js,lang/calendar-es-nv.js,Scripts/calendar-setup-nv.js">
</script>
<? } ?>
<script type="text/javascript">
$('b_progress').innerHTML = '50%';
$('b_progress').style.width = $('b_progress').innerHTML;
</script>
<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryAccordion.js" type="text/javascript"></script>
<script src="SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="SpryAssets/SpryEffects.js" type="text/javascript"></script>
<script type="text/javascript">
$('b_progress').innerHTML = '55%';
$('b_progress').style.width = $('b_progress').innerHTML;
</script>
<script src="codebase/dhtmlxcommon.js?rnd=132"></script>
<script src="codebase/dhtmlxmenu.js?rnd=132"></script>
<? if (true) { ?>
<script src="codebase/dhtmlxgrid.js?rnd=132"></script>
<script src="codebase/dhtmlxgridcell.js?rnd=132"></script>
<script src="codebase/dhtmlxtoolbar.js?rnd=132"></script>
<script src="codebase/dhtmlxtree.js?rnd=132"></script>
<? } ?>
<script type="text/javascript">
$('b_progress').innerHTML = '60%';
$('b_progress').style.width = $('b_progress').innerHTML;
</script>

<script src="codebase/dhtmlxtabbar.js?rnd=132"></script>
<script src="codebase/dhtmlxtabbar_start.js?rnd=132"></script>
<script src="codebase/dhtmlxwindows.js?rnd=132"></script>
<script src="codebase/dhtmlxlayout.js?rnd=132"></script>
<script src="codebase/dhtmlxcalendar.js?rnd=132"></script>
<script src="codebase/dhtmlxcontainer.js?rnd=132"></script>

<script type="text/javascript">
$('b_progress').innerHTML = '75%';
$('b_progress').style.width = $('b_progress').innerHTML;
</script>
<!--Actualizacion 10-->
<? if (true) { ?>
<script src="codebase/dhtmlxform.js?rnd=132"></script>
<script src="codebase/ext/dhtmlxform_item_upload.js?rnd=132"></script>
<script src="codebase/ext/swfobject.js?rnd=132"></script>
<? } ?>

<script type="text/javascript">
$('b_progress').innerHTML = '77%';
$('b_progress').style.width = $('b_progress').innerHTML;
</script>


<? if (true) { ?>
<script src="codebase/dhtmlxcombo.js?rnd=132"></script>
<script src="codebase/ext/dhtmlxcombo_extra.js?rnd=132"></script>
<script src="codebase/ext/dhtmlxmenu_ext.js?rnd=132"></script>
<? } ?>


<script type="text/javascript">
$('b_progress').innerHTML = '79%';
$('b_progress').style.width = $('b_progress').innerHTML;
</script>

<? if (true) { ?>
<script src='codebase/ext/dhtmlxgrid_pgn.js?rnd=132'></script>
<script src="codebase/ext/dhtmlxgrid_math.js?rnd=132"></script>
<script src="codebase/ext/dhtmlxgrid_filter.js?rnd=132"></script>
<script src='codebase/php/connector.js?rnd=132'></script>
<? } ?>
<script type="text/javascript">
$('b_progress').innerHTML = '83%';
$('b_progress').style.width = $('b_progress').innerHTML;
</script>
<link rel="stylesheet" type="text/css" href="resources/css/combos.css" />
<link rel="stylesheet" type="text/css" href="resources/css/ext-all.css" />
<script type="text/javascript">
$('b_progress').innerHTML = '84%';
$('b_progress').style.width = $('b_progress').innerHTML;
</script>
<script type="text/javascript" src="adapter/ext/ext-base.js"></script>
<script type="text/javascript" src="ext-all-debug.js"></script>
<script type="text/javascript" src="examples.js"></script>
<script type="text/javascript">
$('b_progress').innerHTML = '87%';
$('b_progress').style.width = $('b_progress').innerHTML;
</script>
<link href="prin_pcss_3x1.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="js_color_picker_v2.css" media="screen">

<script type="text/javascript">
$('b_progress').innerHTML = '88%';
$('b_progress').style.width = $('b_progress').innerHTML;
</script>

<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryAccordion.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="menu_style.css" />
<link rel='stylesheet' type='text/css' href='x/lib/tpg_dyn.css'>
<link type="text/css" rel="stylesheet" href="stylex1.css?rnd=132">
<link type="text/css" rel="stylesheet" href="stylex-p.css?rnd=132">

<link rel="stylesheet" type="text/css" media="all" href="css/calendar-system.css?rnd=132" title="win2k-cold-1" />

<script type="text/javascript">
$('b_progress').innerHTML = '90%';
$('b_progress').style.width = $('b_progress').innerHTML;
</script>


<link rel="STYLESHEET" type="text/css" href="codebase/dhtmlxgrid.css?rnd=132">
<link href='codebase/ext/dhtmlxgrid_pgn_bricks.css?rnd=132' rel='STYLESHEET' type='text/css'>
<link rel="STYLESHEET" type="text/css" href="codebase/dhtmlxtabbar.css?rnd=132">
<link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxgrid_dhx_skyblue.css?rnd=132">
<link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxgrid_dhx_black.css?rnd=132">
<link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxtoolbar_dhx_skyblue.css?rnd=132">
<link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxtoolbar_dhx_black.css?rnd=132">
<link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxmenu_modern_black.css?rnd=132">
<link rel="stylesheet" type="text/css" href="codebase/dhtmlxtree.css">
<? if (!$antiguio) { ?>
<script type="text/javascript">
$('b_progress').innerHTML = '94%';
$('b_progress').style.width = $('b_progress').innerHTML;
</script>
<? } ?>
<link rel="STYLESHEET" type="text/css" href="codebase/dhtmlxcalendar.css?rnd=132">
<link rel="STYLESHEET" type="text/css" href="codebase/skins/dhtmlxcalendar_dhx_blue.css?rnd=132">
<link rel="STYLESHEET" type="text/css" href="codebase/skins/dhtmlxcalendar_dhx_black.css?rnd=132">
<link rel="stylesheet" type="text/css" href="codebase/dhtmlxlayout.css?rnd=132">
<link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxlayout_dhx_skyblue.css?rnd=132">
<? if (!$antiguio) { ?>
<script type="text/javascript">
$('b_progress').innerHTML = '96%';
$('b_progress').style.width = $('b_progress').innerHTML;
</script>
<? } ?>
<link rel="stylesheet" type="text/css" href="codebase/dhtmlxwindows.css?rnd=132">
<link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxwindows_dhx_skyblue.css?rnd=132">
<link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxwindows_dhx_black.css?rnd=132">
<link href="css/princss.css" rel="stylesheet" type="text/css">
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/spinnerload.css" rel="stylesheet" type="text/css">

<!--Actualizacion 10-->
<link rel="STYLESHEET" type="text/css" href="codebase/dhtmlxcombo.css?rnd=132">
<link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxform_dhx_skyblue.css?rnd=132">

<script src="./ireaxion/ireaxion.v001.js"> </script>
<link rel="STYLESHEET" type="text/css" href="./ireaxion/ireaxion-1.css">
<script type="text/javascript">
$('b_progress').innerHTML = '100%';
$('b_progress').style.width = $('b_progress').innerHTML;
</script>

<!--Actualizacion 10-->
<? include "upgrade.php"; ?>
<!--CARGA DE CSS!-->
<script>
var MODE = "<?= $mode == $PRODUCCION ? "PROD" : "DEV" ?>";
var response = "<? echo base64_decode($_REQUEST['code']); ?>";
var arrInfo = response.split("||");
if (arrInfo[10] != 0) {
    var idusuario = arrInfo[12];
    document.cookie = "sessionhash=0; max-age=" + (60 * 60 * 24 * 4);
    Ext.BLANK_IMAGE_URL = 'resources/images/default/s.gif';

    $('b_progress_listo').style.display = "";
    $('tablemenu2').style.display = "none";
    $('header2').style.display = "";
    $('logo').style.display = "none";
    switch (arrInfo[1]) {
        case '-2':
            $("con").innerHTML = 'Nivel:Administrador';
            oko = 1;
            break;
        case '-1':
            $("con").innerHTML = 'Nivel:Usuario';
            oko = 0;
            break;
        case '-4':
            $("con").innerHTML = 'Nivel:Informacion';
            oko = 0;
            break;
        case '-5':
            $("con").innerHTML = 'Nivel:Sistema';
            oko = 0;
            break;
        default:
            $("con").innerHTML = 'Concesionario:' + arrInfo[1];
            oko = 0;
            break;
    }
    $("cngfvendedor").lang = arrInfo[11];
    $("con").title = arrInfo[1];
    $("con").style.display = "";
    $("fch").style.display = "";
    $("fch").innerHTML = 'Fecha:' + arrInfo[4];
    $("fch").title = arrInfo[4];
    $("jnd").innerHTML = 'Jornada:' + arrInfo[5];
    $("jnd").title = arrInfo[5];
    $("usu").style.display = "";
    $("usu").innerHTML = 'Usuario:' + idusuario;
    $("usu").title = arrInfo[7];
    $("usu").lang = idusuario;
    $("est").style.display = "";
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
    new Ajax.Request('chatactivo.php', {
        method: 'get',
        onSuccess: function(transport) {
            var response = transport.responseText;
            response.evalScripts();
        },
        onFailure: function() {
            alert('No tengo respuesta Comuniquese con el Administrador!');
        }
    });
    $('prossed_bar').innerHTML = "";
    $('content').style.display = "";
    callCreditBarr(MODE)
} else
    makeResultwin2('newClave.php?usu=' + idusuario, 'repuesta')
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
    for ($i = 0; $i <= count($datos); $i++) {
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