<?php


class User{

    static function getUser($username){
        global $dbh;
        $data = $dbh->prepare("SELECT * FROM Gebruiker WHERE gebruikersnaam = :username");
        $data->execute([":username" => $username]);
        $user = $data->fetch(PDO::FETCH_ASSOC);
        return $user;
    }
    static function updateUser($user)
    {
        global $dbh;
        $data = $dbh->prepare("UPDATE Gebruiker SET Gebruikersnaam=:gebruikersnaam, Adresregel_1=:adress, Adresregel_2=:adress2, Postcode=:postcode, 
                     Plaatsnaam=:place, Land=:country, Mailbox=:email, Vraag=:question, Antwoordtekst=:answer
                                    WHERE Gebruikersnaam = :username");
        $data->execute($user);
    }

    static function updatePassword($username, $password)
    {
        global $dbh;
        $data = $dbh->prepare("UPDATE Gebruiker SET Wachtwoord=:password WHERE Gebruikersnaam = :username");
        $data->execute([":username" => $username, ":password" => $password]);
    }

    static function upgradeUser($user, $info)
    {
        global $dbh;
        $data = $dbh->prepare("UPDATE Gebruiker SET Verkoper=1 WHERE gebruikersnaam = :username");
        $data->execute([":username" => $user]);
        $data = $dbh->prepare("INSERT INTO Verkoper (Gebruiker, Bank, Bankrekening, ControleOptie, Creditcard) VALUES 
                                                                                       (:username, :bank, :bankrekening, :controle, :creditcard)");
        $data->execute([":username" => $user, ":bank" => $info["bank"], ":bankrekening" => $info["rekening"], ":controle" => $info["controle"], ":creditcard" => $info["creditcard"]]);
    }

    static function insertUser($user)
    {
        global $dbh;
        $data = $dbh->prepare("INSERT INTO Gebruiker (Gebruikersnaam, Voornaam, Achternaam, Adresregel_1, Adresregel_2, 
                       Postcode, Plaatsnaam, Land, Geboortedag, Mailbox, Wachtwoord, Vraag, Antwoordtekst, Verkoper, Action, Bevestiging) VALUES (:Gebruikersnaam,:Voornaam,:Achternaam,:Adresregel_1,
                                                                                                                                     :Adresregel_2  ,:Postcode,:Plaatsnaam,:Land,:Geboortedag,
                                                                                                                                     :Mailbox,:Wachtwoord,:Vraag,:Antwoordtekst,:Verkoper,:Action, :Bevestiging)");
        $data->execute($user);
        //$data = $dbh->prepare('INSERT INTO GebruikersTelefoon (Gebruiker, Telefoon) VALUES (:Gebruikersnaam, :Telefoon)');
        //$data->execute(array(":Gebruikersnaam" => $user["Gebruikersnaam"], ":Telefoon" => $telefoon));
    }

    static function getQuestions()
    {
        global $dbh;
        $data = $dbh->prepare('SELECT Vraagnummer, TekstVraag FROM Vraag');
        $data->execute();
        $result = $data->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    static function getQuestion($number)
    {
        global $dbh;
        $data = $dbh->prepare('SELECT TekstVraag FROM Vraag WHERE Vraagnummer=:question');
        $data->execute([":question" => $number]);
        $result = $data->fetch(PDO::FETCH_NUM);
        return $result[0];
    }

    static function makeUser($username){
        global $dbh;
        $stmt = $dbh->prepare('UPDATE Gebruiker SET Bevestiging=1 WHERE Gebruikersnaam =:username');
        $stmt->execute([":username" => $username]);
    }
}