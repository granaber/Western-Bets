<?
include_once 'prc_php.php';
$link = Connection::getInstance();
?>
<form id="form-accces" class="absolute lg:w-[26%] mt-3 d-none">

    <div id="repuesta" class="form-group"></div>
    <div class="form-group">

        <label for="exampleInputEmail1" class="h6 text-light">Usuario</label>
        <input type="text" class="form-control" id="idusuario" aria-describedby="emailHelp" autocomplete="off">
        <!-- <small id="emailHelp" class="form-text text-muted">Nunca compartiremos tus datos con nadie más.</small> -->
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1" class="h6 text-light">Contraseña</label>
        <input type="password" class="form-control" id="idclave">
    </div>

    <button id="btaccess" type="button" onclick="exeAcceso()" class="btn btn-primary  btn-block ">
        <h3 class="text-white">Acceder</h3>
    </button>
    <div id="wait" role="status" style="display:none">
        <div class="spinner-border text-warning" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <div class="form-group text-center text-white">
        <!-- <h4> - o - </h4> -->
    </div>
    <div class="form-group ">
        <a type="button" href="https://portal.westernbets.pro/portal" class="btn btn-warning  btn-block">
            <h3> Registrate</h3>
        </a>
    </div>
</form>
<section id="form-registro" class="absolute lg:w-[26%] d-none">



    <div id="carrusel" class="carousel slide  carousel-fade" data-ride="carousel">
        <ol class="carousel-indicators">
            <?
            $active = "class='active'";
            $q = mysqli_query($link, "SELECT * FROM _image_publish where level=0 order by pos");
            while ($r = mysqli_fetch_array($q)) {
                $id = $r['id'] - 1;
            ?>
                <li data-target="#carrusel" data-slide-to="<?= $id ?>" <?= $active ?>></li>
            <?
                $active = "";
            }
            ?>

        </ol>
        <div class="carousel-inner">
            <?
            $active = "active";

            $q = mysqli_query($link, "SELECT * FROM _image_publish where level=0 order by pos");
            while ($r = mysqli_fetch_array($q)) {
                $file = $path . "/" . $r['file'];
            ?>
                <div class="carousel-item <?= $active ?>">
                    <img src="<?= $file ?>" alt="publish betgambler" style="width: 100%;height: 100%;border-radius: 15px; "
                        class="d-block w-100" />
                </div>
            <?
                $active = "";
            } ?>

        </div>
        <button class="carousel-control-prev" type="button" data-target="#carrusel" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-target="#carrusel" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </button>
    </div>
</section>