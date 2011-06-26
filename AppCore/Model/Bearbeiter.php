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
     * @see    library/Zend/Auth/Adapter/Zend_Auth_Adapter_Interface
     */
    public function authenticate()
    {
        $select = $this->select();

        if (null === $this->_userName
            || null === $this->_password
        ) {
            return new \Zend\Auth\Result(
                \Zend\Auth\Result::FAILURE_CREDENTIAL_INVALID,
                null,
                array('Authentifizierung fehlgeschlagen!')
            );
        }

        $username = strtolower($this->_userName);
        $password = md5($this->_password);

        $select->where('`Login` = 1');

        $config = \Zend\Registry::get('_config');
        if ($config->ldap->enabled == 0) {
            // check password, if ldap is not enabled
            $select->where('`Passwort` = ?', $password)
                ->where('`Benutzername` = ?', $username);
        } else {
            $select->where('(`LDapName` = \'' . $username .'\') OR (`Benutzername` = \'' . $username .'\' AND `Passwort` = \'' . $password .'\')');
        }

        $rows  = $this->fetchAll($select);
        $valid = false;

        if (isset($rows[0])) {
            if ($config->ldap->enabled == 0) {
                if ($rows[0]->Benutzername == $username) {
                    $valid = true;
                }
            } else {
                if ($rows[0]->Benutzername == $username
                    || $rows[0]->LDapName == $username
                ) {
                    $valid = true;
                }

                if ($rows[0]->LDapName == $username) {
                    $auth = \Zend\Auth::getInstance();

                    /*
                     * u.woithe Change 2010-11-18 for Bug30718
                     */
                    $resultAuthLdap = new \AppCore\Auth\Ldap(
                        $this->_userName,
                        $this->_password,
                        $auth
                    );
                    $resultLdap = $resultAuthLdap->authenticate();
                    $resultCode = $resultLdap->getCode();

                    if ($resultCode != \Zend\Auth\Result::SUCCESS) {
                        /*
                         * Search in LDAP was not successfull
                         */
                        $this->_logger->warn(
                            'Benutzerkonto \'' . $username .
                            '\' ist in der Datenbank nicht vorhanden oder ' .
                            'Passwort falsch.'
                        );

                        $valid = false;
                    }
                    // u.woithe End
                }
            }
        }

        if ($valid) {
            return new \Zend\Auth\Result(
                \Zend\Auth\Result::SUCCESS,
                new \AppCore\Auth\Identity($rows[0]),
                array()
            );
        }

        $this->_logger->warn('Login of User \'' . $username . '\' failed');

        return new \Zend\Auth\Result(
            \Zend\Auth\Result::FAILURE_CREDENTIAL_INVALID,
            null,
            array('Authentifizierung fehlgeschlagen!')
        );
    }
}