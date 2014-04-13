<?php

include_once(dirname(__FILE__).'/../model/DAO.php');
include_once(dirname(__FILE__).'/xml.php');

$image = DAO::getInstance()->getImage($_GET['id']);
$related_pictures = DAO::getInstance()->getSimilarPicture($image->acquisition_time);

include(dirname(__FILE__).'/../view/detail.php');

?>