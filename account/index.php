<?php
require_once '../app/init.php';
$error = false;
if ($_SERVER['HTTP_REFERER'] = "http://account.offnet.ca/verify.php") {
    $error = "Invalid Code";
}
if (isset($_POST['submit'])) {
    $recaptcha=$_POST['g-recaptcha-response'];
    $google_url=Core::ini('captcha','url');
    $secret=Core::ini('captcha','secret');
    $ip=$_SERVER['REMOTE_ADDR'];
    $url = file_get_contents($google_url."?secret=".$secret."&response=".$recaptcha."&remoteip=".$ip);
    $data = json_decode($url);
    //Check Captcha
    if(!isset($data->success) OR !$data->success==true) {
        $error = "Invalid Captcha";
    } else {
        //Check input
        if (!isset($_POST['phone'])) {
            $error = "No Phone Number";
        } else {
            //Check to see if account exists
            $accountId = \Account::getId($_POST['phone']);
            if (!$accountId) {
                $error = "Account Doesn't Exsit";
            } else {
                //Generate Code
                \Verify::generate($accountId, $_POST['phone']);
                session_start();
                $_SESSION['id'] = $accountId;
                $_SESSION['phone'] = $_POST['phone'];
                //Send to verification page
                header("Location: verify.php");
            }
        }
    }
}
?>
<html>
<head>
    <title>Offnet Login</title>
    <meta name="google-site-verification" content="MVAlxIYS8MCv2R1M9ZhX_0miWoL4PHzg9p-ZH5qUuPQ"/>
    <script src='https://www.google.com/recaptcha/api.js'></script>
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
        <h2>Login</h2>
        <form action="index.php" method="post">
          <fieldset>
            <label for="nameField">Phone Number</label>
            <input type="text" name="phone" placeholder="19020000000" id="phone">
            <div class="g-recaptcha" data-sitekey="<?php echo Core::ini('captcha','key'); ?>"></div>
            <input class="button-primary" name="submit" type="submit" value="Send Verification Code">
          </fieldset>
        </form>
    </div>
</div>
</body>

<script>
 close = document.getElementById("close");
 close.addEventListener('click', function() {
   note = document.getElementById("note");
   note.style.display = 'none';
 }, false);
</script>
</html>
