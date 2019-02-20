<?php
	$a=file("titles.txt");
	$f= "スペイシー";//true
	$ff="スぺイシー";//false
	var_dump($f);
	var_dump($ff);
	foreach($a as $aa){
		$t=strpos($aa,$f);
		$tt=strpos($aa,$ff);
		if($t){
			echo '$t ='.$t."\n";
			echo '$tt='.$tt."\n";
		}
	}
/*
Result:

$t =1
$tt=
$t =1
$tt=
$t =1
$tt=
$t =1
$tt=
$t =1
$tt=
$t =1
$tt=
$t =1
$tt=
$t =1
$tt=
$t =1
$tt=
$t =1
$tt=
$t =1
$tt=
$t =1
$tt=
$t =1
$tt=
$t =1
$tt=
$t =1
$tt=
$t =1
$tt=
$t =1
$tt=
$t =1
$tt=
$t =1
$tt=
$t =1
$tt=
$t =1
$tt=
$t =1
$tt=
$t =1
$tt=
$t =1
*/
?>
