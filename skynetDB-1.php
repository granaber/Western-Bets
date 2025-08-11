<?
require('prc_php.php');
require_once('prc_skynet.php');
require_once('codebase/php/grid_connector.php');
global $server1;
global $user1;
global $clv1;
global $db1;

$liga = $_REQUEST['liga'];
$fechab = date("Y-m-d");
$ids = 0;


$GLOBALS['link'] = Skynet::getInstance();

$result = mysqli_query($GLOBALS['link'], "Select * From _tbjornadaDB  where fechaDB='$fechab'");
if (mysqli_num_rows($result) != 0) :
	$row = mysqli_fetch_array($result);
	$ids = $row['ids'];
endif;

if ($ids != 0) :
	$aApu = array();
	$pErio = array();
	$GLOBALS['link'] = Connection::getInstance();
	$resultN2 = mysqli_query($GLOBALS['link'], "Select * From  _DBligas  where Liga=" . $liga);
	$rowN2 = mysqli_fetch_array($resultN2);
	$resultN2 = mysqli_query($GLOBALS['link'], "SELECT _tbjuegodd.Descripcion , _DBLogros . * FROM _tbjuegodd, _DBLogros WHERE _tbjuegodd.IDDD = _DBLogros.IDDD and _tbjuegodd.Grupo=" . $rowN2['Grupo']);
	$i = 1;
	while ($rowN3 = mysqli_fetch_array($resultN2)) {
		$descrip[] = 'A' . $i;
		$aApu[] = $rowN3['DBLogros'];
		$pErio[] = $rowN3['periodo'];
		$i++;
	}

	//$apuestas='AGanar,AB,Runline,AGanar1M,AB1M,Runline1M,AGanar2M,AB2M,Runline2M';
	$apuestas = implode(',', $descrip);
	//$posApues=array('away_money|home_money','over_price|under_price|total','away_spread|away_price|home_spread|home_price');
	//$aApu=explode(',',$apuestas);


	//echo "Select * from _tbequiposDB where ids=$ids and liga=$liga and  equipo1!=''";


	$res = mysqli_connect($server1, $user1, $clv1);
	mysql_select_db($db1);

	$grid = new GridConnector($res);

	$grid->event->attach("beforeRender", "formatting");

	$grid->render_sql("Select * from _tbequiposDB where ids=$ids and liga=$liga and  equipo1!='' ", "id", "id,hora,equipo1,equipo2,picher1,picher2," . $apuestas);


endif;

function formatting($row)
{
	global $aApu;
	global $pErio;
	global $descrip;

	$id = $row->get_value("id");

	$GLOBALS['link'] = Skynet::getInstance();

	for ($i = 0; $i <= count($aApu) - 1; $i++) {
		$result2 = mysqli_query($GLOBALS['link'], "Select * From _tbLogrosDB  where id=$id and periodo=" . $pErio[$i] . " order by serial ASC");
		echo ("Select * From _tbLogrosDB  where id=$id and periodo=" . $pErio[$i] . " order by serial ASC");
		$row2 = mysqli_fetch_array($result2);

		$datos = array();
		$campos = explode('|', $aApu[$i]);

		print_r($campos);


		for ($j = 0; $j <= count($campos) - 1; $j++)
			$datos[] = $row2[$campos[$j]];

		$row->set_value($descrip[$i], implode('/', $datos));

		if (mysqli_num_rows($result2) > 1) :
			$row->set_cell_style($descrip[$i], "background:#900; color:#FFF; font:bold");
		endif;
	}
}
		
	/*	$result = mysqli_query($GLOBALS['link'],"Select * From _tbLogrosDB  where id=$id order by periodo,serial");
		while($row1 = mysqli_fetch_array($result)){ 
		    
		    if ( $primerPeriodo!=$row1['periodo'] ):
				$primerPeriodo=$row1['periodo'];
				$nuevo=true;
			endif;
			if ($nuevo):
				$nuevo=false;
				$result2 = mysqli_query($GLOBALS['link'],"Select * From _tbLogrosDB  where id=$id and periodo=".$primerPeriodo." order by serial ASC");
				$row2 = mysqli_fetch_array($result2);
				
				for ($nivel=0;$nivel<=2;$nivel++){
						$datos=array();
						$campos=explode('|',$posApues[$nivel]); 
						for ($j=0;$j<=count($campos)-1;$j++)
						$datos[]=$row2[ $campos[$j] ];
						
						$row->set_value($aApu[$fila],implode('/',$datos));
						
						if (mysqli_num_rows($result2)>1):
							$row->set_cell_style($aApu[$fila], "background:#900; color:#FFF; font:bold");
						endif;
						
						if ($fila<=count($aApu)-1): $fila++; else: break; endif;
					
				}
				
			endif;			
						
	
			
			
		}*/
