<?php
	function getRelease($name)
	{			
		$db = new DB();

		return $db->queryOneRow(sprintf("SELECT count(*) as total FROM prehash WHERE releasename =  %s", $db->escapeString($name)));		
	}	
	function AddRelease($name)
	{			
		$db = new DB();
		return $db->queryInsert(sprintf("INSERT INTO prehash (releasename, hash, predate) VALUES (%s, %s,  NOW())", $db->escapeString($name), $db->escapeString(md5($name))));		
	}
		

	if (isset($_GET["id"]))
	{
		$res  = getRelease($_GET["id"]);
					
		if ($res['total'] == 0)
		{	
			AddRelease($_GET["id"]);
		}
	
	}


