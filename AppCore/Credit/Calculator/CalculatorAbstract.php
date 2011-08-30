<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Credit\Calculator;

/**
 * Controller-Klasse zum Ausliefern von Javascript-Dateien
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Credit
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: InputAbstract.php 24 2011-02-01 20:55:24Z tmu $
 */

/**
 * Controller-Klasse zum Ausliefern von Javascript-Dateien
 *
 * @category  Kreditrechner
 * @package   Credit
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @abstract
 */
abstract class CalculatorAbstract
{
    protected $_db = null;

    protected $_kreditbetrag = null;

    protected $_laufzeit = null;

    protected $_zweck = null;

    protected $_caid = null;

    protected $_sparte = null;

    protected $_teaseronly = null;

    protected $_bestonly = null;

    protected $_onlyproduct = null;

    protected $_onlyinstitut = null;

    protected $_boni = null;

    protected $_details = null;

    protected $_logger = null;

    /**
     * the class contructor
     *
     * @return \AppCore\Credit\Input\AbstractInput
     */
    public function __construct()
    {
        $this->_db     = \Zend\Db\Table\AbstractTable::getDefaultAdapter();
        $this->_logger = \Zend\Registry::get('log');
    }

    /**
     * calculates the credit results
     *
     * @return array|boolean the result array or FALSE if an error occured
     * @abstract
     */
    public abstract function calculate();

    /**
     * @param integer $laufzeit the value for the variable
     *
     * @return void
     * @access public
     */
    public function setLaufzeit($laufzeit)
    {
        $this->_laufzeit = (int) $laufzeit;

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
     * @param integer $betrag the value for the variable
     *
     * @return void
     * @access public
     */
    public function setKreditbetrag($betrag)
    {
        $this->_kreditbetrag = (int) $betrag;

        return $this;
    }

    /**
     * @return integer
     * @access public
     */
    public function getKreditbetrag()
    {
        return $this->_kreditbetrag;
    }

    /**
     * @param integer $campaignId the new Campaign ID
     *
     * @return void
     * @access public
     */
    public function setCaid($campaignId)
    {
        $this->_caid = (int) $campaignId;

        return $this;
    }

    /**
     * @return integer|string
     * @access public
     */
    public function getCaid()
    {
        return (int) $this->_caid;
    }

    /**
     * @param integer $zweck the value for the variable
     *
     * @return void
     * @access public
     */
    public function setZweck($zweck)
    {
        $this->_zweck = (int) $zweck;

        return $this;
    }

    /**
     * @return integer
     * @access public
     */
    public function getZweck()
    {
        return (int) $this->_zweck;
    }

    /**
     * @param integer $sparte the new sparte
     *
     * @return void
     * @access public
     */
    public function setSparte($sparte)
    {
        $this->_sparte = (int) $sparte;

        return $this;
    }

    /**
     * @return integer
     * @access public
     */
    public function getSparte()
    {
        return (int) $this->_sparte;
    }

    /**
     * @param boolean $teaseronly the value for the variable
     *
     * @return void
     * @access public
     */
    public function setTeaserOnly($teaseronly)
    {
        $this->_teaseronly = (boolean) $teaseronly;

        return $this;
    }

    /**
     * @return boolean
     * @access public
     */
    public function getTeaserOnly()
    {
        return $this->_teaseronly;
    }

    /**
     * @param boolean $bestonly the value for the variable
     *
     * @return void
     * @access public
     */
    public function setBestOnly($bestonly)
    {
        $this->_bestonly = (boolean) $bestonly;

        return $this;
    }

    /**
     * @return boolean
     * @access public
     */
    public function getBestOnly()
    {
        return $this->_bestonly;
    }

    /**
     * @param boolean|null $bestonly the value for the variable
     *
     * @return void
     * @access public
     */
    public function setBoni($boni)
    {
        $this->_boni = $boni;

        return $this;
    }

    /**
     * @return boolean
     * @access public
     */
    public function getBoni()
    {
        return $this->_boni;
    }

    /**
     * @param integer $onlyproduct the product id for the calculation
     *
     * @return void
     * @access public
     */
    public function setOnlyProduct($onlyproduct)
    {
        $this->_onlyproduct = (int) $onlyproduct;

        return $this;
    }

    /**
     * @return integer
     * @access public
     */
    public function getOnlyProduct()
    {
        return $this->_onlyproduct;
    }

    /**
     * @param string $test the value for the variable
     *
     * @return void
     * @access public
     */
    public function setDetails($details)
    {
		$allowedDetails = array(
			'full', 'short', 'id'
		);
		
		if (!is_string($details) || !in_array($details, $allowedDetails)) {
			$details = 'full';
		}
		
        $this->_details = $details;

        return $this;
    }

    /**
     * @return string
     * @access public
     */
    public function getDetails()
    {
        return $this->_details;
    }
}