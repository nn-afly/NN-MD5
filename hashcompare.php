<?php
define('FS_ROOT_OVERRIDE', realpath(dirname(__FILE__)));
require_once (FS_ROOT_OVERRIDE . "/../../www/config.php");
require_once (FS_ROOT_OVERRIDE . "/../../www/lib/framework/db.php");
require_once (FS_ROOT_OVERRIDE . "/../../www/lib/releases.php");
require_once (FS_ROOT_OVERRIDE . "/../../www/lib/category.php");
		
		
	function CheckExists()
	{	
		$db = new DB();
		return $db->query(sprintf("select 1 from prehash"));		
	}
 	function getHashes()
	{			
		$db = new DB();
		return $db->query(sprintf("SELECT r.ID, ph.releasename, g.name FROM releases r join prehash  ph on ph.hash = r.searchname join groups g ON g.ID = r.groupID  WHERE r.categoryid = 8010"));		
	}
		
	function updaterelease($foundName, $id, $groupname)
	{			
		$db = new DB();
		$rel = new Releases();
		$cat = new Category();

		$cleanRelName = $rel->cleanReleaseName($foundName);
		$catid = $cat->determineCategory($groupname, $foundName);			
			
		$db->query(sprintf("UPDATE releases SET name = %s,  searchname = %s, categoryID = %d WHERE ID = %d",  $db->escapeString($cleanRelName),  $db->escapeString($cleanRelName), $catid,  $id));	
		
	}
	
	function hashInit()
	{
			
		if (CheckExists() !== false)
		{
		
			$results = getHashes();
			
			foreach($results as $result) 
			{
				echo "Hash Match! Renaming release... ".$result['releasename']."\n";
				updaterelease($result['releasename'], $result['ID'], $result['name']);
			}
		}
		
	}
	
	
?>