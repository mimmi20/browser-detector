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
class Laufzeit extends ServiceAbstract
{
    /**
     * Class Constructor
     *
     * @return \\AppCore\\Service\Laufzeit
     */
    public function __construct()
    {
        $this->_model = new \AppCore\Model\Laufzeit();
    }

    /**
     * liefert alle möglichen Laufzeiten für eine Sparte
     *
     * @param string $sparte the name of the sparte
     *
     * @return array
     * @access public
     */
    public function getList($sparte)
    {
        return $this->_model->getCached('laufzeit')->getList($sparte);
    }

    /**
     * liefert den Namen zu einer Laufzeit
     *
     * @param string  $sparte   the name of the sparte
     * @param integer $laufzeit the Laufzeit
     *
     * @return string
     * @access public
     */
    public function name($sparte, $laufzeit = 48)
    {
        return $this->_model->getCached('laufzeit')->name($sparte, $laufzeit);
    }

    /**
     * checks if the product is available
     *
     * @param integer $value the product ID
     *
     * @return boolean
     * @access public
     */
    public function check($value, $sparte = '')
    {
        return $this->_model->getCached('laufzeit')->check($value, $sparte);
    }

    /**
     * Fetches rows by primary key.  The argument specifies one or more primary
     * key value(s).  To find multiple rows by primary key, the argument must
     * be an array.
     *
     * This method accepts a variable number of arguments.  If the table has a
     * multi-column primary key, the number of arguments must be the same as
     * the number of columns in the primary key.  To find multiple rows in a
     * table with a multi-column primary key, each argument must be an array
     * with the same number of elements.
     *
     * The find() method always returns a Rowset object, even if only one row
     * was found.
     *
     * @param  mixed $key The value(s) of the primary keys.
     *
     * @return \Zend\Db\Table\Rowset_Abstract Row(s) matching the criteria.
     * @throws Zend_Db_Table_Exception
     */
    public function find($laufzeitId = null)
    {
        return $this->_model->getCached('campaign')->find($laufzeitId);
    }

    /**
     * cleans the model cache
     *
     * calls the {@link _cleanCache} function with defined tag name
     *
     * @return \\AppCore\\Service\Laufzeit
     */
    public function cleanCache()
    {
        return $this->cleanTaggedCache('laufzeit');
    }
}