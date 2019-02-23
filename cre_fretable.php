<?php
	function bookwrite(&$booking_no){
		$filename="final_booking_no.txt";
		if($fp=fopen($filename,"w")){
			fwrite($fp,$booking_no);
			fclose($fp);
		}
		else{
			echo "Error: not file open ".$filename.PHP_EOL;
			exit();
		}
	}
	function bookread(&$booking_no){
		$filename="final_booking_no.txt";
		if($fp=fopen($filename,"r")){
			$booking_no=fgets($fp);
			//echo $booking_no.PHP_EOL;
			fclose($fp);
		}
		else{
			echo "Error: not file open ".$filename.PHP_EOL;
			exit();
		}
	}

	$mysqli = new mysqli("localhost","root","pass","SAR");
	if($mysqli->connect_error){
		echo $mysqli->connect_error.PHP_EOL;
		exit();
	}
	$sql="select booking_no,space_name from new_essential order by booking_no;";
	if($result=$mysqli->query($sql)){
			$booking_no=0;
			bookread($booking_no);
			while($row=$result->fetch_assoc()){
				if($booking_no<$row["booking_no"]){
					$space=$row["space_name"];
					$booking_no=$row["booking_no"];
					//echo $booking_no."\t".$space.PHP_EOL;

					$sql="select booking_no,start_date,end_date from service where booking_no=$booking_no;";
					if($result2=$mysqli->query($sql)){
						while($data=$result2->fetch_assoc()){
							$s_date=new DateTime($data["start_date"]);
							$e_date=new DateTime($data["end_date"]);
							
							$year=$s_date->format("Y");
							$month=$s_date->format("m");
							$f_time=$s_date->format("H:i:s");
							$e_time=$e_date->format("H:i:s");
							
							if($e_time<$f_time)$e_date->add(new DateInterval('P1D'));
							$t_diff=$s_date->diff($e_date);
							$t_diff=$t_diff->format("%H:%I:%S");
/*
							echo "YEAR:\t".$year.PHP_EOL;
							echo "MONTH:\t".$month.PHP_EOL;
							echo "first_time:\t".$f_time.PHP_EOL;
							echo "end_time:\t".$e_time.PHP_EOL;
							echo "DIFF:\t".$t_diff.PHP_EOL;
*/
						}
					}
					else{
						echo "Error:".$sql.PHP_EOL;
						exit();
					}
					$sql="select space_name,year,month,use_totaltime from frequency where space_name='$space' AND year=$year AND month=$month;";
					if($result3=$mysqli->query($sql)){
						$num_row=$result3->num_rows;
						//echo $num_row.PHP_EOL;
						if($num_row == 0){
							$sql="insert into frequency values ('$space',$year,$month,'$t_diff');";
							if($mysqli->query($sql));
							else{
								echo "Error:".$sql.PHP_EOL;
								exit();
							}
						}
						else{
							while($data=$result3->fetch_assoc()){
								$d_totaltime=$data["use_totaltime"];
								//echo $d_totaltime."\t".$t_diff.PHP_EOL;
								$sql="select addtime('$d_totaltime','$t_diff');";
								if($result4=$mysqli->query($sql)){
									while($data2=$result4->fetch_assoc()){
										//print_r($data2);
										//var_dump($data2);
										//echo $data2["addtime('$d_totaltime','$t_diff')"].PHP_EOL;
										$totaltime=$data2["addtime('$d_totaltime','$t_diff')"];
									}
								}
								else{
									echo "Error:".$sql.PHP_EOL;
									exit();
								}
								$sql="update frequency set use_totaltime='$totaltime' where space_name='$space' AND year=$year;";
								if($result5=$mysqli->query($sql));
								else{
									echo "Error:".$sql.PHP_EOL;
									exit();
								}
							}
						}
						bookwrite($booking_no);
					}
					else{
						echo "Error:".$sql.PHP_EOL;
						exit();
					}
				}
			}
			$result->close();
	}
	else{
		echo "Error:".$sql.PHP_EOL;
		exit();
	}
	$mysqli->close();
?>
