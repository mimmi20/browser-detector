<?php
namespace Browscap\Device\Handlers\Desktop;

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

use Browscap\Device\Handlers\GeneralDesktop;

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
class LinuxDesktop extends GeneralDesktop
{
    /**
     * @var string the detected device
     */
    protected $_device = 'Linux Desktop';
    
    /**
     * Final Interceptor: Intercept
     * Everything that has not been trapped by a previous handler
     *
     * @param string $this->_useragent
     * @return boolean always true
     */
    public function canHandle()
    {
        if ('' == $this->_useragent) {
            return false;
        }
        
        $linux = array(
            'Linux', 'Debian', 'Ubuntu', 'SUSE', 'Fedora', 'Mint', 'redhat', 
            'Slackware', 'Zenwalk GNU', 'CentOS', 'Kubuntu', 'CrOs'
        );
        
        if (!$this->_utils->checkIfContains($linux, true)) {
            return false;
        }
        
        if ($this->_utils->checkIfContains('Loewe; SL121')) {
            return false;
        }
        
        return true;
    }
    
    /**
     * detects the device name from the given user agent
     *
     * @param string $userAgent
     *
     * @return StdClass
     */
    public function detectDevice()
    {
        return $this;
    }
    
    /**
     * gets the weight of the handler, which is used for sorting
     *
     * @return integer
     */
    public function getWeight()
    {
        return 100;
    }
    
    /**
     * returns TRUE if the device has a specific Operating System
     *
     * @return boolean
     */
    public function hasOs()
    {
        return true;
    }
    
    /**
     * returns null, if the device does not have a specific Operating System
     * returns the OS Handler otherwise
     *
     * @return null|\Browscap\Os\Handler
     */
    public function detectOs()
    {
        $os = array(
            'Linux',
            'Debian',
            'Fedora',
            'JoliOs',
            'Kubuntu',
            'Mint',
            'Redhat',
            'Slackware',
            'Suse',
            'Ubuntu',
            'ZenwalkGnu',
            'CentOs',
            'LinuxTv',
            'CrOs',
            'Ventana',
            'Mandriva'
        );
        
        $chain = new \Browscap\Os\Chain(false, $os);
        $chain->setLogger($this->_logger);
        $chain->setDefaultHandler(new \Browscap\Os\Handlers\Unknown());
        $chain->setUseragent($this->_useragent);
        
        return $chain->detect();
    }
    
    /**
     * detect the cpu which is build into the device
     *
     * @return WindowsDesktop
     */
    protected function _detectCpu()
    {
        // Intel 64 bits
        if ($this->_utils->checkIfContains(array('x64', 'x86_64'))) {
            $this->_cpu = 'Intel X64';
            
            return $this;
        }
        
        // AMD 64 Bits
        if ($this->_utils->checkIfContains(array('amd64', 'AMD64'))) {
            $this->_cpu = 'AMD X64';
            
            return $this;
        }
        
        // PPC 64 Bits
        if ($this->_utils->checkIfContains(array('ppc64'))) {
            $this->_cpu = 'PPC X64';
            
            return $this;
        }
        
        // Intel X86
        if ($this->_utils->checkIfContains(array('i586', 'i686', 'i386', 'i486', 'i86'))) {
            $this->_cpu = 'Intel X86';
            
            return $this;
        }
        
        $this->_cpu = '';
        
        return $this;
    }
    
    /**
     * detect the bits of the cpu which is build into the device
     *
     * @return WindowsDesktop
     */
    protected function _detectBits()
    {
        // 64 bits
        if ($this->_utils->checkIfContains(array('x64', 'Win64', 'x86_64', 'amd64', 'AMD64', 'ppc64'))) {
            $this->_bits = '64';
            
            return $this;
        }
        
        // old deprecated 16 bit windows systems
        if ($this->_utils->checkIfContains(array('Win3.1', 'Windows 3.1'))) {
            $this->_bits = '16';
            
            return $this;
        }
        
        // general windows or a 32 bit browser on a 64 bit system (WOW64)
        if ($this->_utils->checkIfContains(array('Win', 'WOW64', 'i586', 'i686', 'i386', 'i486', 'i86', 'Intel Mac OS X', 'Android'))) {
            $this->_bits = '32';
            
            return $this;
        }
        
        $this->_bits = '';
        
        return $this;
    }
}