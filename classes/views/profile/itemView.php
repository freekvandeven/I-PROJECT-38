<?php
    $items = Items::getSellerItems($_SESSION['name']);
    $displayedItems = array("Titel", "Startprijs", "Betalingswijze", "Betalingsinstructie", "Plaatsnaam", "Land", "Looptijd", "VeilingGesloten");
?>

<main>
    <div class="mijnVeilingenBox">
        <h2 class="text-center">Mijn veilingen</h2>
        <h5 class="text-center">Al uw veilingen kunt u hieronder zien.</h5>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">Link</th>
                    <th>Koper</th>
                    <?php foreach($displayedItems as $key){
                        echo "<th>$key</th>";
                    } ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach($items as $item):
                    if($item['VeilingGesloten'] == "Wel "){
                        $label = "table-success";
                    } else {
                        $label = "table-danger";
                    }
                    ?>
                    <tr class="<?=$label?>">
                        <td><a href="item.php?id=<?=$item['Voorwerpnummer']?>">Voorwerp <?=$item["Voorwerpnummer"]?></a></td>
                        <td><a href="profile.php?id=<?=$item['Koper']?>"><?=$item['Koper']?></a></td>
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
