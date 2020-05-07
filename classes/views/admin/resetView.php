<main class="adminPagina">
    <div class="jumbotron">
        <h2 class="display-5">Welkom master op de Adminpagina</h2>
        <p>Op deze pagina heeft u een aantal opties waar alleen u toegang tot heeft.</p>
    </div>
    <h3>Reset the database:</h3>
    <form method="post" action="">
        <input type="hidden" name="token" value="<?=$token?>">
        <input type="hidden" name="category" value="reset">
        <input type="submit" value="reset">
    </form>
    <a href="admin.php">Go back</a>
</main>