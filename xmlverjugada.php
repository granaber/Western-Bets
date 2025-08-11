<?
// ********** Creacion de archivo XML ************
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$IDJ = $_REQUEST['idj'];
$file1 = $_REQUEST['file1']; /// Documento de Tickets Perdedores
$file2 = $_REQUEST['file2']; /// Documento de Tickets Ganadores	
$file3 = $_REQUEST['file3']; /// Documento de Tickets Posibles Ganadores	

/// Documento de Tickets Perdedores
$doc = new DOMDocument('1.0', 'UTF-8');
$element  = $doc->appendChild(new DOMElement('rows'));
$totalventasTP = 0;
$totalpremiosTP = 0;

/// Documento de Tickets Ganadores	
$docTG = new DOMDocument('1.0', 'UTF-8');
$elementTG  = $docTG->appendChild(new DOMElement('rows'));
$totalventasTG = 0;
$totalpremiosTG = 0;

/// Documento de Tickets Posibles Ganadores	
$docTPG = new DOMDocument('1.0', 'UTF-8');
$elementTPG  = $docTPG->appendChild(new DOMElement('rows'));
$totalventasTPG = 0;
$totalpremiosTPG = 0;


$result_f = mysqli_query($GLOBALS['link'], "SELECT Fecha FROM _jornadabb where IDJ=" . $IDJ);
$Rowf = mysqli_fetch_array($result_f);

$resultj = mysqli_query($GLOBALS['link'], 'SELECT * FROM _tjugadabb where IDJ=' . $IDJ . ' Order by Serial ');
while ($Row = mysqli_fetch_array($resultj)) {


	switch (vescruteBytree($Row['serial'])) {

		case 1:
			$element1  = $element->appendChild(new DOMElement('row'));
			$element1->setAttribute("id", $Row['serial']);
			if ($Row['activo'] == 2) : $serial = -1 * $Row['serial'];
			else : $serial = $Row['serial'];
				$totalventasTP += $Row['ap'];
				$totalpremiosTP += $Row['acobrar'];
			endif;
			$element_ns = new DOMElement('cell', $serial, '');
			$element1->appendChild($element_ns);
			$element_ns = new DOMElement('cell', $Row['IDC'], '');
			$element1->appendChild($element_ns);
			$element_ns = new DOMElement('cell', $Row['hora'], '');
			$element1->appendChild($element_ns);
			$element_ns = new DOMElement('cell', $Rowf['Fecha'], '');
			$element1->appendChild($element_ns);
			$element_ns = new DOMElement('cell', $Row['ap'], '');
			$element1->appendChild($element_ns);
			$element_ns = new DOMElement('cell', $Row['acobrar'], '');
			$element1->appendChild($element_ns);
			$element_ns = new DOMElement('cell', $Row['terminal'], '');
			$element1->appendChild($element_ns);
			$element_ns = new DOMElement('cell', $Row['se'], '');
			$element1->appendChild($element_ns);
			break;
		case 2:
			$element1TPG  = $elementTPG->appendChild(new DOMElement('row'));
			$element1TPG->setAttribute("id", $Row['serial']);
			if ($Row['activo'] == 2) : $serial = -1 * $Row['serial'];
			else : $serial = $Row['serial'];
				$totalventasTPG += $Row['ap'];
				$totalpremiosTPG += $Row['acobrar'];
			endif;
			$element_nsTPG = new DOMElement('cell', $serial, '');
			$element1TPG->appendChild($element_nsTPG);
			$element_nsTPG = new DOMElement('cell', $Row['IDC'], '');
			$element1TPG->appendChild($element_nsTPG);
			$element_nsTPG = new DOMElement('cell', $Row['hora'], '');
			$element1TPG->appendChild($element_nsTPG);
			$element_nsTPG = new DOMElement('cell', $Rowf['Fecha'], '');
			$element1TPG->appendChild($element_nsTPG);
			$element_nsTPG = new DOMElement('cell', $Row['ap'], '');
			$element1TPG->appendChild($element_nsTPG);
			$element_nsTPG = new DOMElement('cell', $Row['acobrar'], '');
			$element1TPG->appendChild($element_nsTPG);
			$element_nsTPG = new DOMElement('cell', $Row['terminal'], '');
			$element1TPG->appendChild($element_nsTPG);
			$element_nsTPG = new DOMElement('cell', $Row['se'], '');
			$element1TPG->appendChild($element_nsTPG);
			break;
		case 3:
			$element1TG  = $elementTG->appendChild(new DOMElement('row'));
			$element1TG->setAttribute("id", $Row['serial']);
			if ($Row['activo'] == 2) : $serial = -1 * $Row['serial'];
			else : $serial = $Row['serial'];
				$totalventasTG += $Row['ap'];
				$totalpremiosTG += $Row['acobrar'];
			endif;
			$element_nsTG = new DOMElement('cell', $serial, '');
			$element1TG->appendChild($element_nsTG);
			$element_nsTG = new DOMElement('cell', $Row['IDC'], '');
			$element1TG->appendChild($element_nsTG);
			$element_nsTG = new DOMElement('cell', $Row['hora'], '');
			$element1TG->appendChild($element_nsTG);
			$element_nsTG = new DOMElement('cell', $Rowf['Fecha'], '');
			$element1TG->appendChild($element_nsTG);
			$element_nsTG = new DOMElement('cell', $Row['ap'], '');
			$element1TG->appendChild($element_nsTG);
			$element_nsTG = new DOMElement('cell', $Row['acobrar'], '');
			$element1TG->appendChild($element_nsTG);
			$element_nsTG = new DOMElement('cell', $Row['terminal'], '');
			$element1TG->appendChild($element_nsTG);
			$element_nsTG = new DOMElement('cell', $Row['se'], '');
			$element1TG->appendChild($element_nsTG);
			break;
	}
}
$element1  = $element->appendChild(new DOMElement('row'));
$element1->setAttribute("id", '');
$element_ns = new DOMElement('cell', '', '');
$element1->appendChild($element_ns);
$element_ns = new DOMElement('cell', '', '');
$element1->appendChild($element_ns);
$element_ns = new DOMElement('cell', '', '');
$element1->appendChild($element_ns);
$element_ns = new DOMElement('cell', 'Totales', '');
$element1->appendChild($element_ns);
$element_ns = new DOMElement('cell', $totalventasTP, '');
$element1->appendChild($element_ns);
$element_ns = new DOMElement('cell', $totalpremiosTP, '');
$element1->appendChild($element_ns);
$element_ns = new DOMElement('cell', '', '');
$element1->appendChild($element_ns);
$element_ns = new DOMElement('cell', '', '');
$element1->appendChild($element_ns);

