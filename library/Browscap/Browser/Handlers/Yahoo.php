<?php
declare(ENCODING = 'utf-8');
namespace Browscap\Browser\Handlers;

/**
 * Copyright(c) 2011 ScientiaMobile, Inc.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or(at your option) any later version.
 *
 * Refer to the COPYING file distributed with this package.
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version   SVN: $Id$
 */

use Browscap\Browser\Handler as BrowserHandler;

/**
 * CatchAllUserAgentHanlder
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version   SVN: $Id$
 */

class Yahoo extends BrowserHandler
{
    /**
     * @var string the detected browser
     */
    protected $_browser = 'Yahoo!';
    
    /**
     * Returns true if this handler can handle the given user agent
     *
     * @return bool
     */
    public function canHandle()
    {
        if ($this->_utils->checkIfStartsWith($this->_useragent, 'Mozilla/5.0 (YahooYSMcm')
            || $this->_utils->checkIfStartsWith($this->_useragent, 'Scooter')
            || $this->_utils->checkIfStartsWith($this->_useragent, 'Y!OASIS')
            || $this->_utils->checkIfStartsWith($this->_useragent, 'YahooYSMcm')
            || $this->_utils->checkIfStartsWith($this->_useragent, 'YRL_ODP_CRAWLER')
        ) {
            return true;
        }
        
        return false;
    }
}