<?php
 
defined( '_JEXEC' ) or die( 'Restricted access' );
include_once('cce.php');
 
jimport( 'joomla.application.component.model' );
 
class CceModelFAGrades extends CceModelCce
{

	function __construct(){
        	parent::__construct();
        }

	function getFAGrade($pid,&$rec)
        {
                $q = 'SELECT `id`,`from`,`to`,`letter`,`points`,`description`,`points` FROM #__fagrades WHERE id ='.$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

	function getFAGradeLetter($pmarks,&$rec)
        {
                $q = 'SELECT `id`,`from`,`to`,`letter`,`points`,`description`,`points` FROM #__fagrades WHERE `from` <= '.$pmarks.' AND `to` >= '.$pmarks;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }


       function addFAGrade($pfrom,$pto,$pletter,$ppoints,$pdescription)
       {
                $q = "INSERT INTO #__fagrades(`from`,`to`,`letter`,`points`,`description`) VALUES('".$pfrom."','".$pto."','".$pletter."',".$ppoints.",'".$pdescription."')";

                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateFAGrade($id,$pfrom,$pto,$pletter,$ppoints,$pdescription)
        {
                $q = "UPDATE #__fagrades SET `from`='".$pfrom."', `to`='".$pto."', `letter`='".$pletter."',`points`=".$ppoints.", `description`='".$pdescription."' WHERE `id`=".$id;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function deleteFAGrade($pids)
        {
                $ids = implode(',',$pids);
                $q = 'DELETE FROM #__fagrades WHERE `id` IN ('.$ids.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function getFAGrades()
        {
                $query = "SELECT `id`,`from`,`to`,`letter`,`points`,`description` FROM #__fagrades";
                $db = & JFactory::getDBO();
                $db->setQuery( $query );
                $activities = $db->loadObjectList();
                return $activities;
        }
}
