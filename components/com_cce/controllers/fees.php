<?php
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

require_once('helper.php'); 

class CCEControllerFees extends JController
{

	function validateuser()
	{
		if(! Helper::checkuser()){ 
			$redirectTo = JRoute::_('index.php?option=com_users?view=login',false);
	        	$this->setRedirect($redirectTo,'Please Login...');
			return;
		}
	}

   	function display() {
		$this->validateuser();
		$document = JFactory::getDocument();
        	$viewType = $document->getType();
	        $viewName = JRequest::getCmd('view', $this->default_view);
        	$viewLayout = JRequest::getCmd('layout', 'default');
	        $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        	$model=& $this->getModel('fees');
	        if($model==true){
        	        $view->setModel($model,true);
	        }
        	$view->setLayout($viewLayout);
	        $view->display();
    	}

	function showfeestructure(){
                $sc = JRequest::get('POST');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=feecategory&Itemid='.$sc['Itemid'].'&fstid='.$sc['fstid'].'&cmdf='.$sc['cmdf'],false);
                $this->setRedirect($redirectTo,'');
	}

	function savenewfeestructure(){
                $sc = JRequest::get('POST');
                $model = & $this->getModel('fees');
                $status = $model->addFeeStructure('New Fee Structure - please update',$fstid);
		if($status){
			$fcs = $model->getFeeCategories_tt();
			foreach($fcs as $fc){
				$model->addFeeCategory1($fc->name,$fc->description,$fcid);
				$fps = $model->getFeeParticulars_t($fc->id);
				foreach($fps as $fp){
					$model->addFeeParticular($fp->name,$fp->description,$fp->amount,$fp->accountid,$fcid,$fp->groupbased);
				}
				$model->addFeeCategoryStructure($fstid,$fcid);
			}
		}
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=feecategory&Itemid='.$sc['Itemid'].'&fstid='.$fstid.'&cmdf='.$sc['cmdf'],false);
                $this->setRedirect($redirectTo,'');
	}

	function savefeeparticulars(){
                $sc = JRequest::get('POST');
                $model = & $this->getModel('fees');
		foreach($sc['test'] as  $k=>$v){
			$model->updateFeeParticular1($k,$v);
		}
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=feecategory&Itemid='.$sc['Itemid'].'&fstid='.$sc['fstid'].'&eon='.$sc['eon'].'&cmdf='.$sc['cmdf'],false);
                $this->setRedirect($redirectTo,'');
		
	}

	function savefeestructure(){
                $sc = JRequest::get('POST');
                $model = & $this->getModel('fees');
		$status = $model->updateFeeStructure($sc['fstid'],$sc['fsttitle']);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=feecategory&Itemid='.$sc['Itemid'].'&fstid='.$sc['fstid'].'&cmdf='.$sc['cmdf'],false);
		if($status){
	                $this->setRedirect($redirectTo,'');
		}else{
	                $this->setRedirect($redirectTo,'Could not add a fee structure title...');
		}
	}

	function savefeecategory(){
                $sc = JRequest::get('POST');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=feecategory&Itemid='.$sc['Itemid'].'&fstid='.$sc['fstid'].'&eon='.$sc['eon'],false);
                $model = & $this->getModel('fees');
                if($sc['id']==-1){
                        $status = $model->addFeeCategory($sc['name'],$sc['description']);
                }else{
                        $status = $model->updateFeeCategory($sc['id'],$sc['name'],$sc['description']);
                }
                if($status==false){
                        JError::raiseWarning(500,'Could not save record..');
                        $this->setRedirect($redirectTo,'Retry...');
                }else{
                        $this->setRedirect($redirectTo,'Fee Category has been Saved...');
                }
	}


        function savefeecategory_t(){
                $sc = JRequest::get('POST');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=feeheads&Itemid='.$sc['Itemid'],false);
                $model = & $this->getModel('fees');
                if($sc['id']==-1){
                        $status = $model->addFeeCategory_t($sc['name'],$sc['description']);
                }else{
                        $status = $model->updateFeeCategory_t($sc['id'],$sc['name'],$sc['description']);
                }
                if($status==false){
                        JError::raiseWarning(500,'Could not save record..');
                        $this->setRedirect($redirectTo,'Retry...');
                }else{
                        $this->setRedirect($redirectTo,'Fee Category has been Saved...');
                }
        }


