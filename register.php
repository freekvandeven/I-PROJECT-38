<?php
session_start();
require_once('includes/functions.php');
$parameterList = array("username", "password", "confirmation", "email", "first-name", "surname", "adress", "postcode",
    "place", "country", "phone-number", "birth-date", "secret-question", "secret-answer");
$optionalList = array("phone-number2", "adress2");

# handle the register post request
if(!empty($_POST)) {
    # check if everything is set
    $isValid = true;
    foreach ($parameterList as $parameter) {
        $isValid &= (isset($_POST[$parameter]) && !empty($_POST[$parameter]));
    }
    if ($isValid) { # user filled in everything
        if ($_POST["password"] == $_POST["confirmation"]) { # check if passwords match
            if(checkdnsrr(explode('@', $_POST["email"])[1], $record = 'MX')) { # check if domain has a mailserver running
                if (empty(User::getUser($_POST["username"]))) { #check if user already exists
                    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
                    $user = array("Gebruikersnaam" => $_POST["username"], ":Voornaam" => $_POST["first-name"], ":Achternaam" => $_POST["surname"], ":Adresregel_1" => $_POST["adress"], ":Adresregel_2" => $_POST["adress2"],
                        ":Postcode" => $_POST["postcode"], ":Plaatsnaam" => $_POST["place"], ":Land" => $_POST["country"], ":Geboortedag" => $_POST["birth-date"], ":Mailbox" => $_POST["email"], ":Wachtwoord" => $password,
                        ":Vraag" => $_POST["secret-question"], ":Antwoordtekst" => $_POST["secret-answer"], ":Verkoper" => FALSE, ":Action" => FALSE);
                    User::insertUser($user, $_POST["phone-number"]);
                    header("Location: login.php");
                } else {
                    $err = "user already exists";
                }
            } else {
                $err = "email is invalid or taken";
            }
        } else {
            $err = "passwords did not match";
        }
    } else {
        $err = "please fill in all data";
    }
}

$title = "Register Page";
require_once('includes/header.php');

require_once('classes/views/registerView.php');

require_once('includes/footer.php');