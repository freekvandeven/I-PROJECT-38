<?php
    $items = Items::getBuyerItems($_SESSION['name']);
    $displayedItems = array("Titel", "Startprijs", "Betalingswijze", "Betalingsinstructie", "Plaatsnaam", "Land", "Looptijd", "VeilingGesloten");
?>

<main>
    <div class="favoritesBox">
        <h2 class="text-center">Mijn favoriete veilingen</h2>
        <h5 class="text-center">Als u op een veiling biedt, kunt u die hieronder zien.</h5>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">Link</th>
                    <?php foreach($displayedItems as $key){
                        echo "<th>$key</th>";
                    } ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach($items as $item): ?>
                    <tr>
                        <td><a href="item.php?id=<?=$item['Voorwerpnummer']?>">Voorwerp <?=$item["Voorwerpnummer"]?></a></td>
                        <td><a href="profile.php?id=<?=$item['Verkoper']?>"><?=$item['Verkoper']?></a></td>
                        <?php foreach($displayedItems as $itemName): ?>
                            <td><?=$item[$itemName]?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
        <div class="form-group text-center">
            <p class="gaTerugKnop"><a href="profile.php">Ga terug</a></p>
        </div>
    </div>
</main>