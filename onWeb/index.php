<html>
<head>
	<link rel=stylesheet type=text/css href=table.css>
	<meta charset=utf-8>
</head>
<body>
	<?php
		//cell coloring bgcolor=*
		class Table{
			public function html_table($input,$color){
				$i=0;
				echo "<input type=date><input type=date><input type=submit>";
				echo "<table border=1>".PHP_EOL;
				foreach((array)$input as $row){
					$j=0;
					echo "<tr>".PHP_EOL;
					foreach($row as $data){
						if($i==0)
							echo "<th>$data</th>".PHP_EOL;
						else
							echo "<td ".$color[$i][$j].">$data</td>".PHP_EOL;
							$j++;
					}
					$i++;
					echo "</tr>".PHP_EOL;
				}
				echo "</table>".PHP_EOL;
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
				$Ri=255;
				$Gi=255;
				$Bi=255;
				$Re=250;
				$Ge=0;
				$Be=0;
				for($i=1;$i<count($table);$i++){
					for($j=1;$j<count($table[0]);$j++){
						if($max<$table[$i][$j])$max=$table[$i][$j];
						if($min>$table[$i][$j])$min=$table[$i][$j];
					}
				}
				$range=$max-$min;
				$color;
				for($i=1;$i<count($table);$i++){
					for($j=1;$j<count($table[$i]);$j++){
						$Rx=($Re-$Ri)*($table[$i][$j]/$range)+$Ri;
						$Gx=($Ge-$Gi)*($table[$i][$j]/$range)+$Gi;
						$Bx=($Be-$Bi)*($table[$i][$J]/$range)+$Bi;
						$color[$i][$j]="style=background-color:rgb($Rx,$Gx,$Bx);";
					}
				}
				return $color;
			}
		}
		$mysqli=new mysqli("localhost","root","pass","SAR");
		$res=$mysqli->query("select space_name,
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
	from tmp group by space_name;");
		$tl=new Table();
		$table=$tl->to_table($res);
		$color=$tl->heatmap_all($table);
		$tl->html_table($table,$color);
	?>
</body>
</html>
