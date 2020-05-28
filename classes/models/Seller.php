<?php

class Seller{


    static function getSellers(){
        global $dbh;
        $data = $dbh->prepare('SELECT * FROM Verkoper');
        $data->execute();
        $result = $data->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    static function commentedOnUser($giver,$receiver){
        global $dbh;
        $data = $dbh->prepare('SELECT count(*) FROM Comments WHERE FeedbackGever = :giver AND gebruikersnaam = :receiver');
        $data->execute([':giver'=>$giver,':receiver'=>$receiver]);
        $result = $data->fetchColumn();
        return $result;
    }

    static function updateUserSeller($UserNewSellerInformation)
    {
        global $dbh;
        $data = $dbh->prepare("UPDATE Verkoper SET Bank=:bank, Bankrekening=:bankrekening, ControleOptie=:controlenummer, Creditcard=:creditcard
                                    WHERE Gebruiker = :username");
        $data->execute($UserNewSellerInformation);
    }

    static function getSeller($username)
    {
        global $dbh;
        $data = $dbh->prepare("SELECT * FROM Verkoper WHERE Gebruiker = :username");
        $data->execute([":username" => $username]);
        $seller = $data->fetch(PDO::FETCH_ASSOC);
        return $seller;
    }

    static function ratedUser($giver,$receiver){
        global $dbh;
        $data = $dbh->prepare('SELECT count(*) FROM Beoordeling WHERE GegevenDoor = :giver AND Gebruikersnaam = :receiver');
        $data->execute([':giver'=>$giver,':receiver'=>$receiver]);
        $result = $data->fetchColumn();
        return $result;
    }

    static function getSoldTo($user){
        global $dbh;
        $data = $dbh->prepare("SELECT DISTINCT Koper FROM Voorwerp WHERE Verkoper = :user AND NOT Koper IS NULL");
        $data->execute([":user"=>$user]);
        $result = $data->fetchAll(PDO::FETCH_COLUMN);
        return $result;
    }
}
