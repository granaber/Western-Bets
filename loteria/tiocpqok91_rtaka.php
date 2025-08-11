<? require('prc_php.php');
$clave=$_COOKIE['-okwilh'];
$claveencrip=encrypt(strval($clave), 'mjuilk091o@');
//setcookie('-okwilh',$claveencrip);
echo json_encode($claveencrip);
?>