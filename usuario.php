<?
$pfc = $_REQUEST['fc'];
/* parametros de FC
fc = 0 ... Incluir
fc >= 1 ... Busca el registo para modificar o eliminar si existe */

require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$idt = $_REQUEST['idt'];
$accesogp = accesolimitado($idt);


if ($pfc == 0) :

  $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tusu Order by IDusu DESC ");

  if (mysqli_num_rows($result) != 0) :
    $row = mysqli_fetch_array($result);
    $idu = $row["IDusu"] + 1;
  else :
    $idu = 1;
  endif;
  $us = "";
  $nm = "";
  $clv = "";
  $rcl = "";
  $est = "";
  $tp = 1;
  $as = "";
  $es = "";
  $blq = $row["bloqueado"];
  $v = array();
  $v2 = array();
  $ip = 0;
  $ABanca = 0;
  $iAp = array();
else :


  $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tusu where IDusu=" . $pfc);

  $row = mysqli_fetch_array($result);
  $idu = $row["IDusu"];
  $us = $row["Usuario"];
  $nm = $row["Nombre"];
  $clv = $row["clave"];
  $rcl = $row["clave"];
  $est = $row["Estacion"];
  $tp = $row["Tipo"];
  $as = $row["Asociado"];
  $es = $row["Estatus"];
  $blq = $row["bloqueado"];
  $v = explode("|", $row['Acceso']);
  $v2 = explode("-", $row['AccesoP']);
  if ($tp == 4) :  $ip = 1;
    $iAp = explode(',', $row["AGrupo"]);
    $ABanca = $row["ABanca"];
  else : $iAp = [];
    $ip = 0;
    $ABanca = 0;
  endif;
endif;

?>

