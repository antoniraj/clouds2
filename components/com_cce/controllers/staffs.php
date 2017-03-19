<?php
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once('myfunctions.php');
 
jimport('joomla.application.component.controller');
require_once('helper.php'); 
 
class CCEControllerStaffs extends JController
{


    function display()
    {
	if(! Helper::checkuser()){ 
                	$redirectTo = JRoute::_('index.php?option=com_users?view=login',false);
        		$this->setRedirect($redirectTo,'Please Login First');
	}
	$view = JRequest::getVar('view');
        $task=JRequest::getVar('task');
	switch($view){
		case 'staffs':
			switch($task){
				case 'displayStaffs':
					$this->displayStaffs();
					break;
				case 'actions':
                        		$ids = JRequest::getVar('cid',null,'default','array');
                        		$form = JRequest::get('POST');
                                $validate = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=staffs&controller=staffs&layout=profile&task=display',false);
    
								if(count($form['cid']) == 0 AND !$form['Add'] AND !$form['import']){
										JError::raiseWarning(500,'Please select a record');
										$this->setRedirect($validate,'');
								}
								else if((count($form['cid']) > 1) AND (!$form['Delete']) AND !$form['Add']){
										JError::raiseWarning(500,'Please select any one of the record');
										$this->setRedirect($validate,'');
								}
								else{   		
                        		if($form['import'])
									$this->importRecords();
                        		if($form['Delete']) $this->removeStaff($ids,$form['Itemid']);
                        		if($form['Edit']){
                                		$redirectTo = 'index.php?option='.JRequest::getVar('option').'&view=addstaff&controller=staffs&task=edit&cid='.$ids[0].'&Itemid='.$form['Itemid'];
                                		$this->setRedirect($redirectTo,'');
                        		}
                        		if($form['Add']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=addstaff&controller=staffs&task=add&aid='.$form['aid'].'&Itemid='.$form['Itemid'],false);
                                		$this->setRedirect($redirectTo,'');
							}
							}
					break;
				default:
					$this->displayStaffs();
			}
			break;
		
		case 'addstaff':
                        $form = JRequest::get('POST');
			if($form['cancel']=='Cancel'){
                              $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=staffs&task=display&view=staffs&Itemid='.$form['Itemid'],false);
                              $this->setRedirect($redirectTo,'Staff');	
			      return;
			}
			switch($task)
			{
				case 'add':
					$this->addStaff();
					break;
				case 'edit':
					$this->editStaff();
					break;
				case 'save':
					$this->saveStaff();
					break;
				default:
					echo "No action has been defined for the view addstaff";
			}
			break;

		default:
			echo "No action has been defined for the view staffs";
	}

     }

