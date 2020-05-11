<?php
session_start();
if(!isset($_SESSION['code'])){
    $_SESSION['code'] = rand(1000,9999);
}
if(isset($_POST['code']) && !empty($_POST['code'])){
    if($_POST['code'] == $_SESSION['code']){
        header("Location: https://www.youtube.com/watch?v=dQw4w9WgXcQ");
    } else {
        $_SESSION['code'] = rand(1000,9999);
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="stylesheet" href="../css/denied.css" />
    <title>Access Denied</title>
    <script src="../js/RotaryDial.js"></script>
</head>
<body>
    <h3>You have been denied access to the website</h3>
    <p>Prove that you are not a computer by filling in this code: <?=$_SESSION['code']?></p>
    <form id="myForm" method="post">

    </form>
    <!--
    <div></div>
    <form>
        <label for="code">Code</label>
        <input id="code" type="number">
        <input type="submit" name="submit" value="prove">
        <button name="clear" type="button"></button>
    </form>
    -->
<script>
    const init = function(){
        /*
        const div = document.getElementsByName('div');

        const input = document.getElementById('code');

        const btn = document.getElementsByName('button');

        btn.innerText = "Clear";
        btn.addEventListener("click", e => {
            input.value = "";
        });

        input.type = "text";

        div.append(input);
        div.append(btn);
        */
        const div = document.createElement('div');

        const input = document.createElement('input');
        input.setAttribute("type", "number");
        input.setAttribute("name", "code");
        const submit = document.createElement('input');
        submit.setAttribute("type", "submit");
        submit.setAttribute("value", "Prove");
        const btn = document.createElement('button');

        btn.innerText = "Clear";

        btn.addEventListener("click", e => {
            input.value = "";
        });

        div.append(input);
        div.append(submit);
        div.append(btn);
        var form = document.getElementById("myForm");
        form.appendChild(div);

        const func = function(value){
            input.value += value;
        }

        const rd = new RotaryDial({callback: func});

    }

    init();
</script>

</body>
</html>