<?php
//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);
include __DIR__ . '/include/ls.php';
include __DIR__ . '/include/PB.php';
include __DIR__ . '/include/profis.php';

$pfs = new profis();
error_reporting(E_ALL);

$ini_array = parse_ini_file("config.ini", true/* will scope sectionally */);
$ls = new ls();
$ls->localelab();
$content = "";
$p = new ProgressBar();
if (!empty($_POST)) {
    strlen($_POST['state']) == 0 ? die("non è stato selezioanto il codice ATECO") : 1;
   // echo $_POST['tper'];
    //echo '<BR>';
    //echo '<BR>';
    //echo '<BR>';
    //echo ($_POST['state']);
} else {
    echo 'qualquadra non cosa!!!';

}

$eleb = ($ls->elefile(1));
$eleb2 = ($ls->elefile(2));
//var_dump($eleb);
//var_dump($eleb2);
$elef = (array_diff($eleb, $eleb2));
$f = 0;
$i = 0;
$size = 100;
$conta = 100 / ((count($elef) == 0) ? 1 : count($elef));
echo <<<EOT
<style>
/*the following html and body rule sets are required only if using a % width or height*/
/*html {
width: 100%;
height: 100%;
}*/
body {
  box-sizing: border-box;
  width: 100%;
  height: 100%;
  margin: 0;
  padding: 0 20px 0 20px;
  text-align: center;
  background: white;
}
.scrollingtable {
  box-sizing: border-box;
  display: inline-block;
  vertical-align: middle;
  overflow: hidden;
  width: auto; /*if you want a fixed width, set it here, else set to auto*/
  min-width: 0/*100%*/; /*if you want a % width, set it here, else set to 0*/
  height: 188px/*100%*/; /*set table height here; can be fixed value or %*/
  min-height: 0/*104px*/; /*if using % height, make this large enough to fit scrollbar arrows + caption + thead*/
  font-family: Verdana, Tahoma, sans-serif;
  font-size: 15px;
  line-height: 20px;
  padding: 20px 0 20px 0; /*need enough padding to make room for caption*/
  text-align: left;
}
.scrollingtable * {box-sizing: border-box;}
.scrollingtable > div {
  position: relative;
  border-top: 1px solid black;
  height: 100%;
  padding-top: 20px; /*this determines column header height*/
}
.scrollingtable > div:before {
  top: 0;
  background: cornflowerblue; /*header row background color*/
}
.scrollingtable > div:before,
.scrollingtable > div > div:after {
  content: "";
  position: absolute;
  z-index: -1;
  width: 100%;
  height: 100%;
  left: 0;
}
.scrollingtable > div > div {
  min-height: 0/*43px*/; /*if using % height, make this large enough to fit scrollbar arrows*/
  max-height: 100%;
  overflow: scroll/*auto*/; /*set to auto if using fixed or % width; else scroll*/
  overflow-x: hidden;
  border: 1px solid black; /*border around table body*/
}
.scrollingtable > div > div:after {background: white;} /*match page background color*/
.scrollingtable > div > div > table {
  width: 100%;
  border-spacing: 0;
  margin-top: -20px; /*inverse of column header height*/
  /*margin-right: 17px;*/ /*uncomment if using % width*/
}
.scrollingtable > div > div > table > caption {
  position: absolute;
  top: -20px; /*inverse of caption height*/
  margin-top: -1px; /*inverse of border-width*/
  width: 100%;
  font-weight: bold;
  text-align: center;
}
.scrollingtable > div > div > table > * > tr > * {padding: 0;}
.scrollingtable > div > div > table > thead {
  vertical-align: bottom;
  white-space: nowrap;
  text-align: center;
}
.scrollingtable > div > div > table > thead > tr > * > div {
  display: inline-block;
  padding: 0 6px 0 6px; /*header cell padding*/
}
.scrollingtable > div > div > table > thead > tr > :first-child:before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  height: 20px; /*match column header height*/
  border-left: 1px solid black; /*leftmost header border*/
}
.scrollingtable > div > div > table > thead > tr > * > div[label]:before,
.scrollingtable > div > div > table > thead > tr > * > div > div:first-child,
.scrollingtable > div > div > table > thead > tr > * + :before {
  position: absolute;
  top: 0;
  white-space: pre-wrap;
  color: white; /*header row font color*/
}
.scrollingtable > div > div > table > thead > tr > * > div[label]:before,
.scrollingtable > div > div > table > thead > tr > * > div[label]:after {content: attr(label);}
.scrollingtable > div > div > table > thead > tr > * + :before {
  content: "";
  display: block;
  min-height: 20px; /*match column header height*/
  padding-top: 1px;
  border-left: 1px solid black; /*borders between header cells*/
}
.scrollingtable .scrollbarhead {float: right;}
.scrollingtable .scrollbarhead:before {
  position: absolute;
  width: 100px;
  top: -1px; /*inverse border-width*/
  background: white; /*match page background color*/
}
.scrollingtable > div > div > table > tbody > tr:after {
  content: "";
  display: table-cell;
  position: relative;
  padding: 0;
  border-top: 1px solid black;
  top: -1px; /*inverse of border width*/
}
.scrollingtable > div > div > table > tbody {vertical-align: top;}
.scrollingtable > div > div > table > tbody > tr {background: white;}
.scrollingtable > div > div > table > tbody > tr > * {
  border-bottom: 1px solid black;
  padding: 0 6px 0 6px;
  height: 20px; /*match column header height*/
}
.scrollingtable > div > div > table > tbody:last-of-type > tr:last-child > * {border-bottom: none;}
.scrollingtable > div > div > table > tbody > tr:nth-child(even) {background: gainsboro;} /*alternate row color*/
.scrollingtable > div > div > table > tbody > tr > * + * {border-left: 1px solid black;} /*borders between body cells*/
</style>




