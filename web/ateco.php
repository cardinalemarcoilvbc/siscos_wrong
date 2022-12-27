<?php
//session_start();
//require_once __DIR__ . '/inc/flash.php';
include __DIR__ . '/include/ls.php';
include __DIR__ . '/include/PB.php';
$ls = new ls();

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


//47.91.10 atedcodefault


$ini_array = parse_ini_file("config.ini", true /* will scope sectionally */);


$web= glob(__DIR__.'/*.csv');
 
foreach ($web as $f) {
  //echo  "rimosso file {$f}<br>";
$ls->reset($f);
   }



$ext = $ini_array['Parametri']['estensione'];
//$ext2=$ini_array['EXTENSION']['ext'];
$ext2 = $ini_array['EXTENSION'];
//var_dump($ext);
$search = '';
foreach ($ext2['ext'] as $value) {

    //  echo $value . '<br>';
    $search = $search . '.' . str_replace('.', '', '.' . $value) . ',';
}
$search = $search . '}';
$search = str_replace(',}', '', $search);
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
  min-width: 100% 0/*100%*/; /*if you want a % width, set it here, else set to 0*/
  height: 488px/*100%*/; /*set table height here; can be fixed value or %*/
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
EOT;
?>

<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function(){
  $.getJSON("atecoid.json", function(data){
    console.log(data);
    $.each(data, function() {
    });
var data2=$.map(data,function(obj){
    console.log(obj);
    obj.id=obj.id;
    obj.text=obj.id +" ||  "+ obj.text;
    obj.disabled=true;
    console.log(obj.id.substring(0,1));
    if ($.isNumeric(obj.id.substring(0,1))) {
        obj.disabled=false;
};
return obj;
}

)

    $(".js-example-data-array-selected").select2({
  data: data2
});

});

        }
    );
    </script>

</head>
<body>


<table style="height: 94px; margin-left: auto; margin-right: auto;"
border="1" width="800" cellspacing="10" cellpadding="10">
<tbody>
<tr style="height: 116.188px;">
<td style="width: 301px; height: 116.188;">
<p style="text-align: center;"><img src="./img/logo.png" alt="logo" width="110%" height="110%" /></p>
</td>

<td style="width: 501px; height: 116.188px;" rowspan="6">
<?php

echo <<<EOT
<div class="scrollingtable">
<div>
    <div>
      <table>
        <caption></caption>
        <thead>
          <tr>
            <th><div label="File da Elaborare"></div></th>
			<th class="scrollbarhead"/> <!--ALWAYS ADD THIS EXTRA CELL AT END OF HEADER ROW-->
			</tr>
		  </thead>
		  <tbody>
<tr><td>
EOT;

$ris = ($ls->elefile(1));
foreach ($ris as $r) {
    echo '<tr><td>' . $r . '</td></tr>';
}
echo
    <<<EOT
</td></tbody></table>
</div>
</div>
</div>
EOT;
?>

</td>
</tr>
<tr style="height: 116.188px;">

<td style="width: 301px; height: 116.188px;">Seleziona files da caricare
  <form enctype="multipart/form-data" action="upload.php" method="post">
        <div>
<?php
echo
    <<<EOT
 <input type="file" id="file" name="file[]" multiple accept="{$search}" />
EOT;

$rr = "accept='.{$ext}";
?>
          </div>
        <div>
            <button type="submit">Upload</button>
        </div>
    </form>

</tr>
<tr style="height: 18px;">
<td style="width: 301px; height: 18px;">&nbsp;</td>
</tr><!---
<tr style="height: 21px;">
<td style="width: 301px; height: 21px;"><input name="submit" type="submit" value="scarica da SFTP" /></td>
</tr>
<tr style="height: 18px;">
<td style="width: 301px; height: 18px;">&nbsp;</td>
</tr>--->
<tr style="height: 39px;">
<td style="width: 301px; height: 39px;"><br />
<form enctype="multipart/form-data" action="elab.php" method="post">
<label for="id_label_single">
  IMMETTI CODICE ATECO
<select id='ateco' class="js-example-data-array-selected" style="width: 300px"  name="state">
<option></option>
<option id="47.91.10" selected="selected">47.91.10</option>

</select>

</label> 
<br><br>Periodicità IVA<br>
<label for="id_label_single2">

<select id='tper'   style="width: 300px"  name="tper">
<option></option>
<option value=1>Mensile</option>
<option selected="selected"  value=3>Trimestrale</option>
 
 
</select>
</label><br><br>
<input name="submit" type="submit" value="Elaborazione Dati"/>
</form></td>
</tr>

</tbody>
</table>
<tr><h1><a href="./reset.php">Pulisci Memoria</a></h1></tr>
 
<p><br /><br /></p>
</body>
</html>

<?php
/*
require('../vendor/autoload.php');
$app = new Silex\Application();
$app['debug'] = true;
// Register the monolog logging service
$app->register(new Silex\Provider\MonologServiceProvider(), array(
'monolog.logfile' => 'php://stderr',
));
// Register view rendering
$app->register(new Silex\Provider\TwigServiceProvider(), array(
'twig.path' => __DIR__.'/views',
));
// Our web handlers
$app->get('/', function() use($app) {
$app['monolog']->addDebug('logging output.');
return $app['twig']->render('index.twig');
});

$app->get('/cowsay', function() use($app) {
$app['monolog']->addDebug('cowsay');
return "<pre>".\Cowsayphp\Cow::say("Cool beans")."</pre>";
});

$app->run();
 */
?>