	function deletefeecategory()
        {
		$fcid = JRequest::getVar('fcid');
		$eon = JRequest::getVar('eon');
		$fstid = JRequest::getVar('fstid');
		$Itemid = JRequest::getVar('Itemid');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=feecategory&eon='.$eon.'&fstid='.$fstid.'&Itemid='.$Itemid,false);
                if($fcid==null){
                        //Make sure the id parameter was in the request
                        JError::raiseWarning(500,'Record not found..');
                        $this->setRedirect($redirectTo,'Retry...');
                        return;
                }
                $model = & $this->getModel('fees');
                $status=$model->deleteFeeCategory($fcid);
                if($status==true)
                        $this->setRedirect($redirectTo,'Record has been deleted...!');
                else
                        $this->setRedirect($redirectTo,'Could not delete..');
        }


        function deletefeecategory_t()
        {
                $fcid = JRequest::getVar('fcid');
                $Itemid = JRequest::getVar('Itemid');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=feeheads&Itemid='.$Itemid,false);
                if($fcid==null){
                        //Make sure the id parameter was in the request
                        JError::raiseWarning(500,'Record not found..');
                        $this->setRedirect($redirectTo,'Retry...');
                        return;
                }
                $model = & $this->getModel('fees');
                $status=$model->deleteFeeCategory_t($fcid);
                if($status==true)
                        $this->setRedirect($redirectTo,'Record has been deleted...!');
                else
                        $this->setRedirect($redirectTo,'Could not delete..');
        }


	function deletefeestructure(){
                $model = & $this->getModel('fees');
		$fstid = JRequest::getVar('fstid');
		$Itemid= JRequest::getVar('Itemid');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=feecategory&fstid='.$fstid.'&Itemid='.$Itemid,false);
		$rs=$model->deleteFeeStructure($fstid);
		if($rs)
	                $this->setRedirect($redirectTo,'Deleted...');
		else
                	$this->setRedirect($redirectTo,'Operation Failed');
	
	}
	

	function enableediting(){
		$fstid = JRequest::getVar('fstid');
		$Itemid= JRequest::getVar('Itemid');
		$eon= JRequest::getVar('eon');
		if($eon=='1') $eon='0';
		else $eon='1';	
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=feecategory&eon='.$eon.'&fstid='.$fstid.'&Itemid='.$Itemid,false);
                $this->setRedirect($redirectTo,'');
		
	}

	function deletefeecourse()
        {
		$fcidstr= JRequest::getVar('fcids');
		$fcids = explode('-',$fcidstr);

		$fstid = JRequest::getVar('fstid');
		$type= JRequest::getVar('type');
		$eon= JRequest::getVar('eon');
		$cid = JRequest::getVar('cid');
		$Itemid = JRequest::getVar('Itemid');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&eon='.$eon.'&controller=fees&task=display&layout=feecategory&fstid='.$fstid.'&Itemid='.$Itemid,false);
                $model = & $this->getModel('fees');
		if($type==1){
			foreach($fcids as $fcid){
		                $status=$model->deleteFeeCourse($fcid,$cid);
			}
		        $status=$model->deleteFeeCourseParticulars($cid);
		}
		if($type==2){
			$fcid = JRequest::getVar('fcid');
        	        $status=$model->deleteFeeCourse($fcid,$cid);
                	$status=$model->deleteFeeCourseParticulars1($cid,$fcid);
		}
                $this->setRedirect($redirectTo,'Deleted...');
	}


        function deletefeecourseparticular()
        {
                $fstid = JRequest::getVar('fstid');
                $fpid = JRequest::getVar('fpid');
                $eon= JRequest::getVar('eon');
                $cid = JRequest::getVar('cid');
                $Itemid = JRequest::getVar('Itemid');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&eon='.$eon.'&controller=fees&task=display&layout=feecategory&fstid='.$fstid.'&Itemid='.$Itemid,false);
                $model = & $this->getModel('fees');
                $status=$model->deleteFeeCourseParticular($fpid,$cid);
                $this->setRedirect($redirectTo,'Deleted...');
        }



        function deletefeeparticulargroup()
        {
                $fpid= JRequest::getVar('fpid');
                $fstid = JRequest::getVar('fstid');
                $eon= JRequest::getVar('eon');
                $gid = JRequest::getVar('gid');
                $Itemid = JRequest::getVar('Itemid');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&eon='.$eon.'&controller=fees&task=display&layout=feecategory&fstid='.$fstid.'&Itemid='.$Itemid,false);
                $model = & $this->getModel('fees');
                $status=$model->deleteFeeParticularGroup($fpid,$gid);
                $this->setRedirect($redirectTo,'Deleted...');
        }




