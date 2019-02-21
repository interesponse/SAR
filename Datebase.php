<?php
	function mysqli_initial(){
		$mysqli=new mysqli('localhost','root','password','SAR');
		if($mysqli->connect_error){
			echo $mysqli->connect_error;
			echo "error";
			exit(1);
		}
		return $mysqli;
		$mysqli->set_charset('UTF-8');
	}
	function insert($element,$mysqli){
		// $element=to_null($element);
		$res=$mysqli->query("insert into essential (booking_no,site_name,space_name,client) values($element->booking_number,'$element->site_name','$element->space_name','$element->client_name');");
		if(!$res)echo $mysqli->error."\n";
		$res=$mysqli->query("insert into client_info (name,mail) values('$element->client_name','$element->client_mail');");
		if(!$res)echo $mysqli->error."\n";
		$res=$mysqli->query("insert into service (booking_no,start_date,end_date,price) values($element->booking_number,'$element->date_s','$element->date_e',$element->price);");
		if(!$res)echo $mysqli->error."\n";
	}
?>
