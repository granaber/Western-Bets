<?php
require('prc_php.php');
$serial = $_REQUEST["serial"];
settype($serial, 'integer');

echo json_encode(pescrute($serial, 0));
