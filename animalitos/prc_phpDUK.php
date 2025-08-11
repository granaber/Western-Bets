<?php

$MODE_PRODUCTION = 0;
$MODE_DEPLOY = 1;
// Para Activar el Modo DEPLOY solo tiene que crear un acrhivo llamado "deploy.env" en la raiz del proyecto
$mode = modeDetectAnimalitos(); // 0= Modo produccion, bloqueos de Seguridad, 1= Modo Desarrollo, Libre SuperUsuarios
//////////////////////////////////////////////////////////////////////////////////////////////////////////

date_default_timezone_set('America/Caracas');
$server =  $mode == $MODE_PRODUCTION ? '10.136.242.179' : '127.0.0.1:1653'; //zuloteria.db.5144062.hostedresource.com;localhost
$user =  $mode == $MODE_PRODUCTION ? 'betgambler_anima' : 'root'; //root; bancala_loteria
$clv =  $mode == $MODE_PRODUCTION ? 'T-!OV33R}e;}' : 'H4W29ZoGSxKU'; //Legna113;intra
$db = $mode == $MODE_PRODUCTION ? 'animalitos_betgambler' : 'animalitos_betgambler'; //bancala_loteria; lotery

/////// Datos del Server de DEPORTES ///////////
$serverD =  $mode == $MODE_PRODUCTION ? '10.136.242.179' : '127.0.0.1:1653'; //zuloteria.db.5144062.hostedresource.com;localhost
$userD = $mode == $MODE_PRODUCTION ? 'betgambler_root' : 'root'; //root; bancala_loteria
$clvD = $mode == $MODE_PRODUCTION ? '8I#q}*7sGWC]' : 'H4W29ZoGSxKU'; //Legna113;intra
$dbD =  $mode == $MODE_PRODUCTION ? 'parlay_betgambler' : 'parlay_betgambler'; //bancala_loteria; lotery
///////////////////////////////////////////////
/////// Datos del Server de Americanas ///////////
$serverA = '74.217.31.36'; //zuloteria.db.5144062.hostedresource.com;localhost
$userA = 'tujugada_rootremo'; //root; bancala_loteria
$clvA = '5zdi~ovsTsKg'; //Legna113;intra
$dbA = 'tujugada_americana'; //bancala_loteria; lotery
///////////////////////////////////////////////
$CantidaNumeros = 38;
$minutosho = 0;
$minutosh = $minutosho;
$arrayvendido = array();
$lisColorsLottery = ['#006699', '#4c5791', '#5e4f87', '#6d467b', '#763e6d', '#7c375d', '#7e334d', '#894b7d', '#605f20', '#70591f', '#006d7a', '#006c57', '#044034', '#50829f', '#37596e', '#4a9dd0'];
$WAIT_TRP_RD = 0;
$APROBAT_TRP_RD = 1;
class ConnectionAnimalitos
{
  protected $_link;
  public static function getInstance()
  {
    global $server;
    global $user;
    global $clv;
    global $db;
    return mysqli_connect($server, $user, $clv, $db);
  }
}
function HorarealAnimalitos($minutos, $fm)/*"h:i:s A"*/
{
  $x = date("H i s m d Y", time());
  $fecha = explode(" ", $x);
  $fecha[1] = $fecha[1] + $minutos;
  $fecha2 = date($fm, mktime($fecha[0], $fecha[1], $fecha[2], $fecha[3], $fecha[4], $fecha[5]));
  return $fecha2;
}
function FecharealAnimalitos($minutos, $formato)
{
  $x = date("H i s m d Y", time());
  $fecha = explode(" ", $x);
  $fecha[1] = $fecha[1] + $minutos;
  $fecha2 = date($formato, mktime($fecha[0], $fecha[1], $fecha[2], $fecha[3], $fecha[4], $fecha[5]));
  return $fecha2;
}
function _ConverFecha($FechaOri)
{
  $sing = strpos($FechaOri, '-');
  $sep = $sing === false ? '/' : '-';
  $DivFecha = explode($sep, $FechaOri);
  $FechaOri = $DivFecha[2] . '-' . $DivFecha[1] . '-' . $DivFecha[0];
  return $FechaOri;
}
function _ConverFechaT2($FechaOri)
{
  $DivFecha = explode('-', $FechaOri);
  $FechaOri = $DivFecha[2] . '-' . $DivFecha[1] . '-' . $DivFecha[0];
  return $FechaOri;
}
function convertirMilitarAnimalitos($Hora)
{
  $PMAM = explode("a", $Hora);
  if (count($PMAM) == 1) :
    $PMAM = explode("p", $Hora);
    if (count($PMAM) == 1) :
      $PMAM = explode(" ", $Hora);
    else :
      $PMAM[1] = 'pm';
    endif;
  else :
    $PMAM[1] = 'am';
  endif;

  $horaM = explode(":", $PMAM[0]);
  if (!isset($horaM[1])) $horaM[1] = '00';
  if (!isset($horaM[2])) $horaM[2] = '00';
  if (strtoupper($PMAM[1]) == 'PM') :
    if (intval($horaM[0]) != 12) :
      $horaM[0] = intval($horaM[0]) + 12;
    endif;
  endif;
  return implode(':', $horaM);
}
function convertirNormal($Hora)
{
  $horaM = explode(":", $Hora);
  $horaR = $horaM[0];
  if ($horaM[0] >= 12) : $AP = 'pm';
    if ($horaM[0] != 12) : $horaR = $horaM[0] - 12;
    endif;
  else : $AP = 'am';
  endif;
  return $horaR . ':' . $horaM[1] . ':' . $horaM[2] . ' ' . $AP;
}

function _NowCaptDUL($IDJ, $IDL)
{
  return;
  //   // global $CantidaNumeros;
  //   /*$iSorteo=array();
  //   $iResultado=array();
  //   $url="http://www.granjamillonaria.com/Resource?a=hoy"; // url de la pagina que queremos obtener
  //   $contents = file_get_contents($url);
  //   $contents = utf8_encode($contents);
  //   $results = json_decode($contents);
  //   $valor=$results->rss;

  //   foreach ($valor as $i => $delta) {

  //       $iSorteo[]=convertirMilitarAnimalitos($valor[$i]->h);
  //       $iResultado[]=$valor[$i]->nu;

  //   }*/
  //   $inicial=false;
  // //  print_r($iSorteo);
  // //  $resultjNSup = mysqli_query($link,"SELECT * FROM _Loterias  Where Activa=1");
  // //   while($row1NSup = mysqli_fetch_array($resultjNSup)){
  //       $iSorteo=array();  $iResultado=array();
  //       $resultj = mysqli_query($link,"SELECT * FROM _JornadaStandar  Where IDL=".$IDL." and Activo=1");
  //       while($row = mysqli_fetch_array($resultj)){
  //         $iSorteo[]=$row['Hora'];
  //         $iResultado[]=-1;
  //       }

  //         for ($i=0;$i<=count($iSorteo)-1;$i++){
  //           $resultj = mysqli_query($link,"SELECT * FROM _Jornada  Where IDJ=".$IDJ." and HoraCierre='".$iSorteo[$i]."' and IDL=".$IDL);
  //         // echo ("SELECT * FROM _Jornada  Where IDJ=".$IDJ." and HoraCierre='".$iSorteo[$i]."' and IDL=".$IDL);
  //           if (mysqli_num_rows($resultj)==0):
  //           $inicial=true;
  //           $resultj2N = mysqli_query($link,"Insert _Jornada (	IDJ,IDJS,HoraCierre,Activa,CantidadNum,IDL ) values($IDJ,0,'".$iSorteo[$i]."',1,".$CantidaNumeros.",".$IDL.")");
  //           //echo ("Insert _Jornada (	IDJ,IDJS,HoraCierre,Activa,CantidadNum,IDL ) values($IDJ,0,'".$iSorteo[$i]."',0,".$CantidaNumeros.",".$IDL.")");
  //           $ID=mysql_insert_id();
  //           $resultj1N = mysqli_query($link,"SELECT * FROM _PremioStandar  ");
  //            while($row1N = mysqli_fetch_array($resultj1N)){
  //               $resultj2N = mysqli_query($link,"Insert _Conf_premio (	ID,modo,numero,logro ) values ($ID,".$row1N['modo'].",".$row1N['numero'].",".$row1N['logro'].")");
  //           //  echo ("Insert _Conf_premio (	ID,modo,numero,logro ) values ($ID,".$row1N['modo'].",".$row1N['numero'].",".$row1N['logro'].")");
  //              }
  //         endif;
  //         }

  //}
  // if ($inicial):
  //   $resultj2N = mysqli_query($link,"Update  _Grupo_Tope_N  set Suma=0");
  //   $resultj2N = mysqli_query($link,"Update  _Grupo_Tope_S set Suma=0");
  //   $resultj2N = mysqli_query($link,"Update  _Banca_Tope_N  set Suma=0");
  //   $resultj2N = mysqli_query($link,"Update  _Banca_Tope_S set Suma=0");
  //   $resultj2N = mysqli_query($link,"Delete From _Tope_Suma_PV_Xnum");
  // endif;
}


function _Capta1(&$iSorteo, &$iResultado)
{

  // $url = "http://www.granjamillonaria.com/Resource?a=animalitos-hoy"; // url de la pagina que queremos obtener
  // $contents = file_get_contents($url);
  // $contents = utf8_encode($contents);
  // $results = json_decode($contents);
  // $valor = $results->rss;

  // foreach ($valor as $i) {
  //   $iSorteo[] = convertirMilitarAnimalitos($valor[$i]->h);
  //   if (isset($valor[$i]->nu))
  //     $iResultado[] = $valor[$i]->nu;
  //   else
  //     $iResultado[] = '';
  // }
  // print_r($iResultado);


}

