<?php
require_once LIB_PATH . 'Unister' . DS . 'Finance' . DS . 'DB' . DS . 'Abstract.php';

/**
 * Datenbank-Klasse fuer alle Funktionen zur Verwaltung der RIESTER-Schnittstellen
 *
 * @author Thomas Mueller <thomas.mueller@unister-gmbh.de>
 */
class Unister_Finance_DB_Page extends Unister_Finance_DB_Abstract
{
    /**
     * unique ID for the Request
     *
     * @var     integer
     * @access    public
     */
    public $nav_id = null;

    /**
     * Category ID for the Page
     *
     * CAN NOT BE "NULL"
     *
     * @var     integer
     * @access    public
     */
    public $cat_id = 0;

    /**
     * Formular ID for the Page
     *
     * CAN NOT BE "NULL"
     *
     * @var     integer
     * @access    public
     */
    public $form_id = 0;

    /**
     * internal Name for the Page
     *
     * @var     string
     * @access    public
     */
    public $datei_name = '';

    /**
     * complete Path for the Page
     *
     * @var     string
     * @access    public
     */
    public $datei_pfad = '';

    /**
     * 
     *
     * @var     integer
     * @access    public
     */
    public $bezug = 0;

    /**
     * 1, if the Page is an Category, 0 otherwise
     *
     * @var     integer
     * @access    public
     */
    public $is_cat = 0;

    /**
     * 1, if the Page is in the Navigation, 0 otherwise
     *
     * @var     integer
     * @access    public
     */
    public $is_nav = 1;

    /**
     * 
     *
     * @var     text
     * @access    public
     */
    public $keyword = '';

    /**
     * 
     *
     * @var     text
     * @access    public
     */
    public $header = '';

    /**
     * 
     *
     * @var     mediumtext
     * @access    public
     */
    public $text = '';

    /**
     * 
     *
     * @var     tinytext
     * @access    public
     */
    public $cross_links = '';

    /**
     * 
     *
     * @var     tinytext
     * @access    public
     */
    public $bottom_links = '';

    /**
     * 
     *
     * @var     text
     * @access    public
     */
    public $meta_title = '';

    /**
     * 
     *
     * @var     text
     * @access    public
     */
    public $meta_desc = '';

    /**
     * 
     *
     * @var     text
     * @access    public
     */
    public $meta_keywords = '';

    /**
     * 
     *
     * @var     tinytext
     * @access    public
     */
    public $search_keywords = '';

    /**
     * 
     *
     * @var     tinytext
     * @access    public
     */
    public $google_keywords = '';

    /**
     * 
     *
     * @var     text
     * @access    public
     */
    public $google_key_type = 'broad';

    /**
     * 1, if Google Ads should be turned on, 0 otherwise
     *
     * @var     integer
     * @access    public
     */
    public $googleads_on = 1;

    /**
     * 1, if Google Ads could be shown on top, 0 otherwise
     *
     * @var     integer
     * @access    public
     */
    public $googleads_on_top = 1;

    /**
     * Unix Timestamp of Creation Date for this Page
     *
     * @var     integer
     * @access    public
     */
    public $createdate = 0;

    /**
     * Sort Order
     *
     * @var     integer
     * @access    public
     */
    public $ordering = 0;

    /**
     * 1, if the Page is active, 0 otherwise
     *
     * @var     integer
     * @access    public
     */
    public $active = 1;

    /**
     * Konstruktor
     */
    public function __construct()
    {
        parent::__construct('pages', 'nav_id');
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
    public function loadByName($oid = null)
    {
        $k = $this->_primary;

        $this->_primary = 'datei_name';

        $this->load($oid);

        $this->_primary = $k;
    }

    /**
     * Loads a row from the database and binds the fields to the object properties
     *
     * @access    public
     * @param    mixed    Optional primary key.  If not specifed, the value of current key is used
     * @return    boolean    True if successful
     */
    public function loadByPath($oid = null)
    {
        $k = $this->_primary;

        $this->_primary = 'datei_pfad';

        $this->load($oid);

        $this->_primary = $k;
    }
}
?>