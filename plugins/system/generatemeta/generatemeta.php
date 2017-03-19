<?php
/*
# ------------------------------------------------------------------------
# Generate Meta - Joomla 3.x System Meta Generator Plugin
# ------------------------------------------------------------------------
# Copyright (C) 2010 - 2013 Omera.Net. Her hakký saklýdýr.
# license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Author: omera
# Websites:  http://joomla.omera.net
# ------------------------------------------------------------------------
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.event.plugin');

require_once (JPATH_SITE.'/components/com_content/helpers/route.php');

class plgSystemGeneratemeta extends JPlugin {
  
    // Constructor
	function plgSystemGeneratemeta( &$subject, $config ) {
		parent::__construct( $subject, $config );
		}
  
	function onBeforeCompileHead() {
	
		//General
		$Container = JFactory::getApplication();
		if (!$Container->isSite()) return ;
		$Doc = JFactory::getDocument();
			$DocType = $Doc->getType();
			if ($DocType != 'html') return ;
		$PageTitle 				= $Doc->getTitle();
		$SiteName 				= $Container->getCfg('SiteName');
			
		//Params
		$FrontPageDis 			= $this->params->def('FrontPageDis', 0);
			if ($this->isFrontPage() && $FrontPageDis == 1) return;
		$TitleOrder 			= $this->params->def('TitleOrder', 0);
		$FrontPageTitle 		= $this->params->def('FrontPageTitle','Home');
		$FrontPageTitleOrder 	= $this->params->def('FrontPageTitleOrder', 0);
		$UseC 					= $this->params->def('UseC', 1);
		$CatTitle 				= $this->params->def('CatTitle', 1);
		$Domain 				= $this->params->def('Domain','');
		
		// Str
		$SiteName 				= str_replace('&amp;','&',$SiteName);
		$Separator 				= str_replace('\\','',$this->params->def('Separator','|')); //Sets and removes Joomla escape char bug.
		  
			//Options & Data
			$option = JRequest::getVar('option', '');
				$view = JRequest::getVar('view','');
					if($UseC==1){
						$thestart = JRequest::getInt('start',0);
						$limitstart = JRequest::getInt('limitstart',0);
						$start="";
							if($thestart>0) {
								$start = '?start='.$thestart;
								} elseif($limitstart>0) {
								$start = '?limitstart='.$limitstart;
								}
						}
					
				$db =  $database = JFactory::getDBO();
					if($option == 'com_content') {
						if($view=='article') {
							if($UseC==1 || $CatTitle==1) {
								$id = JRequest::getInt('id');		
								if($id>0) {
									$query = "SELECT b.title as cattitle,".
											" CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(':', a.id, a.alias) ELSE a.id END as slug,".
											" CASE WHEN CHAR_LENGTH(b.alias) THEN CONCAT_WS(':', a.catid, b.alias) ELSE a.catid END as catslug".
											" FROM #__content AS a LEFT JOIN #__categories AS b ON b.id = a.catid WHERE a.id = $id";
									$row = $db->SetQuery($query);
									$row = $db->loadObject();                          
										if($UseC==1) {
											$UseCan = $Domain.JRoute::_(ContentHelperRoute::getArticleRoute($row->slug, $row->catslug));
											}                   
										if($CatTitle==1 && $row->cattitle!='') {
											$SiteName = $row->cattitle;
											}
									}
								}
							}
						if($view=='category' && $UseC==1) {
							$UseCan = $Domain.JRoute::_(ContentHelperRoute::getCategoryRoute(JRequest::getInt('id')));
								if(strpos($UseCan, '&') !== 0) {
									$start = str_replace('&','?',$start);
									}
							$UseCan = $UseCan.$start;
							}
						}
					if ($this->isFrontPage() && $UseC==1) {
						if($start!='') {
							$UseCan = $Domain.JRoute::_('index.php').$start;
							} else {
							$UseCan = $Domain;
							}
						}
					if(isset($UseCan) && $UseCan!='')$Doc->addHeadLink( $UseCan, 'canonical', 'rel', '' );
					if ($this->isFrontPage()):
					if ($FrontPageTitleOrder == 0):
						$NewPageTitle = $FrontPageTitle . ' ' . $Separator . ' '. $SiteName;
					elseif ($FrontPageTitleOrder == 1):
						$NewPageTitle = $SiteName . ' ' . $Separator . ' ' . $FrontPageTitle;
					elseif ($FrontPageTitleOrder == 2):
						$NewPageTitle = $FrontPageTitle;
					elseif ($FrontPageTitleOrder == 3):
						$NewPageTitle = $SiteName;
					endif;
					else:
					if ($titOrder == 0):
						$NewPageTitle = $PageTitle . ' ' . $Separator . ' ' .  $SiteName;
					elseif ($titOrder == 1):
						$NewPageTitle = $SiteName . ' ' . $Separator . ' ' . $PageTitle;
					elseif ($titOrder == 2):
						$NewPageTitle = $PageTitle;
					endif;
		endif;
			
		// Set the Title
		$Doc->setTitle ($NewPageTitle);
		}

	// Set the Limit
	function onContentPrepare( $context, &$article, &$params, $limitstart ) {
		$Container = JFactory::getApplication();
			$option = JRequest::getVar('option', '');
			$Doc = JFactory::getDocument();
				if($option != 'com_content' || $Doc->getType()!='html' || !$Container->isSite() || $context!='com_content.article') return; 
			$view = JRequest::getVar('view', ''); 
				if($option == 'com_content' && $view != 'article') return;
		$FrontPageDis = $this->params->def('FrontPageDis', 0);
			if ($this->isFrontPage() && $FrontPageDis == 1) return;
		
			if(!isset($article->text) || $article->text == '') {
			return;
				} elseif($article->metakey == '' || $article->metadesc == '') {
				$MaxChar = $this->params->def('MaxChar','500');
				$thecontent = JString::substr($article->text,0,$MaxChar);
				$thecontent = $this->cleanText($thecontent);
				}
		
			if ($article->metakey == '' && 	$Doc->getMetaData('keywords') == $Container->getCfg('MetaKeys')) {
			
				// Word Params
				$BlackWord 		= $this->params->def('BlackWord','');
				$GoldWord 		= $this->params->def('GoldWord','');
				$MinLength 		= $this->params->def('MinLength','5');
				$MaxWords 		= $this->params->def('MaxWords','20');
				$keywords 		= $this->cleanAllSymbols($thecontent);
				$keywords 		= $this->keys($keywords,$BlackWord,$GoldWord,$MaxWords,$MinLength);
					
					//Set the keywords
					if($keywords != '') {
						$Doc->setMetaData('keywords', $keywords);
						}
				}

		  // Set the description
			if ($article->metadesc == '' && $Doc->getMetaData('description') == $Container->getCfg('MetaDesc')) {
				$DescLength 	= $this->params->def('DescLength', 200);
				$metadesc 		= $thecontent . ' ';
				$metadesc 		= JString::substr($metadesc,0,$DescLength);
				$metadesc 		= JString::substr($metadesc,0,JString::strrpos($metadesc,' '));
				$Doc->setDescription($metadesc);
				}
        }
	
	function cleanText( $text ) {
		// Remove tags				
		$text = preg_replace( "'<script[^>]*>.*?</script>'si", '', $text );		
		$text = preg_replace( '/<!--.+?-->/', '', $text );
		$text = preg_replace( '/{.+?}/', '', $text );
		//$text = strip_tags( $text );
		$text = preg_replace( '/<a\s+.*?href="([^"]+)"[^>]*>([^<]+)<\/a>/is', '\2 (\1)', $text );
		$text = preg_replace('/<[^>]*>/', ' ', $text);
		
		// Remove any email addresses
		$regex = '/(([_A-Za-z0-9-]+)(\\.[_A-Za-z0-9-]+)*@([A-Za-z0-9-]+)(\\.[A-Za-z0-9-]+)*)/iex';
		$text = preg_replace($regex, '', $text);
		
		// convert html entities to chars
		$text = html_entity_decode($text,ENT_QUOTES,'UTF-8');
		
		$text = str_replace('"', '\'', $text); //Make sure all quotes play nice with meta.
                $text = str_replace(array("\r\n", "\r", "\n", "\t"), " ", $text); //Change spaces to spaces
		
		
		//convert all separators to a normal space
		$text = preg_replace(array('/\s/u',),' ',$text ); //http://www.fileformat.info/info/unicode/category/index.htm
                // remove any extra spaces
		while (strchr($text,"  ")) {
			$text = str_replace("  ", " ",$text);
		}
		
		// general sentence tidyup
		for ($cnt = 1; $cnt < JString::strlen($text)-1; $cnt++) {
			// add a space after any full stops or comma's for readability
			// added as strip_tags was often leaving no spaces
			if ( ($text{$cnt} == '.') || (($text{$cnt} == ',') && !(is_numeric($text{$cnt+1})))) {
				if ($text{$cnt+1} != ' ') {
					$text = JString::substr_replace($text, ' ', $cnt + 1, 0);
				}
			}
		}
			
		return trim($text);
		}
	
	//function to prepare the text for keywords extraction
	function cleanAllSymbols( $text ) {	    
		//remove symbols
		$text = preg_replace(array('/[\p{Cc}\p{Pd}\p{Pe}\p{Pf}\p{Pi}\p{Po}\p{Ps}\p{Sc}\p{Sm}\p{So}\p{Zl}\p{Zp}\p{Zs}]/u',),' ',$text ); //http://www.fileformat.info/info/unicode/category/index.htm		
                // remove any extra spaces
		while (strchr($text,"  ")) {
			$text = str_replace("  ", " ",$text);
		}			
		return $text;
		}	
	
	function isFrontPage() {
		$app 	= JFactory::getApplication();
		$menu 	= $app->getMenu();
		$lang 	= JFactory::getLanguage();
		if ($menu->getActive() == $menu->getDefault($lang->getTag())) {
	     	return true;
			}
		return false;
		}
	
	function Keys($desc,$blacklist,$sticklist,$count,$MinLength) {
		$desc 		= JString::strtolower($desc); 
		$keysArray 	= explode(" ", $desc);
		
		// Sort words from up to down
		$keysArray 	= array_count_values($keysArray);
		$stickArray = explode(",", $sticklist);
		
		if (JString::strlen($blacklist)>0) {
                 $blackArray = explode(",", $blacklist);
	         foreach($blackArray as $blackWord){
		    if(isset($keysArray[JString::trim($blackWord)]))
			unset($keysArray[JString::trim($blackWord)]);
		 }
		}
		arsort($keysArray);
		$i = 1;
		$keywords 	= "";
		$gkeywords 	= "";
		
		if (JString::strlen($sticklist)>0) {
		 foreach($keysArray as $word => $instances){
			if($i > $count)
				break;
				if(in_array($word,$stickArray)) {
				$gkeywords .= $word . ",";
				$i++;
			 }
		 }
		}
		foreach($keysArray as $word => $instances){
			if($i > $count)
				break;
			if(JString::strlen(JString::trim($word)) >= $MinLength && is_string($word) && in_array($word,$stickArray)==false) {
				$keywords .= $word . ",";
				$i++;
			}
		 }
		$keywords 	= $gkeywords.$keywords;
		$keywords 	= JString::rtrim($keywords, ",");
		return $keywords;
		}
	}