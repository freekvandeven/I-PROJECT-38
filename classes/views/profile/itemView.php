<?php
    $items = Items::getSellerItems($_SESSION['name']);
    $displayedItems = array("Titel", "Startprijs", "Betalingswijze", "Betalingsinstructie", "Plaatsnaam", "Land", "Looptijd", "Koper", "VeilingGesloten");
?>

<main>
    <h2>Lijst van items</h2>
    <table>
        <thead>
            <tr>
                <td>Link:</td>
                <?php foreach($displayedItems as $key){
                    echo "<td>$key</td>";
                } ?>
            </tr>
        </thead>
        <tbody>
        <?php foreach($items as $item): ?>
        <tr>
            <td><a href="item.php?code=<?=$item['Voorwerpnummer']?>">Item <?=$item["Voorwerpnummer"]?></a></td>
            <?php foreach($displayedItems as $itemName): ?>
                <td><?=$item[$itemName]?></td>
            <?php endforeach; ?>
        </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</main>