<?php
    /**
     * Die Klasse verwendet die CURL-Bibliothek und ist in der Lage mehrfache Anfragen
     * parallel zu verarbeiten um somit die Ausfuehrungszeit zu reduzieren.
     *
     * @author Rico Sonntag <rico.sonntag@unister-gmbh.de>
     * @version 1.1
     * @since 13.09.2006
     */
    class Unister_Curl_Requester_Multi
    {
        /**
         * @var Ressource Handle auf ein cURL-Multi-Objekt
         */
        private   $MultiHandle;

        /**
         * @var Array Liste der aktiven Verbindungen
         */
        protected $Connections = array();

        /**
         * @var Array Liste der Anfrage-Objekte
         */
        protected $Requests    = array();

        /**
         * @var Array Ergebnisliste
         */
        protected $Results     = array();

        /**
         * @var Integer Anzahl der aktiven Anfragen
         */
        protected $Active;

        /**
         * Konstruktor
         *
         * @param Array $Requests Liste der Ziel-URLs und ihren entsprechenden HTTP-Headern
         *
         * Aufbau der Array URLs = array(array("https://www.example.com", $HTTPHeader),);
         */
        public function __construct(array $Requests)
        {
            if (!is_array($Requests) || !count($Requests))
                throw new Unister_Curl_Requester_Multi_Exception("Keine Request-Objekte vorhanden!");

            $this->Requests    = $Requests;
            $this->MultiHandle = curl_multi_init();
            $this->Active      = -1;

            // Ergebnisliste initialisieren (fuer jede Anfrage zumindest ein leeres Ergebnis zurueckgeben)
            $this->Results = array_fill(0, count($Requests), "");
        }

        /**
         * Destruktor
         */
        public function __destruct()
        {
            curl_multi_close($this->MultiHandle);
        }

        /**
         * Funktion liefert die Ergebnisliste der Anfragen
         *
         * @return Array Ergebnisliste der Anfragen
         */
        public function GetResults()
        {
            return $this->Results;
        }

        /**
         * Die Funktion fuehrt die Anfragen aus.
         *
         * @return CURLM_OK wenn alles korrekt verarbeitet wurde
         */
        protected function ExecuteRequests()
        {
            // Anfragen ausfuehren
            while (($ExecResult = curl_multi_exec($this->MultiHandle, $this->Active)) == CURLM_CALL_MULTI_PERFORM);
            return $ExecResult;
        }

        /**
         * Die Funktion wartet bis eine der ausstehenden Anfragen beendet wurde.
         *
         * @return Boolean Gibt true zurueck wenn die Anfrage fehlerfrei ausgefuehrt wurde
         */
        private function WaitFor()
        {
            // Wenn Timeout nicht definiert ist, wird Standard-Timeout (120 sek.) gesetzt
            if (!defined(REQUESTS_TIMEOUT)) define('REQUESTS_TIMEOUT',120);
            //Zend_Debug::dump(REQUESTS_TIMEOUT);
            $OldActive  = $this->Active;
            $ExecResult = CURLM_OK;
            while ($this->Active && ($ExecResult == CURLM_OK))
            {
                // auf Antworten warten
                switch (curl_multi_select($this->MultiHandle, REQUESTS_TIMEOUT))
                {
                    case -1 : throw new Unister_Curl_Requester_Multi_Exception("Unbekannter Fehler aufgetreten!");
                    case  0 : throw new Unister_Curl_Requester_Multi_Exception("Zeitueberschreitung [Timeout-Wert: ".REQUESTS_TIMEOUT." Sek.]");
                    // es sind noch Anfragen offen -> diese ausfuehren
                    default : $ExecResult = $this->ExecuteRequests();
                }
                // irgendeine Anfrage ist fertig
                if ($OldActive && ($ExecResult == CURLM_OK) && ($this->Active != $OldActive))
                    return true;
            }
            return false;
        }

        /**
         * Die Funktion schreibt die Ergebnisse der Anfragen in die interne Ergebnisliste.
         * Tritt fuer eine Anfrage ein Fehler auf, wird eine Unister_Curl_Requester_Multi_Exception geworfen.
         *
         * @param Boolean $All wenn "true" (default) dann werden alle Ergebnisse auf einmal abgefragt und in die Ergebnisliste geschrieben.
         *
         * @return Mixed Ergebnisse oder false bei Fehler
         */
        public function RetrieveResult()
        {
            // Ergebnisdaten ermitteln
            foreach ($this->Connections as $Key => $Handle)
            {
                if (curl_errno($Handle))
                    throw new Unister_Curl_Requester_Multi_Exception("Fehler: " . curl_error($Handle));

                // Ergebnis der Anfrage speichern
                $Result = curl_multi_getcontent($Handle);
                // Statistik-Daten der Anfrage speichern
                $Stats = curl_getinfo($Handle);

                // fuer die fertige Anfrage das Ergebnis ermitteln
                if (!strlen($this->Results[$Key]) && strlen($Result))
                {
                    $this->Results[$Key] = $Result;
                    // Element entfernen, da fertig
                    unset($this->Connections[$Key]);
                    // Handle der Anfrage schliessen
                    curl_multi_remove_handle($this->MultiHandle, $Handle);
                    curl_close($Handle);
                    return array($Key, $Result,$Stats);
                }
            }
            return false;
        }

        /**
         * Die Funktion verarbeitet die Anfragen. Fuer jede Anfrage wird die im Konstruktor
         * uebergebene Ziel-URL und der entsprechende HTTP-Header gesetzt.
         *
         * @return Boolean Gibt wenn alle Anfragen fehlerfrei ausgefuehrt wurden true zurueck
         */
        public function HandleRequests()
        {
            // alle eingetragenen Anfragen abarbeiten
            foreach ($this->Requests as $Key => $Request)
            {
                if ($Request instanceof Unister_Curl_Request_Abstract)
                {
                    $URL                     = $Request->GetURL();
                    $Handle                  = curl_init($URL);
                    $this->Connections[$Key] = $Handle;

                    // Setzt die Curl-Optionen des Requests
                    $options = $Request->GetCurlOptions();
                    if (is_array($options) && count($options) > 0){
                        foreach ($options as $optionname => $optionvalue)
                        {
                            curl_setopt($Handle,constant($optionname),$optionvalue);
                        }
                    }

                    // Handle hinzufuegen
                    curl_multi_add_handle($this->MultiHandle, $Handle);
                }
                else
                {
                    throw new Unister_Curl_Requester_Multi_Exception("Objekt $Key ist ungueltig!");
                }
            }

            // Anfragen ausfuehren
            return ($this->ExecuteRequests() == CURLM_OK);
        }

        /**
         * Diese Funktion verarbeitet alle Anfragen und schreibt die Ergebnisse in das jeweilige Request-Objekt.
         */
        public function ProcessRequests()
        {
            if ($this->HandleRequests())
            {
                while ($this->WaitFor())
                {
                    $Result = $this->RetrieveResult();
                    // Ergebnis setzen
                    if (isset($this->Requests[$Result[0]]))
                    {
                        $this->Requests[$Result[0]]->SetResult($Result[1]);
                        $this->Requests[$Result[0]]->SetStats($Result[2]);
                    }
                }
            }
        }
    }
?>