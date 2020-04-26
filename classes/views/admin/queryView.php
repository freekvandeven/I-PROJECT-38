<?php


?>

<main>
    <h2>Send sql queries</h2>
    <form method="post" action="">
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
