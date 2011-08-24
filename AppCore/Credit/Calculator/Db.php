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
 * @version   SVN: $Id: Input.php 24 2011-02-01 20:55:24Z tmu $
 */

/**
 * Controller-Klasse zum Ausliefern von Javascript-Dateien
 *
 * @category  Kreditrechner
 * @package   Credit
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class Db extends CalculatorAbstract
{
    CONST SP = 0;
    CONST FALLBACK = 1;

    private $_mode = self::FALLBACK;

    private $_cache = null;

    /**
     * @param integer $mode the new mode for calculation
     *
     * @return void
     * @access public
     */
    public function setMode($mode = self::FALLBACK)
    {
        switch ((int) $mode) {
            case self::SP:
                // Break intentionally omitted
            case self::FALLBACK:
                // do nothing here
                break;
            default:
                //Fallback mode
                $mode = self::FALLBACK;
                break;
        }

        $this->_mode = $mode;

        return $this;
    }

    /**
     * calculates the credit results using a stored procedure
     *
     * @return array|boolean the result array or FALSE if an error occured
     * @access public
     */
    public function calculate()
    {
        $laufzeit = $this->getLaufzeit();
        $betrag   = $this->getKreditbetrag();
        $caid     = $this->getCaid();
        $sparte   = $this->getSparte();
        $teaser   = $this->getTeaserOnly();
        $product  = $this->getOnlyProduct();
        $zweck    = $this->getZweck();
        $boni     = $this->getBoni();
        $best     = $this->getBestOnly();

        $cacheParams = array(
            (($this->_mode) ? 'FALLBACK' : 'SP'),
            (int) $laufzeit,
            (int) $betrag,
            (int) $caid,
            (int) $sparte,
            (int) $teaser,
            (($product != '') ? str_replace(array(',', ' '), 'x', $product) : 'x'),
            (int) $zweck,
            (($boni !== null) ? (int) $boni : 'x'),
            (int) $best
        );
        
        
        $front   = \Zend\Controller\Front::getInstance();
        $manager = $front->getParam('bootstrap')->getResource('cachemanager');
        $cache   = $manager->getCache('calc');
        $cacheId = 'calcResult_' . implode('_', $cacheParams);
        
        $hasResult = false;
        
        $result = $cache->load($cacheId);
        if (is_array($result)/* && count($result)*/) {
            $hasResult = true;
        }
        
        if (!$hasResult) {
            switch ($this->_mode) {
                case self::SP:
                    /*
                     * default mode (stored procedures)
                     * not active at the moment (11.11.2010 thm)
                     */
                    $calculator = new \AppCore\Credit\Calculator\Db\Sp();
                    break;
                case self::FALLBACK:
                    // Break intentionally omitted
                default:
                    //Fallback mode
                    $calculator = new \AppCore\Credit\Calculator\Db\Fallback();
                    break;
            }
            
            $calculator
                ->setLaufzeit($laufzeit)
                ->setKreditbetrag($betrag)
                ->setCaid($caid)
                ->setSparte($sparte)
                ->setTeaserOnly($teaser)
                ->setBestOnly($best)
                ->setOnlyProduct($product)
                ->setZweck($zweck)
                ->setBoni($boni);

            //var_dump('calculator called');
            $result = $calculator->calculate();

            $cache->save($result, $cacheId);
        }
        
        //var_dump($cacheId, count($result));

        return $result;
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

        $model  = new \AppCore\Model\Products();
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
                'teaserZone'              => 'ttp.teaser_zone',
                'portal'                  => 'ttp.portal',
                'infoAvailable'           => 'ttp.infoAvailable',
                'info'                    => new \Zend\Db\Expr('NULL')
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

        return $model->fetchAll($select)->toArray();
    }

    /**
     * select all rows from the temporary table which is used for the
     * calculation
     *
     * @return array
     */
    protected function getRowsCount()
    {
        $model  = new \AppCore\Model\Products();
        $select = $model->select()->setIntegrityCheck(false);
        $select->from(
            array('ttp' => '__tmp_table_products'),
            array('count' => new \Zend\Db\Expr('COUNT(*)'))
        );

        return $model->fetchAll($select)->current()->count;
    }
}