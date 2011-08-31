<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Plugin;

/**
 * ActionHelper Class to detect the user agent and to set actions according to
 * it
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Controller-Helper
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: AgentLogger.php 46 2011-08-10 18:50:42Z tmu $
 */
 
use Zend\Controller\Request;
use Zend\Controller\Plugin\AbstractPlugin;

/**
 * ActionHelper Class to detect the user agent and to set actions according to
 * it
 *
 * @category  Kreditrechner
 * @package   Controller-Helper
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class AgentLogger extends AbstractPlugin
{
    private $_logger = null;
    
    private $_config = null;

    /**
     * Class constructor
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->_config = \Zend\Registry::get('_config');
		$this->_logger = \Zend\Registry::get('log');
    }

    /**
     * Called before Zend_Controller_Front begins evaluating the
     * request against its routes.
     *
     * @param \Zend\Controller\Request\AbstractRequest $request
     * @return void
     */
    public function routeStartup(Request\AbstractRequest $request)
    {
        $this->_requestData = $request->getParams();
        
        $front    = \Zend\Controller\Front::getInstance();
        $cache    = $front->getParam('bootstrap')->getResource('cachemanager')->getCache('browscap');
		$browscap = new \Browscap\Browscap($this->_config->browscap, $this->_logger, $cache);

        $userAgent = $this->_getUserAgent($request);

        $browser = $browscap->getBrowser($userAgent, false);
        $caid    = $_SESSION->campaignId;

        if ('Default Browser' == $browser->Browser) {
            $campaignService = new \AppCore\Service\Campaigns();
            $campaignName    = $campaignService->getName($caid);

            $browser->Browser .= ' (' . $campaignName . ')';
        }

        switch (true) {
            case $browser->Win64:
                $bits = 64;
                break;
            case $browser->Win32:
                $bits = 32;
                break;
            case $browser->Win16:
                $bits = 16;
                break;
            default:
                $bits = null;
                break;
        }

        $oBrowser = new \AppCore\Service\Browsers();

        $browserClass = $oBrowser->searchByBrowser(
            $browser->Browser, $browser->Version, $browser->Platform, $bits
        );

        $browserId = null;
        
        $db = \Zend\Db\Table\AbstractTable::getDefaultAdapter();
        
        if ($browserClass) {
            $browserId = $browserClass->idBrowsers;
        } else {
            //var_dump($browser);exit;

            $aBrowser = array(
                'browserName'              => $browser->Browser,
                'platformName'             => $browser->Platform,
                'platformVersion'          => $browser->Version,
                'platformMajorVer'         => $browser->MajorVer,
                'platformMinorVer'         => $browser->MinorVer,
                'platformIsWin16'          => $browser->Win16,
                'platformIsWin32'          => $browser->Win32,
                'platformIsWin64'          => $browser->Win64,
                'hasAlphaState'            => $browser->Alpha,
                'hasBetaState'             => $browser->Beta,
                'supportsFrames'           => $browser->Frames,
                'supportsIframes'          => $browser->IFrames,
                'supportsTables'           => $browser->Tables,
                'supportsCookies'          => $browser->Cookies,
                'supportsBackgroundSounds' => $browser->BackgroundSounds,
                'suppertsCdf'              => $browser->CDF,
                'supportsVbScript'         => $browser->VBScript,
                'supportsJavaApplets'      => $browser->JavaApplets,
                'supportsJavaScript'       => $browser->JavaScript,
                'supportsActiveXControls'  => $browser->ActiveXControls,
                'supportedCssVersion'      => $browser->CssVersion,
                'supportsCSS'              => $browser->supportsCSS,
                'isBanned'                 => $browser->isBanned,
                'isMobileDevice'           => $browser->isMobileDevice,
                'isSyndicationReader'      => $browser->isSyndicationReader,
                'isCrawler'                => $browser->Crawler,
                'isAol'                    => $browser->AOL,
                'aolVersion'               => $browser->aolVersion,
                'wurflKey'                 => $browser->wurflKey
            );
            /**/
            //delete array field which are not mapped into database
            unset($aBrowser['browser_name']);
            unset($aBrowser['browser_name_regex']);
            unset($aBrowser['browser_name_pattern']);
            unset($aBrowser['Parent']);

            try {
                $query = 'INSERT INTO `browsers` (`' . implode('`,`', array_keys($aBrowser)). '`) VALUES (\'' . implode('\',\'', array_values($aBrowser)) . '\') ON DUPLICATE KEY UPDATE `createDate`=unix_timestamp()';
                $db->query($query);
                $browserId = $db->lastInsertId();
            } catch (Exception $e) {
                $this->_logger->error($e);

                $browserId = null;
            }
        }

        $_SESSION->agent     = $userAgent;
        $_SESSION->browserId = $browserId;

        $query = 'INSERT INTO `agents` (`idBrowsers`,`agent`,`createDate`) VALUES (' . ($browserId ? $browserId : 'NULL') . ', ' . $db->quote($userAgent) . ', unix_timestamp()) ON DUPLICATE KEY UPDATE `createDate`=unix_timestamp()';
        $db->query($query);
        $agentId = $db->lastInsertId();
        $_SESSION->agentId = $agentId;

        if ($browser->isBanned) {
            /*
             * the user agent should be banned
             */

            //do not calculate the Request
            $_SESSION->noResult = true;

            //mark the the Request as Test
            $_SESSION->isTest = true;

            //spider to be banned
            $_SESSION->crawler = true;

            //normal spider like google
            $_SESSION->spider = true;

            return;
        }

        //normal spider like google
        $_SESSION->spider = (boolean) $browser->Crawler;

        //spider to be banned
        $_SESSION->crawler = false;

        //get the ip adress of the client
        $remoteAddress = ((isset($_SERVER['REMOTE_ADDR']))
                       ? strip_tags(trim((string) $_SERVER['REMOTE_ADDR']))
                       : '');

        $isTest  = false;
        $unitest = (boolean) $request->getParam('unitest');
        if ($unitest || \AppCore\Globals::isTest($remoteAddress)) {
            $isTest = true;
        }

        $_SESSION->noResult = false;
        $_SESSION->isTest   = $isTest;
    }
	
    /**
     * disables the output and sets header
     *
     * this function is called if the request is not allowed or there is no
     * result
     *
     * @param integer $responseCode HTTP Code
     *
     * @return integer|null
     */
    private function _getCampaignId()
    {
        if ($caid = $controller->getHelper('getParam')->getParamFromName('campaignId')) {
            return (int) $caid;
        }
        
        if ($caid = $controller->getHelper('getParam')->getParamFromName('caid')) {
            return (int) $caid;
        }
        
        return null;
    }

    /**
     * get the useragent from the delivered data
     *
     * @param array $rd the requestdata
     *
     * @return string
     */
    private function _getUserAgent(Request\AbstractRequest $request)
    {
        $userAgent = $request->getParam('Agent', '');

        /*
         * detect the clients user agent, in js/iframe mode this is not set
         * -> take over the servers user agent
         */
        if ('' == $userAgent) {
            /*
             * detect the servers user agent, in js-mode this is the clients
             * user agent, in the other modes this is set by the portal
             */
            $support   = new \TeraWurfl\Support();
            $userAgent = $support->getUserAgent();
        }

        return $userAgent;
    }
}