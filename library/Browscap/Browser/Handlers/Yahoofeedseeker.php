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

class Yahoofeedseeker extends Yahoo
{
    /**
     * @var string the detected browser
     */
    protected $_browser = 'unknown';
    
    /**
     * Returns true if this handler can handle the given user agent
     *
     * @return bool
     */
    public function canHandle()
    {
        if ($this->_utils->checkIfStartsWith($this->_useragent, 'Y!J SearchMonkey')
            || $this->_utils->checkIfStartsWith($this->_useragent, 'Y!J-BRE')
            || $this->_utils->checkIfStartsWith($this->_useragent, 'Y!J-BRG/GSC')
            || $this->_utils->checkIfStartsWith($this->_useragent, 'Y!J-BRI')
            || $this->_utils->checkIfStartsWith($this->_useragent, 'Y!J-BRO/YFSJ')
            || $this->_utils->checkIfStartsWith($this->_useragent, 'Y!J-BRP/YFSBJ')
            || $this->_utils->checkIfStartsWith($this->_useragent, 'Y!J-BRQ/DLCK')
            || $this->_utils->checkIfStartsWith($this->_useragent, 'Y!J-BSC')
            || $this->_utils->checkIfStartsWith($this->_useragent, 'Y!J-NSC')
            || $this->_utils->checkIfStartsWith($this->_useragent, 'Y!J-PSC')
            || $this->_utils->checkIfStartsWith($this->_useragent, 'Y!J-SRD')
            || $this->_utils->checkIfStartsWith($this->_useragent, 'Y!J-VSC/ViSe')
            || $this->_utils->checkIfStartsWith($this->_useragent, 'YahooFeedSeeker')
        ) {
            return true;
        }
        
        return false;
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
}