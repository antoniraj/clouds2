<?php
// No direct access
   defined('_JEXEC') OR DIE('Access denied..');
   $app = JFactory::getApplication();
   $iconsDir = JURI::base() . 'components/com_cce/images/64x64';
   $Itemid = JRequest::getVar('Itemid');
   $model =   & $this->getModel();
   $model->gettodaythoughts($thoughts);
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
        JHTML::script('academicyear.js', 'components/com_cce/js/');
        $iconsDir1 = JURI::base() . 'components/com_cce/images';
        $dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
        $modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=news&Itemid='.$masterItemid);


?>

<!-- TOP LINKS....DASHBOARD -->
<table width="100%" cellpadding="10">
        <tr style="border:none;">
                <td style="border:none;" align="right">
  <div style="float:left;">
           <img src="<?php echo $iconsDir1.'/t_thoughts.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div style="float:left;">
                <h2></h2>
                <h1 class="item-page-title">Thoughts for the day</h1>
        </div>

                       <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 48px; height: 48px;" /></a><br />
                        </div>
                        <div style="float:right; width:10px;"> &nbsp;</div>
                        <div style="float:right;">
                        <a href="<?php echo $modulelink; ?>"><img src="<?php echo $iconsDir1.'/1news.png'; ?>" alt="Bulk SMS" style="width: 48px; height: 48px;" /></a><br />
                        </div>
                </td>
        </tr>
</table>

<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=academicyears&view=academicyears&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
	<div class="row-fluid">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> Thoughts for the day</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered">
						  <thead>
							  <tr>
								  <th width="10%">Days</th>
								  <th width="67%">Thought</th>
								  <th width="13%">Reference</th>
								  <th width="10%">Operation</th>
							  </tr>
						  </thead>   
						  <tbody>
							  <?php
					foreach($thoughts as $rec) {
                        $link2 = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=thoughtsfortheday&controller=news&layout=editthoughts&day='.$rec->day.'&Itemid='.$Itemid.'&cid[]='.$rec->id);
						?>
							  
							<tr>
								<td><?php echo $rec->day; ?></td>
								<td><?php echo $rec->message; ?></td>
								<td><span class="label label-warning"><?php echo $rec->reference; ?></span></td>
								<td class="center">
									<a class="btn btn-info" href="<?php echo $link2; ?>">
										<i class="icon-edit icon-white"></i>  
										Edit                                         
									</a>
						
								</td>
							</tr>
							<?php
								}
							?>
							 </tbody>
					  </table>  

					  				<div class="form-actions">
						<div class="pull-right">	
						</div>
						</div>          
			</div>
              
				</div><!--/span-->
			
			</div><!--/row-->
						
<input type="hidden" name="view" value="academicyears" />
<input type="hidden" name="controller" value="academicyears" />
<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
<input type="hidden" name="task" value="actions"/>
</form>