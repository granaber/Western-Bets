<?
 $lis=explode(',',$_REQUEST['vlr']);
 $xml1 = new DOMDocument();
 $rows = $xml1->createElement( "rows" );


 // http://www.therx.com/lines/books.php?host=TheRX
 // http://www.sportsmemo.com/live_odds/books.php?host=SPORTSMEMO
 // http://www.sportsmemo.com/spt-opt/books.php?host=SPORTSMEMO
 $xml = simplexml_load_file('https://www.sportsmemo.com/free-odds/books.php?host=SPORTSMEMO');
		$s = simplexml_import_dom($xml);
		$si=$s->BOOK;

		$row = $xml1->createElement( "row");
		$row->setAttribute("id",  0 );
		if (array_search(0,$lis)!==false) $valor="1"; else $valor="0";
		$cell =  $xml1->createElement( "cell", $valor );
		$cell1 = $xml1->createElement( "cell", 'Todos' );
		$row->appendChild( $cell );$row->appendChild( $cell1 );
		$rows->appendChild( $row );
		for ($i=0;;$i++){
		  if (isset($si[$i])):
			$row = $xml1->createElement( "row");
			$row->setAttribute("id",  $si[$i]['id'] );
			if (array_search($si[$i]['id'],$lis)!==false) $valor="1"; else $valor="0";
			$cell =  $xml1->createElement( "cell", $valor );
			$cell1 = $xml1->createElement( "cell", $si[$i]['name'] );
			$row->appendChild( $cell );$row->appendChild( $cell1 );
			$rows->appendChild( $row );
		   else:
		    break;
		  endif;

		}

		$xml1->appendChild( $rows );
	 	$out = $xml1->save('liscas.xml');

?>