function _NowCaptEscrutesDUL($IDJ, $IDL)
{
  global $link;

  $iSorteo = array();
  $iResultado = array();
  $resultj = mysqli_query($link, "SELECT * FROM _Loterias  Where IDL=" . $IDL);
  $row = mysqli_fetch_array($resultj);
  $funcion = $row['xFun'];
  switch ($funcion) {
    case '2':
      _Capta1($iSorteo, $iResultado);
      break;
  }

  $resultj = mysqli_query($link, "SELECT * FROM _Jornada  Where IDJ=" . $IDJ . " and IDL=" . $IDL);
  while ($row = mysqli_fetch_array($resultj)) {
    $resultj2n = mysqli_query($link, "SELECT * FROM _Escritu_Ani  Where ID=" . $row['ID']);
    if (mysqli_num_rows($resultj2n) == 0) :
      $resultj2N = mysqli_query($link, "Insert _Escritu_Ani (	ID,IDJ,G1,G2,G3,Publicar,IDL ) values (" . $row['ID'] . "," . $IDJ . ",-1,-1,-1,0,$IDL)");
    endif;
  }

  for ($i = 0; $i <= count($iSorteo) - 1; $i++) {
    $resultj = mysqli_query($link, "SELECT * FROM _Jornada  Where IDJ=" . $IDJ . " and HoraCierre='" . $iSorteo[$i] . "' and  IDL=" . $IDL);
    if (mysqli_num_rows($resultj) != 0) :
      $rowj = mysqli_fetch_array($resultj);
      $ID = $rowj['ID'];
      $resultj = mysqli_query($link, "SELECT * FROM _Escritu_Ani  Where ID=" . $ID);
      if (mysqli_num_rows($resultj) == 0) :
        $resultj2N = mysqli_query($link, "Insert _Escritu_Ani (	ID,IDJ,G1,G2,G3,Publicar ) values (" . $ID . "," . $IDJ . "," . $iResultado[$i] . ",-1,-1,1)");
      else :
        $resultj2N = mysqli_query($link, "Update  _Escritu_Ani set G1=" . $iResultado[$i] . ",Publicar=1 where ID=" . $ID);
      endif;
    endif;
  }
}
function _AnularEscrutes($IDJ, $IDL)
{
  global $link;

  $sID = array();
  $result = mysqli_query($link, "Select ID from _Jornada where IDJ=$IDJ and IDL=$IDL");
  while ($row = mysqli_fetch_array($result))
    $sID[] = $row['ID'];

  $result = mysqli_query($link, "Select * From  _Jugada_ani  Where Activo=1 and  IDJ=" . $IDJ);
  $iSerial = array();
  while ($row = mysqli_fetch_array($result)) {
    $data = unserialize(decoBaseK($row['Jugada']));
    foreach ($data as $i => $value) {
      $ide = array_search($data[$i]->sorteo, $sID);
      if ($ide === false) :
        continue;
      else :
        $iSerial[] = $row['serial'];
        break;
      endif;
    }
  }
  $lSerial = implode(',', $iSerial);
  $result = mysqli_query($link, "Update  _Jugada_ani set Esc=0,Down=0 Where  serial in (" . $lSerial . ")");
}
function _Escrute_Ani_total($fecha, $IDL)
{
  global $link;

  $IDJ = _FechaDUK($fecha);

  $sPremios = array();
  $nPremios = array();
  $nPremios1 = array();
  $akIDL = array();
  $result = mysqli_query($link, "Select * From  _Escritu_Ani  Where Publicar=1 and  IDJ=" . $IDJ); //." and ID in (Select ID from _Jornada where IDL=$IDL and  IDJ=".$IDJ.")")
  //echo ("Select * From  _Escritu_Ani  Where Publicar=1 and  IDJ=".$IDJ." and ID in (Select ID from _Jornada where IDL=$IDL and  IDJ=".$IDJ.")");
  while ($row = mysqli_fetch_array($result)) {
    $sPremios[] = $row['ID'];
    /// Premio Ganador 1
    if (is_numeric($row['G1'])) :
      if ($row['G1'] == '0') :
        $nPremios[] = "'" . $row['G1'] . "'";
      else :
        if ($row['G1'] == '00') :
          $nPremios[] = "'" . $row['G1'] . "'";
        else :
          $nPremios[] = $row['G1'];
        endif;
      endif;
    else :
      $nPremios[] = $row['G1'];
    endif;
    /// Premio Ganador 2
    if (is_numeric($row['G2'])) :
      if ($row['G2'] == '0') :
        $nPremios1[] = "'" . $row['G2'] . "'";
      else :
        if ($row['G2'] == '00') :
          $nPremios1[] = "'" . $row['G2'] . "'";
        else :
          $nPremios1[] = $row['G2'];
        endif;
      endif;
    else :
      $nPremios1[] = $row['G2'];
    endif;
    ////////////////////////
    $resultIDSOL = mysqli_query($link, "Select * From  _Jornada  Where   ID=" . $row['ID']);
    $rowIDSOL = mysqli_fetch_array($resultIDSOL);
    $akIDL[$row['ID']] = $rowIDSOL['IDL'];
    $resultIDSOL = mysqli_query($link, "Select * From  _Loterias  Where   IDL=" . $rowIDSOL['IDL']);
    $rowIDSOL = mysqli_fetch_array($resultIDSOL); // echo "Select * From  _Loterias  Where   ID=".$row['ID'];
    $xCode[$row['ID']] = $rowIDSOL['Code'];
  }

  //  $alogros=array();
  /*$result = mysqli_query($link,"SELECT _Conf_premio . * FROM _Conf_premio, _Jornada WHERE numero = -1 AND _Conf_premio.ID = _Jornada.ID AND IDJ =".$IDJ);
  while($row = mysqli_fetch_array($result)){
    $alogros[$row['ID']][$row['modo']]=$row['logro'];
  }*/
  //print_r($alogros);
  /*  echo '$sPremios';
  print_r($sPremios);
  echo '$nPremios';
  print_r($nPremios);*/
  $result = mysqli_query($link, "Select * From  _Jugada_ani  Where Activo=1 and Esc=0 and  IDJ=" . $IDJ);
  //echo ("Select * From  _Jugada_ani  Where Activo=1 and Esc=0 and  IDJ=".$IDJ);
  while ($row = mysqli_fetch_array($result)) {
    $premio = array();
    $sumap = 0;
    $down = 0;
    $cerrar = true;
    $data = unserialize(decoBaseK($row['Jugada']));
    //  echo '  SERIAL:'.$row['serial'];echo '*';
    foreach ($data as $i => $value) {
      $ide = array_search($data[$i]->sorteo, $sPremios);
      //  echo $data[$i]->sorteo;echo '*';
      if ($ide === false) :
        $cerrar = false;
      else :
        //echo $nPremios[$ide];echo '*';echo $data[$i]->numero;echo '*';
        if (is_numeric($data[$i]->numero)) :
          if ($data[$i]->numero == '0') :
            $data[$i]->numero = "'" . $data[$i]->numero . "'";
          else :
            if ($data[$i]->numero == '00') :
              $data[$i]->numero = "'" . $data[$i]->numero . "'";
            endif;
          endif;
        endif;
        if ($nPremios[$ide] == $data[$i]->numero) :
          $result2n = mysqli_query($link, "Select * From  _Conf_premio  Where numero='" . $data[$i]->numero . "' and  ID=" . $data[$i]->sorteo);
          if (mysqli_num_rows($result2n) == 0) :

            $result2n = mysqli_query($link, "Select * From  _Conf_premio_esp  Where  numero='" . $data[$i]->numero . "' and  IDL=" . $akIDL[$data[$i]->sorteo]);
            if (mysqli_num_rows($result2n) == 0) :
              if ($akIDL[$data[$i]->sorteo] == 1) :
                $result2n = mysqli_query($link, "Select * From  _Concesionario_Ani  Where IDC='" . $row['IDC'] . "'");
              else :
                $result2n = mysqli_query($link, "Select * From  _Concesionario_Ani_2  Where IDL=" . $akIDL[$data[$i]->sorteo] . " and IDC='" . $row['IDC'] . "'");
              endif;
            endif;

            $row2n = mysqli_fetch_array($result2n);
            $logro = $row2n['iPremio'];

          else :
            $row2n = mysqli_fetch_array($result2n);
            $logro = $row2n['logro'];
          endif;
          $sumap += ($data[$i]->monto * $logro);
          $premio[] = array('n' => $data[$i]->numero, 'l' => $data[$i]->sorteo, 'p' => ($data[$i]->monto * $logro));
        //  print_r($premio);
        endif;
      endif;
    }
    /// Pagar segundo premio
    foreach ($data as $i => $value) {
      // echo '$xCode[$data[$i]->sorteo]='.$xCode[$data[$i]->sorteo];
      if (isset($xCode[$data[$i]->sorteo])) {
        if ($xCode[$data[$i]->sorteo] == '2') :
          $ide = array_search($data[$i]->sorteo, $sPremios);
          if ($ide !== false) :
            if ($nPremios1[$ide] == $data[$i]->numero) :
              $result2n = mysqli_query($link, "Select * From  _Concesionario_Ani_2  Where IDL=" . $akIDL[$data[$i]->sorteo] . " and IDC='" . $row['IDC'] . "'");
              $row2n = mysqli_fetch_array($result2n);
              $logro = $row2n['iPremio1'];

              $sumap += ($data[$i]->monto * $logro);
              $premio[] = array('n' => $data[$i]->numero, 'l' => $data[$i]->sorteo, 'p' => ($data[$i]->monto * $logro));
            endif;
          endif;
        endif;
      }
    }
    ////////////////////
    if ($sumap != 0) :
      $down = 0;
      $result2n = mysqli_query($link, "Select * From  _Jugada_ani_prem  Where serial=" . $row['serial']);
      if (mysqli_num_rows($result2n) == 0) :
        $result2n = mysqli_query($link, "Insert  _Jugada_ani_prem  values (" . $row['serial'] . "," . $sumap . ",'" . ecoBaseAnimalitos(serialize($premio)) . "')");
      else :
        $result2n = mysqli_query($link, "Update   _Jugada_ani_prem  set premio=" . $sumap . ",Jpremio='" . ecoBaseAnimalitos(serialize($premio)) . "' where serial=" . $row['serial']);
      endif;
    else :
      $result2n = mysqli_query($link, "Update _Jugada_ani_prem  set premio=0,Jpremio='' Where serial=" . $row['serial']);
    endif;
    if ($cerrar &&  $sumap == 0) :  $down = 1;
    endif;
    if ($cerrar) : $escrute = 1;
    else : $escrute = 0;
    endif;
    $result2n = mysqli_query($link, "Update _Jugada_ani  set Esc=" . $escrute . ", down=" . $down . " Where serial=" . $row['serial']);
  }
}
function _FechaDUK($Fecha = NULL, $Crear = 1)
{
  global $link;

  if (is_null($Fecha)) :
    $Fecha = FecharealAnimalitos(0, 'Y-m-d');
  else :
    $Fecha = _ConverFecha($Fecha);
  endif;
  $link = ConnectionAnimalitos::getInstance();



  $resultj = mysqli_query($link, "SELECT * FROM _Jornarda_fecha  Where Fecha='" . $Fecha . "'"); //echo ("SELECT * FROM _Jornarda_fecha  Where Fecha='".$Fecha."'");
  $IDJ = 0;
  if (@mysqli_num_rows($resultj) == 0) :
    $resultj = mysqli_query($link, "SELECT * FROM _Jornarda_fecha   Order by IDJ  DESC "); //echo "SELECT * FROM _Jornarda_fecha   Order by IDJ  DESC";
    if ($Crear == 1) :
      if (mysqli_num_rows($resultj) != 0) :
        $rowj = mysqli_fetch_array($resultj);
        $IDJ = $rowj["IDJ"] + 1;
      else :
        $IDJ = 1;
      endif;
    // $resultj = mysqli_query($link,"Insert _Jornarda_fecha values ($IDJ,'$Fecha')");
    endif;
  //// Copiar Jornadas Activas

  //$resultj = mysqli_query($link,"SELECT * FROM _JornadaStandar  Where Activo=1");
  //	while($row = mysqli_fetch_array($resultj)){
  //      $resultj2N = mysqli_query($link,"Insert _Jornada (	IDJ,IDJS,HoraCierre,Activa,CantidadNum ) values($IDJ,".$row['id'].",'".$row['Hora']."',0,36)");

  //      $resultj1N = mysqli_query($link,"SELECT * FROM _PremioStandar  ");
  //      while($row1N = mysqli_fetch_array($resultj1N)){
  //        $resultj2N = mysqli_query($link,"Insert _Conf_premio (	IDJ,modo,numero,logro ) values ($IDJ,".$row1N['modo'].",".$row1N['numero'].",".$row1N['logro'].")");
  //        }
  //  }



  else :
    $rowj = mysqli_fetch_array($resultj);
    $IDJ = $rowj["IDJ"];
  endif;


  return $IDJ;
}
function decoBaseLL($_decoParam)
{
  // Proceso DECODE param
  $_utxprm = urldecode(base64_decode($_decoParam));
  $_utxprm = explode(',', $_utxprm);
  // print_r($_utxprm);
  for ($i = 0; $i <= count($_utxprm) - 1; $i++) {
    $varibles = explode(':', $_utxprm[$i]);
    $_REQUEST[$varibles[0]] = $varibles[1];
  }
  // Fin Proceso DECODE

}
function decoBaseAnimalitos($_decoParam)
{
  // Proceso DECODE param
  $_utxprm = urldecode(base64_decode($_decoParam));
  $_utxprm = explode('|', $_utxprm);

  for ($i = 0; $i <= count($_utxprm) - 1; $i++) {
    $varibles = explode('=', $_utxprm[$i]);

    $_REQUEST[$varibles[0]] = $varibles[1];
  }
  // Fin Proceso DECODE

}
function ecoBaseAnimalitos($_ecoParam)
{
  // Proceso DECODE param
  $_utxprm = base64_encode(urlencode($_ecoParam));
  return $_utxprm;
}
function decoBaseK($_decoParam)
{
  // Proceso DECODE param

  $_utxprm = urldecode(base64_decode($_decoParam));

  return $_utxprm;
}
function bticketAnimalitos()
{
  global $link;

  $result2 = mysqli_query($link, "START TRANSACTION");
  $result2 = mysqli_query($link, "SELECT N_x  FROM _conteo Where Modulo='Ticket' FOR UPDATE");
  $result2 = mysqli_query($link, "UPDATE _conteo SET N_x = LAST_INSERT_ID(N_x + 1) Where Modulo='Ticket'");
  $result2 = mysqli_query($link, "SELECT LAST_INSERT_ID() as N_x;");
  $row2 = mysqli_fetch_array($result2);
  $result2 = mysqli_query($link, "COMMIT");

  $tik = $row2["N_x"];

  return $tik;
}
function getipAnimalitos()
{

  if (getenv('HTTP_X_FORWARDED_FOR')) {
    $realip = getenv('HTTP_X_FORWARDED_FOR');
  } elseif (getenv('HTTP_CLIENT_IP')) {
    $realip = getenv('HTTP_CLIENT_IP');
  } else {
    $realip = getenv('REMOTE_ADDR');
  }

  return $realip;
}

