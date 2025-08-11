<?php
$IDT = $_REQUEST['idt'];
$fc = $_REQUEST["fc"];
?>
<div class="frm-escruting">
  <div class="escruting-date">
    <span class="Estilo1" style="font-size:14px"> Fecha: <input autocomplete="off" class="input-pv-standard"
        data-idt="<?= $IDT ?>" style="height: 30px;width: 85px;" name=" fc" type="text" id="fc" lang=""
        value="<?php echo $fc; ?>" size="10" xml:lang="" /></span>
    <button class="button-pv-standard" onclick=" jsonvalores_esc()">Buscar</button>
  </div>
  <div id="boxescrute" class="escruting-main">

    <?php include('escrute-2.php'); ?>


  </div>
</div>
<script>
  cargarcampos_e();
</script>