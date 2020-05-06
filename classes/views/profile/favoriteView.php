<?php
    $items = Items::getBuyerItems($_SESSION['name']);
    $displayedItems = array("Titel", "Startprijs", "Betalingswijze", "Betalingsinstructie", "Plaatsnaam", "Land", "Looptijd", "VeilingGesloten");
?>

<main>
    <div class="favorietenBox">
        <h2 class="text-center">Mijn favoriete veilingen</h2>
        <h5 class="text-center">Als u op een veiling biedt, kunt u die hieronder zien.</h5>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">Link</th>
                    <th>Verkoper</th>
                    <?php foreach($displayedItems as $key){
                        echo "<th>$key</th>";
                    } ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach($items as $item):
                    if($item['VeilingGesloten'] == "Wel "){
                        if($item['Koper'] == $_SESSION['name']){
                            $label = "table-success";
                        } else {
                            $label = "table-danger";
                        }
                    } else {
                        if(Items::getHighestBid($item['Voorwerpnummer'])['Gebruiker'] == $_SESSION['name']){
                            $label = "table-info";
                        } else {
                            $label = "table-warning";
                        }
                    }

                ?>
                    <tr class="<?=$label?>">
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
        <div class="row">
            <div class="legenda col-xl-4 offset-xl-8 col-lg-5 offset-lg-7 col-md-6 offset-md-6 col-sm-12 col-12 ">
                <h5 class="text-center">Legenda</h5>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Kleur en betekenis</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr class="table-success">
                                <td>Veiling is afgelopen en je hebt gewonnen.</td>
                            </tr>

                            <tr class="table-danger">
                                <td>Veiling is afgelopen en je hebt verloren.</td>
                            </tr>

                            <tr class="table-warning">
                                <td>Veiling is nog niet afgelopen maar je bent wel overgeboden.</td>
                            </tr>

                            <tr class="table-info">
                                <td>Veiling is nog niet afgelopen maar je bent wel de hoogste bieder.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="form-group text-center col-lg-12">
                <p class="gaTerugKnop" style="margin-bottom: 60px;"><a href="profile.php">Ga terug</a></p>
            </div>
    </div>
</main>