<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Credit\Input;

/**
 * Controller-Klasse zum Ausliefern von Javascript-Dateien
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Credit
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id$
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
abstract class InputAbstract
{
    protected $_db = null;

    protected $_kreditbetrag = null;

    protected $_laufzeit = null;

    protected $_zweck = null;

    protected $_caid = null;

    protected $_paid = null;

    protected $_sparte = null;

    protected $_sparteName = null;

    protected $_teaseronly = null;

    protected $_bestonly = null;

    protected $_onlyproduct = null;

    protected $_onlyinstitut = null;

    protected $_boni = null;

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
     * @access public
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
    {//var_dump('yy', $campaignId);
        $campaignModel = new \AppCore\Service\Campaigns();
        $this->_caid   = $campaignModel->getId($campaignId);

        if (false !== $this->_caid) {
            $portal = $campaignModel->getPortal($campaignId);

            if (is_object($portal)) {
                $this->setPaid($portal->p_id);
            } else {
                $this->setPaid(null);
            }
        }

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
     * @param integer|string $paid the value for the variable
     *
     * @return void
     * @access public
     */
    public function setPaid($paid)
    {
        $this->_paid = $paid;

        return $this;
    }

    /**
     * @return integer|string
     * @access public
     */
    public function getPaid()
    {
        return (int) $this->_paid;
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
        $this->_sparte = $sparte;

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
     * @param integer|string $sparteName the new sparte
     *
     * @return void
     * @access public
     */
    public function setSparteName($sparteName)
    {
        $this->_sparteName = $sparteName;

        return $this;
    }

    /**
     * @return integer|string
     * @access public
     */
    public function getSparteName()
    {
        return $this->_sparteName;
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
     * @param boolean $bestonly the value for the variable
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
     * @param integer|string $onlyproduct the product id for the calculation
     *
     * @return void
     * @access public
     */
    public function setOnlyProduct($onlyproduct)
    {
        if (is_object($onlyproduct)) {
            throw new Exception(
                'setOnlyProduct($onlyproduct) requires Interger input'
            );
        }

        $this->_onlyproduct = $onlyproduct;

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
     * @param string $onlyinstitut the value for the variable
     *
     * @return void
     * @access public
     */
    public function setOnlyInstitut($onlyinstitut)
    {
        $this->_onlyinstitut = (string) $onlyinstitut;

        return $this;
    }

    /**
     * @return string
     * @access public
     */
    public function getOnlyInstitut()
    {
        return $this->_onlyinstitut;
    }

    /**
     * select all rows from the temporary table which is used for the
     * calculation
     *
     * @return array
     */
    protected function getRows()
    {
        $effZinsCondition = 'CASE
                   WHEN `ttp`.`boni` = 0 THEN `ttp`.`effZins`
                   WHEN `ttp`.`zinssatzIsCleaned`>0 THEN `ttp`.`zinssatzCleaned`
                   WHEN `ttp`.`showAb` > 0          THEN `ttp`.`effZins`
                   WHEN `ttp`.`effZinsOben` > `ttp`.`effZinsUnten` THEN
                           `ttp`.`effZinsUnten`
                   ELSE `ttp`.`effZins` END';

        $model  = new \AppCore\Model\Produkte();
        $select = $model->select()->setIntegrityCheck(false);
        $select->from(
            array('ttp' => '__tmp_table_products'),
            array(
                'uid'                     => 'ttp.uid',
                'kreditInstitutTitle'     => 'ttp.kreditInstitutTitle',
                'kreditinstitut'          => 'ttp.kreditinstitut',
                'product'                 => 'ttp.product',
                'kreditName'              => 'ttp.kreditName',
                'kreditAnnahme'           => 'ttp.kreditAnnahme',
                'kreditTestsieger'        => 'ttp.kreditTestsieger',
                'kreditEntscheidung'      => 'ttp.kreditEntscheidung',
                'kreditEntscheidung_Sort' => 'ttp.kreditEntscheidung_Sort',
                'boni'                    => 'ttp.boni',
                'ordering'                => 'ttp.ordering',
                'zinsgutschrift'          => 'ttp.zinsgutschrift',
                'anlagezeitraum'          => 'ttp.anlagezeitraum',
                'ecgeb'                   => 'ttp.ecgeb',
                'kreditkartengeb'         => 'ttp.kreditkartengeb',
                'kontofuehrung'           => 'ttp.kontofuehrung',
                'effZins'                 => new \Zend\Db\Expr(
                    $effZinsCondition
                ),
                'effZinsOben'             => 'ttp.effZinsOben',
                'effZinsUnten'            => 'ttp.effZinsUnten',
                'zinssatzCleaned'         => 'ttp.zinssatzCleaned',
                'zinssatzIsCleaned'       => 'ttp.zinssatzIsCleaned',
                'effZinsN'                => 'ttp.effZinsN',
                'effZinsR'                => 'ttp.effZinsR',
                'showAb'                  => 'ttp.showAb',
                'step'                    => 'ttp.step',
                'min'                     => 'ttp.min',
                'max'                     => 'ttp.max',
                'monatlicheRate'          => 'ttp.monatlicheRate',
                'gesamtKreditbetrag'      => 'ttp.gesamtKreditbetrag',
                'kreditKosten'            => 'ttp.kreditKosten',
                'kostenErsterMonat'       => 'ttp.kostenErsterMonat',
                'internal'                => 'ttp.internal',
                'url'                     => 'ttp.url',
                'pixel'                   => 'ttp.pixel',
                'teaser'                  => 'ttp.teaser',
                'teaser_zone'             => 'ttp.teaser_zone',
                'portal'                  => 'ttp.portal',
                'infoAvailable'           => 'ttp.infoAvailable'
            )
        );

        $select->joinLeft(
            array('p' => 'produkte'),
            '`ttp`.`product` = `p`.`kp_id`',
            array(
                // Produktinformation
                'info' => new \Zend\Db\Expr('IFNULL(`p`.`kp_info`, \'\')')
            )
        );

        $order = array();

        if (!$this->_bestonly) {
            $order[] = new \Zend\Db\Expr('`ttp`.`teaser` DESC');
        }

        $order[] = new \Zend\Db\Expr(
            $effZinsCondition . ($this->_sparte == 1 ? '' : ' DESC')
        );

        $order[] = 'ttp.ordering';
        $order[] = new \Zend\Db\Expr('`ttp`.`portal` DESC');
        $order[] = 'ttp.kreditInstitutTitle';

        $select->order($order);

        return $model->fetchAll($select);
    }
}