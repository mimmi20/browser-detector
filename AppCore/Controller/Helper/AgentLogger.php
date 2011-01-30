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
 * @version   SVN: $Id: AgentLogger.php 30 2011-01-06 21:58:02Z tmu $
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
        $browscap           = new \AppCore\Browscap();

        $userAgent = $this->_getUserAgent();

        //unset these params, they are set lowercased later
        $request->setParam('Agent', null);
        $request->setParam('agent', null);

        $browser = $browscap->getBrowser($userAgent, false);
        var_dump($browser);
        
        $x = new \TeraWurfl\TeraWurfl();
        var_dump($x->getDeviceCapabilitiesFromAgent($userAgent));

        if ('Default Browser' == $browser->Browser) {
            $campaignService = new \AppCore\Service\Campaigns();
            $campaignName    = $campaignService->getName(
                $this->getActionController()->getHelper('GetParam')->direct('campaign_id')
            );

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

        $oBrowser = new \AppCore\Model\Browser();

        $browserClass = $oBrowser->searchByBrowser(
            $browser->Browser, $browser->Version, $browser->Platform, $bits
        );

        if ($browserClass) {
            $request->setParam('agentId', $browserClass->browserId);
        } else {
            $aBrowser = (array) $browser;

            //delete array field which are not mapped into database
            unset($aBrowser['browser_name']);
            unset($aBrowser['browser_name_regex']);
            unset($aBrowser['browser_name_pattern']);
            unset($aBrowser['MajorVer']);
            unset($aBrowser['MinorVer']);
            unset($aBrowser['Alpha']);
            unset($aBrowser['Beta']);
            unset($aBrowser['Parent']);

            try {
                $request->setParam('agentId', $oBrowser->insert($aBrowser));
            } catch (Exception $e) {
                $this->_logger->error($e);

                $request->setParam('agentId', null);
            }
        }

        $request->setParam('agent', $userAgent);

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

        $noResult = false;
        $noLog    = false;
        $isTest   = false;

        if (\AppCore\Globals::isBlocked($remoteAddress)) {
            $noResult = true;
        }

        /*
        if ($browser->Crawler || $noResult) {
            $noLog = true;
        }
        */

        $unitest = (boolean) $this->getActionController()->getHelper('GetParam')->direct('unitest');
        if ($unitest || \AppCore\Globals::isTest($remoteAddress)) {
            $isTest = true;
        }

        //$request->setParam('noLog', $noLog);
        $request->setParam('noResult', $noResult);
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