<?php
	class Database{
		public $mysqli;
		function __construct(){
	  		$this->mysqli=new mysqli('localhost','root','pass','SAR');
			if($this->mysqli->connect_error){
				echo $this->mysqli->connect_error."\n";
				exit(1);
			}
			$this->mysqli->set_charset('utf8');
		}
		public function insert($element){
			// $element=to_null($element);
			$res=$this->mysqli->query("insert into service (booking_no,start_date,end_date,price) values('$element->booking_number','$element->date_s','$element->date_e','$element->price');");
			if(!$res){echo $this->mysqli->error."\nservice"."\n";return 1;}
			$res=$this->mysqli->query("insert into client (name,mail,organization,purpose,application) values('$element->client_name','$element->client_mail','$element->client_organization','$element->client_purpose','$element->application_date');");
			if(!$res){echo $this->mysqli->error."\nclient"."\n";return 1;}
			$res=$this->mysqli->query("insert into essential (booking_no,site_name,space_name,client) values('$element->booking_number','$element->site_name','$element->space_name',".$this->mysqli->insert_id.");");
			if(!$res){echo $this->mysqli->error."\nessential"."\n";return 1;}
			return 0;
		}
		public function delete($element){
			$res=$this->mysqli->query("select client from essential where booking_no=$element->booking_number;");
			/*error message*/if(!$res){echo $this->mysqli->error."\nclient"."\n";return 1;}
			$client=null;foreach($res as $tmp)$client=$tmp['client'];
			$res=$this->mysqli->query("delete from essential where booking_no=$element->booking_number;");
			/*error message*/if(!$res){echo $this->mysqli->error."\nessential"."\n";return 1;}
			$res=$this->mysqli->query("delete from service where booking_no=$element->booking_number;");
			/*error message*/if(!$res){echo $this->mysqli->error."\nservice"."\n";return 1;}
			$res=$this->mysqli->query("delete from client where id=$client;");
			/*error message*/if(!$res){echo $this->mysqli->error."\nclient:"."$client\n";return 1;}
			return 0;
		}
	}
?>
