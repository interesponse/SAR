<?php
	function Extract_spacee($str){
		$name_s=strpos($str,"お申込みスペース");
		$phone_s=strpos($str,"電話");
		$address_s=strpos($str,"住所:");
		$map_s=strpos($str,"MAP:");
		echo "\n\n".$phone_s."\n\n";
		echo $str;
	}
//	mb_language('ja');
//	mb_internal_encoding("UTF-8");
	$imap='{imap.googlemail.com:993/novalidate-cert/imap/ssl}INBOX';
	$username='common10111@gmail.com';
	$password='Tmcitonetwothree';
	//$response=imap_open($imap,$username,$password);
//	if(!$response){
//		echo "Failed\n";
//		exit(1);
//	}
	//$message_ids=imap_search($response,'From "no-reply@" BEFORE "10 February 2019"');
//	foreach($message_ids as $message_id){
		//$header=imap_headerinfo($response,$message_id);
		//$subject=mb_decode_mimeheader($header->subject);
		//$body=imap_fetchbody($response,$message_id,1,FT_INTERNAL);
		//$body=base64_decode($body);
		//$f="スぺイシー";
		$a=file("titles.txt");
		foreach($a as $subject){
//			echo $subject."\n";
			$t=strpos($subject,"スぺイシー");
			if($t)
				echo $subject."\n";
		}
//		}
?>
