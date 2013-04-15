<?php
define('FS_ROOT', realpath(dirname(__FILE__)));
require_once (FS_ROOT . "/../../www/config.php");
require_once (FS_ROOT . "/../../www/lib/framework/db.php");
require_once (FS_ROOT . "/../../www/lib/util.php");
function AddRelease($name, $date)
{
$db = new DB();
return $db->queryInsert(sprintf("INSERT IGNORE INTO prehash (releasename, hash, predate) VALUES (%s, %s, %s)", $db->escapeString($name), $db->escapeString(md5($name)), $db->escapeString($date)));
}

$fp=fopen("/var/www/newznab/misc/update_scripts/hash.txt","r") or die("cannot open file\n"); // change the file to same as irssi script
while(!feof($fp)) {
  $line=fgets($fp);
  if(strlen($line)>1) {
    $line1=split("\t",trim($line));
    AddRelease($line1[0],$line1[1]);
  }
}
fclose($fp);

?>