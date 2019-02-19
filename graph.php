<?php
	require_once '/mnt/c/Users/toron/Desktop/mingw/app/CloudWorks/SAR/Graphs/jpgraph-4.2.6/src/jpgraph.php';
	require_once '/mnt/c/Users/toron/Desktop/mingw/app/CloudWorks/SAR/Graphs/jpgraph-4.2.6/src/jpgraph_bar.php';
	$data= array(
		'data' => array(
    		array(151, 170, 140, 116, 157),
   		 	array(161, 147, 182, 105, 140),
   		 	array(115, 110, 90, 93, 88),
 		 ),
	 	 'legends' => array('a', 'b', 'c'),
	 	 'colors' => array('red@0.8', 'green@0.8', 'blue@0.8'),
	);
	for($i=0;$i<count($data['data']);$i++){
		$bar[]=new BarPlot($data['data']);
		$bar[$i]->setLegend($data['legends'][$i]);
		$bar[$i]->setFillColor($data['colors'][$i]);
	}
	$group=new GroupBarPlot($bar);
	$board=new Graph(400,400);
	$board->setScale('textlin');
	$board->add($group);
	$board->stroke();
	#url=https://www.buildinsider.net/web/bookphplib100/025
?>
