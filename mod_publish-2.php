<?
$LEVEL = intval($_REQUEST['LEVEL']);
$leveId = 4 * $LEVEL;
require_once('prc_php.php');
$link = Connection::getInstance();
global $path;
$backup = '/home/files-publish';
$out = [];
for ($i = 1; $i <= 4; $i++) {
    $name = "file$i";
    //datos del arhivo
    if (isset($_FILES[$name])) {
        $nombre_file1 = $_FILES[$name]['name']; //
        $tipo_file1 = $_FILES[$name]['type'];
        $tamano_file1 = $_FILES[$name]['size'];

        //compruebo si las características del file1s que deseo
        if (!((strpos($tipo_file1, "gif") || strpos($tipo_file1, "jpeg") || strpos($tipo_file1, "png")) && ($tamano_file1 < 250000))) {
            $out[] = ['file' => $nombre_file1, 'erro' => 1, 'id' => $i + $leveId, 'new' => true];
            // echo "La extensión o el tamaño de los archivos no es correcta. Se permiten archivos .gif , .jpg o .png con un maximo de 200kb";
        } else {
            if (move_uploaded_file($_FILES[$name]['tmp_name'], $path . "/" . $nombre_file1)) {
                // echo "El archivo ha sido cargado correctamente.";
                copy($path . "/" . $nombre_file1, $backup . "/" . $nombre_file1);
                $out[] = ['file' => $nombre_file1, 'erro' => 0, 'id' => $i + $leveId, 'new' => true];
            } else {
                $out[] = ['file' => $nombre_file1, 'erro' => 2, 'id' => $i + $leveId, 'new' => true];

                // echo "Ocurrió algún error al subir el fichero. No pudo guardarse.";
            }
        }
    }
}


foreach ($out as $key) {
    if ($key['erro'] == 0) {
        $id = $key['id'];
        $file = $key['file'];
        $q = mysqli_query($link, "SELECT * FROM _image_publish where id=$id and level=$LEVEL");
        if (mysqli_num_rows($q) == 0) {
            mysqli_query($link, "INSERT _image_publish (id,file,timestamp,pos,level) values ($id,'$file',CURRENT_TIMESTAMP(),$id,$LEVEL)");
        } else {
            mysqli_query($link, "UPDATE _image_publish set file='$file',timestamp=CURRENT_TIMESTAMP() where id=$id and level=$LEVEL");
        }
    }
}
$def = $out;
$q = mysqli_query($link, "SELECT * FROM _image_publish where  level=$LEVEL order by pos");
while ($r = mysqli_fetch_array($q)) {

    $found_key = array_search($r['file'], array_column($out, 'file'));

    if ($found_key === false) {
        $def[] = ['file' => $r['file'], 'erro' => 0, 'id' => $r['id'], 'new' => false];
    }
}


echo json_encode($def);