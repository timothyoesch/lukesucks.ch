<?php
global $conn;
$stmt = $conn->prepare("SELECT * FROM `signs` WHERE `sign_status` = '1' AND `sign_public` = '1'");
$stmt->execute();
$publicSigns = $stmt->get_result();
$publicSigns = $publicSigns->fetch_all(MYSQLI_ASSOC);

$i = 0;
foreach($publicSigns as $sign) : ?>
    <strong><?= $sign["sign_fname"] ?> <?= $sign["sign_lname"] ?>,</strong><?php if ($sign["sign_orga"] != "") : ?> <?= $sign["sign_orga"] ?>,<?php endif; ?> <?= $sign["sign_plz"] ?> <?= $sign["sign_ort"] ?><?php if ($i < count($publicSigns) - 1) : ?>;<?php endif; ?>
<?php
$i++;
endforeach;