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

use Browscap\Browser\Handler as BrowserHandler;

/**
 * ChromeUserAgentHandler
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    SVN: $Id$
 */
class Arora extends BrowserHandler
{
    /**
     * @var string the detected browser
     */
    protected $_browser = 'Arora';
    
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
        
        if (!$this->_utils->checkIfStartsWith($this->_useragent, 'Mozilla/')
            && !$this->_utils->checkIfStartsWith($this->_useragent, 'Arora/')
        ) {
            return false;
        }
        
        if (!$this->_utils->checkIfContainsAll($this->_useragent, array('AppleWebKit', 'Arora'))) {
            return false;
        }
        
        $isNotReallyAnSafari = array(
            // using also the KHTML rendering engine
            'Chromium',
            'Flock',
            'Galeon',
            'Lunascape',
            'Iron',
            'Maemo',
            'PaleMoon',
            'Rockmelt',
            'Comodo Dragon',
            'Google Earth',
            'Chrome'
        );
        
        if ($this->_utils->checkIfContainsAnyOf($this->_useragent, $isNotReallyAnSafari)) {
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
        $doMatch = preg_match('/Arora\/(\d+\.\d+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = $matches[1];
            return;
        }
        
        $this->_version = '';
    }
    
    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 6;
    }
    
    /**
     * returns TRUE if the browser has a specific rendering engine
     *
     * @return boolean
     */
    public function hasEngine()
    {
        return true;
    }
    
    /**
     * returns null, if the browser does not have a specific rendering engine
     * returns the Engine Handler otherwise
     *
     * @return null|\Browscap\Os\Handler
     */
    public function getEngine()
    {
        $handler = new \Browscap\Engine\Handlers\Webkit();
        $handler->setLogger($this->_log);
        $handler->setUseragent($this->_useragent);
        
        return $handler->detect();
    }
}