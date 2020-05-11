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

    static function ratedUser($giver,$receiver){
        global $dbh;
        $data = $dbh->prepare('SELECT count(*) FROM Beoordeling WHERE GegevenDoor = :giver AND Gebruikersnaam = :receiver');
        $data->execute([':giver'=>$giver,':receiver'=>$receiver]);
        $result = $data->fetchColumn();
        return $result;
    }
}
