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
                $order[':order'] = "looptijdbegintijdstip DESC";
                break;
            case "Old":
                $order[':order'] = "looptijdbegintijdstip ASC";
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
$items = selectFromCatalog($select);

generateCatalog($items);
?>
<script type="text/javascript">
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
