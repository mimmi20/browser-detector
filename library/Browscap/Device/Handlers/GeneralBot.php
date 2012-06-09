<?php
namespace Browscap\Device\Handlers;

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
 * @version    SVN: $Id: GeneralDesktop.php 168 2012-01-22 16:26:29Z  $
 */

use Browscap\Device\Handler as DeviceHandler;

/**
 * CatchAllUserAgentHandler
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    SVN: $Id: GeneralDesktop.php 168 2012-01-22 16:26:29Z  $
 */
class GeneralBot extends DeviceHandler
{
    /**
     * @var string the detected device
     */
    protected $_device = 'general Bot';
    
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
        
        if ($this->_utils->isSpamOrCrawler($this->_useragent)) {
            return true;
        }
        
        if ($this->_utils->isFakeBrowser($this->_useragent)) {
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
        return 1;
    }
    
    /**
     * returns TRUE if the device is a mobile
     *
     * @return boolean
     */
    public function isMobileDevice()
    {
        return false;
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
    public function getOs()
    {
        $handler = new \Browscap\Os\Handlers\Unknown();
        $handler->setLogger($this->_logger);
        $handler->setUseragent($this->_useragent);
        
        return $handler->detect();
    }
    
    /**
     * returns TRUE if the device has a specific Browser
     *
     * @return boolean
     */
    public function hasBrowser()
    {
        return true;
    }
    
    /**
     * returns null, if the device does not have a specific Browser
     * returns the Browser Handler otherwise
     *
     * @return null|\Browscap\Os\Handler
     */
    public function getBrowser()
    {
        $browsers = array(
            'AcoonBot',
            'Bingbot',
            'Camcrawler',
            'CamelHttpStream',
            'CheckHttp',
            'Clipish',
            'Coverscout',
            'Curl',
            'CydralWebImageSearch',
            'DCPbot',
            'EventGuruBot',
            'ExaleadCloudView',
            'FakeBrowser',
            'FeedfetcherGoogle',
            'GeneralBot',
            'GenericJavaCrawler',
            'Getleft',
            'Godzilla',
            'Google',
            'Googlebot',
            'GSLFbot',
            'ImageSearcherS',
            'InsiteRobot',
            'JustCrawler',
            'Larbin',
            'Libwww',
            'Mail',
            'Mjbot',
            'MosBookmarks',
            'Msnbot',
            'NetNewsWire',
            'Netvibes',
            'NewsRack',
            'Nutch',
            'PagePeeker',
            'Parchbot',
            'PearHttpRequest',
            'Php',
            'Picsearchbot',
            'PodtechNetwork',
            'Pogodak',
            'Python',
            'Qihoo',
            'Quantcastbot',
            'Quicktime',
            'RgAnalytics',
            'RssingBot',
            'Safersurf',
            'Scorpionbot',
            'Scoutjet',
            'Scrubby',
            'Setooz',
            'SeznamScreenshotGenerator',
            'Snapbot',
            'Sosospider',
            'Sqwidgebot',
            'StrategicBoardBot',
            'StrawberryjamUrlExpander',
            'TasapImageRobot',
            'TinyTinyRss',
            'TkcAutodownloader',
            'TrendMicro',
            'TumblrRssSyndication',
            'Tweetbot',
            'TwengabotDiscover',
            'Twitturls',
            'TypoLinkvalidator',
            'Unisterbot',
            'UnisterTesting',
            'UniversalFeedParser',
            'UoftdbExperiment',
            'Vagabondo',
            'Voilabot',
            'Webaroo',
            'Webbotru',
            'Webcapture',
            'WebmasterworldServerHeaderChecker',
            'Webscan',
            'Websuchebot',
            'Wepbot',
            'Winkbot',
            'Wisebot',
            'WordPress',
            'Woriobot',
            'WorldWideWeasel',
            'XaldonWebspider',
            'XchaosArachne',
            'XenusLinkSleuth',
            'Xspider',
            'YacyBot',
            'Yadowscrawler',
            'Yahoo',
            'ZmEu',
            'Zookabot'
        );
        
        $browserChain = new \Browscap\Browser\Chain(false, $browsers);
        $browserChain->setLogger($this->_logger);
        
        if ($this->_cache instanceof \Zend\Cache\Frontend\Core) {
            $browserChain->setCache($this->_cache);
        }
        
        return $browserChain->detect($this->_useragent);
    }
}