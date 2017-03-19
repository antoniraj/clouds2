<?php
session_start();
	include_once('dbfunctions.php');
        include "./libchart/classes/libchart.php";

	$rno =  $_REQUEST['user'];
	$course =  $_REQUEST['course'];
	$a = explode(",",$_REQUEST['ids']);

	$pro_data=array(); //Productivity array
	$qua_data=array(); //Quality array
	$locp_data=array(); //LOC Plan
	$loca_data=array(); //LOC Actual
		
        $chart = new LineChart();
        $chart1 = new LineChart();
        $dataSet = new XYDataSet();
        $dataSet1 = new XYDataSet();

        $chart2 = new VerticalBarChart();
        $serie1 = new XYDataSet();
        $serie2 = new XYDataSet();

        $chart3 = new LineChart();

        $serie_plan = new XYDataSet();
        $serie_design = new XYDataSet();
        $serie_code = new XYDataSet();
        $serie_codereivew = new XYDataSet();
        $serie_compile = new XYDataSet();
        $serie_test = new XYDataSet();
        $serie_postmortem = new XYDataSet();


	$i=0;	
	foreach($a as $projectid){
		$status = psp_projectplansummary_get($projectid,$rno,$ppsfobject);
		$n = $i + 1;
		if($status == false){
			break;
		}else{
			$pro_data[$i] = $ppsfobject->sa_locperhour;
			$qua_data[$i] = $ppsfobject->sa_defectsperkloc;
			$locp_data[$i] = $ppsfobject->tp_total;
			$loca_data[$i] = $ppsfobject->ta_total;
			$serie1->addPoint(new Point("Project".$n, $locp_data[$i]));
			$serie2->addPoint(new Point("Project".$n, $loca_data[$i]));
	        	$dataSet->addPoint(new Point("Project".$n, $pro_data[$i]));
        		$dataSet1->addPoint(new Point("Project".$n, $qua_data[$i]));
		}
		$i = $i + 1;
	}
	$j = 0;
	foreach($a as $projectid){
		$status = psp_projectplansummary_get_todate($projectid,$rno,$course,$ppsfobject);
		$n = $j + 1;
		if($status == false) break;
		if($j < $i) {
			$tplan = round($ppsfobject->ta_plan / $ppsfobject->ta_total * 100.0);
			$tdesign = round($ppsfobject->ta_design / $ppsfobject->ta_total * 100.0);
			$tcode= round($ppsfobject->ta_code/ $ppsfobject->ta_total * 100.0);
			$tcodereview = round($ppsfobject->ta_codereview / $ppsfobject->ta_total * 100.0);
			$tcompile = round($ppsfobject->ta_compile / $ppsfobject->ta_total * 100.0);
			$ttest = round($ppsfobject->ta_test / $ppsfobject->ta_total * 100.0);
			$tpostmortem = round($ppsfobject->ta_postmortem / $ppsfobject->ta_total * 100.0);
			$serie_plan->addPoint(new Point("Project".$n, $tplan));
			$serie_design->addPoint(new Point("Project".$n, $tdesign));
			$serie_code->addPoint(new Point("Project".$n, $tcode));
			$serie_compile->addPoint(new Point("Project".$n, $tcompile));
			$serie_test->addPoint(new Point("Project".$n, $ttest));
			$serie_postmortem->addPoint(new Point("Project".$n, $tpostmortem));
			//$serie_creview->addPoint(new Point("Project".$n, $tcodereview));
		}
		$j++;
	}
	$dataSet3 = new XYSeriesDataSet();
        $dataSet3->addSerie("Plan", $serie_plan);
        $dataSet3->addSerie("Design", $serie_design);
        $dataSet3->addSerie("Code", $serie_code);
        $dataSet3->addSerie("Compile", $serie_compile);
        $dataSet3->addSerie("Test", $serie_test);
        $dataSet3->addSerie("Postmortem", $serie_postmortem);
        //$dataSet3->addSerie("CReview", $serie_creivew);
        $chart3->setDataSet($dataSet3);

        $chart3->setTitle("% of Time Spent on each Phase");
        $chart3->getPlot()->setGraphCaptionRatio(0.62);
        $chart3->render("generated/phasetimes" . $_SESSION['username'] . ".png");


        $dataSet2 = new XYSeriesDataSet();
        $dataSet2->addSerie("Plan", $serie1);
        $dataSet2->addSerie("Actual", $serie2);
        $chart2->setDataSet($dataSet2);
        $chart2->getPlot()->setGraphCaptionRatio(0.65);
        $chart2->setTitle("LOC Estimation Accuracy");
        $chart2->render("generated/LOCAcc" . $_SESSION['username'] . ".png");



        $chart->setDataSet($dataSet);
        $chart1->setDataSet($dataSet1);

        $chart->setTitle("Productivity Report(LOC/Hour)");
        $chart->render("generated/productivity" . $_SESSION['username'] . ".png");
        $chart1->setTitle("Quality Report(Defects/KLOC)");
        $chart1->render("generated/quality" . $_SESSION['username'] . ".png");

	

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <title>Libchart line demonstration</title>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<h4><center><table><tr><td>RNO:<?php echo strtoupper($rno); ?></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;COURSE CODE:<?php echo strtoupper($course); ?></td></tr></table></center></h4>
<hr>
<body>
<center><table>
<?php
session_start();
echo "<tr><td><img alt=\"Estimation Accuracy\" src=\"./generated/LOCAcc" . $_SESSION['username'] . ".png\" style=\"border: 1px solid gray;\"/></td></tr>";
echo "<tr><td><img alt=\"Productivity\" src=\"./generated/productivity" . $_SESSION['username'] . ".png\" style=\"border: 1px solid gray;\"/></td></tr>";
echo "<tr><td><img alt=\"Quality\" src=\"./generated/quality" . $_SESSION['username'] . ".png\" style=\"border: 1px solid gray;\"/></td></tr>";
echo "<tr><td><img alt=\"Phase Timings\" src=\"./generated/phasetimes" . $_SESSION['username'] . ".png\" style=\"border: 1px solid gray;\"/></td></tr>";
?>
</table></center>
</body>
</html>

	
