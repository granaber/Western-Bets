<?php
///
$op = $_REQUEST['op'];
if ($op == 1) :
  $usu = $_REQUEST['usu'];
  require('prc_php.php');
  $GLOBALS['link'] = Connection::getInstance();
  $result = mysqli_query($GLOBALS['link'], "Update  _tusu Set bloqueado=0 where IDusu=" . $usu);

endif;



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title>Documento sin t&iacute;tulo</title>
  <style type="text/css">
    <!--
    .Estilo12 {
      font-family: Verdana, Arial, Helvetica, sans-serif;
      font-weight: bold;
    }

    .Estilo6 {
      color: #FFFFFF
    }

    .Estilo7 {
      font-size: 15px
    }

    .shadowcontainer {
      width: 240px;
      /* container width*/
      background-color: #d1cfd0;
    }

    .shadowcontainer .innerdiv {
      /* Add container height here if desired */
      background-color: white;
      border: 1px solid gray;
      padding: 6px;
      position: relative;
      left: -5px;
      /*shadow depth*/
      top: -5px;
      /*shadow depth*/
    }
    -->
  </style>
  <link href="css/menus.css" rel="stylesheet" type="text/css" />
  <style type="text/css">
    <!--
    .Estilo17 {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 12px;
    }

    .Estilo47 {
      color: #000000
    }
    }
    -->
  </style>
</head>

