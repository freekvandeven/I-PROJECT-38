<?php
# step 0 setup procedures


$getKeyWordId = $dbh->prepare("exec getKeyWordId ?");
$getKeyWordId->bindParam(1, $keyword);

$keywordLinkInsert = $dbh->prepare("exec KeyWordLinkInsert ?, ?");
$keywordLinkInsert->bindParam(1, $keywordId);
$keywordLinkInsert->bindParam(2, $itemId);

$keywordInsert = $dbh->prepare("exec KeyWordInsert ?");
$keywordInsert->bindParam(1, $keyword);
# step 1 get highest itemId from KeyWordsLink
$return = $dbh->query("SELECT max(VoorwerpNummer) as hoogsteNummer FROM KeyWordsLink");
$itemId = $return->fetch(PDO::FETCH_COLUMN);
if (!$itemId) {
    $return = $dbh->query("SELECT min(VoorwerpNummer) as hoogsteNummer FROM Voorwerp");
    $itemId = $return->fetch(PDO::FETCH_COLUMN);
}
# step 2 get title from itemId
$data = $dbh->query("SELECT Titel FROM Voorwerp WHERE VoorwerpNummer > $itemId");
$titles = $data->fetchAll(PDO::FETCH_COLUMN);
# step 3 loop the next items
foreach ($titles as $title) {
    $itemId++;
    # step 4 parse title to keywords
    $keywords = explode(" ", $title);
    foreach ($keywords as $keyword) {
        $keyword = strtolower(preg_replace('/\PL/u', '', $keyword));
        $keyword = trim($keyword);
        if (strlen($keyword) > 2) {
            # step 5 execute
            $keywordInsert->execute();
            $getKeyWordId->execute();
            $keywordId = $getKeyWordId->fetch(PDO::FETCH_COLUMN);
            if($keywordId!=0) {
                $keywordLinkInsert->execute();
            }
        }
    }
}
echo "finished";
?>