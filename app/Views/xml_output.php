<?php

use Config\Services;

$this->session = Services::session();
// Attention. CI_Enivronment must be set to production, otherwise debug information is written to the XML file
// Output String with header -> Content-Type:text/xml
if ($xml = $this->session->get('crawlXML')) {
    header('Content-Type: text/xml; charset=utf-8');
    header('Content-Disposition: attachment; filename=sitemap.xml');
    print_r($xml);
}