  	function deletefeegroup()
        {
                $fcid= JRequest::getVar('fcid');
                $fstid = JRequest::getVar('fstid');
                $eon= JRequest::getVar('eon');
                $gid = JRequest::getVar('gid');
                $Itemid = JRequest::getVar('Itemid');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&eon='.$eon.'&controller=fees&task=display&layout=feecategory&fstid='.$fstid.'&Itemid='.$Itemid,false);
                $model = & $this->getModel('fees');
                $status=$model->deleteFeeGroup($fcid,$gid);
                $this->setRedirect($redirectTo,'Deleted...');
        }



	function assigngroups()
	{
                $fstid = JRequest::getVar('fstid');	
                $fcid = JRequest::getVar('fcid');	
		$eon= JRequest::getVar('eon');	
		$Itemid = JRequest::getVar('Itemid');	
                $cids = JRequest::getVar('cid',null,'default','array');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&eon='.$eon.'&task=display&layout=feecategory&fstid='.$fstid.'&Itemid='.$Itemid,false);
                if($cids==null){
                        //Make sure the cid parameter was in the request
                        //JError::raiseError(500,'CID parameter is missing');
                        JError::raiseWarning(500,'Please select a record..');
                        $this->setRedirect($redirectTo,'Retry...');
                        return;
		}
                $model = & $this->getModel('fees');
		foreach($cids as $cid){
                	$status=$model->assignFeeGroup($fcid,$cid);
		}
                $this->setRedirect($redirectTo,'');
	}


        function assignparticulargroups()
        {
                $fstid = JRequest::getVar('fstid');
                $fpid = JRequest::getVar('fpid');
                $eon= JRequest::getVar('eon');
                $Itemid = JRequest::getVar('Itemid');
                $cids = JRequest::getVar('cid',null,'default','array');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&eon='.$eon.'&task=display&layout=feecategory&fstid='.$fstid.'&Itemid='.$Itemid,false);
                if($cids==null){
                        //Make sure the cid parameter was in the request
                        //JError::raiseError(500,'CID parameter is missing');
                        JError::raiseWarning(500,'Please select a record..');
                        $this->setRedirect($redirectTo,'Retry...');
                        return;
                }
                $model = & $this->getModel('fees');
                foreach($cids as $cid){
                        $status=$model->assignFeeParticularGroup($fpid,$cid);
                }
                $this->setRedirect($redirectTo,'');
        }



	function assigncourses()
	{
                $fcidstr = JRequest::getVar('fcids');	
		$fcids = explode('-',$fcidstr);
                $fstid = JRequest::getVar('fstid');	
                $fpid= JRequest::getVar('fpid');	
                $flag= JRequest::getVar('flag');	
                $eon= JRequest::getVar('eon');	
                $Itemid = JRequest::getVar('Itemid');	
		//Read cid as an array
                $cids = JRequest::getVar('cid',null,'default','array');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&eon='.$eon.'&task=display&layout=feecategory&fstid='.$fstid.'&Itemid='.$Itemid,false);
                if($cids==null){
                        //Make sure the cid parameter was in the request
                        //JError::raiseError(500,'CID parameter is missing');
                        JError::raiseWarning(500,'Please select a record..');
                        $this->setRedirect($redirectTo,'Retry...');
                        return;
                }
                $model = & $this->getModel('fees');
		if($flag=='particular'){
		   foreach($cids as $cid){
				$model->assignFeeCourseParticular($fpid,$cid);
			}
			
		}else{
		foreach($fcids as $fcid){
		   $st=$model->getFeeCategoryCourseParticulars($fcid,$precs);
		   foreach($cids as $cid){
                	$model->assignFeeCourse($fcid,$cid); //TRIGGER INSERTS RECORDS IN FEECOLLECTIONMASTER TABLE
			foreach($precs as $prec){
				$model->assignFeeCourseParticular($prec->id,$cid);
			}
		   }
		}
		}
                $this->setRedirect($redirectTo,'');
	}

