<?php
if($json = json_decode(file_get_contents("php://input"), true)) {
    $data = $json;
} else {
    $data = $_POST;
}
global $conn;
global $mcclient;
$mclistid = $_ENV["MCLISTID"];
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"];

$stmt = $conn->prepare("SELECT * from `signs` WHERE `sign_email` = ?;");
$stmt->bind_param("s", $data['email']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows != 0) {
    $return = [
        "status" => "error",
        "code" => "e.1:16",
        "message" => "Diese E-Mail-Adresse wurde bereits verwendet.",
    ];
    echo json_encode($return);
    exit;
}


if ($data["optin"] == false) {
    $optin = 0;
} else {
    $optin = 1;
}

if ($data["public"] == false) {
    $public = 0;
} else {
    $public = 1;
}

$stmt = $conn->prepare("INSERT INTO `signs` (`sign_uuid`, `sign_fname`, `sign_lname`, `sign_email`, `sign_orga`, `sign_plz`, `sign_ort`, `sign_data`, `sign_optin`, `sign_public`) VALUES (?,?,?,?,?,?,?,?,?,?);");
$stmt->bind_param("ssssssssss", $data['uuid'], $data['fname'], $data['lname'], $data['email'], $data['orga'], $data['plz'], $data['city'], $data['userdata'], $optin, $public);
$result = $stmt->execute();
if ($result != 1) {
    $return = [
        "status" => "error",
        "code" => "e.2:29",
        "message" => "Leider ist ein Fehler aufgetreten. Bitte versuchen Sie es später erneut.",
        "error" => $conn->error
    ];
    echo(json_encode($return));
    exit;
}


if ($data["optin"]) {
    try {
        $response = $mcclient->lists->setListMember($mclistid, strtolower(md5($data["email"])), [
            "email_address" => $data["email"],
            'merge_fields' => [
                    "FNAME" => $data["fname"],
                    "LNAME" => $data["lname"]
            ],
            'tags' => ["lukesucks.ch"],
            "status" => "subscribed",
        ]);
    } catch (GuzzleHttp\Exception\ClientException $e) {
    $return = [
      "status" => "error",
      "code" => "e.3:54",
      "message" => "Da ist etwas schief gelaufen, bitte versuch es nochmals.",
      "content" => $e->getResponse()->getBody()->getContents(),
      "errors" => [$e->getMessage()]
    ];
    echo(json_encode($return));
    exit;
    }

    try {
        $response = $mcclient->lists->createListMemberNote(
            $mclistid,
            strtolower(md5($data["email"])),
            [
                "note" => "Form submission: " . $data["uuid"]
            ]
        );
    } catch (GuzzleHttp\Exception\ClientException $e) {
        $return = [
            "status" => "error",
            "code" => "e.4:74",
            "message" => "Da ist etwas schief gelaufen, bitte versuch es nochmals.",
            "content" => $e->getResponse()->getBody()->getContents(),
            "errors" => [$e->getMessage()]
        ];
        echo(json_encode($return));
        exit;
    }
}

global $mail;
try {
    $mail->Subject = 'Neue Unterschrift: lukesucks.ch';
    $mail->Body    = <<<EOD
    Ciao!<br><br>
    Es gab eine neue Unterschrift für den offenen Brief auf lukesucks.ch. Hier die Infos:<br><br>
        <ul>
            <li><b>Vorname:</b> {$data["fname"]}</li>
            <li><b>Nachname:</b> {$data["lname"]}</li>
            <li><b>E-Mail:</b> {$data["email"]}</li>
            <li><b>Organisation:</b> {$data["orga"]}</li>
            <li><b>PLZ:</b> {$data["plz"]}</li>
            <li><b>Ort:</b> {$data["city"]}</li>
        </ul>
    <br>
    Wenn du den Eintrag freischalten möchtest, kannst du das hier tun: <a href="{$actual_link}/freischalten/{$data["uuid"]}">{$actual_link}/freischalten/{$data["uuid"]}</a><br><br>
    Vielen Dank für deine Unterstützung!<br><br>
    <b>Timothy</b>
    EOD;
    $mail->send();
} catch (Exception $e) {
    $return = [
        "status" => "error",
        "code" => "e.5:107",
        "message" => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}",
    ];
    echo(json_encode($return));
    exit;
}


$return = [
    "status" => "success",
    "code" => "s.1:87",
    "message" => "Danke für deine Unterschrift!",
];
echo(json_encode($return));
exit;