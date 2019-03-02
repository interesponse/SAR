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
			$query="insert into service (booking_no,start_date,end_date,price) values('$element->booking_number','$element->date_s','$element->date_e','$element->price');";
			$res=$this->mysqli->query($query);
			/*error message*/if(!$res){echo $this->mysqli->error."\nservice: $query\n";return 1;}
			$query="insert into client (name,mail,organization,purpose,application) values('$element->client_name','$element->client_mail','$element->client_organization','$element->client_purpose','$element->application_date');";
			$res=$this->mysqli->query($query);
			/*error message*/if(!$res){echo $this->mysqli->error."\nclient: $query\n";return 1;}
			$query="insert into essential (booking_no,site_name,space_name,client) values('$element->booking_number','$element->site_name','$element->space_name',".$this->mysqli->insert_id.");";
			$res=$this->mysqli->query($query);
			/*error message*/if(!$res){echo $this->mysqli->error."\nessential: $query\n";return 1;}
			return 0;
		}
		public function delete($element){
			$query="select client from essential where booking_no=$element->booking_number;";
			$res=$this->mysqli->query($query);
			/*error message*/if(!$res){echo $this->mysqli->error."\nclient :$query\n";return 1;}

			$client=null;foreach($res as $tmp)$client=$tmp['client'];
			$query="delete from essential where booking_no=$element->booking_number;";
			$res=$this->mysqli->query($query);
			/*error message*/if(!$res){echo $this->mysqli->error."\nessential: $query\n";return 1;}

			$query="delete from service where booking_no=$element->booking_number;";
			$res=$this->mysqli->query($query);
			/*error message*/if(!$res){echo $this->mysqli->error."\nservice :$query\n";return 1;}

			$query="delete from client where id=$client;";
			$res=$this->mysqli->query($query);
			/*error message*/if(!$res){echo $this->mysqli->error."\nclient :$query\n";return 1;}
			return 0;
		}
	}
?>
