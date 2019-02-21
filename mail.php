<?php
	require_once "Extract.php";
	require_once "Datebase.php";
	$imap='{imap.googlemail.com:993/novalidate-cert/imap/ssl}INBOX';
	$username='common10111@gmail.com';
	$password='Tmcitonetwothree';
	$response=imap_open($imap,$username,$password);
	$mysqli=mysqli_initial();
	if(!$response){
		echo "Failed\n";
		exit(1);
	}
	//$message_ids=imap_search($response,'From "no-reply@" BEFORE "10 February 2019"');
	$message_ids=imap_search($response,'From "no-reply@" BEFORE "10 February 2019"');
	$file_names=file("title.txt");
	foreach($message_ids as $message_id){
		$header=imap_headerinfo($response,$message_id);
		$subject=mb_decode_mimeheader($header->subject);
//		echo $subject."\n";
		if(strpos($subject, trim($file_names[0]))){
			$body=imap_fetchbody($response,$message_id,1,FT_INTERNAL);
			if(strpos($subject,"入金を確認しました") ){
				$body=base64_decode($body);
				$db=Extract_spacee0($body);
				//$db->output();
				insert($db,$mysqli);
			}
			else if(strpos($subject,"スペース予約確定") ){
				$body=my_base64_decode($body);
				$db=Extract_spacee0($body);
				//$db->output();
				insert($db,$mysqli);
			}
			else if(strpos($subject,"未入金の") ){
				$body=base64_decode($body);
				echo $subject."\n";
				echo $body."\n";
				$db=Extract_spacee0($body);
				insert($db,$mysqli);
				exit(1);
			}
		}
		else if(strpos($subject,trim($file_names[1]))){
			$body=imap_fetchbody($response,$message_id,1,FT_INTERNAL);
			$body=mb_convert_encoding(imap_qprint($body),'UTF-8','ISO-2022-JP');
			if(strpos($subject,"スペース予約確定")){
				$db=Extract_resnavi0($body);
				//$db->output();
				insert($db,$mysqli);
			}
			else if(strpos($subject,"入金を確認しました")){
				$db=Extract_resnavi0($body);
				//$db->output();
				insert($db,$mysqli);

			}
			else if(strpos($subject,"予約がキャンセル")){
				echo $subject."\n";
				echo end(mb_split('\.',$subject))."\n";
				$db=Extract_resnavi0($body);
				//$db->output();
				insert($db,$mysqli);
			}
			else if(strpos($subject,"入金を確認できません")){
				$db=Extract_resnavi0($body);
				//$db->output();
				insert($db,$mysqli);
			}
		}
		else{
			$body=imap_fetchbody($response,$message_id,1,FT_INTERNAL);
			$body=imap_qprint($body);
			if(strpos($subject,"今すぐ予約")and false){
				$db=Extract_spacemarket0($body);
				//$db->output();
				insert($db,$mysqli);
			}
			else if(strpos($subject,"予約キャンセル")){
				$db=Extract_spacemarket0($body);
				//$db->output();
				insert($db,$mysqli);
			}else if(strpos($subject,"予約内容の変更リクエスト：承諾")){
				$db=Extract_spacemarket0($body);
				//$db->output();
				insert($db,$mysqli);
			}else if(strpos($subject,"予約内容の変更リクエスト")){
				$db=Extract_spacemarket0($body);
				//$db->output();
				insert($db,$mysqli);
			}else if(strpos($subject,"予約内容の変更リクエスト：却下")){
				$db=Extract_spacemarket0($body);
				//$db->output();
				insert($db,$mysqli);
			}
		}
	}
?>
