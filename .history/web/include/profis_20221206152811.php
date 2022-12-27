
<?php
class profis
{
    /*
    linea file
    0 Codice
    1 Ragione Sociale
    2 Tipo soggetto
    3 "Ditta AA7"
    4 Annotazioni
    5 Titolare P.IVA
    6 Partita IVA
    7 Codice Fiscale
    8 Indirizzi
     */

    public function create_Ana($file, $id = null, $ateco)
    {

        $ind = $id;
        $ini_array = parse_ini_file("config.ini", true/* will scope sectionally */);
        //$ini_xml = parse_ini_file("xml.ini", true /* will scope sectionally */);
        $ateco = str_pad(str_replace('.', '', $ateco), 6, ' ');
        $ext = $ini_array['Parametri']['estensione'];
        $sep = $ini_array['Parametri']['sep'];
        $f = $file;
        ((is_null($ind) == true) ? $ind = 1 : $ind);
        $directory = new DirectoryIterator(dirname(__FILE__));
        $di = str_replace('include', '', $directory->getPath());
        $file_ = $di . $ini_array['percorsi']['toelab'] . (basename($f));
        //file2 = file_get_contents($file_);
        $row = '';
        if ($file = fopen($file_, "r")) {
            while (!feof($file)) {
                $line = ltrim(rtrim(fgets($file)));

                $arr_row = explode(';', $line);
                if (sizeof($arr_row) != 9) {
                    //      echo 'ATTENZIONE NUMERO CAMPI ERRATO!!!!<br>'.
                    //     'I CAMPI PRESENTI SONO :'.sizeof($chk).'<br> E DOVREBBERO ESSERE 9'.'<br>';
                    // fclose($file);
                    $line = '';

                }
                // var_dump($myArray);
                if (!strpos($line, 'Partita iva') && strlen($line) != 0) {

                    $row = $row . '"AGE"' . $sep . '"' . $arr_row[6] . '"'
                        . $sep . '"' . $arr_row[7] . '"' . $sep . '"' . $arr_row[0] . '"' . $sep . PHP_EOL;

                }

            }
            fclose($file);
        }

        //echo $row.'<br>';
        return $row;

    }

    public function creaditta_File($file, $id = null, $ateco,$tper)
    {

       
      // die($tper);
        $ind = $id;
        $ini_array = parse_ini_file("config.ini", true/* will scope sectionally */);
//$ini_xml = parse_ini_file("xml.ini", true /* will scope sectionally */);
        $ateco = str_pad(str_replace('.', '', $ateco), 6, ' ');
        $ext = $ini_array['Parametri']['estensione'];
        $sep = $ini_array['Parametri']['sep'];
        $f = $file;
        ((is_null($ind) == true) ? $ind = 1 : $ind);
        $directory = new DirectoryIterator(dirname(__FILE__));
        $di = str_replace('include', '', $directory->getPath());
        $file_ = $di . $ini_array['percorsi']['toelab'] . (basename($f));
//file2 = file_get_contents($file_);
        $row = '';
        $err1 = 0;
       
        if ($file = fopen($file_, "r")) {
            $ind = 0;
            while (!feof($file)) {
                $line = ltrim(rtrim(fgets($file)));
                //  echo $line;
                // echo gettype($line);
                // echo '<br><br>';
                # do same stuff with the $line
                $line2 = $line;
if ($ind==0) {
   // echo $line.'<br>';
    $line=str_replace(array("\r", "\n"), '', $line);
   // echo $line.'<br>';
}

                $chk = explode(';', $line);
              if (strpos($line,'"')){
                die ("è stato trovato un carattere non valido nella riga <br>".$line);

              }
              
                if (sizeof($chk) != 9 && strlen($line) != 0 && $ind >=3) {
                    echo 'ATTENZIONE NUMERO CAMPI ERRATO!!!!<br>' .
                    'I CAMPI PRESENTI SONO :' . sizeof($chk) . '<br> E DOVREBBERO ESSERE 9' . '<br>';
                    // fclose($file);
                    $line = '';
                    $err1 = 1;
                }

                if ($ind == 0 && 1==2
                    && strtoupper($line) !=
                    'CODICE;RAGIONE SOCIALE;TIPO SOGGETTO;"Ditta AA7";ANNOTAZIONI;TITOLARE P.IVA;PARTITA IVA;CODICE FISCALE;INDIRIZZI'
                ) {
                    echo 'ATTENZIONE I NOMI DI COLONNA SONO ERRATI!!!!<br>' .

                    // fclose($file);
                    $err1 = 1;

                }

                if (!strpos($line, 'Partita iva') && strlen($line) != 0 && $err1 == 0 && $ind>=3) {
                    $fc = $this->build_d0($ateco, $line);
                    $fc = $fc . $this->build_d1($line, $ateco);
                    $fc = $fc . $this->build_d2($line, $ateco);
                    $fc = $fc . $this->build_d3($line, $ateco,$tper);

        
                    $row = $row . $fc;
                }

                $ind = $ind + 1;
            }
            fclose($file);
        }

        echo $f //$basename($file_)
         . '</td></tr><tr><td>';
        return $row;
    }

