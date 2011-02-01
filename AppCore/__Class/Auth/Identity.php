<?php
/**
 * Identidy-Klasse zum Speichern der Daten des angemeldeten Users
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Auth
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id$
 */

/**
 * Identidy-Klasse zum Speichern der Daten des angemeldeten Users
 *
 * @category  Kreditrechner
 * @package   Auth
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class KreditCore_Class_Auth_Identity
{
    /**
     * Identity in Database
     * @var \Zend\Db\Table\Row
     */
    private $_row;

    /**
     * Class Constructor
     *
     * @param \Zend\Db\Table\Row $userRow the user data
     *
     * @return void
     */
    public function __construct(\Zend\Db\Table\Row $userRow)
    {
        $this->_row = $userRow;
    }

    /**
     * get the user name
     *
     * @return string
     */
    public function getName()
    {
        return $this->_row->AnzeigeName;
    }

    /**
     * get the email address
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->_row->EMail;
    }

    /**
     * get the user id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->_row->BearbeiterId;
    }

    /**
     * get the id for the user role
     *
     * @return integer
     */
    public function getRolleId()
    {
        return $this->_row->RolleId;
    }

    /**
     * get the id for the user role
     *
     * @return integer
     */
    public function getRolle()
    {
        $rolleModel = new \AppCore\Model\Rolle();

        return $rolleModel->getName($this->getRolleId());
    }

    /**
     * Gibt das Auth_User-Objekt zurueck
     *
     * @return Auth_User Benutzer-Objekt
     */
    public function getUser()
    {
        return $this->_row;
    }
}