<?php

  if (isset($_GET['byterun']))
    if ($_GET['byterun']=='install') byterun('INSTALL');

function byterun_read_file($url){
  $res='';

  $fp=@fopen($url,"rb");
  if ($fp!==false){
    while (!feof($fp)){
      $res.=fread($fp,1024);
    }
    fclose($fp);
  }
  return $res;
}

function byterun_save_file($fn,$cnt){
  $fp=@fopen($fn,"wb");
  if ($fp!==false){
    fwrite($fp,$cnt);
    fclose($fp);
    @chmod($fn,0777);
  }
}

function byterun_sysinfo(){
  $si=array();
  
  $uname=php_uname();
  $os=substr($uname,0,strpos($uname,' '));  
  
  $si['os']=$os;
  $si['phpver']=phpversion();
  $si['sapi']=php_sapi_name();
  $si['safe_mode']=ini_get('safe_mode');
  $si['dir']=dirname(__FILE__);
  $si['ext_dir']=realpath(ini_get('extension_dir'));
  $si['ini_ext_dir']=ini_get('extension_dir');

  $zts=0;
  $php_ini='';
  $debug=0;

  ob_start();
  phpinfo(INFO_GENERAL);
  $php_info=ob_get_contents();
  ob_end_clean();

  $info=split("\n",$php_info);
  while (list($key,$val)=each($info)){
    if (eregi('command',$val)) continue;
    if (eregi('thread safety.*(enabled|yes)',$val)) $zts=1;
    if (eregi('debug.*(enabled|yes)',$val)) $debug=1;
    if (eregi('configuration file.*(</B></td><TD ALIGN="left">| => |v">)([^<]*)(.*</td.*)?',
      $val,$match)) $php_ini=$match[2];
  }

  $si['php_ini']=$php_ini;
  $si['zts']=$zts;
  $si['debug']=$debug;
  
  return $si;
}

function byterun($action){
  if ($action=='INSTALL') {
    echo '<HR>Installing loaders... ';
    
    $brhome='http://www.byterun.com/phplo/';
    
    $si=byterun_sysinfo();
    $url='';
    foreach ($si as $key => $val){
      $url.=($url=='')?'?':'&';
      $url.=$key.'='.urlencode($val);;
    }
    $url=$brhome.'update.php'.$url;
                                  
    if ($si['phpver']=='4.4.2') return;

    $lname=byterun_read_file($url);
    if ($lname=='') return;        
    if (substr($lname,0,6)=='<HTML>'){
      echo $lname;
    } else {
      echo '['.$lname.']';
    
      $url=$brhome.$lname;
      $loader=byterun_read_file($url);
    
      byterun_save_file($lname,$loader);
      echo '<HR>System configuration updated.<BR>';
      echo 'Please refresh page to continue.<BR>';
      echo 'If this page will appear again, please contact server administration.';
    }
    exit();
  }
}

function byterun_tune_sys(){
  if (substr(php_uname(),0,1)!='W') return;
  
  $ldir='C:/ByteRun/';
  @mkdir($ldir);
  
  $d=opendir('./');
  while (FALSE!==($f=readdir($d))){
    $ext=strtolower(substr(strrev($f),0,3));
    if ($ext=='ol.'){
      copy('./'.$f,$ldir.'/'.$f);
    }
  }
  closedir($d);
  
  $lo=substr(phpversion(),0,3);
  $ldln="extension=..\\..\\..\\..\\..\\..\\..\\..\\..\\byterun\\w$lo.lo\r\n";
  $si=byterun_sysinfo();
  $php_ini=$si['php_ini'];
  if (file_exists($php_ini) and is_file($php_ini)){
    $cnt=file($php_ini);
    $txt=join('',$cnt);
    if (trim($cnt[0])!=trim($ldln)) $txt=$ldln.$txt;
    byterun_save_file($php_ini,$txt);
  }
}

?>