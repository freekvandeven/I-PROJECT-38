<?php
session_start();

$title = "Contact Page";

if(checkPost() && isset($_POST['first-name'],$_POST['surname'],$_POST['phone-number'], $_POST['message'])){
    Database :: getFeedback($_POST['first-name'],$_POST['surname'],$_POST['phone-number'], $_POST['message']);
}

require_once('includes/functions.php');

require_once 'includes/header.php';

require_once('classes/views/contactView.php');

require_once('includes/footer.php');