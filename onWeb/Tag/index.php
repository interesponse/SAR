<!DOCTYPE html>
<head>
	<meta charset=utf8>
	<style>
		button{
			background-color:transparent;
			border:none;
			cursor:pointer;
			padding:0;
			outline:none;
			appearance:none;
			color:#ffffff;
			font-size:110%;
		}
		#tag{
			border:1px dashed #333333;
			border-radius:5px;
			background-color:#009999;
			color:#ffffff;
		}
		ul{
			width:100%;
			background-color:#66cdaa;
		}
		li{
			display:inline;
			width:40%;
		}
		#hiddens{
			display:none;
		}
		.above{
			transition:3s;
		}
		.above:hover #hiddens{
			transition:3s;
			display:inline;
			background-color:#000000;
			color:#ffffff;
		}
	</style>
</head>
<body>
<ul>
	<li><a href='/CW/main.php'>HOME</a></li>
	<li><a href='/CW/Tag/index.php'>Tag</a></li>
</ul>
<?php
	$mysqli=new mysqli("localhost","root","pass","SAR");
	function once(){
			global $mysqli;
			$query="select t.id,t.name,tags.tag,t.space_id from (select tag_map.*,spaces.name from tag_map join spaces on tag_map.space_id=spaces.id) as t join tags on t.tag_id=tags.id;";
			$res=$mysqli->query($query);
			$tag_list;
			foreach($res as $t){
				if(is_null($tag_list[$t['name']]))
					$tag_list[$t['name']]=array();
				$tag_list[$t['name']][]=[$t['tag'],$t['id'],$t['space_id']];
			}
			$code='<table border=1>'.PHP_EOL;
			foreach(array_keys($tag_list) as $key){
				$code.='<tr>'.PHP_EOL;
				$code.="<th>$key</th>";
				foreach($tag_list[$key] as $tag){
					$code.="<td id=tag>".PHP_EOL;
					$code.="<form action=index.php method=POST>".PHP_EOL;
					$code.="<input type=hidden name=tag_map_id value=$tag[1] />".PHP_EOL;
					$code.="<button id=delete name=delete style='display:inline'>&#x2716;</button>".PHP_EOL;
					$code.="$tag[0]</form></td>".PHP_EOL;
				}
				$code.="<td id=tag>".PHP_EOL;
				$code.="<div class=above>".PHP_EOL;
				$code.="<form action=index.php method=POST>".PHP_EOL;
				$code.="<input type=text id=hiddens name=tag_name>".PHP_EOL;
				$code.="<input type=submit id=hiddens name=tag_add>".PHP_EOL;
				$code.="<input type=hidden name=space_id value=$tag[2]>".PHP_EOL;
				$code.="&#43;".PHP_EOL;
				$code.="</form>".PHP_EOL;
				$code.="</div>".PHP_EOL;
				$code.="</td>".PHP_EOL;
				$code.='</tr>'.PHP_EOL;
			}
			echo $code;
	}
	if(isset($_POST['delete'])){
		$query='delete from tag_map where id='.$_POST['tag_map_id'].';';
		$mysqli->query($query);
	}
	if(isset($_POST['tag_add'])){
		$query="insert into tags (tag) values('".$_POST['tag_name']."');";
		$mysqli->query($query);
		$id=$mysqli->insert_id;
		$query="insert into tag_map(space_id,tag_id) values(".$_POST['space_id'].",".$id.");";
		$mysqli->query($query);
	}
	once();
?>
</body>
</html>

