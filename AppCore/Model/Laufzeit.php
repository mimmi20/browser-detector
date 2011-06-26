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
class Laufzeit extends ModelAbstract
{
    /**
     * Table name
     *
     * @var String
     */
    protected $_name = 'laufzeiten';

    /**
     * Primary key
     *
     * @var String
     */
    protected $_primary = 'laufzeit_id';

    /**
     * array of already used prepared statements
     *
     * @var array
     * @static
     */
    private static $_prepared = array();

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
        if (!$this->_checkSparte($sparte)) {
            return array();
        }

        $type = null;
        if (is_numeric($sparte)) {
            $postfix = 'n';
            $type    = \PDO::PARAM_INT;
        } else {
            $postfix = 'x';
            $type    = \PDO::PARAM_STR;
            $sparte  = ucfirst(strtolower((string) $sparte));
        }

        if (!isset(self::$_prepared['getlist_' . $postfix])) {
            /*
             * Prüfen, ob eine URL fuer den Partner und das Institut vorhanden
             * sind
             */
            $select = $this->select();
            $select->from(
                array('l' => $this->_name),
                array('name', 'value')
            );
            $select->join(
                array('ls' => 'laufzeitCategories'),
                'ls.laufzeit_id=l.laufzeit_id',
                array()
            );
            
            if (is_numeric($sparte)) {
                $select->where('ls.idCategories = :sparte');
            } else {
                $select->join(
                    array('s' => 'categories'),
                    's.idCategories=ls.idCategories',
                    array()
                );
                $select->where('s.name = :sparte');
            }
            $select->order(array('l.value'));

            self::$_prepared['getlist_' . $postfix] =
                new \Zend\Db\Statement\Pdo($this->_db, $select);
        }

        $stmt = self::$_prepared['getlist_' . $postfix];
        $stmt->bindParam(':sparte', $sparte, $type);

        try {
            $stmt->execute();

            /**
             * @var stdClass
             */
            $rows = $stmt->fetchAll(\PDO::FETCH_CLASS);
        } catch (\Zend\Db\Statement\Exception $e) {
            $this->_logger->err($e);

            $rows = array();
        }

        $list = array();
        foreach ($rows as $row) {
            $value = number_format($row->value, 1);

            $list[$value] = $row->name;
        }

        return $list;
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
        if (!$this->_checkSparte($sparte)) {
            return '';
        }

        if (!$this->_checkLaufzeit($laufzeit)) {
            return '';
        }

        $type = null;
        if (is_numeric($sparte)) {
            $postfix = 'n';
            $type    = \PDO::PARAM_INT;
            $sparte  = (int) $sparte;
        } else {
            $postfix = 'x';
            $type    = \PDO::PARAM_STR;
            $sparte  = ucfirst(strtolower((string) $sparte));
        }

        $laufzeit = (int) $laufzeit;

        if (!isset(self::$_prepared['name_' . $postfix])) {
            $select = $this->select();
            $select->from(
                array('l' => $this->_name),
                array('name')
            );
            $select->join(
                array('ls' => 'laufzeitCategories'),
                'ls.laufzeit_id=l.laufzeit_id',
                array()
            );
            
            $select->where('l.value = :laufzeit');

            if (is_numeric($sparte)) {
                $select->where('ls.idCategories = :sparte');
            } else {
                $select->join(
                    array('s' => 'categories'),
                    's.idCategories=ls.idCategories',
                    array()
                );
                $select->where('s.name = :sparte');
            }

            $select->order(array('l.value'))
                ->limit(1);

            self::$_prepared['name_' . $postfix] =
                new \Zend\Db\Statement\Pdo($this->_db, $select);
        }

        $stmt = self::$_prepared['name_' . $postfix];
        $stmt->bindParam(':sparte', $sparte, $type);
        $stmt->bindParam(':laufzeit', $laufzeit, \PDO::PARAM_INT);

        try {
            $stmt->execute();

            /**
             * @var stdClass
             */
            $rows = $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\Zend\Db\Statement\Exception $e) {
            $this->_logger->err($e);

            return '';
        }

        if (isset($rows[0]) && '' != $rows[0]->name) {
            return $rows[0]->name;
        }

        return '';
    }

    /**
     * checks if the product is available
     *
     * @param integer $value the product ID
     *
     * @return boolean
     * @access public
     */
    public function check($laufzeit, $sparte = '')
    {
        if (!$this->_checkSparte($sparte)) {
            return false;
        }

        if (!$this->_checkLaufzeit($laufzeit)) {
            return false;
        }

        $type    = null;
        $postfix = 'a';

        if ('' != $sparte) {
            if (is_numeric($sparte)) {
                $postfix = 'n';
                $type    = \PDO::PARAM_INT;
                $sparte  = (int) $sparte;
            } else {
                $postfix = 'x';
                $type    = \PDO::PARAM_STR;
                $sparte  = ucfirst(strtolower((string) $sparte));
            }
        }

        $laufzeit = (int) $laufzeit;

        if (!isset(self::$_prepared['check_' . $postfix])) {
            $select = $this->select();
            $select->from(
                array('l' => $this->_name),
                array('count' => new \Zend\Db\Expr('COUNT(*)'))
            );
            $select->join(
                array('ls' => 'laufzeitCategories'),
                'ls.laufzeit_id=l.laufzeit_id',
                array()
            );
            
            $select->where('l.value = :laufzeit');

            if ('' != $sparte) {
                if (is_numeric($sparte)) {
                    $select->where('ls.idCategories = :sparte');
                } else {
                    $select->join(
                        array('s' => 'categories'),
                        's.idCategories=ls.idCategories',
                        array()
                    );
                    $select->where('s.name = :sparte');
                }
            }

            $select->limit(1);

            self::$_prepared['check_' . $postfix] =
                new \Zend\Db\Statement\Pdo($this->_db, $select);
        }

        $stmt = self::$_prepared['check_' . $postfix];
        if ('' != $sparte) {
            $stmt->bindParam(':sparte', $sparte, $type);
        }
        $stmt->bindParam(':laufzeit', $laufzeit, \PDO::PARAM_INT);

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

        if (isset($rows[0]) && (int) $rows[0]->count) {
            return true;
        }

        return false;
    }

    /**
     * checks the parameter $sparte
     *
     * @param integer $sparte
     *
     * @return boolean
     */
    private function _checkSparte($sparte)
    {
        if (!is_numeric($sparte) && !is_string($sparte)) {
            return false;
        }

        if (is_numeric($sparte) && 0 >= (int) $sparte) {
            return false;
        }

        return true;
    }

    /**
     * checks the parameter $laufzeit
     *
     * @param integer|float $laufzeit
     *
     * @return boolean
     */
    private function _checkLaufzeit($laufzeit)
    {
        if (!is_numeric($laufzeit)) {
            return false;
        }

        if (is_numeric($laufzeit) && 0 >= (float) $laufzeit) {
            return false;
        }

        return true;
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
        if (!is_numeric($laufzeitId)) {
            //partner id in wrong format
            $laufzeitId = 0;
        } elseif (0 >= (int) $laufzeitId) {
            $laufzeitId = 0;
        }

        if (!isset(self::$_prepared['find'])) {
            /**
             * @var Zend_Db_Table_Select
             */
            $select = $this->select();
            $select->from(
                array('l' => $this->_name)
            );

            $select->where('`l`.`laufzeit_id` = :id');

            self::$_prepared['find'] =
                new \Zend\Db\Statement\Pdo($this->_db, $select);
        }

        $stmt = self::$_prepared['find'];
        $stmt->bindParam(':id', $laufzeitId, \PDO::PARAM_INT);

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