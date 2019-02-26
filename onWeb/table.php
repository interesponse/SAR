<?php
	class Table{
		public $id;
		public $code;
		public $start_date;
		public $end_date;
		public function html_table($id,$input,$color){
			$i=0;
			echo $this->start_date."   ".$this->end_date;
			$this->id=$id;
			$selected['Sales']=$_POST['table_type']=='Sales'?'selected':'';
			$selected['Utilizations']=$_POST['table_type']=='Utilizations'?'selected':'';
			$code="";
			$code.="<div id='table-$id'><form action=main.php method=post>".PHP_EOL;
			$code.="<select name=table_type>".PHP_EOL;
			$code.="<option value='Sales' ".$selected['Sales'].">Sales</option>".PHP_EOL;
			$code.="<option value='Utilizations' ".$selected['Utilizations'].">Utilizations</option>".PHP_EOL;
			$code.="</select>".PHP_EOL;
			$code.="<input type=date name=start_date value='$this->start_date'>".PHP_EOL;
			$code.="<input type=date name=end_date value='$this->end_date'>".PHP_EOL;
			$code.="<input type=submit name=update value=update>".PHP_EOL;
			$code.="<input type=submit name=delete value=delete>".PHP_EOL;
			$code.="<input type=submit name=append value=append>".PHP_EOL;
			$code.="<input type=hidden name=id value=$id>".PHP_EOL;
			$code.="</form>".PHP_EOL;
			$code.="<table border=1>".PHP_EOL;
			$code.="<caption>".$_POST['table_type']."</caption>";
			foreach((array)$input as $row){
				$j=0;
				$code.="<tr>".PHP_EOL;
				foreach($row as $data){
					if($i==0)
						$code.="<th>$data</th>".PHP_EOL;
					else{
						$code.="<td ".$color[$i][$j].">$data</td>".PHP_EOL;
						$j++;
					}
				}
				$i++;
				$code.="</tr>".PHP_EOL;
			}
			$code.="</table>".PHP_EOL;
			$code.="</div>".PHP_EOL;
			$this->code=$code;
		}
		public function output(){
			echo $this->code;
			echo "---------------- ".$this->id."----------------\n<br>";
		}
		public function to_table($query_res){
			$i=$j=0;
			$table;
			foreach($query_res as $row){
				$j=0;
				if($i==0){
					foreach(array_keys($row)as $each){
					$table[$i][$j]=$each;
					$j++;
					}
					$j=0;
					$i++;
				}
				foreach($row as $each){
					$table[$i][$j]=$each;
					$j++;
				}
				$i++;
			}
			return $table;
		}
		public function heatmap_all($table){
			$max=-1000;
			$min= 1000;
			//gradation Xi is color of 0%
			//			Xe is color of 100%
			$Ri=255;
			$Gi=255;
			$Bi=255;
			$Re=200;
			$Ge=20;
			$Be=20;
			for($i=1;$i<count($table);$i++){
				for($j=1;$j<count($table[0]);$j++){
					if($max<$table[$i][$j])$max=$table[$i][$j];
					if($min>$table[$i][$j])$min=$table[$i][$j];
				}
			}
			$range=$max-$min;
			for($i=0;$i<count($table);$i++)for($j=0;$j<count($table[$i]);$j++)$color[$i][$j]='';
			for($i=1;$i<count($table);$i++){
				for($j=1;$j<count($table[$i]);$j++){
					$Rx=($Re-$Ri)*($table[$i][$j]/$range)+$Ri;
					$Gx=($Ge-$Gi)*($table[$i][$j]/$range)+$Gi;
					$Bx=($Be-$Bi)*($table[$i][$j]/$range)+$Bi;
					$color[$i][$j]="style=background-color:rgb($Rx,$Gx,$Bx);";
				}
			}
			return $color;
		}
	}
	class Create_table{
		public static $mysqli;
		public static $id_counter=0;
		public static function sales($id,$start_date=null,$end_date=null){
			if(is_null($end_date)){
				$start_date=$_POST['start_date'];
				$end_date=$_POST['end_date'];
			}
			$table_obj=new Table();
			$query="select new_essential.space_name,
   					sum(case when new_essential.site_name='Spacee' then service.price else 0 end) as 'spacee',
 					sum(case when new_essential.site_name='Resnavi' then service.price else 0 end) as 'resnavi',
   					sum(case when new_essential.site_name='Spacemarket' then service.price else 0 end) as 'spacemarket' 
					from new_essential join service on new_essential.booking_no=service.booking_no
					where service.start_date between '$start_date' and '$end_date' group by new_essential.space_name;";
			$res=Create_table::$mysqli->query($query);
			$table=$table_obj->to_table($res);
			$table_obj->start_date=$start_date;
			$table_obj->end_date=$end_date;
			$color=$table_obj->heatmap_all($table);
			$table_obj->html_table($id,$table,$color);
			return $table_obj;
		}
		public static function utilizations($id,$start_date=null,$end_date=null){
			if(is_null($end_date)){
				$start_date=$_POST['start_date'];
				$end_date=$_POST['end_date'];
			}
			$table_obj=new Table();
			$query="select space_name,
					sum(case when '06:00' between time(start_date) and time(end_date) then 1 else 0 end) as '06',
					sum(case when '07:00' between time(start_date) and time(end_date) then 1 else 0 end) as '07',
					sum(case when '08:00' between time(start_date) and time(end_date) then 1 else 0 end) as '08',
					sum(case when '09:00' between time(start_date) and time(end_date) then 1 else 0 end) as '09',
					sum(case when '10:00' between time(start_date) and time(end_date) then 1 else 0 end) as '10',
					sum(case when '11:00' between time(start_date) and time(end_date) then 1 else 0 end) as '11',
					sum(case when '12:00' between time(start_date) and time(end_date) then 1 else 0 end) as '12',
					sum(case when '13:00' between time(start_date) and time(end_date) then 1 else 0 end) as '13',
					sum(case when '14:00' between time(start_date) and time(end_date) then 1 else 0 end) as '14',
					sum(case when '15:00' between time(start_date) and time(end_date) then 1 else 0 end) as '15',
					sum(case when '16:00' between time(start_date) and time(end_date) then 1 else 0 end) as '16',
					sum(case when '17:00' between time(start_date) and time(end_date) then 1 else 0 end) as '17',
					sum(case when '18:00' between time(start_date) and time(end_date) then 1 else 0 end) as '18',
					sum(case when '19:00' between time(start_date) and time(end_date) then 1 else 0 end) as '19',
					sum(case when '20:00' between time(start_date) and time(end_date) then 1 else 0 end) as '20'
					from (select service.booking_no,service.start_date,service.end_date,new_essential.site_name,new_essential.space_name 
					from service join new_essential on service.booking_no=new_essential.booking_no 
					where service.start_date between '".$_POST['start_date']."' and '".$_POST['end_date']."') as new group by space_name;";
			$res=Create_table::$mysqli->query($query);
			$table=$table_obj->to_table($res);
			$color=$table_obj->heatmap_all($table);
			$table_obj->start_date=$start_date;
			$table_obj->end_date=$end_date;
			$table_obj->html_table($id,$table,$color);
			return $table_obj;
		}
	}
?>
