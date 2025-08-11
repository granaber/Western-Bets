<?php    
 require('prc_php.php'); 
 $GLOBALS['link'] = Connection::getInstance();  
 

 $idcn=$_REQUEST['jn'];
 $carr=$_REQUEST['carr'];


 
 $resultado=cierreHI($idcn,$carr,1);
 
 echo json_encode($resultado);
