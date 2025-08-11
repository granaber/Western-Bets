<?
require_once('prc_phpDUK.php');
$link = ConnectionAnimalitos::getInstance();

switch ($_REQUEST['op']) {
  case '1':
    //IDC,IDL,iPremio,iMontSort,iMontMin,iMontMax
    $IDC = $_REQUEST['IDC'];
    $iHb = $_REQUEST['iHb'];
    $iPVenta = $_REQUEST['iPVenta'] == '' ? 0 : $_REQUEST['iPVenta'];
    $iPParti = $_REQUEST['iPParti'] == '' ? 0 : $_REQUEST['iPParti'];
    $iPParti2 = $_REQUEST['iPParti2'] == '' ? 0 : $_REQUEST['iPParti2'];


    $iTkElim = $_REQUEST['iTkElim'] == '' ? 0 : $_REQUEST['iTkElim'];
    $iTkPagar = $_REQUEST['iTkPagar'] == '' ? 0 : $_REQUEST['iTkPagar'];
    $iAceptoPorcentaje = $_REQUEST['iAceptoPorcentaje'] == '' ? 0 : $_REQUEST['iAceptoPorcentaje'];

    $data = json_decode($_REQUEST['Datos']);
    // print_r($data);

    //$iPremio=$_REQUEST['iPremio'];$iMontSort=$_REQUEST['iMontSort'];
    //$iMontMin=$_REQUEST['iMontMin'];  $iMontMax=$_REQUEST['iMontMax'];
    // lineaOBJ={IDL:i,iPremio:$('iPremio'+i).value+,iMontMin:$('iMinimo'+i).value,iMontMax:$('iMaximo'+i).value,iMontSort:$('iMontSort'+i).value}

    foreach ($data as $i => $value) {
      $IDL = $data[$i]->IDL;
      $iPremio = $data[$i]->iPremio1 == "" ? 0 : $data[$i]->iPremio1;
      $iMontSort = $data[$i]->iMontSort == "" ? 0 : $data[$i]->iMontSort;
      $iPremio1 = $data[$i]->iPremio2 == "" ? 0 : $data[$i]->iPremio2;
      $iPremio2 = $data[$i]->iPremio3 == "" ? 0 : $data[$i]->iPremio3;
      $iMontMin = $data[$i]->iMontMin == "" ? 0 : $data[$i]->iMontMin;
      $iMontMax = $data[$i]->iMontMax == "" ? 0 : $data[$i]->iMontMax;
      $iAceptoPorcentaje2 = $data[$i]->iAceptoPorcentaje;
      $iPVentas = $data[$i]->iPVentas == "" ? 0 : $data[$i]->iPVentas;

      $iMontMaxTripleta = $data[$i]->iMontMaxTripleta == "" ? 0 : $data[$i]->iMontMaxTripleta;
      $iPremioTripleta = $data[$i]->iPremioTripleta == "" ? 0 : $data[$i]->iPremioTripleta;
      $iPremioProx =  $data[$i]->iPremioProx == '' ? 0 : $data[$i]->iPremioProx;

      if ($IDL == 1) :
        $resultj = mysqli_query($link, "SELECT * FROM _Concesionario_Ani  Where IDC='$IDC'");
        if (mysqli_num_rows($resultj) == 0) :

          $resultj2N = mysqli_query($link, "Insert _Concesionario_Ani  values('$IDC',$iHb,$iPVenta,$iPParti,$iPParti2,$iPremio,$iMontMin,$iMontMax,$iMontSort,$iTkElim,$iTkPagar,$iAceptoPorcentaje,$iPVentas,$iPremioTripleta,$iMontMaxTripleta)");
        // echo ("Insert _Concesionario_Ani  values('$IDC',$iHb,$iPVenta,$iPParti,$iPremio1,$iMontMin,$iMontMax,$iMontSort,$iTkElim,$iTkPagar)");
        else :
          $resultj2N = mysqli_query($link, "Update  _Concesionario_Ani  set   iPremioTripleta=$iPremioTripleta,iMontMaxTripleta=$iMontMaxTripleta, iAceptoPorcentaje=$iAceptoPorcentaje,iHb=$iHb,iPVenta=$iPVenta,iPParti=$iPParti,iPParti2=$iPParti2,iPremio=$iPremio,iMontMin=$iMontMin,iMontMax=$iMontMax,iMontSort=$iMontSort,iTkElim=$iTkElim,iTkPagar=$iTkPagar,iPVentas=$iPVentas  where IDC='$IDC'");
        endif;
      else :
        $resultj = mysqli_query($link, "SELECT * FROM _Concesionario_Ani_2  Where  IDL=$IDL and  IDC='$IDC'");
        if (mysqli_num_rows($resultj) == 0) :
          //   //                                                        IDC,IDL,iPremio,iMontSort,iMontMin,iMontMax
          echo ("Insert _Concesionario_Ani_2  values('$IDC',$IDL,$iPremio,$iMontSort,$iMontMin,$iMontMax,$iPremio1,$iPremio2,$iAceptoPorcentaje2)");
          $resultj3N = mysqli_query($link, "Insert _Concesionario_Ani_2  values('$IDC',$IDL,$iPremio,$iMontSort,$iMontMin,$iMontMax,$iPremioProx,$iPremio1,$iPremio2,$iAceptoPorcentaje2,$iPVentas,$iPremioTripleta,$iMontMaxTripleta)");
        else :
          $resultj3N = mysqli_query($link, "Update  _Concesionario_Ani_2  set  iPremioTripleta=$iPremioTripleta,iMontMaxTripleta=$iMontMaxTripleta, iAceptoPorcentaje=$iAceptoPorcentaje2,iPremio=$iPremio,iMontMin=$iMontMin,iMontMax=$iMontMax,iMontSort=$iMontSort,iPremio1=$iPremio1,iPremio2=$iPremio2,iPVentas=$iPVentas,iPremioProx=$iPremioProx  where  IDL=$IDL and  IDC='$IDC'");
        // echo "Update  _Concesionario_Ani_2  set iPremio=$iPremio,iMontMin=$iMontMin,iMontMax=$iMontMax,iMontSort=$iMontSort,iPremio1=$iPremio1,iPremio2=$iPremio2 where  IDL=$IDL and  IDC='$IDC'";
        endif;

      endif;
    }
    if (!$resultj2N) :
      echo '<script> alert("Disculpe hubo un error a tratar de Actualizar al Punto de Venta!"); </script>';
    else :
      echo '<script> alert("Datos Almacenados!"); </script>';
    endif;
    break;

  case '2':
    $resultj2N = mysqli_query($link, "Update _Banca_Tope_S  set  Tope=" . $_REQUEST['Tope'] . "  where IDS=" . $_REQUEST['IDS']);
    if (!$resultj2N) :
      echo '<script> alert("Disculpe hubo un error a tratar de Actualizar los Restricciones!"); </script>';
    endif;
    break;
  case '3':
    $resultj2N = mysqli_query($link, "Update _Grupo_Tope_S  set  Tope=" . $_REQUEST['Tope'] . "  where IDG=" . $_REQUEST['IDG'] . " and IDS=" . $_REQUEST['IDS']);
    if (!$resultj2N) :
      echo '<script> alert("Disculpe hubo un error a tratar de Actualizar los Restricciones!"); </script>';
    endif;
    break;
  case '4':
    $resultj2N = mysqli_query($link, "Update _Banca_Tope_N  set  Tope=" . $_REQUEST['Tope'] . "  where IDS=" . $_REQUEST['IDS'] . " and numero='" . $_REQUEST['num'] . "'");
    if (!$resultj2N) :
      echo '<script> alert("Disculpe hubo un error a tratar de Actualizar los Restricciones!"); </script>';
    endif;
    break;
  case '5':
    $resultj2N = mysqli_query($link, "Update _Grupo_Tope_N  set  Tope=" . $_REQUEST['Tope'] . "  where IDS=" . $_REQUEST['IDS'] . " and numero='" . $_REQUEST['num'] . "' and IDG=" . $_REQUEST['IDG']);
    if (!$resultj2N) :
      echo '<script> alert("Disculpe hubo un error a tratar de Actualizar los Restricciones!"); </script>';
    endif;
    break;
  case '6':
    $modo = $_REQUEST['modo'];
    $premio = $_REQUEST['logro'];
    $numero = $_REQUEST['numero'];
    $ID = $_REQUEST['ID'];
    $resultj2N = mysqli_query($link, "Select * from   _Conf_premio  where  modo=" . $modo . " and numero=" . $numero);
    if (mysqli_num_rows($resultj2N) == 0) :
      $resultj2N = mysqli_query($link, "Insert  _Conf_premio  (ID,modo,numero,logro) values (" . $ID . "," . $modo . "," . $numero . "," . $premio . ")");
    else :
      $rowj2n = mysqli_fetch_array($resultj2N);
      $l = $rowj2n['l'];
      $resultj2N = mysqli_query($link, "Update _Conf_premio  set  modo=" . $_REQUEST['modo'] . ",numero=" . $_REQUEST['numero'] . ",logro=" . $_REQUEST['logro'] . "  where l=" . $l);
    endif;
    if (!$resultj2N) :
      echo '<script> alert("Disculpe hubo un error a tratar de Actualizar !"); </script>';
    endif;
    break;
  case '7':
    $l = $_REQUEST['l'];
    $resultj2N = mysqli_query($link, "Delete From  _Conf_premio    where l=" . $l);
    if (!$resultj2N) :
      echo '<script> alert("Disculpe hubo un error a tratar de Actualizar !"); </script>';
    endif;
    break;
  case '8':

    global $serverD;
    global $userD;
    global $clvD;
    global $dbD;



    $data = json_decode($_REQUEST['Datos']);
    $IDGs = $data->IDGs;

    if ($IDGs == '') {
      echo '<script> alert("Necesito que indique que grupos va aplicar los cambios!!"); </script>';
      exit;
    }
    $forIDL = $data->iAssing;
    $iPremio = $data->iPremio1;
    $iPremio1 = $data->iPremio2;
    $iPremio2 = $data->iPremio3;
    $iMontMin = $data->iMontMin;
    $iMontMax = $data->iMontMax;
    $iMontSort = $data->iMontSort;
    $iAceptoPorcentaje = $data->iAceptoPorcentaje;
    $iPVentas = $data->iPVentas;
    $iMontMaxTripleta = $data->iMontMaxTripleta;
    $iPremioTripleta = $data->iPremioTripleta;
    $isActiveTripleta = getTripleta($forIDL);

    $field_update_main = [];

    $field_update = [];
    $field_insert = [];
    $data_insert = [];


    $resul_lott = mysqli_query($link, "SELECT * From _Loterias Where IDL=$forIDL ");
    $row_lott = mysqli_fetch_array($resul_lott);
    $CantiNumer = $row_lott['xFun'] == 4 ? $row_lott['minimalNumber'] : (($row_lott['xFun'] == 0 || $row_lott['xFun'] == 3) ? $row_lott['Code'] : 1);

    if ($iPremio != "") {
      $field_update[] = "iPremio=$iPremio";
      $field_insert[] = "iPremio";
      $data_insert[] = $iPremio;

      $field_update_main[] = "iPremio=$iPremio";
    }
    if ($CantiNumer >= 2) {
      if ($iPremio1 != "") {
        $field_update[] = "iPremio1=$iPremio1";
        $field_insert[] = "iPremio1";
        $data_insert[] = $iPremio1;
      }
    }
    if ($CantiNumer >= 3) {
      if ($iPremio2 != "") {
        $field_update[] = "iPremio2=$iPremio2";
        $field_insert[] = "iPremio2";
        $data_insert[] = $iPremio2;
      }
    }
    if ($iMontMin != "") {
      $field_update[] = "iMontMin=$iMontMin";
      $field_insert[] = "iMontMin";
      $data_insert[] = $iMontMin;

      $field_update_main[] = "iMontMin=$iMontMin";
    }
    if ($iMontMax != "") {
      $field_update[] = "iMontMax=$iMontMax";
      $field_insert[] = "iMontMax";
      $data_insert[] = $iMontMax;

      $field_update_main[] = "iMontMax=$iMontMax";
    }
    if ($iMontSort != "") {
      $field_update[] = "iMontSort=$iMontSort";
      $field_insert[] = "iMontSort";
      $data_insert[] = $iMontSort;

      $field_update_main[] = "iMontSort=$iMontSort";
    }
    if ($iAceptoPorcentaje != "") {
      $field_update[] = "iAceptoPorcentaje=$iAceptoPorcentaje";
      $field_insert[] = "iAceptoPorcentaje";
      $data_insert[] = $iAceptoPorcentaje;

      $field_update_main[] = "iAceptoPorcentaje=$iAceptoPorcentaje";
    }
    if ($iPVentas != "") {
      $field_update[] = "iPVentas=$iPVentas";
      $field_insert[] = "iPVentas";
      $data_insert[] = $iPVentas;

      $field_update_main[] = "iPVentas=$iPVentas";
      $field_update_main[] = "iPVenta=$iPVentas";
    }
    if ($isActiveTripleta) {
      if ($iMontMaxTripleta != "") {
        $field_update[] = "iMontMaxTripleta=$iMontMaxTripleta";
        $field_insert[] = "iMontMaxTripleta";
        $data_insert[] = $iMontMaxTripleta;

        $field_update_main[] = "iMontMaxTripleta=$iMontMaxTripleta";
      }

      ///iPremioTripleta
      if ($iPremioTripleta != "") {
        $field_update[] = "iPremioTripleta=$iPremioTripleta";
        $field_insert[] = "iPremioTripleta";
        $data_insert[] = $iPremioTripleta;

        $field_update_main[] = "iPremioTripleta=$iPremioTripleta";
      }
    }
    if (count($data_insert)  == 0) {
      echo '<script> alert("No hay datos que actualizar!!"); </script>';
      exit;
    }

    $ListIDC = [];
    $linkMain = mysqli_connect($serverD, $userD, $clvD, $dbD);
    $resultjsIDG = mysqli_query($linkMain, "SELECT * FROM _tconsecionario where IDG in ( $IDGs )  ");
    while ($rowIDG = mysqli_fetch_array($resultjsIDG)) {
      $ListIDC[] = "'" . $rowIDG['IDC'] . "'";
    }

    $resultj = mysqli_query($link, "SELECT * FROM _Concesionario_Ani where IDC in (" . join(",", $ListIDC) . ")  ");
    while ($row = mysqli_fetch_array($resultj)) {

      $IDC = $row['IDC'];

      if ($forIDL == 1) {
        mysqli_query($link, "UPDATE _Concesionario_Ani set " . join(",", $field_update_main) . " where IDC='$IDC' ");
      } else {
        $resul_lott = mysqli_query($link, "SELECT * From _Loterias Where IDL=$forIDL ");
        while ($row_lott = mysqli_fetch_array($resul_lott)) {
          $IDL = $row_lott['IDL'];

          $where = " IDC='$IDC' and IDL=$IDL";

          $resultj2 = mysqli_query($link, "SELECT * FROM _Concesionario_Ani_2 where  $where");
          if (mysqli_num_rows($resultj2) == 0) {
            mysqli_query($link, "INSERT _Concesionario_Ani_2  (IDC,IDL," . join(",", $field_insert) . ") VALUES  ('$IDC',$IDL," . join(",", $data_insert) . ") ");
          } else {
            mysqli_query($link, "UPDATE _Concesionario_Ani_2    SET " . join(",", $field_update) . " WHERE $where ");
          }
        }
      }
    }
    echo '<script> alert("Datos Cambiados!"); </script>';
    break;

  case '9':
    //IDC,IDL,iPremio,iMontSort,iMontMin,iMontMax
    $IDG = $_REQUEST['IDG'];
    $data = json_decode($_REQUEST['Datos']);
    foreach ($data as $i => $value) {
      $IDL = $data[$i]->IDL;
      $iMontSort = $data[$i]->iMontSort;
      $iMontMaxNum = $data[$i]->iMontMaxNum;

      $resultj = mysqli_query($link, "SELECT * FROM _Grupos_topes  Where  IDG=$IDG and  IDL=$IDL");
      if (mysqli_num_rows($resultj) == 0) :
        //   //                                                        IDC,IDL,iPremio,iMontSort,iMontMin,iMontMax
        $resultj3N = mysqli_query($link, "Insert _Grupos_topes (IDG,iMontSort,iMontMaxNum,IDL)  values ($IDG,$iMontSort,$iMontMaxNum,$IDL)");
      // echo ("Insert _Concesionario_Ani_2  values('$IDC',$IDL,$iPremio,$iMontSort,$iMontMin,$iMontMax,$iPremio1,$iPremio2,$iAceptoPorcentaje2)");
      else :
        $resultj3N = mysqli_query($link, "Update  _Grupos_topes  set  iMontSort=$iMontSort,iMontMaxNum=$iMontMaxNum where  IDL=$IDL and  IDG=$IDG");
      // echo "Update  _Concesionario_Ani_2  set iPremio=$iPremio,iMontMin=$iMontMin,iMontMax=$iMontMax,iMontSort=$iMontSort,iPremio1=$iPremio1,iPremio2=$iPremio2 where  IDL=$IDL and  IDC='$IDC'";
      endif;
    }
    echo '<script> alert("Datos Grabados!"); </script>';
}
