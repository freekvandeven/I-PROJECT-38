<?php

class Buyer {

    static function getBoughtFrom($user){
        global $dbh;
        $data = $dbh->prepare("SELECT DISTINCT Verkoper FROM Voorwerp WHERE Koper = :user");
        $data->execute([":user"=>$user]);
        $result = $data->fetchAll(PDO::FETCH_COLUMN);
        return $result;
    }

    static function getFollowedItems($user){
        global $dbh;
        $data = $dbh->prepare("SELECT * FROM Favorieten F inner join Voorwerp V on F.Voorwerp = V.Voorwerpnummer WHERE F.Gebruiker = :user");
        $data->execute([":user"=>$user]);
        $result = $data->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    static function unFollowItem($user, $item){
        global $dbh;
        $data = $dbh->prepare("DELETE FROM Favorieten WHERE Gebruiker = :user AND Voorwerp = :item");
        $data->execute([":item"=>$item, ":user"=>$user]);
    }
}