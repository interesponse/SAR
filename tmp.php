<?php
	$f=file_get_contents("buffer.txt");
	$f=mb_split("<[^>]*>",$f);
	for($i=0;$i<count($f);$i++)
		$f[$i]=trim($f[$i]);
	$t=array_search("合計",$f);
	echo $f[$t+2];
?>
