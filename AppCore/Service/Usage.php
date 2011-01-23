<?php
declare(ENCODING = 'iso-8859-1');
namespace Credit\Core\Service;

/**
 * Service
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Services
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: Usage.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * Service
 *
 * @category  Kreditrechner
 * @package   Services
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class Usage extends ServiceAbstract
{
    /**
     * Class Constructor
     *
     * @return \Credit\Core\Service\Usage
     */
    public function __construct()
    {
        $this->_model = new \Credit\Core\Model\Usage();
    }

    /**
     * liefert alle möglichen Laufzeiten für eine Sparte
     *
     * @param string $sparte the name of the sparte
     *
     * @return array
     * @access public
     */
    public function getList()
    {
        return $this->_model->getCached('usage')->getList();
    }

    /**
     * liefert den Namen zu einer Laufzeit
     *
     * @param integer $usage the id/number of the usage
     *
     * @return string
     * @access public
     */
    public function name($usage = 8)
    {
        return $this->_model->getCached('usage')->name($usage);
    }

    /**
     * checkt den Verwendungszeck
     *
     * @param integer $value der Wert, der geprüft werden soll
     *
     * @return boolean
     * @access protected
     */
    public function check($value)
    {
        return $this->_model->getCached('usage')->check($value);
    }

    /**
     * cleans the model cache
     *
     * calls the {@link _cleanCache} function with defined tag name
     *
     * @return \Credit\Core\Service\Usage
     */
    public function cleanCache()
    {
        return $this->cleanTaggedCache('usage');
    }
}