<?php
require_once('prc_phpDUK.php');
$link = ConnectionAnimalitos::getInstance();
$fc = '24/1/2018'; //FecharealAnimalitos(0,'d/m/Y');'14/03/2017';
//$IDJ=_FechaDUK($fc,0);

__Estk($_REQUEST['s']);



function __Estk($serial)
{
  $fc = '24/1/2018';
  $IDJ = _FechaDUK($fc, 0);

  $sPremios = array();
  $nPremios = array();
  $akIDL = array();
  $result = mysqli_query($link, "Select * From  _Escritu_Ani  Where Publicar=1 and  IDJ=" . $IDJ);
  while ($row = mysqli_fetch_array($result)) {
    if (is_numeric($row['G1'])) :
      if ($row['G1'] == '0') :
        $nPremios[] = "'" . $row['G1'] . "'";
      else :
        if ($row['G1'] == '00') :
          $nPremios[] = "'" . $row['G1'] . "'";
        else :
          $nPremios[] = str_replace(' ', '', $row['G1']);
        endif;
      endif;
    else :
      $nPremios[] = str_replace(' ', '', $row['G1']);
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
    $sPremios[] = $row['ID'];
    $nPremios2[] = $row['G3'];
    $resultIDSOL = mysqli_query($link, "Select * From  _Jornada  Where   ID=" . $row['ID']);
    $rowIDSOL = mysqli_fetch_array($resultIDSOL);
    $akIDL[$row['ID']] = $rowIDSOL['IDL'];
  }
  $alogros = array();
  $result = mysqli_query($link, "SELECT _Conf_premio . * FROM _Conf_premio, _Jornada WHERE numero = -1 AND _Conf_premio.ID = _Jornada.ID AND IDJ =" . $IDJ);
  while ($row = mysqli_fetch_array($result)) {
    $alogros[$row['ID']][$row['modo']] = $row['logro'];
  }
  $result = mysqli_query($link, "Select * From  _Jugada_ani  Where Serial=" . $serial);
  //echo ("Select * From  _Jugada_ani  Where Activo=1 and Esc=0 and  IDJ=".$IDJ);
  while ($row = mysqli_fetch_array($result)) {
    $premio = array();
    $sumap = 0;
    $down = 0;
    $cerrar = true;
    $data = unserialize(decoBaseK($row['Jugada']));
    print_r($data);
    print_r($sPremios);
    foreach ($data as $i => $value) {
      $ide = array_search($data[$i]->sorteo, $sPremios);
      if ($ide === false) :
        $cerrar = false;
      else :
        //  echo '*'.$row['serial'];echo '<br>';
        switch ($data[$i]->modo) {
          case '0':
            if (is_numeric($data[$i]->numero)) :
              if ($data[$i]->numero == '0') :
                $data[$i]->numero = "'" . $data[$i]->numero . "'";
              else :
                if ($data[$i]->numero == '00') :
                  $data[$i]->numero = "'" . $data[$i]->numero . "'";
                endif;
              endif;
            endif;
            echo '<br>';
            echo $data[$i]->sorteo . '-' . $nPremios[$ide] . '-' . $data[$i]->numero . '* ';
            echo strcmp($nPremios[$ide], $data[$i]->numero);
            echo '<br>';
            if ($nPremios[$ide] == $data[$i]->numero) :
              echo 'si';
              $result2n = mysqli_query($link, "Select * From  _Conf_premio  Where modo=0 and numero=" . $data[$i]->numero . " and  ID=" . $data[$i]->sorteo);
              if (mysqli_num_rows($result2n) == 0) :

                if ($akIDL[$data[$i]->sorteo] == 1) :
                  $result2n = mysqli_query($link, "Select * From  _Concesionario_Ani  Where IDC='" . $row['IDC'] . "'");

                else :
                  $result2n = mysqli_query($link, "Select * From  _Concesionario_Ani_2  Where IDL=" . $akIDL[$data[$i]->sorteo] . " and IDC='" . $row['IDC'] . "'");
                endif;
                $row2n = mysqli_fetch_array($result2n);
                $logro = $row2n['iPremio'];

              else :
                $row2n = mysqli_fetch_array($result2n);
                $logro = $row2n['logro'];
              endif;
              $sumap += ($data[$i]->monto * $logro);
              $premio[] = array('n' => $data[$i]->numero, 'l' => $data[$i]->sorteo, 'p' => ($data[$i]->monto * $logro), 'm' => 0);
            endif;
            break;

          case '1':
            if ($nPremios[$ide] == $data[$i]->numero1 && $nPremios1[$ide] == $data[$i]->numero2) :
              $result2n = mysqli_query($link, "Select * From  _Concesionario_Ani  Where IDC='" . $row['IDC'] . "'");
              if (mysqli_num_rows($result2n) == 0) :
                $logro = $alogros[$data[$i]->sorteo][1];
              else :
                $row2n = mysqli_fetch_array($result2n);
                $logro = $row2n['iPremio2'];
              endif;
              $sumap += ($data[$i]->monto * $logro);
              $premio[] = array('n' => $data[$i]->numero1 . '/' . $data[$i]->numero2, 'l' => $data[$i]->sorteo, 'p' => ($data[$i]->monto * $logro), 'm' => 1);
            endif;
            break;

          case '2':
            if (($nPremios[$ide] == $data[$i]->numero1 && $nPremios1[$ide] == $data[$i]->numero2) || ($nPremios[$ide] == $data[$i]->numero2 && $nPremios1[$ide] == $data[$i]->numero1)) :
              $result2n = mysqli_query($link, "Select * From  _Concesionario_Ani  Where IDC='" . $row['IDC'] . "'");
              if (mysqli_num_rows($result2n) == 0) :
                $logro = $alogros[$data[$i]->sorteo][2];
              else :
                $row2n = mysqli_fetch_array($result2n);
                $logro = $row2n['iPremio3'];
              endif;
              $sumap += ($data[$i]->monto * $logro);
              $premio[] = array('n' => $data[$i]->numero1 . '/' . $data[$i]->numero2, 'l' => $data[$i]->sorteo, 'p' => ($data[$i]->monto * $logro), 'm' => 2);
            endif;
            break;

          case '3':
            if ($nPremios[$ide] == $data[$i]->numero || $nPremios1[$ide] == $data[$i]->numero) :
              $result2n = mysqli_query($link, "Select * From  _Concesionario_Ani  Where IDC='" . $row['IDC'] . "'");
              if (mysqli_num_rows($result2n) == 0) :
                $logro = $alogros[$data[$i]->sorteo][3];
                $logro2 = $alogros[$data[$i]->sorteo][3];
              else :
                $row2n = mysqli_fetch_array($result2n);
                $logro = $row2n['iPremio4'];
                $logro2 = $row2n['iPremio44'];
              endif;
              if ($nPremios[$ide] == $data[$i]->numero) :
                $sumap += ($data[$i]->monto * $logro);
                $premio[] = array('n' => $data[$i]->numero, 'l' => $data[$i]->sorteo, 'p' => ($data[$i]->monto * $logro), 'm' => 3);
              else :
                $sumap += ($data[$i]->monto * $logro2);
                $premio[] = array('n' => $data[$i]->numero, 'l' => $data[$i]->sorteo, 'p' => ($data[$i]->monto * $logro2), 'm' => 3);
              endif;

            endif;
            break;
        }


      endif;
    }
    /// Segundo chance ///
    foreach ($data as $i => $value) {
      if ($data[$i]->modo == 0) :
        //$key= array_search($data[$i]->sorteo,array_column($premio, 'l'));
        //if ( $key===false ):
        if ($akIDL[$data[$i]->sorteo] == 1) :
          $ide = array_search($data[$i]->sorteo, $sPremios);
          if ($ide !== false) :
            if ($nPremios1[$ide] == $data[$i]->numero) :
              $sumap += ($data[$i]->monto);
              $premio[] = array('n' => $data[$i]->numero, 'l' => $data[$i]->sorteo, 'p' => ($data[$i]->monto), 'm' => 0);
            endif;
          endif;
        endif;
      //  endif;
      endif;
    }

    if ($sumap != 0) :
      $down = 0;

      $result2n = mysqli_query($link, "Select * From  _Jugada_ani_prem  Where serial=" . $row['serial']);
      if (mysqli_num_rows($result2n) == 0) :
        $result2n = mysqli_query($link, "Insert  _Jugada_ani_prem  values (" . $row['serial'] . "," . $sumap . ",'" . ecoBaseAnimalitos(serialize($premio)) . "')");
      else :
        $result2n = mysqli_query($link, "Update   _Jugada_ani_prem  set premio=" . $sumap . ",Jpremio='" . ecoBaseAnimalitos(serialize($premio)) . "' where serial=" . $row['serial']);
      endif;
    endif;
    if ($cerrar &&  $sumap == 0) :  $down = 1;
    endif;
    if ($cerrar) : $escrute = 1;
    else : $escrute = 0;
    endif;
    $result2n = mysqli_query($link, "Update _Jugada_ani  set Esc=" . $escrute . ", down=" . $down . " Where serial=" . $row['serial']);
  }
}
