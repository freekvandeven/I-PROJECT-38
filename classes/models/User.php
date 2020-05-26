<?php


class User
{

    static function getUser($username)
    {
        global $dbh;
        $data = $dbh->prepare("SELECT * FROM Gebruiker WHERE gebruikersnaam = :username");
        $data->execute([":username" => $username]);
        $user = $data->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    static function getUsers()
    {
        global $dbh;
        $data = $dbh->prepare("SELECT * FROM Gebruiker");
        $data->execute();
        $users = $data->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }
    static function getUsersLimit($limit)
    {
        global $dbh;
        $data = $dbh->prepare("SELECT TOP ".$limit." * FROM Gebruiker");
        $data->execute();
        $users = $data->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }
    static function getNotifications($user)
    {
        global $dbh;
        $data = $dbh->prepare("SELECT Bericht, Link FROM Notificaties WHERE Ontvanger = :user");
        $data->execute([":user"=>$user]);
        $result = $data->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    static function clearNotifications($user)
    {
        global $dbh;
        $data = $dbh->prepare("DELETE FROM Notificaties WHERE Ontvanger = :user");
        $data->execute(["user"=>$user]);
    }

    static function notifyUser($user, $message, $link = '#')
    {
        global $dbh;
        $data = $dbh->prepare("INSERT INTO Notificaties (Bericht, Link, Ontvanger) VALUES (:message, :link, :user)");
        $data->execute([":message"=>$message, ":link"=>$link, ":user"=>$user]);
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
    }

    static function insertPhoneNumber($user, $phone)
    {
        global $dbh;
        $data = $dbh->prepare('INSERT INTO GebruikersTelefoon (Gebruiker, Telefoon) VALUES (:Gebruikersnaam, :Telefoon)');
        $data->execute([":Gebruikersnaam" => $user, ":Telefoon" => $phone]);
    }

    static function getPhoneNumber($user)
    {
        global $dbh;
        $data = $dbh->prepare("SELECT Telefoon FROM GebruikersTelefoon WHERE Gebruiker = :user");
        $data->execute([":user"=>$user]);
        $result = $data->fetchAll(PDO::FETCH_COLUMN);
        return $result;
    }

    static function insertFavorites($user, $itemID)
    {
        global $dbh;
        $data = $dbh->prepare('INSERT INTO Favorieten (Gebruiker, Voorwerp) VALUES (:Gebruiker, :Voorwerp)');
        $data->execute([":Gebruiker" => $user, ":Voorwerp" => $itemID]);
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

    static function makeUser($username)
    {
        global $dbh;
        $data = $dbh->prepare('UPDATE Gebruiker SET Bevestiging=1 WHERE Gebruikersnaam =:username');
        $data->execute([":username" => $username]);
    }

    static function reviewUser($user, $giver, $feedback)
    {
        global $dbh;
        $data = $dbh->prepare('INSERT INTO Comments (Gebruikersnaam, FeedbackGever, Feedback) VALUES (:gebruiker, :gever, :feedback)');
        $data->execute([":gebruiker" => $user, ":gever" => $giver, ":feedback" => $feedback]);
    }

    static function getAllComments($user)
    {
        global $dbh;
        $data = $dbh->prepare('SELECT * FROM Comments WHERE Gebruikersnaam = :gebruiker');
        $data->execute([":gebruiker" => $user]);
        $result = $data->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    static function validateEmail($email)
    {
        global $dbh;
        $data = $dbh->prepare('SELECT count(Mailbox) FROM gebruiker WHERE Mailbox = :email');
        $data->execute([":email" => $email]);
        $result = $data->fetchAll(PDO::FETCH_ASSOC);
        return $result[0];
    }

    static function getUserWithEmail($email)
    {
        global $dbh;
        $data = $dbh->prepare("SELECT * FROM Gebruiker WHERE Mailbox = :email");
        $data->execute([":email" => $email]);
        $result = $data->fetchAll(PDO::FETCH_ASSOC);
        return $result[0];
    }

    static function deleteUser($name){
        global $dbh;
        $data = $dbh->prepare("ALTER TABLE Bod NOCHECK FK_Bod_gebruikersnaam");
        $data->execute();
        $data = $dbh->prepare("UPDATE Bod SET Gebruiker = NULL WHERE Gebruiker = :gebruiker");
        $data->execute([":gebruiker"=>$name]);
        $data = $dbh->prepare("ALTER TABLE Bod CHECK FK_Bod_gebruikersnaam");
        $data->execute();
        $data = $dbh->prepare("DELETE FROM Verkoper  WHERE Gebruiker = :gebruiker");
        $data->execute([":gebruiker"=>$name]);
        $data = $dbh->prepare("UPDATE Voorwerp SET Verkoper = NULL WHERE Verkoper = :gebruiker");
        $data->execute([":gebruiker"=>$name]);
        $data = $dbh->prepare("UPDATE Voorwerp SET Koper = NULL WHERE Koper = :gebruiker");
        $data->execute([":gebruiker"=>$name]);
        $data = $dbh->prepare("UPDATE Beoordeling SET Gebruikersnaam = NULL WHERE Gebruikersnaam = :gebruiker");
        $data->execute([":gebruiker"=>$name]);
        $data = $dbh->prepare("UPDATE Beoordeling SET GegevenDoor = NULL WHERE GegevenDoor = :gebruiker");
        $data->execute([":gebruiker"=>$name]);
        $data = $dbh->prepare("UPDATE Comments SET Gebruikersnaam = NULL WHERE Gebruikersnaam = :gebruiker");
        $data->execute([":gebruiker"=>$name]);
        $data = $dbh->prepare("UPDATE Comments SET FeedbackGever = NULL WHERE FeedbackGever = :gebruiker");
        $data->execute([":gebruiker"=>$name]);
        $data = $dbh->prepare("DELETE FROM Gebruiker WHERE Gebruikersnaam = :gebruiker");
        return $data->execute([":gebruiker"=>$name]);
    }

    static function nukeUser($name){
        global $dbh;
        $data = $dbh->prepare("DELETE FROM Bod WHERE Gebruiker = :gebruiker");
        $data->execute([":gebruiker"=>$name]);
        $data = $dbh->prepare("DELETE FROM Verkoper  WHERE Gebruiker = :gebruiker");
        $data->execute([":gebruiker"=>$name]);
        $data = $dbh->prepare("DELETE FROM Voorwerp WHERE Verkoper = :gebruiker");
        $data->execute([":gebruiker"=>$name]);
        $data = $dbh->prepare("DELETE FROM Voorwerp WHERE Koper = :gebruiker");
        $data->execute([":gebruiker"=>$name]);
        $data = $dbh->prepare("DELETE FROM Beoordeling WHERE Gebruikersnaam = :gebruiker");
        $data->execute([":gebruiker"=>$name]);
        $data = $dbh->prepare("DELETE FROM Beoordeling WHERE GegevenDoor = :gebruiker");
        $data->execute([":gebruiker"=>$name]);
        $data = $dbh->prepare("DELETE FROM Comments WHERE Gebruikersnaam = :gebruiker");
        $data->execute([":gebruiker"=>$name]);
        $data = $dbh->prepare("DELETE FROM Comments WHERE FeedbackGever = :gebruiker");
        $data->execute([":gebruiker"=>$name]);
        $data = $dbh->prepare("DELETE FROM Gebruiker WHERE Gebruikersnaam = :gebruiker");
        return $data->execute([":gebruiker"=>$name]);
    }
}