$element1TPG  = $elementTPG->appendChild(new DOMElement('row'));
$element1TPG->setAttribute("id", '');
$element_nsTPG = new DOMElement('cell', '', '');
$element1TPG->appendChild($element_nsTPG);
$element_nsTPG = new DOMElement('cell', '', '');
$element1TPG->appendChild($element_nsTPG);
$element_nsTPG = new DOMElement('cell', '', '');
$element1TPG->appendChild($element_nsTPG);
$element_nsTPG = new DOMElement('cell', 'Totales', '');
$element1TPG->appendChild($element_nsTPG);
$element_nsTPG = new DOMElement('cell', $totalventasTPG, '');
$element1TPG->appendChild($element_nsTPG);
$element_nsTPG = new DOMElement('cell', $totalpremiosTPG, '');
$element1TPG->appendChild($element_nsTPG);
$element_nsTPG = new DOMElement('cell', '', '');
$element1TPG->appendChild($element_nsTPG);
$element_nsTPG = new DOMElement('cell', '', '');
$element1TPG->appendChild($element_nsTPG);

$element1TG  = $elementTG->appendChild(new DOMElement('row'));
$element1TG->setAttribute("id", '');
$element_nsTG = new DOMElement('cell', '', '');
$element1TG->appendChild($element_nsTG);
$element_nsTG = new DOMElement('cell', '', '');
$element1TG->appendChild($element_nsTG);
$element_nsTG = new DOMElement('cell', '', '');
$element1TG->appendChild($element_nsTG);
$element_nsTG = new DOMElement('cell', 'Totales', '');
$element1TG->appendChild($element_nsTG);
$element_nsTG = new DOMElement('cell', $totalventasTG, '');
$element1TG->appendChild($element_nsTG);
$element_nsTG = new DOMElement('cell', $totalpremiosTG, '');
$element1TG->appendChild($element_nsTG);
$element_nsTG = new DOMElement('cell', '', '');
$element1TG->appendChild($element_nsTG);
$element_nsTG = new DOMElement('cell', '', '');
$element1TG->appendChild($element_nsTG);


$doc->save($file1);
$docTG->save($file2);
$docTPG->save($file3);
	
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
