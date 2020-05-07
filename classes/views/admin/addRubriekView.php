<main class="adminPagina">
    <div class="jumbotron">
        <h2 class="display-5">Welkom master op de Adminpagina</h2>
        <p>Op deze pagina heeft u een aantal opties waar alleen u toegang tot heeft.</p>
    </div>
    <h2>Voeg nieuwe Rubrieken toe</h2>
    <form method="post" action="">
            <input type="hidden" name="token" value="<?= $token ?>">
            <input type="hidden" name="category" value="addRubriek">
            <label for="addRubriekField">Nieuwe Rubriek:</label>
            <input type="text" name="newRubriek" id="addRubriekField" value="">
            <input type="submit" value="Voeg toe">
    </form>
    <a href="admin.php">Go back</a><br>
</main>