        function savefeeparticular(){
                $sc = JRequest::get('POST');
		if(isset($sc['groupbased'])) $sc['groupbased']=1;
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=feecategory&fcid='.$sc['fcid'].'&fstid='.$sc['fstid'].'&eon='.$sc['eon'].'&Itemid='.$sc['Itemid'].'&eon='.$sc['eon'],false);
                $model = & $this->getModel('fees');
                if($sc['id']==-1){
                        $status = $model->addFeeParticular($sc['name'],$sc['description'],$sc['amount'],$sc['accountid'],$sc['fcid'],$sc['groupbased']);
                }else{
                        $status = $model->updateFeeParticular($sc['id'],$sc['name'],$sc['description'],$sc['accountid'], $sc['amount'],$sc['groupbased']);
                }
                if($status==false){
                        JError::raiseWarning(500,'Could not save record..');
                        $this->setRedirect($redirectTo,'Retry...');
                }else{
                        $this->setRedirect($redirectTo,'Fee has been Saved...');
                }
        }


	function deletefeeparticular()
        {
                $fcid = JRequest::getVar('fcid');
		$fstid = JRequest::getVar('fstid');
		$eon= JRequest::getVar('eon');
                $fpid = JRequest::getVar('fpid');
                $Itemid = JRequest::getVar('Itemid');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=feecategory&fcid='.$fcid.'&fstid='.$fstid.'&eon='.$eon.'&Itemid='.$Itemid,false);
                $model = & $this->getModel('fees');
                $status=$model->deleteFeeParticular($fpid);
		if($status)
	                $this->setRedirect($redirectTo,'Deleted...');
		else{
                        JError::raiseWarning(500,'You can not delete this  if students have paid for this particular already');
	                $this->setRedirect($redirectTo,'');
		}
        }

  	function savefeeparticular_t(){
                $sc = JRequest::get('POST');
		if(isset($sc['groupbased'])) $sc['groupbased']=1;
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=feeheads&fcid='.$sc['fcid'].'&Itemid='.$sc['Itemid'],false);
                $model = & $this->getModel('fees');
                if($sc['id']==-1){
                        $status = $model->addFeeParticular_t($sc['name'],$sc['description'],$sc['amount'],$sc['accountid'],$sc['fcid'],$sc['groupbased']);
                }else{
                        $status = $model->updateFeeParticular_t($sc['id'],$sc['name'],$sc['description'],$sc['accountid'],$sc['amount'],$sc['groupbased']);
                }
                if($status==false){
                        JError::raiseWarning(500,'Could not save record..');
                        $this->setRedirect($redirectTo,'Retry...');
                }else{
                        $this->setRedirect($redirectTo,'Fee Particular has been Saved...');
                }
        }


        function deletefeeparticular_t()
        {
                $fcid = JRequest::getVar('fcid');
                $fpid = JRequest::getVar('fpid');
                $Itemid = JRequest::getVar('Itemid');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=feeheads&fcid='.$fcid.'&Itemid='.$Itemid,false);
                $model = & $this->getModel('fees');
                $status=$model->deleteFeeParticular_t($fpid);
                $this->setRedirect($redirectTo,'Deleted...');
        }


	

	function savediscount(){
		$Itemid = JRequest::getVar('Itemid');	
                $sc = JRequest::get('POST');
                $model = & $this->getModel('fees');
		if(count($sc['class'])>0){
		foreach($sc['class'] as $cid){
        		$status=$model->addFeeDiscount($sc['fcid'],$sc['studentcategoryid'],$cid,$sc['discount']);
		}
		$str="";
		}else{
			$str="No classes have been selected...";
		}
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=discounts&fcid='.$fcid.'&Itemid='.$Itemid,false);
                $this->setRedirect($redirectTo,$str);
	}
	
	function deletefeediscount(){
                $fdid = JRequest::getVar('fdid');
		$Itemid = JRequest::getVar('Itemid');	
                $model = & $this->getModel('fees');
		$s = $model->deleteFeeDiscount($fdid);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=discounts&fcid='.$fcid.'&Itemid='.$Itemid,false);
                $this->setRedirect($redirectTo,'Deleted...');
	}

	function updatediscount(){
                $sc = JRequest::get('POST');
		$Itemid = JRequest::getVar('Itemid');	
                $model = & $this->getModel('fees');
		$s = $model->updateFeeDiscount($sc['fdid'],$sc['discount']);
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=discounts&fcid='.$fcid.'&Itemid='.$Itemid,false);
                $this->setRedirect($redirectTo,'Updated...');
	}

