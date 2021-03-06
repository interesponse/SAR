<?php
	function my_base64_decode($str){
		$not_decode=array('mimepart','Content','charset');
		$new_str="";
		foreach(mb_split("[\n\r]",$str) as $a)
			if(strpos($a,$not_decode[0])or strpos($a,$not_decode[1])or strpos($a,$not_decode[2]));
			else $new_str=$new_str.trim($a);
		return mb_convert_encoding($new_str,'UTF-8','BASE64');
	}
	function convert_datetime($str,$only=false){
		$f=trim($str);
		$f=mb_ereg_replace("日",'',$f);
		$t=mb_split("[年月　 \/:～〜]",$f);
		$date_e=trim($t[0]).'-'.trim($t[1]).'-'.trim($t[2]);
		$date_s=$date_e.' '.mb_substr(trim($t[3]),mb_strlen(trim($t[3]))-2).':'.trim($t[4]);
		if($only)return $date_s;
		$date_e=$date_e.' '.trim($t[5]).':'.mb_substr(trim($t[6]),0,2);
		return array($date_s,$date_e);
	}
	class Elements{
		//about service
		public $booking_number;
		public $space_name;
		public $site_name;
		public $price;
		public $date_s;
		public $date_e;
		public $application_date;
		//about client
		public $client_name;
		public $client_mail;
		public $client_organization;
		public $client_purpose;
		//about mail
		public $body;
		public $subject;
		//other
		public $operation=0;
		public function output(){
			echo "Site name : ".$this->site_name."\n";
			echo "Booking  No.".$this->booking_number."\n";
			echo "Space name: ".$this->space_name."\n";
			echo "Price     : ".$this->price."\n";
			echo "date s  : ".$this->date_s."\n";
			echo "date e  : ".$this->date_e."\n";
			echo "date a  : ".$this->application_date."\n";
			echo "Client name:".$this->client_name."\n";
			echo "Client mail:".$this->client_mail."\n";
			echo "client organization: ".$this->client_organization."\n";
			echo "Client purpose: ".$this->client_purpose."\n";
			echo "\n\n";
		}
	}
	function Extract_spacee0($str){
		$space_name=strpos($str,"お申込みスペース");$space_name=mb_split("\n",substr($str,$space_name))[3];
		$price=strpos($str,"［合計料金］");$price=mb_split("\n",substr($str,$price))[1];
		$number=strpos($str,"［予約No］");$number=mb_split("\n",substr($str,$number))[1];
		$date=strpos($str,"［ご利用希望日時］");$date=mb_split("\n",substr($str,$date))[1];
		$client_mail=strpos($str,"［メールアドレス］");$client_mail=mb_split("\n",substr($str,$client_mail))[1];
		$client_name=strpos($str,"［お名前］");$client_name=mb_split("\n",substr($str,$client_name))[1];
		$client_phone=strpos($str,"［電話番号］");$client_phone=mb_split("\n",substr($str,$client_phone))[1];
		$client_organization=strpos($str,"［会社名または団体名］");$client_organization=mb_split("\n",substr($str,$client_organization))[1];
		$client_purpose=strpos($str,"［ご利用目的／用途］");$client_purpose=mb_split("\n",substr($str,$client_purpose))[1];
		$application_date=strpos($str,"[ お申し込み日 ]");
		$application_date=mb_split("\n",substr($str,$application_date))[1];
		$address=strpos($str,"住所:");$address=mb_split(" ",substr($str,$address))[1];
		$map=strpos($str,"MAP:");$map=mb_split("[ \n]",substr($str,$map))[1];
		$info=new Elements();
		//mail
		$info->body=$str;
		//service
		$info->booking_number=trim($number);
		$info->price=trim(mb_ereg_replace("[,円￥\ 　]",'',$price));
		$info->site_name='Spacee';
		$info->space_name=trim($space_name);
		list($info->date_s,$info->date_e)=convert_datetime($date);
		$info->application_date=convert_datetime($application_date,true);
		//client
		$info->client_name=trim(mb_ereg_replace('[　 ]*様','',$client_name));
		$info->client_mail=trim($client_mail);
		$info->client_purpose=trim($client_purpose);
		$info->client_organization=trim($client_organization);
		return $info;
	}
	function Extract_resnavi0($str){
		$space_name=strpos($str,"お申込みスペース");$space_name=mb_split("\n",substr($str,$space_name))[3];
		$price=strpos($str,"[合計料金]");$price=mb_split("\n",substr($str,$price))[1];
		$number=strpos($str,"[予約No]");$number=mb_split("\n",substr($str,$number))[1];
		$date=strpos($str,"[ご利用希望日時]");$date=mb_split("\n",substr($str,$date))[1];
		$client_mail=strpos($str,"[メールアドレス]");$client_mail=mb_split("\n",substr($str,$client_mail))[1];
		$client_name=strpos($str,"[お名前]");$client_name=mb_split("\n",substr($str,$client_name))[1];
		$client_phone=strpos($str,"[電話番号]");$client_phone=mb_split("\n",substr($str,$client_phone))[1];
		$client_organization=strpos($str,"[会社名または団体名]");$client_organization=mb_split("\n",substr($str,$client_organization))[1];
		$client_purpose=strpos($str,"[ご利用目的／用途]");$client_purpose=mb_split("\n",substr($str,$client_purpose))[1];
		$application_date=strpos($str,"[お申込日]");$application_date=mb_split("\n",substr($str,$application_date))[1];
		$info=new Elements();
		//mail
		$info->body=$str;
		//service
		$info->booking_number=trim($number);
		$info->site_name='Resnavi';
		$info->space_name=trim($space_name);
		$info->price=trim(mb_ereg_replace("[,円￥\ 　]",'',$price));
		list($info->date_s,$info->date_e)=convert_datetime($date);
		$info->application_date=convert_datetime($application_date,true);
		//client
		$info->client_name=trim(mb_ereg_replace('[　 ]*様','',$client_name));
		$info->client_mail=trim($client_mail);
		$info->client_organization=trim($client_organization);
		$info->client_purpose=trim($client_purpose);
		return $info;
	}
	function Extract_spacemarket0($str){
		$str=mb_split("<[^>]*>",$str);
		for($i=0;$i<count($str);$i++)$str[$i]=trim($str[$i]);
		$space_name=array_search("スペース名",$str);$space_name=$str[$space_name+2];
		$price=array_search("合計",$str);$price=$str[$price+2];
		$date=array_search("利用期間",$str);$date=$str[$date+2];
		$number=array_search("予約ID",$str);$number=$str[$number+2];
		$client_name=array_search("お名前",$str);$client_name=$str[$client_name+2];
		$client_purpose=array_search("利用用途の詳細",$str);$client_purpose=$str[$client_purpose+2];
		$client_organization=array_search("法人・団体名",$str);$client_organization=$str[$client_organization+2];
		$info=new Elements();
		$info->body=$str;
		$info->booking_number=trim($number);
		$info->space_name=trim($space_name);
		list($info->date_s,$info->date_e)=convert_datetime($date);
		$info->price=trim($price);
		$info->price=trim(mb_ereg_replace("[,円￥\ 　]",'',$price));
		$info->client_name=trim(mb_ereg_replace('[　 ]*様','',$client_name));
		$info->client_mail=trim($client_mail);
		$info->site_name='Spacemarket';
		$info->client_purpose=trim($client_purpose);
		$info->client_organization=trim($client_organization);
		return $info;
	}
?>
