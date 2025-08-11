<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();
//**// Tipo,ID,relacion,IDrelacion //**//
switch ($_REQUEST['Tipo']) {
	case 2:
		$resultj = mysqli_query($GLOBALS['link'], "Select * from _trelacionbanca where ID_Relacionado=" . $_REQUEST['ID'] . " and Tipo=2");
		switch ($_REQUEST['relacion']) {
			case 1:
				if (mysqli_num_rows($resultj) == 0) :
					$resul = mysqli_query($GLOBALS['link'], "Insert _trelacionbanca values (" . $_REQUEST['ID'] . "," . $_REQUEST['Tipo'] . "," . $_REQUEST['IDrelacion'] . ',0,0)');
				else :
					$resul = mysqli_query($GLOBALS['link'], "Update _trelacionbanca set Banca=" . $_REQUEST['IDrelacion'] . ",Zona=0,Intermediario=0 where ID_Relacionado=" . $_REQUEST['ID'] . " and Tipo=2");
				endif;
				break;
			case 2:
				if (mysqli_num_rows($resultj) == 0) :
					$resul = mysqli_query($GLOBALS['link'], "Insert _trelacionbanca values (" . $_REQUEST['ID'] . "," . $_REQUEST['Tipo'] . ",0," . $_REQUEST['IDrelacion'] . ',0)');
				else :
					$resul = mysqli_query($GLOBALS['link'], "Update _trelacionbanca set Zona=" . $_REQUEST['IDrelacion'] . ",Banca=0,Intermediario=0 where ID_Relacionado=" . $_REQUEST['ID'] . " and Tipo=2");
				endif;
				break;
			case 3:
				if (mysqli_num_rows($resultj) == 0) :
					$resul = mysqli_query($GLOBALS['link'], "Insert _trelacionbanca values (" . $_REQUEST['ID'] . "," . $_REQUEST['Tipo'] . ",0,0," . $_REQUEST['IDrelacion'] . ')');
				else :
					$resul = mysqli_query($GLOBALS['link'], "Update _trelacionbanca set Intermediario=" . $_REQUEST['IDrelacion'] . ",Banca=0,Zona=0 where ID_Relacionado=" . $_REQUEST['ID'] . " and Tipo=2");
				endif;
				break;
		}
		break;
	case 3:
		$resultj = mysqli_query($GLOBALS['link'], "Select * from _trelacionbanca where ID_Relacionado=" . $_REQUEST['ID'] . " and Tipo=3");
		switch ($_REQUEST['relacion']) {
			case 1:
				if (mysqli_num_rows($resultj) == 0) :
					$resul = mysqli_query($GLOBALS['link'], "Insert _trelacionbanca values (" . $_REQUEST['ID'] . "," . $_REQUEST['Tipo'] . "," . $_REQUEST['IDrelacion'] . ',0,0)');
				else :
					$resul = mysqli_query($GLOBALS['link'], "Update _trelacionbanca set Banca=" . $_REQUEST['IDrelacion'] . ",Zona=0,Intermediario=0 where ID_Relacionado=" . $_REQUEST['ID'] . " and Tipo=3");
				endif;
				break;
			case 2:
				if (mysqli_num_rows($resultj) == 0) :
					$resul = mysqli_query($GLOBALS['link'], "Insert _trelacionbanca values (" . $_REQUEST['ID'] . "," . $_REQUEST['Tipo'] . ",0," . $_REQUEST['IDrelacion'] . ',0)');
				else :
					$resul = mysqli_query($GLOBALS['link'], "Update _trelacionbanca set Zona=" . $_REQUEST['IDrelacion'] . ",Banca=0,Intermediario=0 where ID_Relacionado=" . $_REQUEST['ID'] . " and Tipo=3");
				endif;
				break;
			case 3:
				if (mysqli_num_rows($resultj) == 0) :
					$resul = mysqli_query($GLOBALS['link'], "Insert _trelacionbanca values (" . $_REQUEST['ID'] . "," . $_REQUEST['Tipo'] . ",0,0," . $_REQUEST['IDrelacion'] . ')');
				else :
					$resul = mysqli_query($GLOBALS['link'], "Update _trelacionbanca set Intermediario=" . $_REQUEST['IDrelacion'] . ",Banca=0,Zona=0 where ID_Relacionado=" . $_REQUEST['ID'] . " and Tipo=3");
				endif;
				break;
		}
		break;
	case 4:
		$resultj = mysqli_query($GLOBALS['link'], "Select * from _trelacionbanca where ID_Relacionado=" . $_REQUEST['ID'] . " and Tipo=4");
		switch ($_REQUEST['relacion']) {
			case 1:
				if (mysqli_num_rows($resultj) == 0) :
					$resul = mysqli_query($GLOBALS['link'], "Insert _trelacionbanca values (" . $_REQUEST['ID'] . "," . $_REQUEST['Tipo'] . "," . $_REQUEST['IDrelacion'] . ',0,0)');
				else :
					$resul = mysqli_query($GLOBALS['link'], "Update _trelacionbanca set Banca=" . $_REQUEST['IDrelacion'] . ",Zona=0,Intermediario=0 where ID_Relacionado=" . $_REQUEST['ID'] . " and Tipo=4");
				endif;
				break;
			case 2:
				if (mysqli_num_rows($resultj) == 0) :
					$resul = mysqli_query($GLOBALS['link'], "Insert _trelacionbanca values (" . $_REQUEST['ID'] . "," . $_REQUEST['Tipo'] . ",0," . $_REQUEST['IDrelacion'] . ',0)');
				else :
					$resul = mysqli_query($GLOBALS['link'], "Update _trelacionbanca set Zona=" . $_REQUEST['IDrelacion'] . ",Banca=0,Intermediario=0 where ID_Relacionado=" . $_REQUEST['ID'] . " and Tipo=4");
				endif;
				break;
			case 3:
				if (mysqli_num_rows($resultj) == 0) :
					$resul = mysqli_query($GLOBALS['link'], "Insert _trelacionbanca values (" . $_REQUEST['ID'] . "," . $_REQUEST['Tipo'] . ",0,0," . $_REQUEST['IDrelacion'] . ')');
				else :
					$resul = mysqli_query($GLOBALS['link'], "Update _trelacionbanca set Intermediario=" . $_REQUEST['IDrelacion'] . ",Banca=0,Zona=0 where ID_Relacionado=" . $_REQUEST['ID'] . " and Tipo=4");
				endif;
				break;
		}
		break;
}
