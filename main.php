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
	//$message_ids=imap_search($mail->box,'From "no-reply@" BEFORE "10 February 2019"');
	$message_ids=imap_sort($mail->box,SORTARRIVAL,0);
	foreach($message_ids as $message_id){
		$db=$mail->classifier($message_id);
		if(is_null($db))
			continue;
		if($db->operation==1){
			$db->output();
			if($mysqli->insert($db))
				file_put_contents("Error.txt",var_dump($db->subject)."\n".var_dump($db->body)."\n\n",FILE_APPEND);
		}else if($db->operation==-1){
			$db->output();
			if($mysqli->delete($db))
				file_put_contents("Error.txt",var_dump($db->subject)."\n".var_dump($db->body)."\n\n",FILE_APPEND);
		}
	}
?>
