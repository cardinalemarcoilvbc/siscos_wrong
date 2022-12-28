<?php
class esolver{
    public function elefile($dir)
    {
        ini_set('display_errors', '1');
        ini_set('display_startup_errors', '1');
        error_reporting(E_ALL);
    
    $ini_array = parse_ini_file("config.ini", true/* will scope sectionally */);
$ext = $ini_array['Parametri']['estensione'];
//  echo  str_replace('include','',__DIR__).$ini_array['percorsi']['oripath'].'<br>';
//    echo  (str_replace('include','',__DIR__).$ini_array['percorsi']['oripath']).'<br>';
if (!is_dir(str_replace('include', '', __DIR__) . $ini_array['percorsi']['oripath'])
) {

    mkdir('/app/web/toelab/', 0777);
 //         echo $this->folder_exist('/app/web/toelab/').'<br>';
    if (!is_dir('/app/web/toelab/')) {

        echo 
        "<H1>attenzione la directory di origine 
         non esiste controllare il config.ini voce oripath</h1>".'<br>';
    }
}
//var_dump($ini_array);
$ext = $ini_array['EXTENSION'];
$search = '{';
foreach ($ext['ext'] as $value) {
    $search = $search . str_replace('.', '', $value) . ',';
}
$search = $search . '}';
$search = str_replace(',}', '}', $search);
$oripath = glob('.\\' . $ini_array['percorsi']['oripath'] . '*.' . $search, GLOB_BRACE);
// glob($ini_array['percorsi']['oripath'] . $ext);
 //var_dump($oripath);
 //var_dump($ini_array['percorsi']['oripath']);
$directory = new DirectoryIterator(dirname(__FILE__));
$di = str_replace('include', '', __DIR__);
//var_dump($oripath);
foreach ($oripath as $f) {
    if (!file_exists($di . $ini_array['percorsi']['procfiles'] . (basename($f)))) {
        copy($f, $di . $ini_array['percorsi']['toelab'] . (basename($f)));
    } else {
    }
}
$res = [];
if ($dir == 1) {
    $lpath = glob($di . $ini_array['percorsi']['toelab'] . '*.' . $search, GLOB_BRACE);
    foreach ($lpath as $f) {
        if (!file_exists($di . $ini_array['percorsi']['procfiles'] . (basename($f)))) {
            array_push($res, basename($f));
        }
    }
} else {
    $lpath = glob($di . $ini_array['percorsi']['procfiles'] . '*.' . $search, GLOB_BRACE);

    foreach ($lpath as $f) {
        array_push($res, basename($f));
    }

}

return array_unique($res);

    
    
    }





public function creafile_comfer($file){

//$tmpfile = fopen($file, "a+")
//or die("non sono riuscito ad aprire il file ".$file);
    $ini_array = parse_ini_file("config.ini", true/* will scope sectionally */);
$ext = $ini_array['Parametri']['estensione'];
$directory = new DirectoryIterator(dirname(__FILE__));
$di = str_replace('include', '', $directory->getPath());
clearstatcache();
//die($directory);
$file=($di . $ini_array['percorsi']['toelab'].$file);
//die($file);
$myfile = fopen($file, "c+") or die("Unable to open file!");
//echo filesize($file).'<br>';
//var_dump(filesize($file));

//die( $file.filesize($file))     ;

     //   $myfile = fopen("ft_conta.txt", "r") or die("Unable to open file!");
//$ndoc = fread($myfile, filesize("ft_conta.txt"));

        //fclose($myfile);
$i=1;
$mod="";
      while (!feof($myfile)) {
        
          $line = ltrim(rtrim(fgets($myfile)));
         
          isset($line) ? $line : die('la linea del file è vuota!!!');
            if (strlen(ltrim(rtrim($line)))<>0 && $i=1){
$mod=$line;
            }
            elseif(strlen(ltrim(rtrim($line)))<>0){
          $mod=$mod.PHP_EOL.$line;      


            } 
          $i=$i+1;
          echo $strlen(ltrim(rtrim($line)).'<br>';
        }
//  fwrite($tmpfile, $rows[0]['corrispettivi']);
//fwrite($file, $ndoc .PHP_EOL.'ZZZZ' );

//fclose($file);



}
public function transmit_file_comfer($file)
{



}

























}


?>