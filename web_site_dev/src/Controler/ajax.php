<?php

include_once(dirname(__FILE__).'/../model/DAO.php');


$image = DAO::getInstance()->setVote($_POST['vote']);   

?>