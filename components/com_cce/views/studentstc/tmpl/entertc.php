<?php



        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid = JRequest::getVar('Itemid');
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
    include_once (JPATH_ROOT.DS.'components'.DS.'com_cce'.DS.'views'.DS.'includecss.php');
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

   	$model = & $this->getModel('cce');
	$model->getSchoolInfo($schoolrec);

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

   	$atItemid = $model->getMenuItemid('master','Academic Terms');
   	if($atItemid) ;
   	else{
        	$atItemid = $model->getMenuItemid('topmenu','Manage School');
   	}
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$busroutelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=transport&Itemid='.$masterItemid);
		$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=vehicledetails&view=vehicledetails&layout=default&Itemid='.$masterItemid);
		$settings= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&layout=transportsettings&task=display&Itemid='.$atItemid);
	$driver= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=vehicledetails&view=vehicledetails&layout=default&task=display&Itemid='.$atItemid);


  	$atlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=terms&view=terms&task=display&Itemid='.$atItemid);


?>
<?php
        $isModal = JRequest::getVar( 'print' ) == 1; // 'print=1' will only be present in the url of the modal window, not in the presentation of the page
        if( $isModal) {
                $href = '"#" onclick="window.print(); return false;"';
        } else {
                $href = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
                $href = "window.open(this.href,'win2','".$href."'); return false;";
                $href = '"index.php?option=com_cce&view=studentstc&controller=studentstc&layout=printtc&task=display&sid='.$this->student->id.'&tmpl=component&print=1" '.$href;
        }
?>



<?php 
	
	$countryname=$model->getCountryName($this->student->country);
	$nationality=$model->getCountryName($this->student->nationality);

?>	
<center>
  <div style="width:740px;" class="studenttc">
<center>
  <h4>EDUCATION DEPARTMENT </h4>
  <h1>TRANSFER CERTIFICATE</h1>
  <h6>(FOR PRIMARY/HIGHER/SECONDARY/MULTI PURPOSE SCHOOLS)</h6>
