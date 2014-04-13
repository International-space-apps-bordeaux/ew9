<?php

include_once(dirname(__FILE__).'/../model/DAO.php');
include_once(dirname(__FILE__).'/xml.php');

$IDBestImage= DAO::getInstance()->getBestImageOfMonth();
$markers = DAO::getInstance()->getAllMarkers();

$xml_result = create_xml($markers);
include(dirname(__FILE__).'/../view/accueil.php');

?>