<?php


	include_once('dbfunctions.php');
        include "./libchart/classes/libchart.php";

	$app = JFactory::getApplication();
	$prefix = $app->getCfg('dbprefix');
        $chart2 = new VerticalBarChart(900,300);
        $serie1 = new XYDataSet();

	$db =& JFactory::getDBO();
	getCourses($crecs);
	foreach($crecs as $crec){
	        $query = 'SELECT count(distinct (studentid)) AS students FROM '.$prefix.'classattendance where cdate=current_date AND classid = '.$crec->id;
        	$db->setQuery( $query );
	        $recs = $db->loadObjectList();
		foreach($recs as $rec){
			$serie1->addPoint(new Point($crec->code,$rec->students));
		}	
	}
        $dataSet2 = new XYSeriesDataSet();
        $dataSet2->addSerie("Classes", $serie1);
        $chart2->setDataSet($dataSet2);
        $chart2->getPlot()->setGraphCaptionRatio(0.65);
        $chart2->setTitle("Absentees(Today)");
        $chart2->render("images/attendance/attendance.png");
	echo '<img alt="attendance" src="./images/attendance/attendance.png" style="border: 1px solid gray;"';
?>
