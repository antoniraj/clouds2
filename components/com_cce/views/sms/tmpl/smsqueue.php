<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid = JRequest::getVar('Itemid');
	$category= JRequest::getVar('category');
        JHtml::stylesheet('styles.css','./components/com_cce/css/');
        JHTML::script('academicyear.js', 'components/com_cce/js/');
        JHTML::script('validate.js', 'components/com_cce/js/');


   	$testsmsfile = JPATH_COMPONENT.DS.'smstemp'.DS.'smsfile.txt';
        $testsmsno = file_get_contents($testsmsfile);


        $model = & $this->getModel();
        $iconsDir1 = JURI::base() . 'components/com_cce/images';
        $dashboardItemid = $model->getMenuItemid('manageschool','Dash Board');
        if($dashboardItemid) ;
        else{
                $dashboardItemid = $model->getMenuItemid('topmenu','Manage School');
        }
        $masterItemid = $model->getMenuItemid('manageschool','Master');
        if($masterItemid) ;
        else{
                $masterItemid = $model->getMenuItemid('topmenu','Manage School');
        }
        $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
        $modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=sms&Itemid='.$masterItemid);
	$app =& JFactory::getApplication();
        $pathway =& $app->getPathway(); 
        $pathway->addItem('Home', $dashboardlink);
 //       $pathway->addItem('SMS',$modulelink);
        $pathway->addItem('SMS QUEUE');



?>

<b style="font: bold 15px Georgia, serif;">SMS MODULE</b>

<?php
        $this->showlinks();
?>


<style>
#theimage1 { visibility: hidden; }
</style>



<div class="pull-right">
<form action="index.php" method="post" name="testform1" >
<br />
Test Mobile:<input type="text" style="width:100px;" value="<?php echo $testsmsno; ?>" name="testsmsno" maxlength="10" /> <input type="submit" class="btn btn-small btn-warning" name="save" value="Save"  />
<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
<input type="hidden" id="view" name="view" value="sms" />
<input type="hidden" id="layout" name="layout" value="smsqueue" />
<input type="hidden" id="controller" name="controller" value="sms" />
<input type="hidden" name="task" id="task" value="savetestmobile" />
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
</form>
</div>


<form action="index.php" method="POST" name="addform" id="addform">
	<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i>SMS  QUEUE</h2>
						<div class="box-icon">
<button class="btn btn-small btn-danger" name="submit"  onclick="tend1()" value="Send"><i class="icon icon-color icon-envelope-closed icon-white"></i>  Send</button>

						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th  class="sorting_disabled"><input type="checkbox" value="" onchange="check()" name="chk[]"></th>
								  <th>S#</th>
								  <th>Date</th>
								  <th>Time</th>
								  <th>SMS Text
<img id="theimage1" src="<?php echo $iconsDir.'/loading25.gif'; ?>" style="width: 50px; height: 50px;" >
</th>

                                  <th>SMS Count</th>
                                  <th>Sent By</th>
                                  <th>Sent To</th>
                                  <th>Status</th>				
                           <th>Operation</th>
        <th>Test SMS</th>

                          			  </tr>
						  </thead>   
						  <tbody>
<?php
$logid = JRequest::getVar('logid');
$model = $this->getModel('sms');
$s = $model->getStudentSMSLog($recs);
$i=1;
foreach($recs as $rec) {
	$arr = explode(',',$rec->sids);
	$cc = count($arr);
        echo "<tr>";
        echo "<td>";
        if($rec->status==='A')
                echo "<input type=\"checkbox\"  name=\"cid[]\" value=\"".$rec->id."\" /> ";
        echo "</td><td>".$i++."</td><td>$rec->fsmsdate</td><td>$rec->smstime</td><td>".htmlspecialchars($rec->smstext)."</td><td> <p style=\"font-size:25px; color:red;\">$cc</p></td><td>$rec->sentby</td><td>$rec->sentto</td><td>";
        if($rec->status==='A') //if alreay approved then enable send option
        {
                echo "Ready";
        }
        else if($rec->status==='N')
        {
                echo "Aproval Pending";
        }else{
                echo "Sent";
        }
?>
        </td>
        <td>
<?php
        $clink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&task=deletesms&layout=smsqueue&logid='.$rec->id.'&Itemid='.$Itemid);
        echo '<a class="btn btn-mini btn-danger" href="'.$clink.'"><i class="" icon-white"></i>'.Cancel.'</a>';
        ?>
        </td>
        <td>

<?php
        $testsmslink=JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=sms&view=sms&task=sendtestsms&layout=smsqueue&testsmstext='.$rec->smstext.'&testsmsno='.$testsmsno.'&Itemid='.$Itemid);
        echo '<a class="btn btn-mini btn-info" href="'.$testsmslink.'"><i class="" icon-white"></i>Send Test SMS</a>';
?>
        </td>

        </tr>
<?php

}
?>


                                                         </tbody>
                                          </table>
                                        </div>


                                </div><!--/span-->

                        </div><!--/row-->
                <input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
                <input type="hidden" id="view" name="view" value="sms" />
                <input type="hidden" id="layout" name="layout" value="smsqueue" />
                <input type="hidden" id="controller" name="controller" value="sms" />
                <input type="hidden" name="task" id="task" value="sendstudentsms" />
                <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />

                </form>
                                                                                    
