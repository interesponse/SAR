<?php
	class Classification{
		public $box;
		public function classifier($message_id){
			$db=null;
			$header=imap_headerinfo($this->box,$message_id);
			$subject=mb_decode_mimeheader($header->subject);
			if(strpos($subject, 'スペイシー')){
				$body=imap_fetchbody($this->box,$message_id,1,FT_INTERNAL);
				if(strpos($subject,"入金を確認しました") ){
					$body=base64_decode($body);
					$db=Extract_spacee0($body);
					$db->operation=1;
				}else if(strpos($subject,"スペース予約確定") ){
					$body=my_base64_decode($body);
					$db=Extract_spacee0($body);
				}else if(strpos($subject,"未入金の") ){
					$body=base64_decode($body);
					echo $subject."\n";
					echo $body."\n";
					$db=Extract_spacee0($body);
					exit(1);
				}
			}
			else if(strpos($subject,trim('れすなび'))){
				$body=imap_fetchbody($this->box,$message_id,1,FT_INTERNAL);
				$body=mb_convert_encoding(imap_qprint($body),'UTF-8','ISO-2022-JP');
				if(strpos($subject,"スペース予約確定")){
					$db=Extract_resnavi0($body);
				}else if(strpos($subject,"入金を確認しました")){
					$db=Extract_resnavi0($body);
					$db->operation=1;
				}else if(strpos($subject,"予約がキャンセル")){
					echo $subject."\n";
					echo end(mb_split('\.',$subject))."\n";
					$db=Extract_resnavi0($body);
				}else if(strpos($subject,"入金を確認できません")){
					$db=Extract_resnavi0($body);
				}
			}
			else{
				$body=imap_fetchbody($this->box,$message_id,1,FT_INTERNAL);
				$body=imap_qprint($body);
				if(strpos($subject,"今すぐ予約")and false){
					$db=Extract_spacemarket0($body);
					$db->operation=1;
				}else if(strpos($subject,"予約キャンセル")){
					$db=Extract_spacemarket0($body);
				}else if(strpos($subject,"予約内容の変更リクエスト：承諾")){
					$db=Extract_spacemarket0($body);
				}else if(strpos($subject,"予約内容の変更リクエスト")){
					$db=Extract_spacemarket0($body);
				}else if(strpos($subject,"予約内容の変更リクエスト：却下")){
					$db=Extract_spacemarket0($body);
				}
			}
			if(!is_null($db)) return $db;
			return null;
		}
	}
?>
