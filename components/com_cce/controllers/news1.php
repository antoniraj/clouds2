<?php
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
 
require_once('helper.php'); 
/**
 */
class CCEControllerNews extends JController
{
    function display()
    {
	if(! Helper::checkuser()){ 
                	$redirectTo = JRoute::_('index.php?option=com_users?view=login',false);
        		$this->setRedirect($redirectTo,'Please Login...');
	}else{
		$document = JFactory::getDocument();
		$viewType = $document->getType();
		$viewName = JRequest::getCmd('view', $this->default_view);
		$viewLayout = JRequest::getCmd('layout', 'default');
		$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
		$model=& $this->getModel('news');
		if($model==true){
			$view->setModel($model,true);
		}
		$view->setLayout($viewLayout);
		$view->display();
    	}
    }

    function settopnews()
    {
	$document = JFactory::getDocument();
	$viewType = $document->getType();
	$viewName = JRequest::getCmd('view', $this->default_view);
	$viewLayout = JRequest::getCmd('layout', 'default');
	$view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
	$model=& $this->getModel('news');
	$model1=& $this->getModel('cce');
	if($model==true){
		$view->setModel($model,true);
		$view->setModel($model1);
	}
	$view->setLayout($viewLayout);
	$view->display();
    }


    function updatetopnews()
    {
                $topnews = JRequest::get('POST');
		$topnews['newstext']=JRequest::getVar( 'newstext', '', 'post', 'string', JREQUEST_ALLOWHTML );
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=topnews&controller=news&layout=topnews&task=settopnews&Itemid='.$topnews['Itemid'],false);
                $model = & $this->getModel('news');
                if($topnews['id']){
                        $status = $model->updateTopNews($topnews['id'],$topnews['newstext']);
                }else{
                        $status = $model->saveTopNews($topnews['newstext']);
                }
                if($status==false){
                        JError::raiseWarning(500,'Could not save record..');
                        $this->setRedirect($redirectTo,'Retry...');
                }else{
                        $this->setRedirect($redirectTo,'Top News Saved...');
                }
    }

    function setsidebarnews()
    {
        $document = JFactory::getDocument();
        $viewType = $document->getType();
        $viewName = JRequest::getCmd('view', $this->default_view);
        $viewLayout = JRequest::getCmd('layout', 'default');
        $view = $this->getView($viewName, $viewType, '', array('base_path' =>$this->basePath, 'layout' => $viewLayout));
        $model=& $this->getModel('news');
        if($model==true){
                $view->setModel($model,true);
        }
        $view->setLayout($viewLayout);
        $view->display();
    }

    function updatesidebarstudentnews()
    {
                $news = JRequest::get('POST');
		$news['newstext1']=JRequest::getVar( 'newstext1', '', 'post', 'string', JREQUEST_ALLOWHTML );
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=studentnews&controller=news&layout=sidenews&task=setsidebarnews&Itemid='.$news['Itemid'],false);
                $model = & $this->getModel('news');
                if($news['id']){
                        $status = $model->updateSideBarStudentNews($news['id'],$news['newstext1']);
                }else{
                        $status = $model->saveSideBarStudentNews($news['newstext1']);
                }
                if($status==false){
                        JError::raiseWarning(500,'Could not save record..');
                        $this->setRedirect($redirectTo,'Retry...');
                }else{
                        $this->setRedirect($redirectTo,'Side Bar Student News Saved...');
                }
    }


    function updatesidebarstaffnews()
    {
                $news = JRequest::get('POST');
                $news['newstext2']=JRequest::getVar( 'newstext2', '', 'post', 'string', JREQUEST_ALLOWHTML );
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=staffnews&controller=news&layout=default&task=setsidebarstaffnews&Itemid='.$news['Itemid'],false);
                $model = & $this->getModel('news');
                if($news['id']){
                        $status = $model->updateSideBarStaffNews($news['id'],$news['newstext2']);
                }else{
                        $status = $model->saveSideBarStaffNews($news['newstext2']);
                }
                if($status==false){
                        JError::raiseWarning(500,'Could not save record..');
                        $this->setRedirect($redirectTo,'Retry...');
                }else{
                        $this->setRedirect($redirectTo,'Side Bar News Staff Saved...');
                }
    }

    function updatesidebarparentnews()
    {
                $news = JRequest::get('POST');
                $news['newstext3']=JRequest::getVar( 'newstext3', '', 'post', 'string', JREQUEST_ALLOWHTML );
                $redirectTo = JRoute::_('index.php?option='.JRequest::getVar('option').'&view=parentnews&controller=news&layout=default&task=setsidebarparentnews&Itemid='.$news['Itemid'],false);
                $model = & $this->getModel('news');
                if($news['id']){
                        $status = $model->updateSideBarParentNews($news['id'],$news['newstext3']);
                }else{
                        $status = $model->saveSideBarParentNews($news['newstext3']);
                }
                if($status==false){
                        JError::raiseWarning(500,'Could not save record..');
                        $this->setRedirect($redirectTo,'Retry...');
                }else{
                        $this->setRedirect($redirectTo,'Side Bar News Parent Saved...');
                }
   }


}

