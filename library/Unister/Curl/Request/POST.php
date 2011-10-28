<?php
    /**
     * Curl-Request-Klasse fuer POST-Requests
     *
     * @author Rico Sonntag <rico.sonntag@unister-gmbh.de>
     * @version 1.1
     * @since 13.09.2006
     */
    abstract class Unister_Curl_Request_POST extends Unister_Curl_Request_Abstract
    {
        /**
         * @var Array Feld mit den Daten
         */
        protected $PostData;

        /**
         * @var Boolean Werte als UTF-8 uebermitteln?
         */
        protected $utf8Enc;

        /**
         * Konstruktor
         *
         * @param String $URL URL des POST-Requests
         * @param Array $PostData Daten des POST-Requests
         */
        public function __construct($URL, array $PostData)
        {
            parent::__construct($URL);
            $this->PostData     = $PostData;
            $this->utf8Enc         = true;
        }

        /**
         * Die Funktion erzeugt eine Zeichenkette die das zu uebertragene
         * Post-Request enthaelt und gibt diese zurueck.
         *
         * @param bool Encoding-Typ (true (=default) für UTF8 Encoding, false für kein Encoding)
         *
         * @return String Post-Request-String
         */
        public function GetPostString()
        {
            $Str = "";
            foreach ($this->PostData as $Key => $Value)
                if($this->utf8Enc)
                {
                    $Str .= "$Key=" . utf8_encode($Value) . "&";
                }
                else
                {
                    $Str .= "$Key=$Value&";
                }
            return substr($Str, 0, -1);
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
                'CURLOPT_POST'                => 1,
                'CURLOPT_POSTFIELDS'        => $this->GetPostString(),
                'CURLINFO_HEADER_OUT'        => 1,
                'CURLOPT_USERAGENT'            => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; pl; rv:1.9) Gecko/2008052906 Firefox/3.0',
                //'CURLOPT_NOBODY'            => 0,
                'CURLOPT_HTTPHEADER'        => array(
                        "Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.3",
                        "Accept-Language: de-de,de;q=0.7,en-us;q=0.5,en;q=0.3",
                        "Accept-Charset: iso-8859-1,utf-8;q=0.7,*;q=0.7",
                        "Keep-Alive: 300"
                    ),
                'CURLOPT_CONNECTTIMEOUT'    => REQUEST_TIMEOUT,
                
            );
        }
    }
?>