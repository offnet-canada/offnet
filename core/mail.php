<?php
/* ____  _____________   ______________
  / __ \/ ____/ ____/ | / / ____/_  __/
 / / / / /_  / /_  /  |/ / __/   / /   
/ /_/ / __/ / __/ / /|  / /___  / /    
\____/_/   /_/   /_/ |_/_____/ /_/  */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../thirdparty/PHPMailer/src/Exception.php';
require '../thirdparty/PHPMailer/src/PHPMailer.php';
require '../thirdparty/PHPMailer/src/SMTP.php';

function mailer($body, $subject = "Error", $to = "default@default.com", $username = "Offnet User") {
	$mail = new PHPMailer;

	//$mail->SMTPDebug = 3;                               // Enable verbose debug output

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = Core::ini('email', 'domain');  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = Core::ini('email', 'sender');                 // SMTP username
	$mail->Password = Core::ini('email', 'senderpass');                           // SMTP password
	$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 465;                                    // TCP port to connect to

	$mail->From = Core::ini('email', 'sender');
	$mail->FromName = 'Offnet Serivce';
	$mail->addAddress($to, $username);     // Add a recipient
	$mail->isHTML(true);                                  // Set email format to HTML

	$mail->Subject = $subject;
    $mail->Body    = $body;
    $mail->send();
}
?>
