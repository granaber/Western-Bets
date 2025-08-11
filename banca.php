<style type="text/css">
  .Estilo17 {
    font-family: Verdana, Arial, Helvetica, sans-serif;
    font-size: 18px;
    font-weight: bold;
    color: #000
  }
</style>

<?
$pfc = $_REQUEST['fc'];
/* parametros de FC
fc = 0 ... Incluir
fc >= 1 ... Busca el registo para modificar o eliminar si existe */

require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
if ($pfc == 0) :

  $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbanca Order by IDB DESC ");
  $row = mysqli_fetch_array($result);
  if ($result) :
    $idg = $row["IDB"] + 1;
  else :
    $idg = 1;
  endif;
  $nm = "";
  $res = "";
  $es = 1;
else :
  $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbanca where IDB=" . $pfc);
  $row = mysqli_fetch_array($result);
  $idg = $row["IDB"];
  $nm = $row["NombreB"];
  $res = $row["Propietario"];
  $es = $row["Estatus"];
endif;

?>
<div id="fromBanca" style="background:#BAC6D8;width:415px; height:1000px">
  <table width="481" cellpadding="0" cellspacing="0">
    <tbody>
      <tr>
        <td width="479">
          <table border="0" cellpadding="2" cellspacing="1" width="100%">

            <tbody>


              <tr title="">
                <td width="20%"><strong>Codigo</strong></td>
                <td width="80%" id="n_idg" title="<?php echo $idg; ?>"><span style="font-size:14px; color:#FF9900"><strong><?php echo $idg; ?></strong></span><br /></td>
              </tr>

              <tr>
                <td>Nombre</td>
                <td><input name="text5" type="text" id="nombre" onChange="validar4(event);" onkeyup="pulsart(event,'responsable'); validar4(event);" value='<?php echo $nm; ?>' />
                  <font color="red"> *</font>
                  <img id="imgnombre" src="media/serro.png" height="16" width="16" style="display:none" title="" />
                </td>
              </tr>
              <tr>
                <td>Responsable</td>
                <td><input name="text4" type="text" id="responsable" onChange="validar4(event);" onkeyup="pulsart(event,'telefono'); validar4(event);" value='<?php echo $res; ?>' />
                  <font color="red">*</font>
                  <img id="imgresponsable" src="media/serro.png" height="16" width="16" style="display:none" title="" />
                </td>
              </tr>

              <tr>
                <td>Estatus</td>
                <td><select name="select" size="1" id="estatus">
                    <option value="1" <?php echo ($es == 1 ? " selected='selected'" : " "); ?>>Activo</option>
                    <option value="2" <?php echo ($es == 2 ? " selected='selected'" : " "); ?>>Suspendido</option>
                  </select></td>
              </tr>
            </tbody>
          </table>

      </tr>
    </tbody>
  </table>
</div>

<script>
  function clicktoolBar(id) {
    switch (id) {
      case "Cerrar_":
        dhxWins1.window("w1").close();
        makeRequest('banca-1-1.php');
        break;
      case "Guardar_":
        grabar_banca();
        break;
      case "Eliminar_":
        eliminar_banca();
        break;
    }
  }
  dhxWins1 = new dhtmlXWindows();
  dhxWins1.setImagePath("codebase/imgs/");
  w1 = dhxWins1.createWindow("w1", 350, 300, 315, 250);
  w1.setText('BANCA');
  w1.attachObject('fromBanca');
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

  //dhxWins1.window('w1').setModal(true);
</script>