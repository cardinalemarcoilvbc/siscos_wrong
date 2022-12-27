<!DOCTYPE html>
<html>
<head>
</head>
<body>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<?php

use Shuchkin\SimpleXLSX;

$vend=str_replace("web","",__DIR__) . 'vendor\shuchkin\simplexlsx\src\SimpleXLSX.php';
require_once( $vend);
//var_dump($vend);
$ini_array = parse_ini_file("config.ini", true /* will scope sectionally */);
$ext=$ini_array['EXTENSION'];
//var_dump($ext);
$search='{';
foreach ($ext['ext'] as $value){
echo $value . '<br>';
$search=$search  .str_replace('.','',$value).',';
}
$search=$search.'}';
$search=str_replace(',}','}',$search);  
echo '<br>';
/*
$xlsx= SimpleXLSX::parse('.\toelab\test_lotto - Copia.xlsx');
$sheets=$xlsx->sheetNames(); 
foreach($sheets as $index => $name){
    foreach ( $xlsx->rows($index) as $r => $row ) {
    }
}

foreach($xlsx->rows(1) as $r){

    foreach ($r as $value){
//echo $value.'      ';
    }
//echo '<br>';
}
 

*/
 $data = file_get_contents (__DIR__.'/include/ateco.json');
 $json = json_decode($data, true);
 foreach ($json as $key => $value) {
     if (!is_array($value)) {
       //   echo $key . '=>' . $value . '<br/>';
     } else {
         foreach ($value as $key => $val) {
         //    echo $key . '=>' . $val . '<br/>';
         }
     }
 }

if (!empty($_POST)){
echo '<BR>';
echo '<BR>';
echo '<BR>';
var_dump ($_POST['state']);
}
else{
    echo 'banana';
}

?>

<script>
    $(document).ready(function(){
 //       $.getJSON("atecoid.json", function(data){
 //          console.log(data);
 //           console.log(data.data.id); // Prints: Harry
 //           console.log(data.text); // Prints: 14
 //       }).fail(function(){
 //           console.log("An error has occurred.");
  //      });
 //       $.getJSON("atecoid.json", function(data){
 //       $.each(data.features, function(i, feature) {
 // console.log(feature.properties.id);
//})

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
<form method="post"  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
<select id='ateco'  
 class="js-example-data-array-selected" style="width: 50%"  required name="state">
<option></option>
<input name="submit" type="submit" value="Elaborazione Locale" 

/>
</form>
 <?php
  /*
 foreach ($json as $key => $value) {
    if (!is_array($value)) {
        echo '<option value="'.$key.'">'.$key.' ||  '.$value.'</option>';
    } else {
        foreach ($value as $key => $val) {
      echo     '<option value="'.$key.'">'.$key.' ||  '.$val.'</option>';
        }
    }
}*/
$line='37625;"SHENZHENSHINUOSIYAELECTRONICCO ;Ltd";Altro;Ditta attiva per AA7 (Inizio/Variaz./Cessaz.Attività - Società);Senza annotazioni;Si;16619271006;16619271006;
';
echo $line;
echo '<br>';
 print_r(explode(';',$line));
 echo '<br><br>';
 $mimmo=explode(';',$line) ;
 var_dump( sizeof($mimmo));
 $line='37625; SHENZHENSHINUOSIYAELECTRONICCO  Ltd ;Altro;Ditta attiva per AA7 (Inizio/Variaz./Cessaz.Attività - Società);Senza annotazioni;Si;16619271006;16619271006;
 ';
 echo $line;
 echo '<br>';
  print_r(explode(';',$line));
  echo '<br><br>';
  $mimmo=explode(';',$line) ;
  var_dump( sizeof($mimmo));

?>
 
</select>
</body>
</html>

 