	function savefeeschedule(){
                $sc = JRequest::get('POST');
		$Itemid = JRequest::getVar('Itemid');	
                $model = & $this->getModel('fees');
		foreach($sc['fdate'] as $key=>$frec){
			$fine = $sc['fine'];
			$gid = $sc['gid'];
			list($cid,$fcid,$fsid1) = explode("-",$key);
			if($fsid1){
				$status = $model->updateFeeSchedule($fsid1,JArrayHelper::mysqlFormat($frec),$fine[$key]);
			}else{
        	        	$status = $model->addFeeSchedule($fcid,$cid,JArrayHelper::mysqlFormat($frec),$fine[$key],$gid[$key]);
			}
                	if($status==false){
                        	JError::raiseWarning(500,'Could not save record..');
	                        $this->setRedirect($redirectTo,'Retry...');
        	        }else{
                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=feeschedule&Itemid='.$sc['Itemid'],false);
                        	$this->setRedirect($redirectTo,'Fee Schedule has been Saved...');
			}
		}
	}

	function printfeereceipt(){
                $fs = JRequest::get('POST');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=printreceipt&regno='.$fs['regno'].'&cid='.$fs['cid'].'&gid='.$fs['gid'].'&studentid='.$fs['studentid'].'&receiptno='.$fs['receiptno'].'&fcid='.$fs['fcid'].'&Itemid='.$fs['Itemid']."&format=pdf&tmpl=component",false);
                $this->setRedirect($redirectTo,'');
		
	}


	function savedeductions($sc)
	{
                $model = & $this->getModel('fees');
		if($sc['groupbased']=="1"){
			if($sc['caddflag']=='1')
        	       	 	$status = $model->addGroupFeeConcession($sc['fcid'],$sc['studentid'],$sc['gid'],$sc['concession']);
			else
               	 		$status = $model->updateGroupFeeConcession1($sc['fcid'],$sc['studentid'],$sc['gid'],$sc['concession']);
		}else{
			if($sc['caddflag']=='1')
               	 		$status = $model->addFeeConcession($sc['fcid'],$sc['studentid'],$sc['cid'],$sc['concession']);
			else
               	 		$status = $model->updateFeeConcession1($sc['fcid'],$sc['studentid'],$sc['cid'],$sc['concession']);
		}
		return $status;
	}





