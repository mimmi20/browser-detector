<?php
declare(ENCODING = 'iso-8859-1');
namespace Credit\Core\Model;

/**
 * Model
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Models
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: Zins.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * Model
 *
 * @category  Kreditrechner
 * @package   Models
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class Zins extends ModelAbstract
{
    /**
     * Table name
     *
     * @var String
     */
    protected $_name = 'zins';

    /**
     * Primary key
     *
     * @var String
     */
    protected $_primary = 'uid';

    /**
     * array of already used prepared statements
     *
     * @var array
     * @static
     */
    private static $_prepared = array();

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

        if (!isset(self::$_prepared['getzins'])) {
            $select = $this->select();
            $select->where('kp_id = :product');
            $select->where('laufzeit = :laufzeit');
            $select->where('betrag <= :betrag');
            $select->where(new \Zend\Db\Expr('NOT zinssatz IS NULL'));
            $select->where(new \Zend\Db\Expr('active = 1'));

            $select->limit(1);

            self::$_prepared['getzins'] =
                new \Zend\Db\Statement\Pdo($this->_db, $select);
        }

        $stmt = self::$_prepared['getzins'];
        $stmt->bindParam(':product', $productId, \PDO::PARAM_INT);
        $stmt->bindParam(':laufzeit', $laufzeit, \PDO::PARAM_INT);
        $stmt->bindParam(':betrag', $betrag, \PDO::PARAM_INT);

        try {
            $stmt->execute();

            /**
             * @var stdClass
             */
            $oZins = $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\Zend\Db\Statement\Exception $e) {
            $this->_logger->err($e);

            return null;
        }

        if (!isset($oZins[0])) {
            return null;
        }

        return (float) $oZins[0]->zinssatz;
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
        if (!is_numeric($zinsId)) {
            //partner id in wrong format
            $zinsId = 0;
        } elseif (0 >= (int) $zinsId) {
            $zinsId = 0;
        }

        if (!isset(self::$_prepared['find'])) {
            /**
             * @var Zend_Db_Table_Select
             */
            $select = $this->select();
            $select->from(
                array('z' => $this->_name)
            );

            $select->where('`z`.`uid` = :id');

            self::$_prepared['find'] =
                new \Zend\Db\Statement\Pdo($this->_db, $select);
        }

        $stmt = self::$_prepared['find'];
        $stmt->bindParam(':id', $zinsId, \PDO::PARAM_INT);

        try {
            $stmt->execute();

            /**
             * @var stdClass
             */
            $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Zend\Db\Statement\Exception $e) {
            $this->_logger->err($e);

            $rows = array();
        }

        $options = array(
            'data'  => $rows
        );

        $rowSet = new \Zend\Db\Table\Rowset($options);
        $rowSet->setTable($this);

        while ($rowSet->valid()) {
            $rowSet->current();
            $rowSet->next();
        }

        return $rowSet->rewind();
    }
}