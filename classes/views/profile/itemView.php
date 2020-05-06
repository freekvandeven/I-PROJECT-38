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
                        <th>Link</th>
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

        <div class="row">
            <div class="legenda col-xl-3 offset-xl-9 col-lg-5 offset-lg-7 col-md-5 offset-md-7 col-sm-12 col-12 ">
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
                                <td>Veiling is afgelopen.</td>
                            </tr>

                            <tr class="table-danger">
                                <td>Veiling is nog niet afgelopen.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="form-group text-center col-lg-12">
                <p class="gaTerugKnop" style="margin-bottom: 60px;"><a href="profile.php">Ga terug</a></p>
            </div>

        </div>
    </div>
</main>