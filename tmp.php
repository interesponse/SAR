<?php
	$f=file_get_contents("un.txt");
	echo mb_convert_encoding($f,'UTF-8','SJIS');
?>
