<?php

class Items
{

    static function insertItem($item)
    {
        global $dbh;
        $data = $dbh->prepare('INSERT INTO Voorwerp (Titel,Beschrijving,Startprijs,Betalingswijze,Betalingsinstructie,Plaatsnaam,Land,Looptijd,
                                      LooptijdBeginDag,LooptijdBeginTijdstip,Verzendkosten,Verzendinstructies,Verkoper,LooptijdEindeDag,
                                      LooptijdEindeTijdstip,VeilingGesloten,Verkoopprijs)
                                      VALUES              (:Titel,:Beschrijving,:Startprijs,:Betalingswijze,:Betalingsinstructie,:Plaatsnaam,:Land,:Looptijd,
                                      :LooptijdBeginDag,:LooptijdBeginTijdstip,:Verzendkosten,:Verzendinstructies,:Verkoper,:LooptijdEindeDag,
                                      :LooptijdEindeTijdstip,:VeilingGesloten,:Verkoopprijs)');
        return $data->execute($item);
    }

    static function insertIntoRubriek($itemId, $rubriekNummer)
    {
        global $dbh;
        $data = $dbh->prepare('INSERT INTO VoorwerpInRubriek (Voorwerp,RubriekOpLaagsteNiveau) VALUES(:Voorwerp,:RubriekOpLaagsteNiveau)');
        return $data->execute([":Voorwerp" => $itemId, ":RubriekOpLaagsteNiveau" => $rubriekNummer]);
    }

    static function getBuyerItems($buyer)
    {
        global $dbh;
        $data = $dbh->prepare('SELECT DISTINCT Voorwerpnummer, Titel, Startprijs, Betalingswijze, Betalingsinstructie, Plaatsnaam, Land,
                Looptijd, Verkoper, Koper, VeilingGesloten FROM Voorwerp v RIGHT OUTER JOIN Bod b ON b.Voorwerp=v.Voorwerpnummer WHERE Koper=:buyer1 OR Gebruiker=:buyer');
        $data->execute([":buyer" => $buyer, ":buyer1" => $buyer]);
        $result = $data->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    static function getSellerItems($seller)
    {
        global $dbh;
        $data = $dbh->prepare('SELECT * FROM Voorwerp WHERE Verkoper =:seller');
        $data->execute([":seller" => $seller]);
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

    static function getItem($item)
    {
        global $dbh;
        $data = $dbh->prepare('SELECT * FROM Voorwerp WHERE Voorwerpnummer = :itemId');
        $data->execute([":itemId" => $item]);
        $result = $data->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    static function getItems()
    {
        global $dbh;
        $data = $dbh->prepare('SELECT * FROM Voorwerp');
        $data->execute();
        $result = $data->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    static function getFinishedItems()
    {
        global $dbh;
        $data = $dbh->prepare("SELECT * FROM Voorwerp WHERE VeilingGesloten='Nee' AND (LooptijdEindeDag < :vandaag  OR
                            (LooptijdEindeDag = :vandaag2 AND LooptijdEindeTijdstip < :moment))");
        #$data = $dbh->prepare("SELECT * FROM Voorwerp WHERE VeilingGesloten='Nee' AND LooptijdEindeDag < :vandaag");
        $data->execute(array(":vandaag" => date("Y-m-d"), ":vandaag2" => date("Y-m-d"), ":moment" => date("H:i:s")));
        $result = $data->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    static function finishItem($item, $buyer, $sellprice)
    {
        global $dbh;
        $data = $dbh->prepare("UPDATE Voorwerp SET VeilingGesloten='Wel', Koper=:buyer, Verkoopprijs=:sellprice WHERE Voorwerpnummer = :item");
        $data->execute([":item" => $item, ":buyer" => $buyer, ":sellprice" => $sellprice]);
    }

    static function getBids($item)
    {
        global $dbh;
        $data = $dbh->prepare('SELECT CAST(Bodbedrag AS decimal(10,2)) AS Bodbedrag, Voorwerp, Gebruiker FROM Bod WHERE Voorwerp = :voorwerpID ORDER BY Bodbedrag DESC');
        $data->execute([":voorwerpID" => $item]);
        $result = $data->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    static function getHighestBid($item)
    {
        global $dbh;
        $data = $dbh->prepare('SELECT CAST(Bodbedrag as decimal(10,2)) AS Bodbedrag, Gebruiker FROM Bod WHERE Voorwerp = :voorwerpID AND Gebruiker is not null ORDER BY 1 DESC');
        $data->execute([":voorwerpID" => $item]);
        $result = $data->fetchAll(PDO::FETCH_ASSOC);
        return $result[0];
    }

    static function placeBid($item, $price, $user)
    {
        global $dbh;
        $data = $dbh->prepare('INSERT INTO Bod (Voorwerp, Bodbedrag, Gebruiker, BodDag, BodTijdstip) VALUES (:voorwerp, :bodbedrag, :user, :boddag, :bodtijdstip)');
        $data->execute(array(":voorwerp" => $item, ":bodbedrag" => $price, ":user" => $user, ":boddag" => date('Y-m-d'), ":bodtijdstip" => date("H:i:s")));
    }

    static function getRubrieken()
    {
        global $dbh;
        $data = $dbh->prepare('SELECT Rubrieknaam, Rubrieknummer FROM Rubriek');
        $data->execute();
        $result = $data->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    static function soldToUser($koper, $verkoper)
    {
        global $dbh;
        $data = $dbh->prepare('SELECT count(*) FROM Voorwerp WHERE Verkoper = :verkoper AND Koper = :koper');
        $data->execute([":koper" => $koper, ':verkoper' => $verkoper]);
        $result = $data->fetchColumn();
        return $result;
    }

    static function addView($id)
    {
        global $dbh;
        $data = $dbh->prepare('UPDATE Voorwerp set Views = Views + 1 where voorwerpnummer = :id');
        $data->execute(["id"=>$id]);
    }

    static function getCategories()
    {
        global $dbh;
        $sql = "SELECT r.Rubrieknummer as hoofdnummer, r.Rubrieknaam as hoofdnaam, t.Rubrieknummer as subnummer, t.Rubrieknaam as subnaam, y.Rubrieknummer as subsubnummer, y.Rubrieknaam as subsubnaam 
        FROM Rubriek r left join Rubriek t on t.Rubriek = r.Rubrieknummer left join Rubriek y on y.Rubriek = t.Rubrieknummer WHERE r.Rubriek = -1 ORDER BY r.Rubrieknummer, t.Rubrieknummer, y.Rubrieknummer
";
        $data = $dbh->query($sql);
        $result = $data->fetchAll(PDO::FETCH_ASSOC);
        $filtered = [];
        foreach($result as $row){
            $filtered[$row['hoofdnaam']][$row['subnaam']] = $row['subsubnaam'];
        }
        return $filtered;
    }
}
