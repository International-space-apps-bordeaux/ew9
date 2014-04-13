<?php
require "db.php";
require "depots.php";
require "tbl_images.php";
require "ftp.php";
require "pictures.php";

echo "debut du script\n";

$db = new db();
$db->connect();
$ftp = new ftp();

$depots = new depots($db);
$images = new tbl_images($db);

$listeDepots = $depots->lister();
$listeImages = $images->lister();

// Browse storage list in DB
foreach ($listeDepots as $depot)
{
	$ftp->ftp_connection($depot["server"]);
	$contents = $ftp->ftp_sync($depot["path"], $db,$depot["id"]);
	
}
$rm = "rm -R ../files/tmp/*";
exec($rm);
echo "fin du script\n";
?>