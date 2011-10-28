<?php
    /**
     * Abstrakte Klasse der Curl-Requests
     *
     * @author Rico Sonntag <rico.sonntag@unister-gmbh.de>
     * @version 1.1
     * @since 13.09.2006
     */
    abstract class Unister_Curl_Request_Abstract
    {
        /**
         * @var String URL des Requests
         */
        protected $URL;

        /**
         * @var Mixed Ergebnis des Requests
         */
        protected $Result;

        /**
         * @var Array Statistik-Daten des Requests
         */
        protected $Stats;

        /**
         * Konstruktor
         */
        public function __construct($URL)
        {
            $this->URL        = $URL;
            $this->Result     = null;
            $this->Stats     = null;
        }

        /**
         * Setzt die URL
         *
         * @param String $URL URL des Requests
         */
        public function SetURL($URL)
        {
            $this->URL = $URL;
        }

        /**
         * Gibt die URL zurueck
         *
         * @return String URL des Requests
         */
        public function GetURL()
        {
            return $this->URL;
        }

        /**
         * Setzt das Request-Ergebnis
         *
         * @param Mixed $Result Ergebnis des Requests
         */
        public function SetResult($Result)
        {
            $this->Result = $Result;
        }

        /**
         * Setzt die Request-Statistiken
         *
         * @param Array $Stats Statistik-Daten des Requests
         */
        public function SetStats($Stats)
        {
            $this->Stats = $Stats;
        }

        /**
         * Gibt die Statistik-Daten zurueck
         *
         * @return Array Statistik-Daten
         */
        public function GetStats()
        {
            return $this->Stats;
        }

        /**
         * Gibt das Request-Ergebnis zurueck
         *
         * @return Mixed Ergebnis des Requests
         */
        public function GetResult()
        {
            return $this->Result;
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
            );
        }

    }
?>