</center>
<br />
      <div style="width:740px;">
      <div style="float:left;">Edn : 80</div>
  	<div style="float:right;">No: .................................</div>
    </div>
    <table>
      <tr>
        <td><strong>1. Name of the School</strong></td>
        <td><center>
            <h3><?php echo $schoolrec->schoolname; ?></h3>
            <?php echo $schoolrec->schooladdress; ?>
          </center></td>
      </tr>
      <tr>
        <td><strong>2. Admission No.</strong></td>
        <td><?php echo $this->student->ano; ?></td>
      </tr>
      <tr>
        <td><strong>3. Name of the pupil in full</strong></td>
        <td><?php echo $this->student->firstname.$this->student->lastname; ?></td>
      </tr>
      <tr>
        <td><span style="float:left;"><strong>4. Sex </strong></span> : <?php echo $this->student->gender; ?><span style="margin-left:40px;"> <strong>5. Nationality</strong> : <?php echo $nationality; ?></span></td>
        <td><span style="float:left;"><strong>6. Religion</strong></span> : <?php echo $this->student->religion; ?> <span style="margin-left:40px;"> <strong>7. Caste</strong> : <?php echo $this->student->caste; ?></span></td>
      </tr>
      <tr>
        <td><strong>8. Name of the father</strong></td>
        <td><?php echo $this->student->pfathername; ?></td>
      </tr>
      <tr>
        <td>9. Whether candidate belongs to 
        <div class="controls">
								  <label class="radio">
									<input type="radio" name="shedule" id="optionsRadios1" value="Shedule Caste" checked="">
									Shedule Caste
								  </label>
								  <div style="clear:both"></div>
								  <label class="radio">
									<input type="radio" name="shedule" id="optionsRadios2" value="Shedule Tribe">
									Shedule Tribe
									</label>
		</div>
         </td>
        <td>10. Whether qualified for promotion to a higher standard 
        <div class="controls">
								  <label class="radio">
									<input type="radio" name="promotion" id="optionsRadios1" value="Yes">
									Yes
								  </label>
								  <div style="clear:both"></div>
								  <label class="radio">
									<input type="radio" name="promotion" id="optionsRadios2" value="No">
									No
									</label>
		</div>
        </td>
      </tr>
      <tr>
        <td><strong>11. Date of birth(in figures and words)</strong></td>
        <td><?php echo $this->student->dob; ?></td>
      </tr>
      <tr>
        <td><span style="float:left;"><strong>12. Place of Birth</strong><?php echo $this->student->birthplace; ?></span></td>
        <td>13. Standard in which the pupil was reading at the time of leaving the school(in words)
        <br>
			<input type="text" value="" name="standard">
        </td>
      </tr>
      <tr>
        <td>14. In the case of pupil of Higher Standards <br>
          </span><span style="float:left"> <strong>Languages Studied </strong><select name="Language">
          <option value="1">English</option>
          <option value="2">Kanada</option>
          <option value="3">Hindi</option>
          <option value="4">Tamil</option>
          </select> </span></td>
        <td>19. Scholarship if any (nature and period to be specified) 
        <br><Br>
            <input type="text" value="" name="scholarship">
        </td>
      </tr>
      <tr>
        <td>15. Medium of Instruction
           <select name="Language">
          <option value="1">English</option>
          <option value="2">Kanada</option>
          <option value="3">Hindi</option>
          <option value="4">Tamil</option>
          </select> 
        
        </td>
        <td>20. Whether medically examined or not
        
         <div class="controls">
								  <label class="radio">
									<input type="radio" name="medical" id="optionsRadios1" value="Yes">
									Yes
								  </label>
								  <div style="clear:both"></div>
								  <label class="radio">
									<input type="radio" name="medical" id="optionsRadios2" value="No">
									No
									</label>
		</div>
        </td>
      </tr>
      <tr>
        <td>16. Date of Admission or Promotion to the class or standard : <strong><?php echo $this->student->adate; ?></strong></td>
        <td>21. Date of pupil's last attendance at the school
         <div class="controls">
								<input type="text" class="input-xlarge datepicker" id="date01" name="lastattend" value="">
		 </div>
        </td>
      </tr>
      <tr>
        <td>17. Whether the pupil has paid all the fees due to the School</td>
        <td rowspan="2">22. Date on which the application for the Transfer Certificate was received  
        <div class="controls">
								<input type="text" class="input-xlarge datepicker" id="date02" name="dateofreceived" value="">
		 </div></td>
      </tr>
      <tr>
        <td>18. Fee concessions, if any (nature and period to be specified)</td>
      </tr>
      <tr>
        <td>23. Date of issue of the Transfer Certificate
         <div class="controls">
								<input type="text" class="input-xlarge datepicker" id="date03" name="issuedate" value="">
		 </div>
        
        </td>
        <td>24. Number of school days upto the date of leaving
           <input type="text" value="" name="numberofdays">
        </td>
      </tr>
      <tr>
        <td>25. Number of school days the pupil attended
           <input type="text" value="" name="attended">
        </td>
        <td>26. Character and conduct
          <select name="character">
		 <option value="" selected="selected">Please select any Character</option>
          <option value="1">Very Good</option>
          <option value="2">Good</option>
          <option value="3">Poor</option>
          <option value="4">Very Poor</option>
          </select> 
        </td>
      </tr>
    </table>
    <br />
    <br />
    <br />
    <h4 align="right">Signature of the Head of the Institution</h4>
    <br />
    <br />
  </div>
</center>
<br />
<form action="index.php" method="POST" name="addform" id="addform" onSubmit="return stest()">
  <table>
  </table>
  <input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
  <input type="hidden" id="id" name="id" value="<?php echo $this->rec->id; ?>" />
  <input type="hidden" id="aid" name="aid" value="<?php echo $this->rec->aid; ?>" />
  <input type="hidden" id="view" name="view" value="vehicledetails" />
  <input type="hidden" id="controller" name="controller" value="vehicledetails" />
  <input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
  <input type="hidden" name="task" id="task" value="save" />
  <input type="hidden" name="layout" id="layout" value="addvehicle" />
</form>

<?php
 include_once (JPATH_ROOT.DS.'components'.DS.'com_cce'.DS.'views'.DS.'includejs.php');
?>
