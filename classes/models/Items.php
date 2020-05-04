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

}
