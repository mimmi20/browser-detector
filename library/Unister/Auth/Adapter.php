<?php
require_once LIB_PATH . 'Zend' . DS . 'Auth' . DS . 'Adapter' . DS . 'Interface.php';
require_once LIB_PATH . 'Zend' . DS . 'Auth' . DS . 'Adapter' . DS . 'DbTable.php';
require_once LIB_PATH . 'Zend' . DS . 'Auth' . DS . 'Result.php';
require_once LIB_PATH . 'Unister' . DS . 'Auth' . DS . 'User.php';

/**
 * Adapter auf die ZF-Authentifizierung
 *
 * @author Thomas Kroehs <thomas.kroehs@unister-gmbh.de>
 */
class Unister_Auth_Adapter implements Zend_Auth_Adapter_Interface
{
    /**
     * @var String Benutzername
     */
    private $username;

    /**
     * @var String MD5 des Passworts
     */
    private $password;

    /**
     * @var Integer Benutzer-ID
     */
    private $user_id;

    /**
     * @var Auth_User Benutzer-Objekt
     */
    private $user;

    /**
     * Konstruktor
     *
     * @param String $uname Benutzername [optional]
     * @param String $pass Passwort [optional]
     */
    public function __construct($uname = null,$pass = null)
    {
        $this->user     = new Unister_Auth_User();
        $this->username = (!is_null($uname) && $uname != '')     ? $uname     : null;
        $this->password = (!is_null($pass) && $pass != '')         ? $pass     : null;
    }

    /**
     * Setzt die Login-Daten
     *
     * @param String $uname Benutzername
     * @param String $pass Passwort
     */
    public function setLogin($uname,$pass)
    {
        $this->username = $uname;
        $this->password = $pass;
    }

    /**
     * Fuehrt den Authentifizierungs-Versuch durch
     *
     * @throws Zend_Auth_Adapter_Exception Exception wenn Authentifizierung fehlschlaegt
     * @return Zend_Auth_Result
     */
    public function authenticate()
    {
        if (!is_null($this->username) && !is_null($this->password)) {
            $dbAdapter                 = Zend_Registry::get('db');
            $authAdapter             = new Zend_Auth_Adapter_DbTable($dbAdapter,'bearbeiter','Benutzername','Passwort');
            $authAdapter->setIdentity($this->username)
                        ->setCredential($this->password)
                        ->setCredentialTreatment('MD5(?)');
            $result = $authAdapter->authenticate();
            if ($result->isValid()){
                $resultRow                 = $authAdapter->getResultRowObject();
                var_dump($resultRow);exit;
                $this->user->role         = $resultRow->rolle;
                $this->user->role_id    = $resultRow->rolle_id;
                $this->user->userId        = $resultRow->bearbeiterid;
                $this->user->showName     = $resultRow->anzeigename;
                $this->user->eMail        = $resultRow->email;
                $this->user_id             = $resultRow->bearbeiterid;
                return $result;
            }else{
                return new Zend_Auth_Result(0,0,array());
            }
        }else{
            return new Zend_Auth_Result(0,0,array());
        }
    }

    /**
     * Gibt die Benutzer-ID zurueck
     *
     * @return Integer Benutzer-ID
     */
    public function getIdentity()
    {
        return $this->user_id;
    }

    /**
     * Gibt das Auth_User-Objekt zurueck
     *
     * @return Auth_User Benutzer-Objekt
     */
    public function getUser()
    {
        return $this->user;
    }
}