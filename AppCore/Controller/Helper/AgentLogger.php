<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Controller\Helper;

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
 * @version   SVN: $Id$
 */

/**
 * ActionHelper Class to detect the user agent and to set actions according to
 * it
 *
 * @category  Kreditrechner
 * @package   Controller-Helper
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class AgentLogger extends \Zend\Controller\Action\Helper\AbstractHelper
{
    /**
     * Class constructor
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->_logger = \Zend\Registry::get('log');
    }
    
    /**
     * detects and logs the user agent
     *
     * @return void
     */
    public function log()
    {
        $request = $this->getRequest();

        $this->_requestData = $request->getParams();
        
        $config   = \Zend\Registry::get('_config');
        $front    = \Zend\Controller\Front::getInstance();
        $cache    = $front->getParam('bootstrap')->getResource('cachemanager')->getCache('browscap');
        $browscap = new \Browscap\Browscap($config->browscap, $this->_logger, $cache);

        $userAgent = $this->_getUserAgent();

        //unset these params, they are set lowercased later
        $request->setParam('Agent', null);
        $request->setParam('agent', null);

        $browser = $browscap->getBrowser($userAgent, false);
        $caid    = $this->getActionController()->getHelper('GetCampaignId')->direct();
        //var_dump($browser->Browser, $browser->wurflKey);
        
        //$wurflDb = \Zend\Registry::get('wurfldb');
        //$x = new \TeraWurfl\TeraWurfl(null, $wurflDb);
        //$x->getDeviceCapabilitiesFromAgent($userAgent);
        //var_dump($x->getDeviceCapability('id'));

        //exit;
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

        $request->setParam('agent', $userAgent);
        $request->setParam('browserId', $browserId);

        $query = 'INSERT INTO `agents` (`idBrowsers`,`agent`,`createDate`) VALUES (' . ($browserId ? $browserId : 'NULL') . ', ' . $db->quote($userAgent) . ', unix_timestamp()) ON DUPLICATE KEY UPDATE `createDate`=unix_timestamp()';
        $db->query($query);
        $agentId = $db->lastInsertId();
        $request->setParam('agentId', $agentId);

        if ($browser->isBanned) {
            /*
             * the user agent should be banned
             */

            //do not calculate the Request
            $request->setParam('noResult', true);

            //mark the the Request as Test
            $request->setParam('isTest', true);

            //spider to be banned
            $request->setParam('crawler', true);

            //normal spider like google
            $request->setParam('spider', true);

            return;
        }

        //normal spider like google
        $request->setParam('spider', (boolean) $browser->Crawler);

        //spider to be banned
        $request->setParam('crawler', false);

        //get the ip adress of the client
        $remoteAddress = ((isset($_SERVER['REMOTE_ADDR']))
                       ? strip_tags(trim((string) $_SERVER['REMOTE_ADDR']))
                       : '');

        $isTest  = false;
        $unitest = (boolean) $this->getActionController()->getHelper('GetParam')->direct('unitest');
        if ($unitest || \AppCore\Globals::isTest($remoteAddress)) {
            $isTest = true;
        }

        $request->setParam('noResult', false);
        $request->setParam('isTest', $isTest);
    }

    /**
     * Default-Methode für Services
     *
     * wird als Alias für die Funktion {@link log} verwendet
     *
     * @return void
     */
    public function direct()
    {
        $this->log();
    }

    /**
     * get the useragent from the delivered data
     *
     * @param array $rd the requestdata
     *
     * @return string
     */
    private function _getUserAgent()
    {
        $userAgent = $this->getActionController()->getHelper('GetParam')->direct('Agent', '');

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