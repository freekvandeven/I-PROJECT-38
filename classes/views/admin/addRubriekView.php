<?php
$result = generateCategoryArray();
$filtered = $result[0];
$mapping = $result[1];

function getRubriek()
{
    if (isset($_GET['subsubsubRubriek'])) return array($_GET['subsubsubRubriek'], 'subsubsubrubriek');
    if (isset($_GET['subsubRubriek'])) return array($_GET['subsubRubriek'], 'subsubrubriek');
    if (isset($_GET['subRubriek'])) return array($_GET['subRubriek'], 'subrubriek');
    if (isset($_GET['mainRubriek'])) return array($_GET['mainRubriek'], 'hoofdrubriek');
    return null;
}

?>

<main class="adminPaginaSub rubriekenBoomPagina">
    <div class="jumbotron">
        <h2 class="display-5">Welkom op de rubriekenpagina</h2>
        <p>Op deze pagina kunt u rubrieken toevoegen.</p>
    </div>

    <div class="container">
        <?php
        $selected = getRubriek();
        if (is_null($selected)):
            ?>
            <h2 class="text-center">Selecteer een rubriek</h2>
            <form method="post" action="" class="bewerkMenu">
                <input type="hidden" name="token" value="<?= $token ?>">
                <input type="hidden" name="category" value="addRubriek">
                <input type="hidden" name="rubriek" value="-1">
                <div class="row">
                    <input type="text" name="rubriekNieuw" value="" placeholder="Hoofdrubriek" class="col-sm-2 col-3">
                    <button type="submit" name="action" value="add">Voeg een hoofdrubriek toe</button>
                </div>
            </form>
        <?php else: ?>
            <h2 class="text-center">Pas de geselecteerde rubriek aan</h2>
            <p class="amount"><?= $mapping[$selected[0]] ?>: <?=Category::getCategoryUsage($selected[0])?> veilingen</p>
            <form method="post" action="" class="bewerkMenu">
                <input type="hidden" name="token" value="<?= $token ?>">
                <input type="hidden" name="category" value="addRubriek">
                <input type="hidden" name="rubriek" value="<?= $selected[0] ?>">
                <div class="row">
                    <input type="text" name="rubriekNaam" value="<?= $mapping[$selected[0]] ?>" class="col-sm-2 col-3">
                    <button type="submit" name="action" value="change">Verander de naam</button>
                </div>
                <?php if ($selected[1] != 'subsubsubrubriek'): ?>
                    <div class="row">
                        <input type="text" name="rubriekNieuw" value="" class="col-sm-2 col-3">
                        <button type="submit" name="action" value="add">Voeg een rubriek toe</button>
                    </div>
                <?php endif; ?>
                <div class="row">
                    <button type="submit" name="action" value="delete" class="deleteButton">Verwijder Rubriek</button>
                </div>
            </form>
        <?php endif; ?>

        <div class="row">
            <div class="col">
                <ul class="categorieenLijst <?php if(!isset($_GET['mainRubriek'])) echo 'col-lg-3 col-8';?>">
                    <form method="get" action="">
                        <input type="hidden" name="category" value="addRubriek">
                        <li class="titel">Categorieën</li>
                        <?php
                        foreach ($filtered as $key => $value) {
                            echo "<li><button type='submit' name='mainRubriek' value='$key'>$mapping[$key]</button></li>";
                        } ?>
                    </form>
                </ul>
            </div>
            <?php if (isset($_GET['mainRubriek'])): ?>
                <div class='col'>
                    <ul class="categorieenLijst">
                        <form method="get" action="" class="">
                            <input type="hidden" name="category" value="addRubriek">
                            <input type='hidden' name='mainRubriek' value='<?= $_GET['mainRubriek'] ?>'>
                            <li class="titel"><?=$mapping[$_GET['mainRubriek']]?></li>
                            <?php
                            if (!empty(array_key_first($filtered[$_GET['mainRubriek']]))) {
                                foreach ($filtered[$_GET['mainRubriek']] as $key => $value) {
                                    echo "<li><button type='submit' name='subRubriek' value='$key'>$mapping[$key]</button></li>";
                                }
                            } ?>
                        </form>
                    </ul>
                </div>
                <?php if (isset($_GET['subRubriek'])): ?>
                    <div class='col'>
                        <ul class="categorieenLijst">
                            <form method="get" action="">
                                <input type='hidden' name="category" value="addRubriek">
                                <input type='hidden' name='mainRubriek' value='<?= $_GET['mainRubriek'] ?>'>
                                <input type='hidden' name='subRubriek' value='<?= $_GET['subRubriek'] ?>'>
                                <li class="titel"><?=$mapping[$_GET['subRubriek']]?></li>
                                <?php
                                if (!empty(array_key_first($filtered[$_GET['mainRubriek']][$_GET['subRubriek']]))) { // improve this check
                                    foreach ($filtered[$_GET['mainRubriek']][$_GET['subRubriek']] as $key => $value) {
                                        echo "<li><button type='submit' name='subsubRubriek' value='$key'>$mapping[$key]</button>";
                                    }
                                } ?>
                            </form>
                        </ul>
                    </div>
                    <?php if (isset($_GET['subsubRubriek'])): ?>
                        <div class='col'>
                            <ul class="categorieenLijst">
                                <form method="get" action="">
                                    <input type='hidden' name='category' value='addRubriek'>
                                    <input type='hidden' name='mainRubriek' value='<?= $_GET['mainRubriek'] ?>'>
                                    <input type='hidden' name='subRubriek' value='<?= $_GET['subRubriek'] ?>'>
                                    <input type='hidden' name='subsubRubriek' value='<?= $_GET['subsubRubriek'] ?>'>
                                    <li class="titel"><?=$mapping[$_GET['subsubRubriek']]?></li>
                                    <?php
                                    if (!empty(array_key_first($filtered[$_GET['mainRubriek']][$_GET['subRubriek']][$_GET['subsubRubriek']]))) { //improve this check
                                        foreach ($filtered[$_GET['mainRubriek']][$_GET['subRubriek']][$_GET['subsubRubriek']] as $subsubsubrubriek) {
                                            echo "<li><button type='submit' name='subsubsubRubriek' value='$subsubsubrubriek'>$mapping[$subsubsubrubriek]</button>";
                                        }
                                    } ?>
                                </form>
                            </ul>
                        </div>
                    <?php
                    endif;
                endif;
            endif;
            ?>
        </div>
    </div>
    <div class="gaTerugKnopBox text-center">
        <a class="gaTerugKnop" href="admin.php">Ga terug</a>
    </div>
</main>