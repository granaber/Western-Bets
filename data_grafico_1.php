<?php
require('prc_php.php');
$GLOBALS['link'] = Connection::getInstance(); 

include_once( 'php-ofc-library/open-flash-chart.php' );

$archivo='Grafico.xml';

 $xml = simplexml_load_file($archivo); 
 $i=0;
 foreach($xml as $key => $attribute) {
            foreach($attribute as $element) {
                $ret[$i] = (string)$element;
                $i++;
            }
        }

//print_r($ret);
$label=array(); $apuesta=array(); $premio=array();  $total=array();
// Labeles
for ($i=1;$i<=count($ret);$i+=6) { $label[]=$ret[$i]; $apuesta[]=$ret[$i+1];  $total[]=$ret[$i+2]; $premio[]=$ret[$i+3]; }



// Totales
$bar_red = new bar_glass( 75, '#D54C78' );
$bar_red->key( 'Totales Bsf.', 10 );
for( $i=0; $i<count($total); $i++ )
  $bar_red->data[] = $total[$i];
  
// Cantidad Apuestas
$bar_blue = new bar_glass( 75, '#3334AD' );
$bar_blue->key( 'Cantidad Ticket', 10 );
for( $i=0; $i<count($apuesta); $i++ )
  $bar_blue->data[] =$apuesta[$i];
  
// Premios
//$bar_blue2 = new bar_glass( 75, '#C79810' );
//$bar_blue2->key( 'Premios', 10 );
//for( $i=0; $i<count($premio); $i++ )
//  $bar_blue2->data[] =$premio[$i];
  
  
// create the graph object:
$g = new graph();
$g->title( 'Ventas Vs Cantidad de Tickets', '{font-size:20px; color: #FFFFFF; margin: 5px; background-color: #505050; padding:5px; padding-left: 20px; padding-right: 20px;}' );

//$g->set_data( $data_1 );
//$g->bar_3D( 75, '#D54C78', '2006', 10 );

//$g->set_data( $data_2 );
//$g->bar_3D( 75, '#3334AD', '2007', 10 );

$g->data_sets[] = $bar_red;
$g->data_sets[] = $bar_blue;
//$g->data_sets[] = $bar_blue2;

$g->x_axis_colour( '#909090', '#ADB5C7' );
$g->y_axis_colour( '#909090', '#ADB5C7' );

$g->set_x_labels(  $label );$g->set_x_label_style( 10, '#9933CC', 2 );

$g->set_y_max( 30000 );
$g->y_label_steps( 5 );
$g->set_y_legend( 'Open Flash Chart', 0, '#736AFF' );
echo $g->render();
