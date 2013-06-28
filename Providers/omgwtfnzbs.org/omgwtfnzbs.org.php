<?php
define('FS_ROOT', realpath(dirname(__FILE__)));
require_once (FS_ROOT . "/../../www/config.php");
require_once (FS_ROOT . "/../../www/lib/framework/db.php");
require_once (FS_ROOT . "/../../www/lib/util.php");
require_once ("hashcompare.php");
		
	
	$src = "http://rss.omgwtfnzbs.org/rss-info.php";

	echo "Requesting pre info from omgwtfnzbs.org rss feed ...";
	$apiresponse = getUrl($src);

	if ($apiresponse)
	{

			if (strlen($apiresponse) > 0)
			{
				echo "Response received\n";
				$preinfo = simplexml_load_string($apiresponse);

				foreach($preinfo->channel->item as $item)
				{
					$cleanname = trim($item->title);
					$res  = getRelease($cleanname);

					if ($res['total'] == 0)
					{
						AddRelease($cleanname, $item->pubDate);
					}

				}

			}
			else
			{
				echo "response was zero length :( \n";
			}
	}
	else
		{
			echo "nothing came :( \n";
		}

?>