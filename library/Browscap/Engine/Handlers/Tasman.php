<?php
namespace Browscap\Engine\Handlers;

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
 * @version    SVN: $Id: Trident.php 220 2012-05-20 11:12:21Z  $
 */

use Browscap\Engine\Handler as EngineHandler;

/**
 * MSIEAgentHandler
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    SVN: $Id: Trident.php 220 2012-05-20 11:12:21Z  $
 */
class Tasman extends EngineHandler
{
    /**
     * @var string the detected engine
     */
    protected $_engine = 'Tasman';
    
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
        
        if (!$this->_utils->checkIfStartsWith($this->_useragent, 'Mozilla/') 
            && !$this->_utils->checkIfContainsAll($this->_useragent, array('MSIE', 'Mac_PowerPC'))
        ) {
            return false;
        }
        
        $noTridentEngines = array(
            'KHTML', 'AppleWebKit', 'WebKit', 'Gecko', 'Presto', 'RGAnalytics',
            'libwww', 'iPhone', 'Firefox', 'Mozilla/5.0 (en)', 'Trident'
        );
        
        if ($this->_utils->checkIfContainsAnyOf($this->_useragent, $noTridentEngines)) {
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
        return 8;
    }
    
    /**
     * returns TRUE if the device supports RSS Feeds
     *
     * @return boolean
     */
    public function isRssSupported()
    {
        return false;
    }
    
    /**
     * returns TRUE if the device supports PDF documents
     *
     * @return boolean
     */
    public function isPdfSupported()
    {
        return false;
    }
}