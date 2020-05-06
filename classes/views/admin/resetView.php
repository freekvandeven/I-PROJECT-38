<main>
    <h2>Welkom master op de Admin pagina</h2>
    <h3>Reset the database:</h3>
    <form method="post" action="">
        <input type="hidden" name="token" value="<?=$token?>">
        <input type="hidden" name="category" value="reset">
        <input type="submit" value="reset">
    </form>
    <a href="admin.php">Go back</a>
</main>