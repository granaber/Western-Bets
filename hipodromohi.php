<style type="text/css">
  .Estilo17 {
    font-family: Verdana, Arial, Helvetica, sans-serif;
    font-size: 18px;
    font-weight: bold;
    color: #FFFFFF
  }

  .EstiloH1 {
    color: #FFFFFF
  }

  .EstiloH2 {
    color: #FFFF00
  }
</style>

<?php

$pfc = $_REQUEST['fc'];
/* parametros de FC
fc = 0 ... Incluir
fc >= 1 ... Busca el registo para modificar o eliminar si existe */


require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
if ($pfc == 0) :

  $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _hipodromoshi Order by _idhipo DESC ");
  $row = mysqli_fetch_array($result);
  if ($result) :
    $idh = $row["_idhipo"] + 1;
  else :
    $idh = 1;
  endif;

  $nm = "";
  $sig = "";
  $es = 1;

else :
  $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _hipodromoshi where _idhipo=" . $pfc);
  $row = mysqli_fetch_array($result);
  $idh = $row["_idhipo"];
  $nm = $row["Descripcion"];
  $sig = $row["siglas"];
  $es = $row["Estatus"];
endif;

?>
<div id="box13">
  <table width="439" cellpadding="0" cellspacing="0">
    <tbody>
      <tr>
        <td width="362">
          <div align="center">
            <span class="Estilo17">Agregar Hipodromo </span>
          </div>
          <br />
          <table border="0" cellpadding="2" cellspacing="1" width="100%">

            <tbody>


              <tr title="">
                <td width="20%"><strong class="EstiloH1">Codigo</strong></td>
                <td width="80%" id="n_idh" title="<?php echo $idh; ?>"><strong style="color:#FFFF00; font-size:16px"><?php echo $idh; ?></strong></td>
              </tr>

              <tr>
                <td><span class="EstiloH1">Nombre</span></td>
                <td><input name="text5" type="text" id="nombre" onChange="validar2(event);" onkeyup="pulsart(event,'sig'); validar4(event);" value='<?php echo $nm; ?>' />
                  <font color="red"> *</font>
                  <img id="imgnombre" src="media/serro.png" height="16" width="16" style="display:none" title="" />
                </td>
              </tr>
              <tr>
                <td><span class="EstiloH1">Siglas</span></td>
                <td><input name="textfield" type="text" id="sig" size="5" onChange="validar4(event);" maxlength="5" onkeyup="pulsart(event,'sig'); validar4(event);" value="<?php echo $sig; ?>">
                  <font color="red"> *</font>
                  <img id="imgsig" src="media/serro.png" height="16" width="16" style="display:none" title="" />
                </td>
              </tr>
              <tr>
                <td><span class="EstiloH1">Estatus</span></td>
                <td><select name="select" size="1" id="estatus">
                    <option value="1" <?php echo ($es == 1 ? " selected='selected'" : " "); ?>>Activo</option>
                    <option value="2" <?php echo ($es == 2 ? " selected='selected'" : " "); ?>>Suspendido</option>
                  </select></td>
              </tr>
            </tbody>
          </table>
          <p>
            <?php if (!$pfc == 0) :
              echo  "<input id='btnguardar'  value='Modificar' type='submit'  onclick='grabar_hipohi();'/>";
              echo  "<input id='btneliminar'  value='Eliminar Hipodromo' type='submit'  onclick='elimnar_hipohi();'/>";
            else :
              echo  "<input id='btnguardar'  value='Guardar Nuevo Hipodromo' type='submit'  disabled='disabled' onclick='grabar_hipohi();'/>";
            endif;
            ?>
            <input name="submit_regresar" value="<-Volver" title="<?php echo $pfc; ?> " onClick="javascript:yq = false;makeRequestJAVA('hipodromo-1-1.php');" type="button" />
          </p><br>
          <font color="red">*</font><samp style="color:#FFFF00">= Campos Obligatorios</samp>
        </td>
      </tr>
    </tbody>
  </table>
</div>
<div id="tablamenu1"></div>
<script>
  Nifty('div#box13', 'big');
</script>