<?php
/**
 * Klasse für Kredit-Anfragen (Berechnungen)
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
 * Klasse für Kredit-Anfragen (Berechnungen)
 *
 * @category  Kreditrechner
 * @package   Credit
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class \AppCore\Credit\Calc extends \AppCore\Credit\CreditAbstract
{
    /**
     * @var    \Zend\View\View object
     * @access private
     * @deprecated
     */
    private $_view = null;

    /**
     * ??
     * @var    boolean
     * @access private
     */
    private $_bonus = null;

    /**
     * Name of an institut, if only one should be calculated
     * @var    string
     * @access private
     */
    private $_onlyInstitut = '';

    /**
     * Number of an Product, if only one should be calculated
     * @var    integer
     * @access private
     */
    private $_onlyProduct = 0;

    /**
     *
     * @var    int (boolean)
     * @access private
     */
    private $_bestOnly = 0;

    /**
     * @var    int (boolean)
     * @access private
     */
    private $_teaserOnly = 0;

    private $_outputFormater = null;
    private $_infoFormater   = null;

    /**
     * calculates the credit
     *
     * @param boolean $doLog  IF TRUE, the request will be logged
     *
     * @access public
     * @return void
     */
    public function calc($isRecalc = false)
    {
        $activeProducts = $this->_calc();

        if (false === $activeProducts      //calculation failed
            || count($activeProducts) == 0 //no result
        ) {
            /*
             * calculation failed or no result
             */
            return array();
        }

        $campaignModel = new \AppCore\Service\Campaigns();
        $campaign      = $campaignModel->find($this->_caid)->current();

        $categoriesModel = new \AppCore\Service\Sparten();
        $sparte       = $categoriesModel->find($this->_sparte)->current();

        //var_dump(count($activeProducts->toArray()));

        if (!is_object($campaign) || !is_object($sparte)) {
            return array();
        }

        // set output and info formater before looping throw the result
        $this->_setOutputFormater()
            ->_setInfoFormater();

        $institutes = array();

        foreach ($activeProducts as $row) {
            //teaser only, ignore others
            if ($this->_teaserOnly && !$row->teaser) {
                //var_dump('no teaser');
                continue;
            }

            /*
             * filter for a specific product/institute, if flags are set
             */
            if ($this->_filterProduct($row)) {
                //var_dump('wrong institute/product');
                continue;
            }

            $institutes = $this->_doCalculation(
                $row, $institutes, $campaign, $sparte, $isRecalc
            );
        }

        //var_dump($institutes);

        $aTrack = array(
            'Antrag',
            'Step',
            '0',
            'Partner',
            $campaign->name,
            'New'
        );

        return $institutes;
    }

    /**
     * do the calculation with the input adapter
     *
     * @return array
     */
    private function _calc()
    {
        $activeProducts = false;

        $calculator = new KreditCore_Class_Credit_Input();
        $calculator
            ->setLaufzeit($this->_laufzeit)
            ->setKreditbetrag($this->_betrag)
            ->setZweck($this->_zweck)
            ->setCaid($this->_caid)
            ->setSparte($this->_sparte)
            ->setTeaserOnly($this->_teaserOnly)
            ->setBestOnly($this->_bestOnly)
            ->setBoni($this->_bonus)
            ->setMode(KreditCore_Class_Credit_Input::FALLBACK);

        if ($this->_onlyProduct) {
            $calculator->setOnlyProduct($this->_onlyProduct);
        } elseif ($this->_onlyInstitut) {
            $calculator->setOnlyInstitut($this->_onlyInstitut);
        }

        /*
         * deactivated
         * SQL for Stored Procedure needs to be updated
         */
        $activeProducts = $calculator->calculate();
        //var_dump(count($activeProducts->toArray()));

        /*
        if (false === $activeProducts) {
            $calculator->setMode(KreditCore_Class_Credit_Input::FALLBACK);

            $activeProducts = $calculator->calculate();
        }
        */

        return $activeProducts;
    }

    /**
     * @param stdClass                       $row
     * @param array                          $institutes
     * @param Zend_Db_Table_Row|null         $campaign
     * @param Zend_Db_Table_Row              $sparte
     *
     * @return array
     */
    private function _doCalculation(
        Zend_Db_Table_Row $row,
        array $institutes,
        Zend_Db_Table_Row $campaign,
        Zend_Db_Table_Row $sparte,
        $isRecalc = false)
    {
        $kreditinstitut = strtolower($row->kreditinstitut);
        $key            = $kreditinstitut . $row->product;

        if (isset($institutes[$key])) {
            return $institutes;
        }

        /*
         * TODO: make it possible to define the picture in the backend
         */
        $companyImageName = HOME_PATH . DS . 'images' . DS . 'gesellschaften'
                          . DS . $kreditinstitut . '.gif';

        //Namen der Klasse anhand des Institutes festlegen
        $klasse = '\AppCore\Model\CalcResult_' . ucfirst($kreditinstitut);

        //Result-Klasse erzeugen
        $result = new $klasse();

        $result->bind($row);

        /*
         * validate result only, if this is not a recalculation
         */
        if (!$isRecalc) {
            /*
             * Gesellschaft nur anzeigen, wenn Ergebnis valid ist (nur
             * wichtig bei Targobank)
             * und wenn ein Company-Logo existiert
             */
            if (!$result->isValid()
                || !file_exists($companyImageName)
            ) {
                return $institutes;
            }
        }

        // look into the campaign and overwrite the product value
        if ($this->_detectInternal($result, $campaign, $isRecalc)) {
            return $institutes;
        }

        if ($result->effZins != $result->effZinsUnten
            || $result->effZins != $result->effZinsOben
        ) {
            /*
             * Zinsband definiert
             * $result->effZins ignorieren
             * TODO: prüfen, ob Minimalwert mit $recult->effZins
             *        bereinstimmt, und ggf. Zinsbeträge nachrechnen
             */
            $minZins = min($result->effZinsUnten, $result->effZinsOben);
            $maxZins = max($result->effZinsUnten, $result->effZinsOben);

            $result->effZinsUnten = $minZins;
            $result->effZinsOben  = $maxZins;
        }

        $result->companyPicture = \Zend\Registry::get('_imageUrlRoot')
                                . 'gesellschaften/' . $kreditinstitut . '.gif';

        $bearbeitungsGebuehr         = 0;
        $result->bearbeitungsGebuehr = $bearbeitungsGebuehr;
        $result->kreditbetrag        = $this->_betrag
                                     + $bearbeitungsGebuehr;
        $result->laufzeit            = $this->_laufzeit;
        $result->vzweck              = $this->_zweck;
        $result->zinsen              = $result->kreditKosten
                                     - $bearbeitungsGebuehr;

        // set product specific values
        $this->_outputFormater
            ->setOnlyProduct($result->product)
            ->setInstitut($result->kreditinstitut)
            ->setProduct($result->product)
            ->setTeaser($result->teaser)
            ->setInternal($result->internal);

        //get parameters for the credit request
        $this->_outputFormater->getAntragsParams($result)

        //create the link for the offer
            ->getOfferLink($result)

        //get parameters for the product info
            ->getInfoParams($result)

        //create links for the product info
            ->getInfoLink($result);

        //$this->_logger->info($result->offerLnk);

        if ($result->kreditTestsieger) {
            /*
             * is a Testsieger
             * -> take picture, if available
             *
             * TODO: make it possible to define the pictures in the
             * backend
             * Reason: BMW has 2 institutes with different pictures
             */
            $fileName     = 'testsieger/' . strtolower($sparte->name)
                          . '/' . $kreditinstitut . '.gif';
            $fileNameFull = 'testsieger/' . strtolower($sparte->name)
                          . '/' . $kreditinstitut . '_full.gif';
            $filePath     = HOME_PATH . DS . 'images' . DS . $fileName;
            $filePathFull = HOME_PATH . DS . 'images' . DS . $fileNameFull;

            if (file_exists($filePath)
                && file_exists($filePathFull)
            ) {
                //image root path
                $irp = \Zend\Registry::get('_imageUrlRoot');

                //the pictures were found
                $result->kreditTestsieger_Pic     = $irp . $fileName;
                $result->kreditTestsieger_fullPic = $irp . $fileNameFull;
            } else {
                /*
                 * the pictures were not found
                 * -> reset the testsieger flag
                 */
                $result->kreditTestsieger_Pic     = '';
                $result->kreditTestsieger_fullPic = '';
                $result->kreditTestsieger         = false;
            }
        }

        $this->_parseInfo($campaign, $result);

        if ($result->pixel) {
            $protocol = \Zend\Registry::get('_protocol');

            if (strpos('###PROTOKOLL###', $result->pixel) !== false) {
                //Url für Pixel anpassen, da Code gesetzt
                $result->pixel = str_replace(
                    '###PROTOKOLL###', $protocol, $result->pixel
                );
            } elseif ('https://' == $protocol) {
                //Url für Pixel anpassen, wenn SSL
                $result->pixel = str_replace(
                    'http://', 'https://', $result->pixel
                );
            }
        }

        //Produkt in das Ergebnis übernehmen
        $institutes[$key] = $result;

        return $institutes;
    }

    /**
     * @param \Zend\View\View $view an view object
     *
     * @return void
     * @access public
     */
    public function setView(\Zend\View\View $view)
    {
        $this->_view = clone $view;

        return $this;
    }

    /**
     * @param boolean $bonus the value for the variable
     *
     * @return void
     * @access public
     */
    public function setBonus($bonus)
    {
        if (null !== $bonus) {
            $this->_bonus = (int) $bonus;
        } else {
            $this->_bonus = null;
        }

        return $this;
    }

    /**
     * @param boolean $value the value for the variable
     *
     * @return void
     * @access public
     */
    public function setBestOnly($value)
    {
        $this->_bestOnly = (boolean) $value;

        return $this;
    }

    /**
     * @param boolean $value the value for the variable
     *
     * @return void
     * @access public
     */
    public function setTeaserOnly($value)
    {
        $this->_teaserOnly = (boolean) $value;

        return $this;
    }

    /**
     * @param integer|string $value the product id for the calculation
     *
     * @return void
     * @access public
     */
    public function setOnlyProduct($value)
    {
        $this->_onlyProduct = $value;

        return $this;
    }

    /**
     * @param string $value the value for the variable
     *
     * @return void
     * @access public
     */
    public function setOnlyInstitut($value)
    {
        $this->_onlyInstitut = $value;

        return $this;
    }

    /**
     * detect if the link target is internal or external from the campaign
     *
     * @param \AppCore\Model\CalcResult $result
     * @param Zend_Db_Table_Row           $campaign
     * @param boolean                     $isRecalc
     *
     * @return boolean if TRUE, the product is NOT allowed in the actual result
     */
    private function _detectInternal(
        \AppCore\Model\CalcResult $result,
        Zend_Db_Table_Row $campaign,
        $isRecalc = false)
    {
        /*
         * default value for $campaign->externalLinks is 'auto'
         * with this value $result->internal is not overwritten
         */
        if ($campaign->externalLinks == 'intern') {
            /*
             * in the campaign, all links should point to the
             * own internal form
             */
            $result->internal = 1;
        } elseif ($campaign->externalLinks == 'extern') {
            /*
             * in the campaign, all link should point to the site
             * from the institute
             */
            $result->internal = 0;
        }

        /*
         * this is a recalculation
         * -> a check, if the institute can be internal or external is not
         * needed
         */
        if ($isRecalc) {
            return false;
        }

        if ($result->internal) {
            /*
             * check if it is possible and allowed for the institute
             * to show the unister forms
             */
            if (!$result->canInternal()) {
                return true;
            }
        } else {
            /*
             * check if it is possible and allowed for the institute
             * to show institute site
             */
            if (!$result->canExternal()) {
                return true;
            }
        }

        return false;
    }

    /**
     * creates a Output Formater to the the product information and
     * sets global values (which do not change in this calculation) to it
     *
     * @return \AppCore\Credit\Calc
     */
    private function _setOutputFormater()
    {
        $formater = new \AppCore\Credit\Output($this->_mode);
        $formater
            ->setLaufzeit($this->_laufzeit)
            ->setKreditbetrag($this->_betrag)
            ->setZweck($this->_zweck)
            ->setCaid($this->_caid)
            ->setSparte($this->_sparte)
            ->setTeaserOnly($this->_teaserOnly)
            ->setBestOnly($this->_bestOnly)
            ->setTest($this->_test);

        $this->_outputFormater = $formater;

        return $this;
    }

    /**
     * creates a Info Formater to the the product information and
     * sets global values (which do not change in this calculation) to it
     *
     * @return \AppCore\Credit\Calc
     */
    private function _setInfoFormater()
    {
        $formater = new KreditCore_Class_Credit_Info();
        $formater
            ->setLaufzeit($this->_laufzeit)
            ->setMode($this->_mode)
            ->setSparte($this->_sparte);

        if (is_object($this->_view)) {
            $formater->setView($this->_view);
        }

        $this->_infoFormater = $formater;

        return $this;
    }

    /**
     * if the onlyProduct or the onlyInstitute flag are set, this function
     * checks, if the actual dataset is affected
     *
     * @param stdClass $row the actual dataset
     *
     * @return boolean
     */
    private function _filterProduct(Zend_Db_Table_Row $row)
    {
        /*
         * filter for a specific product/institute, if flags are set
         */
        if ($this->_onlyProduct) {
            if (!is_array($this->_onlyProduct)
                && false !== strpos($this->_onlyProduct, ',', 0)
            ) {
                $this->_onlyProduct = explode(',', $this->_onlyProduct);
            }

            if (is_array($this->_onlyProduct)
                && !in_array($row->product, $this->_onlyProduct)
            ) {
                return true;
            } elseif (!is_array($this->_onlyProduct)
                && $row->product != $this->_onlyProduct
            ) {
                return true;
            }
        } elseif ($this->_onlyInstitut) {
            if ($row->kreditinstitut != $this->_onlyInstitut) {
                return true;
            }
        }

        return false;
    }

    /**
     * gets the product information and parses it
     *
     * @param Zend_Db_Table_Row           $campaign the actual campaign
     * @param \AppCore\Model\CalcResult $result   the current dataset
     *
     * @return \AppCore\Credit\Calc
     */
    private function _parseInfo(
        Zend_Db_Table_Row $campaign, \AppCore\Model\CalcResult $result)
    {
        if ('no' == $campaign->loadInfo) {
            $result->info = $this->_infoFormater->info(false);
        } else {
            if (!$result->info) {
                /*
                 * the product information is not loaded from database
                 * -> load it now (maybe from a template)
                 */
                $this->_infoFormater->setProduct($result->product);

                $result->info = $this->_infoFormater->info(
                    true, (boolean) $result->infoAvailable
                );
            }

            //replace the placeholders
            $result->info = str_replace(
                array('###min###', '###max###', '###zins###'),
                array(
                    number_format($result->min, 2, ',', '.'),
                    number_format($result->max, 2, ',', '.'),
                    number_format($result->effZins, 2, ',', '.')
                ),
                $result->info
            );
        }

        return $this;
    }
}