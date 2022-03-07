<?php

namespace App\Helpers;

class Curl_And_XPath_Query
{
    public \DOMXPath $xpathQuery;
    public \DOMDocument $dom;

    public function __construct($url)
    {
        $html = $this->curl($url);
        $this->dom = new \DOMDocument();
        @$this->dom->loadHTML($html);
        $this->xpathQuery = new \DOMXPath($this->dom);
    }

    private function curl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $result = curl_exec($ch);
        if (!$result) {
            echo "curl error number: " . curl_errno($ch);
            echo "<br />curl error: " . curl_error($ch) . " on following URL - " . $url;
            var_dump(curl_getinfo($ch));
            var_dump(curl_error($ch));
            exit;
        }
        return $result;
    }

    public function cx_query($query): \DOMNodeList|bool
    {
        $result = $this->xpathQuery->query($query);
        return $result;
    }
}