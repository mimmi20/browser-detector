<?php
namespace Browscap\Browser;

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
 * @package    WURFL
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    SVN: $Id$
 */

/**
 * chain base class
 */
use \Browscap\Chain\AbstractChain;

/**
 * Manages the creation and instatiation of all User Agent Handlers and Normalizers and provides a factory for creating User Agent Handler Chains
 * @package    WURFL
 * @see WURFL_UserAgentHandlerChain
 */
final class Chain extends AbstractChain
{
    /**
     * detect the user agent
     *
     * @param string $userAgent The user agent
     *
     * @return string
     */
    public function detect($userAgent)
    {
        $chain = $this->_createChain();
        
        return $this->_detect($chain, $userAgent);
    }
    
    /**
     * sets the default directory where the chain is searching 
     *
     * @return 
     */
    protected function _setDefaultDirectory()
    {
        $this->_directory = __DIR__ . DIRECTORY_SEPARATOR . 'Handlers' . DIRECTORY_SEPARATOR;
        
        return $this;
    }
    
    /**
     * sets the cache used to make the detection faster
     *
     * @return 
     */
    protected function _setDefaultNamspace()
    {
        $this->_namespace = __NAMESPACE__ . '\\Handlers';
        
        return $this;
    }
}
