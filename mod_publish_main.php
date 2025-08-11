<div class="fmr-publish-main">
    <div class="escruting-main-form ">
        <div class="escruting-main">
            <section id='list-bnt-push' class=" escruting-form1"
                style="display: flex;flex-direction: row;align-content: space-between;flex-wrap: nowrap;width: auto;">

                <button class="escruting-button-partidos-listo-para-escrutar  escruting-button-option" id="push-0"
                    style="width: 200px;margin-right: 10px;" data-level="0">Push
                    Intro</button>

                <button class="none escruting-button-option" id="push-1" style="width: 200px;margin-right: 10px;"
                    data-level="1">Push
                    Ventas</button>

            </section>
            <section id="select-escrute-from">
                <?
                $LEVEL = 0;
                include 'mod_publish-1.php'
                ?>
            </section>
        </div>
    </div>
</div>
<script>
active = 0
document.getElementById('list-bnt-push').addEventListener('click', function(e) {
    e.preventDefault()
    const el = e.target

    el.classList.replace('none', 'escruting-button-partidos-listo-para-escrutar');


    if (el.nodeName === 'BUTTON') {
        const LEVEL = el.dataset.level;


        const elNew = document.getElementById(`push-${active}`)
        elNew.classList.replace('escruting-button-partidos-listo-para-escrutar', 'none');
        active = Number(LEVEL)

        new Ajax.Request("mod_publish-1.php", {
            parameters: {
                LEVEL
            },
            method: "get",
            onComplete: function(transport) {
                var response = transport.responseText;
                $("select-escrute-from").innerHTML = response;
                response.evalScripts();



            },
            onFailure: function() {
                alert("No tengo respuesta Comuniquese con el Administrador!");
            },
        });
    }
})
</script>