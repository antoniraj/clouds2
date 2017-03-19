<?php

//Fee Accounts
        function addFeeAccount($ptitle,$pcode) {
                $q = "INSERT INTO #__fee_feeaccounts(title,code,aid) VALUES('".$ptitle."','".$pcode."',(SELECT id FROM #__academicyears WHERE status='Y' LIMIT 1))";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function getFeeAccount($ppid,&$rec) {
                $q = "SELECT id,title,code,aid FROM #__fee_feeaccounts WHERE id ='".$ppid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }


        function deleteFeeAccount($pid) {
                $q = 'DELETE FROM #__fee_feeaccounts WHERE id IN ('.$pid.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateFeeAccount($pid,$ptitle,$pcode) {
                $q = "UPDATE #__fee_feeaccounts SET title='".$ptitle."', code='".$pcode."' WHERE id=".$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function getFeeAccounts() {
                $db =& JFactory::getDBO();
                $query = "SELECT id,title,code,aid  FROM #__fee_feeaccounts WHERE aid IN (SELECT id FROM #__academicyears WHERE status='Y')";
                $db->setQuery( $query );
                $res= $db->loadObjectList();
                return $res;
        }


//Fee Categories  temp
        function getFeeCategory_t($pid,&$rec) {
                $q = "SELECT id,title,code FROM #__fee_feecategory_t WHERE id ='".$pid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }
        function getFeeCategoryAmount_t($pid,&$amount) {
                $q = "SELECT sum(amount) AS amount FROM #__fee_feeparticulars_t WHERE fcid ='".$pid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                $amount=$rec->amount;
                return true;
        }
        function addFeeCategory_t($name,$pdescription) {
                $q = "INSERT INTO #__fee_feecategory_t(title,code,aid) VALUES('".$name."','".$pdescription."',(SELECT id FROM #__academicyears WHERE status='Y'))";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
        function updateFeeCategory_t($pid,$name,$pdescription,$groupbased) {
                $q = "UPDATE #__fee_feecategory_t SET title='".$name."', code='".$pdescription."' WHERE id=".$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
        function deleteFeeCategory_t($pid) {
                $q = 'DELETE FROM #__fee_feecategory_t WHERE id IN ('.$pid.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }
        function getFeeCategories_t() {
                $db =& JFactory::getDBO();
                $query = "SELECT id,title,code FROM #__fee_feecategory_t WHERE aid IN (SELECT id FROM #__academicyears WHERE status='Y')";
                $db->setQuery( $query );
                $res= $db->loadObjectList();
                return $res;
        }

        function getFeeCategories_tt() {
                $db =& JFactory::getDBO();
                $query = "SELECT id,title,code FROM #__fee_feecategory_t WHERE aid IN (SELECT id FROM #__academicyears WHERE status='Y')";
                $db->setQuery( $query );
                $res= $db->loadObjectList();
                return $res;
        }


//Fee Particulars  temp
        function getFeeParticular_t($ppid,&$rec) {
                $q = "SELECT id,title,code,accountid,amount,groupbased FROM #__fee_feeparticulars_t WHERE id ='".$ppid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

        function addFeeParticular_t($pname,$pdescription,$pamount,$accountid,$pfcid,$groupbased) {
                $q = "INSERT INTO #__fee_feeparticulars_t(title,code,amount,accountid,fcid,groupbased) VALUES('".$pname."','".$pdescription."','".$pamount."','".$accountid."','".$pfcid."','".$groupbased."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function updateFeeParticular_t($pid,$pname,$pdescription,$accountid,$pamount,$gb) {
                $q = "UPDATE #__fee_feeparticulars_t SET title='".$pname."', code='".$pdescription."', groupbased='".$gb."', accountid='".$accountid."', amount='".$pamount."' WHERE id=".$pid;
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function deleteFeeParticular_t($pid) {
                $q = 'DELETE FROM #__fee_feeparticulars_t WHERE id IN ('.$pid.')';
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function cancelReceipt($rno){
                $q = "DELETE FROM #__fee_feecollectiontransaction WHERE receiptno IN ('".$rno."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

//FEE STRUCTURES

        function getFeeStructures() {
                $db =& JFactory::getDBO();
                $query = "SELECT id,title,aid  FROM #__fee_feestructures";
                $db->setQuery( $query );
                $res= $db->loadObjectList();
                return $res;
        }


        function addFeeStructure($title,&$fstid) {
                $q = "INSERT INTO #__fee_feestructures(title,aid) VALUES('".$title."',(SELECT id FROM #__academicyears WHERE status='Y'))";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                $query = "SELECT id  FROM #__fee_feestructures ORDER BY id DESC LIMIT 1";
                $db->setQuery( $query );
                $res= $db->loadObject();
                $fstid=$res->id;
                return true;
        }


        function getFeeStructure($fstid,&$rec) {
                $q = "SELECT id,title,aid FROM #__fee_feestructures WHERE id ='".$fstid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                $rec = $db->loadObject();
                if($rec==null)
                        return false;
                return true;
        }

        function addFeeCategoryStructure($fstid,$fcid) {
                $q = "INSERT INTO #__fee_feecategorystructures(fstid,fcid) VALUES('".$fstid."','".$fcid."')";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }


        function updateFeeStructure($pid,$title) {
                $q = "UPDATE #__fee_feestructures SET title='".$title."' WHERE id='".$pid."'";
                $db = & JFactory::getDBO();
                $db->setQuery($q);
                if(!$db->query())
                        return false;
                return true;
        }

        function getFeeCategoriesByStructure($fstid) {
                $db =& JFactory::getDBO();
                $query = "SELECT id,title,code FROM #__fee_feecategory WHERE id IN (SELECT fcid FROM #__fee_feecategorystructures WHERE fstid IN (SELECT id FROM #__fee_feestructures WHERE aid IN  (SELECT id FROM #__academicyears WHERE status='Y')) AND fstid='".$fstid."')";
                $db->setQuery( $query );
                $res= $db->loadObjectList();
                return $res;
        }

        function getFeeStructureByFeeCategory($fcid){
                $db =& JFactory::getDBO();
                $query = "select title from #__fee_feestructures  WHERE id IN (SELECT fstid FROM #__fee_feecategorystructures where fcid ='".$fcid."'";
                $db->setQuery( $query );
                $recs= $db->loadObjectList();
                return $recs;
        }

        function getFeeCategoriesByStudent($studentid){
                $db =& JFactory::getDBO();
//              $sql="SELECT id,name,groupbased FROM #__fee_feecategory WHERE aid IN (SELECT id FROM #__academicyears WHERE status='Y') AND (id IN (SELECT fcid FROM #__fee_coursefeecategory WHERE cid IN (SELECT classid FROM #__fee_studentclass WHERE studentid='".$studentid."'))) OR (id IN (SELECT fcid FROM #__fee_groupfeecategory WHERE gid IN (SELECT gid FROM #__fee_groupmembers WHERE sid='".$studentid."')))";
                $sql="SELECT id,title,code FROM #__fee_feecategory WHERE aid IN (SELECT id FROM #__academicyears WHERE status='Y') AND id IN (SELECT fcid FROM #__fee_coursefeecategory WHERE cid IN (SELECT classid FROM #__fee_studentclass WHERE studentid='".$studentid."'))";
                $db->setQuery( $sql);
                $recs= $db->loadObjectList();
                return $recs;
        }





?>
