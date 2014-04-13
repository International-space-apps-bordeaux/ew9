<?php
include_once(dirname(__FILE__).'/../model/DAO.php');
$IDphoto= DAO::getInstance()->getBestImageOfMonth();
$BestPhotoOfMonth= DAO::getInstance()->getImage($IDphoto);
$images = DAO::getInstance()->getRandomGallery();
include(dirname(__FILE__).'/../view/gallery.php');
?>