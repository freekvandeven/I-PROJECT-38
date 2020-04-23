<?php
require_once('db-config.php');
$dbh = connectToDatabase();
function connectToDatabase()
{
    global $host;
    global $dbname;
    global $username;
    global $password;
    global $options;
    global $serverType;
    try {
        $dbh = new PDO("$serverType:host=$host;dbname=$dbname", $username, $password, $options);
        return $dbh;
    } catch (PDOException $e) {
        echo $e->getMessage();
        return null;
    }
}

function getUser($username)
{
    global $dbh;
    $data = $dbh->prepare("SELECT * FROM Gebruiker WHERE gebruikersnaam = :username");
    $data->execute([":username" => $username]);
    $user = $data->fetch(PDO::FETCH_ASSOC);
    return $user;
}

function upgradeUser($user, $info)
{
    global $dbh;
    $data = $dbh->prepare("UPDATE Gebruiker SET action=TRUE WHERE gebruikersnaam = :username");
    $data->execute([":username" => $user]);
    $data = $dbh->prepare("INSERT INTO Verkoper (Gebruiker, Bank, Bankrekening, ControleOptie, Creditcard) VALUES 
                                                                                       (:username, :bank, :bankrekening, :controle, :creditcard)");
    $data->execute([":username" => $user, ":bank" => $info["bank"], ":bankrekening" => $info["rekening"], ":controle" => $info["controle"], ":creditcard" => $info["creditcard"]]);
}

function insertUser($user, $telefoon)
{
    global $dbh;
    $data = $dbh->prepare('INSERT INTO Gebruiker (Gebruikersnaam, Voornaam, Achternaam, Adresregel_1, Adresregel_2, 
                       Postcode, Plaatsnaam, Land, Geboortedag, Mailbox, Wachtwoord, Vraag, Antwoordtekst, Verkoper, action) VALUES (:Gebruikersnaam,:Voornaam,:Achternaam,:Adresregel_1,
                                                                                                                                     :Adresregel_2  ,:Postcode,:Plaatsnaam,:Land,:Geboortedag,
                                                                                                                                     :Mailbox,:Wachtwoord,:Vraag,:Antwoordtekst,:Verkoper,:Action)');
    $data->execute($user);
    $data = $dbh->prepare('INSERT INTO GebruikersTelefoon (Gebruiker, Telefoon) VALUES (:Gebruikersnaam, :Telefoon)');
    $data->execute(array(":Gebruikersnaam" => $user["Gebruikersnaam"], ":Telefoon" => $telefoon));
}

function insertItem($item)
{
    global $dbh;
    $data = $dbh->prepare('INSERT INTO Voorwerp (Titel,Beschrijving,Startprijs,Betalingswijze,Betalingsinstructie,Plaatsnaam,Land,Looptijd,
                                      LooptijdBeginDag,LooptijdBeginTijdstip,Verzendkosten,Verzendinstructies,Verkoper,LooptijdEindeDag,
                                      LooptijdEindeTijdstip,VeilingGesloten,Verkoopprijs) 
                                      VALUES              (:Titel,:Beschrijving,:Startprijs,:Betalingswijze,:Betalingsinstructie,:Plaatsnaam,:Land,:Looptijd,
                                      :LooptijdBeginDag,:LooptijdBeginTijdstip,:Verzendkosten,:Verzendinstructies,:Verkoper,:LooptijdEindeDag,
                                      :LooptijdEindeTijdstip,:VeilingGesloten,:Verkoopprijs)');
    $data->execute($item);
}

function get_ItemId()
{
    global $dbh;
    $data = $dbh->prepare('SELECT MAX(Voorwerpnummer) as nieuwId FROM Voorwerp');
    $data->execute();
    $result = $data->fetch(PDO::FETCH_ASSOC);
    return $result['nieuwId'];
}

function selectFromCatalog($orders)
{
    global $dbh;
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $execute = array();
    $sql = "SELECT * FROM Voorwerp ";
    foreach ($orders as $key => $order) {
        if (!empty($order)) {
            if (strpos($key, ":where") !== false) {
                $sql .= " WHERE " . $key;
                $execute[":where"] = $order;
            } else if (strpos($key, ":and") !== false) {
                $sql .= " AND " . $key;
                $execute[":and"] = $order;
            } else if (strpos($key, ":order") !== false) {
                $sql .= " ORDER BY " . $key;
                $execute[":order"] = $order;
            } else if (strpos($key, ":limit") !== false) {
                $sql .= " LIMIT " . $key;
                $execute["limit"] = $order;
            }
        }
    }
    $data = $dbh->prepare($sql);
    $data->execute($execute);
    return $data->fetchAll(PDO::FETCH_ASSOC);
}