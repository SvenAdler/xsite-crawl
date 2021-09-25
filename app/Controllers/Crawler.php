<?php

namespace App\Controllers;

use App\Helpers\URL_Validator;
use App\Helpers\CurlQuery;
use Codeigniter\Controller;

class Crawler extends BaseController
{
    public function __construct() {
          $this->session = \Config\Services::session();
          $this->session->start();
    }

    /*
     * Controller: am Ende der Empfangsfunktion redirect mit Framework

       @session_start() (oder Ähnliches mit Framework) in Ergebnis-View und in Controller einbauen
     *
     */
    public function acceptURL()
    {
            $this->session->remove('emptyUrl_crawlerror');
            $this->session->remove('invalidUrl_crawlerror');
            $url = trim($this->request->getPost('URL'));

            if(!$url)
            {
                $this->session->set('emptyUrl_crawlerror', ' 1#EMPTY URL: Please enter an URL!');
            } else
            {
                $validator = new URL_Validator();
                if(!$validator->validate_url($url))
                {
                    $this->session->set('invalidUrl_crawlerror', '2#INVALID URL: Please enter a valid URL!');
                } else
                {
                    // Timer starten, muss gleichzeitig mit crawl() laufen können, Thread
                    // Im seperaten Thread crawl starten und merken
                    // Timer in einem zweiten Thread starten, der den Crawl-Thread und sich selbst nach Zeit stoppt
                    //print_r($url . "!!!!");
                    $this->crawl($url); // die muss asynchron laufen
                    /*
                    - Thread für crawl() starten und merken
                    - Timer in einem 2. Thread starten, der nach der Zeit den Crawl-Thread und sich selbst stoppt

                    $crawlfred=new Thread(function() {
                    crawl($url);
                                });
                        $crawlfred->start();
                        $timerfred=new Thread(function() {
                        wait(1000*60);
                        if($crawlfred->isRunning()) {
                        $crawfred->stop();
                                            }
                                                }
                                        ));
                        $timerfred->start();
                     */
                }
            }

            #TODO redirect statt view? (return redirect('result_page');)

            return view('result_page');
    }

    public function crawl($url)
    {
        // Das hier soll umgebaut werden, in was anderes und vor allem es rekursiv zu bauen
        // anchor href: "//a/@href"
        // anchor src:  "//img/@src"
        $crawledData = array();
        $xpath = new CurlQuery($url);
        $urlQuery = $xpath->query("//a/@href"); // evtl. filern?
        for($i = 0; $i < $urlQuery->length; $i++)
            {
                $nodeValue = $urlQuery->item($i)->nodeValue;
                $parsedNodeValue = parse_url($nodeValue);
                //TODO URL-Parser einbauen -> new urlparser($v)?
                if(!empty($parsedNodeValue['scheme']))
                {
                    // Absolute URL is not for interest
                } else {
                    // TODO relative URL $nodeValue ergänzen, um den Anfang von $url
                    $crawledData[]['url'] = $nodeValue;
                    $this->session->set('url', $crawledData);

                    // TODO herausfinden wie man ein Array in eine Session speichert und abruft...
                }
            }
    }

//    public function _downloadData()
//    {
//
//        if($this->request->getPost('download')) {
//        $urlArr = $this->session->get('url');
//
//        //$urlArr = array("d","dd");
//        $this->response->setXML();
//           if (!write_file(WRITEPATH . 'data-3.txt', (string)$urlArr)){
//
//               echo 'Unable to write the file';
//           }else{
//
//               echo 'Successfully file written';
//           }
//
//           //return $response->download($xmlFileName, $urlArr);
//        }

       // Datei anlegen
        // Datei öffnen
        // foreach
        // Datei schließen

        // wenn Datei geschrieben dann ursprüngliche Seite wieder anzeigen.
   // }

    // Validation of the URL und check -> extra class?
    // Check Options
    // Start crawling and load html
    // Second iframe

    //Download Funktion
}