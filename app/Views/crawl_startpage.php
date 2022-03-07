<?php

use App\Helpers\URL_Exclude_Lists;

?>
<!DOCTYPE html>
<html lang="en">
<?php require "startpage_header.php" ?>
<body>
<!-- Enter URL Section -->
<form action="<?= base_url('Crawler/main') ?>" target="result_frame" method="post" class="url-form-style">
    <ul>
        <li>
            <label for="URL">Enter URL</label>
            <input type="text" name="URL" placeholder="..." required/>
            <span>Enter the full website URL here (e.g. https://www.duckduckgo.com)</span>
        </li>
        <li>
            <input type="submit" value="Submit"/>
        </li>
    </ul>
</form>

<!-- Show results -->
<iframe id="result_frame" name="result_frame"></iframe>

<!-- Settings Section-->
<button class="open-button" onclick="openSettingsForm()">Settings</button>
<div class="form-popup" id="myForm">
    <form action="<?= base_url('SettingsController/set_settings') ?>" class="form-container" method="post">
        <label for="timeLimit"><b>Time limit (sec)</b></label>
        <input type="number" name="timeLimit" placeholder="Set time limit" value="1" step="1" min="1" required>
        <br/>
        <b>Check to exclude URLs</b>
        <br/>
        <?php
        $ex = new URL_Exclude_Lists();
        $first = true;
        foreach ($ex->excludeLists as $key => $list) {
            ?>
            <input type="checkbox" name="<?= $key ?>" id="<?= $key ?>" <?= $first ? "checked" : "" ?>/>
            <div class="tooltip"><?= $key ?>
                <span class="tooltiptext">
                    <?= implode("<br />\n", $list) ?>
                </span>
            </div>
            <br/>
            <?php
            $first = false;
        }
        ?>
        <br/><br/>
        <button type="submit" class="btn">Save Settings</button>
        <button type="button" class="btn cancel" onclick="closeSettingsForm()">Close</button>
    </form>
</div>

<!-- Download button -->
<form action="<?= base_url('Crawler/download') ?>" method="post">
    <input type="submit" value="Download" name="download" class="download-button">
</form>

<script>
    function openSettingsForm() {
        document.getElementById("myForm").style.display = "block";
    }

    function closeSettingsForm() {
        document.getElementById("myForm").style.display = "none";
    }
</script>
</body>
</html>