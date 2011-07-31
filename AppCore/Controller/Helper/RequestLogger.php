<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Controller\Helper;

/**
 * ActionHelper Class to log the request
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
 * ActionHelper Class to log the request
 *
 * @category  Kreditrechner
 * @package   Controller-Helper
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class RequestLogger extends \Zend\Controller\Action\Helper\AbstractHelper
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
     * logs the request
     *
     * @param string $service The name of the Service
     * @param string $module  The name of the module
     *
     * @return void
     */
    public function log()
    {
        $request = $this->getRequest();
        $ip      = $this->_getIp();

        $browserId  = $this->getActionController()->getHelper('getParam')->getParamFromName('browserId');
        $agentId    = $this->getActionController()->getHelper('getParam')->getParamFromName('agentId');
        $campaignId = $this->getActionController()->getHelper('getParam')->getParamFromName('caid');
        $isTest     = $this->getActionController()->getHelper('getParam')->getParamFromName('isTest', false);

        // store the request into database and connect to session
        $daten = array(
            'protocol'    => $request->getServer('SERVER_PROTOCOL'),
            'method'      => $request->getServer('REQUEST_METHOD'),
            'host'        => $request->getServer('HTTP_HOST'),
            'idCampaigns' => ($campaignId ? $campaignId : new \Zend\Db\Expr('NULL')),
            'idBrowsers'  => ($browserId ? $browserId : new \Zend\Db\Expr('NULL')),
            'idAgents'    => ($agentId ? $agentId : new \Zend\Db\Expr('NULL')),
            'accept'      => $request->getServer('HTTP_ACCEPT'),
            'language'    => $request->getServer('HTTP_ACCEPT_LANGUAGE'),
            'encoding'    => $request->getServer('HTTP_ACCEPT_ENCODING'),
            'charset'     => $request->getServer('HTTP_ACCEPT_CHARSET'),
            'cookie'      => $request->getServer('HTTP_COOKIE'),
            'IP'          => $ip,
            'uri'         => $request->getRequestUri(),
            'referrer'    => $request->getServer('HTTP_REFERER'),
            'SessionId'   => session_id(),
            'isTest'      => (int) $isTest,
            'fullRequest' => \Zend\Json\Json::encode($request->getServer())
        );

        $requestModel = new \AppCore\Model\Requests();
        $requestId    = $requestModel->insert($daten);

        $request->setParam('requestId', (int) $requestId);
        $request->setParam('IP', $ip);
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
     * return the IP adress, if set from the request parameters, from the
     * server environment otherwise
     *
     * @return string
     */
    private function _getIp()
    {
        $ip = $this->getActionController()->getHelper('getParam')->getParamFromName('IP');

        if (is_string($ip) && '' != $ip) {
            return $ip;
        }

        if (!isset($_SERVER['REMOTE_ADDR'])) {
            return '';
        }

        if (isset($_SERVER['REMOTE_PORT'])) {
            $port = (int) $_SERVER['REMOTE_PORT'];
        } else {
            $port = 80;
        }

        return $_SERVER['REMOTE_ADDR'] . ':' . $port;
    }
}