<div id="fromUsuarios" style="background:#BAC6D8;width:420px; height:1000px">
  <table width="412" border="0" cellspacing="0 ">
    <tr>
      <th colspan="6">
        <div align="center"><span class="Estilo17">Agregar Usuario</span></div>
      </th>
    </tr>
    <tr>
      <th colspan="6" class="subHeader">
        <div align="center"><span class="Estilo23">DATOS DEL USUARIOS</span></div>
      </th>
    </tr>
    <tr>
      <th width="163"><span class="Estilo51">Código</span></th>
      <td width="169" colspan="5" id="n_idu" title=" <?php echo $idu; ?>"><strong><span class="EstiloCodigo"><?php echo $idu; ?></span></strong></td>
    </tr>

    <tr>
      <th class="Estilo51"><span class="Estilo51">Nombre del Usuario</span></th>
      <td colspan="5" class="ta_conc_td">
        <font color="red">
          <input name="Usuario" type="text" id="usuario" size="10" maxlength="10"  onkeyup="pulsart(event,'nombre'); validar3(event);" value='<?php echo $us; ?>' onkeypress="if (permite(event,'num_car3')) {return true;}else{return false;}" />
          *
        </font> <img id="imgusuario" src="media/serro.png" height="16" width="16" style="display:none" title="" />
      </td>
    </tr>
    <tr>
      <th class="Estilo51"><span class="Estilo51">Nombre</span></th>
      <td colspan="5" class="ta_conc_td">
        <font color="red">
          <input name="Nombre" type="text" id="nombre"  onkeyup="pulsart(event,'clave'); validar3(event)" value='<?php echo $nm; ?>' />
          *
        </font> <img id="imgnombre" src="media/serro.png" height="16" width="16" style="display:none" title="" />
      </td>
    </tr>
    <tr>
      <th class="Estilo51"><span class="Estilo51">Clave</span></th>
      <td colspan="5" class="ta_conc_td"><input name="" type="button" value="General" onclick="GenerarClave()" />
        <font color="red">*</font> <img id="imgclave" src="media/serro.png" height="16" width="16" style="display:none" title="" /><span id='claveGenerada'></span>
      </td>
    </tr>
    <tr>
      <th class="Estilo51"><span class="Estilo51">Estacion</span></th>
      <td colspan="5" class="ta_conc_td">
        <font color="red">
          <input name="Nombre" type="text" id="estacion" onfocus=""  onkeyup="pulsart(event,'estacion'); validar3(event)" value='<?php echo $est; ?>' />
          *
        </font> <img id="imgestacion" src="media/serro.png" style="display:none" height="16" width="16" title="" />
      </td>
    </tr>


    <tr>
      <th class="Estilo51"><span class="Estilo51">Tipo de Usuario </span></th>
      <td colspan="5" class="ta_conc_td">
        <font color="red">

          <select name="select2" id="tipo" onchange="cambiarperfil(<? echo $accesogp ?>);">
            <? if ($accesogp == 0) : ?>
              <option onclick="habilitar()" value="1" <?php echo ($tp == 1 ? " selected='selected'" : " "); ?>>Usuario</option>
              <option onclick="habilitar()" value="2" <?php echo ($tp == 2 ? " selected='selected'" : " "); ?>>Administrador</option>
              <option onclick="habilitar()" value="3" <?php echo ($tp == 3 ? " selected='selected'" : " "); ?>>Vendedor</option>
              <option onclick="habilitar()" value="4" <?php echo ($tp == 4 ? " selected='selected'" : " "); ?>>Agente</option>
              <option onclick="habilitar()" value="5" <?php echo ($tp == 5 ? " selected='selected'" : " "); ?>>Sistema</option>
            <? else :
              $tp = 3;
            ?>
              <option onclick="habilitar()" value="3" <?php echo ($tp == 3 ? " selected='selected'" : " "); ?>>Vendedor</option>
            <? endif; ?>
          </select>
        </font>
      </td>
    </tr>
    <tr>
      <th class="Estilo51"><span class="Estilo51">Asociado</span></th>
      <td colspan="5" class="ta_conc_td"><?php
                                          if ($tp == 3) {
                                            echo "<select name='select2' id='asoc' onchange='habilitar()'>";
                                            if ($accesogp == 0) :
                                              $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionario order by IDC");
                                            else :
                                              $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionario where IDG in (" . $accesogp . ") order by IDC");
                                            endif;
                                            while ($row = mysqli_fetch_array($result)) {
                                              echo "<option " . ($as == $row["IDC"] ? " selected='selected'" : " ") . " value=" . $row["IDC"] . ">" . $row["IDC"] . "</option>";
                                            }
                                            echo "</select>";
                                          } else {
                                            echo "<select name='select2' id='asoc' disabled='disabled' onchange='habilitar()'>";
                                            $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionario order by IDRow desc");
                                            while ($row = mysqli_fetch_array($result)) {
                                              echo "<option " . ($as == $row["IDC"] ? " selected='selected'" : " ") . " value=" . $row["IDC"] . ">" . $row["IDC"] . "</option>";
                                            }
                                            echo "</select>";
                                          }
                                          ?></td>
    </tr>
    <tr>
      <th class="Estilo51">Estatus</th>
      <td colspan="5" bordercolor="#FFFFFF" class="ta_conc_td"><select name="select" size="1" id="estatus">
          <option value="1" <?php echo ($es == 1 ? " selected='selected'" : " "); ?>>Activo</option>
          <option value="2" <?php echo ($es == 2 ? " selected='selected'" : " "); ?>>Suspendido</option>
        </select></td>
    </tr>

    <tr>
      <th colspan="3" class="Estilo51" align="left"><input name='acceso' type='checkbox' id='acceso' onclick="if ($('tipo').value=='4') {if (this.checked) {$('combo_zone3').style.display='';}else{$('combo_zone3').style.display='none';} }else{ alert('Para Habilitar esta Opcion el Tipo de Usuario debe ser Administrador de  Grupo'); this.checked=false;}" <? if ($ip != 0) : echo 'checked="checked"';
                                                                                                                                                                                                                                                                                                                                                                  endif; ?> />

        Agente</th>
      <th colspan="5" class="Estilo51">

        <samp id="combo_zone3" style="width:200px; height:30px; <? if ($ip == 0) : echo "display:none";
                                                                endif; ?> "></samp>
        <?php
        $valores = array();
        $ids = array();
        $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tgrupo order by IDG ");
        while ($row = mysqli_fetch_array($result)) {
          $valores[] = $row["IDG"] . '-' . $row["Descrip"];
          $ids[] = $row["IDG"];
        }
        ?>

    </tr>
    <tr>
      <th colspan="5" class="Estilo51" align="left"><input id='vbanca' type="checkbox" value="" onclick="if ($('tipo').value=='4') {if (this.checked) {$('IDB').style.display='';}else{$('IDB').style.display='none';} }else{ alert('Para Habilitar esta Opcion el Tipo de Usuario debe ser Administrador de  Grupo'); this.checked=false;}" <? if ($ip != 0) : echo 'checked="checked"';
                                                                                                                                                                                                                                                                                                                                              endif; ?> />
        Administrador de Banca</th>
      <th colspan="5" class="Estilo51">
        <div id="VBanca"><select name="select2" id="IDB" style="display:none">
            <?
            $result_g = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbanca Order by IDB ");
            while ($row_g = mysqli_fetch_array($result_g)) {
              if ($row_g['Estatus'] == 1) :
                echo "<div id='tpg_" . $row_g['IDB'] . "'  style='height:430px; '>";
                echo '<option  value="' . $row_g['IDB'] . '" ' . ($ABanca == $row_g["IDB"] ? " selected='selected'" : " ") . ' >' . $row_g['IDB'] . '-' . $row_g['NombreB'] . '</option>';
              endif;
            }
            ?>
          </select></div>
      </th>
    </tr>
  </table>
  <samp id='marc' lang="0"></samp>
