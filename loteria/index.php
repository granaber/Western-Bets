<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" debug="false">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>..:: ParlayEnLinea Lottery ::..</title>
</head>
<script type="text/javascript" src="prototype.js"></script>
<script type="text/javascript" src="prc.js" firebugIgnore="true"></script>
<script src="codebase/dhtmlxcommon.js"></script>
<script src="codebase/dhtmlxmenu.js"></script>
<script src="codebase/dhtmlxwindows.js"></script>
<script src="codebase/dhtmlxtabbar.js"></script>
<script src="codebase/dhtmlxgrid.js"></script>
<script src="codebase/dhtmlxdataprocessor.js"></script>
<script src="codebase/php/connector.js"></script><!--	Extension de Grid-->
<script src="codebase/ext/dhtmlxgrid_filter.js"></script> <!--	Extension de Grid-->
<script src="codebase/ext/dhtmlxgrid_srnd.js"></script><!--	Extension de Grid-->

<script src="codebase/dhtmlxgridcell.js"></script>
<script src="codebase/dhtmlxtoolbar.js"></script>
<script src="codebase/dhtmlxcombo.js"></script>
<script src="codebase/dhtmlxcalendar.js"></script>
<script src="codebase/ext/dhtmlxwindows_wtb.js"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
<script src="codebase/dhtmlxlayout.js"></script>
<script src="codebase/dhtmlxtree.js"></script>
<script src="codebase/dhtmlxcontainer.js"></script>
<!--  //  <script  src="codebase/dhtmlxscheduler.js"></script>-->

<!--/*    <link rel="stylesheet" type="text/css" href="codebase/dhtmlxscheduler.css"  >*/-->
<link rel="stylesheet" type="text/css" href="codebase/dhtmlxtree.css">
<link rel="stylesheet" type="text/css" href="codebase/dhtmlxlayout.css">
<link rel="stylesheet" type="text/css" href="codebase/dhtmlxwindows.css">
<link rel="stylesheet" type="text/css" href="codebase/dhtmlxgrid.css">
<link rel="STYLESHEET" type="text/css" href="codebase/dhtmlxcombo.css">
<link rel="STYLESHEET" type="text/css" href="codebase/dhtmlxtabbar.css">

<link rel="STYLESHEET" type="text/css" href="codebase/skins/dhtmlxcalendar_dhx_blue.css">
<link rel="STYLESHEET" type="text/css" href="codebase/skins/dhtmlxcalendar_dhx_black.css">

<link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxlayout_dhx_skyblue.css">
<link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxlayout_dhx_black.css">

<link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxwindows_dhx_skyblue.css">
<link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxwindows_dhx_black.css">

<link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxtoolbar_dhx_skyblue.css">
<link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxtoolbar_dhx_black.css">

<link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxmenu_modern_blue.css">
<link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxgrid_dhx_skyblue.css">
<link rel="stylesheet" type="text/css" href="codebase/skins/dhtmlxgrid_dhx_black.css">

<link rel="STYLESHEET" type="text/css" href="codebase/dhtmlxcalendar.css">

<link rel="STYLESHEET" type="text/css" href="codebase/skins/dhtmlxcalendar_dhx_blue.css">
<link rel="STYLESHEET" type="text/css" href="codebase/skins/dhtmlxcalendar_dhx_black.css">





<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css" />

<style type="text/css">
  @media print {

    .header {
      display: none
    }

    div,
    a {
      display: none
    }

    span {
      display: none
    }

  }
</style>

