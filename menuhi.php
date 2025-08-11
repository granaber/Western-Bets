<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$opciones = explode('|', $_REQUEST['opciones']);

?>
<div id="box3" style="background:#666; width:200px">
	<div id="menu8" align="left">
		<ul>
			<!-- CSS Tabs -->
			<li><a id="current" href="file:///C|/Documents and Settings/Angel Granadillo/Desktop/menuHI/Home.html">JUGADAS</a></li>
			<li><a href="javascript:makeRequest('jugadat4hit.php?tj=0');">Ganadores/Place/Show</a></li>

			<li><a href="javascript:makeRequest('jugadat2hi.php?tj=1');">Exacta</a></li>
			<li><a href="javascript:makeRequest('jugadat2hi.php?tj=2');">Trifecta</a></li>
			<li><a href="javascript:makeRequest('jugadat2hi.php?tj=3');">SuperFecta</a></li>
			<li><a href="javascript:makeRequest('jugadat2hi.php?tj=4');">Pick Four</a></li>
			<li><a href="javascript:makeRequest('jugadat2hi.php?tj=5');">Pick Tree</a></li>
			<li><a href="javascript:makeRequest('jugadat2hi.php?tj=6');">Daily Double</a></li>
			<li><a id="current" href="file:///C|/Documents and Settings/Angel Granadillo/Desktop/menuHI/Home.html">DATOS</a></li>

			<?
			$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tmenu where  SUBMODULO='DATOS'");

			while ($row = mysqli_fetch_array($result)) {
				$key = array_search($row['variable'], $opciones);

				if (($key === false)) :
					echo '<li>';
					echo '<a href="' . $row['Modulocomando'] . '">';
					echo $row['Descripcion'] . '</a></li>';
				endif;
			}

			?>
			<!--<li><a href="javascript:makeRequest('agregarjuego-1-1hi.php');">Configuracion de Juegos</a></li>
<li><a href="javascript:makeRequest('jornadahi.php');">Configuracion de Jornada</a></li>
<li><a href="javascript:makeRequest('cngdeejmplareshi.php');">Configuracion de Ejemplares</a></li>
<li><a href="javascript:makeRequest('hipodromo-1-1hi.php');">Configuracion de Hipodromos</a></li>
<li><a href="javascript:makeRequest('dividendosHI-2.php');">Dividendos y Llegadas</a></li>
<li><a href="javascript:makeRequest('cierresphhi.php');">Cierre de Carrera</a></li>
<li><a href="javascript:makeRequest('menudeacceso.php');">Grupos/Concesionarios/Usuarios/</a></li>-->
			<li><a id="current" href="file:///C|/Documents and Settings/Angel Granadillo/Desktop/menuHI/Home.html">REPORTES</a></li>

			<?
			$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tmenu where  SUBMODULO='REPORTES'");

			while ($row = mysqli_fetch_array($result)) {
				$key = array_search($row['variable'], $opciones);

				if (($key === false)) :
					echo '<li>';
					echo '<a href="' . $row['Modulocomando'] . '">';
					echo $row['Descripcion'] . '</a></li>';
				endif;
			}

			?>
			<!--<li><a href="javascript:makeRequestSC('ver_jugadahi.php');">Ver Jugada</a></li>
<li><a href="javascript:makeRequestSC('reportedeventaspremios.php');">Reporte de Ventas/Premio General</a></li>
<li><a href="javascript:makeRequestSC('reportedeventashipodromo-1');">Reporte General por Hipodromo</a></li>
<li><a href="javascript:makeRequestSC('reportedeventasporconcesionario-1');">Reporte General por Concesionario</a></li>
<li><a href="javascript:makeRequestSC('reportesemanal-1');">Reporte Semanal</a></li>-->
		</ul>
	</div>
</div>

<script>
	Nifty("div#box3", "big");
</script>