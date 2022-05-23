<?php
global $conn;

$stmt = $conn->prepare("UPDATE `signs` SET `sign_status` = 1 WHERE `sign_uuid` = ?;");
$stmt->bind_param("s", $uuid);
$result1 = $stmt->execute();

$stmt = $conn->prepare("SELECT * FROM `signs` WHERE `sign_uuid` = ?;");
$stmt->bind_param("s", $uuid);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($result1 == 1) {
    $return = [
        "status" => "success",
        "code" => "s.1:17",
        "message" => "Dieser Eintrag wurde erfolgreich freigeschaltet.",
        "data" => $row
    ];
} else {
    $return = [
        "status" => "error",
        "code" => "e.1:24",
        "message" => "Da ist etwas schiefgelaufen. Möglicherweise ist der Eintrag bereits freigeschaltet. Wenn die kommende Zeile den Eintrag beinhaltet, dann ist er bereits freigeschaltet.",
        "data" => $row
    ];
}
echo(json_encode($return));
