<?php
session_start();
require_once('includes/functions.php');
$parameterList = array("username", "password", "email", "first-name", "surname", "adress", "adress2", "postcode",
    "place", "country", "phone-number", "phone-number2", "birth-date", "secret-question", "secret-answer");

# handle the register post request
if(isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["email"]) ){
    $posts = [];
    foreach($parameterList as $parameter){
        $posts[$parameter] = (isset($_POST[$parameter])) ? $_POST[$parameter] : '';
    }
    if(empty(getUser($_POST["username"]))){ // check if user already exists
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $user = array("Gebruikersnaam"=>$posts["username"],":Voornaam"=>$posts["first-name"],":Achternaam"=>$posts["surname"],":Adresregel_1"=>$posts["adress"], ":Adresregel_2"=>$posts["adress2"],
            ":Postcode"=>$posts["postcode"], ":Plaatsnaam"=>$posts["place"], ":Land"=>$posts["country"], ":Geboortedag"=>$posts["birth-date"],":Mailbox"=>$posts["email"],":Wachtwoord"=>$password,
            ":Vraag"=>$posts["secret-question"], ":Antwoordtekst"=>$posts["secret-answer"], ":Verkoper"=>FALSE, ":Action"=>FALSE);
        insertUser($user,$posts["phone-number"]);
        createSession($user);
        header("Location: profile.php"); // send person to his profile page
    } else {
        echo "Username is already taken!";
    }
} else {
    echo "please fill in all the data!";
}

$title = "Registreer pagina";
require_once('includes/header.php');

require_once('classes/views/registerView.php');

require_once('includes/footer.php');