<?php
	$a=file("titles.txt");
	$fs=file("title.txt");
	$f=$fs[0];
	echo $f;
	foreach($a as $b){
		$t=strpos($b,trim($f));
		if($t){
			echo $t.$b;
			echo mb_detect_encoding($b);
		}
	}
?>
