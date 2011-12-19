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
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */

use Browscap\Browser\Handler as BrowserHandler;

/**
 * BotCrawlerTranscoderUserAgentHanlder
 * 
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
class BotCrawlerTranscoder extends BrowserHandler
{
    /** 
     *
     * @param string $userAgent
     * @return boolean 
     */
    public function canHandle($userAgent) {
        foreach($this->botCrawlerTranscoder as $key) {
            if($this->utils->checkIfContainsCaseInsensitive($userAgent, $key)) {
                return true;
            }
        }
        return false;
    }


    private $botCrawlerTranscoder = array(
        'bot',
        'crawler',
        'spider',
        'novarra',
        'transcoder',
        'yahoo!searchmonkey',
        'yahoo!slurp',
        'feedfetcher-google',
        //'toolbar',
        'mowser',
        'mediapartners-google',
        'azureus',
        'inquisitor',
        'baiduspider',
        'baidumobaider',
        'holmes/',
        'libwww-perl',
        'netSprint',
        'yandex',
        //'cfnetwork',
        'ineturl',
        'jakarta',
        'lorkyll',
        'microsoft url control',
        'indy library',
        'slurp',
        'crawl',
        'wget',
        'ucweblient',
        //'rma',
        'snoopy',
        'untrursted',
        'mozfdsilla',
        'ask jeeves',
        'jeeves/teoma',
        'mechanize',
        'http client',
        'servicemonitor',
        'httpunit',
        'hatena',
        'ichiro'
    );
    
    /**
     * detects the browser name from the given user agent
     *
     * @param string $userAgent
     *
     * @return StdClass
     */
    public function detect($userAgent)
    {
        $class = new \StdClass();
        $class->browser = $this->detectBrowser($userAgent);
        $class->version = $this->detectVersion($userAgent);
        $class->bits    = $this->detectBits($userAgent);
        
        return $class;
    }
    
    /**
     * detects the browser name from the given user agent
     *
     * @param string $userAgent
     *
     * @return string
     */
    protected function detectBrowser($userAgent)
    {
        return 'unknown';
    }
    
    /**
     * detects the browser version from the given user agent
     *
     * @param string $userAgent
     *
     * @return float
     */
    protected function detectVersion($userAgent)
    {
        return 0.0;
    }
    
    /**
     * detects the bit count by this browser from the given user agent
     *
     * @param string $userAgent
     *
     * @return integer
     */
    protected function detectBits($userAgent)
    {
        return 0;
    }
}
