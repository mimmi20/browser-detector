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
 * @version    SVN: $Id$
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
 * @version    SVN: $Id$
 */
class Trident extends EngineHandler
{
    /**
     * @var string the detected engine
     */
    protected $_engine = 'Trident';
    
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
            && !$this->_utils->checkIfContainsAnyOf($this->_useragent, array('MSIE', 'Trident'))
        ) {
            return false;
        }
        
        $noTridentEngines = array(
            'KHTML', 'AppleWebKit', 'WebKit', 'Gecko', 'Presto', 'RGAnalytics',
            'libwww', 'iPhone', 'Firefox', 'Mozilla/5.0 (en)', 'Mac_PowerPC',
            'Opera'
        );
        
        if ($this->_utils->checkIfContainsAnyOf($this->_useragent, $noTridentEngines)) {
            return false;
        }
        
        return true;
    }
    
    /**
     * detects the browser version from the given user agent
     *
     * @return string
     */
    protected function _detectVersion()
    {
        $doMatch = preg_match('/Trident\/(\d+\.\d+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $this->_version = $matches[1];
            return;
        }
        
        $doMatch = preg_match('/MSIE (\d+\.\d+)/', $this->_useragent, $matches);
        
        if ($doMatch) {
            $version = '';
            
            switch ((float) $matches[1]) {
                case 10.0:
                    $version = '6.0';
                    break;
                case 9.0:
                    $version = '5.0';
                    break;
                case 8.0:
                case 7.0:
                case 6.0:
                    $version = '4.0';
                    break;
                case 5.5:
                case 5.01:
                case 5.0:
                case 4.01:
                case 4.0:
                case 3.0:
                case 2.0:
                case 1.0:
                default:
                    // do nothing here
            }
            
            $this->_version = $version;
            return;
        }
        
        $this->_version = '';
    }
    
    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 86837;
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