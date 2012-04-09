<?php
declare(ENCODING = 'utf-8');
namespace Browscap\Os;

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
 * @package    WURFL
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    SVN: $Id$
 */

/**
 * WURFL_Handlers_Matcher is the base interface that concrete classes 
 * must implement to retrieve a device with the given request    
 *
 * @category   WURFL
 * @package    WURFL
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    SVN: $Id$
 */
interface MatcherInterface
{
    /**
     * sets the logger used when errors occur
     *
     * @param \Zend\Log\Logger $logger
     *
     * @return 
     */
    public function setLogger(\Zend\Log\Logger $logger = null);
    
    /**
     * sets the user agent to be handled
     *
     * @return void
     */
    public function setUserAgent($userAgent);
    
    /**
     * Returns true if this handler can handle the given useragent
     *
     * @return bool
     */
    public function canHandle();
    
    /**
     * detects the operating system name (platform) from the given user agent
     *
     * @return StdClass
     */
    public function detect();
    
    public function getName();
    
    public function getVersion();
    
    public function getBits();
    
    public function getFullName();
    
    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight();
}

