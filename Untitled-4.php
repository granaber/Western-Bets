
<?php
  $valorss='110';
 	  if (abs($valorss)<=99):
		$valordysplay=$valorss;				

		$r = fmod($valorss, 1);
	  else:
	    $valordysplay=$valorss/10; 
	    $r = fmod($valorss, 10);
	  endif;
			  
	  if($r!=0):		
	    if ($valorss<0):
		    $valordysplay=$valordysplay+.5;
		else:
	     	$valordysplay=($valordysplay-.5);				
		endif;
			$valordysplay=$valordysplay."&frac12;";
	  endif;
			
	  $anexo='';
	  if ($valorss>0):
	       $anexo='+';
	  endif;
	  
	  $valordysplay=$anexo.$valordysplay;
	  
	  echo  $valordysplay;

?>

<table width="200" >
  <tr>
    <th scope="col" style="border-bottom:solid">&nbsp;</th>
    <th scope="col" style="border-right: outset  ">&nbsp;</th>
    <th scope="col">&nbsp;</th>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>