<?
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();


// echo "SELECT * FROM _tconfjornada where Estatus=1 and fecha='".date("d/n/Y")."' order by IDCN";





?>

<div id="a_tabbar" style="width:705px; height:435px;" />
</div>

<?
$i = 1;
$result3 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tconfjornadahi where Estatus=1 and fecha='" . date("d/n/Y") . "' order by IDCN");
while ($row = mysqli_fetch_array($result3)) {
  $resultHipo = mysqli_query($GLOBALS['link'], "SELECT * FROM _hipodromoshi where _idhipo=" . $row['IDhipo']);
  $rowHIPO = mysqli_fetch_array($resultHipo);
?>
  <div id="hipo<? echo $i; ?>" lang="<? echo $rowHIPO['Descripcion'];  ?>">
    <?
    $result4 = mysqli_query($GLOBALS['link'], "SELECT * FROM _tdjuegoshi where Estatus=1");


    $cuantosSon = mysqli_num_rows($result4) + 3; // Se SUMAN 3 porque los GANADORES / PLACE / SHOW son fijos y no depende la Tabla _tdjuegoshi

    /*   $idcn=$row3["IDCN"];
   $config=explode("|",$row3["_Jug"]);
   $cantcb=explode("|",$row3["_Fab"]);
   $retira=explode("|",$row3["_Ret"]); */

    ?>
    <table width="1000" border="0">
      <tr>
        <td width="45">Carr.</td>
        <td colspan="3" align="center">Llegada</td>
        <td colspan="<? echo $cuantosSon; ?>">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="91">Primero</td>
        <td width="98">Segundo</td>
        <td width="103">Tercero</td>
        <td width="253">Ganador</td>
        <td width="118">Place</td>
        <td width="118">Show</td>
        <?
        while ($row3 = mysqli_fetch_array($result4)) {
          echo '<td width="122">' . $row3['Descrip'] . '</td>';
        }
        ?>
      </tr>
      <?
      for ($t = 1; $t <= $row['Cantcarr']; $t++) {
        echo '<td><input name="" type="text" size="6"></td>';
        echo '<td width="91"><input name="" type="text" size="6" style="background: #069; color:#FFF"></td>'; //Para Lo Ganadores Primero
        echo '<td width="98"><input name="" type="text" size="6" style="background: #069; color:#FFF" ></td>'; // Segundo
        echo '<td width="103"><input name="" type="text" size="6" style="background: #069; color:#FFF"></td>'; // Tercero   

        for ($t = 1; $t <= $cuantosSon; $t++) {
          echo '<td width="253"><input name="" type="text" size="6"></td>'; // LOS DIVIDENDO DE LOS JUEGOS
        }
      }
      ?>
    </table>
  </div>
  <!--<input name="" type="text" size="6" >-->
<?
  $i++;
} ?>
<script>
  totaldeDiv = <? echo $i - 1; ?>;

  tabbar = new dhtmlXTabBar("a_tabbar", "top");
  //tabbar.setOnSelectHandler(my_func);
  tabbar.setImagePath("codebase/imgs/");
  tabbar.setSkinColors("#FCFBFC", "#F4F3EE", "#FCFBFC");
  tabbar.setStyle("modern");
  for (i = 1; i <= totaldeDiv; i++) {
    tabbar.addTab("a" + i, $('hipo' + i).lang, "150px");
    tabbar.setContent("a" + i, 'hipo' + i);
  }
</script>