function _check_cierre_sorteo($usu)
{
  global $link;

  global $minutosh;
  global $minutosho;
  $IDJS_close = array();
  $Fechas[0] = FecharealAnimalitos($minutosh, 'Y-m-d');
  $resultj = mysqli_query($link, "SELECT * FROM _Jornarda_fecha ORDER BY _Jornarda_fecha.IDJ DESC LIMIT 0 , 2");
  while ($row1N = mysqli_fetch_array($resultj)) {
    if ($row1N['Fecha'] != $Fechas[0]) :
      $Fechas[1] = $row1N['Fecha'];
    endif;
  }

  for ($f = 0; $f <= count($Fechas) - 1; $f++) {
    $resultj = mysqli_query($link, "SELECT * FROM _Jornarda_fecha  Where Fecha='" . $Fechas[$f] . "'");
    if (mysqli_num_rows($resultj) != 0) :
      $rowj = mysqli_fetch_array($resultj);
      $IDJ = $rowj['IDJ'];
      $ip = getipAnimalitos();
      if (empty($ip) || !preg_match('/^(\d{1,3}\.){3}\d{1,3}$/s', $ip)) :
        if (isset($_SERVER["REMOTE_ADDR"]))
          $ip = $_SERVER["REMOTE_ADDR"];
        else
          $ip = 'localhost';
      endif;
      $FechaDIF = FecharealAnimalitos($minutosho, 'd/n/Y');
      $resultj = mysqli_query($link, "SELECT * FROM _Jornada  Where IDJ=" . $IDJ);
      while ($row1N = mysqli_fetch_array($resultj)) {
        if ($row1N['Activa'] == 1) :
          $resultj2n = mysqli_query($link, "SELECT * FROM _Cierre_Sorteo  Where ID=" . $row1N['ID']);
          if (mysqli_num_rows($resultj2n) == 0) :
            if ($f == 1) :
              $IDJS_close[] = $row1N['ID'];
              $resultj3n = mysqli_query($link, "Insert _Cierre_Sorteo (HoraC,ID,IP,Usu) values ('" . HorarealAnimalitos($minutosh, "H:i:s") . "'," . $row1N['ID'] . ",'" . $ip . "'," . $usu . ")");
            else :
              if (diferenciadehorasAnimalitos($FechaDIF, $FechaDIF, $row1N['HoraCierre'], HorarealAnimalitos($minutosh, "H:i:s"))) :
                $IDJS_close[] = $row1N['ID'];
                $resultj3n = mysqli_query($link, "Insert _Cierre_Sorteo (HoraC,ID,IP,Usu) values ('" . HorarealAnimalitos($minutosh, "H:i:s") . "'," . $row1N['ID'] . ",'" . $ip . "'," . $usu . ")");
              endif;
            endif;
          else :
            $IDJS_close[] = $row1N['ID'];
          endif;
        else :
          $IDJS_close[] = $row1N['ID'];
        endif;
      }
    else :
      return array(false);
    endif;
  }
  //print_r($IDJS_close);
  return $IDJS_close;
}

