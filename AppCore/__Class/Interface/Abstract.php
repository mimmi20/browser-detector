<?php

/**
 * @category    Kreditrechner
 * @package     Interface
 * @subpackage  Abstract
 * @copyright   Copyright (c) 2010 Unister GmbH
 * @author      Unister GmbH <teamleitung-dev@unister-gmbh.de>
 * @author      Sven Boehme <sven.boehme@unister-gmbh.de>
 * @version     $Id$
 */

/**
 * abstrakte (Basis-)Klasse für die Schnittstellen der Kreditinstitute 
 *
 * @category    class KreditCore_Class_Interface_PortalService
 * @package     Interface
 * @subpackage  Abstract
 * @copyright   Copyright (c) 2010 Unister GmbH
 */
abstract class KreditCore_Class_Interface_Abstract
{
    /**
     * Eingabedaten des Nutzers
     * 
     * @var ArrayObject
     */
    protected $_data;
    
    /**
     * Konstruktor
     * 
     * @param $data ArrayObject Eingabedaten des Nutzers
     */
    public function __construct($data)
    {
        $this->_data    = $data;
    }
    
    /**
     * versendet die Daten an das Kreditinstitut
     * 
     * @return Boolean
     */
    abstract public function send();
    
    /**
     * gibt das Ergebnis des Datenversandtes zurück
     */
    abstract public function getResult();
}