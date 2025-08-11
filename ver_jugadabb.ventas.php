<?
include_once('./prc_php.php');
require_once 'function_parameters_for_api.php';

$GLOBALS['link'] = Connection::getInstance();

// $content = trim(file_get_contents("php://input"));
// $decoded = json_decode($content, true);

$fechaInitial = $_REQUEST['fecha'] ?? date('d/n/Y');


$rndusr = $_COOKIE['rndusr'];

$data = getParamUser($rndusr, $GLOBALS['link']);
$dark = isModeDart($data['IDusu']);

?>
<h4 class="<?= $dark ? 'text-white' : 'text-dark' ?>  mb-3 text-center">Ver Tickets</h4>

<section style="position: relative;">
    <div id="Calen1" style="position:absolute; left:10%"></div>
</section>

<div class="input-group mb-3">
    <input id='date-fmr-ver-jugada' value="<?= $fechaInitial ?>" type="text" class="form-control"
        placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2" disabled>
    <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="button" style="padding: 0px;"
            onclick=" datepickerVentas('Calen1','date-fmr-ver-jugada',getListTicket)"> <img
                src="./media/logo_calendar.png" alt="calendario" style="width: 50%;">
        </button>
    </div>
</div>

<div class="mb-2">
    <ul id="myTabVerJugada" class="nav nav-tabs <?= $dark ? 'dark' : '' ?>   justify-content-center"
        style="font-size: 11px;">

        <li class=" nav-item">
            <a class="nav-link <?= $dark ? 'dark' : '' ?>  active" href="#" data-context='parlay-verjugada'>Parlay</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $dark ? 'dark' : '' ?> " href="#" data-context='animalito-verjugada'>Animalitos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $dark ? 'dark' : '' ?> " href="#" data-context='americana-verjugada'>Americana</a>
        </li>
    </ul>
</div>
<div id='main-tab-verjugada' class="tab-content" style="padding: 0px;">
    <div class="tab-pane show active" id="tab-parlay-verjugada" role="tabpanel" aria-labelledby="home-tab">


        <section class="frm-table-list-ticket">
            <? require './ver_jugadabb-1.ventas.php' ?>
        </section>


    </div>
    <div class="tab-pane" id="tab-animalito-verjugada" role="tabpanel" aria-labelledby="profile-tab">
        <section class="frm-table-list-ticket-animalitos">
            <? require './animalitos/ver_jugadabb-1.ventas.php' ?>
        </section>

    </div>

    <div class="tab-pane" id="tab-americana-verjugada" role="tabpanel" aria-labelledby="profile-tab">
        <section class="frm-table-list-ticket-americana">
            <? require './americanas/ver_jugadadaa-1.php' ?>

        </section>

    </div>


</div>