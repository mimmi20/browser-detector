<?php
declare(ENCODING = 'iso-8859-1');
namespace Credit\Core\Model;

/**
 * the CalcResult is a virtual/temporary Table, which represents the result of
 * a calculation for credits or other finacial products in this application
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Models
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: CalcResult.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * the CalcResult is a virtual/temporary Table, which represents the result of
 * a calculation for credits or other finacial products in this application
 *
 * because the CalcResult is a virtual/temporary Table, it is not possible
 * to add or change the result rows and store them
 *
 * @category  Kreditrechner
 * @package   Models
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @abstract
 */
abstract class CalcResult
{
    /**
     * @var Zend_Db DB-Handler
     */
    protected $_db;

    /**
     * @var String SQL-Query
     */
    protected $_sql;

    /**
     * Name of the table in the db schema relating to child class
     *
     * @var    string
     * @access protected
     */
    protected $_name = '';

    /**
     * Name of the primary key field in the table
     *
     * @var    string
     * @access protected
     */
    protected $_primary = '';

    /**
     * An array of errors
     *
     * @var    array of error messages
     * @access protected
     */
    protected $_errors = array();

    /**
     * Name des Institutes
     *
     * @var     string
     * @access  public
     */
    public $kreditInstitutTitle = null;

    /**
     * ID des Produktes
     *
     * @var     string
     * @access  public
     */
    public $product = null;

    /**
     * Name des Angebotes
     *
     * @var     string
     * @access  public
     */
    public $kreditName = null;

    /**
     * Annahmewahrscheinlichkeit
     *
     * @var     integer
     * @access  public
     */
    public $kreditAnnahme = null;

    /**
     * @var     integer
     * @access  public
     */
    public $kreditTestsieger = 0;

    /**
     * Entscheidungszeitraum
     *
     * @var     string
     * @access  public
     */
    public $kreditEntscheidung = '3 Tage';

    /**
     * @var     integer
     * @access  public
     */
    public $kreditEntscheidung_Sort = 99;

    /**
     * ist bonitätsabhängig?
     *
     * @var     integer
     * @access  public
     */
    public $boni = 0;

    /**
     * interne Antragsstrecke?
     *
     * @var     integer
     * @access  public
     */
    public $internal = 0;

    /**
     * Sortierung
     *
     * @var     integer
     * @access  public
     */
    public $ordering = 0;

    /**
     * ist verfügbar?
     *
     * @var     integer
     * @access  public
     */
    public $active = 1;

    /**
     * Url für Antrag
     *
     * @var     string
     * @access  public
     */
    public $url = '';

    /**
     * Url für Antrag für Teaser
     *
     * @var     string
     * @access  public
     */
    public $url_teaser = '';

    /**
     * Zählpixel
     *
     * @var     string
     * @access  public
     */
    public $pixel = '';

    /**
     * ist ein Teaser
     *
     * @var     integer
     * @access  public
     */
    public $teaser = 0;

    /**
     * das Portal
     *
     * @var     string
     * @access  public
     */
    public $portal = '';

    /**
     * der Zinssatz
     *
     * @var     float
     * @access  public
     */
    public $effZins = 0.0;

    /**
     * die obere Grenze des Zinsbandes
     *
     * @var     float
     * @access  public
     */
    public $effZinsOben = 0.0;

    /**
     * die untere Grenze des Zinsbandes
     *
     * @var     float
     * @access  public
     */
    public $effZinsUnten = 0.0;

    /**
     * der Überziehungs-Zinssatz bei Girokonten
     *
     * @var     float
     * @access  public
     */
    public $effZinsN = 0.0;

    /**
     * der Rückfall-Zinssatz für Tages-/Festgeld
     *
     * @var     float
     * @access  public
     */
    public $effZinsR = 0.0;

    /**
     * der bereinigte Zinssatz für 2/3 der Kunden
     *
     * @var     float
     * @access  public
     */
    public $zinssatzCleaned = 0.0;

    /**
     * Flag, ob der bereinigte Zinssatz vorhanden ist
     *
     * @var     integer (boolean)
     * @access  public
     */
    public $zinssatzIsCleaned = 0;

    /**
     * ein Flag, das kennzeichnet, ob der Text 'ab ..' anstelle von '.. - ..'
     * angeteigt werden soll
     *
     * @var     float
     * @access  public
     */
    public $showAb = 1;

    /**
     * der minimal mögliche Kreditbetrag
     *
     * @var     integer
     * @access  public
     */
    public $min = 0;

    /**
     * der maximal mögliche Kreditbertrag
     *
     * @var     integer
     * @access  public
     */
    public $max = 0;

    /**
     * der Mindesbetrag für den Zinssatz
     *
     * @var     integer
     * @access  public
     */
    public $step = 0;

    /**
     * die monatliche Rate
     *
     * @var     float
     * @access  public
     */
    public $monatlicheRate = 0.0;

    /**
     * der gesamte Kreditbetrag inkl. Zinsen und Nebenkosten
     *
     * @var     float
     * @access  public
     */
    public $gesamtKreditbetrag = 0.0;

    /**
     * die Kreditkosten
     *
     * @var     float
     * @access  public
     */
    public $kreditKosten = 0.0;

    /**
     * die Kosten bzw. Erträge des 1. Monats
     *
     * @var     float
     * @access  public
     */
    public $kostenErsterMonat = 0.0;

    /**
     * die Bearbeitungsgebühr
     *
     * @var     float
     * @access  public
     */
    public $bearbeitungsGebuehr = 0.0;

