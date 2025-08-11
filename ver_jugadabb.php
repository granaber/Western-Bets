<style type="text/css">
  body {
    margin-left: 0px;
    margin-top: 0px;
    margin-right: 0px;
    margin-bottom: 0px;
  }

  .shadowcontainer5 {
    /* container width*/
    background-color: #d1cfd0;
  }

  .shadowcontainer5.innerdiv {
    /* Add container height here if desired */
    background-color: white;
    border: 1px solid gray;
    padding: 6px;
    position: relative;
    left: -5px;
    /*shadow depth*/
    top: -5px;
    /*shadow depth*/
  }

  .Estilo4 {
    color: #FFFFCC
  }
</style>
<?php
require('prc_php.php');
$link = Connection::getInstance();
$fc = $_REQUEST["fc"];
$idc = $_REQUEST["idc"];
$resultj = mysqli_query($link, "SELECT * FROM _jornadabb where Fecha='" . $fc . "'");
if (mysqli_num_rows($resultj) != 0) :
  $rowj = mysqli_fetch_array($resultj);
  $idj = $rowj["IDJ"];
else :
  $idj = 0;
  $idc = '';
endif;


?>
<br />
<div style="    
    width: 900px;
    background: #333;
    display: flex;
    padding: 6px;
    gap: 5px;
    border-radius: 5px">
  <section>
    <h3 style="font-size: 16px;color: yellow;">Fecha</h3>
  </section>
  <section>
    <input name="fc" type="text" id="fc" lang="<?php echo $idj; ?>" value="<?php echo $fc; ?>" style="
            height: 21px;
            width: 80px;
            border: none;
            border-radius: 2px;
            padding: 11px;
            font-size: 12px;
            color: #000;
            background: #e7e7e7;" />

  </section>

</div>
<br />
<div id="tabl">
  <?php include('ver_jugadabb-2.php'); ?>
</div>