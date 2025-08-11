<style type="text/css">
  <!--
  .Estilo2 {
    color: #FFFFFF;
    font-size: 12px
  }
  -->
  <?





  if (isset($_REQUEST['idt'])) :

    require('prc_php.php');

    $GLOBALS['link'] = Connection::getInstance();

    $idt = $_REQUEST['idt'];

    $acceso = accesolimitado($idt);

  else :

    $acceso = 0;

  endif;

  ?>

</style>

<div id="box6" style="width:660px; background:#333">

  <table width="658" border="0">

    <tr>

      <th width="78" scope="col" onMouseOver="$(this).className='resal2'" onMouseOut="$(this).className=''">
        <p align="center"><img src="media/mundo.pnp.png" width="32" height="32" onClick="<? if ($acceso == 0) : echo "opmenu('ver_listadederportes.php');";
                                                                                          else : echo "alert('Usted no tiene privilegios para acceder a esta opcion');";
                                                                                          endif; ?>"></p>

        <p align="center" class="Estilo2">Deportes</p>
      </th>

      <th width="107" scope="col" onMouseOver="$(this).className='resal2'" onMouseOut="$(this).className=''">
        <p align="center"><img src="media/Grupos de Juegos.png" width="32" height="32" onClick="<? if ($acceso == 0) : echo "opmenu('ver_gruposdejugada.php');";
                                                                                                else : echo "alert('Usted no tiene privilegios para acceder a esta opcion');";
                                                                                                endif; ?>"></p>

        <p align="center" class="Estilo2">Grupos de Jugadas</p>
      </th>

      <th width="97" scope="col" onMouseOver="$(this).className='resal2'" onMouseOut="$(this).className=''">
        <p align="center"><img src="media/juegosdd.png" width="32" height="32" onClick="<? if ($acceso == 0) : echo "opmenu('cnfjuegosdd.php');";
                                                                                        else : echo "alert('Usted no tiene privilegios para acceder a esta opcion');";
                                                                                        endif; ?>"></p>

        <p align="center" class="Estilo2">Configuracion de Juegos</p>
      </th>

      <th width="113" scope="col" onMouseOver="$(this).className='resal2'" onMouseOut="$(this).className=''">
        <p align="center"><img src="media/configequipos.png" width="32" height="32" onClick="<? if ($acceso == 0) : echo "opmenu('listadeequipos.php');";
                                                                                              else : echo "alert('Usted no tiene privilegios para acceder a esta opcion');";
                                                                                              endif; ?>"></p>

        <p align="center" class="Estilo2">Configuracion de Equipos</p>
      </th>
      <th width="111" scope="col" onMouseOver="$(this).className='resal2'" onMouseOut="$(this).className=''">
        <p align="center"><img src="media/grupo.png" width="32" height="32" onclick="opmenu('listerestriccionesdd.php');" /></p>
        <p align="center" class="Estilo2">Configuracion Grupo</p>
      </th>

      <th width="111" scope="col" onMouseOver="$(this).className='resal2'" onMouseOut="$(this).className=''">
        <p align="center"><img src="media/luser.png" width="32" height="32" onClick="opmenu('ver_listadeusuariodd.php');"></p>

        <p align="center" class="Estilo2">Configuracion Concesionario</p>
      </th>

    </tr>



  </table>

</div>

<br><br><br>

<div id="submenucng">

</div>

<script>
  Nifty('div#box6', 'big');
</script>