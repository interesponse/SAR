<?php
	if(!isset($_SESSION))
		session_start();
	if(!isset($_SESSION['user_name'])){
		echo $_SESSION['user_name'];
		sleep(5);
		header("Location:index.php");
		exit;
	}
//	header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<head>
	<link rel=stylesheet type=text/css href=table.css>
	<meta charset=utf-8>
</head>
<body>
	<?php
		class Table{
			public $id;
			public $code;
			public $start_date;
			public $end_date;
			public $information;
			public function html_table($id,$input,$color){
				$i=0;
				echo $this->start_date."   ".$this->end_date;
				$this->id=$id;
				$selected_table['Sales']=$_POST['table_type']=='Sales'?'selected':'';
				$selected_table['Utilizations']=$_POST['table_type']=='Utilizations'?'selected':'';
				$selected_heatmap['all']=$_POST['heatmap']=='all'?'selected':'';
				$selected_heatmap['row']=$_POST['heatmap']=='row'?'selected':'';
				$selected_heatmap['column']=$_POST['heatmap']=='column'?'selected':'';
				$selected_heatmap['none']=$_POST['heatmap']=='none'?'selected':'';
				$code="";
				$code.="<div id='table-$id'><form action=main.php method=post>".PHP_EOL;
				$code.="<select name=table_type>".PHP_EOL;
				$code.="<option value='Sales' ".$selected_table['Sales'].">Sales</option>".PHP_EOL;
				$code.="<option value='Utilizations' ".$selected_table['Utilizations'].">Utilizations</option>".PHP_EOL;
				$code.="</select>".PHP_EOL;
				$code.="<input type=date name=start_date value='$this->start_date'>".PHP_EOL;
				$code.="<input type=date name=end_date value='$this->end_date'>".PHP_EOL;
				$code.="<select name=heatmap>".PHP_EOL;
				$code.="<option value=all ".$selected_heatmap['all'].">all</option>".PHP_EOL;
				$code.="<option value=row ".$selected_heatmap['row'].">row</option>".PHP_EOL;
				$code.="<option value=column ".$selected_heatmap['column'].">column</option>".PHP_EOL;
				$code.="<option value=none ".$selected_heatmap['none'].">none</option>".PHP_EOL;
				$code.="<input type=submit name=update value=update>".PHP_EOL;
				$code.="<input type=submit name=delete value=delete>".PHP_EOL;
				$code.="<input type=submit name=append value=append>".PHP_EOL;
				$code.="<input type=hidden name=id value=$id>".PHP_EOL;
				$code.="<input type=submit name=comparison value=comparison>".PHP_EOL;
				$code.="<input type=hidden name=comparison_flag value=$this->information>".PHP_EOL;
				if($this->information){
					$code.="<input type=date name=start_date2 value='".date('Y-m-d',strtotime($this->start_date."-1 month"))."'>".PHP_EOL;
					$code.="<input type=date name=end_date2 value='".date('Y-m-d',strtotime($this->end_date."-1 month"))."'>".PHP_EOL;
				}
				$code.="</form>".PHP_EOL;
				$code.="<table border=1>".PHP_EOL;
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
			public static function to_table($query_res){
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
			public static function heatmap_all($table){
				$max=-100000;
				$min= 100000;
				//gradation Xi is color of 0%
				//			Xe is color of 100%
				$Ri=255;$Gi=255;$Bi=255;
				$Re=200;$Ge= 20;$Be= 20;
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
			public static function heatmap_row($table){
				$Ri=255;$Gi=255;$Bi=255;
				$Re=200;$Ge= 20;$Be= 20;
				for($i=0;$i<count($table);$i++)for($j=0;$j<count($table[$i]);$j++)$color[$i][$j]='';
				for($i=1;$i<count($table);$i++){
					$max=-100000;
					$min= 100000;
					for($j=1;$j<count($table[$i]);$j++){
						if($max<$table[$i][$j])$max=$table[$i][$j];
						if($min>$table[$i][$j])$min=$table[$i][$j];
					}
					for($j=1;$j<count($table[$i]);$j++){
						$Rx=($Re-$Ri)*($table[$i][$j]/($max-$min))+$Ri;
						$Gx=($Ge-$Gi)*($table[$i][$j]/($max-$min))+$Gi;
						$Bx=($Be-$Bi)*($table[$i][$j]/($max-$min))+$Bi;
						$color[$i][$j]="style=background-color:rgb($Rx,$Gx,$Bx);";
					}
				}
				return $color;
			}
			public static function heatmap_column($table){
				$Ri=255;$Gi=255;$Bi=255;
				$Re=200;$Ge= 20;$Be= 20;
				for($i=0;$i<count($table);$i++)for($j=0;$j<count($table[$i]);$j++)$color[$i][$j]='';
				for($j=1;$j<count($table[0]);$j++){
					$max=-100000;
					$min= 100000;
					for($i=1;$i<count($table);$i++){
						if($max<$table[$i][$j])$max=$table[$i][$j];
						if($min>$table[$i][$j])$min=$table[$i][$j];
					}
					for($i=1;$i<count($table);$i++){
						$Rx=($Re-$Ri)*($table[$i][$j]/($max-$min))+$Ri;
						$Gx=($Ge-$Gi)*($table[$i][$j]/($max-$min))+$Gi;
						$Bx=($Be-$Bi)*($table[$i][$j]/($max-$min))+$Bi;
						$color[$i][$j]="style=background-color:rgb($Rx,$Gx,$Bx);";
					}
				}
				return $color;
			}
			public static function comparison($old,$new){
				for($i=1;$i<count($old);$i++){
					for($j=1;$j<count($old[$i]);$j++){
						if($old[$i][$j]==0)
							$new[$i][$j]=0;
						else
							$new[$i][$j]=(int)($new[$i][$j]/$old[$i][$j]*100);
					}
				}
				return $new;
			}
		}
		class Create_table{
			public static $mysqli;
			public static $id_counter=0;
			private static function sales_query($start_date,$end_date){
				$query="select new_essential.space_name,
    					sum(case when new_essential.site_name='Spacee' then service.price else 0 end) as 'spacee',
 						sum(case when new_essential.site_name='Resnavi' then service.price else 0 end) as 'resnavi',
    					sum(case when new_essential.site_name='Spacemarket' then service.price else 0 end) as 'spacemarket' 
						from new_essential join service on new_essential.booking_no=service.booking_no
						where service.start_date between '$start_date' and '$end_date' group by new_essential.space_name;";
				return $query;
			}
			private static function utilizations_query($start_date,$end_date){
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
						where service.start_date between '$start_date' and '$end_date') as new group by space_name;";
				return $query;
			}
			public static function table($id,$start_date=null,$end_date=null,$information,$query_function){
				if(is_null($end_date)){
					$start_date=$_POST['start_date'];
					$end_date=$_POST['end_date'];
				}
				$table_obj=new Table();
				$query=$query_function($start_date,$end_date);
				$res=Create_table::$mysqli->query($query);
				$table=Table::to_table($res);
				if($information){
					$start_date2;$end_date2;
					if(!is_null($_POST['start_date2'])){
						$start_date2=$_POST['start_date2'];
						$end_date2=$_POST['end_date2'];
					}else{
						$start_date2=date('Y-m-d',strtotime($start_date."-1 month"));
						$end_date2=date('Y-m-d',strtotime($end_date."-1 month"));
					}$query=$query_function($start_date2,$end_date2);
					$res=Create_table::$mysqli->query($query);
					$table2=Table::to_table($res);
					$table=Table::comparison($table2,$table);
				}$table_obj->start_date=$start_date;
				$table_obj->end_date=$end_date;
				$table_obj->information=$information;
				if($_POST['heatmap']=='all')
					$color=Table::heatmap_all($table);
				else if($_POST['heatmap']=='row')
					$color=Table::heatmap_row($table);
				else if($_POST['heatmap']=='column')
					$color=Table::heatmap_column($table);
				$table_obj->html_table($id,$table,$color);
				return $table_obj;
			}
/*
			public static function sales($id,$start_date=null,$end_date=null,$information){
				if(is_null($end_date)){
					$start_date=$_POST['start_date'];
					$end_date=$_POST['end_date'];
				}
				$table_obj=new Table();
				$query=Create_table::sales_query($start_date,$end_date);
				$res=Create_table::$mysqli->query($query);
				$table=Table::to_table($res);
				if($information){
					$start_date2;$end_date2;
					if(!is_null($_POST['start_date2'])){
						$start_date2=$_POST['start_date2'];
						$end_date2=$_POST['end_date2'];
					}else{
						$start_date2=date('Y-m-d',strtotime($start_date."-1 month"));
						$end_date2=date('Y-m-d',strtotime($end_date."-1 month"));
					}
					$query=Create_table::sales_query($start_date2,$end_date2);
					$res=Create_table::$mysqli->query($query);
					$table2=Table::to_table($res);
					$table=Table::comparison($table2,$table);
				}
				$table_obj->start_date=$start_date;
				$table_obj->end_date=$end_date;
				$table_obj->information=$information;
				if($_POST['heatmap']=='all')
					$color=Table::heatmap_all($table);
				else if($_POST['heatmap']=='row')
					$color=Table::heatmap_row($table);
				else if($_POST['heatmap']=='column')
					$color=Table::heatmap_column($table);
				$table_obj->html_table($id,$table,$color);
				return $table_obj;
			}
			public static function utilizations($id,$start_date=null,$end_date=null,$information){
				if(is_null($end_date)){
					$start_date=$_POST['start_date'];
					$end_date=$_POST['end_date'];
				}
				$table_obj=new Table();
				$query=Create_table::utilizations_query($start_date,$end_date);
				$res=Create_table::$mysqli->query($query);
				$table=Table::to_table($res);
				if($information){
					$start_date2;$end_date2;
					if(!is_null($_POST['start_date2'])){
						$start_date2=$_POST['start_date2'];
						$end_date2  =$_POST['end_date2'];
					}else{
						$start_date2=date('Y-m-d',strtotime($start_date."-1 month"));
						$end_date2=date('Y-m-d',strtotime($end_date."-1 month"));
					}
					$query=Create_table::utilizations_query($start_date2,$end_date2);
					$res=Create_table::$mysqli->query($query);
					$table2=Table::to_table($res);
					$table=Table::comparison($table2,$table);
				}
				if($_POST['heatmap']=='all')
					$color=Table::heatmap_all($table);
				else if($_POST['heatmap']=='row')
					$color=Table::heatmap_row($table);
				else if($_POST['heatmap']=='column')
					$color=Table::heatmap_column($table);
				$table_obj->start_date=$start_date;
				$table_obj->end_date=$end_date;
				$table_obj->information=$information;
				$table_obj->html_table($id,$table,$color);
				return $table_obj;
			}
*/
		}
		$mysqli=new mysqli("localhost","root","pass","SAR");
		Create_table::$mysqli=$mysqli;
		if(isset($_POST['update'])){
			if($_POST['table_type']=='Sales'){
				$_SESSION['table'][(int)$_POST['id']]=
				Create_table::table((int)$_POST['id'],null,null,(int)$_POST['comparison_flag'],Create_table::sales_query);
			}else if($_POST['table_type']=='Utilizations'){
				$_SESSION['table'][(int)$_POST['id']]=
				Create_table::table((int)$_POST['id'],null,null,(int)$_POST['comparison_flag'],Create_table::utilizations_query);
			}
		}
		if(isset($_POST['append'])){
			if($_POST['table_type']=='Sales'){
				$_SESSION['table'][$_SESSION['id']]=
				Create_table::table($_SESSION['id'],null,null,null,Create_table::sales_query);
			}
			else if($_POST['table_type']=='Utilizations'){
				$_SESSION['table'][$_SESSION['id']]=
				Create_table::table($_SESSION['id'],null,null,null,Create_table::utilizations_query);
			}
			$_SESSION['id']++;
		}
		if(isset($_POST['delete'])){
			unset($_SESSION['table'][(int)$_POST['id']]);
		}
		if(isset($_POST['comparison'])){
			if($_POST['table_type']=='Sales'){
				$_SESSION['table'][(int)$_POST['id']]=
				Create_table::table((int)$_POST['id'],null,null,!(int)$_POST['comparison_flag'],Create_table::sales_query);
			}else if($_POST['table_type']=='Utilizations'){
				$_SESSION['table'][(int)$_POST['id']]=
				Create_table::table((int)$_POST['id'],null,null,!(int)$_POST['comparison_flag'],Create_table::utilizations_query);
			}
		}
		if(!isset($_SESSION['id'])){
			$_SESSION['id']=0;
			$_SESSION['table'][$_SESSION['id']]=
			Create_table::table($_SESSION['id'],'2019-01-01','2019-030-1',null,Create_table::sales_query);
			$_SESSION['id']++;
			$_SESSION['table'][$_SESSION['id']]=
			Create_table::table($_SESSION['id'],'2019-01-01','2019-030-1',null,Create_table::utilizations_query);
			$_SESSION['id']++;
		}
		ksort($_SESSION['table']);
		foreach($_SESSION['table'] as $table){
			$table->output();
		}
	?>
</body>
</html>
