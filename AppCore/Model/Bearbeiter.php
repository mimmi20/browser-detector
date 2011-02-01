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
class Bearbeiter
    extends ModelAbstract
    implements \Zend\Auth\Adapter\AdapterInterface
{
    /**
     * Primary key
     *
     * @var String
     */
    protected $_primary = 'BearbeiterId';

    /**
     * Table name
     *
     * @var String
     */
    protected $_name = 'bearbeiter';

    /**
     * Credentials Password
     * @var String
     */
    private $_password = null;

    /**
     * Credentials UserName
     * @var String
     */
    private $_userName = null;

    /**
     * Set Credentials
     *
     * @param string $userName the User Name
     * @param string $password the password
     *
     * @return \\AppCore\\Model\Bearbeiter
     * @access public
     */
    public function setCredentials($userName, $password)
    {
        if (!is_string($userName) || !is_string($password)) {
            return null;
        }

        $this->_userName = $userName;
        $this->_password = $password;

        return $this;
    }

    /**
     * (non-PHPdoc)
     *
     * @return Zend_Auth_Result
     * @access public
     * @see    library/Zend/Auth/Adapter/Zend_Auth_Adapter_Interface
     */
    public function authenticate()
    {
        $select = $this->select();

        if (null === $this->_userName
            || null === $this->_password
        ) {
            return new Zend_Auth_Result(
                Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID,
                null,
                array('Authentifizierung fehlgeschlagen!')
            );
        }

        $username = strtolower($this->_userName);

        $select->where('Login = 1')
            ->where('Benutzername = ?', $username)
            ->where('Passwort = ?', md5($this->_password))/**/;

        $rows = $this->fetchAll($select);

        if (isset($rows[0]) && $rows[0]->Benutzername == $username) {
            return new Zend_Auth_Result(
                Zend_Auth_Result::SUCCESS,
                new KreditCore_Class_Auth_Identity($rows[0]),
                array()
            );
        } else {
            return new Zend_Auth_Result(
                Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID,
                null,
                array('Authentifizierung fehlgeschlagen!')
            );
        }
    }
}