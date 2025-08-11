<?php
$GLOBALS['link'] = mysqli_connect("localhost", "sphonlin_root", "intra");
mysql_select_db("sphonlin_sphonline");
?>

<body>
  <div id="box">

    <!--- box border -->
    <div id="lb">
      <div id="rb">
        <div id="bb">
          <div id="blc">
            <div id="brc">
              <div id="tb">
                <div id="tlc">
                  <div id="trc">
                    <!--  -->

                    <div id="content">

                      <p class="EstiloTT"><b>Resultados del Super Pool Hipico</b></p>
                      <img src="media/result.jpg" width="450">
                      <table width="485" border="0" cellspacing="0" cellpadding="2">
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
                        $result = mysqli_query($GLOBALS['link'], "Select * From _relacion13 Order By IDCN desc", $GLOBALS['link']);
                        $i = 1;
                        $b = 1;
                        while ($row = mysqli_fetch_array($result)) {
                          $idcn = $row["IDCN"];
                          $obs = substr($row["Observa"], 0, 95);

                          $result2 = mysqli_query($GLOBALS['link'], "Select * From _tconfjornada Where IDCN=" . $idcn, $GLOBALS['link']);
                          $row2 = mysqli_fetch_array($result2);
                          $fc = $row2["Fecha"];
                          $hp = $row2["IDhipo"];

                          $result3 = mysqli_query($GLOBALS['link'], "Select * From _hipodromos Where _idhipo=" . $hp, $GLOBALS['link']);
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
    <td width="500" style="font-size:11px">' . $obs . '</td>
  </tr>';
                          $i++;
                        }
                        ?>
                      </table>
                    </div>

                    <!--- end of box border -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- -->

  </div>
</body>