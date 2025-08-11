<?
require_once('prc_phpDUK.php');
$link = ConnectionAnimalitos::getInstance();

$op = $_REQUEST['op'];

switch ($op) {
	case '0':
		$IDL = $_REQUEST['IDL'];
		$Hora = $_REQUEST['Hora'];
		$Descripcion = $_REQUEST['Descripcion'];
		$activo = $_REQUEST['Activo'];
		$id = $_REQUEST['id'];

		$resultj = mysqli_query($link, "SELECT * FROM _JornadaStandar  Where  IDL=$IDL and '$Hora'=Hora");
		if (mysqli_num_rows($resultj) == 0) :
			$resultj = mysqli_query($link, "Insert _JornadaStandar (Hora,Descripcion,	Activo,IDL)  values ('$Hora','$Descripcion',$activo,$IDL);");
		//echo ("Insert _JornadaStandar (Hora,Descripcion,	Activo,IDL)  values ('$Hora','$Descripcion',$activo,$IDL);");
		else :
			$resultj = mysqli_query($link, "Update _JornadaStandar set Hora='$Hora',Activo=$activo,Descripcion='$Descripcion' Where '$Hora'=Hora");
		//echo ("Update _JornadaStandar set Hora='$Hora',Activo=$activo,Descripcion='$Descripcion' Where '$Hora'=Hora");
		endif;
		break;

	case '1':
		$activo = $_REQUEST['Activo'];
		$Hora = $_REQUEST['Hora'];
		$IDL = $_REQUEST['IDL'];
		$resultj = mysqli_query($link, "Update _JornadaStandar set Activo=$activo Where  IDL=$IDL  and '$Hora'=Hora");
		//	echo ("Update _JornadaStandar set Activo=$activo Where '$Hora'=Hora");
		break;
	case '2':
		$Hora = $_REQUEST['Hora'];
		$IDL = $_REQUEST['IDL'];
		$resultj = mysqli_query($link, "Delete From  _JornadaStandar  Where IDL=$IDL and '$Hora'=Hora");
		break;
	case '3':
		$data = json_decode($_REQUEST['Datos']);
		$IDL = $_REQUEST['IDL'];

		foreach ($data as $i => $value) {
			$Hora = $data[$i]->Hora;
			$Descripcion = $data[$i]->Descripcion;
			$activo = $data[$i]->Activo;
			$resultj = mysqli_query($link, "SELECT * FROM _JornadaStandar  Where  IDL=$IDL and  '$Hora'=Hora");
			if (mysqli_num_rows($resultj) == 0) :
				$resultj = mysqli_query($link, "Insert _JornadaStandar (Hora,Descripcion,	Activo,IDL)  values ('$Hora','$Descripcion',$activo,$IDL);");
			//echo ("Insert _JornadaStandar (Hora,Descripcion,	Activo,IDL)  values ('$Hora','$Descripcion',$activo,$IDL);");
			else :
				$resultj = mysqli_query($link, "Update _JornadaStandar set Hora='$Hora',Activo=$activo,Descripcion='$Descripcion' Where '$Hora'=Hora");
			//echo ("Update _JornadaStandar set Hora='$Hora',Activo=$activo,Descripcion='$Descripcion' Where '$Hora'=Hora");
			endif;
		}
		break;
	case '4':
		$IDL = $_REQUEST['IDL'];
		$Numero = $_REQUEST['Numero'];
		$Descripcion = $_REQUEST['Descripcion'];
		$Figura = $_REQUEST['Figura'];
		$Hab = $_REQUEST['Hab'];

		$resultj = mysqli_query($link, "SELECT * FROM _NumeroAnimatios  Where  IDL=$IDL and '$Numero'=num");
		if (mysqli_num_rows($resultj) == 0) :
			//	echo ("Insert _NumeroAnimatios (num,figura,activo,nombre,IDL)  values ('$Numero','$Figura',$Hab,'$Descripcion',$IDL);");
			$resultj = mysqli_query($link, "Insert _NumeroAnimatios (num,figura,activo,nombre,IDL)  values ('$Numero','',$Hab,'$Descripcion',$IDL);");
		else :
			$resultj = mysqli_query($link, "Update _NumeroAnimatios set activo=$Hab,nombre='$Descripcion' Where IDL=$IDL and '$Numero'=num");
		endif;
		break;
	case '5':
		$Hab = $_REQUEST['Activo'];
		$Numero = $_REQUEST['Numero'];
		$IDL = $_REQUEST['IDL'];
		$resultj = mysqli_query($link, "Update _NumeroAnimatios set activo=$Hab Where  IDL=$IDL  and '$Numero'=num");

		break;
	case '6':
		$Numero = $_REQUEST['Numero'];
		$IDL = $_REQUEST['IDL'];
		$resultj = mysqli_query($link, "Delete From  _NumeroAnimatios  Where  IDL=$IDL  and '$Numero'=num");
		break;

	case '7':
		$data = json_decode($_REQUEST['Datos']);
		$IDL = $_REQUEST['IDL'];
		foreach ($data as $i => $value) {
			$Numero = $data[$i]->Numero;
			$Descripcion = $data[$i]->Descripcion;
			$Figura = $data[$i]->Figura;
			$Hab = $data[$i]->Hab;
			$resultj = mysqli_query($link, "SELECT * FROM _NumeroAnimatios  Where  IDL=$IDL and '$Numero'=num");
			if (mysqli_num_rows($resultj) == 0) :
				$resultj = mysqli_query($link, "Insert _NumeroAnimatios (num,figura,activo,nombre,IDL)  values ('$Numero','$Figura',$Hab,'$Descripcion',$IDL);");
			//echo ("Insert _NumeroAnimatios (num,figura,activo,nombre,IDL)  values ('$Numero','$Figura',$Hab,'$Descripcion',$IDL);");
			else :
				$resultj = mysqli_query($link, "Update _NumeroAnimatios set figura='$Figura',activo=$Hab,nombre='$Descripcion' Where IDL=$IDL and '$Numero'=num");
			endif;
		}
		break;

	case '8':
		$Numero = $_REQUEST['Numero'];
		$Figura = $_REQUEST['Figura'];
		$IDL = $_REQUEST['IDL'];
		$resultj = mysqli_query($link, "Update _NumeroAnimatios set figura='$Figura' Where  IDL=$IDL  and '$Numero'=num");
		break;
}


echo json_encode($resultj);
