<!DOCTYPE html>
<head>
	<meta charset=utf8>
</head>
<body>
<?php
	$mysqli=new mysqli("localhost","root","pass","SAR");
	$query="select t.id,t.name,tags.tag from (select tag_map.*,spaces.name from tag_map join spaces on tag_map.space_id=spaces.id) as t join tags on t.tag_id=tags.id;";
	$res=$mysqli->query($query);
	$tag_list;
	foreach($res as $t){
		if(is_null($tag_list[$t['name']]))
			$tag_list[$t['name']]=array();
		$tag_list[$t['name']]+=[[$t['tag'],$t['id']]];
	}
	$code='<table border=1>'.PHP_EOL;
	foreach(array_keys($tag_list) as $key){
		$code.='<tr>'.PHP_EOL;
		$code.="<th>$key</th>";
		foreach($tag_list[$key] as $tag){
			$code.="<td>$tag[0]</td>".PHP_EOL;
		}
		$code.='</tr>'.PHP_EOL;
	}
	echo $code;
?>
</body>
</html>
