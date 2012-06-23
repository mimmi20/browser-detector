<?php
namespace Browscap\Device\Handlers;

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
 * CatchAllUserAgentHandler
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    SVN: $Id$
 */
class Macintosh extends GeneralDesktop
{
    /**
     * @var string the detected device
     */
    protected $_device = 'Macintosh';

    /**
     * @var string the detected manufacturer
     */
    protected $_manufacturer = 'Apple';
    
    /**
     * Final Interceptor: Intercept
     * Everything that has not been trapped by a previous handler
     *
     * @param string $this->_useragent
     * @return boolean always true
     */
    public function canHandle()
    {
        if ('' == $this->_useragent) {
            return false;
        }
        
        if ($this->_utils->isMobileBrowser($this->_useragent)) {
            return false;
        }
        
        if ($this->_utils->isSpamOrCrawler($this->_useragent)) {
            return false;
        }
        
        if ($this->_utils->isFakeBrowser($this->_useragent)) {
            return false;
        }
        
        $mac = array(
            'Macintosh', 'Darwin', 'Mac_PowerPC', 'MacBook', 'for Mac', 'PPC Mac'
        );
        
        if (!$this->_utils->checkIfContainsAnyOf($this->_useragent, $mac)) {
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
        return 2;
    }
    
    /**
     * returns TRUE if the device has a specific Operating System
     *
     * @return boolean
     */
    public function hasOs()
    {
        return true;
    }
    
    /**
     * returns null, if the device does not have a specific Operating System
     * returns the OS Handler otherwise
     *
     * @return null|\Browscap\Os\Handler
     */
    public function getOs()
    {
        $os = array(
            'Macintosh',
            'Macosx',
            'Darwin'
        );
        
        $osChain = new \Browscap\Os\Chain(false, $os);
        $osChain->setLogger($this->_logger);
        
        if ($this->_cache instanceof \Zend\Cache\Frontend\Core) {
            $osChain->setCache($this->_cache);
        }
        
        return $osChain->detect($this->_useragent);
    }
}