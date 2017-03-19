<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );

include_once('cce.php');
class CceModelNews extends CceModelCce {
        function __construct(){
                parent::__construct();
        }

        function getTopNews(&$rec)
        {
                $q = 'SELECT `id`,`newstext` FROM #__schooltopnews LIMIT 1';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

       function saveTopNews($pnewstext)
       {
                $q = "INSERT INTO #__schooltopnews(`newstext`) VALUES(trim('".$pnewstext."'))";

                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateTopNews($id,$ptext)
        {
                $q = "UPDATE #__schooltopnews SET `newstext`=trim('".$ptext."') WHERE `id`=".$id;
                $db = & JFactory::getDBO();

                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
	}

        function getSideBarNews(&$rec)
        {
                $q = 'SELECT `id`,`newstext1`,`newstext2`,`newstext3` FROM #__schoolsidebarnews LIMIT 1';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }
        function getSideBarStudentNews(&$rec)
        {
                $q = 'SELECT `id`,`newstext1` FROM #__schoolsidebarnews LIMIT 1';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

        function getSideBarStaffNews(&$rec)
        {
                $q = 'SELECT `id`,`newstext2` FROM #__schoolsidebarnews LIMIT 1';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

        function getSideBarParentNews(&$rec)
        {
                $q = 'SELECT `id`,`newstext3` FROM #__schoolsidebarnews LIMIT 1';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }



       function saveSideBarNews($pn1,$pn2,$pn3)
       {
                $q = "INSERT INTO #__schoolsidebarnews(`newstext1`,`newstext2`,`newstext3`) VALUES(trim('".$pn1."'),trim('".$pn2."'),trim('".$pn3."'))";

                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
       
       function saveSideBarStudentNews($pn1)
       {
                $q = "INSERT INTO #__schoolsidebarnews(`newstext1`) VALUES(trim('".$pn1."'))";

                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
       function saveSideBarStaffNews($pn1)
       {
                $q = "INSERT INTO #__schoolsidebarnews(`newstext2`) VALUES(trim('".$pn1."'))";

                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

       function saveSideBarParentNews($pn1)
       {
                $q = "INSERT INTO #__schoolsidebarnews(`newstext3`) VALUES(trim('".$pn1."'))";

                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
        function updateSideBarNews($id,$pn1,$pn2,$pn3)
        {
                $q = "UPDATE #__schoolsidebarnews SET `newstext1`=trim('".$pn1."'), `newstext2`=trim('".$pn2."'), `newstext3`=trim('".$pn3."') WHERE `id`=".$id;
                $db = & JFactory::getDBO();

                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
	}

        function updateSideBarStudentNews($id,$pn1)
        {
                $q = "UPDATE #__schoolsidebarnews SET `newstext1`=trim('".$pn1."') WHERE `id`=".$id;
                $db = & JFactory::getDBO();

                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
	}

        function updateSideBarStaffNews($id,$pn1)
        {
                $q = "UPDATE #__schoolsidebarnews SET `newstext2`=trim('".$pn1."') WHERE `id`=".$id;
                $db = & JFactory::getDBO();

                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
	}

        function updateSideBarParentNews($id,$pn1)
        {
                $q = "UPDATE #__schoolsidebarnews SET `newstext3`=trim('".$pn1."') WHERE `id`=".$id;
                $db = & JFactory::getDBO();

                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
	}



}