    function displayStaffs()
    {
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'default');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	$model=& $this->getModel('cce');
	$model1=& $this->getModel('staffattendance');
	$model2=& $this->getModel('staffleave');
	$model3=& $this->getModel('schoolcal');
	if($model==true){
		$view->setModel($model,true);
		$view->setModel($model1);
		$view->setModel($model2);
		$view->setModel($model3);
	}
	$view->setLayout($viewLayout);
	$view->display();
    }
 
    function addStaff()
    {
	
        $document = JFactory::getDocument();
        $viewType = $document->getType();
        $viewName = JRequest::getCmd('view', $this->default_view);
        $viewLayout = JRequest::getCmd('layout', 'default');
        $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model = $this->getModel('cce');
        if($model==true){
              //Push the model into the view
                $view->setModel($model,true);
        }
        $view->setLayout($viewLayout);
        $view->display();
    }

        function editStaff()
        {
                //Read cid as an array
                $ids = JRequest::getVar('cid',null,'default','array');
                $document = JFactory::getDocument();
                $viewType = $document->getType();
                $viewName = JRequest::getCmd('view', $this->default_view);
                $viewLayout = JRequest::getCmd('layout', 'default');
                $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
                $model = & $this->getModel('cce');
                if($model==true){
                        //Push the model into the view
                        $view->setModel($model,true);
                }
                $view->setLayout($viewLayout);
                $view->displayEdit($ids[0]);
        }
   function staffprofile($staffid)
        {
                //Read cid as an array
               $document = JFactory::getDocument();
                $viewType = $document->getType();
                $viewName = JRequest::getCmd('view', $this->default_view);
                $viewLayout = JRequest::getCmd('layout', 'profile');
                $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
                $model = & $this->getModel('cce');
                if($model==true){
                        //Push the model into the view
                        $view->setModel($model,true);
                }
                $view->setLayout($viewLayout);
                $view->profile($staffid);
        }
	function addJoomlaUser($name, $username, $password, $email) {
      		jimport('joomla.user.helper');
		$salt   = JUserHelper::genRandomPassword(32);
		$crypted  = JUserHelper::getCryptedPassword($password, $salt);
		$cpassword = $crypted.':'.$salt;
                $model = & $this->getModel('cce');
		$gid = $model->getACLGroupID('Teacher');
      		$data = array(
          		"name"=>$name,
          		"username"=>$username,
          		"password"=>$password,
          		"password2"=>$password,
          		"email"=>$email,
          		"block"=>0,
          		"groups"=>array($gid)
      		);
     	 	$user = new JUser;
      		//Write to database
      		if(!$user->bind($data)) {
          		throw new Exception("Could not bind data. Error: " . $user->getError());
      		}
      		if (!$user->save()) {
          		throw new Exception("Could not save user. Error: " . $user->getError());
      		}
		return $user->id;
	}


    function go()
    {
		 $data = JRequest::get('post');
		 	$staffid=JRequest::getVar('staffid');
		 	$layout=JRequest::getVar('layout');
		 if($layout=='leave')
		 {
		 if(!$staffid)
		 {
			 	$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=staffs&layout=leave&controller=staffs&task=display&Itemid='.$Itemid,false);
				JError::raiseWarning(500,'Please select any Staff..');
				$this->setRedirect($redirectTo,'');
				return;
		 }
		}
        $document = JFactory::getDocument();
        $viewType = $document->getType();
        $viewName = JRequest::getCmd('view', $this->default_view);
        $viewLayout = JRequest::getCmd('layout', 'default');
        $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model=& $this->getModel('cce');
        $model1=& $this->getModel('staffattendance');
        $model2=& $this->getModel('staffleave');
        $model3=& $this->getModel('schoolcal');
        if($model==true){
                $view->setModel($model,true);
                $view->setModel($model1);
                $view->setModel($model2);
                $view->setModel($model3);
        }
        $view->setLayout($viewLayout);
        $view->display();
    }


  function saveabsentees()
    {
        $data = JRequest::get('post');
        $cdate= JRequest::getVar('cdate');
        $Itemid= $data['Itemid'];
        //$courseid = JRequest::getVar('courseid');
        $Itemid= JRequest::getVar('Itemid');
        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=staffs&Itemid='.$Itemid.'&view=staffs&task=go&layout=attendance&cdate='.$cdate.'&session='.$data['session'],false);
        $model = & $this->getModel('staffattendance');
        $a = explode('-',$cdate);
        $c1date=$a[2]."-".$a[1]."-".$a[0];
        $s=$model->deleteStaffAbsentees($c1date,$data['session']);
		$presents=$model->getstaffpresent(JArrayHelper::mysqlformat($cdate),$data1);
		if(!$data1)
		{
		$status=$model->addstaffpresent(JArrayHelper::mysqlformat($cdate));
		}        
        
        foreach($data['sids'] as $sid){
                if(! in_array($sid,$data['present']) || count($data['present'])==0)
                        $r=$model->addStaffAbsentee($c1date,$sid,$data['session']);
			
        }
        $this->setRedirect($redirectTo,'Absentees saved...');
    }


      function staffimage($staffid,$scode)
	{
       $staff = JRequest::get('POST');
		define ("MAX_SIZE","9000"); 
		$model = & $this->getModel('cce');
		  $valid_formats = array("jpg", "png", "gif", "bmp","jpeg");
		//Retrieve file details from uploaded file
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=students&task=add'.'&view=addstudent&courseid='.$cid.'&Itemid='.$form['Itemid'],false);
		if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") 
		{

		foreach ($_FILES['photos']['name'] as $name => $value)
		{
        $filename = stripslashes($_FILES['photos']['name'][$name]);
        $size=filesize($_FILES['photos']['tmp_name'][$name]);
        //get the extension of the file in a lower case format
         $i = strrpos($filename,".");
         if (!$i) { return ""; }
         $l = strlen($filename) - $i;
         $ext = substr($filename,$i+1,$l);
          $ext = strtolower($ext);
     	$uploaddir = "components/com_cce/staffphoto/";
	   	$model->getsiglestaffphoto($staffid,$file);
	   	$path=$file->scode.'.'.$file->extention;
	   	$imagepath=$uploaddir.$path;
	   	unlink($imagepath);
	    $model->updatesinglestaffphoto($staffid);
	
         if(in_array($ext,$valid_formats))
         {
	       if ($size < (MAX_SIZE*1024))
	       {
		   $image_name=$scode.'.'.$ext;
		   $newname=$uploaddir.$image_name;
           if (move_uploaded_file($_FILES['photos']['tmp_name'][$name], $newname)) 
           {
	       $time=time();
	       $s=$model->savestaffphoto($image_name,$scode,$staffid,$ext,$time);
	       }
	      else
	       {
			   $this->setRedirect($redirectTo,' You have exceeded the size limit! so moving unsuccessful!');
			   return 0;
	         }

	       }
		   else
		   {
			     $this->setRedirect($redirectTo,' You have exceeded the size limit!');
						return 0;
          
	       }
       
          }
          else
         { 
			 $this->setRedirect($redirectTo,'Unknown Extension!');
						
				return 0;
           
	     }
           
     }
	}
			
	}
          //For insert and update
        function saveStaff()
        {

                $staff = JRequest::get('POST');
                //Retrieve file details from uploaded file
                $file = JRequest::getVar('photos', null, 'files', 'array');
			  	$danger = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=addstaff&controller=staffs&task=add&aid='.$form['aid'].'&Itemid='.$form['Itemid'],false);
   $success = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=staffs&controller=staffs&task=display&cid='.$staffid.'&Itemid='.$staff['Itemid'],false);
   
                $model = & $this->getModel('cce');
				if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$staff['email']))
  			{
  				  			JError::raiseWarning(500,'Invalid Email Format');
                        $this->setRedirect($danger,'');
						return;
  			}
  			$model->getusers($users);
			foreach($users as $user)
			{
			    $storeduser[]=$user->email;
			}
				

                if($staff['id']){
                        $status = $model->updateStaff($staff['id'],$staff['hprefix'],$staff['staffcode'],$staff['firstname'],$staff['middlename'],$staff['lastname'],JArrayHelper::mysqlformat($staff['dob']),$staff['gender'],$staff['bloodgroup'],JArrayHelper::mysqlformat($staff['doj']),$staff['nationality'],$staff['qualification'],$staff['jobtitle'],$staff['department'],$staff['category'],$staff['position'],$staff['grade'],$staff['experienceinfo'],$staff['totalexperience'],$staff['status'],$staff['maritalstatus'],$staff['fathername'],$staff['mothername'],$staff['addressline1'],$staff['addressline2'],$staff['city'],$staff['state'],$staff['pincode'],$staff['country'],$staff['phone'],$staff['mobile'],$staff['email']);
			if($status){
				$staffid=$staff['id'];

				  $uploadstatus=$this->staffimage($staff['id'],$staff['staffcode']);
			}
                }else{
			   if (in_array($staff['email'], $storeduser))
				{
						JError::raiseWarning(500,'This Email is alreay available');
                        $this->setRedirect($danger,'');
                        return;
				}
                        $status = $model->addStaff($staff['hprefix'],$staff['staffcode'],$staff['firstname'],$staff['middlename'],$staff['lastname'],JArrayHelper::mysqlformat($staff['dob']),$staff['gender'],$staff['bloodgroup'],JArrayHelper::mysqlformat($staff['doj']),$staff['nationality'],$staff['qualification'],$staff['jobtitle'],$staff['department'],$staff['category'],$staff['position'],$staff['grade'],$staff['experienceinfo'],$staff['totalexperience'],$staff['status'],$staff['maritalstatus'],$staff['fathername'],$staff['mothername'],$staff['addressline1'],$staff['addressline2'],$staff['city'],$staff['state'],$staff['pincode'],$staff['country'],$staff['phone'],$staff['mobile'],$staff['email']);
						
			if($status){
				$staffid=$status;
	          $uploadstatus=$this->staffimage($status,$staff['staffcode']);
			  	$users=$this->addJoomlaUser($staff['firstname'],$staff['staffcode'],$staff['staffcode'],$staff['email']);

		       	}
		
                }
                
                if(!$status){
                        JError::raiseWarning(500,'Could not save record');
                        $this->setRedirect($danger,'');
                }else{
                        $this->setRedirect($success,'Staff deatails have been Saved');
                }
        }

        function removeStaff($ids=null,$Itemid)
        {
              
                $model = & $this->getModel('cce');
                $status=$model->deleteStaff($ids);
                $deldir = "components/com_cce/staffphoto/";
                foreach($ids as $id)
                {
					$model->getsiglestaffphoto($id,$file);
					$path=$file->scode.'.'.$file->extention;
					$imagepath=$deldir.$path;
					unlink($imagepath);
                
				}
                $model->deletestaffphoto($ids);
				$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=staffs&controller=staffs&task=display&Itemid='.$Itemid,false);
                if($status==true)
                        $this->setRedirect($redirectTo,'Record has been deleted!');
                else
                       	JError::raiseWarning(500,'Could not delete Record');
						$this->setRedirect($redirectTo,'');
        }

	function importRecords(){
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=staffs&controller=staffs&task=display&Itemid='.$Itemid,false);
		$Itemid= JRequest::getVar('Itemid');
		//Retrieve file details from uploaded file, sent from upload form
		$file = JRequest::getVar('recs', null, 'files', 'array');
		if(!$file['name'])
		{
			JError::raiseWarning(500,'Please select a file first');
        	$this->setRedirect($redirectTo,'');
        	return;
		}
		//Import filesystem libraries. Perhaps not necessary, but does not hurt
		jimport('joomla.filesystem.file');
		//Clean up filename to get rid of strange characters like spaces etc
		$filename = JFile::makeSafe($file['name']);
		//Set up the source and destination of the file
		$src = $file['tmp_name'];
		$dest = JPATH_COMPONENT . DS . "uploads" . DS . $filename;
		//First check if the file has the right extension, we need csv only
		if ( strtolower(JFile::getExt($filename) ) == 'csv') {
   			if ( JFile::upload($src, $dest) ) {
      				//Redirect to a page of your choice
				$fh = fopen($dest,'r');//read the contents of the file
				$heading = fgetcsv($fh);//remove the heading
				$model = & $this->getModel('cce');
				while (! feof($fh)){
					$staff=fgetcsv($fh);
					if(feof($fh)) break;
                        		$status = $model->addStaff($staff[0],$staff[1],$staff[2],$staff[3],$staff[4],JArrayHelper::mysqlFormat($staff[5]),$staff[6],$staff[7],JArrayHelper::mysqlFormat($staff[8]),$staff[9],$staff[10],$staff[11],$staff[12],$staff[13],$staff[14],$staff[15],$staff[16],$staff[17],$staff[18],$staff[19],$staff[20],$staff[21],$staff[22],$staff[23],$staff[24],$staff[25],$staff[26],$staff[27],$staff[28],$staff[29],$staff['30']);
				}
   			} else {
      				//Redirect and throw an error message
				echo "Move failed";
   			}
		} else {
			JError::raiseWarning(500,'Wrong file type');
        	$this->setRedirect($redirectTo,'');
        	return;
   			//Redirect and notify user file is not right extension
		}
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=staffs&controller=staffs&task=display&Itemid='.$Itemid,false);
		$this->setRedirect($redirectTo,'Staff file has been Imported Successfully');
	}

	function getdepartmentwiseattendancereport()
	{
        	$Itemid= JRequest::getVar('Itemid');
        	$cdate= JRequest::getVar('cdate');
        	$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=staffs&Itemid='.$Itemid.'&view=staffs&layout=rattendance&cdate='.$cdate,false);
        	$this->setRedirect($redirectTo,'');
	}

    function saveleave()
    {
        $data = JRequest::get('post');
        $Itemid= $data['Itemid'];
        $staffid = $data['staffid'];
        $fromdate = $data['fromdate'];
        $todate = $data['todate'];
        $Itemid= JRequest::getVar('Itemid');
        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=staffs&Itemid='.$Itemid.'&go=go&view=staffs&layout=leave&task=go&staffid='.$staffid.'&fdate='.$fromdate.'&todate='.$todate,false);
        $model = & $this->getModel('staffleave');
        $r=$model->deleteStaffLeave($fromdate,$todate,$staffid);
        foreach($data['lrec'] as $lrec){
                list($lid,$sid,$cdate,$ses) = explode(':',$lrec);
                $r=$model->addStaffLeave($cdate,$sid,$ses,$data['reason']);
        }
        $this->setRedirect($redirectTo,'Staff Leave Saved');
    }

}

