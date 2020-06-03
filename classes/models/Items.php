<?php

class Items
{

    static function insertItem($item)
    {
        global $dbh;
        $data = $dbh->prepare('INSERT INTO Voorwerp (Titel,Beschrijving,Startprijs,Betalingswijze,Betalingsinstructie,Plaatsnaam,Land,
                                      LooptijdBeginTijdstip,Verzendkosten,Verzendinstructies,Verkoper,
                                      LooptijdEindeTijdstip,VeilingGesloten,Verkoopprijs)
                                      VALUES              (:Titel,:Beschrijving,:Startprijs,:Betalingswijze,:Betalingsinstructie,:Plaatsnaam,:Land,
                                      :LooptijdBeginTijdstip,:Verzendkosten,:Verzendinstructies,:Verkoper,
                                      :LooptijdEindeTijdstip,:VeilingGesloten,:Verkoopprijs)');
        $success = $data->execute($item);
        Items::addKeyWords($item[':Titel'], $item[':Beschrijving']);
        return ($success);
    }

    static function addKeyWords($title, $description = null)
    {
        $keywords = explode(" ", strtolower($title));
        if($description!= null)
        $keywords = array_merge(explode(" ", strtolower($description)), $keywords);
        global $dbh;
        $keywordInsert = $dbh->prepare("exec KeyWordInsert ?");
        $keywordInsert->bindParam(1, $keyword);
        foreach ($keywords as $keyword) {
                $keyword = preg_replace('/\PL/u', '', $keyword);
                $keyword = strtolower($keyword);
            if(strlen($keyword)>2) {
                $keywordInsert->execute();
                Items::addKeyWordLink(Items::getKeyWordId($keyword)['KeyWordNummer'], Items::get_ItemId());
            }
        }
    }

    static function addKeyWordLink($keywordId, $itemId)
    {
        global $dbh;
        $keywordLinkInsert = $dbh->prepare("exec KeyWordLinkInsert ?, ?");
        $keywordLinkInsert->bindParam(1, $keywordId);
        $keywordLinkInsert->bindParam(2, $itemId);
        $keywordLinkInsert->execute();
    }

    static function getKeyWordId($keyword)
    {
        global $dbh;
        $data = $dbh->prepare("SELECT KeyWordNummer From KeyWords WHERE KeyWord = :KeyWord");
        $data->execute([":KeyWord" => $keyword]);
        return $data->fetch(PDO::FETCH_ASSOC);
    }

    static function insertFile($files)
    {
        global $dbh;
        $data = $dbh->prepare('INSERT INTO Bestand (Filenaam, Voorwerp) 
                                        VALUES (:Filenaam, :Voorwerp)');
        return $data->execute($files);
    }

    static function getBuyerItems($buyer)
    {
        global $dbh;
        $data = $dbh->prepare('SELECT DISTINCT Voorwerpnummer, Titel, Startprijs, Betalingswijze, Betalingsinstructie, Plaatsnaam, Land, 
                LooptijdEindeTijdstip, Verkoper, Koper, VeilingGesloten FROM Voorwerp v RIGHT OUTER JOIN Bod b ON b.Voorwerp=v.Voorwerpnummer WHERE Koper=:buyer1 OR Gebruiker=:buyer');
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

    static function getItemsLimit($limit, $search = '')
    {
        global $dbh;
        $data = $dbh->prepare("SELECT TOP $limit * FROM Voorwerp WHERE Titel LIKE :search");
        $data->execute([":search" => '%' . $search . '%']);
        $result = $data->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    static function getFinishedItems()
    {
        global $dbh;
        $data = $dbh->prepare("SELECT * FROM Voorwerp WHERE VeilingGesloten=0 AND LooptijdEindeTijdstip < :nu ");
        #$data = $dbh->prepare("SELECT * FROM Voorwerp WHERE VeilingGesloten='Nee' AND LooptijdEindeDag < :vandaag");
        $data->execute(array(":nu" => date("Y-m-d H:i:s")));
        $result = $data->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    static function finishItem($item, $buyer, $sellprice)
    {
        global $dbh;
        $data = $dbh->prepare("UPDATE Voorwerp SET VeilingGesloten=1, Koper=:buyer, Verkoopprijs=:sellprice WHERE Voorwerpnummer = :item");
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

    static function placeBid($item, $price, $user, $date)
    {
        global $dbh;
        $data = $dbh->prepare('INSERT INTO Bod (Voorwerp, Bodbedrag, Gebruiker, BodTijdstip) VALUES (:voorwerp, :bodbedrag, :user,  :date)');
        $data->execute(array(":voorwerp" => $item, ":bodbedrag" => $price, ":user" => $user, ":date" => $date));
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
        $data->execute(["id" => $id]);
    }

    static function deleteItem($id)
    {
        global $dbh;
        $data = $dbh->prepare("DELETE FROM Voorwerp where Voorwerpnummer = :id");
        return $data->execute([':id' => $id]);
    }

    static function getFiles($item)
    {
        global $dbh;
        $data = $dbh->prepare("SELECT Filenaam FROM Bestand WHERE Voorwerp = :item AND NOT Filenaam LIKE '%img%'");
        $data->execute([":item" => $item]);
        $result = $data->fetchAll(PDO::FETCH_COLUMN);
        return $result;
    }

    static function getThumbnail($item)
    {
        global $dbh;
        $data = $dbh->prepare("SELECT Filenaam FROM Bestand WHERE Voorwerp = :item AND Filenaam LIKE '%img%'");
        $data->execute([":item" => $item]);
        $result = $data->fetchColumn();
        return $result;
    } //TODO FIX THIS

    static function getFollowers($item)
    {
        global $dbh;
        $data = $dbh->prepare("SELECT Gebruiker FROM Favorieten WHERE Voorwerp = :item");
        $data->execute([":item" => $item]);
        $result = $data->fetchAll(PDO::FETCH_COLUMN);
        return $result;
    }
}
