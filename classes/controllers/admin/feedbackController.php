<?php

if(isset($_POST['deleteFeedback'],$_POST['email'])){
    Admin::deleteWebsiteFeedback($_POST['deleteFeedback'],$_POST['email']);
    $toast = "feedback succesvol verwijderd";
}
$_GET['category'] = $_POST['category'];