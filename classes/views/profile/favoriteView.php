<?php
$items = Items::getBuyerItems($_SESSION['name']);
$followed = Buyer::getFollowedItems($_SESSION['name']);
$displayedItems = array("Titel", "Startprijs", "Betalingswijze", "Betalingsinstructie", "Plaatsnaam", "Land");
?>

<main class="mijnFavorietenPagina">
    <h2 class="text-center">Mijn actieve veilingen</h2>
    <h5 class="text-center">Als u op een veiling biedt of wint, kunt u die hieronder zien.</h5>

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
                    <?php foreach ($displayedItems as $key) {
                        echo "<th>$key</th>";
                    } ?>
                    <th>Eindtijd</th>
                    <th>Veiling gesloten</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($items as $item):
                    if ($item['VeilingGesloten'] == 1) {
                        $label = ($item['Koper'] == $_SESSION['name']) ? "table-green" : "table-red";
                    } else {
                        $label = (Items::getHighestBid($item['Voorwerpnummer'])['Gebruiker'] == $_SESSION['name']) ? "table-blue" : "table-orange";
                    }
                    ?>
                    <tr class="<?= $label ?>">
                        <td>
                            <a href="item.php?id=<?= $item['Voorwerpnummer'] ?>">Voorwerp <?= $item["Voorwerpnummer"] ?></a>
                        </td>
                        <td><a href="profile.php?id=<?= $item['Verkoper'] ?>"><?= $item['Verkoper'] ?></a></td>
                        <?php foreach ($displayedItems as $itemName): ?>
                            <td><?= substr($item[$itemName],0,39) ?></td>
                        <?php endforeach; ?>
                        <td><?= explode(".", $item['LooptijdEindeTijdstip'])[0] ?></td>
                        <td><?php echo ($item['VeilingGesloten']) ? 'Ja' : 'Nee'; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <h2 class="text-center">Mijn favoriete veilingen</h2>
    <h5 class="text-center">Als u op een veiling volgt, kunt u die hieronder zien.</h5>

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
                        <tr class="table-grey">
                            <td>Je volgt deze veiling en hebt nog niet geboden.</td>
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
                    <?php foreach ($displayedItems as $key) {
                        echo "<th>$key</th>";
                    } ?>
                    <th>Eindtijd</th>
                    <th>Veiling gesloten</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($followed as $item):
                    if ($item['VeilingGesloten']) {
                        $label = ($_SESSION['name'] == $item['Koper']) ? "table-green" : "table-red";
                    } else if (empty(Items::userHasBid($item['Voorwerpnummer'], $_SESSION['name']))) {
                        $label = "table-grey";
                    } else{ $label = (Items::getHighestBid($item['Voorwerpnummer'])['Gebruiker'] == $_SESSION['name']) ? "table-blue" : "table-orange";
                    }

                    ?>
                    <tr class="<?= $label ?>">
                        <td>
                            <a href="item.php?id=<?= $item['Voorwerpnummer'] ?>">Voorwerp <?= $item["Voorwerpnummer"] ?></a>
                        </td>
                        <td><a href="profile.php?id=<?= $item['Verkoper'] ?>"><?= $item['Verkoper'] ?></a></td>
                        <?php foreach ($displayedItems as $itemName): ?>
                            <td><?= substr($item[$itemName],0,39) ?></td>
                        <?php endforeach; ?>
                        <td><?= explode(".", $item['LooptijdEindeTijdstip'])[0] ?></td>
                        <td><?php echo ($item['VeilingGesloten']) ? 'Ja' : 'Nee'; ?></td>
                        <form method="post"
                              onsubmit="return confirm('Weet u zeker dat u deze veiling niet meer wilt volgen?');">
                            <input type="hidden" name="token" value="<?= $token ?>">
                            <input type="hidden" name="action" value="favorite">
                            <td class="verwijderButton">
                                <button type="submit" value="<?= $item['Voorwerpnummer'] ?>" name="deleteFollow">
                                    <img src="images/adminimages/delete.png" alt="Delete">
                                </button>
                            </td>
                        </form>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="gaTerugKnopBox text-center">
        <a href="profile.php" class="gaTerugKnop">Ga terug</a>
    </div>
</main>

