<?php
$items = selectFromCatalog(evalSelectPOST());

generateCatalog($items);
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