function diferenciadehorasAnimalitos($fecha1, $fecha2, $hora1, $hora2)
{
  $horaM = explode(":", $hora1);
  $fechaMK = explode("/", $fecha1);
  if ($horaM[2] == '') : $horaM[2] = 0;
  endif;
  $fechaMK1 = mktime($horaM[0], $horaM[1], $horaM[2], $fechaMK[1], $fechaMK[0], $fechaMK[2]);

  $horaM = explode(":", $hora2);
  $fechaMK = explode("/", $fecha2);
  if ($horaM[2] == '') : $horaM[2] = 0;
  endif;
  $fechaMK2 =  mktime($horaM[0], $horaM[1], $horaM[2], $fechaMK[1], $fechaMK[0], $fechaMK[2]);

  $respuesta = $fechaMK1 <= $fechaMK2;
  return $respuesta;
}
function _MontoDUK($data)
{

  $monto = 0;
  foreach ($data as $i => $value) {
    $mon = (float)$data[$i]->monto;
    $monto += $mon;
  }
  return $monto;
}
function _verSorteoTripleta($idSorteo)
{
  global $link;

  $resultj = mysqli_query($link, "SELECT * FROM _Jornada,_Loterias  Where _Jornada.IDL=_Loterias.IDL and ID=" . $idSorteo);
  $rowj = mysqli_fetch_array($resultj);
  $IDL = $rowj['IDL'];
  $IDJs = $rowj['IDJ'];
  $nomlott = $rowj['Nombre'];
  $ini_hour = $rowj['HoraCierre'];

  $resultjOb = mysqli_query($link, "SELECT * FROM _JornadaStandar  Where Hora='" .   $ini_hour . "' and IDL=" . $IDL);
  $rowjOb = mysqli_fetch_array($resultjOb);
  $ini_hour_real = $rowjOb['Descripcion'];


  $pointA = 0;
  $vuelta = 0;

  $resultj = mysqli_query($link, "SELECT * FROM _Jornarda_fecha  Where IDJ=" . $IDJs);
  $rowj = mysqli_fetch_array($resultj);
  $ini_date = $rowj['Fecha'];

  $next_date = new DateTime($ini_date);
  $next_date->add(new DateInterval('P1D'));
  $list_date = [$ini_date, $next_date->format('Y-m-d')];

  $list_hour = [];
  $list_hour[] = [$ini_hour, $list_date[$vuelta], $ini_hour_real];

  $resultj = mysqli_query($link, "SELECT * FROM _JornadaStandar  Where IDL=" . $IDL . " order by Hora");
  $all_sorteos = mysqli_fetch_all($resultj);


  while (count($list_hour) < count($all_sorteos)) {
    $pointB = count($list_hour) - 1;
    if ($all_sorteos[$pointA][1] == $list_hour[$pointB][0]) {
      $pointA++;
      if ($pointA >= count($all_sorteos)) {
        $pointA = 0;
        $vuelta++;
      }
      $list_hour[] = [$all_sorteos[$pointA][1], $list_date[$vuelta], $all_sorteos[$pointA][2]];
    } else {
      $pointA++;
    }
    if ($pointA > count($all_sorteos)) {
      $pointA = 0;
      $vuelta++;
    }
  }

  return [$list_hour,  $IDJs,  $IDL,  $nomlott];
}
function getDataSpecial($type)
{
  global $link;
  $sql = "Select * from _Type_bet where type=$type";
  $resultj = mysqli_query($link, $sql);

  if (mysqli_num_rows($resultj) != 0) :
    $rowj = mysqli_fetch_array($resultj);
    return [$rowj['description'], $rowj['maxnumber'], $rowj['siglas']];
  endif;

  return ['', 0, ''];
}
function _verSorteo($idSorteo, $IDJ, $IDC, $esp = 0)
{
  global $link;

  $datos = array();
  $resultj = mysqli_query($link, "SELECT * FROM _Jornada,_Loterias  Where _Jornada.IDL=_Loterias.IDL and ID=" . $idSorteo);
  if (mysqli_num_rows($resultj) != 0) :

    switch ($esp) {
      case 0:
        $rowj = mysqli_fetch_array($resultj);
        //  $resultj = mysqli_query($link,"SELECT * FROM _JornadaStandar  Where id=".$rowj['IDJS']);$rowj= mysqli_fetch_array($resultj);
        $datos[0] = convertirNormal($rowj['HoraCierre']) . '(' . $rowj['Nombre'] . ')'; // $rowj['Descripcion'];
        $IDL = $rowj['IDL'];
        $ID = $rowj['ID'];
        break;
      case 1:
        $getdata = getDataSpecial($esp);
        $datosTripleta = _verSorteoTripleta($idSorteo);
        $IDL =  $datosTripleta[2];
        $Lista = $datosTripleta[0];
        $DesdeSorteo = $Lista[0];
        $HastaSorteo = end($Lista);

        $HoraDesde = $DesdeSorteo[2];
        $HoraHasta = $HastaSorteo[2];

        $FechaDesde = substr(_ConverFechaT2($DesdeSorteo[1]), 0, 5);
        $FechaHasta = substr(_ConverFechaT2($HastaSorteo[1]), 0, 5);

        $datos[0] =  "#$getdata[0]# |$FechaDesde/$HoraDesde->$FechaHasta/$HoraHasta|($datosTripleta[3])"; // $rowj['Descripcion'];
    }
  endif;
  //$resultj = mysqli_query($link,"SELECT * FROM _Conf_premio  Where numero=-1 and modo=0 and ID=".$rowj['ID']);$rowj= mysqli_fetch_array($resultj);

  if ($IDL == 1) :
    $resultj = mysqli_query($link, "Select * From  _Concesionario_Ani  Where IDC='$IDC'");
  else :
    $resultj = mysqli_query($link, "Select * From  _Concesionario_Ani_2  Where IDC='$IDC' and IDL=" . $IDL);
  endif;
  if (mysqli_num_rows($resultj) != 0) :
    $rowj = mysqli_fetch_array($resultj);
    switch ($esp) {
      case 0:
        $datos[1] = $rowj['iPremio'];
        $datos[3] = $IDL == 1 ? 0 : $rowj['iPremio1'];
        $datos[4] = $IDL == 1 ? 0 : $rowj['iPremio2'];
        $datos[5] = 0;
        $resultj = mysqli_query($link, "Select * From  _Conf_premio_esp  Where IDL=$IDL");
        if (mysqli_num_rows($resultj) != 0) :
          $rowj = mysqli_fetch_array($resultj);
          $datos[5] = $rowj['iPremio'];
        endif;

        break;
      case 1:
        $datos[1] = $rowj['iPremioTripleta'];
        $datos[3] = 0;
        $datos[4] = 0;
        $datos[5] = 0;
    }
  else :
    $resultj = mysqli_query($link, "SELECT * FROM _Conf_premio  Where numero=-1 and modo=0 and ID=" . $ID);
    $rowj = mysqli_fetch_array($resultj);
    $datos[1] = $rowj['logro'];
    $datos[3] = 0;
    $datos[4] = 0;
    $datos[5] = 0;

  endif;
  $datos[2] = $IDL;


  return $datos;
}
function showPremioTicket($APremios, $sorteo,  $IDL)
{
  $TRIPLETA = '*TRP*';
  $Add = '';
  $b = '';
  foreach ($APremios as &$thipremios) {
    $thisPremio = 0;
    if ($thipremios['l'] == 0) :
      if ($thipremios['l1'] == $sorteo || $thipremios['l2'] == $sorteo || $thipremios['l3'] == $sorteo) :
        $Add = $TRIPLETA;
        $nLis =  _verAnimalito($thipremios['n1'] . ',' . $thipremios['n2'] . ',' . $thipremios['n3'], $IDL);
        $thisPremio = $thipremios['p'];
      endif;
    else :
      if ($thipremios['l'] == $sorteo) :
        $Add = '';
        $nLis = _verAnimalito($thipremios['n'], $IDL);
        $thisPremio = $thipremios['p'];
      endif;
    endif;
    if ($thisPremio != 0) {
      $NumerodePremio[] = implode(',', $nLis);
      $b .= '<tr><td colspan="4" align="center"><p align="center" style="font-weight: bold;">GANO CON:' . $Add . implode(',', $NumerodePremio) . ' PREMIO:' . $thisPremio . '</p></td></tr><tr>';
      $NumerodePremio = [];
    }
  }
  return $b;
}
function _verSorteoEsp($idSorteo)
{
  global $link;
  $resultj = mysqli_query($link, "SELECT * FROM _Jornada,_Loterias  Where _Jornada.IDL=_Loterias.IDL and ID=" . $idSorteo);
  if (mysqli_num_rows($resultj) != 0) :
    $rowj = mysqli_fetch_array($resultj);

    return [convertirNormal($rowj['HoraCierre']), $rowj['Nombre']];

  endif;
  return ['', ''];
}
function _verAnimalito($idAnimalito, $IDL)
{
  global $link;

  $lis = explode(',', $idAnimalito);
  $nLis = array();
  foreach ($lis as $idex => $value) {
    if (is_numeric($lis[$idex])) :
      if ($lis[$idex] == 0) :
        $nLis[] = "'" . $lis[$idex] . "'";
      else :
        if ($lis[$idex] == '00') :
          $nLis[] = "'" . $lis[$idex] . "'";
        else :
          $nLis[] = $lis[$idex];
        endif;
      endif;
    else :
      $nLis[] = $lis[$idex];
    endif;
  }
  $nombres = array();
  // print_r($nLis);
  // echo  implode(',', $nLis);
  // echo "*";
  // echo $IDL;
  // echo  "SELECT * FROM _NumeroAnimatios  Where num in (" . implode(',', $nLis) . ") and IDL=$IDL";
  $resultj = mysqli_query($link, "SELECT * FROM _NumeroAnimatios  Where num in (" . implode(',', $nLis) . ") and IDL=$IDL");
  //  echo "SELECT * FROM _NumeroAnimatios  Where num in ($idAnimalito) and IDL=$IDL";
  while ($row = mysqli_fetch_array($resultj))
    $nombres[] = $row['nombre'];

  return  $nombres;
}
function ticketDUK($serial, $fechaactual, $horaticket, $IDC, $se, $data, $ap, $IDJ, $MODO, $TU, $MND)
{
  global $link;

  // TU 1: PUNTO DE VENTA
  // TU 2: ADMINITRADOR O DE GRUPO
  // MODO 1: ORIGNAL
  // MODO 2: COPIA
  // MODO 3: VER TICKET
  //[{"numero": "0", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "0", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "0", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "0", "sorteo": "48", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "48", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "48", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "48", "monto": "10", "modo": 0}]
  $b = '';
  $habilitado = false;
  if ($MODO == 1 || $MODO == 2) :
    $b = '<table width="235" border="0" style="font-size:10px; font-family:Arial, Helvetica, sans-serif"> ';
    $b .= '<tr><td colspan="4" align="center"><p align="center">.:: Animalitos ::.</p></td></tr><tr>';
    $b .= '<td colspan="4">Serial:' . $serial . '</td></tr>';
    $b .= '<tr><td colspan="4">Fecha:' . $fechaactual . ' Hora:' . $horaticket . '</td></tr>';
    $b .= '<tr><td colspan="4">Agencia:' . $IDC . '</td></tr>';
    if ($MODO == 1) :
      $b .= '<tr><td colspan="4">S.E.:' . $se . ' CN:' . count($data) . '</td></tr>';
    else :
      $b .= '<tr><td colspan="4">ESTO ES UNA COPIA DEL TICKET</td></tr>';
    endif;
  endif;
  if ($MODO == 3) :
    $b = '<table  width="235" border="0" style="font-size:13px; font-family:Arial, Helvetica, sans-serif;color:#000000"> ';
    $b .= '<tr><td colspan="4" align="center"><br></td></tr><tr>';
    $b .= '<tr><td colspan="4" align="center"><p align="center">.:: Animalitos ::.</p></td></tr><tr>';
    $b .= '<tr><td colspan="4" align="center"><br></td></tr><tr>';
    $b .= '<td colspan="4"><p align="center" style="font-size:15px;">Serial:' . $serial . '</p></td></tr>';
    $b .= '<tr><td colspan="4" align="center"></td></tr><tr>';
    $ver = true;
    if ($TU == 1) :
      $resultj2n = mysqli_query($link, "SELECT * FROM _Concesionario_Ani WHERE  IDC='" . $IDC . "'");
      $row2n = mysqli_fetch_array($resultj2n);
      $iTkPagar = $row2n['iTkPagar'];

      if ($iTkPagar == 1) :
        $resultHB = mysqli_query($link, "SELECT * FROM _Jugada_ani_pagado WHERE serial=" . $serial);
        if (mysqli_num_rows($resultHB) != 0) : $ver = true;
        else :   $ver = false;
        endif;
      endif;
    endif;
    $APremios = array();
    $Premio = 0;
    if ($ver) :
      $resultj2n = mysqli_query($link, "SELECT * FROM _Jugada_ani_prem  Where serial=" . $serial);
      if (mysqli_num_rows($resultj2n) != 0) :
        $row2n = mysqli_fetch_array($resultj2n);
        $habilitado = true;
        $Premio = $row2n['premio'];
        $APremios = unserialize(decoBaseK($row2n['Jpremio']));
      // print_r($APremios);
      endif;
    endif;
  endif;


  $sorteo = 0;
  $columna = 1;
  $esp = 0;
  // print_r($data);
  // for ($i = 0; $i <= count($data); $i++) {
  foreach ($data as &$jug) {
    $d_esp = $jug->esp ?? 0;
    if ($sorteo != $jug->sorteo ||  $esp != $d_esp) :
      if ($columna == 2) $b .= '<td >|</td><td ></td></tr>';

      if ($MODO == 3) :
        if ($sorteo != 0) :
          $IDL = listLoteriByIDJ($jug->sorteo);
          $b .= showPremioTicket($APremios, $sorteo, $IDL);
        endif;
        $b .= '<tr><td colspan="4" align="center"><br></td></tr><tr>';
      endif;
      $columna = 1;
      $sorteo = $jug->sorteo;
      $esp = $jug->esp ?? 0;
      $datos = _verSorteo($sorteo, $IDJ, $IDC, $esp);
      // $b .= '<tr><td colspan="4"> <p align="center" style="font-weight: bold;">*' . $datos[0] . '-1x' . $datos[1] . '*</p></td></tr>';
      $b .= '<tr><td colspan="4"> <p align="center" style="font-weight: bold;">*' . $datos[0] . '*</p></td></tr>';
      $myPremio = "1er 1x" . $datos[1] . ($datos[3] != 0 ? " |2do 1x" . $datos[3] : "") . ($datos[4] != 0 ? " |3er 1x" . $datos[4] : "") . ($datos[5] != 0 ? " |Esp 1x" . $datos[5] : "");
      $b .= '<tr><td colspan="4"><p align="center" style="font-weight: bold;">*Premio ' . $myPremio . '*</p></td></tr>';
      if ($MODO == 2) :
        $b .= '<tr><td colspan="4">ESTO ES UNA COPIA DEL TICKET</td></tr>';
      endif;
    //$b.='<tr><td colspan="2">---------------------------------</td></tr>';
    endif;
    switch ($esp) {
      case 0:
        $nombre = _verAnimalito($jug->numero, $datos[2]);
        if ($columna == 1) :
          $b .= '<tr><td >|' . $nombre[0] . '</td ><td >#' . $jug->monto . '#</td>';
          $columna = 2;
        else :
          $b .= '<td >|' . $nombre[0] . '</td ><td >#' . $jug->monto . '#</td></tr>';
          $columna = 1;
        endif;
        break;
      case 1:
        $nombre = _verAnimalito($jug->numero1 . ',' . $jug->numero2 . ',' . $jug->numero3, $datos[2]);
        // if ($columna == 1) :
        $b .= '<tr><td colspan="3">|' . $nombre[0] . '/' . $nombre[1] . '/' . $nombre[2] . '</td ><td >#' . $jug->monto . '#</td></tr>';
        // $columna = 2;
        // else :
        //   $b .= '<td >|' . $nombre[0] . '/' . $nombre[1] . '/' . $nombre[2] . '</td ><td >#' . $jug->monto . '#</td></tr>';
        //   $columna = 1;
        // endif;
        break;
        // case '2':
        //   $nombre = _verAnimalito($jug->numero1 . ',' . $jug->numero2 . ',' . $jug->numero3, $datos[2]);
        //   if ($columna == 1) :
        //     $b .= '<tr><td >|' . $nombre[0] . '/' . $nombre[1] . '/' . $nombre[2] . '</td ><td >#' . $jug->monto . '#</td>';
        //     $columna = 2;
        //   else :
        //     $b .= '<td >|' . $nombre[0] . '/' . $nombre[1] . '/' . $nombre[2] . '</td ><td >#' . $jug->monto . '#</td></tr>';
        //     $columna = 1;
        //   endif;
        //   break;
    }
  }
  if ($MODO == 3) :
    if ($sorteo != 0) :
      if ($habilitado) {
        if ($APremios[0]['l'] == 0)  $sorteo = $APremios[0]['l1'];
      }
      $b .= showPremioTicket($APremios, $sorteo, $datos[2]);

    // foreach ($APremios as $s => $vs) {
    //   if ($APremios[$s]['l'] == $sorteo) :
    //     $nLis = _verAnimalito($APremios[$s]['n'], $datos[2]);
    //     $NumerodePremio[] = implode(',', $nLis);
    //     $b .= '<tr><td colspan="4" align="center"><p align="center" style="font-weight: bold;">GANO CON:' . implode(',', $NumerodePremio) . ' PREMIO:' . $APremios[$s]['p'] . '</p></td></tr><tr>';
    //   endif;
    // }
    endif;
  endif;
  if ($MODO == 1 || $MODO == 2) :
    $b .= '<tr><td colspan="4">--------------------------------</td></tr>';
  else :
    $b .= '<tr><td colspan="4"><br></td></tr>';
    $b .= '<tr><td colspan="4"><br></td></tr>';
  endif;
  $b .= '<tr><td colspan="4"><p style="font-size:15px;">Total Ticket: ' .  number_format($ap, 2, ',', '.') . '</p></td></tr>';
  if ($MODO == 3) :
    if ($ver) :
      $b .= '<tr><td colspan="4" align="center"><br></td></tr><tr>';
      $b .= '<tr><td colspan="4"><p style="font-size:15px;">A Pagar: ' .  number_format($Premio, 2, ',', '.') . '</p></td></tr>';
    endif;
  endif;
  if ($MODO == 2) :
    $b .= '<tr><td colspan="4">ESTO ES UNA COPIA DEL TICKET</td></tr>';
  endif;
  if ($MODO == 1 || $MODO == 2) :
    $b .= '<tr><td colspan="4">***** VERIFIQUE SU JUGADA *****</td></tr>';
    $resultj = mysqli_query($link, "SELECT * FROM _Adedum_Ticket  Where Activo=1 order by l");
    while ($row = mysqli_fetch_array($resultj)) {
      $b .= '<tr><td colspan="4"><p align="center">' . $row['texto'] . '</p></td></tr>';
    }
    $b .= '<tr><td colspan="4">-</td></tr>';
    $b .= '<tr><td colspan="4">-</td></tr>';
  endif;
  $b .= '</table>';

  return $b;
}
// function ticketDUK($serial, $fechaactual, $horaticket, $IDC, $se, $data, $ap, $IDJ, $MODO, $TU)
// {
//   global $link;

