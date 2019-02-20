<?php
	print_r(error_get_last());
	$f=file("base64.txt");
	$ff="";
	foreach($f as $a)
		$ff=$ff.trim($a);
	$ff=str_split($ff,4);
	foreach($ff as $f){
		echo $f." ".strlen($f)."\n";
		$t=base64_decode($f);
		echo $t."\n";
	}
?>
