<?php
require_once LIB_PATH . 'Unister' . DS . 'Finance' . DS . 'Abstract.php';

/**
 * TODO
 *
 * @author Thomas Mueller <thomas.mueller@unister-gmbh.de>
 */
abstract class Unister_Finance_DB_Abstract extends Unister_Finance_Abstract
{
    /**
     * Name of the table in the db schema relating to child class
     *
     * @var     string
     * @access    protected
     */
    protected $_name = '';

    /**
     * Name of the primary key field in the table
     *
     * @var        string
     * @access    protected
     */
    protected $_primary = '';

    /**
     * An array of errors
     *
     * @var        array of error messages
     * @access    protected
     * @since    1.0
     */
    protected $_errors = array();

    /**
     * Konstruktor
     */
    public function __construct($table, $key)
    {
        parent::__construct();        $this->_db = Zend_Registry::get('db');

        $this->_name    = $table;
        $this->_primary = $key;
    }

    /**
     * Class destructor
     *
     * @return void
     * @access public
     */
    public function __destruct()
    {
        unset($this->_db);
    }

    public function output_db_profiler(Zend_Db_Profiler $profiler)
    {
        $queries = $profiler->getQueryProfiles();

        foreach($queries as $number => $query) {
            echo "<h3>Query Number ".$number."</h3>";
            echo "<pre>duration = ".$query->getElapsedSecs()."</pre>";
            echo "<pre>sql = ".$query->getQuery()."</pre>";
        }
    }

    /**
     * Gets the internal table name for the object
     *
     * @return string
     * @since 1.5
     */
    public function getTableName()
    {
        return $this->_name;
    }

    /**
     * Gets the internal primary key name
     *
     * @return string
     * @since 1.5
     */
    public function getKeyName()
    {
        return $this->_primary;
    }

    /**
     * Resets the default properties
     * @return    void
     */
    public function reset()
    {
        $k = $this->_primary;
        foreach ($this->getProperties() as $name => $value) {
            if ($name != $k) {
                $this->$name = $value;
            }
        }
    }

    /**
     * Binds a named array/hash to this object
     *
     * Can be overloaded/supplemented by the child class
     *
     * @access    public
     * @param    $from    mixed    An associative array or object
     * @param    $ignore    mixed    An array or space separated list of fields not to bind
     * @return    boolean
     */
    public function bind($from, $ignore = array())
    {
        $fromArray    = is_array($from);
        $fromObject    = is_object($from);

        if (!$fromArray && !$fromObject) {
            $this->setError(get_class($this) . '::bind failed. Invalid from argument');
            return false;
        }

        if (!is_array($ignore)) {
            $ignore = explode(' ', $ignore);
        }

        foreach ($this->getProperties() as $k => $v) {
            // internal attributes of an object are ignored
            if (!in_array($k, $ignore)) {
                if ($fromArray && isset($from[$k])) {
                    $this->$k = $from[$k];
                } else if ($fromObject && isset($from->$k)) {
                    $this->$k = $from->$k;
                }
            }
        }
        return true;
    }

    /**
     * Loads a row from the database and binds the fields to the object properties
     *
     * @access    public
     * @param    mixed    Optional primary key.  If not specifed, the value of current key is used
     * @return    boolean    True if successful
     */
    public function load($oid = null)
    {
        $k = $this->_primary;

        if ($oid !== null) {
            $this->$k = $oid;
        }

        $oid = $this->$k;

        if ($oid === null) {
            return false;
        }

        $this->reset();

        $Select = $this->_db->select();
        $Select->from($this->_name)
                   ->distinct()
                   ->where($this->_primary . ' = ' . $this->_db->Quote($oid))
                   ->order($this->_primary);
        try {
            $sql  = $Select->assemble();
            $stmt = $this->_db->prepare($sql);
            $stmt->execute();
            return $this->bind($stmt);
        } catch (PDOException $pe) {
            $this->setError('Abgefangene PDO-Exception: ' . $pe->getMessage());
            die();
        }
    }

    /**
     * Inserts a new row if id is zero or updates an existing row in the database table
     *
     * Can be overloaded/supplemented by the child class
     *
     * @access public
     * @param boolean If false, null object variables are not updated
     * @return null|string null if successful otherwise returns and error message
     */
    public function store($updateNulls = false)
    {
        $k   = $this->_primary;
        $id  = 0;
        $ret = 0;

        if ($this->$k) {
            //Update
            $values = array();

            foreach ($this->getProperties() as $name => $value) {
                if ($name != $k) {
                    $values[$name]= $value;
                }
            }

            $ret = $this->_db->update($this->_name, $values, $this->_primary . ' = ' . $this->_db->Quote($this->$k));
            $id  = $this->$k;
        } else {
            //Insert
            $values = array();

            foreach ($this->getProperties() as $name => $value) {
                if ($name != $k) {
                    $values[$name]= $value;
                }
            }

            $ret = $this->_db->insert($this->_name, $values);

            $id = $this->_db->lastInsertId();
        }

        if (!$ret && !$id) {
            Zend_Debug::dump($ret);
            Zend_Debug::dump($id);
            $this->setError(get_class($this) . '::store failed - '/*.$this->_db->errorInfo()*/);
            return false;
        } else {
            return $id;
        }
    }

    /**
     * Default delete method
     *
     * can be overloaded/supplemented by the child class
     *
     * @access public
     * @return true if successful otherwise returns and error message
     */
    public function erase($oid = null)
    {
        $k = $this->_primary;

        if ($oid) {
            $this->$k = (int) $oid;
        }

        $Delete = $this->delete($this->_name, $this->_primary.' = '. $this->_db->Quote($this->$k));

        return true;
    }

    /**
     * Generic save function
     *
     * @access    public
     * @param    array    Source array for binding to class vars
     * @param    string    Filter for the order updating
     * @param    mixed    An array or space separated list of fields not to bind
     * @returns TRUE if completely successful, FALSE if partially or not succesful.
     */
    public function save($source, $order_filter = '', $ignore = '')
    {
        if (!$this->bind($source, $ignore)) {
            return false;
        }

        if (!$this->check()) {
            return false;
        }

        if (!$this->store()) {
            return false;
        }

        if (!$this->checkin()) {
            return false;
        }

        /*
        if ($order_filter) {
            $filter_value = $this->$order_filter;
            $this->reorder( $order_filter ? $this->_db->nameQuote( $order_filter ).' = '.$this->_db->Quote( $filter_value ) : '' );
        }
        */

        $this->setError('');
        return true;
    }

    /**
     * Get the most recent error message
     *
     * @param    integer    $i Option error index
     * @param    boolean    $toString Indicates if JError objects should return their error message
     * @return    string    Error message
     * @access    public
     * @since    1.5
     */
    public function getError($i = null, $toString = true)
    {
        // Find the error
        if ($i === null) {
            // Default, return the last message
            $error = end($this->_errors);
        } elseif (!array_key_exists($i, $this->_errors)) {
            // If $i has been specified but does not exist, return false
            return false;
        } else {
            $error    = $this->_errors[$i];
        }

        return $error;
    }

    /**
     * Return all errors, if any
     *
     * @access    public
     * @return    array    Array of error messages or JErrors
     * @since    1.5
     */
    public function getErrors()
    {
        return $this->_errors;
    }

    /**
     * Add an error message
     *
     * @param    string $error Error message
     * @access    public
     * @since    1.0
     */
    public function setError($error)
    {
        array_push($this->_errors, $error);
    }
}