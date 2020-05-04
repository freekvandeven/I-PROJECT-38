<?php


class User{

    static function getUser($username){
        global $dbh;
        $data = $dbh->prepare("SELECT * FROM Gebruiker WHERE gebruikersnaam = :username");
        $data->execute([":username" => $username]);
        $user = $data->fetch(PDO::FETCH_ASSOC);
        return $user;
    }
}