<?php

class Category
{

    static function getCategories()
    {
        global $dbh;
        $sql = "SELECT r.Rubrieknummer as hoofdnummer, r.Rubrieknaam as hoofdnaam, t.Rubrieknummer as subnummer, t.Rubrieknaam as subnaam, y.Rubrieknummer as subsubnummer, y.Rubrieknaam as subsubnaam, z.Rubrieknummer as subsubsubnummer, z.Rubrieknaam as subsubsubnaam 
                FROM Rubriek r left join Rubriek t on t.Rubriek = r.Rubrieknummer left join Rubriek y on y.Rubriek = t.Rubrieknummer left join Rubriek z on z.Rubriek = y.Rubrieknummer WHERE r.Rubriek = -1 
                ORDER BY r.Rubrieknummer, t.Rubrieknummer, y.Rubrieknummer, z.Rubrieknummer";
        $data = $dbh->query($sql);
        $result = $data->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    static function getRubrieken()
    {
        global $dbh;
        $data = $dbh->prepare('SELECT Rubrieknaam, Rubrieknummer FROM Rubriek');
        $data->execute();
        $result = $data->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    static function getCategoryUsage($category)
    {
        global $dbh;
        $data = $dbh->prepare("SELECT COUNT(*) FROM VoorwerpInRubriek WHERE RubriekOpLaagsteNiveau = :category");
        $data->execute([":category"=>$category]);
        $result = $data->fetch(PDO::FETCH_COLUMN);
        return $result;
    }

    static function getUnusedCategoryNumber()
    {
        // source https://www.eidias.com/blog/2012/1/16/finding-gaps-in-a-sequence-of-identifier-values-of
        global $dbh;
        $data = $dbh->prepare("SELECT TOP 1 RN from
            (SELECT Rubrieknummer, row_number() over (order by Rubrieknummer) as RN 
            from Rubriek) as T WHERE Rubrieknummer > RN 
            SELECT * FROM Rubriek ORDER BY Rubrieknummer");
        $data->execute();
        $result = $data->fetch(PDO::FETCH_COLUMN);
        return $result;
    }

    static function changeCategoryName($categoryID, $newName)
    {
        global $dbh;
        $data = $dbh->prepare("UPDATE Rubriek SET Rubrieknaam = :updated WHERE Rubrieknummer = :category");
        $data->execute([":updated" => $newName, ":category" => $categoryID]);
    }

    static function deleteCategory($category)
    {
        global $dbh;
        $data = $dbh->prepare('DELETE FROM Rubriek WHERE Rubrieknummer = :category');
        $data->execute([":category" => $category]);
    }

    static function addCategory($category, $parent)
    {
        global $dbh;
        $data = $dbh->prepare("INSERT INTO Rubriek (Rubrieknummer, Rubrieknaam, Rubriek) VALUES(:available, :name, :parent)");
        $data->execute([":name" => $category, ":parent" => $parent, ":available"=>self::getUnusedCategoryNumber()]);
    }

    static function insertIntoRubriek($itemId, $rubriekNummer)
    {
        global $dbh;
        $data = $dbh->prepare('INSERT INTO VoorwerpInRubriek (Voorwerp,RubriekOpLaagsteNiveau) VALUES(:Voorwerp,:RubriekOpLaagsteNiveau)');
        return $data->execute([":Voorwerp" => $itemId, ":RubriekOpLaagsteNiveau" => $rubriekNummer]);
    }
}