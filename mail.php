<?php
	function Extract_spacee0($str){
		echo $str;
		$name_s=strpos($str,"お申込みスペース");
		$price_s=strpos($str,"［合計料金］");
		$time_s= strpos($str,"［ご利用時間数］");
		$number_s=strpos($str,"［予約No］");
		echo "\n\n".$addres_s."\n\n";
		$space_name=mb_split("\n",substr($str,$name_s))[3];
		$price=mb_split("\n",substr($str,$price_s))[1];
		$time= mb_split("\n",substr($str,$time_s))[1];
		$number=mb_split("\n",substr($str,$number_s))[1];
		echo $space_name."\n";
		echo $price."\n";
		echo $time."\n";
		echo $number."\n";
	}
	/*
	$imap='{imap.googlemail.com:993/novalidate-cert/imap/ssl}INBOX';
	$username='common10111@gmail.com';
	$password='Tmcitonetwothree';
	$response=imap_open($imap,$username,$password);
	if(!$response){
		echo "Failed\n";
		exit(1);
	}
	$message_ids=imap_search($response,'From "no-reply@" BEFORE "10 February 2019"');
	$file_names=file("title.txt");
	foreach($message_ids as $message_id){
		$header=imap_headerinfo($response,$message_id);
		$subject=mb_decode_mimeheader($header->subject);
		$body=imap_fetchbody($response,$message_id,1,FT_INTERNAL);
		$body=base64_decode($body);
		$body=mb_convert_encoding($body,'UTF-8');
		if(strpos($subject, trim($file_names[0])) and strpos($subject,"入金を確認しました") ){
			echo $subject;
			Extract_spacee0($body);
		}
	}
	*/
	$str=file_get_contents("text.txt");
	Extract_spacee0($str);
?>
