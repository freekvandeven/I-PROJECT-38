<?php
$parameterList = array("username", "secret-question", "secret-answer", "email", "adress", "country", "place", "postcode");
$optionalList = array("password", "confirmation", "adress2", "phone-number", "phone-number2");
# handle the register post request
$correct = true;
foreach($parameterList as $parameter){
    if(empty($_POST[$parameter])){
        $err = "please fill in all parameters";
        $correct = false;
    }
}
if($correct) {
    $user = User::getUser($_SESSION['name']);
    $changes = array(":username"=>$_SESSION['name'],":gebruikersnaam"=>$_POST["username"], ":adress"=>$_POST["adress"], ":adress2"=>$_POST["adress2"], ":postcode"=>$_POST["postcode"],":place"=>$_POST["place"],
        ":country"=>$_POST["country"], ":email"=>$_POST["email"], ":question"=>$_POST["secret-question"], ":answer"=>$_POST["secret-answer"]);
    User::updateUser($changes);
    createSession(User::getUser($changes[":gebruikersnaam"]));

    if(!empty($_POST["password"]) && !empty($_POST["confirmation"])){
        if($_POST["password"] == $_POST["confirmation"]){
            User::updatePassword($_SESSION['name'], password_hash($_POST["password"], PASSWORD_DEFAULT));
            header("Location: profile.php");
        } else {
            $err = "Passwords did not match";
        }
    } else {
        header("Location: profile.php");
    }
    # geef de gebruiker een notificatie
}