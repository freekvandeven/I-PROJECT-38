<main class="adminPagina">
    <div class="jumbotron">
        <h2 class="display-5">Welkom master op de Adminpagina</h2>
        <p>Op deze pagina heeft u een aantal opties waar alleen u toegang tot heeft.</p>
    </div>
    <h2>Send sql queries</h2>
    <form method="post" action="">
        <input type="hidden" name="token" value="<?=$token?>">
        <input type="hidden" name="category" value="query">
        <label for="queryField">SQL Query:</label>
        <input type="text" name="queryString" id="queryField" value="">
        <input type="submit" value="Query">
    </form>
    <a href="admin.php">Go back</a><br>
    <p>
    <?php if(isset($result)){
        echo "Query: " . $_POST['queryString'] . " gave result:<br>";
        echo $result;
    }?>
    </p>
</main>
