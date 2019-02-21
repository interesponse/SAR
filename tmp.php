<?php
	$ff=file("date.txt");
	foreach($ff as $f){
		$f=mb_ereg_replace("日",'',$f);
		$t=mb_split("[年月日　 \/:～〜]",$f);
		$date_e=trim($t[4]).'-'.trim($t[5]).'-'.trim($t[6]);
		$date_s=$date_e.' '.mb_substr(trim($t[7]),mb_strlen(trim($t[7]))-2).':'.trim($t[8]);
		$date_e=$date_e.' '.trim($t[9]).':'.mb_substr(trim($t[10]),0,2);
		echo $date_s."\n";
		echo $date_e."\n";
	}
?>