    /*
    linea file
    0 Codice
    1 Ragione Sociale
    2 Tipo soggetto
    3 "Ditta AA7"
    4 Annotazioni
    5 Titolare P.IVA
    6 Partita IVA
    7 Codice Fiscale
    8 Indirizzi
     */

    public function build_d0($ateco, $line)
    {
        //print_r($line);
        $line2 = explode(';', $line);

        // print_R($line2);
        // $ris=$line.'D0'.$ateco.$line;
        isset($line) ? $line : die('la linea del file è vuota!!!');
        $ris = 'D0' . '0'; //proc +id
        $ris = $ris . "  " . str_pad($line2[0], 6, ' '); //gruppo archivi profis + cod ditta
        $ris = $ris . str_pad((strlen($line2[0])>=3 ? ' ':$line2[6]), 12, ' ', STR_PAD_LEFT); //partitaiva
        $ris = $ris . str_pad((strlen($line2[0])>=3  ? ' ':$line2[7]), 16, ' ', STR_PAD_LEFT); //codice fiscale
        $ris = $ris . '0' . '0' . '0' . '0' . '0' . '1'; //cei,rcf,cls,css,gpar,sc3
        $ris = $ris . '1' . '1' . '0' . '0' . '0' . '0'; //csp3,crt3,psg3,psp3,anric3
        $ris = $ris . '0' . '0' . '0' . '0' . '0' . '0'; //adg3,bil3,ftp3,cbl3,edf3
        $ris = $ris . '0' . '1'; //gcom3,acc3
        $ris = $ris . '0101' . date('Y'); //datai
        $ris = $ris . str_pad(' ', 8, ' ', STR_PAD_LEFT); //'3112'.date('Y'); //dataf
        $ris = $ris . str_pad(' ', 514);
        $ris = $ris . '2021.7  ' . 'A';
        //$ateco  ;
        echo '<tr><td>'.$ris . '</td></tr>';
        return $ris .   ( DIRECTORY_SEPARATOR === '\\' ?  PHP_EOL :"\r".PHP_EOL );
    }
    public function build_d1($line, $ateco)
    {
        //   $t=file_get_contents($file);
        $line2 = explode(';', $line);

        $ris = 'D1';
        $ris = $ris . str_pad($line2[0], 6, ' '); //codice ditat profis
        $ris = $ris . str_pad((strlen($line2[0])>=3 ? ' ':$line2[6]), 12, ' ', STR_PAD_LEFT); //partitaiva
        $ris = $ris . str_pad((strlen($line2[0])>=3  ? ' ':$line2[7]), 16, ' ', STR_PAD_LEFT); //codice fiscale
        $ris = $ris . date('Y'); //date('Y-m-d H:i:s') ;//ese
        $ris = $ris . '0101' . date('Y'); //datai
        //$ris = $ris . str_pad(' ', 8, ' ', STR_PAD_LEFT);
        ////
        $ris = $ris .'3112'.date('Y'); //dataf
        $ris = $ris . '   '; //cvalu
        $ris = $ris . ' 0'; //GestContEntiTerSet numero 2
        $ris = $ris . str_pad(' ', 528); //blk
        $ris = $ris . '2021.7  ' . 'A' . ( DIRECTORY_SEPARATOR === '\\' ?  PHP_EOL :"\r".PHP_EOL );
        echo '<tr><td>'.$ris . '</td></tr>';
        return $ris;
    }
    public function build_d2($line, $ateco)
    {
        // $t=file_get_contents($file);
        $line2 = explode(';', $line);

        //  print_R($line2);
        $ris = 'D2';
        $ris = $ris . str_pad($line2[0], 6, ' '); //codice ditat profis
        $ris = $ris . str_pad((strlen($line2[0])>=3 ? ' ':$line2[6]), 12, ' ', STR_PAD_LEFT); //partitaiva
        $ris = $ris . str_pad((strlen($line2[0])>=3  ? ' ':$line2[7]), 16, ' ', STR_PAD_LEFT); //codice fiscale
        $ris = $ris . date('Y'); //ese
        $ris = $ris . ' 0'; //atc numero 2
        $ris = $ris . str_pad($ateco, 6, ' '); //cate07
        $ris = $ris . str_pad(' ', 5); //cate
        $ris = $ris . str_pad(' ', 50); //atdes
        // $ris = $ris . '0101' . date('Y'); //datai
        //$ris = $ris . str_pad(' ', 8, ' ', STR_PAD_LEFT); //
        $ris = $ris . str_pad(' ', 8, ' ', STR_PAD_LEFT);//datai
        $ris = $ris . str_pad(' ', 8, ' ', STR_PAD_LEFT);//dataf
        //$ris = $ris .'3112'.date('Y'); //dataf
        $ris = $ris . '0'; //attsr
        $ris = $ris . '1'; //ambc
        $ris = $ris . '2'; //rec
        $ris = $ris . '0'; //drcdip
        $ris = $ris . '0'; //rcm
        $ris = $ris . str_pad('S1', 6); //cpc
        $ris = $ris . '0'; //ssp
        $ris = $ris . str_pad('0', 6, ' ', STR_PAD_LEFT); //ppim
        $ris = $ris . str_pad('0', 6, ' ', STR_PAD_LEFT); //prit
        $ris = $ris . '0'; //tnpn
        $ris = $ris . '0'; //gio
        $ris = $ris . '0'; //rpro
        $ris = $ris . '0'; //crisc
        $ris = $ris . '0'; //refo
        $ris = $ris . str_pad(' ', 6, ' ', STR_PAD_LEFT); //sfr
        $ris = $ris . str_pad(' ', 3, ' ', STR_PAD_LEFT); //rsr
        $ris = $ris . str_pad(' ', 6, ' ', STR_PAD_LEFT); //gsf
        $ris = $ris . '0'; //tebil
        $ris = $ris . str_pad('0', 3, ' ', STR_PAD_LEFT); //gru
        $ris = $ris . str_pad('0', 3, ' ', STR_PAD_LEFT); //spe
        $ris = $ris . ' '; //app
        $ris = $ris . '1'; //adc
        $ris = $ris . '0'; //mrac
        $ris = $ris . '0'; //dicc
        $ris = $ris . '1'; //IAAbbAliFis
        $ris = $ris . str_pad('0', 17, ' ', STR_PAD_LEFT); //lra
        $ris = $ris . '0'; //rba
        $ris = $ris . '2'; //mcm
        $ris = $ris . '0'; //rcei
        $ris = $ris . '1'; //cdr
        $ris = $ris . '0'; //caf
        $ris = $ris . '0'; //efin
        $ris = $ris . '0'; //gestdatieroglib
        $ris = $ris . '0'; //comdatispesescuole
        $ris = $ris . '  '; //cau
        $ris = $ris . str_pad(' ', 387); //blk
        $ris = $ris . '2021.7  ' . 'A' . ( DIRECTORY_SEPARATOR === '\\' ?  PHP_EOL :"\r".PHP_EOL );
        echo '<tr><td>'.$ris . '</td></tr>';
        return $ris;
    }
    public function build_d3($line, $ateco,$tper)
    {
        // $t=file_get_contents($file);
        $line2 = explode(';', $line);
        $ris = 'D3';
        $ris = $ris . str_pad($line2[0], 6, ' ');
        $ris = $ris . str_pad((strlen($line2[0])>=3 ? ' ':$line2[6]), 12, ' ', STR_PAD_LEFT); //partitaiva
        $ris = $ris . str_pad((strlen($line2[0])>=3  ? ' ':$line2[7]), 16, ' ', STR_PAD_LEFT); //codice fiscale
        $ris = $ris . date('Y'); //aiv
        $ris = $ris . str_pad('01', 2, ' ', STR_PAD_LEFT); //ati
        $ris = $ris . str_pad($ateco, 6, '0'); //cate07
        $ris = $ris . str_pad(' ', 5, ' ', STR_PAD_LEFT); //cate
        $ris = $ris . str_pad(' ', 50, ' ', STR_PAD_LEFT); //atdes
        $ris = $ris . '0101' . date('Y'); //ATDINI
        //$ris = $ris . str_pad(' ', 8, ' ', STR_PAD_LEFT); //.'3112'.date('Y'); //ATDFIN
        $ris = $ris .'3112'.date('Y'); //ATDFIN
        $ris = $ris . '0'; //attsr
        $ris = $ris . str_pad('0', 2, ' ', STR_PAD_LEFT); //riv
        
        $ris = $ris . str_pad($tper, 2, ' ', STR_PAD_LEFT); //tper
      //  die($tper);
        if ($tper==3){
            $ris = $ris . str_pad('1', 1, ' ', STR_PAD_LEFT); //cit

        }
        else{
    $ris = $ris . str_pad('0', 1, ' ', STR_PAD_LEFT); //cit
}
        $ris = $ris . str_pad('0', 1, ' ', STR_PAD_LEFT); //pro
        $ris = $ris . str_pad(' ', 6, ' ', STR_PAD_LEFT); //prod
        $ris = $ris . str_pad('0', 1, '0', STR_PAD_LEFT); //a36
        $ris = $ris . str_pad('0', 1, '0', STR_PAD_LEFT); //a1t
        $ris = $ris . str_pad('0', 1, '0', STR_PAD_LEFT); //a1p
        $ris = $ris . str_pad(' ', 6, ' ', STR_PAD_LEFT); //pFOR
        $ris = $ris . str_pad('0', 2, ' ', STR_PAD_LEFT); //cris
        $ris = $ris . str_pad('0', 1, '0', STR_PAD_LEFT); //impi
        $ris = $ris . str_pad(' ', 1, ' ', STR_PAD_LEFT); //butr
        $ris = $ris . str_pad('0', 1, '0', STR_PAD_LEFT); //bute
        $ris = $ris . str_pad('0', 1, '0', STR_PAD_LEFT); //bugab
        $ris = $ris . str_pad('0', 6, ' ', STR_PAD_LEFT); //pml
        $ris = $ris . str_pad('0', 1, '0', STR_PAD_LEFT); //riac
        $ris = $ris . str_pad('0', 1, '0', STR_PAD_LEFT); //edrr
        $ris = $ris . str_pad('0', 3, ' ', STR_PAD_LEFT); //nracq
        $ris = $ris . str_pad('0', 3, ' ', STR_PAD_LEFT); //nrvem
        $ris = $ris . str_pad('0', 3, ' ', STR_PAD_LEFT); //nrcor
        $ris = $ris . str_pad('0', 17, ' ', STR_PAD_LEFT); //capr
        $ris = $ris . str_pad('0', 2, ' ', STR_PAD_LEFT); //cappr
        $ris = $ris . str_pad('0', 17, ' ', STR_PAD_LEFT); //ccpr
        $ris = $ris . str_pad('0', 1, '0', STR_PAD_LEFT); //ecai
        $ris = $ris . str_pad('0', 1, '0', STR_PAD_LEFT); //edia
        $ris = $ris . str_pad('0', 1, '0', STR_PAD_LEFT); //eliq
        $ris = $ris . str_pad('0', 1, '0', STR_PAD_LEFT); //ecdf
        $ris = $ris . str_pad('0', 1, '0', STR_PAD_LEFT); //ecdot
        $ris = $ris . str_pad('0', 1, '0', STR_PAD_LEFT); //blges
        $ris = $ris . str_pad('0', 1, '0', STR_PAD_LEFT); //03attr
        $ris = $ris . str_pad('0', 1, '0', STR_PAD_LEFT); //03pasr
        $ris = $ris . str_pad(' ', 8, ' ', STR_PAD_LEFT); //03dpre
        $ris = $ris . str_pad('0', 1, '0', STR_PAD_LEFT); //f24eo
        $ris = $ris . str_pad('0', 1, '0', STR_PAD_LEFT); //iv32b
        $ris = $ris . str_pad('0', 1, '0', STR_PAD_LEFT); //ptivc32b
        $ris = $ris . str_pad('0', 1, '0', STR_PAD_LEFT); //slivc32b
        $ris = $ris . str_pad('0', 1, '0', STR_PAD_LEFT); //dciva
        $ris = $ris . str_pad('0', 1, '0', STR_PAD_LEFT); //cdps
        $ris = $ris . str_pad('0', 2, ' ', STR_PAD_LEFT); //soggint
        $ris = $ris . str_pad('0', 1, '0', STR_PAD_LEFT); //cdsf
        $ris = $ris . str_pad('0', 1, '0', STR_PAD_LEFT); //cdan
        $ris = $ris . str_pad('1', 2, ' ', STR_PAD_LEFT); //soggintan
        $ris = $ris . str_pad('0', 1, '0', STR_PAD_LEFT); //comdatispesescuole
        $ris = $ris . str_pad(' ', 360); //blk
        $ris = $ris . '2021.7  ' . 'A' . ( DIRECTORY_SEPARATOR === '\\' ?  PHP_EOL :"\r".PHP_EOL );
        echo '<tr><td>'.$ris . '</td></tr>';

        $cd_profis=str_pad($line2[0], 6, ' ');           

         
          

        $ris = $ris .'D4'.$cd_profis.'                            '.date('Y').'01479110     A001Acquisti                                          0000000                                                               1000000                                                                                                                                            000   00010    2V0010         0000 0000         00 0000         0 0000          0000         0 0000         00 0000         0 0000         0000 0000          000                                  0                                                                     2021.7  A'. ( DIRECTORY_SEPARATOR === '\\' ?  PHP_EOL :"\r".PHP_EOL );
        $ris = $ris .'D4'.$cd_profis.'                            '.date('Y').'01479110     V001Vendite                                           0000000                                                               1002000                                                                                                                                            000   00010    2 0000         0000 0000         00 0000         0 0000          0000         0 0000         00 0000         0 0000         0000 0000          000                                  0                                                                     2021.7  A'. ( DIRECTORY_SEPARATOR === '\\' ?  PHP_EOL :"\r".PHP_EOL );
        $ris = $ris .'D4'.$cd_profis.'                            '.date('Y').'01479110     C001Corrispettivi                                     0000000                                                               1002000                                                                                                                                            000   00010    0 0000         0000 0000         00 0000         0 0000          0000         0 0000         00 0000         0 0000         0000 0000          000                                  0                                                                     2021.7  A'. ( DIRECTORY_SEPARATOR === '\\' ?  PHP_EOL :"\r".PHP_EOL );
        $ris = $ris .'D8'.$cd_profis.'                            '.date('Y').'1          00001012022013311220223000000' 
        .str_pad((strlen($line2[6])<=3 ? ' ':$line2[6]), 12, ' ', STR_PAD_RIGHT) //partitaiva
        .str_pad((strlen($line2[7])<=3  ? ' ':$line2[7]), 16, ' ', STR_PAD_RIGHT) //codice fiscale
        .'0          00001012022012311220222000000'  
        .'                            0000000                                                                                                                                                                                                                                                                                                                                                                                                                      2021.7  A'. ( DIRECTORY_SEPARATOR === '\\' ?  PHP_EOL :"\r".PHP_EOL );
        $ris = $ris .'DP'.$cd_profis.'                            '.date('Y').'01479110     1222100                                                            0                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    2021.7  A'. ( DIRECTORY_SEPARATOR === '\\' ?  PHP_EOL :"\r".PHP_EOL );
        $ris = $ris .'DE'.$cd_profis.'                            '.date('Y').'01479110     00000USCRF00000  0000        00                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         2021.7  A'. ( DIRECTORY_SEPARATOR === '\\' ?  PHP_EOL :"\r".PHP_EOL );
        $ris = $ris .'DR'.$cd_profis.'                            '.date('Y').'00000000100110000000000000000 000000000000000000000000010000000000000                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                2021.7  A'. ( DIRECTORY_SEPARATOR === '\\' ?  PHP_EOL :"\r".PHP_EOL );
        $ris = $ris .'DG'.$cd_profis.'                            '.date('Y').'01479110     10200000002022010                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       2021.7  A'. ( DIRECTORY_SEPARATOR === '\\' ?  PHP_EOL :"\r".PHP_EOL );
        

        return $ris;
    }