<body>
  <div class="innerdiv" id="tablemenu">
    <table width="1083" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="403">&nbsp;</td>
        <td width="672">
          <div class="shadowcontainer">
            <div class="innerdiv">
              <table width="224" height="71" border="0" cellspacing="0">
                <tr bgcolor="#0066FF">
                  <th colspan="2" bgcolor="#D4DAE6">
                    <div align="center"><span class="Estilo17">RESULTADOS</span></div>
                  </th>
                </tr>
                <tr>
                  <th>
                    <div id="selej"><strong>Jornada</strong>:
                      <select name="select" id="sjornada">
                      </select>
                    </div>
                  </th>
                  <td width="76"><input type="submit" name="Submit3" value="Buscar" /></td>
                </tr>
              </table>
            </div>
          </div>
        </td>
      </tr>
    </table>
    <table width="1083" cellspacing="2" cellpadding="2">
      <tr>
        <td height="73" align="center" valign="top" bgcolor="#D4DAE6">
          <div class="shadowcontainer">
            <div class="innerdiv">
              <table border="0" cellspacing="0">
                <tr bgcolor="#0066FF">
                  <th colspan="3" bgcolor="#FFCC66"><span class="Estilo47">Sexto Zuliano </span></th>
                </tr>
                <tr>
                  <th width="25">1</th>
                  <td width="111"><span class="Estilo17">YAAINI</span></td>
                  <td width="78" align="right">
                    <div align="center">5</div>
                  </td>
                </tr>
                <tr>
                  <th>2</th>
                  <td><span class="Estilo17">ALWAYS REASON </span></td>
                  <td align="right">
                    <div align="center">3,4</div>
                  </td>
                </tr>
                <tr>
                  <th>3</th>
                  <td><span class="Estilo17">RACING POET </span></td>
                  <td align="right">
                    <div align="center">8</div>
                  </td>
                </tr>
                <tr>
                  <th>4</th>
                  <td><span class="Estilo17">RENACIENTE</span></td>
                  <td align="right">
                    <div align="center">4</div>
                  </td>
                </tr>
                <tr>
                  <th>5</th>
                  <td><span class="Estilo17">REINA LUJALO </span></td>
                  <td align="right">
                    <div align="center">8</div>
                  </td>
                </tr>
                <tr>
                  <th>6</th>
                  <td><span class="Estilo17">HIDRO DANCING </span></td>
                  <td align="right">
                    <div align="center">2</div>
                  </td>
                </tr>
                <tr>
                  <th colspan="3">
                    <div align="right">A.C 16.951 BsF . </div>
                  </th>
                </tr>
              </table>
            </div>
          </div>
        </td>
        <td align="center" valign="top" bgcolor="#D4DAE6">
          <div class="shadowcontainer">
            <div class="shadowcontainer11">
              <div class="innerdiv">
                <table border="0" cellspacing="0">
                  <tr bgcolor="#0066FF">
                    <th colspan="3" bgcolor="#FF6600"><span class="Estilo47">Super Pool Hipico </span></th>
                  </tr>
                  <tr>
                    <th width="25">1</th>
                    <td width="122"><span class="Estilo17">REINA LUJANO </span></td>
                    <td width="67" align="right">
                      <div align="center">8</div>
                    </td>
                  </tr>
                  <tr>
                    <th>2</th>
                    <td><span class="Estilo17">HIDRO DANCING </span></td>
                    <td align="right">
                      <div align="center">2</div>
                    </td>
                  </tr>
                  <tr>
                    <th>3</th>
                    <td><span class="Estilo17">GRAN SOCIEDAD </span></td>
                    <td align="right">
                      <div align="center">3</div>
                    </td>
                  </tr>
                  <tr>
                    <th>4</th>
                    <td><span class="Estilo17">FERNANDO ALONZO </span></td>
                    <td align="right">
                      <div align="center">1,2</div>
                    </td>
                  </tr>
                  <tr>
                    <th>5</th>
                    <td><span class="Estilo17">GRAN DIVERSION </span></td>
                    <td align="right">
                      <div align="center">13</div>
                    </td>
                  </tr>
                  <tr>
                    <th>6</th>
                    <td><span class="Estilo17">GALLO GRANDE </span></td>
                    <td align="right">
                      <div align="center">9</div>
                    </td>
                  </tr>
                  <tr>
                    <th colspan="2">
                      <div align="right">A.C. </div>
                    </th>
                    <td align="center">5.535 BsF </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </td>
        <td align="center" valign="top" bgcolor="#D4DAE6">
          <div class="shadowcontainer">
            <div class="shadowcontainer11">
              <div class="innerdiv">
                <table border="0" cellspacing="0">
                  <tr bgcolor="#0066FF">
                    <th colspan="3" bgcolor="#99CCFF"><span class="Estilo47">Pool de Cuatro 1 Tanda </span></th>
                  </tr>
                  <tr>
                    <th width="25">1</th>
                    <td width="104"><span class="Estilo17">RACING POET </span></td>
                    <td width="85" align="right">
                      <div align="center">8</div>
                    </td>
                  </tr>
                  <tr>
                    <th>2</th>
                    <td><span class="Estilo17">RENACIENTE</span></td>
                    <td align="right">
                      <div align="center">4</div>
                    </td>
                  </tr>
                  <tr>
                    <th>3</th>
                    <td><span class="Estilo17">REINA LUJALO </span></td>
                    <td align="right">
                      <div align="center">8</div>
                    </td>
                  </tr>
                  <tr>
                    <th>4</th>
                    <td><span class="Estilo17">HIDRO DANCING </span></td>
                    <td align="right">
                      <div align="center">2</div>
                    </td>
                  </tr>
                  <tr>
                    <th colspan="2">
                      <div align="right">DIVIDENDO </div>
                    </th>
                    <td align="right">2.230,60 BsF </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </td>
        <td align="center" valign="top" bgcolor="#D4DAE6">
          <div class="shadowcontainer">
            <div class="shadowcontainer11">
              <div class="innerdiv">
                <table border="0" cellspacing="0">
                  <tr bgcolor="#0066FF">
                    <th colspan="3" bgcolor="#99CCFFF"><span class="Estilo47">Pool de Cuatro 2 Tanda </span></th>
                  </tr>
                  <tr>
                    <th width="21">1</th>
                    <td width="106"><span class="Estilo17">GRAN SOCIEDAD </span></td>
                    <td width="87" align="right">
                      <div align="center">3</div>
                    </td>
                  </tr>
                  <tr>
                    <th>2</th>
                    <td><span class="Estilo17">FERNANDO ALONZO </span></td>
                    <td align="right">
                      <div align="center">1,2</div>
                    </td>
                  </tr>
                  <tr>
                    <th>3</th>
                    <td><span class="Estilo17">GRAN DIVERSION </span></td>
                    <td align="right">
                      <div align="center">13</div>
                    </td>
                  </tr>
                  <tr>
                    <th>4</th>
                    <td><span class="Estilo17">GALLO GRANDE </span></td>
                    <td align="right">
                      <div align="center">9</div>
                    </td>
                  </tr>
                  <tr>
                    <th colspan="2" align="right">DIVIDENDO </th>
                    <td align="center">5.071,87 BsF </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div class="shadowcontainer">
            <div class="innerdiv">
              <table border="0" cellspacing="0">
                <tr bgcolor="#0066FF">
                  <th colspan="3"><span class="Estilo6">Superfecta 1 Carrera </span></th>
                </tr>
                <tr>
                  <th width="25">1&ordm;</th>
                  <td width="111"><span class="Estilo17">YAINNI</span></td>
                  <td width="78" align="center">
                    <div align="center">(5)</div>
                  </td>
                </tr>
                <tr>
                  <th>2&ordm;</th>
                  <td class="Estilo17">BABY DANI </td>
                  <td align="center">
                    <div align="center">(6)</div>
                  </td>
                </tr>
                <tr>
                  <th>3&ordm;</th>
                  <td><span class="Estilo17">MARIAZELL</span></td>
                  <td align="center">
                    <div align="center">(7)</div>
                  </td>
                </tr>
                <tr>
                  <th>4&ordm;</th>
                  <td><span class="Estilo17">DORADA JAK </span></td>
                  <td align="center">
                    <div align="center">(2)</div>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </td>
        <td>
          <div class="shadowcontainer">
            <div class="innerdiv">
              <table border="0" cellspacing="0">
                <tr bgcolor="#0066FF">
                  <th colspan="3"><span class="Estilo6">Superfecta 2 Carrera </span></th>
                </tr>
                <tr>
                  <th width="25">1&ordm;</th>
                  <td width="111"><span class="Estilo17">ALWAYS REASON </span></td>
                  <td width="78" align="center">
                    <div align="center">(4)</div>
                  </td>
                </tr>
                <tr>
                  <th>2&ordm;</th>
                  <td class="Estilo17">LEISA QUERIDA </td>
                  <td align="center">
                    <div align="center">(2)</div>
                  </td>
                </tr>
                <tr>
                  <th>3&ordm;</th>
                  <td><span class="Estilo17">MI MU&Ntilde;ECA </span></td>
                  <td align="center">
                    <div align="center">(1)</div>
                  </td>
                </tr>
                <tr>
                  <th>4&ordm;</th>
                  <td><span class="Estilo17">NI&Ntilde;A MAGA </span></td>
                  <td align="center">
                    <div align="center">(5)</div>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </td>
        <td>
          <div class="shadowcontainer">
            <div class="innerdiv">
              <table border="0" cellspacing="0">
                <tr bgcolor="#0066FF">
                  <th colspan="3" bgcolor="#0066FF"><span class="Estilo6">Superfecta 3 Carrera </span></th>
                </tr>
                <tr>
                  <th width="25">1&ordm;</th>
                  <td width="111">&nbsp;</td>
                  <td width="78" align="center">&nbsp;</td>
                </tr>
                <tr>
                  <th>2&ordm;</th>
                  <td class="Estilo17">&nbsp;</td>
                  <td align="center">&nbsp;</td>
                </tr>
                <tr>
                  <th>3&ordm;</th>
                  <td>&nbsp;</td>
                  <td align="center">&nbsp;</td>
                </tr>
                <tr>
                  <th>4&ordm;</th>
                  <td>&nbsp;</td>
                  <td align="center">&nbsp;</td>
                </tr>
              </table>
            </div>
          </div>
        </td>
        <td>
          <div class="shadowcontainer">
            <div class="innerdiv">
              <table border="0" cellspacing="0">
                <tr bgcolor="#0066FF">
                  <th colspan="3"><span class="Estilo6">Superfecta 4 Carrera </span></th>
                </tr>
                <tr>
                  <th width="25">1&ordm;</th>
                  <td width="119"><span class="Estilo17">RENACIENTE</span></td>
                  <td width="70" align="center">
                    <div align="center">(4)</div>
                  </td>
                </tr>
                <tr>
                  <th>2&ordm;</th>
                  <td class="Estilo17">BELAGIO</td>
                  <td align="center">
                    <div align="center">(1)</div>
                  </td>
                </tr>
                <tr>
                  <th>3&ordm;</th>
                  <td><span class="Estilo17">POR BUENO </span></td>
                  <td align="center">
                    <div align="center">(5)</div>
                  </td>
                </tr>
                <tr>
                  <th>4&ordm;</th>
                  <td><span class="Estilo17">CHANQUILON</span></td>
                  <td align="center">
                    <div align="center">(2)</div>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div class="shadowcontainer">
            <div class="innerdiv">
              <table border="0" cellspacing="0">
                <tr bgcolor="#0066FF">
                  <th colspan="3"><span class="Estilo6">Superfecta 5 Carrera </span></th>
                </tr>
                <tr>
                  <th width="25">1&ordm;</th>
                  <td width="111"><span class="Estilo17">REINA LUJALO </span></td>
                  <td width="78" align="center">
                    <div align="center">(8)</div>
                  </td>
                </tr>
                <tr>
                  <th>2&ordm;</th>
                  <td class="Estilo17">BARJAS</td>
                  <td align="center">
                    <div align="center">(7)</div>
                  </td>
                </tr>
                <tr>
                  <th>3&ordm;</th>
                  <td><span class="Estilo17">ARMONICA</span></td>
                  <td align="center">
                    <div align="center">(1)</div>
                  </td>
                </tr>
                <tr>
                  <th>4&ordm;</th>
                  <td><span class="Estilo17">WIN AGAIN </span></td>
                  <td align="center">
                    <div align="center">(4)</div>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </td>
        <td>
          <div class="shadowcontainer">
            <div class="innerdiv">
              <table border="0" cellspacing="0">
                <tr bgcolor="#0066FF">
                  <th colspan="3"><span class="Estilo6">Superfecta 6 Carrera </span></th>
                </tr>
                <tr>
                  <th width="25">1&ordm;</th>
                  <td width="111"><span class="Estilo17">HIDRO DANCING </span></td>
                  <td width="78" align="center">
                    <div align="center">(2)</div>
                  </td>
                </tr>
                <tr>
                  <th>2&ordm;</th>
                  <td class="Estilo17">HADA</td>
                  <td align="center">
                    <div align="center">(7)</div>
                  </td>
                </tr>
                <tr>
                  <th>3&ordm;</th>
                  <td><span class="Estilo17">ACQUERELLA</span></td>
                  <td align="center">
                    <div align="center">(9)</div>
                  </td>
                </tr>
                <tr>
                  <th>4&ordm;</th>
                  <td><span class="Estilo17">BABY ILIANA </span></td>
                  <td align="center">
                    <div align="center">(5)</div>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </td>
        <td>
          <div class="shadowcontainer">
            <div class="innerdiv">
              <table border="0" cellspacing="0">
                <tr bgcolor="#0066FF">
                  <th colspan="3"><span class="Estilo6">Superfecta 7 Carrera </span></th>
                </tr>
                <tr>
                  <th width="25">1&ordm;</th>
                  <td width="111"><span class="Estilo17">GRAN SOCIEDAD </span></td>
                  <td width="78" align="center">
                    <div align="center">(3)</div>
                  </td>
                </tr>
                <tr>
                  <th>2&ordm;</th>
                  <td class="Estilo17">NELSON HA</td>
                  <td align="center">
                    <div align="center">(1)</div>
                  </td>
                </tr>
                <tr>
                  <th>3&ordm;</th>
                  <td><span class="Estilo17">WAR INDY </span></td>
                  <td align="center">
                    <div align="center">(7)</div>
                  </td>
                </tr>
                <tr>
                  <th>4&ordm;</th>
                  <td><span class="Estilo17">LADY TECH </span></td>
                  <td align="center">
                    <div align="center">(8)</div>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </td>
        <td>
          <div class="shadowcontainer">
            <div class="innerdiv">
              <table border="0" cellspacing="0">
                <tr bgcolor="#0066FF">
                  <th colspan="3"><span class="Estilo6">Superfecta 8 Carrera </span></th>
                </tr>
                <tr>
                  <th width="25">1&ordm;</th>
                  <td width="119"><span class="Estilo17">FERNANDO ALONZO </span></td>
                  <td width="70" align="center">
                    <div align="center">(2)</div>
                  </td>
                </tr>
                <tr>
                  <th>2&ordm;</th>
                  <td class="Estilo17">RUIRUA</td>
                  <td align="center">
                    <div align="center">(7)</div>
                  </td>
                </tr>
                <tr>
                  <th>3&ordm;</th>
                  <td><span class="Estilo17">PARTNERS HERO </span></td>
                  <td align="center">
                    <div align="center">(10)</div>
                  </td>
                </tr>
                <tr>
                  <th>4&ordm;</th>
                  <td><span class="Estilo17">MISTER CANO </span></td>
                  <td align="center">
                    <div align="center">(3)</div>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div class="shadowcontainer">
            <div class="innerdiv">
              <table border="0" cellspacing="0">
                <tr bgcolor="#0066FF">
                  <th colspan="3"><span class="Estilo6">Superfecta 9 Carrera </span></th>
                </tr>
                <tr>
                  <th width="25">1&ordm;</th>
                  <td width="119"><span class="Estilo17">GRAN DIVERSION </span></td>
                  <td width="70" align="center">
                    <div align="center">(13)</div>
                  </td>
                </tr>
                <tr>
                  <th>2&ordm;</th>
                  <td class="Estilo17">THE BLACK SIX </td>
                  <td align="center">
                    <div align="center">(14)</div>
                  </td>
                </tr>
                <tr>
                  <th>3&ordm;</th>
                  <td><span class="Estilo17">MICHITO</span></td>
                  <td align="center">
                    <div align="center">(7)</div>
                  </td>
                </tr>
                <tr>
                  <th>4&ordm;</th>
                  <td><span class="Estilo17">EL PAYASO </span></td>
                  <td align="center">
                    <div align="center">(12)</div>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </td>
        <td>
          <div class="shadowcontainer">
            <div class="innerdiv">
              <table border="0" cellspacing="0">
                <tr bgcolor="#0066FF">
                  <th colspan="3"><span class="Estilo6">Superfecta 10 Carrera </span></th>
                </tr>
                <tr>
                  <th width="25">1&ordm;</th>
                  <td width="119"><span class="Estilo17">GALLO GRANCDE </span></td>
                  <td width="70" align="center">
                    <div align="center">(9)</div>
                  </td>
                </tr>
                <tr>
                  <th>2&ordm;</th>
                  <td class="Estilo17">NELSON HA </td>
                  <td align="center">
                    <div align="center">(4)</div>
                  </td>
                </tr>
                <tr>
                  <th>3&ordm;</th>
                  <td><span class="Estilo17">NADAL</span></td>
                  <td align="center">
                    <div align="center">(8)</div>
                  </td>
                </tr>
                <tr>
                  <th>4&ordm;</th>
                  <td><span class="Estilo17">BLUE CHAMPION </span></td>
                  <td align="center">
                    <div align="center">(10)</div>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </td>
        <td>
          <div class="shadowcontainer">
            <div class="innerdiv">
              <table border="0" cellspacing="0">
                <tr bgcolor="#0066FF">
                  <th colspan="3"><span class="Estilo6">Superfecta 11 Carrera </span></th>
                </tr>
                <tr>
                  <th width="25">1&ordm;</th>
                  <td width="119">&nbsp;</td>
                  <td width="70" align="center">&nbsp;</td>
                </tr>
                <tr>
                  <th>2&ordm;</th>
                  <td class="Estilo17">&nbsp;</td>
                  <td align="center">&nbsp;</td>
                </tr>
                <tr>
                  <th>3&ordm;</th>
                  <td>&nbsp;</td>
                  <td align="center">&nbsp;</td>
                </tr>
                <tr>
                  <th>4&ordm;</th>
                  <td>&nbsp;</td>
                  <td align="center">&nbsp;</td>
                </tr>
              </table>
            </div>
          </div>
        </td>
        <td>
          <div class="shadowcontainer">
            <div class="innerdiv">
              <table border="0" cellspacing="0">
                <tr bgcolor="#0066FF">
                  <th colspan="3"><span class="Estilo6">Superfecta 11 Carrera </span></th>
                </tr>
                <tr>
                  <th width="25">1&ordm;</th>
                  <td width="119">&nbsp;</td>
                  <td width="70" align="center">&nbsp;</td>
                </tr>
                <tr>
                  <th>2&ordm;</th>
                  <td class="Estilo17">&nbsp;</td>
                  <td align="center">&nbsp;</td>
                </tr>
                <tr>
                  <th>3&ordm;</th>
                  <td>&nbsp;</td>
                  <td align="center">&nbsp;</td>
                </tr>
                <tr>
                  <th>4&ordm;</th>
                  <td>&nbsp;</td>
                  <td align="center">&nbsp;</td>
                </tr>
              </table>
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2" align="center">
          <div class="shadowcontainer">
            <div class="innerdiv">
              <div align="center">
                <table border="0" cellspacing="0">
                  <tr bgcolor="#0066FF">
                    <th colspan="4" bgcolor="#FCF573"><span class="Estilo47">Doble Perfecta </span></th>
                  </tr>
                  <tr>
                    <th colspan="2">
                      <div align="center">5C Y 6C </div>
                    </th>
                    <td colspan="2" align="center">
                      <div align="center"><strong>9C Y 10C </strong></div>
                    </td>
                  </tr>
                  <tr>
                    <th width="45">
                      <div align="center">1&ordm; 8 </div>
                    </th>
                    <td width="47">
                      <div align="center">1&ordm; 6</div>
                    </td>
                    <td width="43">
                      <div align="center">1&ordm; 13 </div>
                    </td>
                    <td width="52" align="right">
                      <div align="center">1&ordm; 9 </div>
                    </td>
                  </tr>
                  <tr>
                    <th>
                      <div align="center">2&ordm; 7 </div>
                    </th>
                    <td>
                      <div align="center">2&ordm; 7 </div>
                    </td>
                    <td>
                      <div align="center">2&ordm; 14 </div>
                    </td>
                    <td align="right">
                      <div align="center">2&ordm; 1 </div>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </div>
</body>

</html>