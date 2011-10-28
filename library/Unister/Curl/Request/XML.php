<?php
    /**
     * Abstrakte Curl-Request-Klasse fuer XML-basierende Requests
     *
     * @author Rico Sonntag <rico.sonntag@unister-gmbh.de>
     * @version 1.1
     * @since 13.09.2006
     */
    abstract class Unister_Curl_Request_XML extends Unister_Curl_Request_Abstract
    {
        /**
         * Konstruktor
         *
         * @param String $URL URL des XML-Requests
         */
        public function __construct($URL)
        {
            parent::__construct($URL);
        }

        /**
         * Abstrakte Funktion GetXML - Gibt das XML zurueck
         */
        abstract protected function GetXML($BaseXML);

        /**
         * Diese rekursive Funktion konvertiert die XML-Document-Daten
         * in einen Array, beginnend ab $ParentNode.
         *
         * @param DOMNode $ParentNode Elternknoten des XML - ab diesen beginnt die Funktion
         *
         * @return Array Gibt die XML-Daten als Array zurueck
         */
        protected function DOM2Array(DOMNode $ParentNode)
        {
            $Result = array();
            while ($ParentNode)
            {
                if ($ParentNode->hasChildNodes())
                {
                    $ChildNode = $ParentNode->firstChild;
                    $NodeName  = $ParentNode->nodeName;

                    if ($ChildNode->nodeType == XML_ELEMENT_NODE)
                    {
                        if (isset($Result[$NodeName]))
                        {
                            if (!is_array($Result[$NodeName][0]))
                                $Result[$NodeName] = array($Result[$NodeName]);
                            $Result[$NodeName] []= $this->DOM2Array($ChildNode);
                        }
                        else
                            $Result[$NodeName] = $this->DOM2Array($ChildNode);
                    }
                    else
                    {
                        if ($ChildNode->nodeType == XML_TEXT_NODE)
                            $Result[$NodeName] = trim(stripslashes(utf8_decode($ParentNode->nodeValue)));
                        else
                            $Result[$NodeName] = trim(stripslashes(utf8_decode($ChildNode->nodeValue)));
                    }
                }
                $ParentNode = $ParentNode->nextSibling;
            }
            return $Result;
        }

        /**
         * Diese Funktion liefert einen XML-String als Array zurueck. Sie benutzt dazu die rekursive
         * Funktion DOM2Array.
         *
         * @param String $XMLStr XML-String
         *
         * @return Array Daten aus dem XML
         *
         * @see DOM2Array
         */
        public function ToArray($XMLStr)
        {
            if (!strlen($XMLStr)){
                //throw new Request_XML_Exception("XML-String darf nicht leer sein!");
                return null;
            }else{
                // neues XML-Dokument erzeugen
                $XMLDocument = new DOMDocument("1.0", "iso-8859-1");
                // Whitespaces am Anfang von Tags entfernen
                $XMLDocument->preserveWhiteSpace = false;
                // Dokument laden
                $XMLDocument->loadXML($XMLStr);
                return $this->DOM2Array($XMLDocument->documentElement);
            }
        }
    }
?>