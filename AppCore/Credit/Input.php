<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Credit;

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
 */
class Input extends Input\InputAbstract
{
    CONST SP = 0;
    CONST FALLBACK = 1;

    private $_mode = 0;

    private $_cache = null;
    
    private $_config = null;

    /**
     * Konstruktor
     *
     * @return void
     * @access public
     */
    public function __construct()
    {
        parent::__construct();
        $this->_config = new \Zend\Config\Config($this->getActionController()->getInvokeArg('bootstrap')->getOptions());

        if ($config->calccache->enable) {
            $this->_cache = \Zend\Cache\Cache::factory(
                $config->calccache->frontend,
                $config->calccache->backend,
                $config->calccache->front->toArray(),
                $config->calccache->back->toArray()
            );
        }
    }

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
        $institut = $this->getOnlyInstitut();
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
            (($institut != '') ? $institut : 'x'),
            (int) $zweck,
            (($boni !== null) ? (int) $boni : 'x'),
            (int) $best
        );

        $cacheId = 'calcResult_' . implode('_', $cacheParams);

        /*
         * the servers using the database on DB24 where the stored procedure
         * exists
         */
        $liveServers = array(
            SERVER_ONLINE_STAGING,
            SERVER_ONLINE_LIVE,
            SERVER_ONLINE_LIVE14,
            SERVER_ONLINE_LIVE47,
            SERVER_ONLINE_LIVE57,
            SERVER_ONLINE_LIVE_F1,
            SERVER_ONLINE_LIVE_F2,
            SERVER_ADMIN
        );

        //if (!is_object($this->_cache)
        //    || !$result = $this->_cache->load($cacheId)
        //) {
            /*
             * the stored procedure does exist only on the live servers
             * -> replace with fallback mode to prevent errors
             */
            if (!in_array(APPLICATION_ENV, $liveServers)) {
                $this->_mode = self::FALLBACK;
            }

            switch ($this->_mode) {
                case self::SP:
                    /*
                     * default mode (stored procedures)
                     * not active at the moment (11.11.2010 thm)
                     */
                    $calculator = new \AppCore\Credit\Input\Sp();
                    break;
                case self::FALLBACK:
                    // Break intentionally omitted
                default:
                    //Fallback mode
                    $calculator = new \AppCore\Credit\Input\Fallback();
                    break;
            }
            
            //var_dump('cc', $caid);

            $calculator
                ->setLaufzeit($laufzeit)
                ->setKreditbetrag($betrag)
                ->setCaid($caid)
                ->setPaid($this->getPaid())
                ->setSparte($sparte)
                ->setSparteName($this->getSparteName())
                ->setTeaserOnly($teaser)
                ->setBestOnly($best)
                ->setOnlyProduct($product)
                ->setOnlyInstitut($institut)
                ->setZweck($zweck)
                ->setBoni($boni);

            $result = $calculator->calculate();

            //if (is_object($this->_cache)) {
            //    $this->_cache->save($result, $cacheId);
            //}
        //}

        return $result;
    }
}