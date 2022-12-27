
<?php
class ls
{

    public $ini_array = array();
    function elefile($dir)
    {

    //    include __DIR__ . '/include/ls.php';
    //    include __DIR__ . '/include/PB.php';
//str_replace("ns8:", "", $tmp_xml);
        $ini_array = parse_ini_file("config.ini", true /* will scope sectionally */);
        $ext = $ini_array['Parametri']['estensione'];
       // echo  str_replace('include','',__DIR__).$ini_array['percorsi']['oripath'];
      //   echo  (str_replace('include','',__DIR__).$ini_array['percorsi']['oripath']);
        if (//!is_dir('/app/web/toelab/') 
        //|| 
        !is_dir(str_replace('include', '', __DIR__).$ini_array['percorsi']['oripath'])
        ) {

            echo "<H1>attenzione la directory di origine  non esiste controllare il config.ini voce oripath</h1>";
        }
        //var_dump($ini_array);
        $ext = $ini_array['EXTENSION'];
        $search = '{';
        foreach ($ext['ext'] as $value) {
            $search = $search  . str_replace('.', '', $value) . ',';
        }
        $search = $search . '}';
        $search = str_replace(',}', '}', $search);
        $oripath = glob('.\\' . $ini_array['percorsi']['oripath'] . '*.' . $search, GLOB_BRACE);
        // glob($ini_array['percorsi']['oripath'] . $ext);
        //var_dump($oripath);
        //var_dump($ini_array['percorsi']['oripath']);
        $directory = new DirectoryIterator(dirname(__FILE__));
        $di = str_replace('include', '', __DIR__);


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


    function localelab()
    {
        $ini_array = parse_ini_file("config.ini", true /* will scope sectionally */);
        $ext = $ini_array['Parametri']['estensione'];
        $directory = new DirectoryIterator(dirname(__FILE__));
        $di = str_replace('include', '', $directory->getPath());
        $lpath = glob($di . $ini_array['percorsi']['toelab'] . $ext);
        foreach ($lpath as $f) {
        }
    }

    /*da finire  che per il valfile  non si riesce a rimediare un xsd del nso da nessuna parte */
    function valfile($file)
    {
        $ini_array = parse_ini_file("config.ini", true /* will scope sectionally */);

        $f = $file;
        $directory = new DirectoryIterator(dirname(__FILE__));
        $di = str_replace('include', '', $directory->getPath());

        $xsd = $di . 'include\\test100.xsd';
        $xml = $di . $ini_array['percorsi']['toelab'] . (basename($f));


        libxml_use_internal_errors(true);
        libxml_clear_errors();
        if (isset($xsd) && isset($xml)) {
            $cxml = fopen($xml, "r");
            $cxsd = fopen($xsd, "r");
            /*      if ($cxml == false) {
            return "FILE  XML NON TROVATO";
        }
        if ($cxsd == false) {
            return "FILE  XSD NON TROVATO";
        }*/
        } else {
            // $xsd = "/var/www/html/main/basic/xml/Schema_VFPR12.xsd";
            //../xml/Schema_DatiFattura_29052020.xsd";//sftp://root@www.anpira.it:8052/var/www/html/main/basic/xml/Schema_DatiFattura_29052020.xsd
            // $xml = '/var/www/html/main/basic/xml/ft2.xml';
            // libxml_use_internal_errors(true);
            $test = fopen($xml, "r");
            if ($test) {
                $x = fread($test, filesize($xml));
                // return $x;   
            }
        }

        $rxml = new DOMDocument();
        $rxml->load($xml);
        if (!$rxml->schemaValidate($xsd)) {
            // print '<b>DOMDocument::schemaValidate() Generated Errors!</b>';
            return libxml_get_errors();
        } else {

            echo $file . 'fatto';
            return $file . 'fatto';;
        }
    }




    function processafile_xml($file, $ind = null)
    {


        $ini_array = parse_ini_file("config.ini", true /* will scope sectionally */);
        $ini_xml = parse_ini_file("xml.ini", true /* will scope sectionally */);

        $ext = $ini_array['Parametri']['estensione'];
        $sep=$ini_array['Parametri']['sep'];
        $f = $file;
        ((is_null($ind) == true) ? $ind = 1 : $ind);
        $directory = new DirectoryIterator(dirname(__FILE__));
        $di = str_replace('include', '', $directory->getPath());
        $file = $di . $ini_array['percorsi']['toelab'] . (basename($f));
        ini_set('error_reporting', E_ALL ^ E_WARNING);
        $data = new SimpleXmlElement($file, null, true);
        json_encode($data);
        $namespaces = $data->getNamespaces(true);
        $new = ($data->Order);
        $con = json_encode($new);
        $subnest = ($data->Order->Children("cac", TRUE)->OrderLine);
        $subnest_covid = ($data->Children("ns8", TRUE)->Order->Children("ns2", TRUE)->OrderLine);
        $subnest_order4 =        ($data->Children("ns4", TRUE)->Order->Children("ns3", TRUE)->OrderLine);


        if (get_object_vars($subnest) <> false || count($subnest) <> 0) {
            $row = "";
            $row = "TES";
            try {
                $dt1 =     strtotime($data->Order->Children("cbc", TRUE)->IssueDate);
                $dt = date("d/m/Y", $dt1);

                $row = $row . $sep . $dt . $sep . $ind . $sep . $data->Order->Children("cac", TRUE)
                    ->BuyerCustomerParty->Children("cac", TRUE)->Party
                    ->Children("cac", TRUE)->PartyTaxScheme->Children("cbc", TRUE)->CompanyID;
                $row = $row . $sep   . $dt;
                $row = $row .   $sep . $data->Order->Children("cbc", TRUE)->ID .$sep.$sep.$sep.$sep 
                . PHP_EOL;
                foreach ($data->Order->Children("cac", TRUE)->OrderLine as $line) {
                    $row = $row . "RIG" . $sep   . $dt .$sep.$ind.$sep.$sep.$sep.$sep;
                    $row = $row . $line->Children("cac", true)->LineItem->children("cac", true)->Item->
                    children("cac", true)->BuyersItemIdentification->children("cbc", true)->ID . $sep.$sep;
                    $row = $row . $line->Children("cac", true)->LineItem->children("cbc", true)->Quantity;
                    $row = $row . $sep . $line->Children("cac", true)->LineItem->children("cac", true)
                    ->Price->children("cbc", true)->PriceAmount .
                        PHP_EOL;
                }
            } catch (Exception $var) {
                print $var->getMessage();
            }
            $di = str_replace('include', '', $directory->getPath());
            $xml = $di . $ini_array['percorsi']['toelab'] . (basename($f));
            copy($xml, $di . $ini_array['percorsi']['procfiles'] . (basename($f)));
            //echo $xml;
            unlink($xml);
            return $row;
        } elseif (get_object_vars($subnest_covid) <> false || count($subnest_covid) <> 0) {
            //   echo '<tr><td> Ordine covid</tr></td>';
            $tmp_xml = file_get_contents($file); //fread(fopen($file,"r"),$file);
            // var_dump($testo);
            $tmp_file = fopen("_" . basename($file), "w");
            fwrite($tmp_file, $tmp_xml);
            $tmp_xml = str_replace("ns8:", "", $tmp_xml);
            $tmp_xml = str_replace("ns2:", "", $tmp_xml);
            $tmp_file = fopen("_" . basename($file), "w");
            fwrite($tmp_file, $tmp_xml);
            $data =  new SimpleXmlElement("_" . basename($file), null, true);
            try {
                $row = "";
                $row = "TES";
                $dt1 =     strtotime($data->Order->IssueDate);
                $dt = date("d/m/Y", $dt1);

                $row = $row . $sep . $dt . $sep . $ind . $sep . $data->Order->BuyerCustomerParty->Party
                    ->PartyTaxScheme->CompanyID;
                $row = $row . $sep   . $dt;
                $row = $row .   $sep . $data->Order->ID . $sep.$sep.$sep.$sep . PHP_EOL;
                //   echo '<tr><td>' . $row . '</tr></td>';
                foreach ($data->Order->OrderLine as $line) {

                    $row = $row . "RIG" . "$sep"   . $dt . $sep.$ind.$sep.$sep.$sep.$sep;
                    $row = $row . $line->LineItem->Item->SellersItemIdentification->ID . $sep.$sep;
                    $row = $row . $line->LineItem->Quantity;
                    $row = $row . $sep . $line->LineItem->Price->PriceAmount . PHP_EOL;
                }



                $di = str_replace('include', '', $directory->getPath());
                $xml = $di . $ini_array['percorsi']['toelab'] . (basename($f));
                copy($xml, $di . $ini_array['percorsi']['procfiles'] . (basename($f)));
                //     echo $row;
                unlink($xml);
                unlink("_" . basename($file));
                return $row;
            } catch (Exception $var) {
                print $var->getMessage();
            }
        } elseif ( //get_object_vars($subnest_order4) <> false || count($subnest_order4) <> 0 && 
            1 == 2
        ) {
            $tmp_xml = file_get_contents($file); //fread(fopen($file,"r"),$file);
            // var_dump($testo);
            $tmp_file = fopen("_" . basename($file), "w");
            fwrite($tmp_file, $tmp_xml);
            $tmp_xml = str_replace("ns4:", "", $tmp_xml);
            $tmp_xml = str_replace("ns3:", "", $tmp_xml);
            $tmp_file = fopen("_" . basename($file), "w");
            fwrite($tmp_file, $tmp_xml);
            $data =  new SimpleXmlElement("_" . basename($file), null, true);
            try {
                $row = "";
                $row = "TES";
                $dt1 =     strtotime($data->Order->IssueDate);
                $dt = date("d/m/Y", $dt1);

                $row = $row . $sep . $dt . $sep . $ind . $sep . $data->Order->BuyerCustomerParty->Party
                    ->PartyTaxScheme->CompanyID;
                $row = $row . $sep   . $dt;
                $row = $row .   $sep . $data->Order->ID . $sep.$sep.$sep.$sep . PHP_EOL;
                //   echo '<tr><td>' . $row . '</tr></td>';
                foreach ($data->Order->OrderLine as $line) {

                    $row = $row . "RIG" . $sep   . $dt . $sep.$ind.$sep.$sep.$sep.$sep;
                    $row = $row . $line->LineItem->Item->SellersItemIdentification->ID . $sep.$sep;
                    $row = $row . $line->LineItem->Quantity;
                    $row = $row . $sep . $line->LineItem->Price->PriceAmount . PHP_EOL;
                }



                $di = str_replace('include', '', $directory->getPath());
                $xml = $di . $ini_array['percorsi']['toelab'] . (basename($f));
                copy($xml, $di . $ini_array['percorsi']['procfiles'] . (basename($f)));
                //     echo $row;
                unlink($xml);
                unlink("_" . basename($file));
                return $row;
            } catch (Exception $var) {
                print $var->getMessage();
            }
        } else {

            $tmp_xml = file_get_contents($file); //fread(fopen($file,"r"),$file);
            // var_dump($testo);
            $tmp_file = fopen("_" . basename($file), "w");
            fwrite($tmp_file, $tmp_xml);
            /*            $tmp_xml = str_replace("ns1:", "", $tmp_xml);
            $tmp_xml = str_replace("ns2:", "", $tmp_xml);
            $tmp_xml = str_replace("ns3:", "", $tmp_xml);
           $tmp_xml = str_replace("ns4:", "", $tmp_xml);
            $tmp_xml = str_replace("ns5:", "", $tmp_xml);
            $tmp_xml = str_replace("ns6:", "", $tmp_xml);
            $tmp_xml = str_replace("ns7:", "", $tmp_xml);
            $tmp_xml = str_replace("ns8:", "", $tmp_xml);
            $tmp_xml = str_replace("ns9:", "", $tmp_xml);

*/

            $ns = $ini_xml['NS']['name_space'];
            //var_dump($ns);
            foreach ($ns as $val) {
                //  echo "<br>".$val;
                $tmp_xml = str_replace($val, "", $tmp_xml);
                // $i=$i+1;

            }



            //    $tmp_xml = preg_replace("/<.*(xmlns *= *[\"'].[^\"']*[\"']).[^>]*>/i", "", $tmp_xml); 

            $tmp_file = fopen("_" . basename($file), "w");
            fwrite($tmp_file, $tmp_xml);
            $data =  new SimpleXmlElement("_" . basename($file), null, true);
            try {
                if (strpos($tmp_xml, 'LineItem') == false) {

                    throw new Exception('Attenzione il documento non contiene righe valide!!');
                }
                $row = "";
                $row = "TES";
                $dt1 =     strtotime($data->Order->IssueDate);
                $dt = date("d/m/Y", $dt1);

                $row = $row . $sep . $dt . $sep . $ind . $sep . $data->Order->BuyerCustomerParty->Party
                    ->PartyTaxScheme->CompanyID;
                $row = $row . $sep   . $dt;
                $row = $row .   $sep . $data->Order->ID . $sep.$sep.$sep.$sep . PHP_EOL;
                //   echo '<tr><td>' . $row . '</tr></td>';
                foreach ($data->Order->OrderLine as $line) {

                    $row = $row . "RIG" . $sep   . $dt . $sep.$ind.$sep.$sep.$sep.$sep;
                    $row = $row . $line->LineItem->Item->SellersItemIdentification->ID . $sep.$sep;
                    $row = $row . $line->LineItem->Quantity;
                    $row = $row . $sep . $line->LineItem->Price->PriceAmount . PHP_EOL;
                }



                $di = str_replace('include', '', $directory->getPath());
                $xml = $di . $ini_array['percorsi']['toelab'] . (basename($f));
                copy($xml, $di . $ini_array['percorsi']['procfiles'] . (basename($f)));
                //     echo $row;
                unlink($xml);
                unlink("_" . basename($file));
                return $row;
            } catch (Exception $var) {
                //  print $var->getMessage();
                echo "<B>il File {$f}  potrebbe non essere CORRETTO!!!!</B><br><B>Non presenta al'interno i dati relativi a un ordine</B><br><BR>";
            }
        }
    }








    function creafile($rows)
    {
        $ini_array = parse_ini_file("config.ini", true /* will scope sectionally */);

        $nfile = $ini_array['percorsi']['output'] . $ini_array['Parametri']['NomeOut'] . date('m-d-Y_hia') . '.csv';
        $tmpfile = fopen($nfile, "w")
            or   $this->extremesave($rows);
        /*die("NON POSSO CREARE IL FILE DI OUTPUT!! COntrollare cartella e permessi!! "
    .$ini_array['percorsi']['output'].'Sistemi_Roma_'.date('m-d-Y_hia').'.csv'
);*/
        fwrite($tmpfile, $rows);
        fclose($tmpfile);
        $webf = fopen($ini_array['Parametri']['NomeOut'] . date('m-d-Y_hia') . '.csv', "w") or
            $this->extremesave($rows);
        fwrite($webf, $rows);

        if (strlen($rows) > 10) {

            return $nfile;
        } else {
            return "";
        }
    }
    function extremesave($row)
    {

        fwrite("c:\nso_" . date('m-d-Y_hia') . '.csv', $row);
        die("NON POSSO CREARE IL FILE DI OUTPUT  !! COntrollare cartella e permessi!! ");
    }

    function reset($file)
    {
        unlink($file);
    }


    function grid()
    {

        $ini_array = parse_ini_file("config.ini", true /* will scope sectionally */);
        $ext = $ini_array['Parametri']['estensione'];
        //$ini_array['percorsi']['procfiles'];
        $pfile = glob($ini_array['percorsi']['procfiles'] . $ext);
        $html = <<<EOT
<div class="scrollingtable">
<div>
    <div>
      <table>
        <caption></caption>
        <thead>
          <tr>
            <th><div label="File Elaborati"></div></th>
			<th class="scrollbarhead"/> <!--ALWAYS ADD THIS EXTRA CELL AT END OF HEADER ROW-->
			</tr>
		  </thead>
		  <tbody>
 
 <tr><td> 
EOT;
        foreach ($pfile as $pf) {
            $bspf = basename($pf);
            $html = $html . <<<EOT
	<label for="name">Nome File</label><br /> 
	<input ID="{$bspf}" type="checkbox" value="{$bspf}" /> {$bspf}<br /> 
EOT;
        }
        $html = $html . <<<EOT
</td></tbody></table>
</div>
</div>
</div><br>
<button type="submit" value="Submit" onclick="test()">Cancella</button> 
EOT;
        return $html;
    }

function processafile_xls($file, $ind = null){

echo $file.'<br></td></tr><tr><td>';

}


}
?>






