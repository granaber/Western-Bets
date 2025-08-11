<?php
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
$idc = "";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<head>
  <title>Another attempt at CSS rounded-corner dialogs using the sliding doors technique</title>
  <style type="text/css">
    /* this is an example page. Real-use cases should never have inline CSS like this. ;) */

    bodyc {
      font: normal 76% georgia, helvetica, verdana, tahoma, arial, "sans serif";
    }

    .dialogc {
      width: 67%;
      margin: 0px;
      min-width: 41em;
      max-width: 650px;
      /* I only cut the left background images out to 800px. You could do much larger, etc. */
      color: #fff;
    }

    .dialogc .hdc .cc,
    .dialogc .ftc .cc {
      font-size: 1px;
      /* ensure minimum height */
      height: 11px;
    }

    .dialogc .ftc .cc {
      height: 14px;
    }

    .dialogc .hdc {
      background: transparent url(media/tl.png) no-repeat 0px 0px;
      margin-right: 14px;
      /* space for right corner */
    }

    .dialogc .hdc .cc {
      background: transparent url(media/tr.png) no-repeat right 0px;
      margin-right: -14px;
      /* pull right corner back over "empty" space (from above margin) */
    }

    .dialogc .bdc {
      background: transparent url(media/ml.png) repeat-y 0px 0px;
      margin-right: 6px;
    }

    .dialogc .bdc .cc {
      background: transparent url(media/mr.png) repeat-y right 0px;
      margin-right: -6px;
    }

    .dialogc .bdc .cc .sc {
      margin: 0px 8px 0px 4px;
      background: url(media/ms.jpg) repeat-x 0px 0px;
      padding: 1em;
    }

    .dialogc .ftc {
      background: transparent url(media/bl.png) no-repeat 0px 0px;
      margin-right: 14px;
    }

    .dialogc .ftc .cc {
      background: transparent url(media/br.png) no-repeat right 0px;
      margin-right: -14px;
    }

    /* content-specific */

    .dialogc h1c {
      /* header */
      font-size: 2em;
      margin: 0px;
      padding: 0px;
      margin-top: -0.6em;
    }

    pc {
      font-family: verdana, tahoma, arial, "sans serif";
    }

    .dialogc pc {
      margin: 0.5em 0px 0px 0px;
      padding: 0px;
      font: 0.95em/1.5em arial, tahoma, "sans serif";
    }

    html>body .dialogc prec {
      font-size: 1.1em;
    }

    .lineac {
      background: t;
    }
  </style>
</head>

<body>

  <div>

    <div class="dialogc">
      <div class="hdc">
        <div class="cc"></div>
      </div>
      <div class="bdc">
        <div class="cc">
          <div class="sc">

            <!-- content area -->

            <table width="378" height="220" border="0" cellpadding="5" cellspacing="0">
              <tr>
                <td width="475">
                  <p align="center" style="font:bold; font-size:16px"><strong>REPORTE DE VENTAS Y
                      PREMIOS</strong></p>
                  <hr />
                  <table width="368" height="144" border="1" cellpadding="2" cellspacing="0">
                    <tr>
                      <td width="360">
                        <table width="360" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="308">
                              <table width="359" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="82">
                                    <div align="center"><img src="media/printer.jpg" width="50" height="50" onclick="javascript:imprimirreeportes('reportedeventasRSM.php',1);" />
                                    </div>
                                  </td>
                                  <td width="55">&nbsp;</td>
                                  <td width="75">
                                    <div align="center"><img src="media/pantalla.jpg" width="50" height="50" onclick="javascript:imprimirreeportes('reportedeventasRSM.php',2);" />
                                    </div>
                                  </td>
                                  <td width="38">&nbsp;</td>
                                  <td>
                                    <div align="center"></div>
                                    <div align="center"></div>
                                  </td>
                                </tr>
                                <tr>
                                  <td bgcolor="#E2E7EF">
                                    <div align="center"><strong>Imprimir</strong>
                                    </div>
                                  </td>
                                  <td bgcolor="#E2E7EF">&nbsp;</td>
                                  <td bgcolor="#E2E7EF">
                                    <div align="center"><strong>Pantalla</strong>
                                    </div>
                                  </td>
                                  <td bgcolor="#E2E7EF">&nbsp;</td>
                                  <td bgcolor="#E2E7EF">
                                    <div align="center"></div>
                                    <div align="center"></div>
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    <div align="center"><strong>Desde</strong>:
                                    </div>
                                  </td>
                                  <td><strong>
                                      <input name="fc" type="text" id="fc" onFocus="cargarcampos3();" size="10" value="<?php echo date("d/n/Y") ?>" />
                                    </strong></td>
                                  <td>
                                    <div align="center"></div>
                                  </td>
                                  <td>
                                    <div align="center"><strong>Hasta:</strong>
                                    </div>
                                  </td>
                                  <td width="107">
                                    <div align="center"><strong>
                                        <input name="fc2" type="text" id="fc2" onFocus="cargarcampos4();" size="10" value="<?php echo date("d/n/Y") ?>" />
                                      </strong></div>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td>
                              <table width="358" border="0" cellspacing="0" cellpadding="0">

                                <tr>
                                  <td width="148" bgcolor="#E2E7EF"><strong>Tipo de
                                      Reporte:</strong></td>
                                  <td width="106" bgcolor="#E2E7EF"><strong>
                                      <input name="reporte" type="radio" value="radiobutton" checked="checked" />
                                      Detallado</strong></td>
                                  <td width="104" bgcolor="#E2E7EF"><strong>
                                      <input name="reporte" type="radio" value="radiobutton" style="display:none" />
                                    </strong></td>
                                </tr>

                              </table>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
            <!-- content area -->
          </div>
        </div>
      </div>
      <div class="ftc">
        <div class="cc"></div>
      </div>
    </div>

  </div>

</body>

</html>