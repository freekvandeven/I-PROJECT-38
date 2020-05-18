<?php
session_start();
require_once('includes/functions.php');
registerRequest();

$action = array('FAQ, AVG, Privacyverklaring');

$title = 'Footer pagina';

require_once('includes/header.php');

if(isset($_GET['action']) && in_array($_GET['action'], $actions)){
    require_once('classes/views/footer/'.$_GET['action'].'View.php');
} else {
    require_once('classes/views/footer/FAQView.php');
}

require_once('includes/footer.php');