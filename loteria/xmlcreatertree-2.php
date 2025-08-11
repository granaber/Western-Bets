<?
// ********** Creacion de archivo XML ************
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

$file = "gridRelaCION.xml";



$doc = new DOMDocument('1.0', 'UTF-8');

$element  = $doc->appendChild(new DOMElement('tree'));
$element->setAttribute("id", "0");

$element2  = $element->appendChild(new DOMElement('item'));
$element2->setAttribute("text", "Sistema");
$element2->setAttribute("id", "Sistema");
$element2->setAttribute("open", "1");


$i = 1;
$resultj = mysqli_query($GLOBALS['link'], 'SELECT * FROM _tbanca Order By IDB');
while ($Row = mysqli_fetch_array($resultj)) {
	$element1  = $element2->appendChild(new DOMElement('item'));
	$element1->setAttribute("text", $Row['Descripcion']);
	$element1->setAttribute("id", '1-' . $Row['IDB']);
	$element1->setAttribute("im0", "banca.ico");
	$element1->setAttribute("im1", "banca.ico");
	$element1->setAttribute("im2", "banca.ico");
	/// Primer Nivel
	$resultj1 = mysqli_query($GLOBALS['link'], 'SELECT * FROM _trelacionbanca where Banca=' . $Row['IDB']);
	while ($Row1 = mysqli_fetch_array($resultj1)) {
		switch ($Row1['Tipo']) {
			case 2:
				$sql = 'SELECT * FROM _tzona where IDZ=' . $Row1['ID_Relacionado'];
				$imag = "zona.gif";
				break;
			case 3:
				$sql = 'SELECT * FROM _tintermediario where IDI=' . $Row1['ID_Relacionado'];
				$imag = "intermediario.ico";
				break;
			case 4:
				$sql = 'SELECT * FROM _tagencias where IDC=' . $Row1['ID_Relacionado'];
				$imag = "agencia.gif";
				break;
		}
		$resultjBusq = mysqli_query($GLOBALS['link'], $sql);
		$RowBusq = mysqli_fetch_array($resultjBusq);
		$element3  = $element1->appendChild(new DOMElement('item'));
		$element3->setAttribute("text", $RowBusq['Descripcion']);
		$element3->setAttribute("id", $Row1['Tipo'] . '-' . $Row1['ID_Relacionado']);
		$element3->setAttribute("im0", $imag);
		$element3->setAttribute("im1", $imag);
		$element3->setAttribute("im2", $imag);
		/// Segundo Nivel
		if ($Row1['Tipo'] == 2) :
			$sql1 = 'SELECT * FROM _trelacionbanca where Zona=' . $Row1['ID_Relacionado'];
		endif;
		if ($Row1['Tipo'] == 3) :
			$sql1 = 'SELECT * FROM _trelacionbanca where Intermediario=' . $Row1['ID_Relacionado'];
		endif;
		$resultj2 = mysqli_query($GLOBALS['link'], $sql1);
		while ($Row2 = mysqli_fetch_array($resultj2)) {
			switch ($Row2['Tipo']) {
				case 2:
					$sql = 'SELECT * FROM _tzona where IDZ=' . $Row2['ID_Relacionado'];
					$imag = "zona.gif";
					break;
				case 3:
					$sql = 'SELECT * FROM _tintermediario where IDI=' . $Row2['ID_Relacionado'];
					$imag = "intermediario.ico";
					break;
				case 4:
					$sql = 'SELECT * FROM _tagencias where IDC=' . $Row2['ID_Relacionado'];
					$imag = "agencia.gif";
					break;
			}
			$resultjBusq = mysqli_query($GLOBALS['link'], $sql);
			$RowBusq = mysqli_fetch_array($resultjBusq);
			$element4  = $element3->appendChild(new DOMElement('item'));
			$element4->setAttribute("text", $RowBusq['Descripcion']);
			$element4->setAttribute("id", $Row2['Tipo'] . '-' . $Row2['ID_Relacionado']);
			$element4->setAttribute("im0", $imag);
			$element4->setAttribute("im1", $imag);
			$element4->setAttribute("im2", $imag);

			/// Tercer Nivel
			if ($Row2['Tipo'] == 2) :
				$sql2 = 'SELECT * FROM _trelacionbanca where Zona=' . $Row2['ID_Relacionado'];
			endif;
			if ($Row2['Tipo'] == 3) :
				$sql2 = 'SELECT * FROM _trelacionbanca where Intermediario=' . $Row2['ID_Relacionado'];
			endif;
			$resultj3 = mysqli_query($GLOBALS['link'], $sql2);
			while ($Row3 = mysqli_fetch_array($resultj3)) {
				switch ($Row3['Tipo']) {
					case 2:
						$sql = 'SELECT * FROM _tzona where IDZ=' . $Row3['ID_Relacionado'];
						$imag = "zona.gif";
						break;
					case 3:
						$sql = 'SELECT * FROM _tintermediario where IDI=' . $Row3['ID_Relacionado'];
						$imag = "intermediario.ico";
						break;
					case 4:
						$sql = 'SELECT * FROM _tagencias where IDC=' . $Row3['ID_Relacionado'];
						$imag = "agencia.gif";
						break;
				}
				$resultjBusq = mysqli_query($GLOBALS['link'], $sql);
				$RowBusq = mysqli_fetch_array($resultjBusq);
				$element5  = $element4->appendChild(new DOMElement('item'));
				$element5->setAttribute("text", $RowBusq['Descripcion']);
				$element5->setAttribute("id", $Row3['Tipo'] . '-' . $Row3['ID_Relacionado']);
				$element5->setAttribute("im0", $imag);
				$element5->setAttribute("im1", $imag);
				$element5->setAttribute("im2", $imag);
			}
		}
	}




	$i++;
}
$doc->save($file);
