<?php
    /**
     * Abstrakte Curl-Request-Klasse fuer Soap-Requests
     *
     * @author Rico Sonntag <rico.sonntag@unister-gmbh.de>
     * @version 1.1
     * @since 13.09.2006
     */
    abstract class Unister_Curl_Request_SOAP extends Unister_Curl_Request_XML
    {
        /**
         * @var String SOAP-Action
         */
        protected $Action;

        /**
         * @var String SOAP-Action-URL
         */
        protected $ActionURL;

        /**
         * @var String XML-Request-Daten
         */
        protected $XMLRequest;

        /**
         * @var String Gibt den SOAP-Namespace an
         */
        protected $SOAPNamespace;

        /**
         * @var Strong Encoding der XML-Daten
         */
        protected $Encoding;

        /**
         * Konstruktor
         *
         * @param String $URL Request-URL
         * @param String $ActionURL SOAP-Action-URL
         * @param String $Action SOAP-Action
         */
        public function __construct($URL, $ActionURL, $Action)
        {
            parent::__construct($URL);
            $this->Action             = $Action;
            $this->ActionURL          = $ActionURL;
            $this->XMLRequest         = '';
            $this->SOAPNamespace     = 'soap';
            $this->Encoding         = 'utf-8';
        }

        /**
         * Gibt die Header als String zurueck
         *
         * @return String Header-String
         */
        public function GetHTTPHeader()
        {
            // URL parsen
            $URLParts = parse_url($this->URL);

            // SOAP-Header aufbauen
            $Headers  = 'POST ' . $URLParts['path'] . ' HTTP/1.1'.chr(13).chr(10);
            $Headers .= 'Host: ' . $URLParts['host'] . chr(13).chr(10);
            $Headers .= 'Connection: Keep-Alive'.chr(13).chr(10);
            $Headers .= 'Content-Type: text/xml; charset='.$this->Encoding.chr(13).chr(10);
            $Headers .= 'Content-Length: ' . strlen($this->XMLRequest) . chr(13).chr(10);
            $Headers .= 'SOAPAction: "' . $this->ActionURL . $this->Action . '"'.chr(13).chr(10);
            $Headers .= chr(13).chr(10);
            $Headers .= $this->XMLRequest;

            return $Headers;
        }

        /**
         * Gibt die CURL-Optionen des Requests zurueck
         *
         * @return Array CURL-Optionen
         */
        public function GetCurlOptions()
        {
            if (!defined(REQUEST_TIMEOUT)) define('REQUEST_TIMEOUT',30);
            return array(
                'CURLOPT_TIMEOUT'            => REQUEST_TIMEOUT,
                'CURLOPT_RETURNTRANSFER'    => 1,
                'CURLOPT_CUSTOMREQUEST'        => $this->GetHTTPHeader(),
            );
        }

        /**
         * Gibt das komplette SOAP-XML zurueck
         *
         * @param String $BaseXML SOAP-Body-XML-String
         *
         * @return String SOAP-XML-String
         */
        protected function GetXML($BaseXML)
        {
            $XML  = '<?xml version="1.0" encoding="'.$this->Encoding.'"?>'.chr(10);
            $XML .= '<'.$this->SOAPNamespace.':Envelope xmlns:'.$this->SOAPNamespace.'="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">'.chr(10);
            $XML .= '<'.$this->SOAPNamespace.':Body>'.chr(10);
            $XML .= $BaseXML;
            $XML .= '</'.$this->SOAPNamespace.':Body>'.chr(10);
            $XML .= '</'.$this->SOAPNamespace.':Envelope>'.chr(10);
            return $XML;
        }

        /**
         * Gibt die SOAP-Action zurueck
         *
         * @return String SOAP-Action
         */
        public function GetAction()
        {
            return $this->Action;
        }

        /**
         * Gibt die SOAP-Action-URL zurueck
         *
         * @return String SOAP-Action-URL
         */
        public function GetActionURL()
        {
            return $this->ActionURL;
        }

        /**
         * Gibt die XML-Request-Daten zurueck
         *
         * @return String XML-Request-String
         */
        public function GetXMLRequest()
        {
            return $this->XMLRequest;
        }

        /**
         * Setzt die XML-Request-Daten
         *
         * @param String $XML XML-Request-Daten
         */
        public function SetXMLRequest($XML)
        {
            $this->XMLRequest = $XML;
        }

        /**
         * Gibt die Antwort des Requests zurueck
         *
         * @param String $Type Form der Request-Daten
         *
         * @return Mixed Request-Antwort
         */
        public function GetResponse($Type = 'array')
        {
            switch ($Type){
                case 'object':{
                    // TODO Rückgabe als Objekt
                    break;
                }
                case 'string':{
                    return $this->Result;
                    break;
                }
                case 'array':
                default:{
                    return $this->ToArray($this->Result);
                    break;
                }
            }
        }
    }
?>
