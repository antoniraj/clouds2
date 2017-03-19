<?php
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.model' );
 
class CceModelScholasticBGrades extends JModel
{

	function __construct(){
        	parent::__construct();
        }

	function getScholasticBGrade($pid,&$rec)
        {
                $q = 'SELECT `id`,`points`,`title`,`letter`,`description` FROM #__scholasticbgrades WHERE id ='.$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }


       function addScholasticBGrade($ppoints,$ptitle,$pletter,$pdescription)
       {
                $q = "INSERT INTO #__scholasticbgrades(`points`,`title`,`letter`,`description`) VALUES('".$ppoints."','".$ptitle."','".$pletter."','".$pdescription."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateScholasticBGrade($id,$ppoints,$ptitle,$pletter,$pdescription)
        {
                $q = "UPDATE #__scholasticbgrades SET `points`='".$ppoints."', `title`='".$ptitle."', `letter`='".$pletter."', `description`='".$pdescription."' WHERE `id`=".$id;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function deleteScholasticBGrade($pids)
        {
                $ids = implode(',',$pids);
                $q = 'DELETE FROM #__scholasticbgrades WHERE `id` IN ('.$ids.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function getScholasticBGrades()
        {
                $query = "SELECT `id`,`points`,`title`,`letter`,`description` FROM #__scholasticbgrades";
                $db = & JFactory::getDBO();
                $db->setQuery( $query );
                $activities = $db->loadObjectList();
                return $activities;
        }


        function getScholasticBGradeLetter($pmarks,&$rec) {
                $q = 'SELECT `id`,`letter`,`points`,`description` FROM #__scholasticbgrades WHERE `points`= '.$pmarks;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

}
