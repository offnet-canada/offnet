<?php
session_start();
require_once '../app/init.php';
$error = false;
if (!isset($_SESSION['login'])) {
    session_destroy();
    header("Location: index.php");
    die();
}
?>

<html>
<head>
    <title>Offnet Account</title>
    <link rel="icon" href="favicon.ico">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="//cdn.rawgit.com/necolas/normalize.css/master/normalize.css">
    <link rel="stylesheet" href="//cdn.rawgit.com/milligram/milligram/master/dist/milligram.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto+Slab">
</head>

<body>

<div class="Account">
<h1>Account:</h1>
<h3>Phone: <?php echo $_SESSION['phone']; ?> </h3>
<h3>Credit: 
<?php 
$credit = \Subscription::getCredit($_SESSION['id']); 
if ($credit < 0) {
    $credit = 0;
}
echo $credit;
?> </h3>
</div>

<?php
if ($error) {
    echo "
<div id='note'>
    $error <a id='close'>[close]</a>
</div>
";
}
?>

</body>
</html>
