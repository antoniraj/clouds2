<?php
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once('myfunctions.php');
jimport('joomla.application.component.controller');
require_once('helper.php'); 
 
class CCEControllerStudents extends JController
{

    function display()
    {
	if(! Helper::checkuser()){ 
                	$redirectTo = JRoute::_('index.php?option=com_users?view=login',false);
        		$this->setRedirect($redirectTo,'Please Login...');
	}
	$view = JRequest::getVar('view');
        $task = JRequest::getVar('task');
	$courseid = JRequest::getVar('courseid');
	$Itemid= JRequest::getVar('Itemid');
	switch($view){
		case 'students':
        		switch($task)
        		{
                		case 'displayStudents':
                        		$this->displayStudents($courseid);
     	               			break;
				case 'actions':
                        		$ids = JRequest::getVar('cid',null,'default','array');
                        		$form = JRequest::get('POST');
								$validate = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=students&controller=students&courseid='.$form['courseid'].'&task=display&Itemid='.$Itemid,false);             		
                    		if($form['import']){
								$this->importRecords();
								}else
                        		if($form['go']){
						// $this->displayStudents($form['courses']);
						$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=students&controller=students&courseid='.$form['courses'].'&Itemid='.$form['Itemid'].'&start='.JRequest::getVar('limitstart'),false);
                                                $this->setRedirect($redirectTo,'');

					}else
                        		if($form['Delete']) $this->removeStudent($ids,$form['Itemid']);
                        		else if($form['Edit']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=addstudent&controller=students&check=2&courseid='.$form['courses'].'&task=edit&cid='.$ids[0].'&Itemid='.$form['Itemid'],false);
                                		$this->setRedirect($redirectTo,'');
                        		}else
                        		if($form['Add']){
                                		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=students&task=add'.'&view=addstudent&courseid='.$form['courses'].'&Itemid='.$form['Itemid'],false);
                                		$this->setRedirect($redirectTo,'');	
					}else 
                        		if($form['View']){ //Profile View
						if($ids){
							$link = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=studentprofile&controller=studentprofile&layout=profile&courseid='.$form['courses'].'&Itemid='.$form['Itemid'].'&id='.$ids[0],false);
                                			$redirectTo = JRoute::_($link,false);
						}else{
                                                	$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=students&controller=students&courseid='.$ciid.'&Itemid='.$form['Itemid'].'&start='.JRequest::getVar('limitstart').'&limit='.JRequest::getVar('limit'),false);
							JError::raiseWarning(500,'Please select a record');
						}
	                                	$this->setRedirect($redirectTo,'');	
					}else 
					if($form['TC']){ //TC Edit and Print
                                                if($ids){
                                                        $tclink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=studentprofile&controller=studentprofile&layout=tc&courseid='.$form['courses'].'&Itemid='.$form['Itemid'].'&id='.$ids[0],false);
                                                        $redirectTo = JRoute::_($tclink,false);
                                                }else{
                                                        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=students&controller=students&courseid='.$ciid.'&Itemid='.$form['Itemid'].'&start='.JRequest::getVar('limitstart').'&limit='.JRequest::getVar('limit'),false);
                                                        JError::raiseWarning(500,'Please select a record');
                                                }
                                                $this->setRedirect($redirectTo,'');
                                        }else
                                        if($form['Conduct']){ //TC Edit and Print
                                                if($ids){
                                                        $cclink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=studentprofile&controller=studentprofile&layout=conductcertificate&courseid='.$form['courses'].'&Itemid='.$Itemid.'&id='.$ids[0],false);
                                                        $redirectTo = JRoute::_($cclink,false);
                                                }else{
                                                        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=students&controller=students&courseid='.$ciid.'&Itemid='.$form['Itemid'].'&start='.JRequest::getVar('limitstart').'&limit='.JRequest::getVar('limit'),false);
                                                        JError::raiseWarning(500,'Please select a record');
                                                }
                                                $this->setRedirect($redirectTo,'');
                                        }else
                                        if($form['Attendance']){ //Attendance Edit and Print
                                                if($ids){
                                                        $aclink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=studentprofile&controller=studentprofile&layout=attendancecertificate&courseid='.$form['courses'].'&Itemid='.$form['Itemid'].'&id='.$ids[0],false);
                                                        $redirectTo = JRoute::_($aclink,false);
                                                }else{
                                                        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=students&controller=students&courseid='.$ciid.'&Itemid='.$form['Itemid'].'&start='.JRequest::getVar('limitstart').'&limit='.JRequest::getVar('limit'),false);
                                                        JError::raiseWarning(500,'Please select a record');
                                                }
                                                $this->setRedirect($redirectTo,'');
					}else
                                        if($form['Bonafide']){ //Bonafide Edit and Print
                                                if($ids){
                                                        $bclink = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=studentprofile&controller=studentprofile&layout=bonafiedcertificate&courseid='.$form['courses'].'&Itemid='.$form['Itemid'].'&id='.$ids[0],false);
                                                        $redirectTo = JRoute::_($bclink,false);
                                                }else{
                                                        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=students&controller=students&courseid='.$ciid.'&Itemid='.$form['Itemid'].'&start='.JRequest::getVar('limitstart').'&limit='.JRequest::getVar('limit'),false);
                                                        JError::raiseWarning(500,'Please select a record');
                                                }
                                                $this->setRedirect($redirectTo,'');
                                        }else{
						$ciid=($form['courses'])?$form['courses']:$courseid;
                                                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=students&controller=students&courseid='.$ciid.'&Itemid='.$form['Itemid'].'&start='.JRequest::getVar('limitstart').'&limit='.JRequest::getVar('limit'),false);
                                                $this->setRedirect($redirectTo,'Please select a record to perform any operation..');

					}
					break;
				case 'excel':

                                        $this->displayexcel($courseid);
                                        break;

				default:
                        		$this->displayStudents($courseid);
			}
			break;
		case 'addstudent':
                        $form = JRequest::get('POST');
			if($form['Cancel']=='Cancel'){
                              $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=students&task=display&view=students&courseid='.$form['courseid'].'&Itemid='.$form['Itemid'],false);
                              $this->setRedirect($redirectTo,'Students');	
				return;
			}
			switch($task)
			{
				case 'add':
					$this->addStudent();
					break;
				case 'edit':
					$this->editStudent();
					break;
				case 'redirect':
					$sid= JRequest::getVar('sid');
					$cid= JRequest::getVar('cid');
					$this->deletestudentphoto($sid);
					break;
				case 'redirectto':
					$sid= JRequest::getVar('sid');
					$this->redirecttoedit($sid);
					break;
				case 'save':
					$this->saveStudent();
					break;
				default:
					echo "ERROR";
			}
			break;
		default:
			echo "ERROR";
	}

     }

