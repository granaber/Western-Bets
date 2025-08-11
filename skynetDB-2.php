<?
require('prc_php.php');
require('prc_skynet.php');
$GLOBALS['link'] = Skynet::getInstance();

$fechab = date("Y-m-d");

$result = mysqli_query($GLOBALS['link'], "Select * From _tbjornadaDB  where fechaDB='$fechab'");
if (mysqli_num_rows($result) != 0) :
	$row = mysqli_fetch_array($result);
	$ids = $row['ids'];
endif;

?>

<div id="a_tabbar" align="center" style="width:900px; height:500px;" />
<?
$ligar = array();
$descrip = array();
$i = 0;
$result = mysqli_query($GLOBALS['link'], "Select * From _tbligaDB  where  	ids=$ids ORDER BY liga ASC ");
while ($row = mysqli_fetch_array($result)) {
	$lista .= $row['liga'] . ',';
	$ltexto .= $row['name'] . ',';
	$liga[$i] = $row['liga'];

	echo "<div id='tpg_" . $row['liga'] . "'  style='height:400px; width:800px '>";
	echo "</div>";

	$i++;
}


$GLOBALS['link'] = Connection::getInstance();
for ($i = 0; $i <= count($liga) - 1; $i++) {
	$descrip[$i] = '0';
	$resultN2 = mysqli_query($GLOBALS['link'], "Select * From  _DBligas  where Liga=" . $liga[$i]);
	if (mysqli_num_rows($resultN2) != 0) :
		$rowN2 = mysqli_fetch_array($resultN2);
		$resultN2 = mysqli_query($GLOBALS['link'], "SELECT _tbjuegodd.Descripcion , _DBLogros . * FROM _tbjuegodd, _DBLogros WHERE _tbjuegodd.IDDD = _DBLogros.IDDD and _tbjuegodd.Grupo=" . $rowN2['Grupo']);
		while ($rowN3 = mysqli_fetch_array($resultN2)) {
			if ($descrip[$i] == '0') :  $descrip[$i] = '';
			endif;
			$descrip[$i] .= $rowN3['Descripcion'] . ',';
		}
	endif;
}

// Emcabezados 



?>

</div>
<script>
	var deportes = '<? echo implode(',', $liga); ?>';
	var emcabedepor = '<? echo implode('|', $descrip); ?>';


	listaDepor = deportes.split(',');

	listaEmcab = emcabedepor.split('|');

	var lista = '<? echo $lista; ?>';
	var ltexto = '<? echo $ltexto; ?>';


	valoreslista = lista.split(',');
	valoresltexto = ltexto.split(',');


	tabbar1 = new dhtmlXTabBar("a_tabbar", "top");
	tabbar1.setImagePath("codebase/imgs/");
	tabbar1.enableAutoReSize(true);
	for (i = 0; i <= valoreslista.length - 2; i++) {
		tabbar1.addTab("a_" + valoreslista[i], valoresltexto[i], "150px");
		tabbar1.setContent("a_" + valoreslista[i], "tpg_" + valoreslista[i]);
	}

	tabbar1.enableScroll(true);
	tabbar1.setTabActive("a_" + valoreslista[0]);

	validos = new Array()
	l = 0;
	dimCol = "80,80,80,80,80,80,80,80,80,80,80,80,80,80,80";
	for (i = 0; i <= listaDepor.length - 1; i++) {
		if (listaEmcab[i] != '0') {
			//apuestas='AGanar,AB,Runline,AGanar1M,AB1M,Runline1M,AGanar2M,AB2M,Runline2M';
			apuestas = listaEmcab[i];
			validos[l] = listaDepor[i];
			mygridVar[l] = new dhtmlXGridObject("tpg_" + valoreslista[i]);
			mygridVar[l].setImagePath("codebase/imgs/");
			mygridVar[l].setHeader("ID,Hora,EquipoA,EquipoB,PchtA,PchtB," + apuestas);
			mygridVar[l].setInitWidths(dimCol)
			mygridVar[l].setColAlign("right,right,right,right,right,right,right,right,right,right,right,right,right,right,right")
			mygridVar[l].setColTypes("ro,ro,ro,ro,ro,ro,ro,ro,ro,ro,ro,ro,ro,ro,ro,ro,ro");
			mygridVar[l].setSkin("dhx_skyblue");
			mygridVar[l].init();
			mygridVar[l].loadXML("skynetDB-1.php?liga=" + listaDepor[i]);
			l++;
		}
	}

	refresDBest()
</script>