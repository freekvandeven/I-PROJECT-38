<?php
require_once('db-config.php');
$dbh = connectToDatabase();
function connectToDatabase(){
    global $host;
    global $dbname;
    global $username;
    global $password;
    global $options;
    global $serverType;
    try {
        $dbh = new PDO("$serverType:host=$host;dbname=$dbname", $username, $password, $options);
        return $dbh;
    }catch(PDOException $e){
        echo $e->getMessage();
        return null;
    }
}

function getUser($username){
    global $dbh;
    $data = $dbh->prepare("SELECT * FROM Gebruiker WHERE gebruikersnaam = :username");
    $data->execute([":username"=>$username]);
    $user = $data->fetch(PDO::FETCH_ASSOC);
    return $user;
}

function insertUser($user, $telefoon){
    global $dbh;
    $data = $dbh->prepare('INSERT INTO Gebruiker (Gebruikersnaam, Voornaam, Achternaam, Adresregel_1, Adresregel_2, 
                       Postcode, Plaatsnaam, Land, Geboortedag, Mailbox, Wachtwoord, Vraag, Antwoordtekst, Verkoper, action) VALUES (:Gebruikersnaam,:Voornaam,:Achternaam,:Adresregel_1,
                                                                                                                                     :Adresregel_2  ,:Postcode,:Plaatsnaam,:Land,:Geboortedag,
                                                                                                                                     :Mailbox,:Wachtwoord,:Vraag,:Antwoordtekst,:Verkoper,:Action)');
    $data->execute($user);
    $data = $dbh->prepare('INSERT INTO GebruikersTelefoon (Gebruiker, Telefoon) VALUES (:Gebruikersnaam, :Telefoon)');
    $data->execute(array(":Gebruikersnaam"=>$user["Gebruikersnaam"], ":Telefoon"=>$telefoon));
    //array_unshift($array, $id)
    /*
    $sql = sprintf('SELECT * FROM user WHERE name LIKE :name %s %s',
        !empty($_GET['city'])   ? 'AND city   = :city'   : null,
        !empty($_GET['gender']) ? 'AND gender = :gender' : null);
    if (!empty($_GET['city'])) {
        $stmt->bindParam(':city', '%'.$_GET['city'].'%', PDO::PARAM_STR);
    }
    */
}
