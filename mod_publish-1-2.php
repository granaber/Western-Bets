<?

require_once('prc_php.php');
$link = Connection::getInstance();


$pos1 = [10, 180];
$pos2 = [280, 500];
$pos3 = [580, 790];
$pos4 = [860, 1000];

$id = $_REQUEST['id'];
$posx = intval($_REQUEST['posx']);
$level = intval($_REQUEST['LEVEL']);

$whatPost = 0;

if ($posx >= $pos1[0] && $posx <= $pos1[1]) {
    $whatPost = 1;
}

if ($posx >= $pos2[0] && $posx <= $pos2[1]) {
    $whatPost = 2;
}

if ($posx >= $pos3[0] && $posx <= $pos3[1]) {
    $whatPost = 3;
}

if ($posx >= $pos4[0] && $posx <= $pos4[1]) {
    $whatPost = 4;
}

mysqli_query($link, "UPDATE _image_publish set pos=$whatPost where id=$id and level=$level");
