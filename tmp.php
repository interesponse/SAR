<?php
	require_once 'Database.php';
	$mysqli=new Database();
	$list=$mysqli->mysqli->query("select distinct space_name from essential;");
	$space_list=array();
	foreach($list as $l){
		array_push($space_list,$l['space_name']);
	}
	for($i=0;$i<count($space_list);$i++){
		for($j=0;$j<count($space_list);$j++){
			$percent=0;
			$match=similar_text($space_list[$i],$space_list[$j],$percent);
			echo $space_list[$i]."\n".$space_list[$j]."\n";
			echo $match."\t".$percent."\n\n\n";
		}
	}
?>
