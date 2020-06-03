<?php

class Buyer
{

    static function getBoughtFrom($user)
    {
        global $dbh;
        $data = $dbh->prepare("SELECT DISTINCT Verkoper FROM Voorwerp WHERE Koper = :user");
        $data->execute([":user" => $user]);
        $result = $data->fetchAll(PDO::FETCH_COLUMN);
        return $result;
    }

    static function getFollowedItems($user)
    {
        global $dbh;
        $data = $dbh->prepare("SELECT * FROM Favorieten F inner join Voorwerp V on F.Voorwerp = V.Voorwerpnummer WHERE F.Gebruiker = :user");
        $data->execute([":user" => $user]);
        $result = $data->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    static function unFollowItem($user, $item)
    {
        global $dbh;
        $data = $dbh->prepare("DELETE FROM Favorieten WHERE Gebruiker = :user AND Voorwerp = :item");
        $data->execute([":item" => $item, ":user" => $user]);
    }

    static function getSearchTriggers($user)
    {
        global $dbh;
        $data = $dbh->prepare("SELECT Zoekwoord FROM SearchTrigger WHERE Gebruiker = :user");
        $data->execute([":user" => $user]);
        $result = $data->fetchAll(PDO::FETCH_COLUMN);
        return $result;
    }

    static function addSearchTrigger($user, $search)
    {
        global $dbh;
        $data = $dbh->prepare("INSERT INTO SearchTrigger VALUES (:search, :user)");
        $data->execute([":user" => $user, ":search" => $search]);
    }

    static function triggerFollowers($title, $message, $link)
    {
        global $dbh;
        $keywords = explode(" ", $title);
        $data = $dbh->prepare("SELECT Gebruiker FROM SearchTrigger WHERE Zoekwoord = :keyword");
        foreach ($keywords as $keyword) {
            $data->execute([":keyword" => $keyword]);
            while ($row = $data->fetch(PDO::FETCH_COLUMN)) {
                User::notifyUser($row, $message, $link);
            }
        }

    }
}