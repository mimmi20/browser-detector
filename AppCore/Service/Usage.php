<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Service;

/**
 * Service
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Services
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id$
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
     * @return \\AppCore\\Service\Usage
     */
    public function __construct()
    {
        $this->_model = new \AppCore\Model\Usage();
    }

    /**
     * liefert alle m�glichen Laufzeiten f�r eine Sparte
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
     * @param integer $value der Wert, der gepr�ft werden soll
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
     * @return \\AppCore\\Service\Usage
     */
    public function cleanCache()
    {
        return $this->cleanTaggedCache('usage');
    }
}