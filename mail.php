<?php
	$imap='{imap.googlemail.com:993/novalidate-cert/imap/ssl}INBOX';
	$username='common10111@gmail.com';
	$password='Tmcitonetwothree';
	$response=imap_open($imap,$username,$password);
	if(!$response)
		echo "Failed\n";
	else{
		$message_ids=imap_search($response,ALL);
		print_r($message_ids);
		foreach($message_ids as $message_id){
			$header=imap_headerinfo($response,$message_id);
			$subject=mb_decode_mimeheader($header->subject);
			echo $subject."\n";
			$body=imap_fetchbody($response,$message_id,1,FT_INTERNAL);
			$body=trim($body);
			$body=mb_convert_encoding($body,'JIS');
			echo $body."\n";
		}
	}
?>
