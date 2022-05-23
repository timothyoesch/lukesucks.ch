<?php
require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
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

$Browser = new foroco\BrowserDetection();
$useragent = $_SERVER['HTTP_USER_AGENT'];
$result = $Browser->getAll($useragent);
$userdata = json_encode($result);
global $userdata;

$mcapi = $_ENV["MCAPI"];
$mclistid = $_ENV["MCLISTID"];
$mcserver = $_ENV["MCSERVER"];
$mcclient = new \MailchimpMarketing\ApiClient();
$mcclient->setConfig([
    'apiKey' => $mcapi,
    'server' => $mcserver
]);
global $mcclient;

$conn = new mysqli($_ENV['DBHOST'], $_ENV['DBUSER'], $_ENV['DBPW'], $_ENV['DBNAME']);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    $conn->set_charset("utf8");
}
global $conn;


Router::get('/', function() {
    $page = [
        "title" => "Keine Show für Täter - Luke Mockridge sucks",
        "desc" => "Luke Mockridge wird am 29. Mai im Hallenstadion Zürich auftreten, hilf mit, das zu verhindern!",
    ];
    include __DIR__ . "/../templates/home.php";
});

Router::post('/add', function() {
    include __DIR__ . "/../interfaces/add.php";
});

Router::get('/freischalten/{uuid}', function($uuid) {
    include __DIR__ . "/../interfaces/freischalten.php";
});

Router::get('/fetchall', function() {
    include __DIR__ . "/../interfaces/fetchall.php";
});


Router::get('/analytics', function() {
    include __DIR__ . "/../templates/analytics.php";
});