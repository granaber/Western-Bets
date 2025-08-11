<?
// ********** Creacion de archivo XML ************
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$file = $_REQUEST['file'];
$sql1 = $_REQUEST['sql1'];
$sql2 = $_REQUEST['sql2'];
$Clave = $_REQUEST['Clave'];
$campos = explode('|', $_REQUEST['campos']);

$doc = new DOMDocument('1.0', 'UTF-8');

$element  = $doc->appendChild(new DOMElement('tree'));
$element->setAttribute("id", "0");

$element2  = $element->appendChild(new DOMElement('item'));
$element2->setAttribute("text", $_REQUEST['principal']);
$element2->setAttribute("id", $_REQUEST['principal']);
$element2->setAttribute("open", "1");


$i = 1;
$resultj = mysqli_query($GLOBALS['link'], $sql1);
while ($Row = mysqli_fetch_array($resultj)) {
	$resultjdf = mysqli_query($GLOBALS['link'], $sql2 . $Row[$Clave]);

	if (mysqli_num_rows($resultjdf) == 0) :
		$element1  = $element2->appendChild(new DOMElement('item'));
		$element1->setAttribute("text", $Row[$campos[0]]);
		$element1->setAttribute("id", $_REQUEST['Indice'] . '-' . $Row[$campos[1]]);
	endif;
	/* for ($j=0;$j<=count($campos)-1;$j++)
		    {
		     $DATA=explode('!',	$campos[$j]);
			 
			 if (count($DATA)==2):
			   if ($DATA[0]=='DATA'):
                $elementns = $doc->createElement('cell');
                $elementns->appendChild($doc->createCDATASection('<img src="images/logo/'.$Row[$DATA[1]].'" />'));
                $element1->appendChild($elementns);
			   endif;
			   if ($DATA[0]=='SEL'):
                 $element_ns = new DOMElement('cell',$DATA[1], '');
				 $element1->appendChild($element_ns);
			   endif;
				
			 else:
			    	$element_ns = new DOMElement('cell',$Row[$campos[$j]], '');
					$element1->appendChild($element_ns);
			 endif;
			 
		    }*/
	$i++;
}
$doc->save($file);
