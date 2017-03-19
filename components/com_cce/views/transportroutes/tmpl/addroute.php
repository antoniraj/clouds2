

<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
	$Itemid = JRequest::getVar('Itemid');
	JHtml::stylesheet('styles.css','./components/com_cce/css/');
	JHtml::stylesheet('jquery-ui-1.10.0.custom.min.css','./components/com_cce/js/timepicker/');
	JHtml::stylesheet('jquery.ui.timepicker.css?v=0.3.3','./components/com_cce/js/timepicker/');
	JHTML::script('jquery-1.9.0.min.js', 'components/com_cce/js/timepicker/include/');
	JHTML::script('jquery.ui.core.min.js', 'components/com_cce/js/timepicker/include/ui-1.10.0');
	JHTML::script('jquery.ui.widget.min.js', 'components/com_cce/js/timepicker/include/ui-1.10.0');
	JHTML::script('jquery.ui.tabs.min.js', 'components/com_cce/js/timepicker/include/ui-1.10.0');
	JHTML::script('jquery.ui.position.min.js', 'components/com_cce/js/timepicker/include/ui-1.10.0');
	JHTML::script('jquery.ui.timepicker.js', 'components/com_cce/js/timepicker/');

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


  <SCRIPT language="javascript">
        function addRow(tableID) {
 
            var table = document.getElementById(tableID);
 
            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);
 
            var colCount = table.rows[0].cells.length;
 
            for(var i=0; i<colCount; i++) {
 
                var newcell = row.insertCell(i);
 
                newcell.innerHTML = table.rows[0].cells[i].innerHTML;
                //alert(newcell.childNodes);
                switch(newcell.childNodes[0].type) {
                    case "text":
                            newcell.childNodes[0].value = "";
                            break;
                    case "checkbox":
                            newcell.childNodes[0].checked = false;
                            break;
                    case "select-one":
                            newcell.childNodes[0].selectedIndex = 0;
                            break;
                }
            }
        }
 
        function deleteRow(tableID) {
            try {
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;
 
            for(var i=0; i<rowCount; i++) {
                var row = table.rows[i];
                var chkbox = row.cells[0].childNodes[0];
                if(null != chkbox && true == chkbox.checked) {
                    if(rowCount <= 1) {
                        alert("Cannot delete all the rows.");
                        break;
                    }
                    table.deleteRow(i);
                    rowCount--;
                    i--;
                }
 
 
            }
            }catch(e) {
                alert(e);
            }
        }
 
    </SCRIPT>

<table width="100%" cellpadding="10">
  <tr style="border:none;">
    <td style="border:none;" align="left"><div style="float:left;"> <img src="<?php echo $iconsDir.'/busroute.png'; ?>" alt="" style="width: 64px; height: 64px;" /> </div>
      <div style="float:left;">
        <div>&nbsp;</div>
        <h1 class="item-title">Add/Edit Transport Route</h1>
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
      <label class="control-label" for="focusedInput">Destination</label>
      <div class="controls">
        <input class="focused" id="focusedInput" type="text" required="required" name="route" value="<?php echo $this->rec->route; ?>">
      </div>
    </div>
  </div>
  <div class="span4">
    <div class="control-group" >
      <label class="control-label" for="selectError">Select Vehicle Code</label>
      <div class="controls">
        <select name="vid" id="selectError" data-rel="chosen">
          <option value="0">Select</option>
          <?php foreach($this->vehicles as $veh) {  ?>
          <option value="<?php echo $veh->id; ?>" <?php if($this->rec->vid==$veh->id) echo 'selected="selected"'; ?> ><?php echo $veh->vcode; ?></option>
          <?php }?>
        </select>
      </div>
    </div>
  </div>
</div>

