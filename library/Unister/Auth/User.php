<?php
/**
 * Klasse fuer das Benutzer-Objekt
 *
 * @author Thomas Kroehs <thomas.kroehs@unister-gmbh.de>
 */
class Unister_Auth_User{
    /**
     * @var Integer Benutzer-ID
     */
    public $userId;

    /**
     * @var String Status der Authentifizierung
     */
    public $authStatus;

    /**
     * @var String Anzeigename
     */
    public $showName;

    /**
     * @var String E-Mail-Adresse des Benutzers
     */
    public $eMail;

    /**
     * @var String Acl-Rolle
     */
    public $role;

    /**
     * @var Integer ID der Acl-Rolle
     */
    public $role_id;

    /**
     * Konstruktor
     */
    public function __construct()
    {
        $this->userId         = 2;
        $this->showName     = 'Gast';
        $this->eMail        = '';
        $this->role            = 'Gast';
        $this->role_id        = 15;
    }
}