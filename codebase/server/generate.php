<?php

require_once 'gridPdfGenerator.php';
require_once 'tcpdf/tcpdf.php';
require_once 'gridPdfWrapper.php';

$debug = false;
$error_handler = set_error_handler("PDFErrorHandler");


	$xmlString = stripslashes($_POST['grid_xml']);

if ($debug == true) {
	error_log($xmlString, 3, 'debug_'.date("Y_m_d__H_i_s").'.xml');
}
$f1=$_REQUEST['f1'];$f2=$_REQUEST['f2'];
$xml = simplexml_load_string($xmlString);
$pdf = new gridPdfGenerator();
$pdf->printGrid($xml,$f1,$f2);

function PDFErrorHandler ($errno, $errstr, $errfile, $errline) {
	global $xmlString;
	if ($errno < 1024) {
		error_log($xmlString, 3, 'error_report_'.date("Y_m_d__H_i_s").'.xml');
		exit(1);
	}

}
