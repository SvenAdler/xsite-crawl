<?php

namespace App\Helpers;

class CurlQuery
{
    /**
     * eventuell wird die Logik von Xpath zu Regex o.Ä. geändert.
     */
    public \DOMXPath $xpathQuery;
    public \DOMDocument $dom;

    public function __construct($url)
    {
        $html = $this->_curl($url);
        $this->dom = new \DOMDocument();
        @$this->dom->loadHTML($html);
        $this->xpathQuery = new \DOMXPath($this->dom);
    }

    private function _curl($url)
    {
        // Curl Timer integrieren
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $result = curl_exec($ch);
        if(!$result)
        {
            echo "curl error number: " . curl_errno($ch);
            echo "<br />curl error: " . curl_error($ch) . " on following URL - " . $url;
            var_dump(curl_getinfo($ch));
            var_dump(curl_error($ch));
            exit;
        }
        return $result;
    }

    public function query($query)
    {
        $result = $this->xpathQuery->query($query);
        return $result;
    }

    /* Preview Funktion -> wird entfernt
    public function preview($results)
    {
        echo "<pre>";
        print_r($results);
        echo "<br>Node Values<br>";
        $array = array();
        foreach ($results as $result)
        {
            echo trim($result->nodeValue) . '<br>';
            $array[] = $result;
        }
        echo "<br><br>";
        print_r($array);
    }
    */
}