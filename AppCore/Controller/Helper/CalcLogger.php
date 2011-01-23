<?php
declare(ENCODING = 'iso-8859-1');
namespace Credit\Core\Controller\Helper;

/**
 * Service-Finder für alle Kredit-Services
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Controller-Helper
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: CalcLogger.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * Service-Finder für alle Kredit-Services
 *
 * @category  Kreditrechner
 * @package   Controller-Helper
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
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

        \Credit\Core\Globals::log(
            $getParamHelper->direct('requestId', null, 'Int'),
            $getParamHelper->direct('product', null, 'Int'),
            $getParamHelper->direct('kreditinstitut', '', 'Alpha'),
            $requestType,
            $getParamHelper->direct(
                'kreditbetrag', KREDIT_KREDITBETRAG_DEFAULT, 'Int'
            ),
            $getParamHelper->direct('laufzeit', KREDIT_LAUFZEIT_DEFAULT, 'Int'),
            $getParamHelper->direct(
                'vzweck', KREDIT_VERWENDUNGSZWECK_SONSTIGES, 'Int'
            ),
            $getParamHelper->direct('caid', null, 'Int'),
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