</div>
<div id="ConfigAcceso">
  <?
  include('usuario-1-4.php');
  ?>
</div>

<script>
  <? if ($accesogp == 0) : ?>
    checkBan = '<? echo implode(",", $iAp); ?>';
    valores = '<? echo implode(",", $valores); ?>';
    idst = '<? echo implode(",", $ids); ?>';
    var pvalores = valores.split(",");
    var pids = idst.split(",");
    var icheckBan = checkBan.split(",");
  <? endif; ?>

  function clicktoolBar(id) {
    switch (id) {
      case "Cerrar_":
        dhxWins1.window("w1").close();
        dhxWins1.window("w2").close();
        makeRequest('usuario-1-1.php');
        break;
      case "Guardar_":
        <? if ($accesogp == 0) : ?> rSeleccion();
        <? endif; ?>
        grabar_usuario();
        break;
      case "Eliminar_":
        elimnar_usuario();
        break;
    }
  }
  dhxWins1 = new dhtmlXWindows();
  dhxWins1.setImagePath("codebase/imgs/");
  w1 = dhxWins1.createWindow("w1", 300, 255, 415, 350);
  w1.setText('Usuario');
  w1.attachObject('fromUsuarios');
  dhxWins1.window("w1").button('close').hide();
  dhxWins1.window("w1").button('minmax1').hide();
  dhxWins1.window("w1").button('minmax2').hide();
  dhxWins1.window("w1").button('park').hide();
  dhxWins1.window("w1").denyResize();
  dhxWins1.window("w1").denyMove();
  dhxWins1.window('w1').setModal(true);
  var bar = w1.attachToolbar();
  bar.addButton("Cerrar_", 4, "Volver", "images/redo.gif", "images/redo.gif");
  <? if (!$pfc == 0) : ?>
    bar.addButton("Guardar_", 1, "Guardar ", "media/users.png", "media/users.png");
    bar.addButton("Eliminar_", 3, "Eliminar ", "images/sample_close.gif", "images/sample_close.gif");
  <? else : ?>
    bar.addButton("Guardar_", 1, "Guardar Nuevo ", "media/users.png", "media/users.png");
  <? endif; ?>
  bar.attachEvent("onClick", clicktoolBar);


  w2 = dhxWins1.createWindow("w2", 730, 255, 420, 755);
  w2.setText('Configuracion de Acceso');
  w2.attachObject('ConfigAcceso');
  dhxWins1.window("w2").button('close').hide();
  dhxWins1.window("w2").button('minmax1').hide();
  dhxWins1.window("w2").button('minmax2').hide();
  dhxWins1.window("w2").button('park').hide();
  dhxWins1.window("w2").denyMove();
  //dhxWins1.window('w1').setModal(true);
  <? if ($accesogp == 0) : ?>
    z2 = new dhtmlXCombo("combo_zone3", "alfa3", 170, 'checkbox');
    valor = '';
    var valores = new Array();
    for (i = 0; i <= pvalores.length - 1; i++) {
      var valor = new Array();
      valor[0] = pids[i];
      valor[1] = pvalores[i];
      valores[i] = valor;
    }
    z2.addOption(valores);
    for (i = 0; i <= icheckBan.length - 1; i++)
      for (j = 0; j <= pids.length - 1; j++)
        if (pids[j] == icheckBan[i])
          z2.setChecked(j, true)
  <? endif; ?>
  var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
</script>