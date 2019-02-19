<?php
	$imap='{imap.googlemail.com:993/novalidate-cert/imap/ssl}INBOX';
	$username='common10111@gmail.com';
	$password='Tmcitonetwothree';
	$response=imap_open($imap,$username,$password);
	if(!$response)
		echo "Failed\n";
	else{
		print($response);
		$message_ids=imap_search($response,UNSEEN,SE_UID);
		print_r($message_ids);
		foreach($message_ids as $mesage_id){
			$body=imap_fetchbody($response,$mesage_id,1,FT_INTERNAL);
			$body=trim($body);
			print($body);
		}
	}
?>
