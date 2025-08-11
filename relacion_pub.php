<?php
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance();

?>

<body>
  <p class="EstiloTT"><b>Relacion Publicadas</b></p>
  &nbsp;
  <table width="800" border="0" cellspacing="0" cellpadding="2">
    <tr bgcolor="#0099FF">
      <td width="21" height="11">
        <div align="center"><strong>N&ordm;</strong></div>
      </td>
      <td></td>
      <td width="116">
        <div align="center"><strong>Jornada</strong></div>
      </td>
      <td width="500"><strong>Observacion</strong></td>
    </tr>
    <?php
    $result = mysqli_query($GLOBALS['link'], "Select * From _relacion13 Order By IDCN desc");
    $i = 1;
    $b = 1;
    while ($row = mysqli_fetch_array($result)) {
      $idcn = $row["IDCN"];
      $obs = substr($row["Observa"], 0, 95);

      $result2 = mysqli_query($GLOBALS['link'], "Select * From _tconfjornada Where IDCN=" . $idcn);
      $row2 = mysqli_fetch_array($result2);
      $fc = $row2["Fecha"];
      $hp = $row2["IDhipo"];

      $result3 = mysqli_query($GLOBALS['link'], "Select * From _hipodromos Where _idhipo=" . $hp);
      $row3 = mysqli_fetch_array($result3);
      $sg = $row3["siglas"];
      if ($b == 1) :
        $bcol = "#FFFFFF";
        $b = 2;
      else :
        $bcol = "#E2E7EF";
        $b = 1;
      endif;
      echo '<tr bgcolor="' . $bcol . '" >
    <td width="21" height="10">' . $i . '</td>
	<td width="21" height="10"><a href="javascript:imprimirrelcc(' . $idcn . ');">Ver</a></td>
    <td  width="116"><div align="center">' . $fc . '-' . $sg . '</div></td>
    <td width="500">' . $obs . '</td>
  </tr>';
      $i++;
    }
    ?>
  </table>
</body>