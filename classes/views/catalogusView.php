<main class="catalogusPagina">
    <div class="container">
        <h3 class="text-center">Aangeboden veilingen</h3>
        <?php
        if (isset($_SESSION['loggedin'])) {
            ?>
            <a href="addProduct.php" class="btn btn-primary offset-xl-6 offset-md-0">Product aanbieden</a>
            <?php
        }
        ?>
        <div class="filtermenu">
            <form class="catalogusForm" action="catalogus.php" method="post">
                <input type="hidden" name="token" value="<?= $token ?>">
                <div class="row">
                    <div class="form-group col-xl-12 text-center">
                        <label for="zoekbalk">Zoeken</label>
                    </div>

                    <div class="form-group col-xl-10 col-lg-10 col-md-10 col-sm-10 col-10 text-center">
                        <input class="form-control" id="zoekbalk" type="text" placeholder="Zoek op keywords" name="search">
                    </div>

                    <div class="form-group col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2">
                        <button id="zoekButton" class="zoekButton" type="submit">Zoeken</button>
                    </div>
                </div> <!-- einde row -->

                <div class="row">
                    <div class="form-group col-xl-2 col-lg-2 col-md-3 col-sm-4 col-4">
                        <label for="Rubriek">Rubriek</label>
                        <select class="custom-select" id="Rubriek" name="rubriek" onchange="this.form.submit()">
                            <option value="">Kies Rubriek</option>
                            <?php
                            foreach (Items::getRubrieken() as $rubriek) {
                                echo "<option ";
                                if ($rubriek['Rubrieknummer'] == $_POST['rubriek']) echo "selected";
                                echo " value='" . $rubriek['Rubrieknummer'] . "'>" . $rubriek['Rubrieknaam'] . "</option>";
                            } ?>
                        </select>
                    </div>

                    <div class="form-group col-xl-2 col-lg-2 col-md-3 col-sm-4 col-4">
                        <label for="price">Volgorde</label>
                        <select class="custom-select" id="price" name="order" onchange="this.form.submit()">
                            <option value="">Kies Volgorde</option>
                            <option <?php if ($_POST['order'] == "High") echo "selected " ?>value="High">Duurste Eerst
                            </option>
                            <option <?php if ($_POST['order'] == "Low") echo "selected " ?>value="Low">Goedkoopste Eerst
                            </option>
                            <option <?php if ($_POST['order'] == "New") echo "selected " ?>value="New">Nieuwste Eerst
                            </option>
                            <option <?php if ($_POST['order'] == "Old") echo "selected " ?>value="Old">Oudste Eerst
                            </option>
                        </select>
                    </div>

                    <div class="form-group col-xl-2 col-lg-2 col-md-3 col-sm-4 col-4">
                        <label for="numberOfItems">Aantal</label>
                        <select class="custom-select" id="numberOfItems" name="numberOfItems"
                                onchange="this.form.submit()">
                            <option <?php if ($_POST['numberOfItems'] == 25) echo "selected " ?>value=25>25</option>
                            <option <?php if ($_POST['numberOfItems'] == 50) echo "selected " ?>value=50>50</option>
                            <option <?php if ($_POST['numberOfItems'] == 100) echo "selected " ?>value=100>100</option>
                            <option <?php if ($_POST['numberOfItems'] == 100) echo "selected " ?>value=10000>TEST
                            </option>
                        </select>
                    </div>
                </div> <!-- einde row -->
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
                $select[':where'] = "%" . $_POST['search'] . "%";
            }
            if (isset($_POST['rubriek'])) {
                $select[":rubriek"] = $_POST['rubriek'];
            }
            $select = array_merge($select, $order);
            if (isset($_POST['numberOfItems']))
                $select[':limit'] = $_POST['numberOfItems'];
            else {
                $select[':limit'] = '25';
            }
        }
        $items = selectFromCatalog($select); ?>
        <div class="productsList">
            <?php generateCatalog($items);
            ?>
            <script>
                var my_date;
                <?php
                $i = 0;
                foreach($items as $item){
                $datum = $item['LooptijdEindeDag'];
                $tijdstip = $item['LooptijdEindeTijdstip'];
                $time = explode(" ", $datum)[0] . " " . explode(" ", $tijdstip)[1];
                echo "my_date = '" . explode(".", $time)[0] . "';\n";
                ?>
                my_date = my_date.replace(/-/g, "/");
                setupCountDown('timer-<?=$i?>', new Date(my_date));
                <?php
                $i++;
                }
                ?>
            </script>
        </div>
    </div>
</main>
