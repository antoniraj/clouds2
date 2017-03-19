<?php
	include_once('dbfunctions.php');
        include "./libchart/classes/libchart.php";
$app = JFactory::getApplication();
$prefix = $app->getCfg('dbprefix');
        $chart2 = new VerticalBarChart(900,300);
        $serie1 = new XYDataSet();
	$db =& JFactory::getDBO();
        $query = 'SELECT classid, count(*) as students FROM '.$prefix.'studentclass where classid IN (SELECT id FROM '.$prefix.'courses WHERE aid IN (SELECT id FROM '.$prefix.'academicyears WHERE status=\'Y\')) GROUP BY classid';
        $db->setQuery( $query );
        $recs = $db->loadObjectList();
	foreach($recs as $rec){
		getCourse($rec->classid,$rrec);
		$serie1->addPoint(new Point($rrec->code,$rec->students));

	}	
        $dataSet2 = new XYSeriesDataSet();
        $dataSet2->addSerie("Classes", $serie1);
        $chart2->setDataSet($dataSet2);
        $chart2->getPlot()->setGraphCaptionRatio(0.65);
        $chart2->setTitle("Students Admission Report");
        $chart2->render("images/general/admission.png");
	//echo '<img alt="Report on Students Count" src="./images/general/admission.png" style="border: 1px solid gray;"';
?>

	
