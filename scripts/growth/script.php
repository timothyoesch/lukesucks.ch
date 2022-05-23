<?php
require __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../../");
$dotenv->safeLoad();

use Pecee\SimpleRouter\SimpleRouter as Router;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
global $mail;

try {
    //Server settings
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $_ENV["MAILHOST"];                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $_ENV["MAILUSER"];                     //SMTP username
    $mail->Password   = $_ENV["MAILPW"];                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = $_ENV["MAILPORT"];                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom($_ENV["MAILFROM"]);
    $mail->addAddress($_ENV["MAILTO"]);

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

$conn = new mysqli($_ENV['DBHOST'], $_ENV['DBUSER'], $_ENV['DBPW'], $_ENV['DBNAME']);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    $conn->set_charset("utf8");
}
global $conn;

$stmt = $conn->prepare("SELECT * FROM `signs` WHERE `sign_status` = '1';");
$stmt->execute();
$result = $stmt->get_result();
$signs = $result->fetch_all(MYSQLI_ASSOC);
$numsigns = count($signs);

$stmt = $conn->prepare("INSERT INTO `growth` (`measurement_number`) VALUES (?)");
$stmt->bind_param("i", $numsigns);
$stmt->execute();

file_put_contents(__DIR__ . "/growth-script.log", date("Y-m-d H:i:s") . ": " . $numsigns . " signs\n", FILE_APPEND);