<?php
//On démarre la session
session_start();

//On inclut le header
include 'src/view/header.php';
 
//On inclut le contrôleur s'il existe et s'il est spécifié
if (!empty($_GET['page']) && is_file('src/controler/'.$_GET['page'].'.php'))
{
        include 'src/controler/'.$_GET['page'].'.php';
}
else
{
    include 'src/controler/accueil.php';
}
 
//On inclut le footer
//include 'src/view/footer.php';