//   // TU 1: PUNTO DE VENTA
//   // TU 2: ADMINITRADOR O DE GRUPO
//   // MODO 1: ORIGNAL
//   // MODO 2: COPIA
//   // MODO 3: VER TICKET
//   //[{"numero": "0", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "0", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "0", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "0", "sorteo": "48", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "48", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "48", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "48", "monto": "10", "modo": 0}]
//   $b = '';
//   if ($MODO == 1 || $MODO == 2) :
//     $b = '<table width="235" border="0" style="font-size:10px; font-family:Arial, Helvetica, sans-serif"> ';
//     $b .= '<tr><td colspan="4" align="center"><p align="center">.:: Animalitos ::.</p></td></tr><tr>';
//     $b .= '<td colspan="4">Serial:' . $serial . '</td></tr>';
//     $b .= '<tr><td colspan="4">Fecha:' . $fechaactual . ' Hora:' . $horaticket . '</td></tr>';
//     $b .= '<tr><td colspan="4">Agencia:' . $IDC . '</td></tr>';
//     if ($MODO == 1) :
//       $b .= '<tr><td colspan="4">S.E.:' . $se . ' CN:' . count($data) . '</td></tr>';
//     else :
//       $b .= '<tr><td colspan="4">ESTO ES UNA COPIA DEL TICKET</td></tr>';
//     endif;
//   endif;
//   if ($MODO == 3) :
//     $b = '<table  width="235" border="0" style="font-size:13px; font-family:Arial, Helvetica, sans-serif;color:#000000"> ';
//     $b .= '<tr><td colspan="4" align="center"><br></td></tr><tr>';
//     $b .= '<tr><td colspan="4" align="center"><p align="center">.:: Animalitos ::.</p></td></tr><tr>';
//     $b .= '<tr><td colspan="4" align="center"><br></td></tr><tr>';
//     $b .= '<td colspan="4"><p align="center" style="font-size:15px;">Serial:' . $serial . '</p></td></tr>';
//     $b .= '<tr><td colspan="4" align="center"></td></tr><tr>';
//     $ver = true;
//     if ($TU == 1) :
//       $resultj2n = mysqli_query($link, "SELECT * FROM _Concesionario_Ani WHERE  IDC='" . $IDC . "'");
//       $row2n = mysqli_fetch_array($resultj2n);
//       $iTkPagar = $row2n['iTkPagar'];

//       if ($iTkPagar == 1) :
//         $resultHB = mysqli_query($link, "SELECT * FROM _Jugada_ani_pagado WHERE serial=" . $serial);
//         if (mysqli_num_rows($resultHB) != 0) : $ver = true;
//         else :   $ver = false;
//         endif;
//       endif;
//     endif;
//     $APremios = array();
//     $Premio = 0;
//     if ($ver) :
//       $resultj2n = mysqli_query($link, "SELECT * FROM _Jugada_ani_prem  Where serial=" . $serial);
//       if (mysqli_num_rows($resultj2n) != 0) :
//         $row2n = mysqli_fetch_array($resultj2n);
//         $habilitado = true;
//         $Premio = $row2n['premio'];
//         $APremios = unserialize(decoBaseK($row2n['Jpremio']));
//       // print_r($APremios);
//       endif;
//     endif;
//   endif;


