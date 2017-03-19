<?php
	include_once('dbfunctions.php');
        include "./libchart/classes/libchart.php";

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
	$cb[0] = new XYDataSet();
	$j=1;
	foreach($weeks as $week){
	  $t=0;
	  foreach($crecs as $crec){
		getClassWeeklyAbsentees($crec->id,$week['from'],$week['to'],$rec);
		$t=$t+$rec->total;
	  }
          $cb[0]->addPoint(new Point("W".$j, $t));
	  $j++;
	}	
        $dataSet3 = new XYSeriesDataSet();
        $dataSet3->addSerie('Absentees', $cb[0]);
		
        $chart3->setDataSet($dataSet3);

        $chart3->setTitle("Overall Attendance Report");
        $chart3->getPlot()->setGraphCaptionRatio(0.62);
        $chart3->render("images/attendance/classwiseattendanceoverall.png");
	echo '<img alt="attendance" src="./images/attendance/classwiseattendanceoverall.png" style="border: 1px solid gray;"';
?>


