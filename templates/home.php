<?php
include(__DIR__ . "/partials/header.php");
global $userdata;

global $conn;
$stmt = $conn->prepare("SELECT * FROM `signs` WHERE `sign_status` = '1'");
$stmt->execute();
$signs = $stmt->get_result();
$numSigns = $signs->num_rows;

$stmt = $conn->prepare("SELECT * FROM `signs` WHERE `sign_status` = '1' AND `sign_public` = '1' LIMIT 25");
$stmt->execute();
$publicSigns = $stmt->get_result();
$publicSigns = $publicSigns->fetch_all(MYSQLI_ASSOC);

?>

<div id="heroine-container">
    <div id="heroine-inner" class="w-full py-20">
        <div id="heroine-content" class="my-auto mx-auto">
            <h1>Keine Show</h1>
            <h1>für Täter!</h1>
        </div>
    </div>
    <img src="/img/fuckluke.jpg" alt="Picture of Luke Mockridge with his eyes stricken through." id="heroine-bg-img">
</div>
<div id="open-letter" class="pb-20">
    <div class="sm-cont">
        <div id="heroine-mob-content" class="mt-14">
            <h1 class="bg-header text-7xl mb-4">Keine Show</h1>
            <h1 class="bg-header text-7xl">für Täter!</h1>
        </div>
        <div id="letter-text" class="text-2xl mt-14">
            <p><strong>Luke Mockridge wird am 29. Mai im Hallenstadion Zürich auftreten, hilf mit, das zu verhindern!</strong></p>
            <p>Nach dem Vorwurf der versuchten Vergewaltigung an seiner Ex-Freundin äusserten sich in einer Recherche des Spiegel 10 Frauen unabhängig voneinander, Mockridge sei ihnen gegenüber sexuell übergriffig gewesen. <strong>Er akzeptiere kein »Nein«, in ihren Schilderungen fallen immer wieder die Worte »aggressiv« und »rücksichtslos«.</strong> Anstatt seine Energie in die Aufarbeitung seines übergriffigen Verhaltens zu investieren, <strong>bemüht sich Mockridge darum, die Betroffenen und Journalist*innen mundtot zu machen und geht gerichtlich gegen sie vor.</strong> Ebenfalls ist bewiesen, dass er die berufliche Karriere seiner Ex-Freundin nach den geäusserten Vorwürfen massgeblich sabotiert hat.</p>
            <p>Jetzt witzelt er über das Thema in seiner neuen Show, mit der er gerade auf Tour ist. Wenn es nach den Veranstaltern geht am 29. Mai im Hallenstadion Zürich.</p>
            <p><strong>Es ist wegen Geschichten wie diesen, dass Vorfälle sexualisierter Gewalt nur in den seltensten Fällen angezeigt werden.</strong> Überlebenden wird nicht geglaubt, sie werden nicht ernst genommen und die Täter kommen grösstenteils unbeschadet davon.</p>
            <p>In einer patriarchalen Gesellschaft hat diese strukturelle vielschichtige Gewalt gegen Flinta* System. <strong>Ni una Menos, wir sind viele!</strong></p>
            <p><strong>Veranstaltungsorte wie das Hallenstadion Zürich und Veranstalter*innen wie die Act Entertainment AG sind dafür verantwortlich, wem sie eine Bühne geben. Sie müssen Luke Mockridges Auftritt absagen. Ausserdem fordern wir, dass sie zu ihrer Entscheidung, einem Täter weiterhin eine Plattform geben zu wollen, Stellung beziehen. Keine Show für Täter, Konsequenzen für Luke!</strong></p>
        </div>
        <p class="text-2xl mt-14">Bisher haben <b><?= $numSigns ?> Personen</b> unterschrieben!</p>
        <div id="signatures" class="text-sm mt-6">
            <p>
                <?php
                $i = 0;
                foreach($publicSigns as $sign) : ?>
                    <strong><?= $sign["sign_fname"] ?> <?= $sign["sign_lname"] ?>,</strong><?php if ($sign["sign_orga"] != "") : ?> <?= $sign["sign_orga"] ?>,<?php endif; ?> <?= $sign["sign_plz"] ?> <?= $sign["sign_ort"] ?><?php if ($i < count($publicSigns) - 1) : ?>;<?php endif; ?>
                <?php
                $i++;
                endforeach;
                ?>
            </p>
            <?php
            if(count($publicSigns) == 25): ?>
                <div id="signatures-blind">
                    <a id="show-more"><?= $numSigns - 25 ?> weitere Unterschriften anzeigen</a>
                </div>
            <?php
            endif;
            ?>
        </div>
        <h2 class="text-center bg-header text-8xl mt-16 mb-10">Hilf mit!</h2>
        <div id="message-container" class="my-6 p-3 leading-none">
            <span id="response-message">
                This is where the response message will stand.
            </span>
        </div>
        <form action="#" id="sign-form">
            <input type="hidden" name="uuid" value="<?= uniqid("sign_") ?>">
            <input type="hidden" name="userdata" value='<?= $userdata ?>'>
            <div class="input-group">
                <label for="fname">Vorname</label>
                <input type="text" id="fname" name="fname" required>
            </div>
            <div class="input-group">
                <label for="lname">Nachname</label>
                <input type="text" id="lname" name="lname" required>
            </div>
            <div class="input-group">
                <label for="email">E-Mail</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-group half">
                <label for="plz">PLZ</label>
                <input type="text" id="plz" name="plz" required>
            </div>
            <div class="input-group half">
                <label for="city">Ort</label>
                <input type="text" id="city" name="city" required>
            </div>
            <div class="input-group">
                <label for="orga">Organisation</label>
                <input type="text" id="orga" name="orga" placeholder="optional">
            </div>
            <div class="input-group optin">
                <input type="checkbox" id="public" name="public" checked>
                <label for="public">Ich möchte, dass mein Name öffentlich angezeigt wird.</label>
            </div>
            <div class="input-group optin">
                <input type="checkbox" id="optin" name="optin" checked>
                <label for="optin">Die JUSO darf mich über diesen Brief auf dem Laufenden halten.</label>
            </div>
            <button type="submit">Unterschreiben</button>
        </form>
        <div id="luke-mobi-container" hidden>
            <p class="font-2xl mb-5">Teile diesen Brief mit deinen Freund*innen, <b>damit wir möglichst lautstark zeigen können, dass Tätern keine Bühne gegeben werden darf!</b></p>
            <div id="luke-mobi-buttons" class="flex flex-wrap gap-2 mt-3">
                <button id="luke-mobi-whatsApp" data-type="whatsapp" class="luke-button">Auf WhatsApp teilen</button>
                <button id="luke-mobi-telegram" data-type="telegram" class="luke-button">Auf Telegram teilen</button>
                <button id="luke-mobi-facebook" data-type="facebook" class="luke-button">Auf Facebook teilen</button>
                <button id="luke-mobi-twitter" data-type="twitter" class="luke-button">Auf Twitter teilen</button>
                <button id="luke-mobi-copy" data-type="copy" class="luke-button">Nachricht kopieren</button>
                <button id="luke-mobi-email" data-type="email" class="luke-button luke-button-sec">Per Email teilen</button>
            </div>
        </div>
    </div>
</div>


<?php
include(__DIR__ . "/partials/footer.php");
?>
