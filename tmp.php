<?php
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
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
=======
	if(true)
=======
>>>>>>> 40b90664fc25f4bb54c3db246d6761f32fb64ffb
		$a=20;
	echo $a;
>>>>>>> 003e7a831bfa31f2a0459a2f7c253dc6a8fde1d8
=======
	function a(){
		echo date('Y-m-d');
	}
	$b=a;
	$b();
>>>>>>> 464447d0d8db9e05d0712ce09cb91ba163de81fe
?>
