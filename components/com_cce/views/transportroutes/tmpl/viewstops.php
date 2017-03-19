<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid = JRequest::getVar('Itemid');
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHTML::script('academicyear.js', 'components/com_cce/js/');
	JHTML::script('jquery.js', 'components/com_cce/js/');
	
	$iconsDir1 = JURI::base() . 'components/com_cce/images';

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

   	$atItemid = $model->getMenuItemid('master','Academic Terms');
   	if($atItemid) ;
   	else{
        	$atItemid = $model->getMenuItemid('topmenu','Manage School');
   	}
   	$dashboardlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=dashboard&Itemid='.$dashboardItemid);
   	$busroutelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=transport&Itemid='.$masterItemid);
		
		 	$modulelink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=master&view=master&task=display&layout=setroute&Itemid='.$atItemid);
             $transport= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=transportroutes&view=transportroutes&layout=default&task=display&Itemid='.$atItemid);

 
  	$atlink= JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=terms&view=terms&task=display&Itemid='.$atItemid);

?>
<script language="javascript">
  	jQuery(function($){
    var $button = $('#addTableRow'),
        $row = $('#mans').clone();
    
    $button .click(function(){
        $row.clone().insertBefore( $button );
    });
	
	var $button2 = $('#addTableRowExp'),
        $row2 = $('#mans1').clone();
    
    $button2.click(function(){
        $row2.clone().insertBefore( $button2 );
    });
	
});
</script>
<!--
TOP LINKS....DASHBOARD
-->

<table width="100%" cellpadding="10">
  <tr style="border:none;">
    <td style="border:none;" align="left"><div style="float:left;"> <img src="<?php echo $iconsDir.'/busroute.png'; ?>" alt="" style="width: 64px; height: 64px;" /> </div>
      <div style="float:left;">
        <div>&nbsp;</div>
        <h1 class="item-page-title">Add/Edit Transport Route</h1>
      </div>
      <div style="float:right;"> <a href="<?php echo $dashboardlink; ?>"><img src="<?php echo $iconsDir1.'/1dashboard.png'; ?>" alt="Dash Board" style="width: 32px; height: 32px;" /></a><br />
      </div>
      <div style="float:right; width:10px;"> &nbsp;</div>
      <div style="float:right;"> <a href="<?php echo $busroutelink; ?>"><img src="<?php echo $iconsDir1.'/1transport.png'; ?>" alt="Master" style="width: 32px; height: 32px;" /></a><br />
      </div>
      <div style="float:right; width:10px;"> &nbsp;</div>
      <div style="float:right;"> <a href="<?php echo $transport; ?>"><img src="<?php echo $iconsDir.'/busroute.png'; ?>" alt="Academic Terms" style="width: 32px; height: 32px;" /></a><br />
      </div></td>
  </tr>
</table>
<div class="row-fluid adjustalert alert alert-warning">
<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce'); ?>" method="POST" name="adminForm">
  <div class="span4">
    <div class="control-group">
      <label class="control-label" for="focusedInput">Route Name</label>
      <div class="controls">
        <input class="focused" id="focusedInput" type="text" name="route"  readonly value="<?php echo $this->rec->route; ?>">
      </div>
    </div>
  </div>
  <div class="span4">
    <div class="control-group" >
      <label class="control-label" for="selectError">Vehicle Code</label>
      <div class="controls">
      		<?php
				 $vehicle = $model->getvehicle($this->rec->vid); 
	  			 $stops = $model->getStops($this->rec->id);
				  $countstops = $model->countStops($this->rec->id);
				  echo "<td><input type='text' value=".$vehicle->vcode." readonly /></td>";
			?>
      </div>
    </div>
    </div>
    <div class="span4">
    <div class="control-group" >
      <label class="control-label" for="selectError">No of Stops</label>
      <div class="controls">
		  <div class="input-append">
									<input id="appendedInput" size="16" type="text" name="route"  readonly  value="<?php echo $countstops->n_stops;?>">
		  </div>
      </div>
    </div>
    </div>
  </div>
</div>
<form action="index.php" class="form-horizontal" method="POST" name="addform" id="addform" onSubmit="return stest()">
  <div class="row-fluid sortable">
    <div class="box span12">
      <div class="box-header well" data-original-title>
        <h2><i class="icon-user"></i> Stop Details</h2>
        <div class="box-icon"> <a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a> <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a> <a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a> </div>
      </div>
      <div class="box-content">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th><span class="icon icon-color icon-triangle-ns"></span>Stop Name</th>
              <th><span class="icon icon-color icon-triangle-ns"></span>Fare</th>
              <th width="25%"><span class="icon icon-color icon-triangle-ns"></span>Morning Arival</th>
              <th width="25%"><span class="icon icon-color icon-triangle-ns"></span>Evening Arival</th>
              <th width="25%"><span class="icon icon-color icon-triangle-ns"></span>Operation</th>
            </tr>
          </thead>
        <tbody>
          <?php
  	foreach($stops as $data)
	{
 $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=transportroutes&controller=transportroutes&layout=viewstops&task=delete&cid='.$data->routeId.'&sid='.$data->id,false);
		                                	
  ?>
    <tr style="height:40px;">
      <td ><?php echo $data->stopname?></td>
     <td ><?php echo $data->fare?></td>
      <td ><?php echo $data->m_arrival?></td>
      <td ><?php echo $data->e_arrival?></td>
      <td>
      <a class="btn btn-danger" href="<?php echo $redirectTo; ?>">
<i class="icon-trash icon-white"></i>
Delete
</a>
</td>
    </tr>
    <?php } ?>
        </tbody>
       </table>
      </div>
    <!--/span--> 
  </div>
  <!--/row-->


