<?php
$parameterList = array("bank", "bankrekening", "controlenummer", "creditcard");
# handle the register post request
$correct = true;
foreach($parameterList as $parameter){
    if(empty($_POST[$parameter])){
        $err = "please fill in all parameters";
        $toast = "please fill in all parameters";
        $correct = false;
    }
}
if($correct) {
    $user = User::getUser($_SESSION['name']);
    if ($user['Verkoper']) {
        $err = "je bent al verkoper";
        $toast = "je bent al verkoper";
    } else {
        $details = array("bank" => $_POST["bank"], "rekening" => $_POST["bankrekening"], "controle" => $_POST["controlenummer"], "creditcard" => $_POST["creditcard"]);
        User::upgradeUser($_SESSION['name'], $details);
        header("Location: profile.php?toast=je bent nu verkoper");
        # geef de gebruiker een notificatie
    }
}