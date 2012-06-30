<?php
namespace Browscap\Browser\Handlers;

/**
 * Copyright (c) 2012 ScientiaMobile, Inc.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or(at your option) any later version.
 *
 * Refer to the COPYING.txt file distributed with this package.
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    SVN: $Id$
 */

/**
 * Handler Base class
 */

/**
 * MSIEAgentHandler
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    SVN: $Id$
 */
class MicrosoftOutlook extends MicrosoftOffice
{
    /**
     * @var string the detected browser
     */
    protected $_browser = 'Outlook';

    /**
     * @var string the detected manufacturer
     */
    protected $_manufacturer = 'microsoft';
    
    /**
     * Returns true if this handler can handle the given user agent
     *
     * @return bool
     */
    public function canHandle()
    {
        if ('' == $this->_useragent) {
            return false;
        }
        
        if (!$this->_utils->checkIfContains(array('Outlook', 'Microsoft Office', 'MSOffice'))) {
            return false;
        }
        
        $isNotReallyAnIE = array(
            // using also the Trident rendering engine
            'Maxthon',
            'Galeon',
            'Lunascape',
            'Opera',
            'PaleMoon',
            'Flock',
            'AOL',
            'TOB',
            'MyIE',
            'Excel',
            'Word',
            'PowerPoint',
            //others
            'AppleWebKit',
            'Chrome',
            'Linux',
            'IEMobile',
            'BlackBerry',
            'WebTV',
            // Outlook Express
            'Outlook-Express'
        );
        
        if ($this->_utils->checkIfContains($isNotReallyAnIE)) {
            return false;
        }
        
        return true;
    }
    
    /**
     * detects the browser version from the given user agent
     *
     * @return string
     */
    protected function _detectVersion()
    {
        $doMatch = preg_match('/Microsoft Office Outlook (\d+\.\d+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = $this->_mapVersion($matches[1]);
            return;
        }
        
        $doMatch = preg_match('/Microsoft Office Outlook (\d+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = $this->_mapVersion($matches[1]);
            return;
        }
        
        $doMatch = preg_match('/Microsoft Outlook (\d+\.\d+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = $this->_mapVersion($matches[1]);
            return;
        }
        
        $doMatch = preg_match('/Microsoft Outlook (\d+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = $this->_mapVersion($matches[1]);
            return;
        }
        
        parent::_detectVersion();
    }
}