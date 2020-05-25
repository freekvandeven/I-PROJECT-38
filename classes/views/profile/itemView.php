<?php
    $items = Items::getSellerItems($_SESSION['name']);
    $displayedItems = array("Titel", "Startprijs", "Betalingswijze", "Betalingsinstructie", "Plaatsnaam", "Land", "Looptijd");
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
                            <tr class="table-green">
                                <td>Veiling is afgelopen en er is WEL een bieder.</td>
                            </tr>
                            <tr class="table-red">
                                <td>Veiling is afgelopen en er is GEEN bieder.</td>
                            </tr>
                            <tr class="table-orange">
                                <td>Veiling is bezig, maar er is nog geen bieder.</td>
                            </tr>
                            <tr class="table-blue">
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
                        <th>Veilingnr.</th>
                        <th>Hoogste bieder</th>
                        <?php foreach($displayedItems as $key){
                            echo "<th>$key</th>";
                        } ?>
                        <th>Veiling gesloten</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($items as $item):
                    if($item['VeilingGesloten'] == 1){
                        if(isset($item['Koper'])) {
                            $label = "table-green";
                        } else {
                            $label = "table-red";
                        }
                    } else {
                        if(isset($item['Koper'])) {
                            $label = "table-blue";
                        } else{
                            $label = "table-orange";
                        }
                    }
                    ?>
                    <tr class="<?=$label?>">
                        <td><a href="item.php?id=<?=$item['Voorwerpnummer']?>">Veiling <?=$item["Voorwerpnummer"]?></a></td>
                        <td>
                            <?php if(isset($item['Koper'])) { ?>
                            <a href="profile.php?id=<?=$item['Koper']?>"><?=$item['Koper']?></a> <?php }
                            else { ?>
                            Er heeft nog niemand geboden :(
                            <?php } ?>
                        </td>
                        <?php foreach($displayedItems as $itemName):
                            if(isset($itemName)) {
                                echo '<td>'.$item[$itemName].'</td>';
                            } else {
                                echo '<td>-</td>';
                            }
                            endforeach; ?>
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