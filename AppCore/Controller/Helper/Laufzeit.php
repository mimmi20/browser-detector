<?php
declare(ENCODING = 'utf-8');
namespace AppCore\Controller\Helper;

/**
 * ActionHelper Class to detect the user agent and to set actions according to
 * it
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
 * ActionHelper Class to detect the user agent and to set actions according to
 * it
 *
 * @category  CreditCalc
 * @package   Controller-Helper
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2007-2010 Unister GmbH
 */
class LoanPeriods extends \Zend\Controller\Action\Helper\AbstractHelper
{
    private $_service = null;
    
    /**
     * Class constructor
     *
     * @access public
     * @return \\AppCore\\Controller\Helper\LoanPeriods
     */
    public function __construct()
    {
        $this->_logger  = \Zend\Registry::get('log');
        $this->_service = new \App\Service\LoanPeriods();
    }
    
    /**
     * detects and logs the user agent
     *
     * @return string
     */
    public function name($sparte, $loanPeriod = KREDIT_LAUFZEIT_DEFAULT)
    {
        return $this->_service->name($sparte, $loanPeriod);
    }
    
    /**
     * detects and logs the user agent
     *
     * @return string
     */
    public function getList($sparte)
    {
        return $this->_service->getList($sparte);
    }

    /**
     * Default-Methode für Services
     *
     * wird als Alias für die Funktion {@link log} verwendet
     *
     * @return string
     */
    public function direct($loanPeriod = KREDIT_LAUFZEIT_DEFAULT)
    {
        return $this->name($loanPeriod);
    }
}