<body>
  <?
  date_default_timezone_set('America/Caracas');
  require_once('prc_php.php');
  $GLOBALS['link'] = Connection::getInstance();
  $Fecha = Fechareal(0, 'd/n/Y');
  $IDJ = Jornada($Fecha, true);

  ?>
  <div firebugIgnore="true">
    <div style="background:#036;">
      <span style="color: #FC0; font-size:14px">Jornada No.:</span><span id="IDJ" lang="<? echo $IDJ; ?>" style="color:#FFF; font-size:14px"><? echo $IDJ; ?></span>&nbsp;&nbsp;
      <span style="color: #FC0; font-size:14px">Fecha:</span><span id="Fecha" lang="<? echo $Fecha; ?>" style="color:#FFF; font-size:14px"><? echo $Fecha; ?></span>&nbsp;&nbsp;
      <span id='stUsuario' style="display:none"><span style="color: #FC0; font-size:14px">Usuario:</span><span id="UsuarioB" lang="" style="color:#FFF; font-size:14px"></span>&nbsp;&nbsp;</span></span>
      <span id='stAgencia' style="display:none"><span id="txtAgencia" style="color: #FC0; font-size:14px">Agencia:</span><span id="Agencia" lang="" style="color:#FFF; font-size:14px"></span>&nbsp;&nbsp;</span>
      <span id='stTipodeUsuario' style="display:none"><span style="color: #FC0; font-size:14px">Tipo de Usuario:</span><span id="TUsuario" lang="" style="color:#FFF; font-size:14px"></span>&nbsp;&nbsp;</span>
    </div>
    <div id="MenuTool">
      <div id="contextArea"></div>
    </div>
    <div>
      <div style="height: 180px;">
        <div id="toolbarObj" style=" position: relative"></div>
      </div>
    </div>
    <div id="resp"></div>

    <samp id="printer" style=" color:#FFF"></samp>
    <div id="showprint">
      <div id="printerver" style="width: 100%; height: 100%; overflow: auto; display: none; font-family: Tahoma; font-size: 11px;">
        <div id="printerver_2" style="margin: 3px 5px 3px 5px;">
        </div>
      </div>
    </div>
    <div id="box2" align="center">
      <table width="200" border="0">
        <tr>
          <th colspan="2" scope="col">
            <div align="center"><span class="Estilo13">Entrar al Sistema</span></div>
          </th>
        </tr>
        <tr>
          <th scope="col">
            <div align="right"><span class="EstiloCC">Usuario:</span></div>
          </th>
          <th scope="col">
            <input name="textfield" type="text" id="idusuario" size="10" maxlength="10">
          </th>
        </tr>
        <tr>
          <th scope="col">
            <div align="right"><span class="EstiloCC">Clave:</span></div>
          </th>
          <th scope="col"> <input name="textfield" type="password" id="idclave" size="10" maxlength="10"></th>
        </tr>

        <tr>
          <th scope="col"></th>
          <th scope="col">
            <div align="right">&nbsp;
              <input name="Entrar" type="button" value="Entrar" onClick="accesoalsistema()">
            </div>
          </th>
        </tr>
        <tr>
          <th colspan="2" scope="col"><samp id="repuesta"></samp></th>
        </tr>
      </table>
    </div>

    <div id='Registro' style="display:none">
      <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="3">
            <div align="center"><span style="color:#036">Registro al Sistema</span></div>
          </td>
        </tr>
        <tr>
          <td>Codigo :</td>
          <td colspan="2"><span id="Codigo" style="color:#930"></span></td>
        </tr>
        <tr>
          <td>Serial de Registro</td>
          <td colspan="2"><input name="" type="text" id="c1" size="4" />-
            <input name="input" type="text" id="c2" size="4" />
            -
            <input name="input2" type="text" id="c3" size="4" />
            -
            <input name="input3" type="text" id="c4" size="4" />
            <img id="aceptar" src="images/accept.png" width="24" height="24" style="display:none" /><img id="rechazado" src="images/close.gif" width="16" height="16" style="display:none" />
          </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td align="right"><label>
              <input type="submit" name="button" id="btnRegistro" value="Registrar" onclick="vericarRegistro()" />
            </label></td>
        </tr>
      </table>

    </div>
    <div id='FromClaveBLI' style="display:none">
      <div id='ClaveBLI' style="display:none">


      </div>
    </div>
  </div>
</body>

</html>
<script>
  var dhxWins1 = new dhtmlXWindows();
  dhxWins1.setImagePath("codebase/imgs/");
  w1 = dhxWins1.createWindow("w1", 10, 80, 380, 200);
  w1.setText("Acceso al Sistema  Lotery");
  dhxWins1.window("w1").setModal(true);
  dhxWins1.window("w1").centerOnScreen();
  dhxWins1.window("w1").denyResize();
  dhxWins1.window("w1").denyMove();
  w1.attachObject('box2');
</script>