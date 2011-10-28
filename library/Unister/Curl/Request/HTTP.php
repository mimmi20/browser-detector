<?php
    /**
     * Curl-Request-Klasse fuer einfache HTTP-Requests
     *
     * @author Rico Sonntag <rico.sonntag@unister-gmbh.de>
     * @version 1.1
     * @since 13.09.2006
     */
    class Unister_Curl_Request_HTTP extends Unister_Curl_Request_Abstract
    {
        /**
         * Konstruktor
         */
        public function __construct($URL)
        {
            parent::__construct($URL);
        }

        /**
         * Gibt die Antwort des Requests zurueck
         *
         * @return Mixed Antwort des Requests
         */
        public function GetResponse()
        {
            return $this->Result;
        }
    }
?>