<?php
    $items = Items::getBuyerItems($_SESSION['name']);
    $displayedItems = array("Titel", "Startprijs", "Betalingswijze", "Betalingsinstructie", "Plaatsnaam", "Land", "Looptijd");
?>

<main class="mijnFavorietenPagina">
    <h2 class="text-center">Mijn favoriete veilingen</h2>
    <h5 class="text-center">Als u op een veiling biedt, kunt u die hieronder zien.</h5>

    <div class="tabel col-xl-10 offset-xl-1">
        <div class="legendaButton text-right">
            <button type="button" class="legendaDropdownButton dropdown-toggle" data-toggle="dropdown">Legenda</button>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-item">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Kleur en betekenis</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="table-green">
                                <td>Je hebt de veiling gewonnen.</td>
                            </tr>
                            <tr class="table-red">
                                <td>Je hebt de veiling verloren.</td>
                            </tr>
                            <tr class="table-orange">
                                <td>Je bent overboden op een actieve veiling.</td>
                            </tr>
                            <tr class="table-blue">
                                <td>Je bent de hoogste bieder op een actieve veiling.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Link</th>
                        <th>Verkoper</th>
                        <?php foreach($displayedItems as $key){
                            echo "<th>$key</th>";
                        } ?>
                        <th>Veiling gesloten</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($items as $item):
                    if($item['VeilingGesloten'] == 1){
                        if($item['Koper'] == $_SESSION['name']){
                            $label = "table-green";
                        } else {
                            $label = "table-red";
                        }
                    } else {
                        if(Items::getHighestBid($item['Voorwerpnummer'])['Gebruiker'] == $_SESSION['name']){
                            $label = "table-blue";
                        } else {
                            $label = "table-orange";
                        }
                    }
                    ?>
                    <tr class="<?=$label?>">
                        <td><a href="item.php?id=<?=$item['Voorwerpnummer']?>">Voorwerp <?=$item["Voorwerpnummer"]?></a></td>
                        <td><a href="profile.php?id=<?=$item['Verkoper']?>"><?=$item['Verkoper']?></a></td>
                        <?php foreach($displayedItems as $itemName): ?>
                            <td><?=$item[$itemName]?></td>
                        <?php endforeach; ?>
                        <td>
                            <?php
                            if(isset($item['VeilingGesloten'])) {
                                if($item['VeilingGesloten']) {
                                    echo 'Ja';
                                } else {
                                    echo 'Nee';
                                }
                            }
                            ?>
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="gaTerugKnopBox text-center">
        <a href="profile.php" class="gaTerugKnop">Ga terug</a>
    </div>
</main>

