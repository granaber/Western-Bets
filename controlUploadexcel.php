<?php

$tipo = substr($_FILES['fileUpload']['type'], 0, 5);

$dir = 'arch/';

if (isset($_FILES['fileUpload']['tmp_name'])) {

        if (!copy($_FILES['fileUpload']['tmp_name'], $dir.$_FILES['fileUpload']['name']))
            echo '<script> alert("Error al Subir el Archivo");</script>';
        else
            echo '<script> alert("El archivo '.$_FILES['fileUpload']['name'].' se ha copiado con Exito");</script>';
         
        }
    else echo '<script> alert("El Archivo no ha llegado al Servidor.");</script>';

?>