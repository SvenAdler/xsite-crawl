<?php

namespace App\Controllers;

use App\Helpers\URL_Entry_Validator;
use App\Helpers\Curl_and_XPATH;
use App\Helpers\Relative_To_Absolute_Helper;
use CodeIgniter\Session\Session;
use Config\Services;
use PHPUnit\Util\Exception;

class Crawler extends BaseController
{
    private Session $session;
    private Relative_To_Absolute_Helper $relToAb;

    public function __construct()
    {
        $this->session = Services::session();
        $this->session->start();
        $this->validator = new URL_Entry_Validator();
        $this->relToAb = new Relative_To_Absolute_Helper();
    }

    public function main(): string
    {
        $url = trim($this->request->getPost('URL'));

        if ($this->accept_url($url) === true) {
            $this->crawl_execute($url);
        }
        return view('result_page');
    }

    private function accept_url($url): bool
    {
        //Remove session data
        $this->session->remove('emptyUrl_crawlerror');
        $this->session->remove('invalidUrl_crawlerror');
        $this->session->remove('crawlArr');
        $this->session->remove('crawlXML');

        $parsedURL = parse_url($url);
        if (empty($parsedURL['scheme'])) {
            $url = 'https://' . $url;
        }
        $this->session->set('baseUrl', $url);

        // error messages if url is not accepted
        if (!$url) {
            $this->session->set('emptyUrl_crawlerror', '1#EMPTY URL: Please enter an URL!');
            return false;
        } elseif (!$this->validator->validate_url($url)) {
            $this->session->set('invalidUrl_crawlerror', '2#INVALID URL: Please enter a valid URL!');
            return false;
        }
        return true;
    }

    private function crawl_execute($url): void
    {
        // timelimit
        $timeLimit = $this->session->has('timeLimit') ? $this->session->get('timeLimit') : 1;

        $this->crawledData = array();
        $this->alreadyPlannedUrls = array($url);
        //List of urls to be crawled contains at first only the url given by user
        $this->toCrawl = array($url);
        $endTime = time() + $timeLimit;
        while (!empty($this->toCrawl) && time() < $endTime) {
            $u = array_shift($this->toCrawl); // remove first element of list (toCrawl)
            $this->crawl($u);                       // crawling this url will add further urls
        }
        // set the session variables for preview and the XML-Output
        $this->session->set('crawlArr', $this->crawledData);
        $this->session->set('crawlXML', $this->toXML($this->crawledData));
    }

    private function crawl($url): void
    {
        $baseUrl = $this->session->get('baseUrl');
        $excludeList = $this->session->has('excludeList') ? $this->session->get('excludeList') : array();
        $xpathQuery = new Curl_and_XPATH($url);
        $links = $xpathQuery->cx_query("//a/@href");
        for ($i = 0; $i < $links->length; ++$i) {
            $link = $links->item($i)->nodeValue; // just relative part of url
            // In case of #
            if (str_starts_with($link, '#')) {
                continue;
            }

            // Paths to exclude
            $exclude = false;
            foreach ($excludeList as $excludePart) {
                if (str_contains(strtolower($link), strtolower($excludePart))) {
                    $exclude = true;
                    break;
                }
            }
            if ($exclude) {
                continue;
            }
            $parsedLink = parse_url($link);
            if ((isset($parsedLink['scheme']) && !empty($parsedLink['scheme'])) || str_starts_with($link, '//')) {
                if (!isset($this->alreadyPlannedUrls[$link]) && str_starts_with($link, $baseUrl)) {
                    // Absolute URLs: note, but do not crawl -> Comment in the line below to crawl it
                    //                                       -> Comment out to not crawl the absolute URLs
                    $this->crawledData[] = array('url' => $link, 'crawlInfo' => 'Absolute');
                    $this->alreadyPlannedUrls[$link] = true; // Urls als key die unique sein müssen, wird direkt in php gemacht und irgendwas als value
                }
            } else {
                $solvedLink = $this->relToAb->relative_to_absolute_url($baseUrl, $link);
                if (!isset($this->alreadyPlannedUrls[$solvedLink])) {
                    $data = array('url' => $solvedLink, 'crawlInfo' => 'Relative'); // Intermediate variable for all data
                    $data['lastmod'] = date("c"); // Placeholder
                    try {
                        $headers = get_headers($solvedLink);
                        foreach ($headers as $h) {
                            if (str_starts_with($h, 'Last-Modified:')) {
                                $data['lastmod'] = date('c', strtotime(trim(substr($h, 14))));
                                break;
                            }
                        }
                    } catch (Exception) {
                        // no lastmodified returned
                        $data['lastmod'] = 'Unknown, Exception at get_headers()';
                    }

                    $this->crawledData[] = $data;
                    $this->alreadyPlannedUrls[$solvedLink] = true; // Generates Set of planned Urls
                    $this->toCrawl[] = $solvedLink; // Insert Url in queue
                }
            }
        }
    }

    private function toXML($s): string
    {
        helper('xml');
        $xml = "<?xml version='1.0' encoding='UTF-8'?>\n";
        $xml .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\" 
        xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" 
        xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">\n";
        foreach ($s as $link) {
            $xml .= "<url>\n";
            $xml .= "    <loc>" . xml_convert($link['url']) . "</loc>\n";
            if (isset($link['lastmod'])) {
                $xml .= "    <lastmod>" . $link['lastmod'] . "</lastmod>\n";
            }
            $xml .= "</url>\n";
        }
        $xml .= "</urlset>\n";
        return $xml;
    }

    public function download()
    {
        return view('xml_output');
    }
}

