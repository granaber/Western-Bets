<style type="text/css">
  <!--
  .Estilo2d1 {
    color: #000000
  }

  .Estilo3d1 {
    color: #FFFF66;
    font-size: 10px;
  }

  .Estilo5d1 {
    color: #FFFFFF;
    font-size: 10px;
  }

  .Estilo4d1 {
    color: #FFFFFF;
    font-size: 14px
  }
  -->
</style>





<div id="box5">
  <?php

  require('prc_php.php');
  $GLOBALS['link'] = Connection::getInstance();

  ?>

  <table width="440" border="0" cellspacing="0">
    <tr bgcolor="#006699">
      <th bgcolor="#006699"></th>
      <th colspan="4" bgcolor="#006699">
        <div align="center" class="Estilo4d1">Reporte de Ventas y Ganacias Resumido Prototype II</div>
        <div align="right"></div>
      </th>
    </tr>
    <tr bgcolor="#006699">
      <th bgcolor="#006699"></th>
      <th bgcolor="#006699">&nbsp;</th>
      <th colspan="2" bgcolor="#006699">&nbsp;</th>
      <th bgcolor="#006699">
        <div align="right"></div>
      </th>
    </tr>

    <tr bgcolor="#006699">
      <th bgcolor="#006699"></th>
      <th bgcolor="#006699" class="Estilo3d1">
        <div align="right">Desde:</div>
      </th>
      <th width="144" bgcolor="#006699"><input name="fc" type="text" id="fc1" size="10" value="<?php echo date("d/n/Y"); ?>" /></th>
      <th width="137" bgcolor="#006699">
        <div align="right" class="Estilo3d1">Hasta:</div>
      </th>
      <th bgcolor="#006699"><input name="fc" type="text" id="fc2" size="10" value="<?php echo date("d/n/Y"); ?>" /></th>
    </tr>

    <tr bgcolor="#006699">
      <th bgcolor="#006699"></th>
      <th bgcolor="#006699">
        <div align="right" class="Estilo3d1">Clasificar Por:</div>
      </th>
      <th colspan="3" bgcolor="#006699">
        <form id="form2" name="form2" method="post" action="">
          <label>
            <input name="radio" type="radio" id="uno" onclick="$('tu').style.display='';$('tdc').style.display=''; $('td').style.display='none';$('tdg').style.display='none';$('tt').style.display='none';$('tdb').style.display='none';" value="radio" checked="checked" />
          </label>
          <span class="Estilo5d1">Concesionario</span>
          <label>
            <input type="radio" name="radio" id="dos" value="radio" onclick="$('tu').style.display='none';$('tdc').style.display='none'; $('td').style.display='';$('tdg').style.display='';$('tt').style.display='none';$('tdb').style.display='none';" />
          </label>
          <span class="Estilo5d1">Grupo</span>
          <label>
            <input type="radio" name="radio" id="tres" value="radio" onclick="$('tu').style.display='none';$('tdc').style.display='none'; $('td').style.display='none';$('tdg').style.display='none';$('tt').style.display='';$('tdb').style.display='';" />
          </label>
          <span class="Estilo5d1">Banca</span>
        </form>
      </th>
    </tr>
    <tr bgcolor="#006699">
      <th bgcolor="#006699"></th>
      <th bgcolor="#006699" class="Estilo3d1">
        <div id="tu" align="right">Concesionario:</div>
        <div id="td" align="right" style="display:none">Grupo</div>
        <div id="tt" align="right" style="display:none">Banca</div>
      </th>
      <th colspan="2" bgcolor="#006699">
        <span id="spryselect1">
          <label>
            <div id="tdc" align="left">
              <select id="Concesionario">
                <option value="0">Todos</option>
                <?php $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionario order by IDC");
                while ($row = mysqli_fetch_array($result)) {
                  echo "<option value=" . $row["IDC"] . ">" . $row["IDC"] . "</option>";
                }
                ?>
              </select>
            </div>
            <div id="tdg" align="left" style="display:none">
              <select size="1" id="grupo">
                <option selected="selected" value="0">Todos</option>
                <?php $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tgrupo order by IDG");
                $idg = "";
                while ($row = mysqli_fetch_array($result)) {
                  echo "<option " . ($idg == $row["IDG"] ? " selected='selected'" : " ") . " value=" . $row["IDG"] . ">" . $row["IDG"] . "</option>";
                }
                ?>
              </select>
            </div>
            <div id="tdb" align="left" style="display:none">
              <select size="1" id="banca">
                <option selected="selected" value="0">Todos</option>
              </select>
            </div>
          </label>
          <span class="selectRequiredMsg">Seleccione un elemento.</span></span>
      </th>
      <th bgcolor="#006699">&nbsp;</th>
    </tr>
    <tr bgcolor="#006699">
      <th bgcolor="#006699"></th>
      <th bgcolor="#006699">&nbsp;</th>
      <th colspan="2" bgcolor="#006699">&nbsp;</th>
      <th bgcolor="#006699">&nbsp;</th>
    </tr>
    <tr bgcolor="#006699">
      <th width="1" bgcolor="#006699"></th>
      <th width="80" bgcolor="#006699">&nbsp;</th>
      <th colspan="2" bgcolor="#006699">&nbsp;</th>
      <th width="68" bgcolor="#006699"><img src="media/impripan.png" alt="Imprimir" onclick="imprimirreddprt();" />&nbsp;&nbsp;</th>
    </tr>
  </table>
</div>

<script>
  Nifty('div#box5', 'big');
  var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
  cargarcampos_ddes1();
  cargarcampos_ddes2();
</script>