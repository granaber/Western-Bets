<?
if (isset($_REQUEST['LEVEL'])) {
    $LEVEL = $_REQUEST['LEVEL'];
}
require_once('prc_php.php');
$link = Connection::getInstance();
global $path;
$mode_level = 1;
$id = [];

$q = mysqli_query($link, "SELECT * FROM _image_publish where level=$LEVEL order by pos");
$files = [];
while ($r = mysqli_fetch_array($q)) {
    $files[] = [$r['file'], $r['id']];
}

// $files = ['info-media-publish-animalito1.jpeg', 'info-media-publish-animalito2.jpeg', 'info-media-publish.png', 'info-media-publish.png'];

// 10 - 180
// 280- 500
// 580 - 790
// 860- 1000
?>

<div class="fmr-publish">
    <div class="fmr-publish-1">
        <p>
            <label for="imageFile">Imagen 1 a subir:</label>
            <input type="file" id="imageFile1" name="file1" accept="image/*" multiple />
        </p>
        <p>
            <label for="imageFile">Imagen 2 a subir:</label>
            <input type="file" id="imageFile2" name="file2" accept="image/*" multiple />
        </p>
        <p>
            <label for="imageFile">Imagen 3 a subir:</label>
            <input type="file" id="imageFile3" name="file3" accept="image/*" multiple />
        </p>
        <p>
            <label for="imageFile">Imagen 4 a subir:</label>
            <input type="file" id="imageFile4" name="file4" accept="image/*" multiple />
        </p>
        <button id="btnEnviar" style=" height:50px;width:62px;border-radius: 50%;border: none;background: #3c5d7e;">
            <svg width="30px" height="30px" viewBox="0 0 24 24" version="1.1">
                <title>Upload-1</title>
                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g id="Upload-1">
                        <rect id="Rectangle" fill-rule="nonzero" x="0" y="0" width="24" height="24">

                        </rect>
                        <line x1="12" y1="11" x2="12" y2="20" id="Path" stroke="#ffffff" stroke-width="2"
                            stroke-linecap="round">

                        </line>
                        <path d="M15,13 L12.7071,10.7071 C12.3166,10.3166 11.6834,10.3166 11.2929,10.7071 L9,13"
                            id="Path" stroke="#ffffff" stroke-width="2" stroke-linecap="round">

                        </path>
                        <path
                            d="M8,16 L6,16 C4.34315,16 3,14.6569 3,13 C3,11.3431 4.34315,10 6,10 C6,6.68629 8.68629,4 12,4 C15.3137,4 18,6.68629 18,10 C19.6569,10 21,11.3431 21,13 C21,14.6569 19.6569,16 18,16 L16,16"
                            id="Path" stroke="#ffffff" stroke-width="2" stroke-linecap="round">
                        </path>
                    </g>
                </g>
            </svg>
        </button>
    </div>
    <div class="fmr-publish-body">
        <div id="main-imagen" class="fmr-publish-body-dock">
            <? include 'mod_publish-1-1.php' ?>
        </div>
    </div>

</div>

