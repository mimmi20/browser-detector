<?php
declare(ENCODING = 'utf-8');
namespace AppCore\Controller\Helper;

/**
 * Service-Finder für alle Kredit-Services
 *
 * PHP version 5
 *
 * @category  CreditCalc
 * @package   Controller-Helper
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id$
 */

/**
 * Service-Finder für alle Kredit-Services
 *
 * @category  CreditCalc
 * @package   Controller-Helper
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2007-2010 Unister GmbH
 */
class GetCampaignId extends \Zend\Controller\Action\Helper\AbstractHelper
{
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
    public function getCampaignId()
    {
        $controller = $this->getActionController();
        
        if (!is_object($controller)) {
            return null;
        }
        
        if ($caid = $controller->getHelper('getParam')->getParamFromName('campaignId')) {
            return (int) $caid;
        }
        
        if ($caid = $controller->getHelper('getParam')->getParamFromName('caid')) {
            return (int) $caid;
        }
        
        return null;
    }

    /**
     * Default-Methode für Services
     *
     * wird als Alias für die Funktion {@link getService} verwendet
     *
     * @param string $service The name of the Service
     * @param string $module  The name of the module
     *
     * @return \\AppCore\\Service\Abstract The servics class
     */
    public function direct()
    {
        return $this->getCampaignId();
    }
}