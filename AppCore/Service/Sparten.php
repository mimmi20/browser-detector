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
class Sparten extends ServiceAbstract
{
    /**
     * Class Constructor
     *
     * @return \\AppCore\\Service\Sparten
     */
    public function __construct()
    {
        $this->_model = new \AppCore\Model\Sparten();
    }

    /**
     * checkt die Sparte
     *
     * @param mixed $value der Wert, der geprüft werden soll
     *
     * @return boolean
     * @access protected
     */
    public function check($value)
    {
        return $this->getCached('categories')->check($value);
    }

    /**
     * liefert die ID einer Sparte
     *
     * @param mixed $value ID oder Name der Sparte
     *
     * @return boolean|integer FALSE, wenn die Sparte nicht existiert,
     *                         ansonsten die ID der Sparte
     * @access protected
     */
    public function getId($value)
    {
        return $this->_model->getCached('categories')->getId($value);
    }

    /**
     * liefert die ID einer Sparte
     *
     * @param mixed $value ID oder Name der Sparte
     *
     * @return boolean|integer FALSE, wenn die Sparte nicht existiert,
     *                         ansonsten die ID der Sparte
     * @access protected
     */
    public function getName($value)
    {
        return $this->_model->getCached('categories')->getName($value);
    }

    /**
     * liefert die beforzugte Laufzeit für eine Sparte
     *
     * @param string $sparte der Name der Sparte
     *
     * @return integer
     * @access public
     */
    public function getDefaultLaufzeit($sparte)
    {
        return $this->_model->getCached('categories')->getDefaultLaufzeit($sparte);
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
     * @return \Zend\Db\Table\Rowset_Abstract Row(s) matching the criteria.
     * @throws Zend_Db_Table_Exception
     */
    public function find($categoriesId = null)
    {
        return $this->_model->getCached('campaign')->find($categoriesId);
    }

    /**
     * cleans the model cache
     *
     * calls the {@link _cleanCache} function with defined tag name
     *
     * @return \\AppCore\\Service\Sparten
     */
    public function cleanCache()
    {
        return $this->cleanTaggedCache('categories');
    }
}