//   $sorteo = 0;
//   $columna = 1;
//   // print_r($data);
//   // for ($i = 0; $i <= count($data); $i++) {
//   foreach ($data as &$jug) {
//     if ($sorteo != $jug->sorteo) :
//       if ($columna == 2) $b .= '<td >|</td><td ></td></tr>';

//       if ($MODO == 3) :
//         if ($sorteo != 0) :
//           // foreach ($APremios as $s => $vs) {
//           // print_r($APremios);
//           // for ($s = 0; $s < count($APremios); $s++) {
//           foreach ($APremios as &$thipremios) {
//             if ($thipremios['l'] == $sorteo) :
//               $IDL = listLoteriByIDJ($jug->sorteo);
//               $nLis = _verAnimalito($thipremios['n'], $IDL);
//               $NumerodePremio[] = implode(',', $nLis);
//               $b .= '<tr><td colspan="4" align="center"><p align="center" style="font-weight: bold;">GANO CON:' . implode(',', $NumerodePremio) . ' PREMIO:' . $thipremios['p'] . '</p></td></tr><tr>';
//               $NumerodePremio = array();
//             endif;
//           }
//         endif;
//         $b .= '<tr><td colspan="4" align="center"><br></td></tr><tr>';
//       endif;
//       $columna = 1;
//       $sorteo = $jug->sorteo;
//       $datos = _verSorteo($sorteo, $IDJ, $IDC);
//       // $b .= '<tr><td colspan="4"> <p align="center" style="font-weight: bold;">*' . $datos[0] . '-1x' . $datos[1] . '*</p></td></tr>';
//       $b .= '<tr><td colspan="4"> <p align="center" style="font-weight: bold;">*' . $datos[0] . '*</p></td></tr>';
//       $myPremio = "1er 1x" . $datos[1] . ($datos[3] != 0 ? " |2do 1x" . $datos[3] : "") . ($datos[4] != 0 ? " |3er 1x" . $datos[4] : "");
//       $b .= '<tr><td colspan="4"><p align="center" style="font-weight: bold;">*Premio ' . $myPremio . '*</p></td></tr>';
//       if ($MODO == 2) :
//         $b .= '<tr><td colspan="4">ESTO ES UNA COPIA DEL TICKET</td></tr>';
//       endif;
//     //$b.='<tr><td colspan="2">---------------------------------</td></tr>';
//     endif;

//     switch ($jug->modo) {
//       case '0':
//         $nombre = _verAnimalito($jug->numero, $datos[2]);
//         if ($columna == 1) :
//           $b .= '<tr><td >|' . $nombre[0] . '</td ><td >#' . $jug->monto . '#</td>';
//           $columna = 2;
//         else :
//           $b .= '<td >|' . $nombre[0] . '</td ><td >#' . $jug->monto . '#</td></tr>';
//           $columna = 1;
//         endif;
//         break;
//       case '1':
//         $nombre = _verAnimalito($jug->numero1 . ',' . $jug->numero2, $datos[2]);
//         if ($columna == 1) :
//           $b .= '<tr><td >|' . $nombre[0] . '/' . $nombre[1] . '</td ><td >#' . $jug->monto . '#</td>';
//           $columna = 2;
//         else :
//           $b .= '<td >|' . $nombre[0] . '/' . $nombre[1] . '</td ><td >#' . $jug->monto . '#</td></tr>';
//           $columna = 1;
//         endif;
//         break;
//       case '2':
//         $nombre = _verAnimalito($jug->numero1 . ',' . $jug->numero2 . ',' . $jug->numero3, $datos[2]);
//         if ($columna == 1) :
//           $b .= '<tr><td >|' . $nombre[0] . '/' . $nombre[1] . '/' . $nombre[2] . '</td ><td >#' . $jug->monto . '#</td>';
//           $columna = 2;
//         else :
//           $b .= '<td >|' . $nombre[0] . '/' . $nombre[1] . '/' . $nombre[2] . '</td ><td >#' . $jug->monto . '#</td></tr>';
//           $columna = 1;
//         endif;
//         break;
//     }
//   }

//   if ($MODO == 3) :
//     if ($sorteo != 0) :
//       foreach ($APremios as $s => $vs) {
//         if ($APremios[$s]['l'] == $sorteo) :
//           $nLis = _verAnimalito($APremios[$s]['n'], $datos[2]);
//           $NumerodePremio[] = implode(',', $nLis);
//           $b .= '<tr><td colspan="4" align="center"><p align="center" style="font-weight: bold;">GANO CON:' . implode(',', $NumerodePremio) . ' PREMIO:' . $APremios[$s]['p'] . '</p></td></tr><tr>';
//         endif;
//       }
//     endif;
//   endif;
//   if ($MODO == 1 || $MODO == 2) :
//     $b .= '<tr><td colspan="4">--------------------------------</td></tr>';
//   else :
//     $b .= '<tr><td colspan="4"><br></td></tr>';
//     $b .= '<tr><td colspan="4"><br></td></tr>';
//   endif;
//   $b .= '<tr><td colspan="4"><p style="font-size:15px;">Total Ticket: ' . number_format($ap, 2, ',', '.') . '</p></td></tr>';
//   if ($MODO == 3) :
//     if ($ver) :
//       $b .= '<tr><td colspan="4" align="center"><br></td></tr><tr>';
//       $b .= '<tr><td colspan="4"><p style="font-size:15px;">A Pagar: ' . number_format($Premio, 2, ',', '.') . '</p></td></tr>';
//     endif;
//   endif;
//   if ($MODO == 2) :
//     $b .= '<tr><td colspan="4">ESTO ES UNA COPIA DEL TICKET</td></tr>';
//   endif;
//   if ($MODO == 1 || $MODO == 2) :
//     $b .= '<tr><td colspan="4">***** VERIFIQUE SU JUGADA *****</td></tr>';
//     $resultj = mysqli_query($link, "SELECT * FROM _Adedum_Ticket  Where Activo=1 order by l");
//     while ($row = mysqli_fetch_array($resultj)) {
//       $b .= '<tr><td colspan="4"><p align="center">' . $row['texto'] . '</p></td></tr>';
//     }
//     $b .= '<tr><td colspan="4">-</td></tr>';
//     $b .= '<tr><td colspan="4">-</td></tr>';
//   endif;
//   $b .= '</table>';

//   return $b;
// }
function _Vericacion_Anulacion($data, $idj)
{
  global $link;

  $lSorteo = array();
  foreach ($data as $i => $value) {
    if (!in_array($data[$i]->sorteo, $lSorteo)) :
      $lSorteo[] = $data[$i]->sorteo;
    endif;
  }
  $cerrado = false;
  for ($i = 0; $i <= count($lSorteo) - 1; $i++) {
    $resultj2n = mysqli_query($link, "SELECT * FROM _Cierre_Sorteo  Where ID=" . $lSorteo[$i]);
    if (mysqli_num_rows($resultj2n) != 0) :
      $cerrado = true;
      break;
    endif;
  }
  if (!$cerrado) :
    $Fecha = FecharealAnimalitos(0, 'Y-m-d');
    $resultj = mysqli_query($link, "SELECT * FROM _Jornarda_fecha  Where Fecha='" . $Fecha . "'");
    $rowj = mysqli_fetch_array($resultj);
    if ($idj != $rowj['IDJ'])   $cerrado = true;
  endif;
  return $cerrado;
}
function viewIDJND($IDJ)
{
  global $link;

  $viwI = array();
  $resultj1n = mysqli_query($link, "SELECT * FROM _Jornada  Where IDJ=" . $IDJ);
  while ($row1N = mysqli_fetch_array($resultj1n)) {
    $horaSearch = $row1N['HoraCierre'];
    $resultj = mysqli_query($link, "SELECT * FROM _JornadaStandar  Where Hora='" . $horaSearch . "'");
    $row = mysqli_fetch_array($resultj);
    $viwI[$row1N['ID']] = $row['id'];
  }
  return $viwI;
}
function _NowMonitor($IDJ, $IDS)
{
  global $link;

  $MonitorArr = array();
  /*$mID=array();
  $result = mysqli_query($link,"Select * From  _Jornada  Where IDL=$IDL and  IDJ=".$IDJ);
  while($Row = mysqli_fetch_array($result)) $mID[]=$Row['ID'];*/

  $result = mysqli_query($link, "Select * From  _Jugada_ani  Where Activo=1  and  IDJ=" . $IDJ);
  while ($Row = mysqli_fetch_array($result)) {
    $data = unserialize(decoBaseK($Row['Jugada']));

    foreach ($data as $i => $value) {

      switch ($data[$i]->modo) {
        case 0:
          if ($data[$i]->sorteo == $IDS) :
            $numero = $data[$i]->numero;
            $sorteo = $data[$i]->sorteo;
            $monto = $data[$i]->monto;
            if (isset($MonitorArr[$sorteo][$numero])) :
              $MonitorArr[$sorteo][$numero]['monto'] += $monto;
              $MonitorArr[$sorteo][$numero]['tk']++;
            else :
              $MonitorArr[$sorteo][$numero] = array('monto' => $monto, 'tk' => 1);
            endif;
          endif;
          break;

        case 1:
          break;
      }
    }
  }

  return $MonitorArr;
}
function AutoEscrute($numeroMaximo)
{
  //  $numeroMaximo=array($numeroMaximoS,$numeroMaximoS,$numeroMaximoS)
  $NumeroGanador = array();
  $cant = count($numeroMaximo);
  $i = 0;
  $condicion = true;
  while ($condicion) {
    $NumeroG = rand(1, $numeroMaximo[$i]);
    if ($i != 0) :
      if (in_array($NumeroG, $NumeroGanador)) :
        continue;
      else :
        $NumeroGanador[$i] = $NumeroG;
      endif;
    else :
      $NumeroGanador[$i] = $NumeroG;
    endif;
    $i++;
    if ($i == $cant) $condicion = false;
  }

  return $NumeroGanador;
}
$IDLxIDD = [];
function listLoteriByIDJ($IDSorteo)
{
  global $link;


  $resultj1n = mysqli_query($link, "SELECT * FROM _Jornada  Where ID=$IDSorteo");
  if (mysqli_num_rows($resultj1n) != 0) {
    $row1N = mysqli_fetch_array($resultj1n);
    return $row1N['IDL'];
  }
  // $ID = $row1N['ID'];
  //   $IDLxIDD[$ID] = $row1N['IDL'];
  // }

  return 0;
}
function modeDetectAnimalitos()
{
  $fileDeploy = "/deploy.env";

  if (file_exists(".." . $fileDeploy)) {
    return 1;
  } elseif (file_exists("." . $fileDeploy)) {
    return 1;
  }

  return 0;
}
function getTripleta($IDL)
{
  global $link;
  $resultjAnimalitos  = mysqli_query($link, "SELECT * FROM _NumeroAnimatios where num ='-1' and IDL = " . $IDL);
  return (mysqli_num_rows($resultjAnimalitos) != 0);
}
function getLottery($IDL)
{
  global $link;
  $resul = mysqli_query($link, "SELECT * from _Loterias where IDL=$IDL");
  $row = mysqli_fetch_array($resul);
  return $row['Nombre'];
}