        function savefeetransaction(){

                $rtype=2;   //1 to ordinary receipt - one receipt for all particulars
                            // 2 to print different receipts for accounts


                $fs = JRequest::get('POST');


                $model = & $this->getModel('fees');
                if(isset($fs['Save'])){
                        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=feesubmission&cid='.$fs['cid'].'&studentid='.$fs['studentid'].'&fcid='.$fs['fcid'].'&groupbased='.$fs['groupbased'].'&gid='.$fs['gid'].'&Itemid='.$fs['Itemid'],false);
                        $status=$this->savedeductions($fs);

                        //Save individual concession amounts
                        foreach($fs['conn'] as $key=>$val){
                                list($c_studentid,$c_fpid,$c_id) = explode("$$",$key);
                                if($c_id=="-1"){
					if($val>0)
                                        	$rs=$model->addFeeParticularConcession($c_studentid,$c_fpid,$val);
                                }else{
                                        $rs=$model->updateFeeParticularConcession($c_studentid,$c_fpid,$val);
                                }
                        }

                        if($status) $this->setRedirect($redirectTo,'Successfully saved...');
                        else $this->setRedirect($redirectTo,'Save Failed...');
			return;

                }else if(isset($fs['pay'])){
               		if($fs['gid']>0 && $fs['groupbased']=="1")
                        	$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=feesubmission&groupbased='.$fs['groupbased'].'&cid='.$fs['cid'].'&gid='.$fs['gid'].'&studentid='.$fs['studentid'].'&fcid='.$fs['fcid'].'&insflag='.$fs['insflag'].'&Itemid='.$fs['Itemid'],false);
                	else{
				if(isset($fs['dc']))
                        		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=feecollectionclasslist&cid='.$fs['cid'].'&studentid='.$fs['studentid'].'&fcid='.$fs['fcid'].'&insflag='.$fs['insflag'].'&Itemid='.$fs['Itemid'],false);
				else
                        		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=feesubmission&cid='.$fs['cid'].'&studentid='.$fs['studentid'].'&fcid='.$fs['fcid'].'&insflag='.$fs['insflag'].'&Itemid='.$fs['Itemid'],false);
			}
                
			if($fs['paidnow']<=0) {
                        	JError::raiseWarning(500,'Paid amount can not be zero/negative...');
 	                       $this->setRedirect($redirectTo,'Retry...');
        	                return;
                	}

                	$a = explode('-',$fs['chequeordddate']);
	                $cddate = $a[2].'-'.$a[1].'-'.$a[0];

        	        if($fs['paidnow'] > $fs['balance']){
                	        JError::raiseWarning(500,'Paid amount can not be more than the due...');
                        	$this->setRedirect($redirectTo,'Retry...');
	                        return;
        	        }

		}else if(isset($fs['Print'])){
                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=printreceipt&regno='.$fs['regno'].'&cid='.$fs['cid'].'&gid='.$fs['gid'].'&studentid='.$fs['studentid'].'&receiptno='.$fs['receiptno'].'&fcid='.$fs['fcid'].'&Itemid='.$fs['Itemid']."&format=pdf&tmpl=component",false);
		                $this->setRedirect($redirectTo,'');
				return;
				
		}else{
                	        JError::raiseWarning(500,'Something went wrong...');
                        	$this->setRedirect($redirectTo,'Retry...');
	                        return;
				
		}





        if($rtype=="1"){
                //Get FeePrefix
                $feeprefix=$model->getCurrentFeePrefix()->feeprefix;
                if($fs['gid']>0 && $fs['groupbased']=="1")
                        $status = $model->addFeeTransaction1($fs['fcid'],$fs['studentid'],$fs['cid'],$fs['gid'],$fs['paidnow'],$fs['paymentmode'],$fs['chequeorddno'],$cddate,$fs['bankdetails'],$feeprefix.'-'.$fs['receiptno'],$obj);
                else
                        $status = $model->addFeeTransaction($fs['fcid'],$fs['studentid'],$fs['cid'],$fs['paidnow'],$fs['paymentmode'],$fs['chequeorddno'],$cddate,$fs['bankdetails'],$feeprefix.'-'.$fs['receiptno'],$obj);

                if($status){
                        //Save Individual Particulars
                        foreach($fs['bala'] as $key=>$val){
                                list($pp_acid,$pp_fpid)=explode("$$",$key);
                                $rs=$model->addFeeTransactionParticular($obj->fctid,$pp_fpid,$val);
                        }
                }

                if(($fs['balance']==$fs['paidnow'])&& $status){
                        if($fs['gid']>0 && $fs['groupbased']=="1")
                                $rs=$model->updateFeeMasterStatus1($fs['fcid'],$fs['studentid'],$fs['cid'],$fs['gid'],$fs['fine'],$fs['discount'],$fs['concession']);
                        else
                                $rs=$model->updateFeeMasterStatus($fs['fcid'],$fs['studentid'],$fs['cid'],$fs['fine'],$fs['discount'],$fs['concession']);
                }

                if($status==false){
                        JError::raiseWarning(500,'Could not save record..');
                        $this->setRedirect($redirectTo,'Retry...');
                }else{
                        $this->setRedirect($redirectTo,'Fee Transaction has been Saved...');
                }
           }



	if($rtype==2){
                        foreach($fs['bala'] as $key=>$val){
                                list($pp_acid,$pp_fpid)=explode("$$",$key);
                                $sum[$pp_acid] = 0;
                        }
                        foreach($fs['bala'] as $key=>$val){
                                list($pp_acid,$pp_fpid)=explode("$$",$key);
                                $sum[$pp_acid] = $sum[$pp_acid]+ $val;
                        }
                        $faccs = $model->getFeeAccounts();
                        $count=0;
                        foreach($faccs AS $fac){
                                if($sum[$fac->id]>0){
                                        $nreceiptno=$fac->feeprefix.'-'.($fac->receiptno+1);
                                        $status = $model->addFeeTransaction($fs['fcid'],$fs['studentid'],$fs['cid'],$sum[$fac->id],$fs['paymentmode'],$fs['chequeorddno'],$cddate,$fs['bankdetails'],$nreceiptno,$obj);
                                        if($status){
                                                //Save Individual Particulars
                                                foreach($fs['bala'] as $key=>$val){
                                                        list($pp_acid,$pp_fpid)=explode("$$",$key);
                                                        if($pp_acid == $fac->id)
                                                                $rs=$model->addFeeTransactionParticular($obj->fctid,$pp_fpid,$val);
                                                }
                                                $model->setNewReceiptNo($fac->id,$fac->receiptno+1);
                                        }else{
                                                $model->setNewReceiptNo($fac->id,$fac->receiptno+1);
                                                $count++;
                                        }
                                }
                        }
                        if(($fs['balance']==$fs['paidnow']) ){
                                if($fs['gid']>0 && $fs['groupbased']=="1")
                                        $rs=$model->updateFeeMasterStatus1($fs['fcid'],$fs['studentid'],$fs['cid'],$fs['gid'],$fs['fine'],$fs['discount'],$fs['concession']);
                                else{
                                        $rs=$model->updateFeeMasterStatus($fs['fcid'],$fs['studentid'],$fs['cid'],$fs['fine'],$fs['discount'],$fs['concession']);
				}
                        }
                	if($count>0){
                        	JError::raiseWarning(500,$count.' Transactions failed...');
	                        $this->setRedirect($redirectTo,'Retry...');
        	        }else{
                	        $this->setRedirect($redirectTo,'Fee Transaction has been Saved...');
                	}
                }

	}


