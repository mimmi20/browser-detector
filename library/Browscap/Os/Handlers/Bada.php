<?php
namespace Browscap\Os\Handlers;

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

use Browscap\Os\Handler as OsHandler;

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
class Bada extends OsHandler
{
    /**
     * @var string the detected platform
     */
    protected $_name = 'Bada OS';
    
    /**
     * @var string the manufacturer/creator of this OS
     */
    protected $_manufacturer = 'Samsung';
    
    /**
     * Returns true if this handler can handle the given $useragent
     *
     * @return bool
     */
    public function canHandle()
    {
        if ('' == $this->_useragent) {
            return false;
        }
        
        if (!$this->_utils->checkIfContains('Bada')) {
            return false;
        }
        
        return true;
    }
    
    /**
     * detects the browser version from the given user agent
     *
     * @param string $this->_useragent
     *
     * @return string
     */
    protected function _detectVersion()
    {
        $doMatch = preg_match('/Bada\/([\d\.]+)/', $this->_useragent, $matches);
        
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
        return 4;
    }
    
    /**
     * returns null, if the device does not have a specific Browser
     * returns the Browser Handler otherwise
     *
     * @return null|\Browscap\Os\Handler
     */
    public function getBrowser()
    {
        $browsers = array(
            'Dolfin'
        );
        
        $browserPath = realpath(
            __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' 
            . DIRECTORY_SEPARATOR . 'Browser' 
            . DIRECTORY_SEPARATOR . 'Handlers' . DIRECTORY_SEPARATOR . 'Mobile' 
            . DIRECTORY_SEPARATOR
        );
        $browserNs   = 'Browscap\\Browser\\Handlers\\Mobile';
        
        $chain = new \Browscap\Browser\Chain(false, $browsers, $browserPath, $browserNs);
        $chain->setLogger($this->_logger);
        $chain->setDefaultHandler(new \Browscap\Browser\Handlers\Unknown());
        $chain->setUseragent($this->_useragent);
        
        return $chain->detect();
    }
}