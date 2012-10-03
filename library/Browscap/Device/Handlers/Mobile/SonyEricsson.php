<?php
namespace Browscap\Device\Handlers\Mobile;

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

use Browscap\Device\Handlers\GeneralMobile;

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
class SonyEricsson extends GeneralMobile
{
    /**
     * @var string the detected device
     */
    protected $_device = 'general SonyEricsson';

    /**
     * @var string the detected manufacturer
     */
    protected $_manufacturer = 'SonyEricsson';
    
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
        
        $sonyPhones = array(
            'sonyericsson',
            'sony',
            'e15i',
            'e15av',
            'lt15i',
            'lt18i',
            'lt22i',
            'lt26i',
            'mk16i',
            'mt11i',
            'mt15i',
            's312',
            'sk17i',
            'st18i',
            'st25i',
            'u20i',
            'w508a',
            'w760i',
            'wt13i',
            'x1i',
            'x10i',
            'xst2',
            'playstation',
            'psp'
        );
        
        if ($this->_utils->checkIfContains($sonyPhones, true)) {
            return true;
        }
        
        return false;
    }
    
    /**
     * detects the device name from the given user agent
     *
     * @param string $userAgent
     *
     * @return StdClass
     */
    public function detectDevice()
    {
        $chain = new \Browscap\Device\Chain(
            true, 
            null, 
            __DIR__ . DIRECTORY_SEPARATOR . 'SonyEricsson' . DIRECTORY_SEPARATOR, 
            __NAMESPACE__ . '\\SonyEricsson'
        );
        $chain->setDefaultHandler($this);
        $chain->setUserAgent($this->_useragent);
        
        return $chain->detect();
    }
    
    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return parent::getWeight() + 1;
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
    public function detectOs()
    {
        $os = array(
            'Android',
            'Bada',
            'Brew',
            'Java',
            'Symbianos',
            'WindowsMobileOs',
            'WindowsPhoneOs'
        );
        
        $osChain = new \Browscap\Os\Chain(false, $os);
        $osChain->setLogger($this->_logger);
        
        if ($this->_cache instanceof \Zend\Cache\Frontend\Core) {
            $osChain->setCache($this->_cache);
        }
        
        return $osChain->detect($this->_useragent);
    }
    
    /**
     * returns TRUE if the device has a specific Browser
     *
     * @return boolean
     */
    public function hasBrowser()
    {
        return true;
    }
    
    /**
     * returns null, if the device does not have a specific Browser
     * returns the Browser Handler otherwise
     *
     * @return null|\Browscap\Os\Handler
     */
    public function detectBrowser()
    {
        $browserPath = realpath(
            __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' 
            . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Browser' 
            . DIRECTORY_SEPARATOR . 'Handlers' . DIRECTORY_SEPARATOR . 'Mobile' 
            . DIRECTORY_SEPARATOR
        );
        $browserNs   = 'Browscap\\Browser\\Handlers\\Mobile';
        
        $chain = new \Browscap\Browser\Chain(true, null, $browserPath, $browserNs);
        $chain->setDefaultHandler(new \Browscap\Browser\Handlers\Unknown());
        $chain->setUserAgent($this->_useragent);
        
        return $chain->detect();
    }
}