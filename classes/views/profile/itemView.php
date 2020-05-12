<?php
    $items = Items::getSellerItems($_SESSION['name']);
    $displayedItems = array("Titel", "Startprijs", "Betalingswijze", "Betalingsinstructie", "Plaatsnaam", "Land", "Looptijd", "VeilingGesloten");
?>

<main class="mijnVeilingenPagina">

    <h2 class="text-center">Mijn veilingen</h2>
    <h5 class="text-center">Alle veilingen die je ooit hebt aangeboden zijn hieronder te zien.</h5>

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
                                <td>Veiling is afgelopen.</td>
                            </tr>
                            <tr class="table-danger">
                                <td>Veiling is nog niet afgelopen.</td>
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
    </div>


    <div class="form-group text-center">
        <p class="gaTerugKnop"><a href="profile.php">Ga terug</a></p>
    </div>

</main>