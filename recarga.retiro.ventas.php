<?
include_once('./prc_php.php');
require_once 'prc_credit.php';
require_once 'function_parameters_for_api.php';

$GLOBALS['link'] = Connection::getInstance();

$rndusr = $_COOKIE['rndusr'];

$data = getParamUser($rndusr, $GLOBALS['link']);
$dark = isModeDart($data['IDusu']);

$saldo = 0;
$diferido = 0;
$listBank = [];
$TDC = 2;
$methoPay = getListformatpay(); // ['Zelle', 'Binance', 'Pago Movil', 'Transferencia Bancaria'];
if ($data['IDC'] != -1) {
    $resp = BackendCredito($data['IDC'], 0, 0, $TYPE_SALDO);
    if (!$resp['err']) {
        $saldo = $resp['moneda'] . $resp['saldo'];
    }
    $listBank = getlistBank();
}
$monto_tdc = [10, 20, 50, 100];
?>

<div class="pb-2 fmr-body-rr">
    <h4 class="text-dark mb-3 text-center">Retiros/Recargas</h4>
    <p class="text-center">
        <button id="btn-recarga" class="btn btn-primary" type="button" onclick="handleSwicthRecagaRetiro(RECARGA)">
            Recargar
        </button>
        <button id="btn-retiro" class="btn btn-danger" type="button" onclick="handleSwicthRecagaRetiro(RETIRO)">
            Retirar
        </button>
    </p>
    <div class="collapse" id="fmr-recarga">
        <form id="form-pay">
            <div class="card  bg-primary mb-3 mt-2 p-2">
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-10 col-form-label text-light">Saldo Disponible</label>
                    <div class="col-sm-10">
                        <h4 class="text-light"><?= $saldo ?></h4>
                    </div>
                    <label for="inputEmail3" class="col-sm-10 col-form-label text-light">Saldo Diferido</label>
                    <div class="col-sm-10">
                        <h4 class="text-light"><?= $diferido ?></h4>
                    </div>
                </div>
            </div>
            <div class="form-group row text-center">
                <label for="fmr-method-pay" class="col-form-label " style="width: 100%;">Metodos de Pago</label>
                <div class="m-auto">
                    <select id="fmr-method-pay" name="formatpay" class="fmr-method-pay form-control col-sm-20">
                        <?
                        foreach ($methoPay as $clave => $valor) {
                            // if ($clave === $TDC) continue;
                            echo '<option value=' . ($clave) . ' ' . ($clave == 3 ? 'selected' : '') . '>' . $valor . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div id="monto_normal" class="fmr-mont-pay form-group row text-center fmr-metho-for-not-tdc">
                <label for="fmr-monto-pay" class=" col-form-label" style="width: 100%;">Monto</label>
                <div class="m-auto">
                    <input type="number" class="form-control col-sm-20" id="fmr-monto-pay" name="monto">
                </div>
            </div>
            <div id="monto_tdc" class="form-group row text-center fmr-metho-for-is-tdc d-none">
                <label for="fmr-monto-pay-tdc" class=" col-form-label"
                    style="width: 100%; color:<?= $dark ? '#566a7f' : 'black'  ?>">Monto</label>
                <div class="m-auto">
                    <?
                    $check = 'checked';
                    foreach ($monto_tdc as $clave => $value) { ?>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="montTDC" id="selectMont<?= $value ?>"
                                value="<?= $value ?>" <?= $check ?>>
                            <label class="form-check-label" for="selectMont<?= $value ?>"
                                style="color:<?= $dark ? '#566a7f' : 'black'  ?>">
                                $<?= $value ?>
                            </label>
                        </div>

                    <?
                        $check = '';
                    } ?>
                </div>
            </div>
            <div id="button_tdc" class="form-group row text-center fmr-metho-for-is-tdc d-none">
                <div class="col-sm-20" style="margin: auto;">
                    <button type="button" class="btn btn-primary"
                        onclick="setRegistreRRforTDC({id:<?= $data['IDusu'] ?>,teluser:'<?= $data['phone'] ?>'})">Recargar</button>
                </div>
            </div>
            <div class="fmr-bank-div-pay form-group row text-center fmr-metho-for-not-tdc d-none">
                <label for="fmr-bank-pay" style="width: 100%; color:<?= $dark ? '#566a7f' : 'black'  ?>">Banco
                    origen</label>
                <div class="m-auto">
                    <select id="fmr-bank-pay" name="idban" class="form-control col-sm-20">
                        <?
                        foreach ($listBank as $clave => $valor) {
                            echo '<option value=' . $clave . ' ' . ($clave == 0 ? 'selected' : '') . '>' . $valor . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group row text-center fmr-metho-for-not-tdc">
                <label id='fmr-text-ref-pay' for="fmr-ref-pay"
                    style="width: 100%;color:<?= $dark ? '#566a7f' : 'black'  ?>"># Referencia</label>
                <div class="col-sm-20" style="margin: auto;">
                    <input type="text" class="form-control" id="fmr-ref-pay" name="referencia">
                </div>
            </div>
            <div class="form-group row text-center fmr-metho-for-not-tdc">
                <div class="col-sm-20" style="margin: auto;">
                    <button type="button" class="btn btn-warning"
                        onclick="setRegistreRR({mode:<?= $RECARGA ?>,idusutemp:<?= $data['IDusu'] ?>,teluser:'<?= $data['phone'] ?>'})">Registrar
                        Recarga</button>
                </div>
            </div>
            <input type="text" class="form-control d-none" name="passport" value="NA">
            <input class="form-check-input d-none" type="text" name="typemonto" value="NA">


        </form>
    </div>
    <div class="collapse" id="fmr-retiro">
        <form id="form-cashout">
            <div class="card  bg-danger mb-3 mt-2 p-2">
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-10 col-form-label text-light">Saldo Disponible</label>
                    <div class="col-sm-10">
                        <h4 class="text-light"><?= $saldo ?></h4>
                    </div>
                </div>
            </div>
            <div class="card mb-3 mt-2 p-1">
                <div class="form-group row">
                    <label class="fs-5">
                        IMPORTANTE:
                    </label>
                    <p class="fs-6">
                        Notificar vía Whatsapp para que su retiro sea procesado con éxito.
                    </p>
                </div>
            </div>
            <div class="form-group row text-center">
                <label for="fmr-method-ret" class="col-form-label" style="width: 100%;">Forma de Retiro</label>
                <div class="m-auto">
                    <select id='fmr-method-ret' name='formatpay' class="fmr-method-ret form-control col-sm-10">
                        <?
                        foreach ($methoPay as $clave => $valor) {
                            if ($clave === $TDC) continue;
                            echo '<option value=' . ($clave) . ' ' . ($clave == 3 ? 'selected' : '') . '>' . $valor . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group row text-center">
                <label for="fmr-monto-ret" class=" col-form-label" style="width: 100%;">Monto a retirar</label>
                <div class="m-auto text-left">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="typemonto" id="fmr-modosaldo-ret"
                            value="TOTAL"
                            onclick="document.querySelector(' .fmr-monto-div-ret').classList.add('d-none')" checked>
                        <label class="form-check-label" for="fmr-modosaldo-ret"
                            style="color:<?= $dark ? '#566a7f' : 'black'  ?>">
                            Saldo Disponible <?= $saldo ?>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="typemonto" id="fmr-modoother-ret"
                            value="MONTO"
                            onclick="document.querySelector('.fmr-monto-div-ret').classList.remove('d-none')">
                        <label class="form-check-label" for="fmr-modoother-ret"
                            style="color:<?= $dark ? '#566a7f' : 'black'  ?>">
                            Otro Monto
                        </label>
                    </div>
                </div>
                <div class="fmr-monto-div-ret m-auto d-none">
                    <input type="number" class="form-control col-sm-20" id="fmr-monto-ret" name="monto">
                </div>
            </div>

            <div class="form-group row text-center">
                <label id="fmr-text-ref-ret" for="fmr-ref-ret"
                    style="width: 100%; color:<?= $dark ? '#566a7f' : 'black'  ?>">Correo</label>
                <div class="col-sm-20" style="margin: auto;">
                    <input type="text" class="form-control" id="fmr-ref-ret" name="referencia">
                </div>
            </div>
            <div class="fmr-passport-div-ret form-group row text-center  d-none">
                <label id="fmr-text-ref-ret" for="fmr-ref-ret"
                    style="width: 100%; color:<?= $dark ? '#566a7f' : 'black'  ?>">Documento de Identidad</label>
                <div class="col-sm-20" style="margin: auto;">
                    <input type="text" class="form-control" id="fmr-passport-ret" name="passport">
                </div>
            </div>
            <div class="fmr-bank-div-ret form-group row text-center d-none">
                <label for="fmr-bank-ret" style="width: 100%; color:<?= $dark ? '#566a7f' : 'black'  ?>">Banco:</label>
                <div class="m-auto">
                    <select id="fmr-bank-ret" name="idban" class="form-control col-sm-20">
                        <?
                        foreach ($listBank as $clave => $valor) {
                            echo '<option value=' . $clave . ' ' . ($clave == 0 ? 'selected' : '') . '>' . $valor . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-20" style="margin: auto;">
                    <button type="button" class="btn btn-warning"
                        onclick="setRegistreRR({mode:<?= $RETIRO ?>,idusutemp:<?= $data['IDusu'] ?>,teluser:'<?= $data['phone'] ?>'})">Enviar
                        Solicitud</button>
                </div>
            </div>
        </form>
    </div>
</div>