<?php
/**
 * KreditAdmin_Class_Auth_Adapter_LdapDb
 *
 * Authentication adapter to authenticate against an lDap resource.
 *
 * @category   Kredit-Admin
 * @package    Kredit-Admin_Class
 * @subpackage Auth_Adapter
 * @copyright  Copyright (c) 2010 Unister GmbH
 * @author     Uwe Woithe <uwe.woithe@unister-gmbh.de>
 * @version    SVN: $Id: Ldap.php 4228 2010-12-13 18:09:23Z t.mueller $
 */

class KreditCore_Class_Auth_Ldap implements Zend_Auth_Adapter_Interface
{
    /**
     * @var string
     */
    private $_userName;

    /**
     * @var string
     */
    private $_userPassword;

    /**
     *
     * @var ZEND_AUTH
     */
    private $_auth;

    /**
     * Register configured Ldap auth variables.
     *
     * @param string    $userName
     * @param string    $userPassword
     * @param Zend_Auth $auth
     *
     * @return void
     */
    public function __construct(
        $userName, $userPassword = null, Zend_Auth $auth = null)
    {
        $this->_userName     = $userName;
        $this->_userPassword = $userPassword;
        $this->_auth         = $auth;
    }


    /**
     * Zend_Auth_Adapter_Interface->authenticate()
     *
     * @return $resultLdap;
     */
    public function authenticate()
    {
        $config = \Zend\Registry::get('_config');

        $this->_buildUsername();

        $adapterLdap = new Zend_Auth_Adapter_Ldap(
            $config->ldap->toArray(),
            strtolower($this->_userName),
            $this->_userPassword
        );

        return $this->_auth->authenticate($adapterLdap);
    }

    /**
     * converts the given username into the format used in the ldap
     *
     * @return KreditCore_Class_Auth_Ldap
     */
    private function _buildUsername()
    {
        $this->_userName = strtolower($this->_userName);

        if (strpos($this->_userName, '.') !== false) {
            return $this;
        }

        if (strpos($this->_userName, '_') !== false) {
            $names = explode('_', $this->_userName);

            $this->_userName = substr($names[0], 0, 1) . '.' . $names[1];
        }

        if (strpos($this->_userName, ' ') !== false) {
            $names = explode(' ', $this->_userName);

            $this->_userName = substr($names[0], 0, 1) . '.' . $names[1];
        }

        return $this;
    }
}