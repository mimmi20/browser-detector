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
        $directory = __DIR__ . DS . 'Handlers' . DS;
        $namespace = __NAMESPACE__;
        
        if (!($this->_cache instanceof \Zend\Cache\Frontend\Core) 
            || !($chain = $this->_cache->load('BrowserChain'))
        ) {
            // no cache or the chain is not cached yet
            $chain = $this->_createChain($directory, $namespace);
            
            if ($this->_cache instanceof \Zend\Cache\Frontend\Core) {
                $this->_cache->save($chain, 'BrowserChain');
            }
        }
        
        return $this->_detect($chain, $userAgent, $namespace);
    }
}
