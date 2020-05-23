<main class="catalogusPagina">

    <div class="linkerkant">
        <div class="categorieen">
            <h4 class="font-weight-normal text-center">Categorieën</h4>
            <ul class="list-unstyled">
                <li>categorie 1
                    <ul>
                        <li>subcategorie 1</li>
                        <li>subcategorie 2</li>
                    </ul>
                </li>

                <li>Geselecteerde Categories
                    <ul id="selectedCategories">

                    </ul>
                </li>

                <li> Zoek op categorieen

                    <form class="categorySearchForm" action="" method="post">
                        <input type="hidden" name="token" value="<?= $token ?>">
                        <input class="form-control" id="zoekcategory" type="text" placeholder="Zoek op categorieën"
                               name="search" autocomplete="off" onkeyup="showCategory(this.value)">
                    </form>
                </li>
                <li>
                    <ul id="searchResult">
                    </ul>
                </li>

                <script type="text/javascript">
                    $("#searchResult").bind("click", function (e) {
                        $(e.target).closest("li").toggleClass("highlight");
                        $("#selectedCategories").append("<li>" + $(event.target).text() + "<li/>");
                        showCategory($("#zoekcategory").val());
                    })
                </script>


            </ul>
        </div>
    </div>


    <div class="container">
        <h3 class="text-center col-xl-12 col-md-12 col-12">Aangeboden veilingen</h3>
        <div class="filtermenu">
            <form class="catalogusForm" action="catalogus.php" method="post" onkeyup="regenerateCatalog()"
                  onchange="regenerateCatalog()">
                <input type="hidden" name="token" value="<?= $token ?>">
                <div class="row">
                    <div class="form-group col-xl-12 text-center">
                        <label for="zoekbalk">Zoeken</label>
                    </div>
                </div>

                <div class="row">
                    <?php
                    if (isset($_SESSION['loggedin'])) {
                        ?>
                        <div class="productAanbiedenDiv offset-lg-9 offset-md-0">
                            <a href="addProduct.php" class="productAanbiedenButton col-lg-12 col-sm-12 col-12">Product
                                aanbieden</a>
                        </div>
                        <?php
                    }
                    ?>
                </div>

                <div class="row">
                    <div class="form-group col-xl-10 col-lg-10 col-md-10 col-sm-10 col-10">
                        <input class="form-control" id="zoekbalk" type="text" placeholder="Zoek op keywords"
                               name="search">
                    </div>

                    <div class="form-group col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2">
                        <button id="zoekButton" class="zoekButton" type="submit">Zoeken</button>
                    </div>
                </div> <!-- einde row -->

                <div class="row">
                    <div class="form-group col-xl-2 col-lg-2 col-md-3 col-sm-4 col-4">
                        <label for="Rubriek">Rubriek</label>
                        <select class="custom-select" id="Rubriek" name="rubriek">
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
                        <select class="custom-select" id="price" name="order">
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
                        <select class="custom-select" id="numberOfItems" name="numberOfItems">
                            <option <?php if ($_POST['numberOfItems'] == 25) echo "selected " ?>value=25>25</option>
                            <option <?php if ($_POST['numberOfItems'] == 50) echo "selected " ?>value=50>50</option>
                            <option <?php if ($_POST['numberOfItems'] == 100) echo "selected " ?>value=100>100</option>
                            <option <?php if ($_POST['numberOfItems'] == 100) echo "selected " ?>value=10000>TEST
                            </option>
                        </select>
                    </div>

                    <div class="price-slider"><span>from
                        &euro;<input type="number" value="1" min="1" max="1000000" name="minimum"/> to
                        &euro;<input type="number" value="1000000" min="1" max="1000000" name="maximum"/>
                        </span>
                        <input value="1" min="1" max="1000000" step="10" type="range"/>
                        <input value="1000000" min="1" max="1000000" step="10" type="range"/>
                        <svg width="100%" height="24">
                            <line x1="4" y1="0" x2="300" y2="0" stroke="#212121" stroke-width="12"
                                  stroke-dasharray="1 28"></line>
                        </svg>
                    </div>
                    <script>testJava(".price-slider")</script>
                    <div class="distance-slider"><span>Van
                        <input type="number" value="10" min="0" max="355" name="minimumDistance"/>km tot
                        <input type="number" value="100" min="0" max="355" name="maximumDistance"/>km
                        </span>
                        <input value="10" min="0" max="355" step="1" type="range"/>
                        <input value="80" min="0" max="355" step="1" type="range"/>
                        <svg width="100%" height="24">
                            <line x1="4" y1="0" x2="300" y2="0" stroke="#212121" stroke-width="12"
                                  stroke-dasharray="1 28"></line>
                        </svg>
                    </div>
                    <script>testJava(".distance-slider")</script>
                </div> <!-- einde row -->
            </form>
        </div>


        <?php
        $items = selectFromCatalog(evalSelectPOST()); ?>
        <div class="productsList" id="productsList">
            <?php generateCatalog($items);
            $timerDates = array_column($items, 'LooptijdEindeTijdstip');
            for($i=0;$i<count($timerDates);$i++){
                $timerDates[$i] = explode(".", $timerDates[$i])[0];
            }
            ?>

            <script type="text/javascript">
                var timerDates = <?php echo json_encode($timerDates); ?>;
                initializeCountdownDates(timerDates);
                if(!countdown) { // if countdown hasn't been started
                    setupCountdownTimers();
                }
            </script>
        </div>
    </div>
</main>

<script type="text/javascript">
    function regenerateCatalog() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("productsList").innerHTML = this.responseText;

                // evaluate the javascript returned inside the ajax response
                $("#productsList").find("script").each(function(){
                    eval($(this).text());
                });
            }
        };
        xmlhttp.open("POST", "ajax.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = $('.catalogusForm').serialize();
        xmlhttp.send(data.concat('&request=getCatalogus'));
    }
</script>
