<?php
	$a=file("titles.txt");
	foreach($a as $b){
		$t=strpos($b,"スペイシー");
		if($t){
			echo $t.$b;
			echo mb_detect_encoding($b);
		}
	}
?>
