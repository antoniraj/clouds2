<?php
	include_once('dbfunctions.php');
        include "./libchart/classes/libchart.php";
	$app = JFactory::getApplication();
	$prefix = $app->getCfg('dbprefix');

        $chart2 = new VerticalBarChart(900,300);
        $serie1 = new XYDataSet();

	$db =& JFactory::getDBO();
        $query = 'SELECT cdate, count(distinct studentid) AS total FROM '.$prefix.'classattendance GROUP BY cdate ORDER BY cdate DESC LIMIT 30';
        $db->setQuery( $query );
        $recs = $db->loadObjectList();
	foreach($recs as $rec){
	//	getCourse($rec->classid,$rrec);
		$serie1->addPoint(new Point($rec->cdate,$rec->total));

	}	
        $dataSet2 = new XYSeriesDataSet();
        $dataSet2->addSerie("Dates", $serie1);
        $chart2->setDataSet($dataSet2);
        $chart2->getPlot()->setGraphCaptionRatio(0.65);
        $chart2->setTitle("Absentees in Last 15 Days");
        $chart2->render("images/attendance/attendance10days.png");
	echo '<img alt="attendance" src="./images/attendance/attendance10days.png" style="border: 1px solid gray;"';
?>