    /**
     * der Zinsbetrag
     *
     * @var     float
     * @access  public
     */
    public $zinsen = 0.0;

    /**
     * der Betrag der letzten Rate
     *
     * @var     float
     * @access  public
     */
    public $letzteRate = 0.0;

    /**
     * der Nominalzins
     *
     * @var     float
     * @access  public
     */
    public $nomZins = 0.0;

    /**
     * Darlehenssumme + Bearbeitungsgebühr
     *
     * @var     float
     * @access  public
     */
    public $kreditbetrag = 0.0;

    /**
     * die Laufzeit
     *
     * @var     integer
     * @access  public
     */
    public $laufzeit = 0;

    /**
     * der Verwendungszweck
     *
     * @var     integer
     * @access  public
     */
    public $vzweck = 0;

    /**
     * Codename des Institutes
     *
     * @var     string
     * @access  public
     */
    public $kreditinstitut = '';

    /**
     * @var     string
     * @access  public
     */
    public $kredit_antrag = 'start';

    /**
     * das Testsiegerbild (klein)
     *
     * @var     string
     * @access  public
     */
    public $kreditTestsieger_Pic = '';

    /**
     * das Testsiegerbild (groß)
     *
     * @var     string
     * @access  public
     */
    public $kreditTestsieger_fullPic = '';

    /**
     * @var     string
     * @access  public
     */
    public $antragParams = '';

    /**
     * der Link zum Antrag
     *
     * @var     string
     * @access  public
     */
    public $offerLnk = '';

    /**
     * der Link zum Antrag (für den Teaser)
     *
     * @var     string
     * @access  public
     */
    public $offerLnk_teaser = '';

    /**
     * der Link zur Info
     *
     * @var     string
     * @access  public
     */
    public $infoLnk = '';

    /**
     * der Link zur Info für Teaser
     *
     * @var     string
     * @access  public
     */
    public $infoLnk_teaser = '';

    /**
     * @var     string
     * @access  public
     */
    public $infoParams = '';

    /**
     * wie oft erfolgt die Zinsgutschrift
     *
     * @var     string
     * @access  public
     */
    public $zinsgutschrift = '';

    /**
     * die möglichen Anlagezeiträume
     *
     * @var     string
     * @access  public
     */
    public $anlagezeitraum = '';

    /**
     * der Link zum Bild der Gesellschaft
     *
     * @var     string
     * @access  public
     */
    public $companyPicture = '';

    /**
     * die Gebühren für eine Kredit-Karte inkl. Kommentaren
     *
     * @var     string
     * @access  public
     */
    public $kreditkartengeb = '';

    /**
     * die Gebühren für eine EC-Karte inkl. Kommentaren
     *
     * @var     string
     * @access  public
     */
    public $ecgeb = '';

    /**
     * die Kontoführungskosten inkl. Kommentaren
     *
     * @var     string
     * @access  public
     */
    public $kontofuehrung = '';

    /**
     * Information zum Produkt
     *
     * @var     string
     * @access  public
     */
    public $info = '';

    /**
     * Flag, das anzeigt ob die Information zum Produkt in der Datenbank sind
     *
     * @var     boolean
     * @access  public
     */
    public $infoAvailable = false;

    /**
     * Konstruktor
     *
     * @return void
     * @access public
     */
    public function __construct()
    {
        $this->_db = \Zend\Db\Table\AbstractTable::getDefaultAdapter();
    }

    /**
     * Binds a named array/hash to this object
     *
     * Can be overloaded/supplemented by the child class
     *
     * @param array|object $from   an associative array or object
     * @param mixed        $ignore an array or space separated list of fields
     *                             not to bind
     *
     * @access public
     * @return boolean
     */
    public function bind($from, $ignore = array())
    {
        $fromArray  = is_array($from);
        $fromObject = is_object($from);

        if (!$fromArray && !$fromObject) {
            $class   = get_class($this);
            $message = $class . '::bind failed. Invalid from argument';

            $this->_logger->warn($message);

            return false;
        }

        if (!is_array($ignore)) {
            $ignore = explode(' ', $ignore);
        }

        $keys = array_keys($this->getProperties(true));
        foreach ($keys as $k) {
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
     * Returns an associative array of object properties
     *
     * @param boolean $public If true, returns only the public properties
     *
     * @access protected
     * @return array
     * @see    get()
     */
    protected function getProperties($public = true)
    {
        $vars  = get_object_vars($this);

        if ($public) {
            $keys = array_keys($vars);

            foreach ($keys as $key) {
                if (substr($key, 0, 1) == '_') {
                    unset($vars[$key]);
                }
            }
        }

        return $vars;
    }

    /**
     * Returns the column/value data as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->getProperties(true);
    }

    /**
     * checks if the result is valid
     *
     * validates the result against the requirements of the institutes, if
     * there are any
     *
     * @return boolean TRUE if completely successful,
     *                 FALSE if partially or not succesful.
     * @access public
     * @abstract
     */
    abstract public function isValid();

    /**
     * checks if the institute is able to handle the forms of unister
     *
     * @return boolean TRUE if the internal forms are possible,
     *                 FALSE otherwise.
     *
     * @access public
     * @abstract
     */
    abstract public function canInternal();

    /**
     * checks if the institute is able to load the institute site
     *
     * @return boolean TRUE if the institute site is possible,
     *                 FALSE otherwise.
     *
     * @access public
     * @abstract
     */
    abstract public function canExternal();
}