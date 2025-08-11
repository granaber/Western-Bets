<nav id="main-nav" class=" navbar navbar-expand-sm navbar-dark bg-dark d-flex flex-row justify-content-between">
    <!-- <a class="navbar-brand" href="#">Navbar</a> -->


    <button id='icons-menu-show' style="display:block;" class="navbar-toggler" type="button" data-toggle="collapse"
        data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div id="contextArea" class="">
        <? if ($valores[12] != 'TEST') {
        ?>
            <ul class="navbar-nav">
                <li class="nav-item point-cursor">
                    <a class="nav-link h4" data-menu="op46">Cambio de Clave </a>
                </li>
                <li class="nav-item point-cursor">
                    <a class="nav-link h4" data-menu="sp01">Retiro/Recargas</a>
                </li>
                <li id="dropdowntoggle-main" class="nav-item dropdown">
                    <a id="dropdowntoggle" class="nav-link dropdown-toggle h4 dropdowntoggle-t1" role="button"
                        data-toggle="dropdown" aria-expanded="false">
                        Reportes
                    </a>
                    <div id="drop-menu" class="dropdown-menu drop-menu-class">
                        <a class="dropdown-item h4 point-cursor" data-menu="op65">Ver Tickets</a>
                        <a class="dropdown-item h4 point-cursor" data-menu="sp02">Transacciones</a>
                        <a class="dropdown-item h4 point-cursor" data-menu="sp03">Contable</a>
                        <a class="dropdown-item h4 point-cursor" data-menu="sp04">Resultados de Juegos</a>
                    </div>
                </li>
            </ul>
        <?  }
        ?>
    </div>
    <? if ($valores[12] == 'TEST') { ?>
        <div class=" ml-auto ">
            <button type="button" class="btn btn-primary" style="border-radius: 25px;width: 100px;height: 35px;"
                onclick="loginVentas()"> Entrar</button>
            <a type="button" href="https://portal.westernbets.pro/portal" class="btn btn-warning"
                style="border-radius: 25px;width: 100px;height: 35px;">
                Registrate
            </a>
        </div>
    <? } else { ?>
        <section style="display: flex; align-items: center;">
            <div class="mr-3">
                <img src="./media/sincronizar.png" width="20" height="20" class="d-inline-block align-top point-cursor"
                    alt="Refresh" onclick=" callrefreshsales()">
            </div>
            <div class="mr-3" style="width: 100%;">
                <h5 id="" class="text-light">
                    <img src="./media/login-gradient.png" width="20" height="20" class="d-inline-block align-top"
                        alt="Loggin">
                    <?= $valores[12] ?>
                </h5>
            </div>
            <div>
                <img src="./media/cerrar-sesion_2.png" width="20" height="20" class="d-inline-block align-top point-cursor"
                    alt="Salir" onclick="onexitclient()">
            </div>
        </section>

    <? } ?>
</nav>