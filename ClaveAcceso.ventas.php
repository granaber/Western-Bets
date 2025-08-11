<?
require('prc_php.php');
require_once 'function_parameters_for_api.php';

$GLOBALS['link'] = Connection::getInstance();
$rndusr = $_COOKIE['rndusr'];

$data = getParamUser($rndusr, $GLOBALS['link']);
$dark = isModeDart($data['IDusu']);

?>

<div id="obj" class="<?= $dark ? 'add-dark' : 'bg-light'  ?>   p-2">
	<h4 class="text-dark mb-3"> Cambio de Clave</h4>
	<table border="0" style="width: auto;">
		<tr>
			<td width=" 177"><span style="color:<?= $dark ? 'white' : 'black'  ?> ; font-size:12px">Nombre del
					Usuario:</span></td>
		</tr>
		<tr>
			<td width="273">
				<h5 id="usuario" lang="" class="text-danger"></h5>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td> <label for="exampleInputPassword1">Clave Actual</label></td>
		</tr>
		<tr>
			<td><input id="clave" name="input" class="form-control" type="password"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td><button onclick="handleChangePw()" type="button" class="btn btn-primary mt-1 mb-2">Continuar</button>
			</td>
			</td>
		</tr>
	</table>

</div>