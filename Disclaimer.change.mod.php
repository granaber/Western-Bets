<?
require('prc_php.php');
require_once 'function_parameters_for_api.php';

$GLOBALS['link'] = Connection::getInstance();
$rndusr = $_COOKIE['rndusr'];

$data = getParamUser($rndusr, $GLOBALS['link']);
$dark = isModeDart($data['IDusu']);

?>

<div id="obj" class="<?= $dark ? 'bg-light' : 'add-dark'  ?>   p-2">
	<h4 class="text-dark mb-3"> Cambio de Modo</h4>
	<table border="0" style="width: auto;">
		<tr>
			<td>
				<div style="line-height: 1.45rem;margin-bottom: 25px;">
					Realizaremos el cambio de modo a todo el sistema, refrescaremos, para que usted pueda acceder al
					sistema otra vez con el nuevo entorno seleccionado.
				</div>
			</td>
		</tr>
		<tr>
			<td><button onclick="onexitclient()" type="button" class="btn btn-primary mt-1 mb-2">Continuar</button>
			</td>
			</td>
		</tr>
	</table>

</div>