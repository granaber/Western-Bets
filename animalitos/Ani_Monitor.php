<?php

/*$fc=$_REQUEST['fc'];*/

require('prc_phpDUK.php');
$link = ConnectionAnimalitos::getInstance();

$IDJ = _FechaDUK();
$ListaA = array();
$ListaB = array();
$aSorteo = array();
$isorteo = array();
$GrupIDL = array();
$resultjn1 = mysqli_query($link, "SELECT * FROM _Loterias  Where Activa=1");
while ($rown1 = mysqli_fetch_array($resultjn1)) {
  if (count($aSorteo) == 0) :
    $result = mysqli_query($link, "Select * From  _Jornada  Where IDJ=" . $IDJ . " and IDL=" . $rown1['IDL']);
    while ($Row = mysqli_fetch_array($result)) {
      $aSorteo[] = '(' . $Row['ID'] . ')-' . convertirNormal($Row['HoraCierre']);
      $isorteo[] = $Row['ID'];
    }
  endif;
  $ListaA[] = $rown1['IDL'];
  $ListaB[] = $rown1['Nombre'];
}

?>
<div id='fromUsuarios' align="center" style="background: #FFF; color:#000;width:830px">
  <div id="a_tabbar" align="center" style="width:820px; height:840px;" />
  <?

  foreach ($isorteo as $i => $delta) {
    echo "<div id='tpg_" . $i . "'  style='height:830px; '>";
    echo "</div>";
  }


  ?>
</div>
</div>
<div id="a_tabbar2" align="center" style="width:820px; height:740px;" />
</div>
<div id='gridbox'></div>
<div id="vista">
  <div id="obj2">
    <div id="Calen1" />
  </div>
