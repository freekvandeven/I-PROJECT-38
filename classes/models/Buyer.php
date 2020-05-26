<?php

class Buyer {

    static function getBoughtFrom($user){
        global $dbh;
        $data = $dbh->prepare("SELECT DISTINCT Verkoper FROM Voorwerp WHERE Koper = :user");
        $data->execute([":user"=>$user]);
        $result = $data->fetchAll(PDO::FETCH_COLUMN);
        return $result;
    }
}