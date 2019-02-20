<?php
	function Extract_spacee0($str){
		$space_name=strpos($str,"お申込みスペース");$space_name=mb_split("\n",substr($str,$space_name))[3];
		$price=strpos($str,"［合計料金］");$price=mb_split("\n",substr($str,$price))[1];
		$time= strpos($str,"［ご利用時間数］");$time= mb_split("\n",substr($str,$time))[1];
		$number=strpos($str,"［予約No］");$number=mb_split("\n",substr($str,$number))[1];
		$date=strpos($str,"［ご利用希望日時］");$date=mb_split("\n",substr($str,$date))[1];
		$client_mail=strpos($str,"［メールアドレス］");$client_mail=mb_split("\n",substr($str,$client_mail))[1];
		$client_name=strpos($str,"［お名前］");$client_name=mb_split("\n",substr($str,$client_name))[1];
		$client_phone=strpos($str,"［電話番号］");$client_phone=mb_split("\n",substr($str,$client_phone))[1];
		$address=strpos($str,"住所:");$address=mb_split(" ",substr($str,$address))[1];
		$map=strpos($str,"MAP:");$map=mb_split("[ \n]",substr($str,$map))[1];
		echo $space_name."\n";
		echo $price."\n";
		echo $time."\n";
		echo $number."\n";
		echo $date."\n";
		echo $client_mail."\n";
		echo $client_name."\n";
		echo $client_phone."\n";
		echo $address."\n";
		echo $map."\n";
	}
	function Extract_spacee1($str){
		$space_name=strpos($str,"お申込みスペース");$space_name=mb_split("\n",substr($str,$space_name))[3];
		$price=strpos($str,"［合計料金］");$price=mb_split("\n",substr($str,$price))[1];
		$time= strpos($str,"［ご利用時間数］");$time= mb_split("\n",substr($str,$time))[1];
		$number=strpos($str,"［予約No］");$number=mb_split("\n",substr($str,$number))[1];
		$date=strpos($str,"［ご利用希望日時］");$date=mb_split("\n",substr($str,$date))[1];
		$client_mail=strpos($str,"［メールアドレス］");$client_mail=mb_split("\n",substr($str,$client_mail))[1];
		$client_name=strpos($str,"［お名前］");$client_name=mb_split("\n",substr($str,$client_name))[1];
		$client_phone=strpos($str,"［電話番号］");$client_phone=mb_split("\n",substr($str,$client_phone))[1];
		$address=strpos($str,"住所:");$address=mb_split(" ",substr($str,$address))[1];
		$map=strpos($str,"MAP:");$map=mb_split("[ \n]",substr($str,$map))[1];
		echo $space_name."\n";
		echo $price."\n";
		echo $time."\n";
		echo $number."\n";
		echo $date."\n";
		echo $client_mail."\n";
		echo $client_name."\n";
		echo $client_phone."\n";
		echo $address."\n";
		echo $map."\n";
		if($space_name=='')
			echo $str."\n";
	}
	$imap='{imap.googlemail.com:993/novalidate-cert/imap/ssl}INBOX';
	$username='common10111@gmail.com';
	$password='Tmcitonetwothree';
	$response=imap_open($imap,$username,$password);
	if(!$response){
		echo "Failed\n";
		exit(1);
	}
	//$message_ids=imap_search($response,'From "no-reply@" BEFORE "10 February 2019"');
	$message_ids=imap_search($response,'From "no-reply@"');
	$file_names=file("title.txt");
	foreach($message_ids as $message_id){
		$header=imap_headerinfo($response,$message_id);
		$subject=mb_decode_mimeheader($header->subject);
		if(strpos($subject, trim($file_names[0])) and strpos($subject,"入金を確認しました") ){
			$body=imap_fetchbody($response,$message_id,1,FT_INTERNAL);
			$body=base64_decode($body);
			echo $subject."\n";
			Extract_spacee0($body);
		}
		else if(strpos($subject, trim($file_names[0])) and strpos($subject,"スペース予約確定") ){
			$body=imap_fetchbody($response,$message_id,1,FT_INTERNAL);
			$body=base64_decode($body);
			echo $subject."\n";
			Extract_spacee1($body);
		}
		else if(strpos($subject, trim($file_names[0])) and strpos($subject,"未入金の") ){
			$body=imap_fetchbody($response,$message_id,1,FT_INTERNAL);
			$body=base64_decode($body);
			echo $subject."\n";
			echo $body."\n";
		}
	}
?>