        function savefeeconcession(){
                $sc = JRequest::get('POST');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=feeconcession&courseid='.$sc['courseid'].'&Itemid='.$sc['Itemid'],false);
                $model = & $this->getModel('fees');
                $status = $model->addFeeConcession($sc['fcid'],$sc['studentid'],$sc['courseid'],$sc['amount']);
                if($status==false){
                        JError::raiseWarning(500,'Could not save record..');
                        $this->setRedirect($redirectTo,'Retry...');
                }else{
                        $this->setRedirect($redirectTo,'Fee Concession has been Saved...');
                }
        }


	function deleteconcession(){
                $courseid= JRequest::getVar('courseid');
                $Itemid = JRequest::getVar('Itemid');
                $conid= JRequest::getVar('conid');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=feeconcession&courseid='.$courseid.'&Itemid='.$Itemid,false);
                $model = & $this->getModel('fees');
                $status=$model->deleteFeeConcession($conid);
		if($status)
	                $this->setRedirect($redirectTo,'Deleted...');
		else
	                $this->setRedirect($redirectTo,'Could not delete...');
	}


	function cancelreceipt(){
                $rno= JRequest::getVar('rno');
                $fcid= JRequest::getVar('fcid');
                $cid= JRequest::getVar('cid');
                $studentid= JRequest::getVar('studentid');
                $Itemid = JRequest::getVar('Itemid');
   		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=fees&view=fees&layout=feesubmission&fcid='.$fcid.'&cid='.$cid.'&studentid='.$studentid.'&Itemid='.$Itemid);
                $model = & $this->getModel('fees');
                $status=$model->cancelReceipt($rno);
		if($status)
	                $this->setRedirect($redirectTo,'Cancelled...');
		else
	                $this->setRedirect($redirectTo,'Could not Cancel...');
	}


	function deletefeeaccount(){
                $accountid= JRequest::getVar('accountid');
                $Itemid = JRequest::getVar('Itemid');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=feeaccounts&Itemid='.$Itemid,false);
                $model = & $this->getModel('fees');
                $status=$model->deleteFeeAccount($accountid);
		if($status)
	                $this->setRedirect($redirectTo,'Deleted...');
		else
	                $this->setRedirect($redirectTo,'Could not delete...');
	}



  	function savefeeaccount(){
                $sc = JRequest::get('POST');
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=fees&controller=fees&task=display&layout=feeaccounts&Itemid='.$sc['Itemid'],false);
                $model = & $this->getModel('fees');
                if($sc['id']==-1){
                        $status = $model->addFeeAccount($sc['title'],$sc['code'],$sc['feeprefix'],$sc['receiptno']);
                }else{
                        $status = $model->updateFeeAccount($sc['id'],$sc['title'],$sc['code'],$sc['feeprefix'],$sc['receiptno']);
                }
                if($status==false){
                        JError::raiseWarning(500,'Could not save record..');
                        $this->setRedirect($redirectTo,'Retry...');
                }else{
                        $this->setRedirect($redirectTo,'Fee Account has been Saved...');
                }
        }


}