</div>
</div>
<script>
  SerialMonitor = 0;
  fc = '<? echo FecharealAnimalitos($minutosh, "d/n/Y"); ?>';
  var aSor = '<? echo implode(',', $aSorteo); ?>';
  var xSor = aSor.split(",");
  var iSor = '<? echo implode(',', $isorteo); ?>';
  var xiSor = iSor.split(",");
  var L1 = '<? echo implode(',', $ListaA); ?>';
  var L2 = '<? echo implode(',', $ListaB); ?>';
  mRl1 = L1.split(',');
  mRl2 = L2.split(',');
  mIDL = mRl1[0];

  async function clicktoolBarVer(id) {
    ver = id.split('-');
    if (ver.size() == 3) {
      //'Lt-'+mRl1[i]+'-'+i
      sIDL = ver[2];
      mIDL = ver[1];

      barMon.setItemText('TextoLote', mRl2[sIDL]);
      tabbar.clearAll();
      await _ValoresNew();
      await _TkBar();
    } else {
      switch (id) {
        case "Cerrar_":
          clearInterval(funcionInac);
          dhxWinsMon.window("wMon").close();

          break;
        case "Calendario_":
          calendario();
          break;
      }
    }
  }

  function calendario() {
    dhxWins2 = new dhtmlXWindows();
    dhxWins2.setImagePath("codebase/imgs/");
    var w2 = dhxWins2.createWindow("w2", 400, 60, 190, 210);
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
    fc = fecha;
    barMon.setItemText('TextoFecha', 'Fecha: ' + fecha);
    dhxWins2.window("w2").close();


    xData = _Valores2(fecha);
    xSor = xData[0];
    xiSor = xData[1];
    IDJ = xData[2];
    idjDUK = xData[2];
    //tabbar.clearAll();
    for (i = 0; i <= xSor.length - 1; i++) {
      tabbar.addTab("a_" + i, xSor[i], "150px");
    }
    tabbar.setTabActive("a_0");

    for (i = 0; i <= xSor.length - 1; i++) {
      mygridMM[i].clearAll();

      mygridMM[i].loadXML("animalitos/Ani_Monitor-1-1.php?IDJ=" + IDJ + "&IDS=" + xiSor[i] + "&IDL=" + mIDL);


    }


  }

  function clicktoolTAB(id, lastId) {
    var inew = id.split("_");

    var xId = inew[1];
    idsDUK = xiSor[xId];
    nivel = xId;

    return true;

  }

  function _Valores2(fecha) {
    var r;
    _utxprm = bna('filephp=Ani_Monitor-3.php|fecc=' + fecha, this);
    new Ajax.Request('animalitos/_.php', {
      parameters: {
        uid: _utxprm
      },
      method: 'post',
      asynchronous: false,
      onComplete: function(transport) {
        //new Ajax.Request('animalitos/grabar_animalitos.php',{ parameters: {Jugada:Object.toJSON(TicketCloud),IDC:$('con').title,usu:$('usu').title},method:'post',asynchronous:false,	onComplete: function(transport){
        var response = transport.responseText.evalJSON(true);
        r = response;
      },
      onFailure: function() {
        alert('No tengo respuesta Comuniquese con el Administrador!');
      }
    });
    return r;

  }
  async function _ValoresNew() {
    _utxprm = bna('filephp=Ani_Monitor-1-3.php|IDJ=' + idjDUK + '|IDL=' + mIDL, this);
    new Ajax.Request('animalitos/_.php', {
      parameters: {
        uid: _utxprm
      },
      method: 'post',
      asynchronous: false,
      onComplete: function(transport) {
        //new Ajax.Request('animalitos/grabar_animalitos.php',{ parameters: {Jugada:Object.toJSON(TicketCloud),IDC:$('con').title,usu:$('usu').title},method:'post',asynchronous:false,	onComplete: function(transport){
        var response = transport.responseText.evalJSON(true);
        xiSor = response[1];
        xSor = response[0];
        $('a_tabbar2').innerHTML = response[2];
      },
      onFailure: function() {
        alert('No tengo respuesta Comuniquese con el Administrador!');
      }
    });
  }

  function _TkBar() {

    for (i = 0; i <= xSor.length - 1; i++) {
      tabbar.addTab("a_" + i, xSor[i], "150px");
      tabbar.setContent("a_" + i, "tpg_" + i);
    }

    tabbar.enableScroll(true);
    tabbar.attachEvent("onSelect", clicktoolTAB);

    tabbar.setTabActive("a_0");
    mygridMM = new Array();
    for (i = 0; i <= xSor.length - 1; i++) {
      mygridMM[i] = new dhtmlXGridObject("tpg_" + i);
      mygridMM[i].setImagePath("codebase/imgs/");
      mygridMM[i].setHeader("Num,Animalito,Monto,Cantidad,Porcentaje,Num,Animalito,Monto,Cantidad,Porcentaje");
      mygridMM[i].setInitWidths("40,110,80,80,110,40,110,80,80,110")
      mygridMM[i].setColAlign("right,left,left,left,left,right,left,left,left,left")
      mygridMM[i].setColTypes("ro,ro,ro,ro,ro,ro,ro,ro,ro,ro");
      mygridMM[i].setSkin("dhx_skyblue");
      mygridMM[i].init();
      mygridMM[i].loadXML("animalitos/Ani_Monitor-1-1.php?IDJ=<? echo $IDJ; ?>&IDS=" + xiSor[i] + "&IDL=" + mIDL);
      mygridMM[i].setColumnColor(",,,,,#E0E0E0,#E0E0E0,#E0E0E0,#E0E0E0,#E0E0E0");
    }

  }

  dhxWinsMon = new dhtmlXWindows();
  dhxWinsMon.setImagePath("codebase/imgs/");
  wMon = dhxWinsMon.createWindow("wMon", 200, 100, 850, 900);
  wMon.setText('Monitor (Animalitos)');
  wMon.attachObject('fromUsuarios');
  dhxWinsMon.window("wMon").button('close').hide();
  dhxWinsMon.window("wMon").button('minmax1').hide();
  dhxWinsMon.window("wMon").button('minmax2').hide();
  dhxWinsMon.window("wMon").button('park').hide();
  dhxWinsMon.window("wMon").button('park').hide();
  //dhxWinsMon.window("wMon").denyResize();
  //dhxWinsMon.window("wMon").maximize();
  dhxWinsMon.window("wMon").centerOnScreen();
  barMon = wMon.attachToolbar();
  barMon.addButton("Cerrar_", 1, "Cerrar", "animalitos/icons/noun_1042920_cc.png", "animalitos/icons/noun_1042920_cc.png");
  barMon.addSeparator("separator_", 2);
  barMon.addText('TextoFecha', 3, 'Fecha:' + fc);
  barMon.addButton("Calendario_", 4, "", "animalitos/icons/noun_932012_cc.png", "animalitos/icons/noun_932012_cc.png");

  opts2 = new Array();
  for (i = 0; i <= mRl2.size() - 1; i++) {
    opts2[i] = Array('Lt-' + mRl1[i] + '-' + i, 'obj', mRl2[i]);

  }

  //opts2=Array(Array('Lt1', 'obj', 'La Granja Millonaria'), Array('Lt2', 'obj', 'LotoAnimalitos'))

  barMon.addButtonSelect("Loterias_", 10, 'Animalitos:', opts2, "animalitos/icons/noun_28078_cc.png", null);
  //valor='<a style="color:yellow">'+Rl2[0]+'</a>';
  //console.info(valor)
  barMon.addText('TextoLote', 11, mRl2[0]);

  barMon.attachEvent("onClick", clicktoolBarVer);


  tabbar = new dhtmlXTabBar("a_tabbar", "top");
  tabbar.setStyle("dhx_skyblue");
  tabbar.setImagePath("codebase/imgs/");
  tabbar.enableAutoReSize(true);

  _TkBar();
  idjDUK = <? echo $IDJ; ?>;
  idsDUK = xiSor[0];
  nivel = 0;

  refresMonitor();
</script>