<?
require_once('codebase/php/grid_connector.php');
require_once('prc_php.php');
global $server;
global $user;
global $clv;
global $db;

$Grupo = $_REQUEST['Grupo'];
$IDC = $_REQUEST['IDC'];
$IDG = $_REQUEST['IDG'];


$GLOBALS['link'] = Connection::getInstance();
$lista = '';
$i = 1;
$result2 = mysqli_query($GLOBALS['link'], "SELECT *  FROM _tbjuegodd  where Grupo=$Grupo  ORDER BY Formato, IDDD");
while ($row = mysqli_fetch_array($result2)) {
	$lista .= $i . ',';
	$i++;
}

$noCombinar[0] = false;
if ($IDC == '0' && $IDG == 0) :
	$noCombinar[0] = false;
else :
	$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbreglas_1  Where IDC='$IDC' and IDG=0 and IDDD in (SELECT IDDD  FROM _tbjuegodd  where Grupo=$Grupo )");
	//	echo ("SELECT * FROM _tbreglas_1  Where IDC='$IDC' and IDG=0 and IDDD in (SELECT IDDD  FROM _tbjuegodd  where Grupo=$Grupo )");
	$hay = false;
	if (mysqli_num_rows($result) != 0) :

		while ($row = mysqli_fetch_array($result))
			if ($row['noCombinar'] != '') :
				$hay = true;
				$noCombinar[0] = true;
				$noCombinar[$row['IDDD']] = $row['noCombinar'];
			endif;
	endif;
	if (!$hay) :
		$result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tbreglas_1  Where IDC='0' and IDG=$IDG and IDDD in (SELECT IDDD  FROM _tbjuegodd  where Grupo=$Grupo )");
		//echo ("SELECT * FROM _tbreglas_1  Where IDC='0' and IDG=$IDG and IDDD in (SELECT IDDD  FROM _tbjuegodd  where Grupo=$Grupo )");
		if (mysqli_num_rows($result) != 0) :

			while ($row = mysqli_fetch_array($result))
				if ($row['noCombinar'] != '') :
					$noCombinar[0] = true;
					$noCombinar[$row['IDDD']] = $row['noCombinar'];
				endif;
		endif;
	endif;


endif;
print_r($noCombinar);
echo "SELECT _tbjuegodd.* , _formatosbb.Descripcion as posicion FROM _tbjuegodd , _formatosbb WHERE _tbjuegodd.grupo =$Grupo AND _tbjuegodd.Formato = _formatosbb.Formato Order By Formato,IDDD ASC";

$res = mysqli_connect($server, $user, $clv);
mysqli_select_db($res, $db);

$grid = new GridConnector($res);
$grid->event->attach("beforeRender", "formatting");

$grid->render_sql("SELECT _tbjuegodd.* , _formatosbb.Descripcion as posicion FROM _tbjuegodd , _formatosbb WHERE _tbjuegodd.grupo =$Grupo AND _tbjuegodd.Formato = _formatosbb.Formato Order By Formato,IDDD ASC", "IDDD", "IDDD,Descripcion,posicion," . $lista . 'noCombinar');
//else:
//	$grid->render_sql("SELECT tbukn.* FROM tbukn,_tconsecionario where tbukn.Asociado=_tconsecionario.IDC and  _tconsecionario.IDG =$IDG and  $formato ","IDusu" ,"Usuario,Nombre,Asociado,Estatus");
//endif;
/*function my_update($data){
             $Estatus=$data->get_value("Estatus");
             $IDusu=$data->get_value("IDusu");
             $conn->sql->query("Update tbukn set Estatus={$Estatus} where IDusu={$id}");
             $data->success(); //if you have made custom update - mark operation as finished
			 
			 case 1: $campo='Usuario';break;
		case 2: $campo='Administrador';break;
		case 3: $campo='Vendedor';break;
		case 4: $campo='Info';break;
		case 5: $campo='Sistema';break;
      }*/

function formatting($row)
{
	global $noCombinar;

	if (trim($row->get_value("noCombinar")) != '') :
		if ($noCombinar[0]) :
			$noCombinarT = explode('|', $noCombinar[$row->get_value("IDDD")]);
			for ($i = 0; $i <= count($noCombinarT) - 1; $i++)
				$row->set_value(strval($noCombinarT[$i]), 1);

			$row->set_value('noCombinar', $noCombinar[$row->get_value("IDDD")]);
		else :
			$noCombinarT = explode('|', $row->get_value("noCombinar"));
			for ($i = 0; $i <= count($noCombinarT) - 1; $i++)
				$row->set_value(strval($noCombinarT[$i]), 1);
		endif;
	else :
		if ($noCombinar[0]) :
			$noCombinarT = explode('|', $noCombinar[$row->get_value("IDDD")]);
			for ($i = 0; $i <= count($noCombinarT) - 1; $i++)
				$row->set_value(strval($noCombinarT[$i]), 1);

			$row->set_value('noCombinar', $noCombinar[$row->get_value("IDDD")]);
		endif;
	endif;
}
