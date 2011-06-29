<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Credit;

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
class Calculator extends CreditAbstract
{
    /**
     * @var    \Zend\View\View object
     * @access private
     * @deprecated
     */
    private $_view = null;

    /**
     * a flag to tell, that only products with that flag should be calculated,
     * if all products should be calculated, the flag must set to NULL
     *
     * @var    boolean|null
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
        $productsModel  = new \AppCore\Service\Products();
        $activeProducts = $productsModel->getList(
            $this->_sparte, 
            $this->_zweck, 
            false, 
            $this->_onlyProduct
        );

        if (false === $activeProducts      //calculation failed
            || count($activeProducts) == 0 //no result
        ) {
            /*
             * calculation failed or no result
             */
            return array('count' => 0);
        }

        $campaignModel = new \AppCore\Service\Campaigns();
        $campaign      = $campaignModel->find($this->_caid)->current();

        $categoriesModel = new \AppCore\Service\Sparten();
        $sparte          = $categoriesModel->find($this->_sparte)->current();

        if (!is_object($campaign) || !is_object($sparte)) {
            return array('count' => 0);
        }

        // set output and info formater before looping throw the result
        $this->_setOutputFormater()
            ->_setInfoFormater();

        $institutes = array();
        $i          = -1;
        $validCount = 0;

        foreach ($activeProducts as $row) {
            ++$i;
            
            $productId = (int) $row->product;
            
            $institutes[$i] = array(
                'status'    => '',
                'message'   => '',
                'productId' => $productId,
                'product'   => $row->kreditName,
                'institut'  => $row->kreditInstitutTitle
            );
            
            if (!$row->iactive) {
                $institutes[$i]['status']  = 'skipped';
                $institutes[$i]['message'] = 'institute not active';
                
                continue;
            }
            
            if (!$row->sactive) {
                $institutes[$i]['status']  = 'skipped';
                $institutes[$i]['message'] = 'category not active';
                
                continue;
            }
            
            if (!$row->active || !$productsModel->check($productId)) {
                $institutes[$i]['status']  = 'skipped';
                $institutes[$i]['message'] = 'product not active';
                
                continue;
            }
            
            if (!$row->cactive) {
                $institutes[$i]['status']  = 'skipped';
                $institutes[$i]['message'] = 'product component not active';
                
                continue;
            }
            
            $usages = explode(',', $row->usages);

            if (!in_array($this->_zweck, $usages)) {
                $institutes[$i]['status']  = 'skipped';
                $institutes[$i]['message'] = 'product not available in selected category';
                
                continue;
            }
            
            if (null!== $row->min && $this->_betrag < $row->min) {
                $institutes[$i]['status']  = 'skipped';
                $institutes[$i]['message'] = 'kredit amount lower than product minimum amount';
                
                continue;
            }
            
            if (null !== $row->max && $this->_betrag > $row->max) {
                $institutes[$i]['status']  = 'skipped';
                $institutes[$i]['message'] = 'kredit amount greater than product maximum amount';
                
                continue;
            }
            
            $interface = strtolower($productsModel->getInterface($productId));
            
            if (!$interface) {
                $institutes[$i]['status']  = 'skipped';
                $institutes[$i]['message'] = 'no calculation interface for product';
                
                continue;
            }
            
            $interfaceClass = '\\AppCore\\Credit\\Calculator\\' . ucfirst($interface);
            $oInterface     = new $interfaceClass();
            
            $oInterface
                ->setOnlyProduct($productId)
                ->setLaufzeit($this->_laufzeit)
                ->setKreditbetrag($this->_betrag)
                ->setZweck($this->_zweck)
                ->setCaid($this->_caid)
                ->setSparte($this->_sparte)
                ->setTeaserOnly($this->_teaserOnly)
                ->setBestOnly($this->_bestOnly)
                ->setBoni($this->_bonus);
                
            $result = $oInterface->calculate();
            
            if (!is_array($result) || !isset($result[0])) {
                $institutes[$i]['status']  = 'skipped';
                $institutes[$i]['message'] = 'no calaculation result in interface';
                
                continue;
            }
            
            $institutes[$i] = array_merge($institutes[$i], $result[0]);
            
            // active products
            $institutes[$i] = $this->_doCalculation($institutes[$i], $campaign, $sparte, false);
            
            
            $institutes[$i]['status'] = 'ok';
            
            ++$validCount;
        }
        
        $aTrack = array(
            'Antrag',
            'Step',
            '0',
            'Partner',
            $campaign->name,
            'New'
        );

        return array(
            'result'      => $institutes, 
            'activeCount' => $validCount, 
            'fullCount'   => count($institutes)
        );
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
     * @param stdClass                       $row
     * @param array                          $institutes
     * @param \Zend\Db\Table\Row|null         $campaign
     * @param \Zend\Db\Table\Row              $sparte
     *
     * @return array
     */
    private function _doCalculation(
        array $product,
        \Zend\Db\Table\Row $campaign,
        \Zend\Db\Table\Row $sparte,
        $isRecalc = false)
    {
        $kreditinstitut = strtolower($product['kreditinstitut']);

        /*
         * TODO: make it possible to define the picture in the backend
         */
        $companyImageName = HOME_PATH . DS . 'images' . DS . 'gesellschaften'
                          . DS . $kreditinstitut . '.gif';

        //Namen der Klasse anhand des Institutes festlegen
        $resultClass = '\\AppCore\\Service\\CalcResult';
        
        //Result-Klasse erzeugen
        $result = new $resultClass($kreditinstitut);

        $result->bind($product);
        
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
                return $product;
            }
        }

        // look into the campaign and overwrite the product value
        if ($this->_detectInternal($result, $campaign, $isRecalc)) {
            return $institute;
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

        $result->companyPicture = '/images/gesellschaften/' . $kreditinstitut . '.gif';

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
                //the pictures were found
                $result->kreditTestsieger_Pic     = '/images/' . $fileName;
                $result->kreditTestsieger_fullPic = '/images/' . $fileNameFull;
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
        return $result->toArray();
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
            $this->_bonus = (boolean) $bonus;
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
     * @param \AppCore\Service\CalcResult $result
     * @param \Zend\Db\Table\Row          $campaign
     * @param boolean                     $isRecalc
     *
     * @return boolean if TRUE, the product is NOT allowed in the actual result
     */
    private function _detectInternal(
        \AppCore\Service\CalcResult $result,
        \Zend\Db\Table\Row $campaign,
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
        $formater = new Output($this->_mode);
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
        $formater = new Info();
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
    private function _filterProduct(\Zend\Db\Table\Row $row)
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
     * @param \Zend\Db\Table\Row          $campaign the actual campaign
     * @param \AppCore\Service\CalcResult $result   the current dataset
     *
     * @return \AppCore\Credit\Calc
     */
    private function _parseInfo(
        \Zend\Db\Table\Row $campaign, \AppCore\Service\CalcResult $result)
    {
        if ('no' == $campaign->loadInfo) {
            $result->info = $this->_infoFormater->info(false);
        } else {
            /*
             * the product information is not loaded from database
             * -> load it now (maybe from a template)
             */
            $this->_infoFormater->setProduct($result->product);

            $result->info = $this->_infoFormater->info(
                true, (boolean) $result->infoAvailable
            );

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