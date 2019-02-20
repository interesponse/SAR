<?php
	function table(&$input){
		$i=0;
		foreach($input as $row){
			$j=0;
			foreach($row as $data){
				//print_r($row);
				if($j<count($row))echo $i.",".$j." :";
				$j++;
				echo $data.PHP_EOL;
			}
			$i++;
		}
	}
	$input=[['Colum1','Colum2','Colum3'],['Line1','Line2','Line3']];
	//print_r($input);
	table($input);
?>