    function displayexcel($courseid=null)
    {
    // return JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
        $document = JFactory::getDocument();
        $viewType = $document->getType();
        $viewName = JRequest::getCmd('view', $this->default_view);
        $layoutName= JRequest::getCmd('layout', 'excel');
        $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model=& $this->getModel('cce');
        if($model==true){
                $view->setModel($model,true);
        }
        $view->setLayout($layoutName);
        $view->display($courseid);
    }




    function displayStudents($courseid=null)
    {
    // return JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'default');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	$model=& $this->getModel('cce');
	if($model==true){
		$view->setModel($model,true);
	}
	$view->setLayout($layoutName);
	$view->display($courseid);
    }

 
    function addStudent()
    {
	 //Read courseid as an array
        $courseid = JRequest::getVar('courseid');
        $Itemid = JRequest::getVar('Itemid');
        if(($courseid=='--Select a Course--')||(!$courseid)){
        	//Make sure the courseid parameter was in the request
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=students&controller=students&courseid='.JRequest::getVar('courseid').'&task=display&Itemid='.$Itemid,false);
                $this->setRedirect($redirectTo,'Please select the course/class');
                return;
        }

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

    function editStudent()
    {
		//Read cid as an array
		$ids = JRequest::getVar('cid',null,'default','array');
		if(!$ids[0]){
			   	$validate = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=students&controller=students&courseid='.$form['courseid'].'&task=display&Itemid='.$Itemid,false);
				JError::raiseWarning(500,'Please select a record');
				$this->setRedirect($validate,'');
				return;
		}
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

  function redirecttoedit($sid)
    {
		//Read cid as an array
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
		$view->displayEdit($sid);
	}


                //For insert and update
                
                        

	function studentimage($sid,$rno,$cid)
	{

		define ("MAX_SIZE","2000"); 
		$model = & $this->getModel('cce');
		  $valid_formats = array("jpg", "JPG","JPEG","PNG","GIF","png", "gif","jpeg");
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
     	  	   	$uploaddir = "components/com_cce/studentsphoto/";
	   	$model->getsiglestudentphoto($sid,$file);
	   	$path=trim($file->imagename);
	   	$imagepath=$uploaddir.$path;
		if($file->imagename!='no-image.gif')
	   		unlink($imagepath);
	    $model->updatesinglestudentphoto($sid);
         if(in_array($ext,$valid_formats))
         {
	       if ($size < (MAX_SIZE*1024))
	       {
		   $image_name=$rno.'.'.$ext;
		   $newname=$uploaddir.$image_name;
           if (move_uploaded_file($_FILES['photos']['tmp_name'][$name], $newname)) 
           {
	       $time=time();
	       $s=$model->savephoto($image_name,$sid,$rno,$time);
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
	           
	function saveStudent()
	{
		$student = JRequest::get('POST');
		$Itemid=JRequest::getVar('Itemid');
		$model = & $this->getModel('cce');	
		  $file = JRequest::getVar('photos', null, 'files', 'array');
		if($student['id']){

			$status = $model->updateStudent($student['id'],$student['registerno'],$student['ano'],JArrayHelper::mysqlformat($student['adate']),$student['admittedclass'],$student['firstname'],$student['middlename'],$student['lastname'],JArrayHelper::mysqlformat($student['dob']),$student['gender'],$student['bloodgroup'],$student['birthplace'],$student['nationality'],$student['mothertongue'],$student['caste'],$student['religion'],$student['addressline1'],$student['addressline2'],$student['city'],$student['state'],$student['pincode'],$student['country'],$student['fathername'],$student['phone'],$student['mobile'],$student['email'],$student['focc'],$student['mothername'],$student['mphone'],$student['mmobile'],$student['memail'],$student['mocc'],$student['gname'],$student['gphone'],$student['gmobile'],$student['gocc'],$student['smsto'],$student['categoryid'],$student['idmark'],$student['idmark2'],$student['aadharno'],$student['medium'],$student['lang1'],$student['lang2'],$student['lang3'],$student['studentas'],$student['community'],$student['modeoftransport'],$student['passportno'],$student['disability'],$student['disadvantagedgroup'],JArrayHelper::mysqlformat($student['fdob']),$student['fincome'],JArrayHelper::mysqlformat($student['mdob']),$student['mincome'],$student['emergency']);
		  	if($status){
				if($file)
				{
				  $uploadstatus=$this->studentimage($student['id'],$student['id'],$student['courseid']);
				}	
		  $stid=$student['id'];		
			}
		}else{
			$status = $model->addStudent($student['registerno'],$student['ano'],JArrayHelper::mysqlformat($student['adate']),$student['admittedclass'],$student['firstname'],$student['middlename'],$student['lastname'],JArrayHelper::mysqlformat($student['dob']),$student['gender'],$student['bloodgroup'],$student['birthplace'],$student['nationality'],$student['mothertongue'],$student['caste'],$student['religion'],$student['addressline1'],$student['addressline2'],$student['city'],$student['state'],$student['pincode'],$student['country'],$student['fathername'],$student['phone'],$student['mobile'],$student['email'],$student['focc'],$student['mothername'],$student['mphone'],$student['mmobile'],$student['memail'],$student['mocc'],$student['gname'],$student['gphone'],$student['gmobile'],$student['gocc'],$student['smsto'],$student['idmark'],$student['idmark2'],$student['aadharno'],$student['categoryid'],$student['medium'],$student['lang1'],$student['lang2'],$student['lang3'],$student['studentas'],$student['community'],$student['modeoftransport'],$student['passportno'],$student['disability'],$student['disadvantagedgroup'],JArrayHelper::mysqlformat($student['fdob']),$student['fincome'],JArrayHelper::mysqlformat($student['mdob']),$student['mincome'],$student['emergency'],$student['courseid']);

		 	if($status){
				$us=$this->studentimage($status,$student['id'],$student['courseid']);		     
				$studentid=$status;
				
			}
		  $stid=$status;
		}
         $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=students&task=redirectto&view=students&courseid='.$student['courseid'].'&sid='.$stid.'&Itemid='.$Itemid,false);
  	
     	if($status==false){
		JError::raiseWarning(500,'Could not save record');
        	$this->setRedirect($redirectTo,'');
		}else{
			$this->setRedirect($redirectTo,'Record has been Saved');
		}
	}

   
	function removeStudent($ids=null,$Itemid) {
                $form = JRequest::get('POST');
		//Read cid as an array
		if(!$ids[0]){
			   	$validate = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=students&controller=students&courseid='.$form['courseid'].'&task=display&Itemid='.$Itemid,false);
				JError::raiseWarning(500,'Please select a record');
				$this->setRedirect($validate,'');
				return;
		}
		$model = & $this->getModel('cce');
		$status=$model->deleteStudent($ids);
		        $deldir = "components/com_cce/studentsphoto/";
                foreach($ids as $id)
                {
					$model->getsiglestudentphoto($id,$file);
					$path=trim($file->imagename);
					$imagepath=$deldir.$path;
					if($file->imagename!='no-image.gif')
						unlink($imagepath);
                
				}
                $model->deletestudentPhotos($ids);
	$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=students&controller=students&courseid='.$form['courseid'].'&task=display&Itemid='.$Itemid,false);
		if($status==true)
		    {
					$this->setRedirect($redirectTo,'You have successfully deleted the record');
		}
		else
		{
			JError::raiseWarning(500,'Could not delete record');
        	$this->setRedirect($redirectTo,'');
		}
	}

function deletestudentphoto($sid)
	{
	       $deldir = "components/com_cce/studentsphoto/";
	        $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&controller=students&task=redirectto&view=addstudent&sid='.$sid.'&Itemid='.$form['Itemid'],false);
  			$model = & $this->getModel('cce');
  			$model->getsiglestudentphoto($sid,$file);
			$path=trim($file->imagename);
			$imagepath=$deldir.$path;
			if($file->imagename!='no-image.gif')
		    		unlink($imagepath);
			$status=$model->updatesinglestudentphoto($sid);
			if($status==true)
		    	{
					$this->setRedirect($redirectTo,'Student photo has been Deleted!');
			}
			else
			{
				JError::raiseWarning(500,'Could not delete Photo!');
				$this->setRedirect($redirectTo,'');
			}
	}

	function importRecords(){
			$Itemid= JRequest::getVar('Itemid');
		$courseid= JRequest::getVar('courseid');
		$redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=students&controller=students&courseid='.$courseid.'&task=display&Itemid='.$Itemid,false);

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
		//First check if the file has the right extension, we need jpg only
		if ( strtolower(JFile::getExt($filename) ) == 'csv') {
   			if ( JFile::upload($src, $dest) ) {
      				//Redirect to a page of your choice
				$fh = fopen($dest,'r');//read the contents of the file
				$heading = fgetcsv($fh);//remove the heading
				$model = & $this->getModel('cce');
				$i=0;
				while (! feof($fh)){
					$student=fgetcsv($fh);
					if(feof($fh)) break;
				    	$status[] = $model->addStudent(
						$student[0], 						//Register No
						$student[1],						//Admission No
						JArrayHelper::mysqlformat(trim($student[2])),		//Admission DATE
						$student['3'],						//admitted class
						$student['4'],						//Student Name
						$student['5'],						//Middle Name
						$student['6'],						//Last Name
						JArrayHelper::mysqlformat(trim($student[7])),		//DOB
						$student['8'],						//Gender
						$student['9'],						//Blood Group
						$student['10'],						//Birth Place
						$student['11'],						//Nationality
						$student['12'],						//Mother Tongue
						$student['13'],						//Caste
						$student['14'],						//Religion
						$student['15'],						//Address Line1
						$student['16'],						//Address Line2
						$student['17'],						//City
						$student['18'],						//State
						$student['19'],						//Pin Code
						$student['20'],						//Country
						$student['21'],						//Father name
						$student['22'],						//Father phone
						$student['23'],						//Father mobile
						$student['24'],						//Father email
						$student['25'],						//father occ
						$student['26'],						//Mother name
						$student['27'],						//mother phone
						$student['28'],						//mother mobile
						$student['29'],						//mother email
						$student['30'],						//mother occ
						$student['31'],						//Gar name
						$student['32'],						//Gar phone
						$student['33'],						//Gar mobile
						$student['34'],						//Gar email
						$student['35'],						//Gar occ
						$student['36'],						//Identification Mark
						$student['37'],						//Identification Mark2
						$student['38'],						//Aadhar No
						$student['39'],						//Category id
						$student['40'],						//Medium
						$student['41'],						//Lang1
						$student['42'],						//Lang2
						$student['43'],						//Lang3
						$student['44'],						//Studentas
						$student['45'],						//Community
						$student['46'],						//Mode of Transport
						$student['47'],						//Passport No
						$student['48'],						//Disability
						$student['49'],						//Disadvantaged Group
						JArrayHelper::mysqlformat(trim($student[50])),		//FDOB
						$student['51'],						//F ICOME
						JArrayHelper::mysqlformat(trim($student[52])),		//MDOB
						$student['53'],						//M INCOME
						$student['54'],						//Emergency Contact
						$courseid						//Courseid
					);	
					if($status[$i] AND $student[0])
					{
						 $time=date('d-m-y h:s:A');
						 $imagename=trim($student[35]);
						 $s=$model->savephoto($student[0],$status[$i],$student[0],$time);
					}
					$i++;
				}
   			} else {
      				//Redirect and throw an error message
				JError::raiseWarning(500,'Failed to Move');
		        	$this->setRedirect($redirectTo,'');
        			return;
   			}
		} else {
			JError::raiseWarning(500,'Wrong file type');
        		$this->setRedirect($redirectTo,'');
	        	return;
   			//Redirect and notify user file is not right extension
		}

		if($status[0])
		{
			$this->setRedirect($redirectTo,'Student records has been Imported');
		}else{
			JError::raiseWarning(500,'Sorry, Could not Import');
			$this->setRedirect($redirectTo,'');

		}

	}




       function importRecords1(){
             	//import joomlas filesystem functions, we will do all the filewriting with joomlas functions,
             	//so if the ftp layer is on, joomla will write with that, not the apache user, which might
             	//not have the correct permissions
             	jimport('joomla.filesystem.file');
             	jimport('joomla.filesystem.folder');
              
             	//this is the name of the field in the html form, filedata is the default name for swfupload
             	//so we will leave it as that
            	$fieldName = 'recs';
             	//any errors the server registered on uploading
             	$fileError = $_FILES[$fieldName]['error'];
             	if ($fileError > 0) 
             	{
                     	switch ($fileError) 
                     	{
             		        case 1:
             			        echo JText::_( 'FILE TO LARGE THAN PHP INI ALLOWS' );
             			        return;	
              
             		        case 2:
             			        echo JText::_( 'FILE TO LARGE THAN HTML FORM ALLOWS' );
             			        return;
              
             		        case 3:
             			        echo JText::_( 'ERROR PARTIAL UPLOAD' );
             			        return;
              
             		        case 4:
             			        echo JText::_( 'ERROR NO FILE' );
             			        return;
             	        }
             	}
              
             	//check for filesize
             	$fileSize = $_FILES[$fieldName]['size'];
             	if($fileSize > 2000000)
             	{
             	    echo JText::_( 'FILE BIGGER THAN 2MB' );
             	}
             	echo $fieldName; 
             	//check the file extension is ok
             	$fileName = $_FILES[$fieldName]['name'];
             	$uploadedFileNameParts = explode('.',$fileName);
             	$uploadedFileExtension = array_pop($uploadedFileNameParts);
             	echo $fileName; 
             	$validFileExts = explode(',', 'jpeg,jpg,png,gif');
             	//$validFileExts = explode(',', 'jpeg,jpg,png,gif');
              
             	//assume the extension is false until we know its ok
             	$extOk = false;
              
             	//go through every ok extension, if the ok extension matches the file extension (case insensitive)
             	//then the file extension is ok
		print_r($validFileExts);
		echo $uploadedFileExtension;
             	foreach($validFileExts as $key => $value)
             	{
             	        if( preg_match("/$value/i", $uploadedFileExtension ) )
                     	{
             	                $extOk = true;
                     	}
             	}
              
             	if ($extOk == false) 
             	{
             	        echo JText::_( 'INVALID EXTENSION' );
                     	return;
             	}
              
             	//the name of the file in PHP's temp directory that we are going to move to our folder
             	$fileTemp = $_FILES[$fieldName]['tmp_name'];
              
             	//for security purposes, we will also do a getimagesize on the temp file (before we have moved it 
             	//to the folder) to check the MIME type of the file, and whether it has a width and height
             	$imageinfo = getimagesize($fileTemp);
              
             	//we are going to define what file extensions/MIMEs are ok, and only let these ones in (whitelisting), rather than try to scan for bad
             	//types, where we might miss one (whitelisting is always better than blacklisting) 
             	$okMIMETypes = 'image/jpeg,image/pjpeg,image/png,image/x-png,image/gif';
             	$validFileTypes = explode(",", $okMIMETypes);           
              
             	//if the temp file does not have a width or a height, or it has a non ok MIME, return
             	if( !is_int($imageinfo[0]) || !is_int($imageinfo[1]) ||  !in_array($imageinfo['mime'], $validFileTypes) )
             	{
             	        echo JText::_( 'INVALID FILETYPE' );
                     	return;
             	}
              
             	//lose any special characters in the filename
             	$fileName = preg_replace("/[^A-Za-z0-9]/i", "-", $fileName);
              
             	//always use constants when making file paths, to avoid the possibilty of remote file inclusion
             	$uploadPath = JPATH_SITE.DS.'images'.DS.'stories'.DS.$fileName;
              
             	if(!JFile::upload($fileTemp, $uploadPath)) 
             	{
                     	echo JText::_( 'ERROR MOVING FILE' );
             	        return;
             	}
             	else
             	{
             	   	// success, exit with code 0 for Mac users, otherwise they receive an IO Error
                		exit(0);
             	}
             
             }
             
}

