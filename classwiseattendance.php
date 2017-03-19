<?php
	include_once('dbfunctions.php');
        include "./libchart/classes/libchart.php";
//	$app = JFactory::getApplication();
//	$prefix = $app->getCfg('dbprefix');
//	echo $prefix;

        $chart3 = new LineChart(900,350);

	getCourses($crecs);

	//Workout the weeks from and to for each weak
	getDates($dates);
	$weeks = array();
	$nweeks = count($dates)/6;
	$i=0;
	$j=0;
	$n = count($dates);
	while($i<($n-1)){
		$weeks[$j]['from']=$dates[$i]->cdate;
		$i = $i + 6;
		if(($i-1)<$n) 
			$weeks[$j]['to'] = $dates[$i-1]->cdate;
		else
			$weeks[$j]['to'] = $dates[$n-1]->cdate;	
		$j++;
	}
	//Create Dataset for each class
	$i=0;
	while($i<count($crecs)){	
	        $cb[$i] = new XYDataSet();
		$i++;
	}
	
	$j=1;
	foreach($weeks as $week){
	  $i=0;
	  foreach($crecs as $crec){
		getClassWeeklyAbsentees($crec->id,$week['from'],$week['to'],$rec);
	//	echo "Classid=".$crec->id."--".$week['from']."--".$week['to']."-->".$rec->total."<br />";
		//print_r($rec);
		//
		//
                $cb[$i]->addPoint(new Point("W".$j, $rec->total));
		$i++;
	  }
	  $j++;
	  //echo "------------------------------<br />";
	}	
        $dataSet3 = new XYSeriesDataSet();
        $i=0;
	foreach($crecs as $crec){	
        	$dataSet3->addSerie($crec->code, $cb[$i]);
		$i++;
	}
		
        $chart3->setDataSet($dataSet3);

        $chart3->setTitle("Classwise Attendance Report");
        $chart3->getPlot()->setGraphCaptionRatio(0.62);
        $chart3->render("images/attendance/classwiseattendance.png");
	echo '<img alt="attendance" src="./images/attendance/classwiseattendance.png" style="border: 1px solid gray;"';
?>


