<?php
declare(ENCODING = 'utf-8');
namespace Browscap\Engine\Handlers;

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

use Browscap\Engine\Handler as EngineHandler;

/**
 * MSIEAgentHanlder
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version   SVN: $Id$
 */
class Gecko extends EngineHandler
{
    /**
     * @var string the detected engine
     */
    protected $_engine = 'Gecko';
    
    /**
     * Returns true if this handler can handle the given user agent
     *
     * @return bool
     */
    public function canHandle()
    {
        if (!$this->_utils->checkIfContainsAnyOf($this->_useragent, array('Gecko', 'Firefox'))) {
            return false;
        }
        
        if ($this->_utils->checkIfContainsAnyOf($this->_useragent, array('KHTML', 'AppleWebKit', 'WebKit', 'Presto'))) {
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
        $doMatch = preg_match('/rv\:([\d\.ab]+).*Gecko\/([\d\.]+)/', $this->_useragent, $matches);
        //var_dump($matches);
        if ($doMatch) {
            $this->_version = $matches[1] . ' (' . $matches[2] . ')';
            return;
        }
        
        $doMatch = preg_match('/Gecko\/([\d\.]+)/', $this->_useragent, $matches);
        //var_dump($matches);
        if ($doMatch) {
            $this->_version = '(' . $matches[1] . ')';
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
        return 5244;
    }
    
    /**
     * returns TRUE if the browser suppoorts css gradients
     *
     * @return boolean
     */
    public function supportsCssGradients()
    {
        if ($this->getVersion() <= 3) {
            return false;
        }
        
        return true;
    }
    
    /**
     * returns TRUE if the browser suppoorts css rounded corners
     *
     * @return boolean
     */
    public function supportsCssRoundedCorners()
    {
        if ($this->getVersion() <= 3) {
            return false;
        }
        
        return true;
    }
    
    /**
     * returns TRUE if the browser suppoorts css rounded corners
     *
     * @return boolean
     */
    public function supportsCssBorderImages()
    {
        if ($this->getVersion() <= 1) {
            return false;
        }
        
        return true;
    }
    
    /**
     * returns TRUE if the browser suppoorts css rounded corners
     *
     * @return boolean
     */
    public function supportsCssSpriting()
    {
        if ($this->getVersion() <= 1) {
            return false;
        }
        
        return true;
    }
    
    /**
     * returns TRUE if the browser suppoorts css rounded corners
     *
     * @return boolean
     */
    public function supportsCssWidthAsPercentage()
    {
        if ($this->getVersion() <= 1) {
            return false;
        }
        
        return true;
    }
    
    /**
     * returns TRUE if the browser suppoorts css rounded corners
     *
     * @return boolean
     */
    public function supportsImageInlining()
    {
        if ($this->getVersion() <= 1) {
            return false;
        }
        
        return true;
    }
}