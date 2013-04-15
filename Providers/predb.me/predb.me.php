<?php
define('FS_ROOT', realpath(dirname(__FILE__)));
require_once (FS_ROOT . '/../../www/config.php');
require_once (FS_ROOT . '/../../www/lib/framework/db.php');
require_once (FS_ROOT . '/../../www/lib/util.php');

	function getRelease($name)
	{			
		$db = new DB();
		return $db->queryOneRow(sprintf("SELECT count(*) as total FROM prehash WHERE releasename =  %s", $db->escapeString($name)));		
	}
	
	function AddRelease($name, $date)
	{			
		$db = new DB();
		return $db->queryInsert(sprintf('INSERT INTO prehash (releasename, hash, predate) VALUES (%s, %s, %s)', $db->escapeString($name), $db->escapeString(md5($name)), $db->escapeString($date)));		
	}
	

		$src = 'http://predb.me/?page=1';
		echo "predb.me - request...";
		$response = getUrl($src);
		
		if ($response)
		{
			if (strlen($response) > 0)
			{
				echo "response\n";
					
				$response = str_replace('&','',$response);
				$preinfo = simplexml_load_string($response);
				$preinfo->registerXPathNamespace('x', 'http://www.w3.org/1999/xhtml');
				$preinfo = $preinfo->xpath('/x:html/x:body/x:div[@class="core"]/x:div[@class="content"]/x:div[@class="post-list"]/x:div[@class="pl-body"]/x:div[@class="post"]/x:div[@class="p-head"]');
						
				$Releases=array('Names' => array(), 'Times' => array());
				
				foreach($preinfo as $release)
				{
					foreach($release as $div)
					{
						foreach($div->Attributes() as $name=>$value)
						{
							if ($value=='p-c p-c-time')
							{
								foreach($div->span->Attributes() as $name=>$value)
								{
									if ($name=='data') $time=$value;	
								}							
							}
							elseif ($value=='p-c p-c-title')
							{								
								$release=(string)$div->h2->a;
							}						
						}
					}
					
					
					
					$res  = getRelease($release);
					
					if ($res['total'] == 0)
					{	
					
						AddRelease($release, date('Y-m-d H:i:s',(int)$time));
					
					
					}
					
					
					
				}
		
		}else{
				echo "response was zero length :( \n";
			}
	}else{
			echo "nothing came :( \n";
	}
	
		
	

	
		
		
	
?>