<script>
    var l = "<?= join(",", $id) ?>"

    function changePostImage(id, posx) {
        new Ajax.Request("mod_publish-1-2.php", {
            parameters: {
                id: id,
                posx: posx,
                LEVEL: <?= $LEVEL ?>
            },
            method: "get",
            onComplete: function(transport) {
                var response = transport.responseText;

            },
            onFailure: function() {
                alert("No tengo respuesta Comuniquese con el Administrador!");
            },
        });
    }

    function dragElement(elmnt) {
        var pos1 = 0,
            pos2 = 0,
            pos3 = 0,
            pos4 = 0;
        if (document.getElementById(elmnt.id)) {
            /* if present, the header is where you move the DIV from:*/
            document.getElementById(elmnt.id).onmousedown = dragMouseDown;
        } else {
            /* otherwise, move the DIV from anywhere inside the DIV:*/
            elmnt.onmousedown = dragMouseDown;
        }

        function dragMouseDown(e) {
            e = e || window.event;
            e.preventDefault();
            // get the mouse cursor position at startup:
            pos3 = e.clientX;
            pos4 = e.clientY;
            document.onmouseup = closeDragElement;
            // call a function whenever the cursor moves:
            document.onmousemove = elementDrag;
        }

        function elementDrag(e) {
            e = e || window.event;
            e.preventDefault();
            // calculate the new cursor position:
            pos1 = pos3 - e.clientX;
            pos2 = pos4 - e.clientY;
            pos3 = e.clientX;
            pos4 = e.clientY;
            // set the element's new position:
            elmnt.style.position = 'absolute'
            elmnt.style.width = '10%'
            elmnt.style.height = '70%'
            elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
            elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
        }

        function closeDragElement(e) {
            /* stop moving when mouse button is released:*/
            document.onmouseup = null;
            document.onmousemove = null;
            console.log(e.target.parentElement.dataset.id)
            console.log(e.target.parentElement.style.left)
            const id = e.target.parentElement.dataset.id
            const posx = e.target.parentElement.style.left
            changePostImage(id, posx)

        }
    }
    if (l !== "") {
        var ls = l.split(",");
        for (x = 0; x < ls.length; x++) {
            dragElement(document.getElementById(ls[x]));
        }
    }


    btnEnviar.addEventListener("click", () => {
        const inputFile1 = $('imageFile1')
        const inputFile2 = $('imageFile2')
        const inputFile3 = $('imageFile3')
        const inputFile4 = $('imageFile4')

        const l1 = inputFile1.files.length
        const l2 = inputFile2.files.length
        const l3 = inputFile3.files.length
        const l4 = inputFile4.files.length


        if (l1 > 0 || l2 > 0 || l3 > 0 || l4 > 0) {
            let formData = new FormData();
            formData.append("file1", l1 > 0 ? inputFile1.files[0] : "none");
            formData.append("file2", l2 > 0 ? inputFile2.files[0] : "none");
            formData.append("file3", l3 > 0 ? inputFile3.files[0] : "none");
            formData.append("file4", l4 > 0 ? inputFile4.files[0] : "none");

            fetch("mod_publish-2.php?LEVEL=<?= $LEVEL ?>", {
                    method: 'POST',
                    body: formData,
                })
                .then(respuesta => respuesta.json())
                .then(d => {
                    const ls = new Array()
                    const estatus = new Array();
                    for (let i = 0; i < d.length; i++) {
                        const element = d[i];
                        if (element.new) {
                            const head = `El archivo ${i+1} "${element.file}"`
                            if (element.erro === 0) {
                                estatus.push(`${head}, se publico sin problemas`)

                                ls.push(`draggable-${i}`);
                            }
                            if (element.erro === 1) {
                                estatus.push(
                                    `${head}, La extensión o el tamaño de los archivos no es correcta. Se permiten archivos .gif , .jpg o .png con un maximo de 250kb`
                                )
                            }
                            if (element.erro === 2) {
                                estatus.push(
                                    `${head}, Ocurrió algún error al subir el fichero. No pudo guardarse`)
                            }
                            continue
                        }
                        ls.push(`draggable-${i}`);

                    }


                    new Ajax.Request("mod_publish-1-1.php", {
                        parameters: {
                            refesh: 1,
                            LEVEL: <?= $LEVEL ?>
                        },
                        method: "get",
                        onComplete: function(transport) {
                            var response = transport.responseText;
                            $("main-imagen").innerHTML = response;

                            for (x = 0; x < ls.length; x++) {
                                dragElement(document.getElementById(ls[x]));
                            }
                        },
                        onFailure: function() {
                            alert("No tengo respuesta Comuniquese con el Administrador!");
                        },
                    });



                    alert(estatus.join("\n"));
                });
        } else {
            // El usuario no ha seleccionado archivos
            alert("Selecciona un archivo");
        }
    });
</script>