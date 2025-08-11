<?
require_once('prc_phpDUK.php');
$link = ConnectionAnimalitos::getInstance();

switch ($_REQUEST['op']) {


  case '3':
    $IDL = $_REQUEST['IDL'];
    $resultj2N = mysqli_query($link, "Update _Escritu_Ani  set  Publicar=" . $_REQUEST['Activo'] . "  where ID=" . $_REQUEST['ID']);
    if (!$resultj2N) :
      echo '<script> alert("Disculpe hubo un error a tratar de Actualizar los escrutes!"); </script>';
    else :
      if ($_REQUEST['Activo'] == 1) {
        _Escrute_Ani_total($_REQUEST['fc'], $IDL);
      }
      if ($_REQUEST['Activo'] == 0) : $IDJ = _FechaDUK($_REQUEST['fc']);
        _AnularEscrutes($IDJ, $IDL);
      endif;
    endif;
    break;
  case '4':
    $IDJ = _FechaDUK($_REQUEST['fc']);
    $IDL = $_REQUEST['IDL'];
    $resultj = mysqli_query($link, "SELECT * FROM _Escritu_Ani  Where IDJ=" . $IDJ . " and ID in (Select ID from _Jornada where IDL=$IDL)");
    while ($row1N = mysqli_fetch_array($resultj)) {
      if ($row1N['Publicar'] == 1) : $Activo = 0;
      else : $Activo = 1;
      endif;
      $resultj2N = mysqli_query($link, "Update _Escritu_Ani  set  Publicar=" . $Activo . "  where ID=" . $row1N['ID']);
    }
    if ($Activo == 1) _Escrute_Ani_total($_REQUEST['fc'], $IDL);
    if ($Activo == 0) _AnularEscrutes($IDJ, $IDL);
    if (!$resultj2N) :
      echo '<script> alert("Disculpe hubo un error a tratar de Actualizar la escrutes!"); </script>';
    endif;
    break;
  case '5':
    $resultj = mysqli_query($link, "Select ID,IDL from _Jornada where ID=" . $_REQUEST['ID']);
    $row1N = mysqli_fetch_array($resultj);
    $IDL = $row1N['IDL'];
    $animaito = _verAnimalito($_REQUEST['num'], $IDL);
    if (count($animaito) != 0) :
      switch ($_REQUEST['colm']) {
        case '3':
          $GraGAN = 'G1="' . $_REQUEST['num'] . '"';
          break;
        case '4':
          $GraGAN = 'G2="' . $_REQUEST['num'] . '"';
          break;
        case '5':
          $GraGAN = 'G3=' . $_REQUEST['num'];
          break;
      }
      $resultj2N = mysqli_query($link, "Update _Escritu_Ani  set  " . $GraGAN . "  where ID=" . $_REQUEST['ID']);
      if (!$resultj2N) :
        echo '<script> alert("Disculpe hubo un error a tratar de Actualizar la escrutes!"); </script>';
      else :
        echo '<script> mygrid[' . $IDL . '].cells(' . $_REQUEST['ID'] . ',' . $_REQUEST['colm'] . ').setValue("' . $animaito[0] . '(' . $_REQUEST['num'] . ')' . '") </script>';
      endif;
    else :
      $resultj2N = mysqli_query($link, "Update _Escritu_Ani  set  " . $GraGAN . "  where ID=" . $_REQUEST['ID']);
      echo '<script> alert("Disculpe ese numero no esta habilitado!"); mygrid.cells(' . $_REQUEST['ID'] . ',' . $_REQUEST['colm'] . ').setValue("")</script>';
    endif;
    break;
}
