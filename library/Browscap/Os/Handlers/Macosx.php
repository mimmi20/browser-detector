<?php
declare(ENCODING = 'utf-8');
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
class Macosx extends Macintosh
{
    /**
     * @var string the detected platform
     */
    protected $_name = 'MacOSX';
    
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
        
        if (!$this->_utils->checkIfContainsAnyOf($this->_useragent, array('Macintosh', 'Mac OS X'))) {
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
        $doMatch = preg_match('/Mac OS X ([\d\.\_]+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = str_replace('_', '.', $matches[1]);
            return;
        }
        
        $doMatch = preg_match('/Mac OS X\/([\d\.\_]+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = str_replace('_', '.', $matches[1]);
            return;
        }
        
        $this->_version = '10';
    }
    
    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 295;
    }
}