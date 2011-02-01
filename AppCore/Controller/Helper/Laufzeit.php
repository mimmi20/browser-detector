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
 * @version   SVN: $Id$
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
class Laufzeit extends \Zend\Controller\Action\Helper\AbstractHelper
{
    private $_service = null;
    
    /**
     * Class constructor
     *
     * @access public
     * @return \\AppCore\\Controller\Helper\Laufzeit
     */
    public function __construct()
    {
        $this->_logger  = \Zend\Registry::get('log');
        $this->_service = new \AppCore\Service\Laufzeit();
    }
    
    /**
     * detects and logs the user agent
     *
     * @return string
     */
    public function name($sparte, $laufzeit = KREDIT_LAUFZEIT_DEFAULT)
    {
        return $this->_service->name($sparte, $laufzeit);
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
    public function direct($laufzeit = KREDIT_LAUFZEIT_DEFAULT)
    {
        return $this->name($laufzeit);
    }
}