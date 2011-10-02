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
 * @abstract
 */
class CalcLogger extends \Zend\Controller\Action\Helper\AbstractHelper
{
    /**
     * @var array
     */
    private $_requestData = array();

    /**
     * loads the service class
     *
     * @param string $requestType The type of the request
     *
     * @return void
     */
    public function log($requestType = 'pageimpression')
    {
        $request            = $this->getRequest();
        $this->_requestData = $request->getParams();
        
        $getParamHelper = $this->getActionController()->getHelper('GetParam');
        $caid           = $this->getActionController()->getHelper('GetCampaignId')->direct();

        \AppCore\Globals::log(
            $getParamHelper->direct('requestId', null, 'Int'),
            $getParamHelper->direct('product', null, 'Int'),
            $getParamHelper->direct('kreditinstitut', '', 'Alpha'),
            $requestType,
            $getParamHelper->direct(
                'kreditbetrag', KREDIT_KREDITBETRAG_DEFAULT, 'Int'
            ),
            $getParamHelper->direct('loanPeriod', KREDIT_LOANPERIOD_DEFAULT, 'Int'),
            $getParamHelper->direct(
                'vzweck', KREDIT_VERWENDUNGSZWECK_SONSTIGES, 'Int'
            ),
            $getParamHelper->direct('caid', $caid, 'Int'),
            $getParamHelper->direct('sparte', KREDIT_SPARTE_KREDIT, 'Int'),
            $getParamHelper->direct('agentId', null, 'Int'),
            $getParamHelper->direct('spider', false),
            $getParamHelper->direct('crawler', false),
            $this->_requestData,
            $getParamHelper->direct('isTest', false)
        );
    }

    /**
     * Default-Methode für Services
     *
     * wird als Alias für die Funktion {@link getService} verwendet
     *
     * @param string $service The name of the Service
     * @param string $module  The name of the module
     *
     * @return void
     */
    public function direct($requestType = 'pageimpression')
    {
        $this->log($requestType);
    }
}