    public function build_d4($file)
    {
        $t = file_get_contents($file);
        return $t;
    }

    public function build_d5($file)
    {
        $t = file_get_contents($file);
        return $t;
    }

    public function build_d6($file)
    {
        $t = file_get_contents($file);
        return $t;
    }

    public function build_d7($file)
    {
        $t = file_get_contents($file);
        return $t;
    }

    public function build_d8($file)
    {
        $t = file_get_contents($file);
        return $t;
    }

    public function build_dp($file)
    {
        $t = file_get_contents($file);
        return $t;
    }

    public function build_de($file)
    {
        $t = file_get_contents($file);
        return $t;
    }

    public function build_dr($file)
    {
        $t = file_get_contents($file);
        return $t;
    }

    public function build_dg($file)
    {
        $t = file_get_contents($file);
        return $t;
    }

    public function build_da($file)
    {
        $t = file_get_contents($file);
        return $t;
    }

    public function zipper()
    {
        $ini_array = parse_ini_file("config.ini", true/* will scope sectionally */);
        $uno = $ini_array['Parametri']['NomeOut'] . '.csv';
        $due = $ini_array['Parametri']['NomeANA'] . '.csv';

        $files = array($uno, $due);
        $zipname = $ini_array['Parametri']['ZipFile'] . '.zip';
        $zip = new ZipArchive;
        $zip->open($zipname, ZipArchive::CREATE);
        foreach ($files as $file) {
            $zip->addFile($file);
        }
        $zip->close();
        $di = str_replace('include', '', __DIR__);
        return $di . $ini_array['Parametri']['ZipFile'] . '.zip';

    }

