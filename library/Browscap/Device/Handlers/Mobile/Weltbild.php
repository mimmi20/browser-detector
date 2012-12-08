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
class Weltbild extends GeneralMobile
{
    /**
     * @var string the detected device
     */
    protected $_device = 'general Weltbild Device';

    /**
     * @var string the detected manufacturer
     */
    protected $_manufacturer = 'Weltbild';
    
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
        
        if (!$this->_utils->checkIfContains(array('CatNova', 'CAT NOVA', 'CatNova8', 'Cat StarGate', 'Cat Tablet'))) {
            return false;
        }
        
        return true;
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
            __DIR__ . DIRECTORY_SEPARATOR . 'Weltbild' . DIRECTORY_SEPARATOR, 
            __NAMESPACE__ . '\\Weltbild'
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
        
        $chain = new \Browscap\Os\Chain(false, $os);
        $chain->setLogger($this->_logger);
        $chain->setDefaultHandler(new \Browscap\Os\Handlers\Unknown());
        $chain->setUseragent($this->_useragent);
        
        return $chain->detect();
    }
}