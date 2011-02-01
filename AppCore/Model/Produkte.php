<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Model;

/**
 * Model
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Models
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id$
 */

/**
 * Model
 *
 * @category  Kreditrechner
 * @package   Models
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class Produkte extends ModelAbstract
{
    /**
     * Table name
     *
     * @var String
     */
    protected $_name = 'produkte';

    /**
     * Primary key
     *
     * @var String
     */
    protected $_primary = 'kp_id';

    /**
     * array of already used prepared statements
     *
     * @var array
     * @static
     */
    private static $_prepared = array();

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
        if (!is_numeric($productId)) {
            return false;
        }

        $productId = (int) $productId;

        if (0 >= $productId) {
            return false;
        }

        if (!isset(self::$_prepared['check'])) {
            $select = $this->select();
            $select->from(
                array('p' => $this->_name),
                array('count' => new \Zend\Db\Expr('COUNT(*)'))
            );
            $select->where(new \Zend\Db\Expr('`p`.`kp_id` = :product'));
            $select->where(new \Zend\Db\Expr('`p`.`kp_active` = 1'));

            $select->limit(1);

            self::$_prepared['check'] =
                new \Zend\Db\Statement\Pdo($this->_db, $select);
        }

        $stmt = self::$_prepared['check'];
        $stmt->bindParam(':product', $productId, \PDO::PARAM_INT);

        try {
            $stmt->execute();

            /**
             * @var stdClass
             */
            $rows = $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\Zend\Db\Statement\Exception $e) {
            $this->_logger->err($e);

            return false;
        }

        if (isset($rows[0]) && $rows[0]->count) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * return the sparte and the institute for an product
     *
     * @param integer $product   the product ID
     * @param string  $institut  the institute name
     * @param string  $sparte    the sparte name
     *
     * @return boolean
     * @access public
     */
    public function lade($product, $institut = '', $sparte = '')
    {
        if (!is_numeric($product) || !$this->check($product)) {
            return false;
        }

        if (!isset(self::$_prepared['lade'])) {
            $select = $this->select()->setIntegrityCheck(false);

            $select->from(
                array('p' => $this->_name),
                array('id' => 'kp_id')
            );
            $select->join(
                array('i' => 'institute'),
                '`i`.`ki_id`=`p`.`ki_id`',
                array('institut' => 'ki_name')
            );
            $select->join(
                array('pc' => 'produkt_components'),
                '`pc`.`kp_id`=`p`.`kp_id`',
                array()
            );
            $select->join(
                array('s' => 'sparten'),
                '`pc`.`s_id`=`s`.`s_id`',
                array('sparte' => 's_name')
            );
            $select->where(new \Zend\Db\Expr('`p`.`kp_id` = :product'))
                ->where(new \Zend\Db\Expr('`p`.`kp_active` = 1'))
                ->where(new \Zend\Db\Expr('`s`.`active` = 1'))
                ->where(new \Zend\Db\Expr('`i`.`ki_active` = 1'));

            $select->limit(1);

            self::$_prepared['lade'] =
                new \Zend\Db\Statement\Pdo($this->_db, $select);
        }

        $stmt = self::$_prepared['lade'];
        $stmt->bindParam(':product', $product, \PDO::PARAM_INT);

        try {
            $stmt->execute();

            /**
             * @var stdClass
             */
            $rows = $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\Zend\Db\Statement\Exception $e) {
            $this->_logger->err($e);

            return false;
        }

        if (isset($rows[0]) && $rows[0]->institut) {
            $institut = $rows[0]->institut;
            $sparte   = $rows[0]->sparte;

            return array('institut' => $institut, 'sparte' => $sparte);
        } else {
            return false;
        }
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
     * @param integer $productOnly    the ID for the sparte
     *
     * @return array  a list of product IDs
     * @access public
     */
    public function getList(
        $sparteId, $usage = 8, $ignoreInactive = true, $productOnly = null)
    {
        if (!is_numeric($sparteId)) {
            return array();
        }

        $ignoreInactive = (boolean) $ignoreInactive;

        if (!is_numeric($usage)) {
            $usage = 8;
        }

        if (!is_numeric($productOnly)) {
            $productOnly = null;
        }

        $usage          = (int) $usage;
        $postfix        = 'x';

        if ((int) $productOnly > 0) {
            $postfix .= 'p';
        }

        if ($ignoreInactive) {
            $postfix .= 'i';
        }

        if (!isset(self::$_prepared['loadcaid_' . $postfix])) {
            $select = $this->select()->setIntegrityCheck(false);

            $select->from(
                array('p' => $this->_name),
                array('id' => 'p.kp_id', 'usages' => 'p.kp_usages')
            );
            $select->join(
                array('i' => 'institute'),
                'i.ki_id=p.ki_id',
                array()
            );
            $select->join(
                array('pc' => 'produkt_components'),
                'p.kp_id=pc.kp_id',
                array()
            );
            $select->join(
                array('s' => 'sparten'),
                'pc.s_id=s.s_id',
                array()
            );

            $select->where('s.s_id = :sparte');
            $select->where(
                new \Zend\Db\Expr(
                    '(NOT FIND_IN_SET(:usage,`p`.`kp_usages`) IS NULL) AND
                    (FIND_IN_SET(:usage,`p`.`kp_usages`) > 0)'
                )
            );

            if ((int) $productOnly > 0) {
                $select->where('p.ki_id = :po');
            }

            if ($ignoreInactive) {
                $select->where('p.kp_active = 1')
                    ->where('s.active = 1')
                    ->where('i.ki_active = 1');
            }

            self::$_prepared['loadcaid_' . $postfix] =
                new \Zend\Db\Statement\Pdo($this->_db, $select);
        }

        $stmt = self::$_prepared['loadcaid_' . $postfix];
        $stmt->bindParam(':sparte', $sparteId, \PDO::PARAM_INT);
        $stmt->bindParam(':usage', $usage, \PDO::PARAM_INT);

        if ((int) $productOnly > 0) {
            $stmt->bindParam(':po', $productOnly, \PDO::PARAM_INT);
        }

        try {
            $stmt->execute();

            /**
             * @var array
             */
            $rows = $stmt->fetchAll(\PDO::FETCH_CLASS);
        } catch (\Zend\Db\Statement\Exception $e) {
            $this->_logger->err($e);

            $rows = array();
        }

        $institutesList = array();

        foreach ($rows as $row) {
            $usages = explode(',', $row->usages);

            if (in_array($usage, $usages)) {
                $institutesList[] = $row->id;
            }
        }

        return $institutesList;
    }

    /**
     * returns the actual Zins
     *
     * @param integer $productId the product ID
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

        $zinsModel = new \AppCore\Service\Zins();
        return $zinsModel->getZins($productId, $laufzeit, $betrag);
    }

    /**
     * returns the actual Zins
     *
     * @param integer $productId the product ID
     *
     * @return string|null
     */
    public function getUrl($productId, $caid, $teaser = false)
    {
        if (!is_numeric($productId)) {
            return null;
        }

        $urlModel = new \AppCore\Service\Url();
        return $urlModel->getUrl($productId, $caid, $teaser = false);
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
        if (!is_numeric($productId)) {
            //partner id in wrong format
            $productId = 0;
        } elseif (0 >= (int) $productId) {
            $productId = 0;
        }

        if (!isset(self::$_prepared['find'])) {
            /**
             * @var Zend_Db_Table_Select
             */
            $select = $this->select();
            $select->from(
                array('p' => $this->_name)
            );

            $select->where('p.kp_id = :id');

            self::$_prepared['find'] =
                new \Zend\Db\Statement\Pdo($this->_db, $select);
        }

        $stmt = self::$_prepared['find'];
        $stmt->bindParam(':id', $productId, \PDO::PARAM_INT);

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