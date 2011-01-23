<?php
/**
 * abstrakte Basis-Klasse für alle die Kredit-Funktionen
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Credit
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: CreditAbstract.php 4271 2010-12-16 15:45:47Z t.mueller $
 */

/**
 * abstrakte Basis-Klasse für alle die Kredit-Funktionen
 *
 * @category  Kreditrechner
 * @package   Credit
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @abstract
 */
abstract class KreditCore_Class_CreditAbstract
{
    /**
     * gewünschte Laufzeit des Kredites
     * @var    int
     * @access protected
     */
    protected $_laufzeit = KREDIT_LAUFZEIT_DEFAULT;

    /**
     * gewünschte Verwendung des Kredites
     * @var    int
     * @access protected
     */
    protected $_zweck = KREDIT_VERWENDUNGSZWECK_SONSTIGES;

    /**
     * gewünschter Kreditbetrag
     * @var    int
     * @access protected
     */
    protected $_betrag = KREDIT_KREDITBETRAG_DEFAULT;

    /**
     * Code for an Campaign of an Partner
     * @var    string
     * @access protected
     */
    protected $_caid = '';//campaign-ID

    /**
     * Database object
     * @var    object
     * @access protected
     */
    protected $_db = null;

    /**
     * @var    integer
     * @access protected
     */
    protected $_sparte = KREDIT_SPARTE_KREDIT;

    /**
     * the mode to display the content
     * @var    string
     * @access protected
     */
    protected $_mode = 'html';

    /**
     * if TRUE, the request is a test
     *
     * @var    int (boolean)
     * @access protected
     */
    protected $_test = false;

    /**
     * @var \Zend\Log\Logger
     */
    protected $_logger = null;

    /**
     * Class constructor
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->_db     = \Zend\Db\Table\AbstractTable::getDefaultAdapter();
        $this->_logger = \Zend\Registry::get('log');
    }

    /**
     * @param integer $value the value for the variable
     *
     * @return void
     * @access public
     */
    public function setCaid($value)
    {
        $this->_caid = (int) $value;

        return $this;
    }

    /**
     * @return integer
     * @access public
     */
    public function getCaid()
    {
        return $this->_caid;
    }

    /**
     * @param integer $value the new sparte
     *
     * @return void
     * @access public
     */
    public function setSparte($value)
    {
        $this->_sparte = (int) $value;

        return $this;
    }

    /**
     * @return integer
     * @access public
     */
    public function getSparte()
    {
        return $this->_sparte;
    }

    /**
     * @param integer $value the value for the variable
     *
     * @return void
     * @access public
     */
    public function setLaufzeit($value)
    {
        $this->_laufzeit = (int) $value;

        return $this;
    }

    /**
     * @return integer
     * @access public
     */
    public function getLaufzeit()
    {
        return $this->_laufzeit;
    }

    /**
     * @param integer $value the value for the variable
     *
     * @return void
     * @access public
     */
    public function setZweck($value)
    {
        $this->_zweck = (int) $value;

        return $this;
    }

    /**
     * @return integer
     * @access public
     */
    public function getZweck()
    {
        return $this->_zweck;
    }

    /**
     * @param integer $value the value for the variable
     *
     * @return void
     * @access public
     */
    public function setKreditbetrag($value)
    {
        $this->_betrag = (int) $value;

        return $this;
    }

    /**
     * @return integer
     * @access public
     */
    public function getKreditbetrag()
    {
        return $this->_betrag;
    }

    /**
     * @param integer|string $value the value for the variable
     *
     * @return void
     * @access public
     */
    public function setMode($value)
    {
        $this->_mode = $value;

        return $this;
    }

    /**
     * @return integer
     * @access public
     */
    public function getMode()
    {
        return $this->_mode;
    }

    /**
     * @param boolean $test the value for the variable
     *
     * @return void
     * @access public
     */
    public function setTest($test)
    {
        $this->_test = (boolean) $test;

        return $this;
    }

    /**
     * @return boolean
     * @access public
     */
    public function getTest()
    {
        return $this->_test;
    }
}