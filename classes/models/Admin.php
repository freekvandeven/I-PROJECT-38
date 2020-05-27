<?php

class Admin
{

    static function checkPage($currentPage)
    {
        global $dbh;
        $data = $dbh->prepare('SELECT * FROM Pages WHERE PageName=:page');
        $data->execute([":page" => $currentPage]);
        $result = $data->fetchAll();
        return $result;
    }

    static function searchIPVisits($visitor)
    {
        global $dbh;
        $data = $dbh->prepare('SELECT * FROM Visitors WHERE IP = :ip');
        $data->execute([":ip" => $visitor]);
        $result = $data->fetchColumn();
        return $result;
    }

    static function increaseIPVisits($visitor)
    {
        global $dbh;
        $data = $dbh->prepare('UPDATE Visitors SET TotalVisits = TotalVisits + 1 WHERE IP = :ip');
        $data->execute([":ip" => $visitor]);
    }

    static function increasePage($currentPage)
    {
        global $dbh;
        $data = $dbh->prepare('UPDATE Pages SET Visits = Visits + 1 WHERE PageName = :page');
        $data->execute([":page" => $currentPage]);
    }

    static function insertPage($currentPage)
    {
        global $dbh;
        $data = $dbh->prepare('INSERT INTO Pages (PageName, Visits) VALUES (:page, 1)');
        $data->execute([":page" => $currentPage]);
    }

    static function insertVisitorIP($visitorIP)
    {
        global $dbh;
        $data = $dbh->prepare('INSERT INTO Visitors (IP, TotalVisits) VALUES (:ip, 1)');
        $data->execute([":ip" => $visitorIP]);
    }

    static function checkBlacklist($visitorIP)
    {
        global $dbh;
        $data = $dbh->prepare('SELECT * FROM Blacklist WHERE IP=:ip');
        $data->execute([":ip" => $visitorIP]);
        $result = $data->fetchAll();
        return $result;
    }

    static function checkWhiteList($visitorIP)
    {
        global $dbh;
        $data = $dbh->prepare('SELECT * FROM Whitelist WHERE IP=:ip');
        $data->execute([":ip" => $visitorIP]);
        $result = $data->fetchColumn();
        return $result;
    }

    static function getSiteVisits()
    {
        global $dbh;
        $data = $dbh->prepare('SELECT PageName, Visits FROM Pages');
        $data->execute();
        $result = $data->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    static function getBidsPerDay()
    {
        global $dbh;
        $data = $dbh->prepare("SELECT DATEPART(YEAR, BodTijdstip) AS 'Year',
          DATEPART(MONTH, BodTijdstip) AS 'Month',
          DATEPART(DAY, BodTijdstip) AS 'Day', COUNT (*) FROM Bod GROUP BY DATEPART(DAY, BodTijdstip), DATEPART(MONTH, BodTijdstip), DATEPART(YEAR, BodTijdstip) ORDER BY 1,2,3");
        $data->execute();
        $result = $data->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    static function getAuctionsPerDay()
    {
        global $dbh;
        $data = $dbh->prepare("SELECT DATEPART(YEAR, LooptijdEindeTijdstip) AS 'Year',
          DATEPART(MONTH, LooptijdEindeTijdstip) AS 'Month',
          DATEPART(DAY, LooptijdEindeTijdstip) AS 'Day', COUNT (*) FROM Voorwerp GROUP BY DATEPART(DAY, LooptijdEindeTijdstip), DATEPART(MONTH, LooptijdEindeTijdstip), DATEPART(YEAR, LooptijdEindeTijdstip) ORDER BY 1,2,3");
        $data->execute();
        $result = $data->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    static function getUniqueVisitors()
    {
        global $dbh;
        $data = $dbh->prepare("SELECT * FROM Visitors ORDER BY TotalVisits DESC");
        $data->execute();
        $result = $data->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}