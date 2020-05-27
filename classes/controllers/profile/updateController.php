<?php
/*
 * updateController handles updateInformation from profilePage.
 */
# get all current user information
$user = User::getUser($_SESSION['name']);

$userInformation = array(
    ":adress"=>$user['Adresregel_1'],
    ":adress2"=>$user['Adresregel_2'],
    ":postcode"=>$user['Postcode'],
    ":place"=>$user['Plaatsnaam'],
    ":country"=>$user['Land'],
    ":email"=>$user['Mailbox'],
    ":question"=>$user['Vraag'],
    ":answer"=>$user['Antwoordtekst'],
    ":username"=>$_SESSION['name']
);

$filledFields = array(
    'Persoonsgegevens' => array('email', 'adress', 'adress2' , 'country', 'place', 'postcode'),
    'Inloggegevens' => array('password', 'confirmation'),
    'Beveiligingsgegevens' => array('secret-question', 'secret-answer'),
    'NotRequiredField' => array('adress2')
);

if($_GET['option'] == 'persoonsgegevens') {
    if(checkAllFieldsFilled($filledFields, 'Persoonsgegevens')) { // Als alle verplichte velden zijn ingevuld
        $changes = setArrayUserInformation($filledFields, $userInformation, 'Persoonsgegevens'); // Maakt een array met alle ingevulde values
        if(!empty($_POST['phone-number'])): updateUserPhone(); endif;
        User::updateUser($changes);
        header("Location:profile.php?toast=Gegevens opgeslagen");
    } else { // Als niet alle velden zijn ingevuld
        $err = 'Vul alle velden in!';
    }
} else if($_GET['option'] == 'inloggegevens') {
    if(checkAllFieldsFilled($filledFields, 'Inloggegevens')) {
        $changes = setArrayUserInformation($filledFields, $userInformation, 'Inloggegevens');
    } else {
        $err = 'Vul alle velden in!';
    }
    User::updateUser($changes);
    header("Location: profile.php");
} else if($_GET['option'] == 'beveiligingsgegevens') {

} else if($_GET['option'] == 'profielfoto') {
    if(!empty($_FILES)) {
        deleteFile("upload/users/".$_SESSION['name'].".png");
        imagepng(imagecreatefromstring(file_get_contents($_FILES['img']['tmp_name'])), "upload/users/".$_SESSION['name'].".png");
    } else {
        $err = 'Kies een nieuwe profielfoto om op te slaan.';
    }
} else {

}

function checkAllFieldsFilled($filledFields, $categorie) {
    foreach ($filledFields[$categorie] as $value) :
        if(empty($value)) : return false; endif;
    endforeach;
    return true;
}

function setArrayUserInformation($filledFields, $userInformation, $category) {
    foreach ($filledFields[$category] as $parameter) :
        $userInformation[':'.$parameter] = $_POST[$parameter]; // pakt de array met alle oude waarden van de user en zet daar de nieuwe waarden in afhankelijk van de optie
    endforeach;
    return $userInformation;
}

function updateUserPhone() {
    $userPhoneInformation = array(
        ":phone_number"=>$_POST['phone-number'],
        ":username"=>$_SESSION['name']
    );
    User::updateUserPhoneNumber($userPhoneInformation);
}

//if($correct) {
//    $user = User::getUser($_SESSION['name']);
//    $changes = array(":username"=>$_SESSION['name'],":gebruikersnaam"=>$_POST["username"], ":adress"=>$_POST["adress"], ":adress2"=>$_POST["adress2"], ":postcode"=>$_POST["postcode"],":place"=>$_POST["place"],
//        ":country"=>$_POST["country"], ":email"=>$_POST["email"], ":question"=>$_POST["secret-question"], ":answer"=>$_POST["secret-answer"]);
//    User::updateUser($changes);
//    if(!empty($_FILES)){
//        if ($_FILES['img']) {
//            deleteFile("upload/users/".$_SESSION['name'].".png");
//            imagepng(imagecreatefromstring(file_get_contents($_FILES['img']['tmp_name'])), "upload/users/".$_SESSION['name'].".png");
//        }
//    }
//    if(!empty($_POST["password"]) && !empty($_POST["confirmation"])){
//        if($_POST["password"] == $_POST["confirmation"]){
//            User::updatePassword($_SESSION['name'], password_hash($_POST["password"], PASSWORD_DEFAULT));
//            header("Location: profile.php");
//        } else {
//            $err = "Passwords did not match";
//        }
//    } else {
//        header("Location: profile.php");
//    }
//    # geef de gebruiker een notificatie
//}

?>
