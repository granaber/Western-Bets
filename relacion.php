<?php
///

$GLOBALS['link'] = mysqli_connect("localhost", "sphonlin_root", "intra");
mysql_select_db("sphonlin_sphonline", $GLOBALS['link']);





?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title>Documento sin t&iacute;tulo</title>
  <style type="text/css">
    <!--
    .Estilo12 {
      font-family: Verdana, Arial, Helvetica, sans-serif;
      font-weight: bold;
    }

    .Estilo6 {
      color: #FFFFFF
    }

    .Estilo7 {
      font-size: 15px
    }


    .shadowcontainer1 .innerdiv {
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

    .shadowcontainer1 {
      width: 330px;
      /* container width*/
      background-color: #d1cfd0;
    }

    .shadowcontainer2 {
      width: 1040px;
      /* container width*/
      background-color: #d1cfd0;
    }

    .shadowcontainer2 .innerdiv {
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

    .shadowcontainer {
      width: 290px;
      /* container width*/
      background-color: #d1cfd0;
    }

    .shadowcontainer .innerdiv {
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
    -->
  </style>
  <link href="css/menus.css" rel="stylesheet" type="text/css" />
  <style type="text/css">
    <!--
    .Estilo17 {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 12px;
    }

    .Estilo47 {
      color: #000000
    }
    }
    -->
  </style>
  <html>

<body>
  <table width="1240" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="492">&nbsp;</td>
      <td width="748">
        <div class="shadowcontainer1">
          <div class="innerdiv">
            <table width="316" height="71" border="0" cellspacing="0">
              <tr bgcolor="#0066FF">
                <th colspan="2" bgcolor="#D4DAE6">
                  <div align="center"><span class="Estilo17">RELACION</span></div>
                </th>
              </tr>
              <tr>
                <th width="184">
                  <div id="selej" align="center"><strong>Jornada</strong>:
                    <select name="select" id="sjornada">
                      <?php $result = mysqli_query($GLOBALS['link'], "SELECT _tconfjornada.fecha,_tconfjornada.IDCN,_hipodromos.siglas FROM _tconfjornada,_hipodromos where _tconfjornada.IDhipo=_hipodromos._IDhipo and _hipodromos.estatus=1 and _tconfjornada.estatus=1 order by idcn desc",  $GLOBALS['link']);
                      while ($row = mysqli_fetch_array($result)) {

                        echo "<option value='" . $row["IDCN"] . "'>" . $row["fecha"] . '-' . $row["siglas"] . "</option>";
                      }
                      ?>
                    </select>
                  </div>
                </th>
                <td width="128"><input type="submit" id="bs" value="Buscar" onclick="makeRequestrelacion();" />
                  <input type="submit" id="gd" value="Publicar" onclick="guardarrelacion();" />
                </td>
              </tr>
            </table>
          </div>
        </div>
      </td>
    </tr>
  </table>


  <div id='relacionver'>
  </div>

</body>

</html>