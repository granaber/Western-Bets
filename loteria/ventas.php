<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

if ($_REQUEST["IDCtr"] != '-2') :
  $resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tapertura where IDC=" . $_REQUEST["IDCtr"] . ' and IDJ=' . $_REQUEST["IDJ"]);

  $resultado = (mysqli_num_rows($resultj) != 0);
else :
  $resultado = true;
endif;

if ($resultado) :
  $resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbcuadre where IDC=" . $_REQUEST["IDCtr"] . ' and IDJ=' . $_REQUEST["IDJ"]);

  if ((mysqli_num_rows($resultj) != 0)) :
    $resultado = false;
  endif;

  if ($resultado) :
    $resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tjornada  Where Fecha=STR_TO_DATE('" . Fechareal(0, 'd/n/Y') . "','%d/%m/%Y')");
    $rowj = mysqli_fetch_array($resultj);

    if ($rowj['IDJ'] == $_REQUEST["IDJ"]) :


?>
      <div id="objId">
        <table border="0" cellspacing="0">
          <tr>
            <td width="144" style="background:#069"><strong><span id="Cng" lang="1" style="font-size:14px; color: #FF0">MONEDA Bsf.</span></strong></td>
            <td width="144" style="background:#069"><strong><span style="font-size:14px; color:#FFF">Fecha:<input id='fecha' type="text" style="background:#069; color:#FFF; border:none" size="7" /></span></strong></td>
            <td style="background:#069"><strong><span style="font-size:14px; color:#FFF">Hora:<input id='hora' type="text" style="background:#069; color:#FFF; border:none" size="9" /></span></strong></td>
          </tr>
          <tr>
            <td><strong><span id="Txtliterial" style="font-size:14px;" lang="1">Numero</span></strong></td>
            <td><strong><span style="font-size:14px">Monto</span></strong></td>
          </tr>
          <tr>
            <td><span id="sprytextfield1">
                <input type="text" name="textfield" id="Numero" onkeypress="handleEnter('MontoA',event)" />
                <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no valido.</span><span class="textfieldMinCharsMsg">No se cumple el minimo de caracteres requerido.</span><span class="textfieldMaxCharsMsg">Se ha superado el numero m�ximo de caracteres.</span></span>
              <span id="secuencia" style="display:none"><span id="sprytextfield3">
                  <input id="desde" type="text" size="6" onkeypress="handleEnter('hasta',event)" />
                  <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v�lido.</span></span>-<span id="sprytextfield4">
                  <input id="hasta" type="text" size="6" onkeypress="handleEnter('MontoA',event)" />
                  <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v�lido.</span></span> </span>

            </td>
            <td><span id="sprytextfield2">
                <input type="text" name="textfield2" id="MontoA" onkeypress="handleEnter('idAceptar',event)" />
                <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no valido.</span></span>

            </td>
            <td>
              <input type="submit" name="button" id="idAceptar" value="Aceptar Jugada" disabled="disabled" onclick="Add_Venta(parseInt($('Txtliterial').lang))" />
            </td>
          </tr>
        </table>

      </div>

      <div id="BoxMonto">
        <table border="0" cellspacing="0">
          <tr>
            <td style="background:#069" width="250px"><strong><span style="font-size:16px; color:#FFF">Total del Ticket(Bsf):</span></strong></td>
            <td style="background:#069" width="200px"><input name="" type="text" id="Total_Ticket" value="0" style="font-size:16px"></td>
          </tr>
        </table>
      </div>
      <div id="BtnComandos">
        <table border="0">
          <tr>
            <td colspan="6">&nbsp;</td>
          </tr>
          <tr>
            <td width="176"> <button type="submit" id="_Imprimir" onclick="grabarjugada($('stAgencia').lang)" style="width:170px">
                <div align="left"> <img src="images/print.gif" width="18" height="18" /> Impresion de Ticket</div>
              </button></td>
            <td width="6">&nbsp;</td>
            <td width="6">&nbsp;</td>
            <td width="6">&nbsp;</td>
            <td width="6">&nbsp;</td>
            <td width="6">&nbsp;</td>
          </tr>
          <tr>
            <td>
              <button type="submit" id="_Limpiar" onclick="LimiarTicket()" style="width:170px">
                <div align="left"> <img src="images/edit_dis.gif" width="18" height="18" /> Limpiar Ticket </div>
              </button>
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td> <button type="submit" id="_Eliminar" onclick="Eliminar_Linea()" style="width:170px">
                <div align="left"> <img src="images/sample_close.gif" width="18" height="18" /> Eliminar Filas </div>
              </button></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>

          <tr>
            <td><button type="submit" id="_Permutas" onclick="permutar()" style="width:170px">
                <div align="left"> <img src="images/dhtmlxlayout_icon.gif" width="18" height="18" /> Permutas</div>
              </button></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><button type="submit" id="_Permutas" onclick=" secuencia()" style="width:170px">
                <div align="left"> <img src="images/dhtmlxtoolbar_icon.gif" width="18" height="18" /> Secuencias </div>
              </button></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><button type="submit" id="_Series" onclick="Mseries()" style="width:170px">
                <div align="left"> <img src="images/dhtmlxtoolbar_icon.gif" width="18" height="18" /> Series </div>
              </button></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><button type="submit" id="CambioTriple_a_Terminal" onclick="CambioTriple_a_Terminal()" style="width:170px">
                <div align="left"> <img src="images/dhtmlxajax_icon.gif" width="18" height="18" /> Triple -> Terminal</div>
              </button></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><button type="submit" id="CambioTriple_a_Punta" onclick="CambioTriple_a_Punta()" style="width:170px">
                <div align="left"> <img src="images/leaf_new.gif" width="18" height="18" /> Triple -> Punta</div>
              </button></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><button type="submit" id="CambioTripletazo_a_Terminalazo" onclick="CambioTripletazo_a_Terminalazo()" style="width:170px">
                <div align="left"> <img src="images/leaf_new.gif" width="18" height="18" /> Triple->Terminal(zo) </div>
              </button></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><button type="submit" id="ChangeLotery" onclick="ChangeLotery()" style="width:170px">
                <div align="left"> <img src="images/sample_close.gif" width="18" height="18" /> Loteria -> Loteria </div>
              </button></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><button type="submit" id="CopyLotery" onclick="CopyLotery()" style="width:170px">
                <div align="left"> <img src="images/sample_close.gif" width="18" height="18" /> Copiar a Otra Loteria</div>
              </button></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><button type="submit" id="VerTicket" onclick="VerTicket()" style="width:170px">
                <div align="left"> <img src="images/dhtmlxaccordion_icon.gif" width="18" height="18" /> Ver Jugada </div>
              </button></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><button type="submit" id="Premios" onclick="VerTicketPremiados()" style="width:170px">
                <div align="left"> <img src="images/dhtmlxaccordion_icon.gif" width="18" height="18" /> Premios</div>
              </button></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><button type="submit" id="Gatos" onclick="GastosPuntodeVenta()" style="width:170px">
                <div align="left"> <img src="images/dhtmlxaccordion_icon.gif" width="18" height="18" /> Inclusion de Gastos </div>
              </button></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><button type="submit" id="CierreCaja" onclick="CierreDeCaja(<? echo $_REQUEST["IDJ"]; ?>)" style="width:170px">
                <div align="left"> <img src="images/dhtmlxaccordion_icon.gif" width="18" height="18" /> Cierre de Caja</div>
              </button></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><button type="submit" id="Filtrado" onclick="Filtrado()" style="width:170px">
                <div align="left"> <img src="images/dhtmlxaccordion_icon.gif" width="18" height="18" />Filtrado por Hora</div>
              </button></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><button type="submit" id="Filtrado" onclick="CopiarTKchg()" style="width:170px">
                <div align="left"> <img src="images/leaf_new.gif" width="18" height="18" />Copiar Ticket</div>
              </button></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>

      </div>


      <samp id="nticket" lang=""></samp>

      <div id="vista">
        <div id="obj">
          <div id="Calen1" />
        </div>
      </div>
      </div>
      <div id="FrmBsq" style="display:none">
        <div id="Busqueda"><br /><br />
          <span> Indique el Serial: </span><span id="sprytextfield5">
            <input id="BSerial" type="text" size="8" />
            <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v�lido.</span></span>&nbsp;&nbsp;&nbsp;<input name="" type="button" value="Buscar" onclick="BusquedaSerial();" />
        </div>
      </div>

      <div id="frmPremio" style="display:none">
        <div id="BusquedaPremio"><br /><br />
          <span> Indique el Serial: </span>
          <input id="BSerialP" type="text" size="8" />&nbsp;&nbsp;&nbsp;<input name="" type="button" value="Buscar" onclick="BusquedaSerialPREMIO();" />
        </div>
      </div>

      <div id="frmPagoPremio" style="display:none">
        <div id="PagoPremioCodigo"><br />
          <span> Indique Codigo: </span>
          <input id="UNO" type="text" size="5" />-<input id="DOS" type="text" size="5" />-<input id="TRES" type="text" size="5" />-<input id="CUATRO" type="text" size="5" /><input name="" type="button" value="Validar" onclick="comparar();" />
        </div>
      </div>
      <div id='FromRegistroGasto'>
        <div id="RegistroGasto"></div>
      </div>
      <div id="frmCpySerial" style="display:none">
        <div id="CpySerial"><br />
          <span> Indique Serial: </span>
          <input name="" type="text" id="iuSerial" />
        </div>
      </div>
      <script>
        function doOnCheckLoterias(rowId, cellInd, state) {
          if ($('Txtliterial').lang == '1' || $('Txtliterial').lang == '2')
            $('Numero').focus();
          else
            $('desde').focus();

          if (checkLoteria(mygrid.cells(rowId, 4).getValue())) {
            if (ckeck_Juegos())
              $('idAceptar').disabled = "";
            else
              $('idAceptar').disabled = "disabled";

            if (mygrid.cells(rowId, 6).getValue() != 1 && state) {
              cargar_formato(mygrid.cells(rowId, 6).getValue());
              layout1.cells("a").expand();
            } else {
              if (mygrid.cells(rowId, 6).getValue() != 1) {
                mygridAdicc.clearAll();
                layout1.cells("a").collapse();
              }
            }

          } else {

            mygrid.deleteRow(rowId);
          }
          $('Numero').focus();

        }

        function doOnCheckLoteriasAdici(rowId, cellInd, state) {
          $('Numero').focus();
        }

        function clicktoolBar(id) {

          switch (id) {
            case "Cerrar_":
              stop_func();
              dhxWins1.window("w1").close();
              break;
            case "Moneda":
              if ($('Cng').lang == 1) {
                $('Cng').lang = 2;
                $('Cng').innerHTML = 'CONVERTIR Bs.-Bsf.';
              } else {
                $('Cng').lang = 1;
                $('Cng').innerHTML = 'MONEDA  Bsf.';
              }
              break;

          }

        }
        filaventas = 0;

        dhxWins1 = new dhtmlXWindows();

        dhxWins1.setImagePath("codebase/imgs/");
        w1 = dhxWins1.createWindow("w1", 10, 50, 1000, 550);
        w1.setText("Ventas");
        dhxWins1.window("w1").maximize();

        //dhxWins1.setSkin("web"); 
        dhxLayout = w1.attachLayout("5H");

        dhxLayout.cells("a").setText("Loterias Activas");
        dhxLayout.cells("a").setWidth(315);
        dhxLayout.cells("a").fixSize(true, true);
        dhxLayout.cells("b").setText("Ventas");
        dhxLayout.cells("b").setHeight(130);
        dhxLayout.cells("b").setWidth(450);
        dhxLayout.cells("b").attachObject("objId");
        dhxLayout.cells("b").fixSize(true, true);
        dhxLayout.cells("c").setText("Ticket Virtual"); /// <-- Coloco el Numero de Ticket en Pantalla
        //dhxLayout.cells("c").fixSize(true,true);
        dhxLayout.cells("d").setText("Totales");
        dhxLayout.cells("d").setHeight(70);
        dhxLayout.cells("d").attachObject("BoxMonto");
        dhxLayout.cells("d").fixSize(true, true);
        dhxLayout.cells("e").setText("Comandos/Adicionales");
        dhxLayout.cells("e").fixSize(true, true);

        layout1 = new dhtmlXLayoutObject(dhxLayout.cells("e"), "2U");
        layout1.cells("b").setText("Comandos");
        layout1.cells("b").attachObject("BtnComandos");
        //layout1.cells("b").fixSize(true,true);
        layout1.cells("a").setText("Adicionales");
        layout1.cells("a").setWidth(110);
        layout1.cells("a").collapse();
        layout1.cells("a").fixSize(true, true);

        mygridAdicc = layout1.cells("a").attachGrid();
        mygridAdicc.setImagePath("codebase/imgs/");
        mygridAdicc.setHeader("Signo,Sel,ID");
        mygridAdicc.setInitWidths("70,35")
        mygridAdicc.setColAlign("right,left")
        mygridAdicc.setColTypes("ro,ch,ro");
        //mygridAdicc.setColumnColor("white,white");
        mygridAdicc.setSkin("dhx_skyblue");
        mygridAdicc.enableMultiselect(true);
        mygridAdicc.attachEvent("onCheckbox", doOnCheckLoteriasAdici);
        mygridAdicc.init();


        /// Barra de Herramientas////
        bar = w1.attachToolbar();
        bar.addSeparator("separator_", 0);
        bar.addButton("mensaje", 1, "Mensajes", "images/dhtmlxaccordion_icon.gif", "images/dhtmlxaccordion_icon.gif");
        bar.addSeparator("separator_", 2);
        bar.addButton("Moneda", 3, "Convetir Bs.-Bsf.", "images/dhtmlxajax_icon.gif", null);
        bar.addSeparator("separator_", 4);
        bar.addButton("Cerrar_", 5, "Salir", "images/close.gif", "images/close.gif");
        bar.attachEvent("onClick", clicktoolBar);

        // Grid de Loterias //
        createByxml_Loteria('gridventas.xml', 'SELECT * FROM _tloteria where Estatus=1 Order by IDLot', 'DATA!imagen|SEL!0|NombrePantalla|HORADIA|IDLot|NombreTicket|Formato');
        mygrid = dhxLayout.cells("a").attachGrid();
        mygrid.setImagePath("codebase/imgs/");
        mygrid.setHeader("Loteria,Sel,Loteria,H.Sorteo,ID,NombreTicket,Formato");
        mygrid.setInitWidths("70,30,150,55")
        mygrid.setColAlign("right,left,left,center")
        mygrid.setColTypes("ro,ch,ro,ro,ro,ro,ro");
        mygrid.enableStableSorting(true);
        mygrid.setColSorting("str,na,na,str");
        //mygrid.setColumnColor("white,white,white,white");
        mygrid.setSkin("dhx_skyblue");
        mygrid.attachEvent("onCheckbox", doOnCheckLoterias);
        mygrid.init();
        mygrid.loadXML("gridventas.xml", function() {
          mygrid.sortRows(3, "str", "asc");
        });


        // Grid de Ticket de Ventas //
        mygridv = dhxLayout.cells("c").attachGrid();
        mygridv.setImagePath("codebase/imgs/");
        mygridv.setHeader("Sel,Numero(s), Loteria(s),Monto,Adicional,IDlot,Addi");
        mygridv.setInitWidths("30,75,140,60,135");
        mygridv.setColAlign("left,right,center,right,left");
        mygridv.setColTypes("ch,ed,ro,ed,ro,ro,ro");
        mygridv.setSkin("dhx_skyblue");
        mygridv.enableMultiselect(true);
        mygridv.init();

        //horaestablecer('hora','fecha');

        $('Numero').focus();
        var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {
          pattern: "000",
          validateOn: ["blur", "change"],
          useCharacterMasking: true,
          minChars: 2,
          maxChars: 3
        });
        var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "real", {
          validateOn: ["blur", "change"],
          useCharacterMasking: true
        });
        var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "integer", {
          useCharacterMasking: true
        });
        var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "integer", {
          useCharacterMasking: true
        });
        var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "integer", {
          useCharacterMasking: true
        });
      </script>
    <? else : ?>
      <script>
        alert('Por Favor Presionar la Opcion <Salir del Sistema>')
      </script>
    <? endif; ?>
  <? else : ?>
    <script>
      alert('El Cierre para Venta ya fue Realizado!')
    </script>
  <? endif; ?>
<? else : ?>
  <script>
    alert('La Apertura no fue realizada, Por Favor Proceda con la Opcion')
  </script>
<? endif; ?>