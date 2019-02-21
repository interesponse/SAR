<?php
	require_once "Extract.php";
	require_once "Database.php";
	require_once "mail.php";
	$mail=new Classification();
	$imap='{imap.googlemail.com:993/novalidate-cert/imap/ssl}INBOX';
	$username='common10111@gmail.com';
	$password='Tmcitonetwothree';
	$mail->box=imap_open($imap,$username,$password);
	$mysqli=new Database();
	if(!$mail->box){
		echo "Failed\n";
		exit(1);
	}
	$message_ids=imap_search($mail->box,'From "no-reply@" BEFORE "10 February 2019"');
	foreach($message_ids as $message_id){
		$db=$mail->classifier($message_id);
		if(is_null($db))
			continue;
		if($db->operation==1){
			$db->output();
			$mysqli->insert($db);
		}else if($db->operation==-1){
		}
	}
?>
