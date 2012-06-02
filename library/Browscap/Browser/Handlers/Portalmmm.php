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
 * PortalmmmUserAgentHandler
 * 
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    SVN: $Id$
 */
class Portalmmm extends BrowserHandler
{
    /**
     * @var string the detected browser
     */
    protected $_browser = 'Portalmmm';
    
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
        
        return $this->_utils->checkIfStartsWith($this->_useragent, 'portalmmm');
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
        $handler = new \Browscap\Engine\Handlers\Unknown();
        $handler->setLogger($this->_logger);
        $handler->setUseragent($this->_useragent);
        
        return $handler->detect();
    }
}
