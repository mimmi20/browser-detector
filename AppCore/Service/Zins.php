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
class Zins extends ServiceAbstract
{
    /**
     * Class Constructor
     *
     * @return \\AppCore\\Service\Zins
     */
    public function __construct()
    {
        $this->_model = new \AppCore\Model\Zins();
    }

    /**
     * returns the actual Zins
     *
     * @param integer $productId the product ID
     * @param integer $laufzeit
     * @param integer $betrag
     *
     * @return float|null
     */
    public function getZins(
        $productId,
        $laufzeit = KREDIT_LAUFZEIT_DEFAULT,
        $betrag = KREDIT_KREDITBETRAG_DEFAULT)
    {
        if (!is_numeric($productId)
            || !is_numeric($laufzeit)
            || !is_numeric($betrag)
        ) {
            return null;
        }

        if (0 >= (int) $productId
            || 0 >= (int) $laufzeit
            || 0 >= (int) $betrag
        ) {
            return null;
        }

        return $this->_model->getCached('zins')->getZins(
            $productId, $laufzeit, $betrag
        );
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
     * @return \Zend\Db\Table\Rowset Row(s) matching the criteria.
     * @throws Zend_Db_Table_Exception
     */
    public function find($zinsId = null)
    {
        return $this->_model->getCached('campaign')->find($zinsId);
    }

    /**
     * cleans the model cache
     *
     * calls the {@link _cleanCache} function with defined tag name
     *
     * @return \\AppCore\\Service\Zins
     */
    public function cleanCache()
    {
        return $this->cleanTaggedCache('zins');
    }
}