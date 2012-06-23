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
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    SVN: $Id$
 */

use Browscap\Browser\Handler as BrowserHandler;

/**
 * NokiaUserAgentHandler
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    SVN: $Id$
 */
class Nokia extends BrowserHandler
{
    /**
     * @var string the detected browser
     */
    protected $_browser = 'Nokia';

    /**
     * @var string the detected manufacturer
     */
    protected $_manufacturer = 'Nokia';
    
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
        
        if (!$this->_utils->checkIfContains($this->_useragent, 'Nokia')) {
            return false;
        }
        
        if ($this->_utils->checkIfContainsAnyOf($this->_useragent, array('OviBrowser', 'NokiaBrowser', 'UCWEB', 'BrowserNG', 'S40OviBrowser'))) {
            return false;
        }
        
        return true;
    }
    
    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 27;
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
        $engines = array(
            'Webkit'
        );
        
        $engineChain = new \Browscap\Engine\Chain(false, $engines);
        $engineChain->setLogger($this->_logger);
        
        if ($this->_cache instanceof \Zend\Cache\Frontend\Core) {
            $engineChain->setCache($this->_cache);
        }
        
        return $engineChain->detect($this->_useragent);
    }
}
