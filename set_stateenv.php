<?

// Para Activar el Modo DEPLOY solo tiene que crear un acrhivo llamado "deploy.env" en la raiz del proyecto
//////////////////////////////////////////////////////////////////////////////////////////////////////////
$PRODUCCION = 0;
$DEPLOY = 1;

function modeDetect()
{
    global $PRODUCCION, $DEPLOY;

    $fileDeploy = "/deploy.env";

    if (file_exists(".." . $fileDeploy)) {
        return $DEPLOY;
    } elseif (file_exists("." . $fileDeploy)) {
        return $DEPLOY;
    }

    return $PRODUCCION;
}
$mode = modeDetect(); // 0= Modo produccion, bloqueos de Seguridad, 1= Modo Desarrollo, Libre SuperUsuarios