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
class Institute extends ModelAbstract
{
    /**
     * Table name
     *
     * @var String
     */
    protected $_name = 'institute';

    /**
     * Primary key
     *
     * @var String
     */
    protected $_primary = 'ki_id';

    /**
     * array of already used prepared statements
     *
     * @var array
     * @static
     */
    private static $_prepared = array();

    /**
     * returns the id of an institute
     *
     * @param string|integer $value ID oder Name des Institutes
     *
     * @return boolean|integer FALSE, wenn die Sparte nicht existiert,
     *                         ansonsten die ID der Sparte
     * @access public
     */
    public function getId($value)
    {
        if ((!is_string($value) && !is_numeric($value)) || '' == $value) {
            return false;
        }

        if (is_numeric($value) && 0 >= (int) $value) {
            return false;
        }

        if (is_numeric($value)) {
            $postfix = 'n';
            $type    = \PDO::PARAM_INT;
            $value   = (int) $value;
        } else {
            $postfix = 'x';
            $type    = \PDO::PARAM_STR;
            $value   = strtolower((string) $value);

            if (($pos = strpos($value, '-')) !== false) {
                $value = substr($value, 0, $pos);
            }
        }

        if (!isset(self::$_prepared['getid_' . $postfix])) {
            $select = $this->select();
            $select->from(
                array('i' => $this->_name),
                array('id' => 'ki_id')
            );
            if (is_numeric($value)) {
                $select->where('i.ki_id = :name');
            } else {
                $select->where('LOWER(i.ki_name) = :name');
            }

            $select->limit(1);

            self::$_prepared['getid_' . $postfix] =
                new \Zend\Db\Statement\Pdo($this->_db, $select);
        }

        $stmt = self::$_prepared['getid_' . $postfix];
        $stmt->bindParam(':name', $value, $type);

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

        if (isset($rows[0]) && is_object($rows[0]) && 0 < (int) $rows[0]->id) {
            return (int) $rows[0]->id;
        } else {
            return false;
        }
    }

    /**
     * returns the Color for a given Institute
     *
     * @param integer $kiId the Institute ID
     *
     * @return string the color
     * @access public
     */
    public function getColor($kiId)
    {
        $rows = $this->find($kiId);

        if (null === $rows) {
            return 'ddd';
        }

        $row = $rows->current();
        if ($row) {
            return $row->color;
        } else {
            return 'ddd';
        }
    }

    /**
     * returns the Color for a given Institute
     *
     * @param integer $kiId the Institute ID
     *
     * @return string the color
     * @access public
     */
    public function getName($kiId)
    {
        $rows = $this->find($kiId);

        if (null === $rows) {
            return null;
        }

        if (null === ($row = $rows->current())) {
            return null;
        }

        return $row->ki_title;
    }

    /**
     * returns the id of an institute
     *
     * @return Zend_Db_Table_Select
     * @access public
     */
    public function getList()
    {
        $select = $this->select();
        return $select->order('ki_title');
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
    public function find($instituteId = null)
    {
        if (!is_numeric($instituteId)) {
            //partner id in wrong format
            $instituteId = 0;
        } elseif (0 >= (int) $instituteId) {
            $instituteId = 0;
        }

        if (!isset(self::$_prepared['find'])) {
            /**
             * @var Zend_Db_Table_Select
             */
            $select = $this->select();
            $select->from(
                array('i' => $this->_name)
            );

            $select->where('`i`.`ki_id` = :id');

            self::$_prepared['find'] =
                new \Zend\Db\Statement\Pdo($this->_db, $select);
        }

        $stmt = self::$_prepared['find'];
        $stmt->bindParam(':id', $instituteId, \PDO::PARAM_INT);

        try {
            $stmt->execute();

            /**
             * @var array
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