<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$usuario = $_REQUEST['usu'];
?>

<div id="obj">
  <table border="0" style="width:auto">
    <tr>
      <td width="177"><span style="color:#000; font-size:12px">Nombre del Usuario:</span></td>
    </tr>
    <tr>
      <td width="273">
        <h5 id="usuario" lang="<? echo $usuario; ?>" class="text-danger"><?= $usuario ?></h5>
      </td>

    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>
        <label for="exampleInputPassword1">Nueva Clave</label>
      </td>
    </tr>
    <tr>
      <td>
        <input id="nwclave" name="input" class="form-control" type="password">
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>
        <label for="exampleInputPassword1">Repita la Clave</label>
      </td>

    </tr>
    <tr>
      <td>
        <input id="re_nwclave" name="input" class="form-control" type="password">
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><button onclick="ClaveNuevaVentas();" type="button" class="btn btn-primary mt-1 mb-2">Cambiar
          Clave</button>
      </td>
      </td>
    </tr>
  </table>

</div>