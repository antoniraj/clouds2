<?php
        defined('_JEXEC') OR DIE('Access denied..');
        $app = JFactory::getApplication();
	$iconsDir = JURI::base() . 'components/com_cce/images/64x64';
?>
<div>
        <div style="float:left;">
           <img src="<?php echo $iconsDir.'/managesubjects.png'; ?>" alt="" style="width: 64px; height: 64px;" />
        </div>
        <div>
                <div>&nbsp;</div>
                <h1>Manage Subjects</h1>
        </div>
</div>


<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_cce&controller=academicyears&view=academicyears&task=actions&Itemid='.$Itemid); ?>" method="POST" name="adminForm">
  <div class="row-fluid sortable">
  <div class="box span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-edit"></i>Scholastic B-Grades</h2>
      <div class="box-icon"> <a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a> <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a> </div>
    </div>
    <div class="box-content">
      <table class="table table-striped table-bordered bootstrap-datatable datatable">
        <thead>
          <tr>
            <th><input type="checkbox" value="" onchange="check()" name="chk[]"></th>
            <th>Subject Title</th>
            <th>Subject Code</th>
            <th>Acronym</th>
            <th>credits</th>
          </tr>
        </thead>
        <tbody>
          <?php
					foreach($this->subjects as $rec) {
                 		?>
          <tr>
            <td><input type="checkbox" name="cid[]" id="cid[]" value="<?php echo $rec->id; ?>" /></td>
                <td><?php echo $rec->subjecttitle; ?></td>
                <td><?php echo $rec->subjectcode; ?></td>
                <td><?php echo $rec->acronym; ?></td>
                <td><?php echo $rec->credits; ?></td>
          </tr>
          <?php
								}
							?>
        </tbody>
      </table>
      <div class="row-fluid">
        <div class="span6">
          <button class="btn btn-small btn-primary" value="Edit" name="Edit"> <i class="icon-edit"></i> Edit</button>
          <button class="btn btn-small btn-danger"  value="Delete" name="Delete"> <i class="icon-trash"></i> Delete</button>
        </div>
        <div class="span6" align="right">
          <button class="btn btn-small btn-success" name="Add" value="Add"><i class="icon-plus-sign"></i> Add</button>
        </div>
      </div>
    </div>
    <!--/span--> 
    
  </div>
  <!--/row-->
<input type="hidden" name="controller" value="managesubjects" />
<input type="hidden" name="view" value="managesubjects" />
<input type="hidden" name="aid" value="<?php echo $this->cay[0]->id; ?>" />
<input type="hidden" name="task" value="action"/>
</form>

<form action="<?php echo JRoute::_('index.php?option=com_cce&controller=managesubjects&task=display'); ?>" method="POST" name="adminForm">
<table border="1" cellspacing="2" cellpadding="3">
<tr>
        <th class="list-title" width="5%">Option</th>
        <th class="list-title" width="45%">Subject Title</th>
        <th class="list-title" width="20%">Subject Code</th>
        <th class="list-title" width="20%">Acronym</th>
        <th class="list-title" width="10%">Credits</th>
</tr>
        <?php

                foreach($this->subjects as $rec) {
                       // $link1 = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=courses&controller=courses&task=edit&cid[]='.$rec->id);
        ?>
        <tr>
                <td><input type="checkbox" name="cid[]" id="cid[]" value="<?php echo $rec->id; ?>" /> </td>
                <td><?php echo $rec->subjecttitle; ?></td>
                <td><?php echo $rec->subjectcode; ?></td>
                <td><?php echo $rec->acronym; ?></td>
                <td><?php echo $rec->credits; ?></td>
        </tr>
        <?php } ?>
</table>
<table border="0" width="100%">
<tr> <td width="50%"><input type="submit" class="button_delete"  value="Delete" name="Delete">
<input type="submit" class="button_edit" name="Edit" value="Edit"></td>
<td width="50%" align="right"><input type="submit" class="button_add" name="Add" value="Add"> </td> </tr>
<input type="hidden" name="controller" value="managesubjects" />
<input type="hidden" name="view" value="managesubjects" />
<input type="hidden" name="aid" value="<?php echo $this->cay[0]->id; ?>" />
<input type="hidden" name="task" value="action"/>
</table>
</form>
