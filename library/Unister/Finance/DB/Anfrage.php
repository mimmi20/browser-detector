<?php
require_once LIB_PATH . 'Unister' . DS . 'Finance' . DS . 'DB' . DS . 'Abstract.php';

/**
 * Datenbank-Klasse fuer alle Funktionen zur Verwaltung der RIESTER-Schnittstellen
 *
 * @author Thomas Mueller <thomas.mueller@unister-gmbh.de>
 */
class Unister_Finance_DB_Anfrage extends Unister_Finance_DB_Abstract
{
    /**
     * unique ID for the Request
     *
     * @var     integer
     * @access    protected
     */
    protected $AnfrageId = null;

    /**
     * ID for the Customer , who created the Request
     *
     * CAN NOT BE "NULL"
     *
     * @var     integer
     * @access    protected
     */
    protected $AnfrageKunde_Id = 0;

    /**
     * MySql Timestamp of the Creation Date for the Interface (foreign ID)
     *
     * @var     datetime
     * @access    protected
     */
    protected $DatumEingang = null;

    /**
     * Sparte for the Request
     *
     * @var     string
     * @access    protected
     */
    protected $Sparte_Id = 25; //default for Riester Rente

    /**
     * Lead
     *
     * CAN NOT BE "NULL"
     *
     * @var     integer
     * @access    protected
     */
    protected $Lead = 0;

    /**
     * Partner_Id
     *
     * @var     integer
     * @access    protected
     */
    protected $Partner_Id = null;

    /**
     * AnfrageIP
     *
     * @var     string (50 Byte)
     * @access    protected
     */
    protected $AnfrageIP = '';

    /**
     * AnfrageSchluessel
     *
     * @var     string (32Byte)
     * @access    protected
     */
    protected $AnfrageSchluessel = '';

    /**
     * Neuberechnung
     *
     * @var     integer
     * @access    protected
     */
    protected $Neuberechnung = null;

    /**
     * Konstruktor
     */
    public function __construct()
    {
        parent::__construct('riester_anfrage', 'AnfrageId');

        $this->AnfrageSchluessel = new Zend_Db_Expr('MD5(CONCAT(RAND(),"_",UNIX_TIMESTAMP(NOW())))');
        $this->AnfrageIP         = trim(strval($_SERVER['REMOTE_ADDR']));
    }

    public function mapInput(User_Input $input)
    {
        //nothing to do at the moment
    }

    /**
     * Loads a row from the database and binds the fields to the object properties
     *
     * @access    public
     * @param    mixed    Optional primary key.  If not specifed, the value of current key is used
     * @return    boolean    True if successful
     */
    public function loadByKunde($oid = null)
    {
        $k = $this->_primary;

        $this->_primary = 'AnfrageKunde_Id';

        $this->load( $oid );

        $this->_primary = $k;
    }
}
?>