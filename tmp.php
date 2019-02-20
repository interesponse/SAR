<?php
	print_r(error_get_last());
	$f=file_get_contents("base64.txt");
	$ff=file("base64.txt");
//	echo mb_convert_encoding($f,'UTF-8','BASE64');
//	echo base64_decode($f);
	foreach($ff as $f){
		echo $f."\n";
		$t=base64_decode($f);
		echo $t."\n";
	}
?>
