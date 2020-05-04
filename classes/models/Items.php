<?php

class Items{

    static function insertItem($item)
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

    static function getBuyerItems($buyer){
        global $dbh;
        $data = $dbh->prepare('SELECT * FROM Voorwerp WHERE Koper =:buyer');
        $data->execute([":buyer"=>$buyer]);
        $result = $data->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    static function getSellerItems($seller){
        global $dbh;
        $data = $dbh->prepare('SELECT * FROM Voorwerp WHERE Verkoper =:seller');
        $data->execute([":seller"=>$seller]);
        $result = $data->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    static function get_ItemId()
    {
        global $dbh;
        $data = $dbh->prepare('SELECT MAX(Voorwerpnummer) as nieuwId FROM Voorwerp');
        $data->execute();
        $result = $data->fetch(PDO::FETCH_ASSOC);
        return $result['nieuwId'];
    }

    static function getItem($item){
        global $dbh;
        $data = $dbh->prepare('SELECT * FROM Voorwerp WHERE Voorwerpnummer = :itemId');
        $data->execute([":itemId"=>$item]);
        $result = $data->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    static function getItems(){
        global $dbh;
        $data = $dbh->prepare('SELECT * FROM Voorwerp');
        $data->execute();
        $result = $data->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    static function getFinishedItems(){
        global $dbh;
        $data = $dbh->prepare('SELECT * FROM Voorwerp WHERE VeilingGesloten = "Niet" && (LooptijdEindeDag < :vandaag  || 
                             (LooptijdEindeDag = :vandaag && LooptijdEindeTijdstip < :moment))');
        $data->execute(array(":vandaag"=>date("Y-m-d"),":moment"=>date("H:i:s")));
        $result = $data->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    static function finishItem($item){
        global $dbh;
        $data = $dbh->prepare('UPDATE Voorwerp SET VeilingGesloten= "Wel" WHERE Voorwerpnummer = :item');
        $data->execute([":item"=>$item]);
    }

    static function getBids($item){
        global $dbh;
        $data = $dbh->prepare('SELECT * FROM Bod WHERE Voorwerp = :voorwerpID ORDER BY Bodbedrag DESC');
        $data->execute([":voorwerpID"=>$item]);
        $result = $data->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    static function getHighestBid($item){
        global $dbh;
        $data = $dbh->prepare('SELECT max(Bodbedrag) FROM Bod WHERE Voorwerp = :voorwerpID');
        $data->execute([":voorwerpID"=>$item]);
        $result = $data->fetch(PDO::FETCH_NUM);
        return $result[0];
    }

    static function placeBid($item, $price, $user){
        global $dbh;
        $data = $dbh->prepare('INSERT INTO Bod (Voorwerp, Bodbedrag, Gebruiker, BodDag, BodTijdstip) VALUES (:voorwerp, :bodbedrag, :user, :boddag, :bodtijdstip)');
        $data->execute(array(":voorwerp"=>$item,":bodbedrag"=>$price, ":user"=>$user, ":boddag"=>date('Y-m-d'),":bodtijdstip"=>date("H:i:s")));
    }
}
