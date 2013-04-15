<?php
define('FS_ROOT', realpath(dirname(__FILE__)));
require_once(FS_ROOT . "/../../www/config.php");
require_once(FS_ROOT . "/../../www/lib/framework/db.php");
require_once(FS_ROOT . "/../../www/lib/util.php");
 
 
function getRelease($name)
{
    $db = new DB();
    return $db->queryOneRow(sprintf("SELECT count(*) as total FROM prehash WHERE releasename = %s", $db->escapeString($name)));
}
 
 
function AddRelease($name, $date)
{
    $db = new DB();
    return $db->queryInsert(sprintf("INSERT INTO prehash (releasename, hash, predate) VALUES (%s, %s, %s)", $db->escapeString($name), $db->escapeString(md5($name)), $db->escapeString($date)));
}
 
 
$src = "http://www.rlzlog.info/rss.php?page=1";
 
echo "rlzlog.info - request...";
$apiresponse = getUrl($src);
 
if ($apiresponse) {
   
    if (strlen($apiresponse) > 0) {
        echo "response\n";
        $preinfo = simplexml_load_string($apiresponse);
       
        foreach ($preinfo->channel->item as $item) {
            $cleanname = $item->title;
            $res       = getRelease($cleanname);
           
            if ($res['total'] == 0) {
                AddRelease($cleanname, $item->pubDate);
            }
           
        }
       
    } else {
        echo "response was zero length :( \n";
    }
} else {
    echo "nothing came :( \n";
}
?>