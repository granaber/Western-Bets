 <?
    if (isset($_REQUEST['refesh'])) {
        require_once('prc_php.php');
        $link = Connection::getInstance();
        $LEVEL = $_REQUEST['LEVEL'];

        $q = mysqli_query($link, "SELECT * FROM _image_publish WHERE level=$LEVEL order by pos");
        $files = [];
        while ($r = mysqli_fetch_array($q)) {
            $files[] = [$r['file'], $r['id']];
        }
    }

    $sty = ['position: absolute; width: 10%; height: 70%; top: 261px; left:47px;', 'position: absolute; width: 10%; height: 70%; top: 261px; left: 340px;', 'position: absolute; width: 10%; height: 70%; top: 261px; left: 633px;', 'position: absolute; width: 10%; height: 70%; top: 261px; left: 924px;'];

    // $sty_mar = [' top: 415px; left:47px;', 'top: 415px; left: 340px;', ' top: 415px; left: 633px;', ' top: 415px; left: 924px;'];

    for ($i = 0; $i < 4; $i++) {
        if (isset($files[$i])) {
            $id[] = "draggable-" . $i;
    ?>
 <div style="border: 1px black dashed;height: 45%;width: 20%;border-radius: 10px;">
     <div id="draggable-<?= $i ?>" style="<?= $sty[$i] ?>" data-id="<?= $files[$i][1] ?>">
         <img src="<?= $path . "/" . $files[$i][0]; ?>" class="class-img" />
     </div>
 </div>
 <?    } else { ?>
 <div style="border: 1px black dashed;height: 45%;width: 20%;border-radius: 10px;">
 </div>

 <? }
    } ?>