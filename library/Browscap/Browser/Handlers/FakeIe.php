<?php
declare(ENCODING = 'utf-8');
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
 * CatchAllUserAgentHandler
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    SVN: $Id$
 */

class FakeIe extends FakeBrowser
{
    /**
     * @var string the detected browser
     */
    protected $_browser = 'Fake IE';
    
    /**
     * Returns true if this handler can handle the given user agent
     *
     * @return bool
     */
    public function canHandle()
    {
        if (!$this->_utils->checkIfContainsAnyOf($this->_useragent, array('MSIE', 'Trident'))) {
            return false;
        }
        
        if ($this->_utils->checkIfStartsWith($this->_useragent, 'Mozilla/5.0')
            && $this->_utils->checkIfContainsAnyOf($this->_useragent, array('MSIE 8.0', 'MSIE 7.0', 'MSIE 6.0', 'MSIE 5.', 'MSIE 4.', 'MSIE 3.', 'MSIE 2.', 'MSIE 1.'))
        ) {
            return true;
        }
        
        if ($this->_utils->checkIfContainsAnyOf($this->_useragent, array('compatible ::  MSIE'))
        ) {
            return true;
        }
        
        return false;
    }
}