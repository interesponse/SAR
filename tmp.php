<?php
	$mysqli=new mysqli('localhost','root','password','SAR');
	$a=$mysqli->query("select * from essential where booking_no=385012;");
	var_dump($a);
	foreach($a as $b){
		var_dump($b);
	}
?>
