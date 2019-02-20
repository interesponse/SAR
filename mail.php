<?php
	function my_base64_decode($str){
		$not_decode=array('mimepart','Content','charset');
		$new_str="";
		foreach(mb_split("[\n\r]",$str) as $a)
			if(strpos($a,$not_decode[0])or strpos($a,$not_decode[1])or strpos($a,$not_decode[2]));
			else $new_str=$new_str.trim($a);
		return mb_convert_encoding($new_str,'UTF-8','BASE64');
	}
	function Extract_common($str){
		$space_name=strpos($str,"お申込みスペース");$space_name=mb_split("\n",substr($str,$space_name))[3];
		$price=strpos($str,"［合計料金］");$price=mb_split("\n",substr($str,$price))[1];
		$time= strpos($str,"［ご利用時間数］");$time= mb_split("\n",substr($str,$time))[1];
		$number=strpos($str,"［予約No］");$number=mb_split("\n",substr($str,$number))[1];
		$date=strpos($str,"［ご利用希望日時］");$date=mb_split("\n",substr($str,$date))[1];
		$client_mail=strpos($str,"［メールアドレス］");$client_mail=mb_split("\n",substr($str,$client_mail))[1];
		$client_name=strpos($str,"［お名前］");$client_name=mb_split("\n",substr($str,$client_name))[1];
		$client_phone=strpos($str,"［電話番号］");$client_phone=mb_split("\n",substr($str,$client_phone))[1];
		echo $space_name."\n";
		echo $price."\n";
		echo $time."\n";
		echo $number."\n";
		echo $date."\n";
		echo $client_mail."\n";
		echo $client_name."\n";
		echo $client_phone."\n";
	}
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
	function Extract_resnavi0($str){
		$space_name=strpos($str,"お申込みスペース");
		$space_name=mb_split("\n",substr($str,$space_name))[3];
		$price=strpos($str,"[合計料金]");
		$price=mb_split("\n",substr($str,$price))[1];
		$time= strpos($str,"[ご利用時間数]");
		$time= mb_split("\n",substr($str,$time))[1];
		$number=strpos($str,"[予約No]");
		$number=mb_split("\n",substr($str,$number))[1];
		$date=strpos($str,"[ご利用希望日時]");
		$date=mb_split("\n",substr($str,$date))[1];
		$client_mail=strpos($str,"[メールアドレス]");
		$client_mail=mb_split("\n",substr($str,$client_mail))[1];
		$client_name=strpos($str,"[お名前]");
		$client_name=mb_split("\n",substr($str,$client_name))[1];
		$client_phone=strpos($str,"[電話番号]");
		$client_phone=mb_split("\n",substr($str,$client_phone))[1];
		echo $space_name."\n";
		echo $price."\n";
		echo $time."\n";
		echo $number."\n";
		echo $date."\n";
		echo $client_mail."\n";
		echo $client_name."\n";
		echo $client_phone."\n";
		echo $address."\n";
	
	}
	function Extract_spacemarket0($str){
		$str=mb_split("<[^>]*>",$str);
		for($i=0;$i<count($str);$i++)$str[$i]=trim($str[$i]);
		$space_name=array_search("スペース名",$str);$space_name=$str[$space_name+2];
		$price=array_search("合計",$str);$price=$str[$price+2];
		$time=array_search("利用期間",$str);$time=$str[$time+2];
		$number=array_search("予約ID",$str);$number=$str[$number+2];
		$client_name=array_search("お名前",$str);$client_name=$str[$client_name+2];
		echo $space_name."\n";
		echo $price."\n";
		echo $time."\n";
		echo $number."\n";
		echo $client_name."\n";
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
		if(strpos($subject, trim($file_names[0])) and false){
			$body=imap_fetchbody($response,$message_id,1,FT_INTERNAL);
			if(strpos($subject,"入金を確認しました") ){
				$body=base64_decode($body);
				echo $subject."\n";
				Extract_spacee0($body);
				echo "\n\n";
			}
			else if(strpos($subject,"スペース予約確定") ){
				$body=my_base64_decode($body);
				Extract_spacee0($body);
				echo "\n\n";
			}
			else if(strpos($subject,"入金の") ){
				$body=base64_decode($body);
				echo $subject."\n";
				echo $body."\n";
				Extract_spacee1($body);
				Extract_spacee0($body);
				exit(1);
			}
			else if(strpos($subject,"入金の") ){
				$body=base64_decode($body);
				echo $subject."\n";
				echo $body."\n";
				Extract_spacee1($body);
				Extract_spacee0($body);
				exit(1);
			}
		}
		else if(strpos($subject,trim($file_names[1])) and false){
			$body=imap_fetchbody($response,$message_id,1,FT_INTERNAL);
			$body=mb_convert_encoding(imap_qprint($body),'UTF-8','ISO-2022-JP');
			if(strpos($subject,"スペース予約確定")){
				echo $subject."\n";
				Extract_resnavi0($body);
			}
			else if(strpos($subject,"入金を確認しました")){
				echo $subject."\n";
				Extract_resnavi0($body);
			}
			else if(strpos($subject,"予約がキャンセル")){
				echo $subject."\n";
				echo end(mb_split('\.',$subject))."\n";
				Extract_resnavi0($body);
			}
			else if(strpos($subject,"入金を確認できません")){
				echo $subject."\n";
				Extract_resnavi0($body);
			}
		}
		else{
			$body=imap_fetchbody($response,$message_id,1,FT_INTERNAL);
			$body=imap_qprint($body);
			if(strpos($subject,"今すぐ予約")and false){
				echo $subject."\n";
				Extract_spacemarket0($body);
			}
			else if(strpos($subject,"予約キャンセル")){
				echo $subject."\n";
				Extract_spacemarket0($body);
			}else if(strpos($subject,"予約内容の変更リクエスト：承諾")){
				echo $subject."\n";
				Extract_spacemarket0($body);
			}else if(strpos($subject,"予約内容の変更リクエスト")){
				echo $subject."\n";
				Extract_spacemarket0($body);
			}else if(strpos($subject,"予約内容の変更リクエスト：却下")){
				echo $subject."\n";
				Extract_spacemarket0($body);
			}
		}
	}
?>
