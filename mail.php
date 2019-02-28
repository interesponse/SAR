<?php
	class Classification{
		public $box;
		public function classifier($message_id){
			$db=null;
			$header=imap_headerinfo($this->box,$message_id);
			$subject=mb_decode_mimeheader($header->subject);
			echo $subject."\n";
			if(strpos($subject, 'スペイシー')){
				$body=imap_fetchbody($this->box,$message_id,1,FT_INTERNAL);
				if(strpos($subject,"入金を確認しました") ){
					//not used
					//no operation for this message
					$body=base64_decode($body);
					$db=Extract_spacee0($body);
				}else if(strpos($subject,"スペース予約確定") ){
					//db insert operation
					$body=my_base64_decode($body);
					$db=Extract_spacee0($body);
					$db->operation=1;
				}else if(strpos($subject,"未入金の") ){
					//unchecked
					//db delete operation
					$body=base64_decode($body);
					$db=Extract_spacee0($body);
					$db->operation=-1;
				}
				$db->subject=$subject;
			}
			else if(strpos($subject,trim('れすなび'))){
				$body=imap_fetchbody($this->box,$message_id,1,FT_INTERNAL);
				$body=mb_convert_encoding(imap_qprint($body),'UTF-8','ISO-2022-JP');
				if(strpos($subject,"スペース予約確定")){
					//db insert operation
					$db=Extract_resnavi0($body);
					$db->operation=1;
				}else if(strpos($subject,"入金を確認しました")){
					//not used
					//no operation for this message
					$db=Extract_resnavi0($body);
				}else if(strpos($subject,"予約がキャンセル")){
					//db delete operation
					$db->operation=-1;
					$db=Extract_resnavi0($body);
				}else if(strpos($subject,"入金を確認できません")){
					//db delete operation
					$db=Extract_resnavi0($body);
					$db->operation=1;
				}
				$db->subject=$subject;
			}
			else{
				$body=imap_fetchbody($this->box,$message_id,1,FT_INTERNAL);
				$body=imap_qprint($body);
				if(strpos($body,'body')===false)
					$body=base64_decode($body);
				if(strpos($subject,"今すぐ予約")){
					//db insert operation
					$db=Extract_spacemarket0($body);
					$db->operation=1;
					$db->subject=$subject;
					$db->application_date=date("Y-m-d h:i",strtotime($header->date));
				}else if(strpos($subject,"予約キャンセル")){
					//db delete operation
					$db=Extract_spacemarket0($body);
					$db->operation=-1;
					$db->subject=$subject;
					$db->application_date=date("Y-m-d h:i",strtotime($header->date));
				}else if(strpos($subject,"予約内容の変更リクエスト：承諾")){
					//db delete and insert operation
					$db=Extract_spacemarket0($body);
					$db->operation=2;
					$db->subject=$subject;
					$db->application_date=date("Y-m-d h:i",strtotime($header->date));
				}else if(strpos($subject,"予約内容の変更リクエスト")){
					$db=Extract_spacemarket0($body);
				}else if(strpos($subject,"予約内容の変更リクエスト：却下")){
					//unchecked
					$db=Extract_spacemarket0($body);
				}
			}
			if(!is_null($db)){
				$db->subject=$subject;
				return $db;
			}
			return null;
		}
	}
?>