function getMoneda($idc, $thisLink)
{
  $moneda = "?";
  $result2 = mysqli_query($thisLink, "SELECT sbmonedas.* FROM _tconsecionario,sbmonedas where _tconsecionario.idm=sbmonedas.id and IDC='" . $idc . "'");
  if (mysqli_num_rows($result2) != 0) {
    $row2 = mysqli_fetch_array($result2);
    $moneda = $row2['moneda'];
  }
  return $moneda;
}



function reciboDUK($serial, $fechaactual, $horaticket, $IDC, $se, $data, $ap, $IDJ, $MODO, $TU)
{
  global $link;

  $dataWs = [];

  // TU 1: PUNTO DE VENTA
  // TU 2: ADMINITRADOR O DE GRUPO
  // MODO 1: ORIGNAL
  // MODO 2: COPIA
  // MODO 3: VER TICKET
  //[{"numero": "0", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "41", "monto": "10", "modo": 0}, {"numero": "0", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "43", "monto": "10", "modo": 0}, {"numero": "0", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "45", "monto": "10", "modo": 0}, {"numero": "0", "sorteo": "48", "monto": "10", "modo": 0}, {"numero": "00", "sorteo": "48", "monto": "10", "modo": 0}, {"numero": "01", "sorteo": "48", "monto": "10", "modo": 0}, {"numero": "06", "sorteo": "48", "monto": "10", "modo": 0}]
  $b = '';
  if ($MODO == 1 || $MODO == 2) :
    $b = '<table width="235" border="0" style="font-size:10px; font-family:Arial, Helvetica, sans-serif"> ';
    $b .= '<tr><td colspan="4" align="center"><p align="center"  style="font-size:20px;font-weight: bold;">TICKET #' . $serial . '</p></td></tr><tr>';
    if ($MODO != 1) :
      // $b .= '<tr><td colspan="4">S.E.:' . $se . ' CN:' . count($data) . '</td></tr>';
      // else :
      $b .= '<tr><td colspan="4">ESTO ES UNA COPIA DEL TICKET</td></tr>';
    endif;
  endif;
  if ($MODO == 3) :
    $b = '<table  width="235" border="0" style="font-size:13px; font-family:Arial, Helvetica, sans-serif;color:#000000"> ';
    $b .= '<tr><td colspan="4" align="center"><br></td></tr><tr>';
    $b .= '<tr><td colspan="4" align="center"><p align="center">.:: Animalitos ::.</p></td></tr><tr>';
    $b .= '<tr><td colspan="4" align="center"><br></td></tr><tr>';
    $b .= '<td colspan="4"><p align="center" style="font-size:15px;">Serial:' . $serial . '</p></td></tr>';
    $b .= '<tr><td colspan="4" align="center"></td></tr><tr>';
    $ver = true;
    if ($TU == 1) :
      $resultj2n = mysqli_query($link, "SELECT * FROM _Concesionario_Ani WHERE  IDC='" . $IDC . "'");
      $row2n = mysqli_fetch_array($resultj2n);
      $iTkPagar = $row2n['iTkPagar'];

      if ($iTkPagar == 1) :
        $resultHB = mysqli_query($link, "SELECT * FROM _Jugada_ani_pagado WHERE serial=" . $serial);
        if (mysqli_num_rows($resultHB) != 0) : $ver = true;
        else :   $ver = false;
        endif;
      endif;
    endif;
    $APremios = array();
    $Premio = 0;
    if ($ver) :
      $resultj2n = mysqli_query($link, "SELECT * FROM _Jugada_ani_prem  Where serial=" . $serial);
      if (mysqli_num_rows($resultj2n) != 0) :
        $row2n = mysqli_fetch_array($resultj2n);
        $habilitado = true;
        $Premio = $row2n['premio'];
        $APremios = unserialize(decoBaseK($row2n['Jpremio']));
      // print_r($APremios);
      endif;
    endif;
  endif;


  $sorteo = 0;
  $columna = 1;
  $esp = 0;

  // print_r($data);
  // for ($i = 0; $i <= count($data); $i++) {
  foreach ($data as &$jug) {
    $d_esp = $jug->esp ?? 0;
    if ($sorteo != $jug->sorteo ||  $esp != $d_esp) :
      if ($columna == 2) $b .= '<td >|</td><td ></td></tr>';

      if ($MODO == 3) :
        if ($sorteo != 0) :
          // foreach ($APremios as $s => $vs) {
          // print_r($APremios);
          // for ($s = 0; $s < count($APremios); $s++) {
          foreach ($APremios as &$thipremios) {
            if ($thipremios['l'] == $sorteo) :
              $IDL = listLoteriByIDJ($jug->sorteo);
              $nLis = _verAnimalito($thipremios['n'], $IDL);
              $NumerodePremio[] = implode(',', $nLis);
              $b .= '<tr><td colspan="4" align="center"><p align="center" style="font-weight: bold;">GANO CON:' . implode(',', $NumerodePremio) . ' PREMIO:' . $thipremios['p'] . '</p></td></tr><tr>';
              $NumerodePremio = array();
            endif;
          }
        endif;
        $b .= '<tr><td colspan="4" align="center"><br></td></tr><tr>';
      endif;
      $columna = 1;
      $sorteo = $jug->sorteo;
      $esp = $jug->esp ?? 0;
      $datos = _verSorteo($sorteo, $IDJ, $IDC, $esp);
      // $b .= '<tr><td colspan="4"> <p align="center" style="font-weight: bold;">*' . $datos[0] . '-1x' . $datos[1] . '*</p></td></tr>';
      $b .= '<tr><td colspan="4" style="font-weight: bold;background:#d6d3d3"  align="center">*' . $datos[0] . '*</td></tr>';
      $myPremio = "1er 1x" . $datos[1] . ($datos[3] != 0 ? " |2do 1x" . $datos[3] : "") . ($datos[4] != 0 ? " |3er 1x" . $datos[4] : "") . ($datos[5] != 0 ? " |Esp 1x" . $datos[5] : "");
      $b .= '<tr><td colspan="4"  style="font-weight: bold;" align="center">*Premio ' . $myPremio . '*</td></tr>';

      $dataWs[] = ["level" => 0, "title" => "", "info1" => $datos[0], "info2" => ""];
      $dataWs[] = ["level" => 1, "title" => "Premio", "info1" => $myPremio, "info2" => ""];

      if ($MODO == 2) :
        $b .= '<tr><td colspan="4">ESTO ES UNA COPIA DEL TICKET</td></tr>';
      endif;
    //$b.='<tr><td colspan="2">---------------------------------</td></tr>';
    endif;

    switch ($esp) {
      case 0:
        $nombre = _verAnimalito($jug->numero, $datos[2]);
        if ($columna == 1) :
          $b .= '<tr><td >|' . $nombre[0] . '</td ><td >#' . $jug->monto . '#</td>';
          $columna = 2;
        else :
          $b .= '<td >|' . $nombre[0] . '</td ><td >#' . $jug->monto . '#</td></tr>';
          $columna = 1;
        endif;
        $dataWs[] = ["level" => 2, "title" => "", "info1" =>  $nombre[0], "info2" => $jug->monto];

        break;
      case 1:
        $nombre = _verAnimalito($jug->numero1 . ',' . $jug->numero2 . ',' . $jug->numero3, $datos[2]);
        // if ($columna == 1) :
        $b .= '<tr><td colspan="3">|' . $nombre[0] . '/' . $nombre[1] . '/' . $nombre[2] . '</td ><td >#' . $jug->monto . '#</td></tr>';
        $dataWs[] = ["level" => 2, "title" => "", "info1" => $nombre[0] . '/' . $nombre[1] . '/' . $nombre[2], "info2" => $jug->monto];
        // $columna = 2;
        // else :
        //   $b .= '<td >|' . $nombre[0] . '/' . $nombre[1] . '/' . $nombre[2] . '</td ><td >#' . $jug->monto . '#</td></tr>';
        //   $columna = 1;
        // endif;
        break;
        // case '1':
        //   $nombre = _verAnimalito($jug->numero1 . ',' . $jug->numero2, $datos[2]);
        //   if ($columna == 1) :
        //     $b .= '<tr><td >|' . $nombre[0] . '/' . $nombre[1] . '</td ><td >#' . $jug->monto . '#</td>';
        //     $columna = 2;
        //   else :
        //     $b .= '<td >|' . $nombre[0] . '/' . $nombre[1] . '</td ><td >#' . $jug->monto . '#</td></tr>';
        //     $columna = 1;
        //   endif;
        //   $dataWs[] = ["level" => 2, "title" => "", "info1" => $nombre[0] . '/' . $nombre[1], "info2" => $jug->monto];

        //   break;
        // case '2':
        //   $nombre = _verAnimalito($jug->numero1 . ',' . $jug->numero2 . ',' . $jug->numero3, $datos[2]);
        //   if ($columna == 1) :
        //     $b .= '<tr><td >|' . $nombre[0] . '/' . $nombre[1] . '/' . $nombre[2] . '</td ><td >#' . $jug->monto . '#</td>';
        //     $columna = 2;
        //   else :
        //     $b .= '<td >|' . $nombre[0] . '/' . $nombre[1] . '/' . $nombre[2] . '</td ><td >#' . $jug->monto . '#</td></tr>';
        //     $columna = 1;
        //   endif;
        //   $dataWs[] = ["level" => 2, "title" => "", "info1" => $nombre[0] . '/' . $nombre[1] . '/' . $nombre[2], "info2" => $jug->monto];

        //   break;
    }
  }

  if ($MODO == 3) :
    if ($sorteo != 0) :
      if ($habilitado) {
        if ($APremios[0]['l'] == 0)  $sorteo = $APremios[0]['l1'];
      }
      $b .= showPremioTicket($APremios, $sorteo, $datos[2]);
    // foreach ($APremios as $s => $vs) {
    //   if ($APremios[$s]['l'] == $sorteo) :
    //     $nLis = _verAnimalito($APremios[$s]['n'], $datos[2]);
    //     $NumerodePremio[] = implode(',', $nLis);
    //     $b .= '<tr><td colspan="4" align="center"><p align="center" style="font-weight: bold;">GANO CON:' . implode(',', $NumerodePremio) . ' PREMIO:' . $APremios[$s]['p'] . '</p></td></tr><tr>';
    //   endif;
    // }
    endif;
  endif;
  if ($MODO == 1 || $MODO == 2) :
  // $b .= '<tr><td colspan="4">--------------------------------</td></tr>';
  else :
    $b .= '<tr><td colspan="4"><br></td></tr>';
    $b .= '<tr><td colspan="4"><br></td></tr>';
  endif;
  $b .= '<tr><td colspan="4"  align="center"><p style="font-size:18px;">Total ' . number_format($ap, 2, ',', '.') . '</p></td></tr>';
  $dataWs[] = ["level" => 3, "title" => "Total Ticket", "info1" => number_format($ap, 2, ',', '.'), "info2" => ""];

  if ($MODO == 3) :
    if ($ver) :
      $b .= '<tr><td colspan="4" align="center"><br></td></tr><tr>';
      $b .= '<tr><td colspan="4"><p style="font-size:15px;">A Pagar: ' . number_format($Premio, 2, ',', '.') . '</p></td></tr>';
    endif;
  endif;
  if ($MODO == 2) :
    $b .= '<tr><td colspan="4">ESTO ES UNA COPIA DEL TICKET</td></tr>';
  endif;
  if ($MODO == 1 || $MODO == 2) :
  // $b .= '<tr><td colspan="4">***** VERIFIQUE SU JUGADA *****</td></tr>';
  // $resultj = mysqli_query($link, "SELECT * FROM _Adedum_Ticket  Where Activo=1 order by l");
  // while ($row = mysqli_fetch_array($resultj)) {
  //   $b .= '<tr><td colspan="4"><p align="center">' . $row['texto'] . '</p></td></tr>';
  // }
  // $b .= '<tr><td colspan="4">-</td></tr>';
  // $b .= '<tr><td colspan="4">-</td></tr>';
  endif;
  $b .= '</table>';

  return ["recibo" => $b, "dataws" => $dataWs];
}

