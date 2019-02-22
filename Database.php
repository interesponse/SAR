<?php
	class Database{
		public $mysqli;
		function __construct(){
	  		$this->mysqli=new mysqli('localhost','root','password','SAR');
			if($this->mysqli->connect_error){
				echo $this->mysqli->connect_error;
				echo "error";
				exit(1);
			}
			$this->mysqli->set_charset('utf8');
		}
		public function insert($element){
			// $element=to_null($element);
			$res=$this->mysqli->query("insert into service (booking_no,start_date,end_date,price) values($element->booking_number,'$element->date_s','$element->date_e',$element->price);");
			if(!$res){echo $this->mysqli->error."\service"."\n";return 1;}
			$res=$this->mysqli->query("insert into client_info (name,mail) values('$element->client_name','$element->client_mail');");
			if(!$res){echo $this->mysqli->error."\client_info"."\n";return 1;}
			$res=$this->mysqli->query("insert into essential (booking_no,site_name,space_name,client) values($element->booking_number,'$element->site_name','$element->space_name',".$this->mysqli->insert_id.");");
			if(!$res){echo $this->mysqli->error."\tessential"."\n";return 1;}
			return 0;
		}
		public function delete($element){
			$res=$this->mysqli->query("select client from essential where id=$element->booking_number;");
			if(!$res){echo $this->mysqli->error."\client_info"."\n";return 1;}
			$client=null;foreach($res as $tmp)$client=$tmp['client'];
			$res=$this->mysqli->query("delete from essential where booking_id=$element->booking_number;");
			if(!$res){echo $this->mysqli->error."\client_info"."\n";return 1;}
			$res=$this->mysqli->query("delete from service where booking_id=$element->booking_number;");
			if(!$res){echo $this->mysqli->error."\client_info"."\n";return 1;}
			$res=$this->mysqli->query("delete from client_info where client_id=$client;");
			if(!$res){echo $this->mysqli->error."\client_info"."\n";return 1;}
		}
	}
?>
