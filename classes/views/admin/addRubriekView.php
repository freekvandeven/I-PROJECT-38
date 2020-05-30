<?php
$sql = "SELECT r.Rubrieknummer as hoofdnummer, r.Rubrieknaam as hoofdnaam, t.Rubrieknummer as subnummer, t.Rubrieknaam as subnaam, y.Rubrieknummer as subsubnummer, y.Rubrieknaam as subsubnaam, z.Rubrieknummer as subsubsubnummer, z.Rubrieknaam as subsubsubnaam 
FROM Rubriek r left join Rubriek t on t.Rubriek = r.Rubrieknummer left join Rubriek y on y.Rubriek = t.Rubrieknummer left join Rubriek z on z.Rubriek = y.Rubrieknummer WHERE r.Rubriek = -1 
ORDER BY r.Rubrieknummer, t.Rubrieknummer, y.Rubrieknummer, z.Rubrieknummer";
$data = $dbh->query($sql);
$result = $data->fetchAll(PDO::FETCH_ASSOC);
$filtered = [];
$mapping = [];
foreach ($result as $row) {
    $filtered[$row['hoofdnummer']][$row['subnummer']][$row['subsubnummer']][] = $row['subsubsubnummer'];
    $mapping[$row['hoofdnummer']] = $row['hoofdnaam'];
    $mapping[$row['subnummer']] = $row['subnaam'];
    $mapping[$row['subsubnummer']] = $row['subsubnaam'];
    $mapping[$row['subsubsubnummer']] = $row['subsubsubnaam'];
}
//echo '<pre>' , var_dump($filtered) , '</pre>';
//Debug::dump($filtered);
//Debug::dump($mapping);
function getRubriek()
{
    if (isset($_GET['subsubsubRubriek'])) return array($_GET['subsubsubRubriek'], 'subsubsubrubriek');
    if (isset($_GET['subsubRubriek'])) return array($_GET['subsubRubriek'], 'subsubrubriek');
    if (isset($_GET['subRubriek'])) return array($_GET['subRubriek'], 'subrubriek');
    if (isset($_GET['mainRubriek'])) return array($_GET['mainRubriek'], 'hoofdrubriek');
    return null;
}

?>


<main class="adminPaginaSub">
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
        <?php else: ?>
            <h2 class="text-center">Pas de geselecteerde rubriek aan</h2>
            <form method="post" action="">
                <input type="hidden" name="token" value="<?= $token ?>">
                <input type="hidden" name="category" value="addRubriek">
                <input type="hidden" name="rubriek" value="<?=$selected[0]?>">
                <button type="submit" name="action" value="delete">
                    Verwijder Rubriek
                </button>
                <input type="text" name="rubriekNaam" value="<?=$mapping[$selected[0]]?>">
                <button type="submit" name="action" value="change">
                    Verander de naam
                </button>
                <?php if($selected[1] != 'subsubsubrubriek'): ?>
                <input type="text" name="rubriekNieuw" value="">
                <button type="submit" name="action" value="add">
                    Voeg een rubriek toe
                </button>
                <?php endif; ?>
            </form>
        <?php endif; ?>

        <div class="row">
            <div class="col">
                <ul>
                    <form method="get" action="">
                        <input type="hidden" name="category" value="addRubriek">
                        <?php
                        foreach ($filtered as $key => $value) {
                            echo "<li><button type='submit' name='mainRubriek' value='$key'>$mapping[$key]</button></li>";
                        } ?>
                    </form>
                </ul>
            </div>
            <?php if (isset($_GET['mainRubriek'])): ?>
                <div class='col'>
                    <ul>
                        <form method="get" action="">
                            <input type="hidden" name="category" value="addRubriek">
                            <input type='hidden' name='mainRubriek' value='<?= $_GET['mainRubriek'] ?>'>
                            <?php
                            foreach ($filtered[$_GET['mainRubriek']] as $key => $value) {
                                echo "<li><button type='submit' name='subRubriek' value='$key'>$mapping[$key]</button></li>";
                            } ?>
                        </form>
                    </ul>
                </div>
                <?php if (isset($_GET['subRubriek'])): ?>
                    <div class='col'>
                        <ul>
                            <form method="get" action="">
                                <input type='hidden' name="category" value="addRubriek">
                                <input type='hidden' name='mainRubriek' value='<?= $_GET['mainRubriek'] ?>'>
                                <input type='hidden' name='subRubriek' value='<?= $_GET['subRubriek'] ?>'>
                                <?php
                                if($filtered[$_GET['mainRubriek']][$_GET['subRubriek']] != null) { // improve this check
                                    foreach ($filtered[$_GET['mainRubriek']][$_GET['subRubriek']] as $key => $value) {
                                        echo "<li><button type='submit' name='subsubRubriek' value='$key'>$mapping[$key]</button>";
                                    }
                                }?>
                            </form>
                        </ul>
                    </div>
                <?php if (isset($_GET['subsubRubriek'])): ?>
                    <div class='col'>
                        <ul>
                            <form method="get" action="">
                                <input type='hidden' name='category' value='addRubriek'>
                                <input type='hidden' name='mainRubriek' value='<?= $_GET['mainRubriek'] ?>'>
                                <input type='hidden' name='subRubriek' value='<?= $_GET['subRubriek'] ?>'>
                                <input type='hidden' name='subsubRubriek' value='<?= $_GET['subsubRubriek'] ?>'>
                                <?php
                                if($filtered[$_GET['mainRubriek']][$_GET['subRubriek']][$_GET['subsubRubriek']] != null) { //improve this check
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
    <h2 class="text-center">Voeg een nieuwe Rubriek toe</h2>
    <form method="post" action="">
        <input type="hidden" name="token" value="<?= $token ?>">
        <input type="hidden" name="category" value="addRubriek">

        <label class="offset-xl-3" for="addRubriekField">Nieuwe Rubriek:</label>
        <input class="form-control col-xl-6 offset-xl-3" type="text" name="newRubriek" id="addRubriekField"
               value="" placeholder="Nieuwe rubriek">
        <div class="text-center">
            <input class="voegRubriekToeButton form-control col-xl-2 offset-xl-5" type="submit"
                   value="Voeg toe">
        </div>
    </form>
    <div class="gaTerugKnopBox text-center">
        <a class="gaTerugKnop" href="admin.php">Ga terug</a>
    </div>
</main>