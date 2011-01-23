<?php
declare(ENCODING = 'iso-8859-1');
namespace Credit\Core\Controller\Helper;

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
 * @version   SVN: $Id: Usage.php 30 2011-01-06 21:58:02Z tmu $
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
class Usage extends \Zend\Controller\Action\Helper\AbstractHelper
{
    private $_service = null;
    
    /**
     * Class constructor
     *
     * @access public
     * @return \Credit\Core\Controller\Helper\Usage
     */
    public function __construct()
    {
        $this->_logger  = \Zend\Registry::get('log');
        $this->_service = new \Credit\Core\Service\Usage();
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