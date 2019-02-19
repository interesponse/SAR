<?php
	$a=file("titles.txt");
	foreach($a as $b){
		if(strpos($b,"スペイシー"))
			echo $b;
	}
?>
