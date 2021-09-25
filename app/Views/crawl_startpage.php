<!DOCTYPE html>
<html>
<head>
    <title>Webscraper and XML-Generator</title>

    <meta charset="UTF-8">
    <meta name="description" content="URL Webscaper and XML-Generator written in PHP."/>
    <meta name="author" content="Sven Adler"/>
    <link rel="stylesheet" href="<?= base_url('startpage_style.css') ?>">

</head>
<body>
    <form action="<?= base_url('Crawler/acceptURL') ?>" target="result_frame" method="post" class="url-form-style">
        <ul>
        <li>
            <label for="URL">Enter URL</label>
            <input type="text" name="URL" placeholder="..."/>
            <span>Enter the full website URL here (e.g. https://www.duckduckgo.com)</span>
        </li>
        <li>
            <input type="submit" value="Submit"/>
        </li>
        </ul>
    </form>
    <iframe id="result_frame" name="result_frame"></iframe><br /> <?php /*src="<?= base_url('result_page')?>"*/?>
    <!--<iframe id="second_result_frame" name="second_result_frame"></iframe> -->
    <form action="<?= base_url('Crawler/_downloadData') ?>" method="post">
    <input type="submit" value="Download" name="download" class="download-button-style">
    </form>
        <!--
<select class="test-select" name="option">
    <option value="" disabled selected>Choose your option</option>
    <option value="1">Option 1</option>
    <option value="2">Option 2</option>
    <option value="3">Option 3</option>
</select>

<div class="footer">
    <p>Created for Digitas Pixelpark.</p>
</div>
-->
</body>
</html>