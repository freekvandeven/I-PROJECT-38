<main>
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