    public function zipper_amz()
    {
        $ini_array = parse_ini_file("config.ini", true/* will scope sectionally */);
        $uno = $ini_array['Parametri']['Nomecorr_amz'] . '.csv';
        $due = $ini_array['Parametri']['Nometf_amz'] . '.csv';

        $files = array($uno, $due);
        $zipname = $ini_array['Parametri']['ZipFile_amz'] . '.zip';
        $zip = new ZipArchive;
        $zip->open($zipname, ZipArchive::CREATE);
        foreach ($files as $file) {
            $zip->addFile($file);
        }
        $zip->close();
        $di = str_replace('include', '', __DIR__);
        return $di . $ini_array['Parametri']['ZipFile_amz'] . '.zip';

    }


    public function crea_amz_File($file, $id = null, $ateco=null,$tper=null){
   $ini_array = parse_ini_file("config.ini", true/* will scope sectionally */);
$ind=0;
        $ext = $ini_array['Parametri']['estensione'];
$sep = $ini_array['Parametri']['sep'];
$f = $file;
((is_null($ind) == true) ? $ind = 1 : $ind);
$directory = new DirectoryIterator(dirname(__FILE__));
$di = str_replace('include', '', $directory->getPath());
$file_ = $di . $ini_array['percorsi']['toelab'] . (basename($f));
$corrispettivi='';
$fatture='';
$arr=[];
        $file = fopen($file_, "r") ;
        while (!feof($file)) {
                $line = ltrim(rtrim(fgets($file)));
                //  echo $line;
                // echo gettype($line);
                // echo '<br><br>';
                # do same stuff with the $line
                $line2 = $line;
if ($ind >= 15) {
    // echo $line.'<br>';
    $line = str_replace(array("\r", "\n"), '', $line);
    echo $line.'<br>';
    $arr[]=explode($sep,$line);
    //print("<pre>" . print_r(explode($sep,$line), true) . "</pre>");
$tmp_arr=explode($sep, $line);
//$_SESSION["newsession"]=$arr;
if (!empty($tmp_arr['0'])){  
//$corrispettivi=$corrispettivi.<<<EOT
//M1{$tmp_arr['0']}000000010909090999 10909090999     01      0111101      01111C001020120180000004000000001016T0        0000000                                                                                                                                                                      2018S1    201801000000000                                                        00000               00000000                                                             00                                                             0      000000000000        00000000000000000000000                                                                              00000000000000                                                                            470701         00Prova corrispettivo                                                                                     000    000                  00      0.               0.               0.               0.               0.               0.               20.               0.               00.               000.               0.               0.                                                                                                                                     000000                    0000000000000000 00 00000000    0.               0.               0.               0.                          0.               0.               0                                                        0000000                                            000      0.               0.               0.               0.               0.               0.               0.               0.               0.                   0.               0.               0.               0.               0.               0.               0.               0.               0.               0.               0.                                                                0.               0.               0.               0.               0.               0.               0.               0.               0.               0.               0.               0.               0.               0.               0.               00                                             0.               0.               0.               0.               0.               0.               0.                       0000000                                      00          00        000000000000000000000000000000000000    00                             00000                                                                                                                                                                                                                                                                                                                                     000000 0000        00 000000000000000000000        0000000                                                                                                                                                                                                                                                               0                0.               000                                000                    00    0                                                             00                                                                                                0000000000000                            00000                                                                                                                                                                                                                                                                           0000                                                                                                                                                                2022.5  A
//EOT.PHP_EOL;

$allv=str_replace('{var1}',$tmp_arr['0'],$ini_array['percorsi']['str_corri_1']);
$allv=str_replace('{var2}',$tmp_arr['1'],$allv) ;
$allv = str_replace('{var3}', $tmp_arr['2'], $allv);
$allv = str_replace('{var4}', $tmp_arr['3'], $allv);
$allv = str_replace('{var5}', $tmp_arr['4'], $allv);
$allv = str_replace('{var6}', $tmp_arr['5'], $allv);
$allv = str_replace('{var7}', $tmp_arr['6'], $allv);
$allv = str_replace('{var8}', $tmp_arr['7'], $allv);
$allv = str_replace('{var9}', $tmp_arr['8'], $allv);
$allv = str_replace('{var10}', $tmp_arr['9'], $allv);
$allv = str_replace('{var11}', $tmp_arr['10'], $allv);


$corrispettivi=$corrispettivi.$allv.PHP_EOL;



$fatture = $fatture . <<<EOT
M1{$tmp_arr['0']}000000010909090999 10909090999     01      0111101      01111C001020120180000004000000001016T0        0000000                                                                                                                                                                      2018S1    201801000000000                                                        00000               00000000                                                             00                                                             0      000000000000        00000000000000000000000                                                                              00000000000000                                                                            470701         00Prova corrispettivo                                                                                     000    000                  00      0.               0.               0.               0.               0.               0.               20.               0.               00.               000.               0.               0.                                                                                                                                     000000                    0000000000000000 00 00000000    0.               0.               0.               0.                          0.               0.               0                                                        0000000                                            000      0.               0.               0.               0.               0.               0.               0.               0.               0.                   0.               0.               0.               0.               0.               0.               0.               0.               0.               0.               0.                                                                0.               0.               0.               0.               0.               0.               0.               0.               0.               0.               0.               0.               0.               0.               0.               00                                             0.               0.               0.               0.               0.               0.               0.                       0000000                                      00          00        000000000000000000000000000000000000    00                             00000                                                                                                                                                                                                                                                                                                                                     000000 0000        00 000000000000000000000        0000000                                                                                                                                                                                                                                                               0                0.               000                                000                    00    0                                                             00                                                                                                0000000000000                            00000                                                                                                                                                                                                                                                                           0000                                                                                                                                                                2022.5  A
EOT.PHP_EOL;
}


}
$ind=$ind+1;
        } 

//print_R($corrispettivi);

//die();

 


$gen = [];
$gen[] = ['fattura' => $fatture, 'corrispettivi' => $corrispettivi];
//print_R($gen);


return $gen;




    }

}

?>