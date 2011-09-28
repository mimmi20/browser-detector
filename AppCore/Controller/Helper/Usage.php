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
class Usage extends \Zend\Controller\Action\Helper\AbstractHelper
{
    private $_service = null;
    
    /**
     * Class constructor
     *
     * @access public
     * @return \\AppCore\\Controller\Helper\Usage
     */
    public function __construct()
    {
        $this->_logger  = \Zend\Registry::get('log');
        $this->_service = new \App\Service\Usage();
    }
    
    /**
     * detects and logs the user agent
     *
     * @return string
     */
    public function name($usage = KREDIT_VERWENDUNGSZWECK_SONSTIGES)
    {
        return $this->_service->name($usage);
    }
    
    /**
     * detects and logs the user agent
     *
     * @return array
     */
    public function getList()
    {
        return $this->_service->getList();
    }

    /**
     * Default-Methode für Services
     *
     * wird als Alias für die Funktion {@link log} verwendet
     *
     * @return string
     */
    public function direct($usage = KREDIT_VERWENDUNGSZWECK_SONSTIGES)
    {
        $this->name($usage);
    }
}