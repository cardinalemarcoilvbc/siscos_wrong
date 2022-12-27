<?php
include('.\include\ls.php');
include('.\include\pb.php');
$ini_array = parse_ini_file("config.ini", true /* will scope sectionally */);
$ls= new ls();
$ls->localelab();
$content = "";
$p = new ProgressBar();

$eleb=($ls->elefile(1));
$eleb2=($ls->elefile(2));
//var_dump($eleb);
//var_dump($eleb2);
$mimmo=(array_diff($eleb,$eleb2));
$f=0;
$i=0;
$size = 100;
$conta=100/((count($mimmo)==0 )? 1 :count($mimmo));
/*echo <<<EOT
<table style="height: 94px; margin-left: auto; margin-right: auto;" 
border="1" width="311" cellspacing="10" cellpadding="10">
<tbody>
<tr style="height: 116.188px;">
<td style="width: 301px; height: 116.188;">
Avvio Conversione&hellip;<br />
<a href="./index.php">
<img src="./img/logo.png" alt="logo" width="110%" height="110%" align="center"/>
</a>
EOT
;
echo '<div style="width: 300px;">';
$p->render();
echo '</div></tbody></table>';
echo <<<EOT
<table style="height: 94px; margin-left: auto; margin-right: auto;" 
border="1" width="100%" cellspacing="10" cellpadding="10">
<tbody>
<tr style="height: 116.188px;">
<td style="width: 301px; height: 116.188;text-align:center;" >
EOT
;
*/
$contaid=1;
$riga="";
foreach ($mimmo as $t) {
if (count($mimmo)==1)
{
$i=100;
}
echo 	basename($t). PHP_EOL;;

/*
rimosso che non si riesce a trovare un xsd valido per sto nso....
$ls->valfile(basename($t));
*/
$riga=$riga. $ls->processafile_Copernico(basename($t),$contaid);
//	echo basename($t).'<br>'.round($i,2).'%<br>';
//$p->setProgressBarProgress($i * 100 / $size);
	usleep(1000000 * 0.1);
	$i=$i+$conta;
	$contaid=$contaid+1;
}
//$p->setProgressBarProgress(100);

/*
echo 
<<<EOT
</td></tbody></table>

<table style="height: 94px; margin-left: auto; margin-right: auto;" 
border="1" width="311" cellspacing="10" cellpadding="10">
<tbody><TD><BR><H1>
<a href="./index.php">Terminato</a></h1><br/>
</td></tbody></table>
EOT;
 */
//echo $riga;

$f=$ls->creafile($riga);
if (strlen($f)>3){

	echo "operazione riuscita". PHP_EOL;;
}


/*if (strlen($f)>3){
echo <<<EOT
<table style="height: 94px; margin-left: auto; margin-right: auto;" 
border="1" width="311" cellspacing="10" cellpadding="10">
<tbody><TD><BR><H1>
<a href="./{$f}">Scarica FIle Elaborato</a></h1><br/>
</td></tbody></table>
EOT;
}*/
//$eleb=($ls->elefile(1));
//$eleb2=($ls->elefile(2));
//var_dump($eleb);
//var_dump($eleb2);
//var_dump(array_diff($eleb,$eleb2));
//echo "bestia<br>";