// include_once "typedef.php";


$TYPE_VENTA = 1;
$TYPE_PREMIO = 2;
$TYPE_SALDO = 3;
$TYPE_REVERSO = 5;
$TYPE_PREMIO_REVERSO = 5;
$MSG_NO_AVALIBLE_CREDIT = 'No tiene credito DISPONIBLE';
$token = 'w8D3rTzCrxw968OhtanyMdOUC9AMYe3L';
$API_REST = $mode == $MODE_PRODUCTION ?  'https://credito.betgambler.net:3145' : 'http://localhost:3145';

function BackendCredito($IDC, $Serial, $Monto, $Tipo, $deb)
{
  global $MSG_NO_AVALIBLE_CREDIT;

  $DebitarSaldo = $deb === '' ? SSALDO : $deb;

  $IDCwithCredit = ListCredit($IDC);

  if ($IDCwithCredit === false) :
    return ['err' => true, 'mensaje' => $MSG_NO_AVALIBLE_CREDIT];
  endif;

  global $TYPE_PREMIO;
  global $TYPE_VENTA;
  global $TYPE_SALDO;
  global $token;
  global $API_REST;


  $Saldo = 0;
  $transacc = 'nil';
  if ($Tipo == $TYPE_SALDO) :

    $IDcSaldo = showSaldo($IDC, $DebitarSaldo);
    if (count($IDcSaldo) == 0) {
      return ['err' => true, 'mensaje' => $MSG_NO_AVALIBLE_CREDIT];
    }

    $Saldo = $IDcSaldo['saldo'];
    return ['err' => false, 'saldo' => $Saldo, 'monto' => $Monto, 'mensaje' => '', 'transacc' => $transacc];

  else :
    $API_VENTA = '/apply';
    $URL = $API_REST . $API_VENTA;
    $Data = [
      'idc' => $IDC,
      'monto' => $Monto,
      'serial' => $Serial,
      'tipo' => $Tipo,
      'deb' => $DebitarSaldo,
      'sys' => 1
    ];
    $Response = endPoint($URL, 'PUT', $Data, $token);
    $Error = $Response['err'];

    if (!$Error) {
      $Saldo = $Response['saldo'];
      $transacc = $Response['transacc'];
      return ['err' => false, 'saldo' => $Saldo, 'monto' => $Monto, 'mensaje' => '', 'transacc' => $transacc];
    }

    $Mensaje = $Response['msg'];
    return ['err' => true, 'mensaje' => $Mensaje];
  endif;
}
function ListCredit($IDC)
{
  $conexion = conectMaster();

  $sql = "SELECT * FROM _tbcredito where IDC='$IDC'";
  $q = mysqli_query($conexion, $sql);
  if (mysqli_num_rows($q) == 0) {
    return false;
  }
  $r = mysqli_fetch_array($q);

  return $r[0];
}

function ReverSerialWin($IDJ)
{
  global $link;

  global $TYPE_PREMIO_REVERSO;
  $IDCwithCredit = ListCredit();
  $joinIdc = '';
  foreach ($IDCwithCredit as $a) {
    $joinIdc = $joinIdc . '"' . $a . '",';
  }
  $joinIdc = trim($joinIdc, ',');

  $sqlReverse = 'Select * from tbljgdprnk where IDC in (' . $joinIdc . ") and activo = 1 and idj=$IDJ";
  $resultReverse = mysqli_query($GLOBALS['link'], $sqlReverse);
  while ($rowReverse = mysqli_fetch_array($resultReverse)) {
    if ($rowReverse['escrute'] != '') {
      $escrute = unserialize($rowReverse['escrute']);

      if (k1escrute($escrute) && count($escrute) > 0) {
        $resul = BackendCredito($rowReverse['IDC'], $rowReverse['serial'], $rowReverse['acobrar'], $TYPE_PREMIO_REVERSO);
      }
    }
  }
}
function endPoint($URL, $Method, $Data, $token)
{
  $curl = curl_init();

  curl_setopt_array($curl, [
    CURLOPT_URL => $URL,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => $Method,
    CURLOPT_HTTPHEADER => ['cache-control: no-cache', 'Content-Type: application/json', 'Authorization: Bearer ' . $token],
  ]);
  if ($Data) {
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($Data));
  }
  $response = curl_exec($curl);
  $err = curl_error($curl);
  curl_close($curl);
  $resp = json_decode($response, true);
  return $resp;
}

function showSaldo($IDC, $deb)
{
  if ($deb == AMBOS) {
    $infoCredit = dataCredit($IDC);
    $infoBono = dataBono($IDC);

    $credit = $infoCredit !== false ?   $infoCredit['saldo'] : 0;
    $bono = $infoBono !== false ?   $infoBono['saldo'] : 0;

    return [
      "saldocredit" => $credit,
      "saldobono" => $bono,
      "saldo" => $credit + $bono
    ];
  }

  if ($deb == SSALDO) {
    $infoCredit = dataCredit($IDC);
    $credit = $infoCredit !== false ?   $infoCredit['saldo'] : 0;

    return [
      "saldocredit" => $credit,
      "saldobono" => 0,
      "saldo" => $credit
    ];
  }

  if ($deb == SBONO) {
    $infoBono = dataBono($IDC);
    $bono = $infoBono !== false ?   $infoBono['saldo'] : 0;

    return [
      "saldocredit" => 0,
      "saldobono" => $bono,
      "saldo" => $bono
    ];
  }

  return [];
}

function dataCredit($IDC)
{
  $conexion = conectMaster();

  $sql = "Select * from _tbcredito where IDC='$IDC' order by id DESC limit 1 ";
  $q = mysqli_query($conexion, $sql);
  if (mysqli_num_rows($q) == 0) {

    $r = mysqli_fetch_array($q);

    return $r[0];
  }

  return false;
}


function dataBono($IDC)
{
  $conexion = conectMaster();
  $sql = "Select * from _tbbono where IDC='$IDC' order by id DESC limit 1 ";
  $q = mysqli_query($conexion, $sql);
  if (mysqli_num_rows($q) == 0) {

    $r = mysqli_fetch_array($q);

    return $r[0];
  }

  return false;
}

function conectMaster()
{
  global $serverD;
  global $userD;
  global $clvD;
  global $dbD;
  $conexion = mysqli_connect($serverD, $userD, $clvD, $dbD);
  return $conexion;
}


function getAccessByCookie($rndusr)
{
  global $link;
  $result = mysqli_query($link, "SELECT * FROM _tusu WHERE bloqueado= $rndusr");
  if (mysqli_num_rows($result) != 0) {
    $row = mysqli_fetch_array($result);
    return $row['ABanca'];
  }
  return -1;
}
