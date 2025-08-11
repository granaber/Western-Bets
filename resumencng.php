<style type="text/css">
  <!--
  .Estilo1r {
    color: #FFFFFF
  }

  .Estilo2 {
    color: #FFFFFF;
    font-weight: bold;
  }

  .Estilo3 {
    color: #FFFFFF;
    font-weight: bold;
    font-size: 16px;
  }

  .Estilo1a {
    color: #FFFF00;
    font-weight: bold;
  }

  body {
    background-color: #000;
  }
  -->
</style>

<?php
$cns = $_REQUEST['cns'];
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$resultx = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionario where IDC= '" . $cns . "'");
$rowx = mysqli_fetch_array($resultx);
$nombre = $cns . '-' . $rowx['Nombre'];
$grupo = $rowx['IDG'];

$resultx = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconsecionariodd where IDC= '" . $cns . "'");
$rowx = mysqli_fetch_array($resultx);
$procentajeventas1 = $rowx['pVentas'];
$procentajeventas2 = $rowx['pVentaspd'];
$participacion1 = $rowx['Participacion1'];
$participacion2 = $rowx['Participacion2'];
$cmaxelim = $rowx['cmaxelim'];
$mma = $rowx['mma'];
$mmjpd = $rowx['mmjpd'];
$mmjpp = $rowx['mmjpp'];
$mmdp = $rowx['mmdp'];
if ($cmaxelim == 0) :
  $cmaxelim = ' No puede eliminar';
endif;
?>
<div id="box5" style="width:700px">
  <table width="687" height="141" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="2">
        <div align="center" class="Estilo3">Resumen de su Configuracion para la Venta </div>
      </td>
    </tr>
    <tr>
      <td width="273" height="36"><strong><img src="media/mundo.pnp.png" width="32" height="32"><span class="Estilo1r">Grupo No: </span></strong><span class="Estilo1a" style="font-size:14px"><?php echo $grupo; ?></span></td>
      <td width="160"><strong><img src="media/user.png" width="24" height="24"><span class="Estilo1r">Concesionario:</span></strong><span class="Estilo1a" style="font-size:14px"><?php echo $nombre; ?></span></td>
    </tr>
    <tr>
      <td colspan="2">
        <p><span class="Estilo1r"><strong>% de Ventas:</strong> Parlay:<span class="Estilo1a" style="font-size:14px"><?php echo $procentajeventas1; ?>%</span>Por Derecho:<span class="Estilo1a" style="font-size:14px"><?php echo $procentajeventas2; ?>%</span> </span>
        </p>
      </td>
    </tr>
    <tr>
      <td colspan="2"><strong><span class="Estilo1r">% de Participacion:</span> <img src="media/mas.pnp.png" width="13" height="14"><span class="Estilo1a" style="font-size:14px"><?php echo $participacion1; ?>%</span><img src="media/menos.pnp.png" width="13" height="14"></strong><span class="Estilo1a" style="font-size:14px"><?php echo $participacion2; ?>%</span></td>
    </tr>
    <tr>
      <td><span class="Estilo2"><img src="media/bandera.pnp.png" width="16" height="16">Monto Maximo de Jugada por
          Derecho</span></td>
      <td><span class="Estilo1a" style="font-size:14px">Bs.F.
          <?php echo number_format($mmjpd, 2, '.', ''); ?></span></td>
    </tr>
    <tr>
      <td><span class="Estilo2"><img src="media/bandera.pnp.png" width="16" height="16"><span class="Estilo1r">Monto Maximo de la Apuesta por Ticket</span></span></td>
      <td><span class="Estilo1a" style="font-size:14px">Bs.F.
          <?php echo number_format($mma, 2, '.', ''); ?></span></td>
    </tr>
    <tr>
      <td><span class="Estilo2"><img src="media/bandera.pnp.png" width="16" height="16"><span class="Estilo1r">Monto Maximo de Jugada por Parlay</span></span></td>
      <td><span class="Estilo1a" style="font-size:14px">Bs.F.
          <?php echo number_format($mmjpp, 2, '.', ''); ?></span></td>
    </tr>
    <tr>
      <td><span class="Estilo2"><img src="media/bandera.pnp.png" width="16" height="16"><span class="Estilo1r">Monto Maximo del Premio</span></span></td>
      <td><span class="Estilo1a" style="font-size:14px">1x<?php echo number_format($mmdp, 2, '.', ''); ?></span>
      </td>
    </tr>

    <tr>
      <td><img src="media/borrar2.png" width="22" height="24"><span class="Estilo2">Cantidad Maxima de ticket a
          Eliminar </span></td>
      <td><span class="Estilo1a" style="font-size:14px"><?php echo $cmaxelim; ?> Ticket(s)</span></td>
    </tr>
    <tr>
      <td colspan="2" align="center">&nbsp;</td>
    <tr>
      <td colspan="2" align="center"><span class="Estilo2">Tope Maximo de Ventas x Parlay </span></td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      <td align="center"><span class="Estilo1a" style="font-size:14px">Apuesta Maxima de Bsf.</span></td>
    <tr>

      <?
      $result2 = mysqli_query($GLOBALS['link'], "Select * from _tbrestriccionesxparlay  where  IDC='$cns'");

      while ($row = mysqli_fetch_array($result2)) {

        echo '<tr>';
        echo '<td><span class="Estilo1a" style="font-size:14px"> Parlay de ' . $row['Cantidad'] . ' Equipos </span></td>';
        echo '<td><span class="Estilo1a" style="font-size:14px"> ' . $row['MontodeVenta'] . '</span></td>';
        echo '<tr>';
      }

      ?>
  </table>

</div>

<script type="text/javascript">
  Nifty('div#box5', 'big')
</script>