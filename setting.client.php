<?
include_once 'prc_php.php';
require_once 'function_parameters_for_api.php';

$GLOBALS['link'] = Connection::getInstance();

$rndusr = $_COOKIE['rndusr'];

$data = getParamUser($rndusr, $GLOBALS['link']);
$idusu = $data['IDusu'];

$q = mysqli_query($GLOBALS['link'], "SELECT * FROM _tusu_ext  Where IDusu=$idusu");

$isdecimalparlay = false;

if (mysqli_num_rows($q) != 0) {

    $r = mysqli_fetch_array($q);

    $isdecimalparlay = $r['isdecimalparlay'] == 1;
}

?>
<div class="card  text-white bg-dark border-info m-3">
    <h5 class="card-header">Parlay</h5>
    <div class="card-body">
        <div class="custom-control custom-switch" style="padding-left: 3.25rem;">
            <input type="checkbox" class="custom-control-input" id="systemdecimal" onclick="handleIsDecimalParlay()"
                <?= $isdecimalparlay ? 'checked' : '' ?>>
            <label class="custom-control-label text-white " for="systemdecimal">Sistema Decimal</label>
        </div>
    </div>
</div>