<?php
require('prc_php.php');
require_once 'function_parameters_for_api.php';

$GLOBALS['link'] = Connection::getInstance();
$rndusr = $_COOKIE['rndusr'];

$data = getParamUser($rndusr, $GLOBALS['link']);
$dark = isModeDart($data['IDusu']);
$fechaInitial = date('d/n/Y');
?>

<section>
  <h4 class="<?= $dark ? 'text-white' : 'text-dark' ?> mb-3 text-center">Contable</h4>
  <section style="position: relative;">
    <div id="Calen1" style="position:absolute; left:10%"></div>
    <div id="Calen2" style="position:absolute; left:10%"></div>

  </section>
  <div class="form-group">
    <label class="<?= $dark ? 'text-white' : 'text-dark' ?>">Desde</label>
    <div class="input-group mb-3">
      <input id='date-fmr-desde-contable' value="<?= $fechaInitial ?>" type="text" class="form-control"
        placeholder="Fecha Desde" aria-label="Recipient's username" aria-describedby="button-addon2" disabled>
      <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="button" style="padding: 0px;"
          onclick=" datepickerVentas('Calen1','date-fmr-desde-contable')"> <img
            src="./media/logo_calendar.png" alt="calendario" style="width: 50%;">
        </button>
      </div>
    </div>
  </div>
  <div class="form-group">
    <label class="<?= $dark ? 'text-white' : 'text-dark' ?>">Hasta</label>
    <div class="input-group mb-3">
      <input id='date-fmr-hasta-contable' value="<?= $fechaInitial ?>" type="text" class="form-control"
        placeholder="Fecha Hasta" aria-label="Recipient's username" aria-describedby="button-addon2" disabled>
      <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="button" style="padding: 0px;"
          onclick=" datepickerVentas2('Calen2','date-fmr-hasta-contable')"> <img
            src="./media/logo_calendar.png" alt="calendario" style="width: 50%;">
        </button>
      </div>
    </div>
  </div>
  <div class="form-group text-center" style="width: 100%;">

    <button type="button" class="btn btn-warning" onclick="imprimi_reporte_ventas();">Mostrar Reporte</button>
  </div>
</section>
<div class="frm-report-contable"></div>
<div id="section2"></div>