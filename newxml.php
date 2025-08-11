<?
// ********** Creacion de archivo XML ************
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$file = $_REQUEST['file'];
$sql = $_REQUEST['sql'];
$campos = explode('|', $_REQUEST['campos']);



$doc = new DOMDocument('1.0', 'UTF-8');

$element  = $doc->appendChild(new DOMElement('rows'));

$i = 1;
$resultj = mysqli_query($GLOBALS['link'], $sql);
while ($Row = mysqli_fetch_array($resultj)) {
	$element1  = $element->appendChild(new DOMElement('row'));
	$element1->setAttribute("id", $Row[$campos[0]]);
	for ($j = 0; $j <= count($campos) - 1; $j++) {
		$element_ns = new DOMElement('cell', $Row[$campos[$j]], '');
		$element1->appendChild($element_ns);
	}
	$i++;
}
$doc->save($file);
	
/*Saludos Amigos... 

Me Costo un mundo poder ver como trabaja DOM XML de PHP de 5 en adelante ... 
1.- Las librerias en las versiones PHP de 5 en adelante esta complidas es decir ya no  es una extension..
2.- Por Otra parte el codigo que voy a facilitar va enviar lo siguiente a una archivo
  <?xml version="1.0" encoding="UTF-8"?>
<rows>
   <row id="1">
            <cell>Grupo No.1</cell>
           <cell>GRUPO UNO</cell>
   </row>
   <row id="2">
            <cell>Grupo No.2</cell>
            <cell>MARCOS</cell>
   </row>
   <row id="3">
            <cell>Grupo No.3</cell>
            <cell>POPEYE</cell>
    </row>
</rows>
PUEDEN NOTAR QUE EL XML va dentro de otras etiquetas es decir ROWS (Indice Principal) ROW (los Sudindices) y CELL (las Celdas)... De la misma Manera vamos a tratar el codigo en PHP.... y aqui va el codigo...

        $doc = new DOMDocument ( '1.0', 'UTF-8' );   /// Abrimos el DOMXML Documento	
	
	$element  = $doc->appendChild(new DOMElement('rows'));  // Creamos el Indice Principal ROWS

	$i=1;
	$resultj = mysqli_query($GLOBALS['link'],"SELECT * FROM _tgrupo order by IDG"); // Una Simple Intruccion SQL para mostrar un el ejemplo
	while($Row = mysqli_fetch_array($resultj)) 
	{
	    	        
        // Esto es muy Importante Fijense Bien $element fue la misma variable para llamar la Instruccion en el INDICE ROWS en otras palabras estamos indicando que este nuevo elemento pertenece al INDICE ROWS..

                       $element1  = $element->appendChild(new DOMElement('row'));	
		 	$element1->setAttribute("id", $i);  /// Para asiganar el atributo ID

    // Aqui pasa lo mismo si ven los apuntadores ahora llaman a $element1 para que ellos pertenezcan al SUBINDICE ROW, en este caso ahora a dos etiquetas llamadas CELL

			$element_ns = new DOMElement('cell', 'Grupo No.'.$Row['IDG'], '');
			$element1->appendChild($element_ns);
			$element_ns = new DOMElement('cell', $Row['Descrip'], '');
			$element1->appendChild($element_ns);

			$i++;
		
		}
	$doc->save("grid.xml");  /// <== Aqui lo grabamos a un archivo .XML


Si tiene alguna duda escriban a mi correo.. creo que la explicacion de este articulo esta bien pero es hacer las cosas casi a mano.. y no es la idea PHP es muy poderoso para hacer un archivo tan escueto...

mi correo:angelgranadillo@yahoo.com

Espero que le sirva de mucho*/
