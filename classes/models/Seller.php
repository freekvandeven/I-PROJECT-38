<?php

class Seller{


    static function getSellers(){
        global $dbh;
        $data = $dbh->prepare('SELECT * FROM Verkoper');
        $data->execute();
        $result = $data->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


}
