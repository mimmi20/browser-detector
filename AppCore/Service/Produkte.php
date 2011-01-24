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
 * @version   SVN: $Id: Produkte.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * Service
 *
 * @category  Kreditrechner
 * @package   Services
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class Produkte extends ServiceAbstract
{
    /**
     * Class Constructor
     *
     * @return \\AppCore\\Service\Produkte
     */
    public function __construct()
    {
        $this->_model = new \AppCore\Model\Produkte();
    }

    /**
     * checks if the product is available and active
     *
     * @param integer $productId the product ID
     *
     * @return boolean
     * @access public
     */
    public function check($productId)
    {
        return $this->_model->getCached('produkte')->check($productId);
    }

    /**
     * return the sparte and the institute for an product
     *
     * @param integer $product   the product ID
     * @param string  &$institut the institute name
     * @param string  &$sparte   the sparte name
     *
     * @return boolean
     * @access public
     */
    public function lade($product, &$institut = '', &$sparte = '')
    {
        $institut = null;
        $sparte   = null;

        if (!is_numeric($product) || 0 >= (int) $product) {
            return false;
        }

        $return = $this->_model->getCached('produkte')->lade((string) $product);

        if (is_array($return)) {
            $institut = $return['institut'];
            $sparte   = $return['sparte'];

            return true;
        }

        return false;
    }

    /**
     * returns a list of possible Products
     *
     * @param integer $sparteId       the ID for the sparte
     * @param integer $usage          the ID for the usage
     * @param boolean $ignoreInactive a flag
     *                                TRUE:  all not active products will be
     *                                ignored
     *                                FALSE: also all inactive products will be
     *                                returned
     *
     * @return array  a list of product IDs
     * @access public
     */
    public function getList(
        $sparteId, $usage = 8, $ignoreInactive = true, $productOnly = null)
    {
        return $this->_model->getCached('produkte')->getList(
            $sparteId, $usage, $ignoreInactive, $productOnly
        );
    }

    /**
     * returns the actual Zins
     *
     * @param integer $productId the product ID
     *
     * @return boolean
     * @access public
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

        $zinsModel = new \AppCore\Service\Zins();
        return $zinsModel->getZins($productId, $laufzeit, $betrag);
    }

    /**
     * returns the actual Zins
     *
     * @param integer $productId the product ID
     *
     * @return boolean
     * @access public
     */
    public function getUrl($productId, $caid, $teaser = false)
    {
        if (!is_numeric($productId)) {
            return null;
        }

        $urlModel = new \AppCore\Service\Url();
        return $urlModel->getUrl($productId, $caid, $teaser);
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
    public function find($productId = null)
    {
        return $this->_model->getCached('produkte')->find($productId);
    }

    /**
     * cleans the model cache
     *
     * calls the {@link _cleanCache} function with defined tag name
     *
     * @return \\AppCore\\Service\Produkte
     */
    public function cleanCache()
    {
        return $this->cleanTaggedCache('produkte');
    }
}