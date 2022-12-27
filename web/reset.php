
<?php 
include(__DIR__.'/include/ls.php');
include(__DIR__.'/include/PB.php');

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


$ini_array = parse_ini_file("config.ini", true /* will scope sectionally */);
$ls= new ls();

 
//$ls->localelab();
$directory = new DirectoryIterator(dirname(__FILE__));
$di =str_replace('include','',$directory->getPath());
$di=str_replace(__DIR__,'include','');
//var_dump($ini_array);
$lpath = glob(__DIR__.''.$ini_array['percorsi']['toelab'].'*');

//echo $di.$ini_array['percorsi']['procfiles'];
//var_dump(__DIR__.''.$ini_array['percorsi']['toelab'].'*');
    foreach ($lpath as $f) {
   echo  "rimosso file {$f}<br>";
$ls->reset($f);
    }
 //   echo $di.$ini_array['percorsi']['procfiles'];
    $lpath = glob($di.''.$ini_array['percorsi']['procfiles'].'*');
  //  var_dump($lpath);
    foreach ($lpath as $f) {
   echo  "rimosso file {$f}<br>";
$ls->reset($f);
    }

$web= glob(__DIR__.'/*.csv');
 
foreach ($web as $f) {
  echo  "rimosso file {$f}<br>";
$ls->reset($f);
   }
  echo 
  <<<EOT
  <h1><a href="./index.php">Terminato torna indietro</a></h1><br/>
EOT;
?>
 