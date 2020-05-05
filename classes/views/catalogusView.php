<main>
    <div class="productsList">
        <h3>Bekijk hier alle producten</h3>
        <div class="filtermenu">
            <form class="" action="catalogus.php" method="post">
                <select id="Rubriek" name="Rubriek">
                    <option value="rubriek">Kies Rubriek</option>
                    <?php for ($i = 0; $i < 10; $i++) :
                        ?>
                        <option value="rubriek<?= $i ?>">rubriek<?= $i ?></option>
                    <?php
                    endfor;
                    ?>
                </select>
                <select id="price" name="order">
                    <option value="">Kies Volgorde</option>
                    <option value="High">Duurste Eerst</option>
                    <option value="Low">Goedkoopste Eerst</option>
                    <option value="New">Nieuwste Eerst</option>
                    <option value="Old">Oudste Eerst</option>
                </select>
                <select id="numberOfItems" name="numberOfItems">
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <input type="text" placeholder="Zoeken" name="search">
                <button type="submit">Zoeken</button>
            </form>
        </div>
        <?php
        $select = array();
        if (isset($_POST)) {
            $order = array();
            if (isset($_POST['order'])) {
                switch ($_POST['order']) {
                    case "Low":
                        $order[':order'] = "prijs ASC";
                        break;
                    case "High":
                        $order[':order'] = "prijs DESC";
                        break;
                    case "New":
                        $order[':order'] = "looptijdbegindag DESC";
                        break;
                    case "Old":
                        $order[':order'] = "looptijdbegindag ASC";
                        break;
                }
            }
            if (isset($_POST['search'])) {
                $select['titel = :where'] = $_POST['search'];
            }
            $select = array_merge($select, $order);
            if (isset($_POST['numberOfItems']))
                $select[':limit'] = $_POST['numberOfItems'];
        } else {
            $select[':limit'] = "25";
        }
        $items = selectFromCatalog($select);
        $counter = 0;
        foreach ($items as $card):
            if ($counter % 4 == 0) {
                echo "<div class='row'>";
            }
            ?>
            <div class='col-lg-3'>
                <div class='card'>
                    <a href='item.php?id=<?= $card['Voorwerpnummer'] ?>'>
                        <img src='upload/items/<?= $card['Voorwerpnummer'] ?>.png' class='card-img-top'
                             alt='Productnaam'>
                    </a>
                    <div class='card-body'>
                        <h5 class='card-title'><?= $card['Titel'] ?></h5>
                        <p class="card-text">	&euro; <?= $card['prijs']?></p>
                        <p class='card-text'><?= $card['Beschrijving'] ?></p>
                        <a href='item.php?id=<?= $card['Voorwerpnummer'] ?>' class='card-link'>Meer informatie</a>
                    </div>
                    <div class='card-footer'>
                        <!-- Display the countdown timer in an element -->
                        <p id="timer-<?=$counter?>"></p>
                    </div>
                </div>
            </div>
            <?php
            $counter++;
            if ($counter % 4 == 0) {
                echo "</div>";
            }
        endforeach;
        ?>
        <script>
                var my_date;
                <?php
                $i = 0;
                foreach($items as $item){
                    $datum = $item['LooptijdEindeDag'];
                    $tijdstip = $item['LooptijdEindeTijdstip'];
                    $time = explode(" ", $datum)[0] . " " . explode(" ", $tijdstip)[1];
                    echo "my_date = '" . explode( ".",$time)[0] . "';\n";
                    ?>
                    my_date = my_date.replace(/-/g, "/");
                    setupCountDown('timer-<?=$i?>', new Date(my_date));
                <?php
                $i++;
                }
                    ?>
        </script>
    </div>
</main>
