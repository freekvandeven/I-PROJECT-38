<?php
/*
 * updateController handles updateInformation from profilePage.
 */
# get all current user information
$user = User::getUser($_SESSION['name']);
$userInformation = array(":adress"=>$user['Adresregel_1'], ":adress2"=>$user['Adresregel_2'], ":postcode"=>$user['Postcode'], ":place"=>$user['Plaatsnaam'],
    ":country"=>$user['Land'], ":email"=>$user['Mailbox'], ":question"=>$user['Vraag'], ":answer"=>$user['Antwoordtekst'], ":username"=>$_SESSION['name']
); // oude informatie van de user, deze worden vervangen afhankelijk van de optie/view

$filledFields = array(
    'persoonsgegevens' => array('email', 'adress', 'phone-number', 'country', 'place', 'postcode'),
    'inloggegevens' => array('password', 'confirmation'),
    'beveiligingsgegevens' => array('question', 'answer'),
    'verkopersgegevens' => array('bank', 'bankrekening', 'controlenummer', 'creditcard'),
    'algemeen'=>array('question', 'answer', 'email', 'phone-number', 'adress', 'country', 'place', 'postcode')
); // alle verplichte velden per view/optie, de optionele worden hier later bij toegevoegd om ze te updaten.

if(isset($_GET['option'])) {
    if($_GET['option'] == 'persoonsgegevens') {
        if(checkAllFieldsFilled($filledFields, $_GET['option'])) { // Als alle verplichte velden zijn ingevuld
            $filledFields[$_GET['option']] = ['email', 'adress', 'adress2', 'phone-number', 'country', 'place', 'postcode']; // Voegt adres2 er ook aan toe, want deze moet ook worden geupdate, of die nou empty is of niet
            $changes = setUserNewInformation($filledFields[$_GET['option']], $userInformation); // Maakt een array met alle ingevulde values
            if(!empty(User::getPhoneNumber($_SESSION['name']))) User::updatePhoneNumber($_SESSION['name'], $_POST['phone-number']);
            else User::insertPhoneNumber($_SESSION['name'], $_POST['phone-number']);
            User::updateUser($changes);
            header("Location:profile.php?toast=Gegevens succesvol opgeslagen");
        } else $err = 'Vul alle verplichte velden in!';
    } else if($_GET['option'] == 'inloggegevens') {
        if(checkAllFieldsFilled($filledFields, $_GET['option'])) {
            if($_POST['password'] == $_POST['confirmation']) :
                User::updatePassword($_SESSION['name'], password_hash($_POST["password"], PASSWORD_DEFAULT));
                header("Location:profile.php?toast=Wachtwoord succesvol opgeslagen"); endif;
            if($_POST['password'] != $_POST['confirmation']): $err = 'Wachtwoorden komen niet overeen'; endif;
        } else $err = 'Vul alle verplichte velden in!';
    } else if($_GET['option'] == 'beveiligingsgegevens') {
        if(checkAllFieldsFilled($filledFields, $_GET['option'])) {
            $changes = setUserNewInformation($filledFields[$_GET['option']], $userInformation);
            User::updateUser($changes);
            header("Location:profile.php?toast=Beveilingsgegevens succesvol geüpdate");
        } else $err = 'Vul alle verplichte velden in!';
    } else if($_GET['option'] == 'profielfoto') {
        if($_FILES['img']['size']>0) {
            deleteFile("upload/users/".$_SESSION['name'].".png");
            imagepng(imagecreatefromstring(file_get_contents($_FILES['img']['tmp_name'])), "upload/users/".$_SESSION['name'].".png");
            header("Location:profile.php?toast=Profielfoto succesvol gewijzigd");
        } else $err = 'Kies een nieuwe profielfoto.';
    } else if($_GET['option'] == 'verkopersgegevens') {
        if(checkAllFieldsFilled($filledFields, $_GET['option'])) {
            $newUserSellerInformation = array(":bank"=>$_POST['bank'], ":bankrekening"=>$_POST['bankrekening'], ":controlenummer"=>$_POST['controlenummer'], ":creditcard"=>$_POST['creditcard'], ":username"=>$_SESSION['name']);
            Seller::updateUserSeller($newUserSellerInformation);
            header("Location:profile.php?toast=Verkopersgegevens succesvol geüpdate");
        } else $err = 'Vul alle verplichte velden in!';
    }
} else {
    if(checkAllFieldsFilled($filledFields, 'algemeen')) {
        if($_FILES['img']['size']>0) { // Als een profielfoto is gekozen
            deleteFile("upload/users/".$_SESSION['name'].".png");
            imagepng(imagecreatefromstring(file_get_contents($_FILES['img']['tmp_name'])), "upload/users/".$_SESSION['name'].".png");
        }
        $filledFields['algemeen'] = ['question', 'answer', 'email', 'phone-number', 'adress', 'adress2', 'country', 'place', 'postcode']; // Voegt adres2 eraan toe, want deze moet ook worden geupdate, of die nou empty is of niet
        $changes = setUserNewInformation($filledFields['algemeen'], $userInformation);
        if(!empty(User::getPhoneNumber($_SESSION['name']))) User::updatePhoneNumber($_SESSION['name'], $_POST['phone-number']);
        else User::insertPhoneNumber($_SESSION['name'], $_POST['phone-number']);

        User::updateUser($changes);
        if(isset($_POST['password']) && isset($_POST['confirmation'])) { // Als de 2 passwordvelden ingevuld zijn
            if($_POST['password'] == $_POST['confirmation']) {
                User::updatePassword($_SESSION['name'], password_hash($_POST["password"], PASSWORD_DEFAULT));
                header("Location:profile.php?toast=Profiel succesvol bijgewerkt!");
            } else $err = 'Wachtwoorden komen niet overeen!';
        } else header("Location:profile.php?toast=Profiel succesvol bijgewerkt!");
    } else $err = 'Vul alle verplichte velden in!';
}

function checkAllFieldsFilled($filledFields, $categorie) {
    foreach ($filledFields[$categorie] as $value):
        if(empty($_POST[$value])) : return false; endif;
    endforeach;
    return true;
}

function setUserNewInformation($filledFields, $userInformation) {
    foreach ($filledFields as $parameter): // pakt de array met alle oude waarden van de user en zet daar de nieuwe waarden in afhankelijk van de optie
        if($parameter != 'phone-number'):$userInformation[':'.$parameter] = $_POST[$parameter]; endif; // het telefoonnr moet niet in de tabel Gebruiker komen, daarom wordt deze niet meegenomen
    endforeach;
    return $userInformation;
}

?>
