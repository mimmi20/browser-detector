<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Plugin;

/**
 * Service-Finder für alle Kredit-Services
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Controller-Helper
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: GetCampaignId.php 42 2011-07-31 21:40:21Z tmu $
 */
 
use Zend\Controller\Request;
use Zend\Controller\Plugin\AbstractPlugin;

/**
 * Service-Finder für alle Kredit-Services
 *
 * @category  Kreditrechner
 * @package   Controller-Helper
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class GetCampaignId extends AbstractPlugin
{
    private $_logger = null;
    
    private $_config = null;

    /**
     * Called before Zend_Controller_Front begins evaluating the
     * request against its routes.
     *
     * @param \Zend\Controller\Request\AbstractRequest $request
     * @return void
     */
    public function routeStartup(Request\AbstractRequest $request)
    {
        if ($caid = $request->getParam('campaignId')) {
            $_SESSION->campaignId = (int) $caid;
			
			return;
        }
        
        if ($caid = $request->getParam('caid')) {
            $_SESSION->campaignId = (int) $caid;
			
			return;
        }
        
        $_SESSION->campaignId = 1; // general campaign
    }
}