<?php
define('FS_ROOT', realpath(dirname(__FILE__)));
require_once (FS_ROOT . "/../../www/config.php");
require_once (FS_ROOT . "/../../www/lib/framework/db.php");
require_once (FS_ROOT . "/../../www/lib/util.php");


    $key = 'CHANGE';
   
		
	function getRelease($name)
	{			
		$db = new DB();
		return $db->queryOneRow(sprintf("SELECT count(*) as total FROM prehash WHERE releasename =  %s", $db->escapeString($name)));		
	}
	
	
	function AddRelease($name, $date)
	{			
		$db = new DB();
		return $db->queryInsert(sprintf("INSERT INTO prehash (releasename, hash, predate) VALUES (%s, %s, %s)", $db->escapeString($name), $db->escapeString(md5($name)), $db->escapeString($date)));		
	}
		
	
	$src = "https://pre.corrupt-net.org/rss.php?k=".$key;	
	
	echo "pre.corrupt.net - request...";
	$apiresponse = getUrl($src); 
		
	if ($apiresponse)
	{
			
			if (strlen($apiresponse) > 0) 
			{
				echo "response\n";
				$preinfo = simplexml_load_string($apiresponse);
		
				foreach($preinfo->channel->item as $item) 
				{
					$cleanname = trim(substr($item->title , strpos( $item->title,']')+ 1));
					$res  = getRelease($cleanname);
					
					if ($res['total'] == 0)
					{	
						AddRelease($cleanname, $item->pubDate);
						//echo "\n Added - ".$cleanname."\n";
					}
		
				}

			}else{
				echo "response was zero length :( \n";
			}
	}else{
			echo "nothing came :( \n";
	}
	
?>