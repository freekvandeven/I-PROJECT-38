<?php
    $items = Items::getSellerItems($_SESSION['name']);
    $displayedItems = array("Titel", "Startprijs", "Betalingswijze", "Betalingsinstructie", "Plaatsnaam", "Land", "Looptijd", "VeilingGesloten");
?>

<main class="mijnVeilingenPagina">
    <h2 class="text-center">Mijn veilingen</h2>
    <h5 class="text-center">Als u een veiling aanbiedt, kunt u die hieronder volgen.</h5>

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
                        <tr class="table-success">
                            <td>Veiling is afgelopen en er is WEL een bieder.</td>
                        </tr>

                        <tr class="table-danger">
                            <td>Veiling is afgelopen en er is GEEN bieder.</td>
                        </tr>

                        <tr class="table-warning">
                            <td>Veiling is bezig, maar er is nog geen bieder.</td>
                        </tr>

                        <tr class="table-info">
                            <td>Veiling is bezig en er is al een bieder.</td>
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
                    <th>Koper</th>
                    <?php foreach($displayedItems as $key){
                        echo "<th>$key</th>";
                    } ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach($items as $item):
                    if($item['VeilingGesloten'] == "Wel "){
                        if(isset($item['Koper'])) {
                            $label = "table-success";
                        } else {
                            $label = "table-danger";
                        }
                    } else {
                        if(isset($item['Koper'])) {
                            $label = "table-info";
                        } else{
                            $label = "table-warning";
                        }
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
    </div>

    <div class="form-group text-center">
        <p class="gaTerugKnop"><a href="profile.php">Ga terug</a></p>
    </div>
</main>