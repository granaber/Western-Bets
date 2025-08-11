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
  <h4 class="<?= $dark ? 'text-white' : 'text-dark' ?> mb-3 text-center">Resultados</h4>
  <section style="position: relative;">
    <div id="Calen1" style="position:absolute; left:10%"></div>
  </section>
  <div class="form-group">
    <label class="<?= $dark ? 'text-white' : 'text-dark' ?>">Fecha</label>
    <div class="input-group mb-3">
      <input id='date-fmr-fecha-result' value="<?= $fechaInitial ?>" type="text" class="form-control"
        placeholder="Fecha" aria-label="Recipient's username" aria-describedby="button-addon2" disabled>
      <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="button" style="padding: 0px;"
          onclick=" datepickerVentas('Calen1','date-fmr-fecha-result')"> <img src="./media/logo_calendar.png"
            alt="calendario" style="width: 50%;">
        </button>
      </div>
    </div>
  </div>

  <div class="form-group text-center" style="width: 100%;">

    <button type="button" class="btn btn-primary" onclick="handleReportResutlGame()">Mostrar Reporte</button>
  </div>
</section>