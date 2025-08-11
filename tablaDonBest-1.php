<?
require('prc_php.php');
require_once('codebase/php/grid_connector.php');
global $server;
global $user;
global $clv;
global $db;


$res = mysqli_connect($server, $user, $clv);
mysqli_select_db($res, $db);

$grid = new GridConnector($res);

//	$grid->event->attach("beforeRender","formatting");

$grid->render_sql("Select * from _DBconver ORDER BY idc ASC ", "idc", "idc,BaseM,BaseH,A20M,A20H,A30M,A30H,A40M,A40H,AMacho,BHembra,ApreMedM,ApreMedH,ApreUnM,ApreUnH,ApreUnMedM,ApreUnMedH,MoneyLM,MoneyLH,Logro5inM,Logro5inH");




function formatting($row)
{
	global $aApu;
	global $pErio;
	global $descrip;

	$id = $row->get_value("id");

	$GLOBALS['link'] = Skynet::getInstance();

	for ($i = 0; $i <= count($aApu) - 1; $i++) {
		$result2 = mysqli_query($GLOBALS['link'], "Select * From _tbLogrosDB  where id=$id and periodo=" . $pErio[$i] . " order by serial DESC");
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