<table style="height: 94px; margin-left: auto; margin-right: auto;"
border="1" width="311" cellspacing="10" cellpadding="10">
<tbody>
<tr style="height: 116.188px;">
<td style="width: 301px; height: 116.188;">
Avvio Conversione&hellip;<br />
<a href="./index.php">
<img src="./img/logo.png" alt="logo" width="110%" height="110%" align="center"/>
</a>
EOT;
echo '<div style="width: 300px;">';
$p->render();
echo '</div></tbody></table>';
echo <<<EOT
<div class="scrollingtable">
<div>
    <div>
      <table>
        <caption></caption>
        <thead>
          <tr>
            <th><div label="Files in Elaborazione"></div></th>
			<th class="scrollbarhead"/> <!--ALWAYS ADD THIS EXTRA CELL AT END OF HEADER ROW-->
			</tr>
		  </thead>
		  <tbody>
<tr><td>
EOT;
$contaid = 1;
$riga = "";
foreach ($elef as $t) {
    if (count($elef) == 1) {
        $i = 100;
    }
    //echo   basename($t) . '<br></td></tr><tr><td>';

    /*
    rimosso che non si riesce a trovare un xsd valido per sto nso....
    $ls->valfile(basename($t));
     */
    $riga = $riga . $pfs->creaditta_File(basename($t), $contaid, $_POST['state'],$_POST['tper']);
    //    echo basename($t).'<br>'.round($i,2).'%<br>';
    $p->setProgressBarProgress($i * 100 / $size);
    usleep(1000000 * 0.1);
    $i = $i + $conta;
    $contaid = $contaid + 1;
}
$p->setProgressBarProgress(100);

echo
    <<<EOT


</td></TR></tbody></table>
</div>
</div>
</div>

<table style="height: 94px; margin-left: auto; margin-right: auto;"
border="1" width="311" cellspacing="10" cellpadding="10">
<tbody><TD><BR><H1>
<a href="./index.php">Terminato</a></h1><br/>
</td></tbody></table>
EOT;

//echo $riga;

$f = $ls->creafile($riga);
$html = '';

if (strlen($f) > 3) {

    $t = basename($f);
    $zzz = $t;
    if ($ini_array['Parametri']['wbout'] == 1) {
        $html = <<<EOT
<td><tr><table style="height: 54px; margin-left: auto; margin-right: auto;"
border="1" width="311" cellspacing="10" cellpadding="10">
<tbody><TD><BR><H1>
<a href="{$t}">Scarica File Ditte</a></h1><br/>
</td></tbody></table></tr>
EOT;
    } else {

        $html = <<<EOT
    <td><tr> <table style="height: 54px; margin-left: auto; margin-right: auto;"
    border="1" width="311" cellspacing="10" cellpadding="10">
    <tbody><TD><BR><H1>File Elaborato e disponibile in:<br> {$ini_array['percorsi']['output']}
    </td></tbody></table></tr>
    EOT;
    }
}

$riga = '';
$contaid = 1;
foreach ($elef as $t) {
    $riga = $riga . $pfs->create_Ana(basename($t), $contaid, $_POST['state'],);
    $contaid = $contaid + 1;
}

//echo ($riga);

$f = $ls->creafile($riga, 2);
$v = basename($f);
$html = $html . <<<EOT
<tr><table style="height: 54px; margin-left: auto; margin-right: auto;"
border="1" width="311" cellspacing="10" cellpadding="10">
<tbody><TD><BR><H1>
<a href="{$v}">Scarica File ANAGRAFICHE </a></h1><br/>
</td></tbody></table></tr>
EOT;

//$eleb=($ls->elefile(1));
//$eleb2=($ls->elefile(2));
//var_dump($eleb);
//var_dump($eleb2);
//var_dump(array_diff($eleb,$eleb2));
//echo "bestia<br>";
//$ls= new ls();
//$ls->localelab();
$directory = new DirectoryIterator(dirname(__FILE__));
$di = str_replace('include', '', $directory->getPath());
$di = str_replace(__DIR__, 'include', '');
//var_dump($ini_array);
$lpath = glob(__DIR__ . '' . $ini_array['percorsi']['toelab'] . '*');

//echo $di.$ini_array['percorsi']['procfiles'];
//var_dump(__DIR__.''.$ini_array['percorsi']['toelab'].'*');
foreach ($lpath as $f) {
    // echo  "rimosso file {$f}<br>";
    $ls->reset($f);
}
//   echo $di.$ini_array['percorsi']['procfiles'];
$lpath = glob($di . '' . $ini_array['percorsi']['procfiles'] . '*');
//  var_dump($lpath);
foreach ($lpath as $f) {
//   echo  "rimosso file {$f}<br>";
    $ls->reset($f);
}

$z = $pfs->zipper();
$z = basename($z);
$t = isset($zzz) ? $zzz : '';
echo <<<EOT
<br><br>

<table style="height: 54px; margin-left: auto; margin-right: auto;"
border="1" width="311" cellspacing="10" cellpadding="10">
<tbody><TD><BR><H1>
<a href="{$z}">Scarica File Ditte e Anagrafiche(ZIP)</a></h1><br/>
</td></tbody></table>

EOT;
