<?php
	function table(&$input){
		$i=0;
		echo "<table>".PHP_EOL;
		foreach($input as $row){
			$j=0;
			echo "<tr>".PHP_EOL;
			foreach($row as $data){
				echo "<td>".$data."</td>".PHP_EOL;
				$j++;
			}
			$i++;
			echo "</tr>".PHP_EOL;
		}
		echo "</table>".PHP_EOL;
	}
	$input=[['Colum1','Colum2','Colum3'],['Line1','Line2','Line3']];
	//print_r($input);
	table($input);
?>
