<script type="text/javascript">
function check()
{
     var checkboxes = document.getElementsByTagName('input'), val = null;    
     for (var i = 0; i < checkboxes.length; i++)
     {
         if (checkboxes[i].type == 'checkbox')
         {
             if (val === null) val = checkboxes[i].checked;
             checkboxes[i].checked = val;
         }
     }
 }
</script>
<?php
        defined('_JEXEC') or die('Denied..');
	$app = JFactory::getApplication();
	$iconsdir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid  = JRequest::getVar('Itemid');
	$iconsDir1 = JURI::base() . 'components/com_cce/images';
	     $library1 = JURI::base() . 'components/com_cce/images/library/';
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');

   	$model = & $this->getModel('cce');

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

   	$ayItemid = $model->getMenuItemid('master','Academic Years');
   	if($ayItemid) ;
   	else{
        	$ayItemid = $model->getMenuItemid('manageschool','Home');
   	}
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$library= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=library&Itemid='.$masterItemid);
 	$managebooks= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=library&view=library&task=display&layout=managebooks&Itemid='.$masterItemid);

  	$aylink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=academicyears&view=academicyears&task=display&Itemid='.$ayItemid);


?>
<!--
TOP LINKS....DASHBOARD
-->
<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="right">
  <div style="float:left;">
           <img src="<?php echo $library1.'/addbook.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <h2></h2>
                <h2></h2>
                <h2></h2>
                <h1 class="item-page-title"> Add Book details </h1>
        </div>

                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 28px; height: 28px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $library; ?>"><img src="<?php echo $iconsDir1.'/1library.png'; ?>" alt="Master" style="width: 30px; height: 30px;" /></a><br />
			</div>
			<div style="float:right; width:10px;"> &nbsp;</div>
			<div style="float:right;">
                        <a href="<?php echo $managebooks; ?>"><img src="<?php echo $library1.'/addbook.png'; ?>" alt="Master" style="width: 28px; height: 28px;" /></a><br />
			</div>
			
                </td>
        </tr>
</table>


			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> <strong>Add Book details</strong></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
							<form action="index.php" class="form-horizontal" method="POST" name="addform" id="addform" onSubmit="return stest()">
					
							<fieldset>
								<div class="control-group">
								<label class="control-label" for="focusedInput">Book Number </label>
								<div class="controls">
								  <input class="focused" id="focusedInput" type="text" required="required" name="bookno" value="<?php echo $this->rec->bookno; ?>">
								</div>
							  </div>
						
							  <div class="control-group">
								<label class="control-label" for="focusedInput">ISBN </label>
								<div class="controls">
								  <input class="focused" id="focusedInput" type="text" required="required" name="isbn" value="<?php echo $this->rec->isbn; ?>">
								</div>
							  </div>
							   <div class="control-group">
								<label class="control-label" for="focusedInput">Title</label>
								<div class="controls">
								  <input class="focused" id="focusedInput" type="text" name="title" required="required" value="<?php echo $this->rec->title; ?>">
								</div>
							  </div>
			
						 
							
							  <div class="control-group">
								<label class="control-label" for="selectError3">Category</label>
								<div class="controls">
								  <select name="catid" id="selectError" data-rel="chosen">
                                    <option value="0">Please Select Option</option>
                                    <?php
                                   foreach($this->category as $cat) :
										echo "<option value=\"".$cat->id."\" ".($cat->id == $this->rec->catid ? "selected=\"yes\"" : "").">".$cat->categoryname."</option>";
									endforeach;
									?>
                               </select>
								</div>
							  </div>
							
							  
							 <div class="control-group">
								<label class="control-label" for="focusedInput">Author</label>
								<div class="controls">
								  <input class="focused" id="focusedInput" type="text" name="author" value="<?php echo $this->rec->author; ?>">
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Edition</label>
								<div class="controls">
								  <input class="focused" id="focusedInput" type="text" name="edition" value="<?php echo $this->rec->edition; ?>">
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Publisher</label>
								<div class="controls">
								  <input class="focused" id="focusedInput" type="text" name="publisher" value="<?php echo $this->rec->publisher; ?>">
								</div>
							  </div>
						   <div class="control-group">
								<label class="control-label" for="focusedInput">Book Position</label>
								<div class="controls">
								  <input class="focused" id="focusedInput" type="text" name="bookpos" value="<?php echo $this->rec->bookpos; ?>">
								</div>
							  </div>
							   <div class="control-group">
								<label class="control-label" for="focusedInput">Shelf No</label>
								<div class="controls">
								  <input class="focused" id="focusedInput" type="text" name="shelfno" value="<?php echo $this->rec->shelfno; ?>">
								</div>
								
								

							  <div class="form-actions">
								<button type="submit" class="btn btn-small btn-success" name="Save" Value="Save">Save</button>
								<button type="submit" class="btn btn-small btn-info" name="Copy" Value="Copy">Save and Copy</button>
							  </div>
							</fieldset>
							<input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
							<input type="hidden" id="id" name="id" value="<?php echo $this->rec->id; ?>" />
							<input type="hidden" id="cid" name="cid" value="<?php echo $this->rec->aid; ?>" />
							<input type="hidden" id="view" name="view" value="librarymanagebooks" />
							<input type="hidden" id="controller" name="controller" value="librarymanagebooks" />
							<input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
							<input type="hidden" name="task" id="task" value="save" />
							<input type="hidden" name="layout" id="layout" value="addbook" />	
													
						  </form>
					
					</div>
				</div><!--/span-->
			
			</div><!--/row-->
			