<form action="index.php" class="form-horizontal" method="POST" name="addform" id="addform" onSubmit="return stest()">
  <div class="row-fluid sortable">
    <div class="box span12">
      <div class="box-header well" data-original-title>
        <h2><i class="icon-user"></i> Vehicle Details</h2>
        <div class="box-icon"> <a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a> <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a> </div>
      </div>
      <div class="box-content">
        <table class="table table-striped">
          <thead>
            <tr>
             <th class="sorting_disabled"><input type="checkbox" onchange="check()" name="chk[]" /></th>
              <th><span class="icon icon-color icon-triangle-ns"></span>Stop Name</th>
              <th><span class="icon icon-color icon-triangle-ns"></span>Fare</th>
              <th width="25%"><span class="icon icon-color icon-triangle-ns"></span>Morning Arival</th>
              <th width="25%"><span class="icon icon-color icon-triangle-ns"></span>Evening Arival</th>
            </tr>
          </thead>
          </table>
         <table  id="dataTable" class="table table-striped">

            <?php
			  $stops = $model->getStops($this->rec->id);  
   if($stops)
   {
  	foreach($stops as $data)
	{
		
  ?>
          <input type="hidden" name="ids[]" size="32" required="required" value="<?php echo $data->id?>"/>
          <tr>
          <TD><INPUT type="checkbox" name="chk"/></TD>
            <td ><input type="text" id="stopname" name="stopname[]" size="32" required="required" value="<?php echo $data->stopname?>"/></td>
            <td ><input type="text" id="fare" name="fare[]" size="20"  required="required" value="<?php echo $data->fare?>"/></td>
            <td ><input type="text" id="m_arrival" name="m_arrival[]" size="32"  value="<?php echo $data->m_arrival?>"/></td>
            <td ><input type="text" id="e_arrival" name="e_arrival[]" size="32"  value="<?php echo $data->e_arrival?>"/></td>
            </tr>
  <?php }
   }
   else{
	   ?>
          <tr id="mans">
           <TD><INPUT type="checkbox" name="chk"/></TD>
            <td ><input type="text" id="stopname" name="stopname[]" size="32" required="required" value=""/></td>
            <td ><input type="text" id="fare" name="fare[]" size="20"  required="required" value=""/></td>
            <td ><input type="text" id="m_arrival" name="m_arrival[]" size="32"  value=""/></td>
            <td ><input type="text" id="e_arrival" name="e_arrival[]" size="32"  value=""/></td>
          </tr>
      <?php
   }
   ?>
        </table>
             <div class="row-fluid">
        <div class="span12" align="right">
        <button class="btn btn-small btn-success" name="submit"  value="Save"><i class="icon-plus-sign icon-white"></i> Save</button>
     
           <button type="button" class="btn btn-small btn-primary"  value="addrow" onclick="addRow('dataTable')" ><i class="icon icon-color icon-square-plus"></i> Add Row</button>
      <button type="button" class="btn btn-danger"  value="Deleterow" onclick="deleteRow('dataTable')" ><i class="icon-trash icon-white"></i> Delete Row</button>
       
        </div>
      </div>
      </div>

    </div>
    <!--/span--> 
  </div>
  <!--/row-->
  <input type="hidden" name="option" value="<?php echo JRequest::getVar('option'); ?>" />
  <input type="hidden" id="id" name="id" value="<?php echo $this->rec->id; ?>" />
  <input type="hidden" id="aid" name="aid" value="<?php echo $this->rec->aid; ?>" />
  <input type="hidden" id="view" name="view" value="transportroutes" />
  <input type="hidden" id="controller" name="controller" value="transportroutes" />
  <input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid; ?>" />
  <input type="hidden" name="task" id="task" value="save" />
  <input type="hidden" name="layout" id="layout" value="addroute" />
</form>
  <div>
        <label for="timepicker_6">Time picker with period (AM/PM) in input and with hours leading 0s :</label>
        <input type="text" style="width: 70px;" id="timepicker_6" value="01:30 PM" />
        <script type="text/javascript">
            $(document).ready(function() {
                $('#timepicker_6').timepicker({
                    showPeriod: true,
                    showLeadingZero: true
                });
            });
        </script>

        <a onclick="$('#script_6').toggle(200)">[Show code]</a>
<pre id="script_6" style="display: none" class="code">$('#timepicker').timepicker({
    showPeriod: true,
    showLeadingZero: true
});</pre>
    </div>
