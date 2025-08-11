 <?php
  date_default_timezone_set('America/Caracas');

  function EnLetras($xt)
  {
    switch ($xt) {
      case 1:
        $l = "Uno";
        break;
      case 2:
        $l = "Dos";
        break;
      case 3:
        $l = "Tres";
        break;
      case 4:
        $l = "Cuatro";
        break;
      case 5:
        $l = "Cinco";
        break;
      case 6:
        $l = "Seis";
        break;
      case 7:
        $l = "Siete";
        break;
      case 8:
        $l = "Ocho";
        break;
      case 9:
        $l = "Nueve";
        break;
      case 10:
        $l = "Diez";
        break;
      case 11:
        $l = "Once";
        break;
      case 12:
        $l = "Doce";
        break;
      case 13:
        $l = "Trece";
        break;
      case 14:
        $l = "Catorce";
        break;
    }
    return $l;
  }

  require('prc_php.php');
  $GLOBALS['link'] = Connection::getInstance();

  $envio = array();

  $tipo = $_REQUEST['tipo'];


  if ($tipo == 2) :
    $Serial = $_REQUEST['Serial'];
    $IDCN = $_REQUEST['IDCN'];
    $fecha = Fechareal($minutosa, "d/m/y");
    $IDJugada = $_REQUEST['IDJugada'];
    $Valor_R = $_REQUEST['Valor_R'];
    $Valor_J = $_REQUEST['Valor_J'];
    $terminal = $_REQUEST['terminal'];
    $IDusu = $_REQUEST['IDusu'];
    $jugada = $_REQUEST['jugada'];
    $hora = Horareal($minutosa, "h:i:s A");
    $IDC = $_REQUEST['idc'];
    $multi = $_REQUEST['multi'];
    $carr = $_REQUEST['carr'];
    $fmr = $_REQUEST['fmr'];
    $org = $_REQUEST['org'];
    $nom = $_REQUEST['nom'];
    if ($fmr == 5) :    $premio = $_REQUEST['premio'];
    else :  $premio = 0;
    endif;
    $idcram = rand(1, 2);
    if ($idcram == 1) :
      $se = chr(rand(1, 25) + 65) . '-' . rand(1, $Serial) . '-' . chr(rand(1, 25) + 65) . rand(1, $IDCN) . '-' . substr($Serial, 2, 1) . chr(rand(1, 25) + 65);
    else :
      $se = rand(1, $Serial) . '-' . chr(rand(1, 25) + 65) . '-' . chr(rand(1, 25) + 65) . rand(1, $IDCN) . '-' . substr($Serial, 2, 1) . chr(rand(1, 25) + 65) . '-' . chr(rand(1, 25) + 65) . rand(1, $Valor_J);
    endif;

    if ($fmr == 5) :
      $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _cierre where ct=" . $carr . " and IDCN=" . $IDCN);
    else :
      if ($carr == 0) :
        $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _cierre where IDJug=" . $IDJugada . " and IDCN=" . $IDCN);
      else :
        $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _cierre where IDJug=" . $IDJugada . " and IDCN=" . $IDCN . " and ct=" . $carr);
      endif;
    endif;

    if (mysqli_num_rows($result) == 0) :
      $activar = 1;
      $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tdjuegos where IDJug=" . $IDJugada);
      $row = mysqli_fetch_array($result);
      $title = $row['Descrip'];



      $result = mysqli_query($GLOBALS['link'], "INSERT INTO _tjugada  (Serial,IDCN,Fecha,Hora,Jugada,IDJug,Valor_R,Valor_J,Terminal,IDusu,Anulado,IDC,carr,carr1,nom,org,se) VALUES (" . $Serial . "," . $IDCN . ",'" . $fecha . "','" . $hora . "','" . $jugada . "'," . $IDJugada . "," . $Valor_R . "," . $Valor_J . "," . $terminal . "," . $IDusu . ",0,'" . $IDC . "'," . $carr . ",0,'" . $nom . "'," . $org . ",'" . $se . "')");

      if ($result == false) {

        $result2 = mysqli_query($GLOBALS['link'], "INSERT INTO _tjugada2  (Serial,IDCN,Fecha,Hora,Jugada,IDJug,Valor_R,Valor_J,Terminal,IDusu,Anulado,IDC,carr,carr1,nom,org,se) VALUES (" . $Serial . "," . $IDCN . ",'" . $fecha . "','" . $hora . "','" . $jugada . "'," . $IDJugada . "," . $Valor_R . "," . $Valor_J . "," . $terminal . "," . $IDusu . ",0,'" . $IDC . "'," . $carr . ",0,'" . $nom . "'," . $org . ",'" . $se . "')");
      }

      $k_jug = explode("|", $jugada);
      $valor_de_ins = $result;

      if ($org != 4) :
        $activar = 2;
      else :
        $resultcc = mysqli_query($GLOBALS['link'], "SELECT _tconsecionario.Nombre,_tconsecionario.Direccion FROM _tconsecionario where _tconsecionario.IDC='" . $IDC . "'");
        $rowcc = mysqli_fetch_array($resultcc);
        $ncon = $rowcc['Nombre'];
        $dcon = $rowcc['Direccion'];

      endif;


    else :
      $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tdjuegos where IDJug=" . $IDJugada);
      $row = mysqli_fetch_array($result);
      $tfg = $row['Tandas'];
      $activar = 2;
    endif;

  else :

    $Serial = $_REQUEST['Serial'];
    $result = mysqli_query($GLOBALS['link'], "SELECT _tjugada.*,_tconsecionario.Nombre,_tconsecionario.Direccion FROM _tjugada,_tconsecionario where _tjugada.IDC=_tconsecionario.IDC and Serial=" . $Serial . " and anulado=0");
    $row = mysqli_fetch_array($result);

    if (mysqli_num_rows($result) != 0) :

      $result3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _cierre where IDJug=" . $row['IDJug'] . " and IDCN=" . $row['IDCN']);

      if (mysqli_num_rows($result3) == 0) :
        $result2 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfjornada where IDCN=" . $row['IDCN']);
        $row2 = mysqli_fetch_array($result2);
        if ($row2['Estatus'] == 1) :
          $activar = 1;
          $ncon = $row['Nombre'];
          $dcon = $row['Direccion'];
          $IDCN = $row['IDCN'];
          $fecha = $row['Fecha'];
          $IDJugada = $row['IDJug'];
          $Valor_R = $row['Valor_R'];
          $Valor_J = $row['Valor_J'];
          $terminal = $row['Terminal'];
          $IDusu = $row['IDusu'];
          $jugada = $row['Jugada'];
          $hora = $row["Hora"];
          $IDC = $row['IDC'];
          $carr = $row['carr'];
          $se = $row['se'];
          $result = mysqli_query($GLOBALS['link'], "SELECT * FROM _tdjuegos where IDJug=" . $IDJugada);
          $row = mysqli_fetch_array($result);
          $title = $row['Descrip'];
          $multi = $row['Multip'];
          $fmr = $row['Formato'];
          $k_jug = explode("|", $jugada);


        else :
          $activar = 0;
        endif;

      else :
        $activar = 2;
      endif;
    else :
      $activar = 0;
    endif;
  endif;

  //echo "SELECT * FROM _cierre where IDJug=".$IDJugada." and IDCN=".$IDCN;
  //echo "Update _tdjuegos  Set Descrip='".$jn."',Multi=".$fc.",ApuestaMinima=".$am.",Tandas=".$jt.",Estatus=".$je." where IDJug=".$nj;


  if ($activar == 1) :
    if ($fmr == 5) :
      $tdcl = 4;
    else :
      $tdcl = 3;
    endif;
    $enviar['eva'] = true;
    $enviar['tk'] = '<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<table border="0">
  <tr>
    <th colspan="' . $tdcl . '" scope="col" ><p aling="center">' . $title . '</p></th>
  </tr>
  <tr>
    <th colspan="' . $tdcl . '" scope="col"> Ticket :' . $Serial . '-' . $IDCN . '-' . $terminal . '</th>
  </tr>
  <tr>
    <th colspan="' . $tdcl . '" scope="col">Concesionario:' . $IDC . '-' . trim($ncon) . '</th>
  </tr>
  <tr>
    <th colspan="' . $tdcl . '" scope="col">' . trim($dcon) . '</th>
  </tr>
  <tr>
    <th height="27" colspan="' . $tdcl . '" scope="col">Fecha: ' . $fecha . ' Hora: ' . $hora . '</th>
  </tr>
  <tr>
    <th colspan="' . $tdcl . '" scope="col">';
    if ($tipo == 1) :
      $enviar['tk'] = $enviar['tk'] . '*** COPIA ***';
    else :
      $enviar['tk'] = $enviar['tk'] . 'ORIGINAL';
    endif;
    if ($fmr != 5) :
      if ($carr != 0) :
        $enviar['tk'] = $enviar['tk'] . "<br>Carrera/Tanda:" . $carr;
      endif;
    else :
      $enviar['tk'] = $enviar['tk'] . "<br>Carrera:" . $carr;
    endif;
    if ($fmr != 5) :
      $enviar['tk'] = $enviar['tk'] . '</th>
 	 </tr>
 	 <tr >
    <th bgcolor="#CCCCCC" scope="col" class="boc" >V/E </th>
    <th  valign="top"  bgcolor="#CCCCCC" scope="col" class="alinc" >Jugada</th>';
      if ($fmr != 4) :
        $enviar['tk'] = $enviar['tk'] . '<th valign="top" bgcolor="#CCCCCC" scope="col" class="alinr" >x ' . $multi . '</th>';
      else :
        $enviar['tk'] = $enviar['tk'] . '<th valign="top" bgcolor="#CCCCCC" scope="col" >En Letras</th>';
      endif;
    else :
      $enviar['tk'] = $enviar['tk'] . '</th>
 	 </tr>
	 <tr>
   		 <th colspan="' . $tdcl . '" scope="col">Premiacion x Tabla Bsf.:' . trim($premio) . '</th>
  	</tr>
 	 <tr >
    <th   bgcolor="#CCCCCC" scope="col" class="boc" >Ejem</th>
    <th  valign="top"  bgcolor="#CCCCCC" scope="col" class="alinc" >Nombre</th>';
      $enviar['tk'] = $enviar['tk'] . '<th   valign="top" bgcolor="#CCCCCC" scope="col" class="alinc" >Logro/Tablas.</th><th valign="top" bgcolor="#CCCCCC" scope="col" class="alinc" >Premio</th>';
    endif;

    $enviar['tk'] = $enviar['tk'] . ' </tr>';

    for ($i = 1; $i <= count($k_jug) - 1; $i++) {
      if (fmod($i, 2) == 0) :
        $enviar['tk'] = $enviar['tk'] . " <tr bgcolor='#CCCCCC'> ";
      else :
        $enviar['tk'] = $enviar['tk'] . " <tr>";
      endif;

      if ($fmr != 5) :
        $valor = explode("-", $k_jug[$i]);
        $enviar['tk'] = $enviar['tk'] . "<th scope='col'>" . $i . ")</th>";

        if ($fmr != 4) :
          $enviar['tk'] = $enviar['tk'] . " <th valign='top' scope='col' >" . substr($k_jug[$i], 0, strlen($k_jug[$i]) - 1) . "</th>";
          $enviar['tk'] = $enviar['tk'] . " <th valign='top' scope='col' class='alinr' >" . (count($valor) - 1) . "</th>";
        else :
          $enviar['tk'] = $enviar['tk'] . " <th valign='top' scope='col' >" . $k_jug[$i] . "</th>";
          $enviar['tk'] = $enviar['tk'] . " <th valign='top' scope='col'>" . EnLetras($k_jug[$i]) . "</th>";
        endif;

      else :
        $valor = explode("*", $k_jug[$i]);
        $resulttablas = mysqli_query($GLOBALS['link'], "SELECT * FROM _tablaejempleares where carr=" . $carr . " and IDCN=" . $IDCN . " and Noeje=" . $valor[0]);
        $rowtablas = mysqli_fetch_array($resulttablas);
        $valortbl = explode("-", $valor[1]);
        $enviar['tk'] = $enviar['tk'] . "<th scope='col'>" . $valor[0] . ")</th>";
        $enviar['tk'] = $enviar['tk'] . " <th valign='top' scope='col' >" . trim($rowtablas['Nombre']) . "</th>";
        $enviar['tk'] = $enviar['tk'] . " <th valign='top' scope='col' class='alinr'>" . $valortbl[1] . '/' . $valortbl[0] . "</th>";
        $enviar['tk'] = $enviar['tk'] . " <th valign='top' scope='col' class='alinr'>" . ($valortbl[0] * $premio) . "</th>";
      endif;
      $enviar['tk'] = $enviar['tk'] . "</tr>";
    }
    $formattedR = number_format($Valor_R);
    $formattedJ = number_format($Valor_J);

    $enviar['tk'] = $enviar['tk'] . '<tr>';
    if ($fmr != 5) :
      if ($fmr != 4) :
        $enviar['tk'] = $enviar['tk'] . '<th colspan="2" align="right" valign="top" scope="col">Total Ticket:Bsf.</th> <th height="23" scope="col" class="alinr" >' . $formattedR . '</th>';
      else :
        $enviar['tk'] = $enviar['tk'] . '<th colspan="2" align="right" valign="top" scope="col"></th><th width="0" height="23" scope="col"></th>';
      endif;
      $enviar['tk'] = $enviar['tk'] . '</tr><tr><th colspan="2" align="right" valign="top" scope="col">Pagado:Bsf.</th><th  scope="col" class="alinr" >' . $formattedJ . '</th></tr>';
    else :
      $enviar['tk'] = $enviar['tk'] . '<th colspan="3" align="right" valign="top" scope="col">Total:Bsf.</th> <th scope="col" class="alinr" >' . $formattedR . '</th></tr><tr><th colspan="2" align="right" valign="top" scope="col"></th><th  scope="col" class="alinr" ></th></tr>';
    endif;



    $enviar['tk'] = $enviar['tk'] . '<tr>';

    $enviar['tk'] = $enviar['tk'] . '<th colspan="' . $tdcl . '" scope="col"> S.E.:' . trim($se) . '</th></tr>';
    $enviar['tk'] = $enviar['tk'] . '<tr><th colspan="' . $tdcl . '" scope="col"> *** CADUCA A LOS 7 DIAS *** </th></tr>';
    $enviar['tk'] = $enviar['tk'] . '<tr><th colspan="' . $tdcl . '" scope="col"> ***** CONSERVE SU TICKET ***** </th> </tr>';
    $enviar['tk'] = $enviar['tk'] . '<tr><th colspan="' . $tdcl . '" scope="col"> ****** APUESTASFERCAR.COM ***** </th>  </tr>';
    $enviar['tk'] = $enviar['tk'] . '<tr>- </tr>';
    $enviar['tk'] = $enviar['tk'] . '<tr>- </tr>';
    $enviar['tk'] = $enviar['tk'] . '<tr>- </tr>';
    $enviar['tk'] = $enviar['tk'] . '<tr>- </tr>';
    $enviar['tk'] = $enviar['tk'] . '<tr>- </tr>';
    $enviar['tk'] = $enviar['tk'] . '<tr>- </tr></table>';
    $enviar['confir'] = $valor_de_ins;
  else :
    if ($tipo == 2) :
      if ($org != 4) :
        $enviar['eva'] = true;
        $enviar['tk'] = "Grabado";
        $enviar['confir'] = $valor_de_ins;
      else :
        $enviar['eva'] = false;
        $enviar['tk'] = $activar;
        $enviar['as'] = $tfg;
      endif;
    else :
      $enviar['eva'] = false;
      $enviar['tk'] = $activar;
      $enviar['as'] = $tfg;
    endif;
  endif;

  echo (json_encode($enviar));
  ?>