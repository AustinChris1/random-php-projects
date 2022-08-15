<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Load Composer's autoloader
require "vendor/autoload.php";

if(isset($_POST['mail'])){
$body = file_get_contents("example.php");
$variables = array (
    "{{name}}" => "Austin-Chris",
    "{{token}}" => md5(rand()),
    "{{str}}" => 123455,
    "{{email}}" => "iwuaustinchris@gmail.com",

);
foreach ($variables as $key => $values){
    $body = str_replace($key, $values, $body);
}
echo $body;
$name = $variables["{{name}}"];
$email = $variables["{{email}}"];
$token = $variables["{{token}}"];

    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = "server236.web-hosting.com";
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "ssl";
    $mail->Port = 465;

    $mail->Username = "info@spectrawebx.xyz";
    $mail->Password = $mail['password'];

    $mail->setFrom("info@spectrawebx.xyz", "Spectra Web-X");
    $mail->addAddress($email);

    //Content
    $mail->isHTML(true);
    $mail->Subject = "Spectra Web-X Email Verification";

    $email_template = "
    <h2>Hello $name, Welcome to Spectra Web-X</h2>
    <img src='https://ibb.co/rb0f5tc' width='200px' height='200px'>
    <h5>Thanks for your registration.<br> Please verify your email address by clicking the button below</h5><br/><br/>
    <a style='background-color:orange; color:white; padding: 2px 2px 2px 2px ' href='http:/192.168.43.46/portfolio/verify-email.php?token=$token'>Verify my account</a>

    ";
    // 'https://unsplash.it/801'
    $mail->Body = $body;
    $mail->send();

}
?>

<?php
include "header.php";
?>
<div class="container">
<div class="row">
<div class="card">
<div class="card-header">
<h1>Include Bootstrap page in mail</h1>
<div class="card-body">
    <form action="" method="post">
<button class="btn btn-info" name="mail">Send Mail</button></div></div></div></div></div>
</form>
<?php
include "footer.php";
?>