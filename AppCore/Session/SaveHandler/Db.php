<?php
declare(ENCODING = 'utf-8');
namespace AppCore\Session\SaveHandler;

/**
 * Savehandler zum Speichern der Session in einer Datenbank
 *
 * PHP version 5
 *
 * @category  CreditCalc
 * @package   Session
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: Db.php 24 2011-02-01 20:55:24Z tmu $
 */

/**
 * Savehandler zum Speichern der Session in einer Datenbank
 *
 * @category  CreditCalc
 * @package   Session
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2007-2010 Unister GmbH
 */
class Db
    implements \Zend\Session\SaveHandler
{
    private $_conn   = null;
    private $_params = array();
    private $_logger = null;

    /**
     * class constructor
     *
     * @param Zend_Db_Adapter_Abstract $conn   the database connection
     * @param array                    $params the session params
     *
     * @return KreditCore_Class_Session_SaveHandler_Db
     */
    public function __construct(
        Zend_Db_Adapter_Abstract $conn, array $params = array())
    {
        $_params = array(
            'tablename'       => 'sessions',
            'idfield'         => 'session_id',
            'datafield'       => 'data',
            'expiresfield'    => 'expiry',
            'beginfield'      => 'begin',
            'uidfield'        => 'user_id',
            'max_lifetime'    => 3600,
            'gc_max_lifetime' => 3600,
        );
        if (is_array($params)) {
            $this->_params = array_merge($_params, $params);
        } else {
            $this->_params = $_params;
        }
        $this->_conn   = $conn;
        $this->_logger = \Zend\Registry::get('log');
    }

    /**
     * Open Session - retrieve resources
     *
     * @param string $savePath
     * @param string $name
     *
     * @return boolean
     */
    public function open($savePath, $name)
    {
        return true;
    }

    /**
     * Close Session - free resources
     *
     * @return boolean
     */
    public function close()
    {
        return true;
    }

    /**
     * Read session data
     *
     * @param string $id
     *
     * @return stdClass
     */
    public function read($id)
    {
        if (strlen($id) == 32) {
            try {
                return $this->_conn->fetchOne(
                    'SELECT ' . $this->_params['datafield'] . ' ' .
                    'FROM ' . $this->_params['tablename'] . ' ' .
                    'WHERE ' . $this->_params['idfield'] . ' = :id' .
                    ' AND ' . $this->_params['expiresfield'] .
                    ' > UNIX_TIMESTAMP() ' . 'LIMIT 1;',
                    array('id' => $id)
                );
            } catch (Exception $e) {
                $this->_logger->err($e);

                return null;
            }
        } else {
            return null;
        }
    }

    /**
     * Write Session - commit data to resource
     *
     * @param string $id
     * @param mixed $data
     *
     * @return boolean
     */
    public function write($id, $data)
    {
        if (strlen($id) == 32) {
            try {
                $this->_conn->query(
                    'INSERT INTO ' . $this->_params['tablename'] .
                    ' ( ' . $this->_params['idfield'] . ', ' .
                    $this->_params['datafield'] . ', ' .
                    $this->_params['expiresfield'] . ')
                    VALUES (:idi,:datai,:expiresi )
                    ON DUPLICATE KEY UPDATE
                    ' . $this->_params['datafield'] . ' = :datau,
                    ' . $this->_params['expiresfield'] . ' = :expiresu;',
                    array(
                        'idi'      => $id,
                        'datai'    => $data,
                        'expiresi' => time() + $this->_params['max_lifetime'],
                        'datau'    => $data,
                        'expiresu' => time() + $this->_params['max_lifetime']
                    )
                );

            } catch(Exception $e) {
                $this->_logger->err($e);

                return false;
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Destroy Session - remove data from resource for
     * given session id
     *
     * @param string $id
     *
     * @return boolean
     */
    public function destroy($id)
    {
        try {
            $this->_conn->query(
                'DELETE FROM ' . $this->_params['tablename'] . ' WHERE ' .
                $this->_params['idfield'] . ' = :id ;',
                array(
                    'id' => $id
                )
            );
        } catch(Exception $e) {
            $this->_logger->err($e);

            return false;
        }
        return true;
    }

    /**
     * Garbage Collection - remove old session data older
     * than $maxlifetime (in seconds)
     *
     * @param int $maxlifetime
     *
     * @return boolean
     */
    public function gc($maxlifetime)
    {
        try {
            $this->_conn->query(
                'DELETE FROM ' . $this->_params['tablename'] . ' WHERE ' .
                $this->_params['expiresfield'] . ' < :time ;',
                array(
                    'time' => (time() - $maxlifetime)
                )
            );
        } catch(Exception $e) {
            $this->_logger->err($e);

            return false;
        }
        return true;
    }

    /**
     * Set session manager
     * 
     * @param  Manager $manager 
     * @return DbTable
     */
    public function setManager(Manager $manager)
    {
        $this->_manager = $manager;
        return $this;
    }

    /**
     * Get Session Manager
     * 
     * @return Manager
     */
    public function getManager()
    {
        if (null === $this->_manager) {
            $this->setManager(Container::getDefaultManager());
        }
        return $this->_manager;
    }
}