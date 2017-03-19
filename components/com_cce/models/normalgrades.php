<?php
 
defined( '_JEXEC' ) or die( 'Restricted access' );
include_once('cce.php');
 
jimport( 'joomla.application.component.model' );
 
class CceModelNormalGrades extends CceModelCce
{

	function __construct(){
        	parent::__construct();
        }

	function getNormalGrade($pid,&$rec)
        {
                $q = 'SELECT `id`,`from`,`to`,`letter`,`points`,`description`,`points` FROM #__normalgrades WHERE id ='.$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

	function getNormalGradeLetter($pmarks,&$rec)
        {
                $q = 'SELECT `id`,`from`,`to`,`letter`,`points`,`description`,`points` FROM #__normalgrades WHERE `from` <= '.$pmarks.' AND `to` >= '.$pmarks;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }


       function addNormalGrade($pfrom,$pto,$pletter,$ppoints,$pdescription)
       {
                $q = "INSERT INTO #__normalgrades(`from`,`to`,`letter`,`points`,`description`) VALUES('".$pfrom."','".$pto."','".$pletter."',".$ppoints.",'".$pdescription."')";

                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateNormalGrade($id,$pfrom,$pto,$pletter,$ppoints,$pdescription)
        {
                $q = "UPDATE #__normalgrades SET `from`='".$pfrom."', `to`='".$pto."', `letter`='".$pletter."',`points`=".$ppoints.", `description`='".$pdescription."' WHERE `id`=".$id;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function deleteNormalGrade($pids)
        {
                $ids = implode(',',$pids);
                $q = 'DELETE FROM #__normalgrades WHERE `id` IN ('.$ids.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function getNormalGrades()
        {
                $query = "SELECT `id`,`from`,`to`,`letter`,`points`,`description` FROM #__normalgrades";
                $db = & JFactory::getDBO();
                $db->setQuery( $query );
                $activities = $db->loadObjectList();
                return $activities;
        }
}
