<?php
    /**
     * Die Klasse verwendet die CURL-Bibliothek und fuehrt einen Request aus
     *
     * @author Thomas Mueller <thomas.mueller@unister-gmbh.de>
     * @version 1.0
     * @since 10.10.2007
     */
    class Unister_Curl_Requester_Single
    {
        /**
         * @var Ressource Handle auf ein cURL-Objekt
         */
        private $Handle;

        /**
         * @var Unister_Curl_Request_Abstract Request-Objekt
         */
        protected $Request;

        /**
         * @var Mixed Ergebnis
         */
        protected $Result;

        /**
         * Konstruktor
         *
         * @param Unister_Curl_Request_Abstract $Request Request-Objekt
         */
        public function __construct(Unister_Curl_Request_Abstract $Request)
        {
            $this->Request        = $Request;
            $this->Handle         = curl_init($Request->GetURL());
        }

        /**
         * Destruktor
         */
        public function __destruct()
        {
            curl_close($this->Handle);
        }

        /**
         * Funktion liefert das Ergebnis der Anfrage
         *
         * @return Mixed Ergebnis der Anfrage
         */
        public function GetResult()
        {
            return $this->Result;
        }

        /**
         * Diese Funktion verarbeitet die Anfrage und schreibt das Ergebnis in das Request-Objekt.
         */
        public function ProcessRequest()
        {
            // Setzt die Curl-Optionen des Requests
            $options = $this->Request->GetCurlOptions();
            if (is_array($options) && count($options) > 0){
                foreach ($options as $optionname => $optionvalue)
                {
                    curl_setopt($this->Handle,constant($optionname),$optionvalue);
                }
            }
            
            // Fuehrt die CURL-Anfrage aus
            $curl_result = curl_exec($this->Handle);

            // Pruefen auf Fehler
            if (curl_errno($this->Handle) == 0 && $curl_result !== false)
            {
                // Ergebnis in das Request-Objekt schreiben
                $this->Request->SetResult($curl_result);
                // Anfrage-Statistik in das Request-Objekt schreiben
                $this->Request->SetStats(curl_getinfo($this->Handle));
                return true;
            }
            else
            {
                // Fehler bei der Anfrage
                throw new Unister_Curl_Requester_Single_Exception("Fehler in der CURL Anfrage! - ".curl_error($this->Handle));
                return false;
            }
        }



    }
?>