  <nav class="layout-navbar container-l navbar navbar-expand-l navbar-detached align-items-center <?= $dark ? 'navbar-dark bg-dark' : '  bg-navbar-theme ' ?> "
      id="layout-navbar">
      <div class="layout-menu-toggle navbar-nav align-items-xl-center me-5 me-xl-0 d-l-none">
          <? if ($valores[12] != 'TEST') { ?>
          <a id='icons-menu-show' class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
              <i class="bx bx-menu bx-sm"></i>
          </a>
          <? } ?>
      </div>
      <? if ($valores[12] != 'TEST') { ?>
      <div style="display: flex; justify-content: center; align-items: center;">
          <img src="media/westernbets.pro.title.mobile.png" alt="" srcset="" style="width: 80%;">
      </div>
      <? } ?>

      <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">


          <ul class="navbar-nav flex-row align-items-center ms-auto">
              <!-- Place this tag where you want the button to render. -->


              <!-- User -->
              <? if ($valores[12] == 'TEST') { ?>
              <div class=" ml-auto ">
                  <button type="button" class="btn btn-primary" style="border-radius: 25px;width: 100px;height: 35px;"
                      onclick="loginVentas()">Entrar</button>
                  <a type="button" href="https://portal.westernbets.pro/portal" class="btn btn-warning"
                      style="border-radius: 25px;width: 100px;height: 35px;">
                      Registrate
                  </a>
              </div>
              <? } else { ?>
              <li class="nav-item navbar-dropdown dropdown-user dropdown ">
                  <a id="dropdown-user" class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                      data-bs-toggle="dropdown">
                      <div class="avatar avatar-online">
                          <img src="./media/avatar.png" alt="" class="w-px-40 h-auto rounded-circle">
                      </div>
                  </a>

                  <ul class="dropdown-menu dropdown-menu-end <?= $dark ? 'dropdown-menu-dark' : ' ' ?>"
                      data-bs-popper="none">
                      <li>
                          <a class="dropdown-item">
                              <div class="d-flex">
                                  <div class="flex-shrink-0 me-3">
                                      <div class="avatar avatar-online">
                                          <img src="./media/avatar.png" alt="" class="w-px-40 h-auto rounded-circle">
                                      </div>
                                  </div>
                                  <div class="flex-grow-1">
                                      <span class="fw-semibold d-block"> <?= $valores[12] ?></span>
                                      <small class="text-muted"> <?= $valores[1] ?></small>
                                  </div>
                              </div>
                          </a>
                      </li>
                      <li class="point-cursor">
                          <a class="dropdown-item" onclick="callrefreshsales()">
                              <i class='bx bx-repost me-2'></i>
                              <span class="align-middle">Refresh</span>
                          </a>
                      </li>
                      <li class="point-cursor">
                          <div class="custom-control custom-switch" style="padding-left: 3.25rem;">
                              <input type="checkbox" class="custom-control-input" id="darkmode" onclick="handleMode()"
                                  <?= $dark ? 'checked' : '' ?>> <label
                                  class="custom-control-label <?= $dark ? 'text-light' : ' ' ?>"
                                  for="darkmode">Dark</label>
                          </div>
                      </li>
                  </ul>
              </li>
              <? } ?>
              <!--/ User -->
          </ul>
      </div>
  </nav>
  <? if ($valores[12] != 'TEST') { ?>
  <aside id="layout-menu"
      class="layout-menu menu-vertical menu   <?= $dark ? 'bg-menu-theme-dark ' : 'bg-menu-theme ' ?>"
      data-bg-class="bg-menu-theme">
      <div style="background-color:<?= $dark ? 'black' : 'gray' ?> ; margin: auto;" class="app-brand">
          <img width="100%" src="media/westernbets.pro.title.mobile.png" alt="" srcset="" style=" width: 55%;
              margin:auto; padding: 6px 0px 6px 0px;">

          <a id='anti-icons-menu-show' href=" javascript:void(0);"
              class="layout-menu-toggle menu-link text-large ms-auto d-block d-l-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
          </a>
      </div>

      <div class="menu-inner-shadow"></div>

      <ul id='contextArea' class="menu-inner py-1 overflow-auto">
          <!-- Dashboard -->
          <li class="menu-item point-cursor ">
              <a style="color:<?= $dark ? '#fff' : '#1a47ad' ?>;" class="menu-link" data-menu="op46">
                  <i class="bx bx-user me-2"></i>
                  <div data-i18n="Analytics">Cambio de Claves</div>
              </a>
          </li>
          <li class="menu-item  point-cursor">
              <a style="color:<?= $dark ? '#fff' : '#1a47ad' ?>;" class="menu-link" data-menu="sp01">
                  <i class="bx bx-money me-2"></i>
                  <div data-i18n="Analytics">Retiro/Recargas</div>
              </a>
          </li>

          <li id='click-toggle' class="menu-item menu-item-animating" style="color:<?= $dark ? '#fff' : '#1a47ad' ?>;">
              <a href="javascript:void(0)" class="menu-link menu-toggle ">
                  <i class="menu-icon tf-icons bx bx-copy"></i>
                  <div data-i18n="Extended UI">REPORTES</div>
              </a>
              <ul class="menu-sub">
                  <li class="menu-item point-cursor">
                      <a data-menu="op65" class="menu-link">
                          <div data-i18n="Perfect Scrollbar">Ver Tickets</div>
                      </a>
                  </li>
                  <li class="menu-item point-cursor">
                      <a data-menu="sp02" class="menu-link">
                          <div data-i18n="Text Divider">Transacciones</div>
                      </a>
                  </li>
                  <li class="menu-item point-cursor">
                      <a data-menu="sp03" class="menu-link">
                          <div data-i18n="Text Divider">Contable</div>
                      </a>
                  </li>
                  <li class="menu-item point-cursor">
                      <a data-menu="sp04" class="menu-link">
                          <div data-i18n="Text Divider">Resultados de Parlay</div>
                      </a>
                  </li>
                  <li class="menu-item point-cursor">
                      <a data-menu="sp05" class="menu-link">
                          <div data-i18n="Text Divider">Resultados de Animalitos</div>
                      </a>
                  </li>
                  <li class="menu-item point-cursor">
                      <a data-menu="sp06" class="menu-link">
                          <div data-i18n="Text Divider">Conformes Americana</div>
                      </a>
                  </li>
                  <li class="menu-item point-cursor">
                      <a data-menu="none" class="menu-link" href="./reglamento/reglamentos.pdf" target="_blank">
                          <div data-i18n="Text Divider">Reglamentos</div>
                      </a>
                  </li>
              </ul>
          </li>
          <li class="menu-item  point-cursor">
              <a style="color:<?= $dark ? '#fff' : '#1a47ad' ?>;" class="menu-link" data-menu="sp07">
                  <i class="bx bx-cog me-2"></i>
                  <div data-i18n="Analytics">Configuración</div>
              </a>
          </li>
          <li class="menu-item  point-cursor">
              <a style="color:<?= $dark ? '#fff' : '#1a47ad' ?>;" class="menu-link" data-menu="close">
                  <i class="bx bx-power-off me-2"></i>
                  <div data-i18n="Analytics">Cerrar Sesión</div>
              </a>
          </li>
      </ul>
  </aside>
  <? } ?>