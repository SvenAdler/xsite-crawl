<!DOCTYPE html>
<html>
<head>
    <title>Result_Frame</title>
    <meta charset="UTF-8">
</head>

<body>

<?php
// Get the results
//
// out of the Session
$this->session = \Config\Services::session();

if($this->session->has('emptyUrl_crawlerror'))
{
    print_r($emptyUrl = $this->session->get('emptyUrl_crawlerror'));
}
elseif($this->session->has('invalidUrl_crawlerror'))
{
    print_r($invalidUrl = $this->session->get('invalidUrl_crawlerror'));
}
else
{
    print_r("<pre>");
    $urlArr = $this->session->get('crawlArr');
    foreach ($urlArr as $element)
    {
        echo htmlentities($element['url'],ENT_COMPAT);
        echo "\n";
    }
    print_r("</pre>");
}
?>

</body>
</html>