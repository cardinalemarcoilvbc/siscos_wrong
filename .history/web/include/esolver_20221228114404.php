<?php
class esolver
{
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
                    "<h1>ERRORE  attenzione la directory di origine
         non esiste controllare il config.ini voce oripath</h1>" . '<br>';
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

    public function creafile_comfer($file)
    {

//$tmpfile = fopen($file, "a+")
//or die("non sono riuscito ad aprire il file ".$file);
        $ini_array = parse_ini_file("config.ini", true/* will scope sectionally */);
        $ext = $ini_array['Parametri']['estensione'];
        $directory = new DirectoryIterator(dirname(__FILE__));
        $di = str_replace('include', '', $directory->getPath());
        clearstatcache();
//die($directory);
        $file = ($di . $ini_array['percorsi']['toelab'] . $file);
//die($file);
        $myfile = fopen($file, "c+") or die("Unable to open file!");
//echo filesize($file).'<br>';
//var_dump(filesize($file));

//die( $file.filesize($file))     ;

        //   $myfile = fopen("ft_conta.txt", "r") or die("Unable to open file!");
//$ndoc = fread($myfile, filesize("ft_conta.txt"));

        //fclose($myfile);
        $i = 1;
        $mod = "";
        while (!feof($myfile)) {

            $line = ltrim(rtrim(fgets($myfile)));

            isset($line) ? $line : die('la linea del file è vuota!!!');
            
            if (strlen(ltrim(rtrim($line))) > 0) {
         //       echo $line . '<br>';
                if (strlen(ltrim(rtrim($mod))) > 0) {
                    $mod = $mod . PHP_EOL . $line;
                } else { $mod = $mod . $line;
                }
                $i = $i + 1;

                     }
        }
       // echo '<br>mod<br>';
        //echo $mod . '<br>';
        $mod=$mod.PHP_EOL."ZZ".str_pad($i,6,'0',STR_PAD_LEFT);
        $mod=$mod.PHP_EOL;
        $tmpfilename=$di . $ini_array['percorsi']['procfiles'].
   '2C'.str_replace(':','',date("H:i:s")).'.052';
   $wfile= fopen(  $tmpfilename,'w');  
  fwrite($wfile, $mod);
//fwrite($file, $ndoc .PHP_EOL.'ZZZZ' );
sleep(2);
$this->transmit_file_comfer( $tmpfilename);

    }
    public function transmit_file_comfer($file)
    {
 
$log_ftp='';
$lf=fopen(date("Y-m-d").'_log.txt','a');

$ini_array = parse_ini_file("config.ini", true/* will scope sectionally */);

$ftp_param=$ini_array['ftp'];


echo $file.'<br>';
$log_ftp=$log_ftp.date("Y-m-d H:i:s").':   INZIO OPERAZIONI PER IL FILE '.$file . '<br>';
fwrite($lf, str_replace('<br>', PHP_EOL, $log_ftp));

//echo $ftp_param['user'] . '<br>';
//echo $ftp_param['pass'] . '<br>';
//echo $ftp_param['url'] . '<br>';
//echo $ftp_param['dir'] . '<br>';

$msg= 'mi connetto a :'.$ftp_param['url'] . '<br>';
echo $msg;
$log_ftp = $log_ftp . date("Y-m-d H:i:s") .':   '. $msg . '<br>';
fwrite($lf, str_replace('<br>', PHP_EOL, $log_ftp));


$ftp = ftp_connect($ftp_param['url'] ) or die("Couldn't connect to $ftp_server");

$msg =$ftp ?  'connessione effettuata'.'<br>' :'<h1>ERRORE  connessione fallita</H1><br>';
echo $msg;

$ftp_l=ftp_login($ftp,$ftp_param['user'],$ftp_param['pass'])
or die("login fallito!!")
;
$msg = $ftp_l ? 'login effettuato' . '<br>' : '<h1>ERRORE  login fallita!!</H1><br>';
echo $msg;
$log_ftp = $log_ftp . date("Y-m-d H:i:s") . ':   ' . $msg . '<br>';
fwrite($lf, str_replace('<br>', PHP_EOL, $log_ftp));



$ftp_cd=ftp_chdir($ftp, $ftp_param['dir'])or die("directory non esistente");
$msg = $ftp_cd ? 'cambio dir effettuato' . '<br>' : '<h1>ERRORE  cambio dir fallita!!</H1><br>';
echo $msg;
$log_ftp = $log_ftp . date("Y-m-d H:i:s") . ':   ' . $msg . '<br>';
fwrite($lf, str_replace('<br>', PHP_EOL, $log_ftp));


//$file= str_replace('/','\\',$file) ;
$fp = fopen($file, 'r') or die("file non esistente");

$ftp_upd=ftp_fput($ftp,basename($file),$fp,FTP_ASCII);
$msg = $ftp_upd ? 'upload effettuato' . '<br>' : '<h1>ERRORE   upload  fallita!!</H1><br>';
echo $msg;
$log_ftp = $log_ftp . date("Y-m-d H:i:s") . ':   ' . $msg . '<br>';

fwrite($lf,str_replace('<br>',PHP_EOL,$log_ftp));

$res = ftp_size($ftp, basename($file));
$nfile=basename($file);
if ($res != -1) {
    $msg= "dimensione  $nfile è  $res bytes<br>";
   echo $msg;
   $log_ftp = $log_ftp . date("Y-m-d H:i:s") . ':   ' . $msg . '<br>';
fwrite($lf, str_replace('<br>', PHP_EOL, $log_ftp));


} else {
    $msg= "file a 0 bytes <br>riprovo trasmissione<br>";
    $ftp_upd = ftp_fput($ftp, basename($file), $fp, FTP_ASCII);
$msg = $ftp_upd ? 'upload effettuato' . '<br>' : '<h1>ERRORE  upload  fallita!!</H1><br>';
echo $msg;
$log_ftp = $log_ftp . date("Y-m-d H:i:s") . ':   ' . $msg . '<br>';
fwrite($lf, str_replace('<br>', PHP_EOL, $log_ftp));


$res = ftp_size($ftp, basename($file));
$msg = ($res != -1) ? 'upload effettuato' . '<br>' : '<h1>ERRORE  upload  fallita!!</H1><br>';
echo $msg;
$log_ftp = $log_ftp . date("Y-m-d H:i:s") . ':   ' . $msg . '<br>';
fwrite($lf, str_replace('<br>', PHP_EOL, $log_ftp));

}

// close the connection
ftp_close($ftp);
$msg ="CHIUDO CONNESSIONE FTP PER IL FILE ".basename($file).'<br>';
$log_ftp = $log_ftp . date("Y-m-d H:i:s") . ':   ' . $msg . '<br>';
fwrite($lf, str_replace('<br>', PHP_EOL, $log_ftp));

    }

}
