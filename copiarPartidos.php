<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Documento sin título</title>
</head>

<script type="text/javascript" src="prototype.js"></script>

<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();


?>

<body>
	Indique la Pagina:<select id="IDPagina">
		<?
		$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbpaginas Order by IDPaginas ");
		while ($row = mysqli_fetch_array($resultj)) {

			echo "<option  value=" . $row["IDPaginas"] . " >" . $row["Nombre"] . "</option>";
		}
		?>
	</select>

	<br />

	Indique Deporte:<select id="Grupo">
		<?
		$resultj = mysqli_query($GLOBALS['link'], "SELECT * FROM _gruposdd where  Estatus=1 Order by grupo ");
		while ($row = mysqli_fetch_array($resultj)) {

			echo "<option  value=" . $row["Grupo"] . " >" . $row["Descripcion"] . "</option>";
		}
		?>
	</select>
	<textarea cols="50" rows="5" id="texto"></textarea>
	<input type="submit" name="button" id="button" value="Enviar" onclick="procesar()" />
</body>

</html>
<script>
	function procesar() {
		var valor = $('texto').value;
		var proceso = valor.split(" ");

		new Ajax.Request('copiarPartidos-2.php', {
			parameters: {
				proceso: $('texto').value,
				Grupo: $('Grupo').value,
				IDPagina: $('IDPagina').value
			},
			method: 'get',
			onComplete: function(transport) {
				var response = transport.responseText;
				alert(response);
			},

			onFailure: function() {
				alert('No tengo respuesta Comuniquese con el Administrador!');
			}
		});


	}
</script>