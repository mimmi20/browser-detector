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
 * @version   SVN: $Id: Sparten.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * Model
 *
 * @category  Kreditrechner
 * @package   Models
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class Sparten extends ModelAbstract
{
    /**
     * Table name
     *
     * @var String
     */
    protected $_name = 'sparten';

    /**
     * Primary key
     *
     * @var String
     */
    protected $_primary = 's_id';

    /**
     * array of already used prepared statements
     *
     * @var array
     * @static
     */
    private static $_prepared = array();

    /**
     * checkt die Sparte
     *
     * @param mixed $value der Wert, der gepr�ft werden soll
     *
     * @return boolean
     * @access protected
     */
    public function check($value)
    {
        if (!is_string($value) && !is_numeric($value)) {
            //partner id in wrong format
            return false;
        }

        $type = null;

        if (is_numeric($value)) {
            $postfix = 'n';
            $type    = \PDO::PARAM_INT;
        } else {
            $value   = ucfirst(strtolower((string) $value));
            $postfix = 'x';
            $type    = \PDO::PARAM_STR;
        }

        if (!isset(self::$_prepared['check_' . $postfix])) {
            $select = $this->select();
            $select->from(
                array('s' => $this->_name),
                array('count' => new \Zend\Db\Expr('COUNT(*)'))
            );
            if (is_numeric($value)) {
                $select->where('s.s_id = :sparte');
            } else {
                $select->where('s.s_name = :sparte');
            }
            $select->where(new \Zend\Db\Expr('s.active = 1'));

            $select->limit(1);

            self::$_prepared['check_' . $postfix] =
                new \Zend\Db\Statement\Pdo($this->_db, $select);
        }

        $stmt = self::$_prepared['check_' . $postfix];
        $stmt->bindParam(':sparte', $value, $type);

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
        }

        return false;
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
        if (!is_string($value) && !is_numeric($value)) {
            //partner id in wrong format
            return false;
        }

        if (is_numeric($value) && 0 >= (int) $value) {
            return false;
        }

        $type = null;

        if (is_numeric($value)) {
            $postfix = 'n';
            $type    = \PDO::PARAM_INT;
        } else {
            $value   = ucfirst(strtolower((string) $value));
            $postfix = 'x';
            $type    = \PDO::PARAM_STR;
        }

        if (!isset(self::$_prepared['getid_' . $postfix])) {
            $select = $this->select();
            $select->from(
                array('s' => $this->_name),
                array('id' => 's_id')
            );

            if (is_numeric($value)) {
                $select->where('s.s_id = :sparte');
            } else {
                $select->where('s.s_name = :sparte');
            }

            $select->where(new \Zend\Db\Expr('s.active = 1'));
            $select->limit(1);

            self::$_prepared['getid_' . $postfix] =
                new \Zend\Db\Statement\Pdo($this->_db, $select);
        }

        $stmt = self::$_prepared['getid_' . $postfix];
        $stmt->bindParam(':sparte', $value, $type);

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

        if (!isset($rows[0])
            || !is_object($rows[0])
            || 0 == (int) $rows[0]->id
        ) {
            return false;
        }

        return (int) $rows[0]->id;
    }

    /**
     * liefert die ID einer Sparte
     *
     * @param mixed $value ID oder Name der Sparte
     *
     * @return boolean|string FALSE, wenn die Sparte nicht existiert,
     *                        ansonsten der Name der Sparte
     * @access protected
     */
    public function getName($value)
    {
        $id = $this->getId($value);

        if (false === $id) {
            return false;
        }

        $name = $this->find($id)->current();

        if (!is_object($name)) {
            $this->_logger->err(
                'Name from Sparte not found! value for search: ' . $id
            );
            return false;
        }

        return $name->s_name;
    }

    /**
     * liefert die beforzugte Laufzeit f�r eine Sparte
     *
     * @param string $sparte der Name der Sparte
     *
     * @return integer
     * @access public
     */
    public function getDefaultLaufzeit($sparte)
    {
        if (false === ($sparte = $this->getId($sparte))) {
            return KREDIT_LAUFZEIT_DEFAULT;
        }

        if (is_numeric($sparte)) {
            $postfix = 'n';
            $type    = \PDO::PARAM_INT;
        } else {
            $value   = ucfirst(strtolower((string) $value));
            $postfix = 'x';
            $type    = \PDO::PARAM_STR;
        }

        if (!isset(self::$_prepared['loadcaid_' . $postfix])) {
            $select = $this->select();

            if (is_numeric($sparte)) {
                $select->where('s_id = :sparte');
            } else {
                $select->where('s_name = :sparte');
            }
            $select->limit(1);

            self::$_prepared['loadcaid_' . $postfix] =
                new \Zend\Db\Statement\Pdo($this->_db, $select);
        }

        $stmt = self::$_prepared['loadcaid_' . $postfix];
        $stmt->bindParam(':sparte', $sparte, $type);

        try {
            $stmt->execute();

            /**
             * @var stdClass
             */
            $rows = $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\Zend\Db\Statement\Exception $e) {
            $this->_logger->err($e);

            return KREDIT_LAUFZEIT_DEFAULT;
        }

        if (isset($rows[0]) && isset($rows[0]->defaultLaufzeit)) {
            return (int) $rows[0]->defaultLaufzeit;
        }

        return KREDIT_LAUFZEIT_DEFAULT;
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
    public function find($spartenId = null)
    {
        if (!is_numeric($spartenId)) {
            //partner id in wrong format
            $spartenId = 0;
        } elseif (0 >= (int) $spartenId) {
            $spartenId = 0;
        }

        if (!isset(self::$_prepared['find'])) {
            /**
             * @var Zend_Db_Table_Select
             */
            $select = $this->select();
            $select->from(
                array('i' => $this->_name)
            );

            $select->where('`i`.`s_id` = :id');
            self::$_prepared['find'] =
                new \Zend\Db\Statement\Pdo($this->_db, $select);
        }

        $stmt = self::$_prepared['find'];
        $stmt->bindParam(':id', $spartenId, \PDO::PARAM_INT);

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