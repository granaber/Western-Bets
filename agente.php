<?
$user_agent = $_SERVER['HTTP_USER_AGENT'];
// print_r($user_agent);
print_r( getBrowser($user_agent));


function getBrowser($user_agent){

    $datos=explode('/',$user_agent);
    // print_r($datos);
    $explo='0';
    for ($i=0;i<=count($datos);$i++){
    if(strpos($datos[$i], 'MSIE') !== FALSE)
       $explo='Internet explorer';
     elseif(strpos($datos[$i], 'Edge') !== FALSE) //Microsoft Edge
       $explo='Microsoft Edge';
     elseif(strpos($datos[$i], 'Trident') !== FALSE) //IE 11
        $explo='Internet explorer';
     elseif(strpos($datos[$i], 'Opera Mini') !== FALSE)
       $explo="Opera Mini";
     elseif(strpos($datos[$i], 'Opera') || strpos($datos[$i], 'OPR') !== FALSE)
       $explo="Opera";
     elseif(strpos($datos[$i], 'Firefox') !== FALSE)
       $explo='Mozilla Firefox';
     elseif(strpos($datos[$i], 'Chrome') !== FALSE)
       $explo='Google Chrome';
     elseif(strpos($datos[$i], 'Safari') !== FALSE)
       $explo="Safari";

       if ($explo!='0'){
           $version=$datos[$i+1];
            break;
       }
    }

    return array($explo,$version);
    
    }

?>