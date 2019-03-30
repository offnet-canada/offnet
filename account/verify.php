<?php
session_start();
require_once '../app/init.php';
$error = false;
if (!isset($_SESSION['id'])) {
    session_destroy();
    header("Location: index.php");
    die();
}
if (isset($_POST['submit']) && isset($_POST['code'])) {
    if (!Verify::check($_SESSION['id'], $_POST['code'])) {
        session_destroy();
        header("Location: index.php");
        die();
    } else {
        $_SESSION['login'] = true;
        header("Location: account.php");
    }
}
?>
<html>
<head>
    <title>Offnet Login</title>
    <link rel="icon" href="favicon.ico">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="//cdn.rawgit.com/necolas/normalize.css/master/normalize.css">
    <link rel="stylesheet" href="//cdn.rawgit.com/milligram/milligram/master/dist/milligram.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto+Slab">
</head>

<body>

<?php
if ($error) {
    echo "
<div id='note'>
    $error <a id='close'>[close]</a>
</div>
";
}
?>

<div class="parent">
    <div class="child">
        <h2>Enter Code</h2>
        <form action="verify.php" method="post">
          <fieldset>
            <label for="nameField">Code</label>
            <input type="text" name="code" placeholder="12345" id="code">
            <input class="button-primary" name="submit" type="submit" value="Check Code">
          </fieldset>
        </form>
    </div>
</div>
</body>
</html>
