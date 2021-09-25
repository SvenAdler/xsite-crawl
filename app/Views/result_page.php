<!DOCTYPE html>
<html>
<head>
    <title>Result page</title>
  <!--  <link rel="stylesheet" href="my_toucan_design.css"> -->
    <meta charset="UTF-8">
    <meta name="description" content="URL Webscaper and XML-Generator written in PHP."/>
    <meta name="author" content="Sven Adler"/>
</head>

<body>

<?php
$this->session = \Config\Services::session();
if($this->session->has('emptyUrl_crawlerror'))
    //(isset($_SESSION['emptyUrl_crawlerror']))
{
    print_r($emptyUrl = $this->session->get('emptyUrl_crawlerror'));
    //print_r($_SESSION['crawlerror']);
} else if($this->session->has('invalidUrl_crawlerror'))
    //(isset($_SESSION['invalidUrl_crawlerror']))
{
    print_r($invalidUrl = $this->session->get('invalidUrl_crawlerror'));
    //print_r($_SESSION['crawlresults']);
} else
{
    print_r("<pre>");
    print_r($urlArr = $this->session->get('url'));
//    $urlArr = $this->session->get('url');
//    return  $urlArr;

    //print_r($_SESSION['crawlresults']);
}
?>

</body>
</html>