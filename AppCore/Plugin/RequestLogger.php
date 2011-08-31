<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Plugin;

/**
 * ActionHelper Class to log the request
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Controller-Helper
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: RequestLogger.php 42 2011-07-31 21:40:21Z tmu $
 */
 
use Zend\Controller\Request;
use Zend\Controller\Plugin\AbstractPlugin;

/**
 * ActionHelper Class to log the request
 *
 * @category  Kreditrechner
 * @package   Controller-Helper
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class RequestLogger extends AbstractPlugin
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
        $ip = $this->_getIp($request);

        $browserId  = $_SESSION->browserId;
        $agentId    = $_SESSION->agentId;
        $campaignId = $_SESSION->campaignId;
        $isTest     = $_SESSION->isTest;

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

        $_SESSION->requestId = (int) $requestId;
        $_SESSION->IP        = $ip;
    }

    /**
     * return the IP adress, if set from the request parameters, from the
     * server environment otherwise
     *
     * @param \Zend\Controller\Request\AbstractRequest $request
     * @return string
     */
    private function _getIp(Request\AbstractRequest $request)
    {
        $ip = $request->getParam('IP');

        if (is_string($ip) && '' != $ip) {
            return $ip;
        }

        if (!isset($_SERVER['REMOTE_ADDR'])) {
            return '';
        }

        if (isset($_SERVER['REMOTE_PORT'])) {
            return $_SERVER['REMOTE_ADDR'] . ':' . (int) $_SERVER['REMOTE_PORT'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }
}