<?php
require_once('includes/database.php');

$title = '404';

require_once('includes/header.php');
?>
<main>
        <h1>Oeps! Je pagina konden wij helaas niet vinden!</h1><br>
        <h3>Excuses voor het ongemak!</h3><br><br>
        <p>Niet getreurd, er is nog veel te ontdekken. Ga ervoor!<p><br>
        <p>Klik hieronder om te een bepaald product te zoeken!</p><br>
        <a href="catalogus.php">Zoek producten</a>
</main>

<?php
require_once('includes/footer.php');
?>