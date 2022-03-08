<?php

namespace App\Helpers;

class Curl_and_XPATH
{
    private \DOMDocument $dom;
    private \DOMXPath $xpath;

    public function __construct($url)
    {
        $html = $this->curl($url);
        $this->dom = new \DOMDocument();
        @$this->dom->loadHTML($html);
        $this->xpath = new \DOMXPath($this->dom);
    }

    private function curl($url)
    {
        $ch = curl_init();
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_AUTOREFERER => false,
            CURLOPT_FOLLOWLOCATION => true
        ];
        curl_setopt_array($ch, $options);
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
        return $this->xpath->query($query);
    }
}