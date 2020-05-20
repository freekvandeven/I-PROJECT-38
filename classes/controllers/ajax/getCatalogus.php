<?php
$items = selectFromCatalog(evalSelectPOST());

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
