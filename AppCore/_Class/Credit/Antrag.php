<?php
/**
 * Klasse fuer Kredit-Antr�ge
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
 * Klasse fuer Kredit-Antr?ge
 *
 * @category  Kreditrechner
 * @package   Credit
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class \AppCore\Credit\Antrag extends \AppCore\Credit\CreditAbstract
{
    /**
     * @var    string
     * @access private
     */
    private $_step = 1;

    /**
     * @var    integer
     * @access private
     */
    private $_product = '';

    /**
     * @var    string
     * @access private
     */
    private $_sex = '';

    /**
     * @var    string
     * @access private
     */
    private $_title = '';

    /**
     * @var    string
     * @access private
     */
    private $_firstName = '';

    /**
     * @var    string
     * @access private
     */
    private $_surName = '';

    /**
     * @var    string
     * @access private
     */
    private $_postcode = '';

    /**
     * @var    string
     * @access private
     */
    private $_city = '';

    /**
     * @var    string
     * @access private
     */
    private $_email = '';

    /**
     * @var    string
     * @access private
     */
    private $_street = '';

    /**
     * @var    string
     * @access private
     */
    private $_housenumber = '';


    private $_phonePrefix = '';
    private $_phone = '';
    private $_mobilePrefix = '';
    private $_mobile = '';
    private $_birthDay = 0;
    private $_birthMonth = 0;
    private $_birthYear = 0;
    private $_familyState = 'unknown';
    private $_country = '';
    private $_profession = '';
    private $_schufaOk = 0;
    private $_contactOk = 0;
    private $_agbOk = 0;
    private $_threeMonths = 0;
    private $_firstTimeOver = 0;
    private $_view = null;
    private $_ip = '';
    private $_income = 0;
    private $_anzahl = 0;
    private $_boniLevel = 'medium';

    private $_requestData = array();

    /**
     * method to create a Credit Form
     *
     * @param \Zend\View\View $this->_view an View object
     *
     * @access public
     * @return \Zend\View\View
     */
    public function normalform()
    {
        $requestData = $this->_requestData;

        $this->_view->alleLaufzeiten   = $this->_getLaufzeitList();
        $this->_view->aktuelleLaufzeit = $this->_laufzeit;
        $this->_view->alleZwecke       = $this->_getUsageList();
        $this->_view->aktuellerZweck   = $this->_zweck;
        $this->_view->aktuellerBetrag  = $this->_betrag;

        $this->_view->sparte = strtolower($this->_sparte);
        $this->_view->caid   = strtolower($this->_caid);
        //$this->_view->paid   = strtolower($this->_paid);
        $this->_view->mode   = strtolower($this->_mode);

        unset($requestData['Agent']);
        unset($requestData['agent']);
        unset($requestData['laufzeit']);
        unset($requestData['vzweck']);
        unset($requestData['kreditbetrag']);
        unset($requestData['target']);
        unset($requestData['screen_wide']);
        unset($requestData['screen_height']);
        unset($requestData['submit']);

        $name   = 'creditCalc';
        $this->_view->formName = $name;

        if ($this->_mode == 'html') {
            $this->_view->action = 'javascript:void(0);';
            $this->_view->submit = '';
        } elseif ($this->_mode == 'js') {
            $this->_view->action = 'javascript:void(0);';//$action;
            $this->_view->submit = 'var u=document.getElementById('
            . "'vzweck'"
            . ').value;var t=document.getElementById('
            . "'laufzeit'"
            . ').value;var a=document.getElementById('
            . "'kreditbetrag'"
            . ').value;calc(u, t, a);';
        } else {
            $this->_view->action = '';
            $this->_view->submit = '';
        }

        $this->_view->requestData = $requestData;//$requestData;

        return $this->_view;
    }

    /**
     * method to create a Credit Form
     *
     * @param \Zend\View\View $this->_view an view object
     *
     * @access public
     * @return \Zend\View\View
     */
    public function mini()
    {
        $this->_view->sparte = strtolower($this->_sparte);
        $this->_view->caid   = strtolower($this->_caid);
        //$this->_view->paid   = strtolower($this->_paid);
        $this->_view->mode   = strtolower($this->_mode);

        return $this->_view;
    }

    /**
     * displays kredit request
     *
     * @param \Zend\View\View &$this->_view an view object
     *
     * @return array
     * @access public
     */
    public function antrag()
    {
        $data       = array();
        $data['ok'] = false;

        $institut   = null;
        $sparteName = null;

        $modelProducts = new \AppCore\Service\Products();
        if (!$this->_product
            || !$modelProducts->lade($this->_product, $institut, $sparteName)
        ) {
            $data['reason'] = 'product not available';

            return $data;
        }

        //the Institute was not found
        if (!$institut) {
            $data['reason'] = 'institute not active';

            return $data;
        }

        $product = $modelProducts->find($this->_product)->current();
        $usages  = explode(',', $product->usages);
        if (!in_array($this->_zweck, $usages)) {
            //product is not available for the selected useage
            $data['reason'] = 'wrong usage';

            return $data;
        }

        $data['kreditResult'] = array();
        $data['file']         = '';
        $data['product']      = $this->_product;
        $data['sparte']       = $sparteName;

        $data['kreditResult'] = array();

        $key          = $institut . $this->_product;
        $data['key']  = $key;

        //Kredit-Daten neu berechnen
        $usages     = $this->_getUsageList();
        $laufzeiten = $this->_getLaufzeitList();
        $laufzeit   = number_format($this->_laufzeit, 1);

        if ($this->_betrag >= KREDIT_BETRAG_MIN
            && $this->_betrag <= KREDIT_BETRAG_MAX
            && array_key_exists($this->_zweck, $usages)
            && array_key_exists($laufzeit, $laufzeiten)
        ) {
            $calculator = new \AppCore\Credit\Calc();
            $calculator
                ->setCaid($this->_caid)
                ->setSparte($this->_sparte)
                ->setLaufzeit($this->_laufzeit)
                ->setZweck($this->_zweck)
                ->setKreditbetrag($this->_betrag)
                ->setMode($this->_mode)
                ->setOnlyProduct($this->_product)
                ->setOnlyInstitut($institut);
            $data['kreditResult'] = $calculator->calc(true);
        }

        if (!isset($data['kreditResult'][$key])
            || !($data['kreditResult'][$key]
                instanceof \AppCore\Service\CalcResult)
        ) {
            $data['reason'] = 'recalculation failed';

            return $data;
        }

        $url = $data['kreditResult'][$key]->offerLnk;

        /*
         * no URL found
         * maybe the product is not active in the actual campaign
         */
        if (!$url) {
            $data['reason'] = 'no URL found';

            return $data;
        }

        $zins = $data['kreditResult'][$key]->effZins;

        /*
         * no Zins found
         * maybe the product is not active in the actual timerange/amount
         */
        if (!$zins) {
            $data['reason'] = 'no Zins found';

            return $data;
        }

        //used for mapping for portalservice
        $data['berufsgruppe'] = \AppCore\Globals::getBerufsgruppe();

        $data['zins']    = $zins;
        $data['min']     = $data['kreditResult'][$key]->min;
        $data['max']     = $data['kreditResult'][$key]->max;
        $data['rate']    = $data['kreditResult'][$key]->monatlicheRate;
        $data['prozent'] = $this->_view->getZins($data['kreditResult'][$key]);

        $data['institut']     = $institut;
        $data['kreditbetrag'] = $this->_betrag;
        $data['laufzeit']     = $this->_laufzeit;
        $data['zweck']        = $this->_zweck;
        $data['requestData']  = $this->_requestData;

        if (isset($this->_requestData['creditLine'])
            && $this->_requestData['creditLine']
        ) {
            $data['creditLine'] = $this->_requestData['creditLine'];
        } else {
            //get the type of credit line
                    $campaignModel      = new \AppCore\Model\Campaigns();
            $data['creditLine'] = $campaignModel->getLine($this->_caid);
        }

        /*
         * map different requestdata
         */
        $this->_mapSex();
        $this->_mapTitle();
        $this->_mapSurname();
        $this->_mapFirstname();
        $this->_mapEmail();
        $this->_mapPostcode();
        $this->_mapCity();
        $this->_mapStreet();
        $this->_mapHouseNumber();
        $this->_mapPhone();
        $this->_mapPhonePrefix();
        $this->_mapMobile();
        $this->_mapMobilePrefix();
        $this->_mapBirthDay();
        $this->_mapBirthMonth();
        $this->_mapBirthYear();
        $this->_mapFamilyState();
        $this->_mapCountry();
        $this->_mapProfession();
        $this->_mapAgb();
        $this->_mapContact();
        $this->_mapSchufa();
        $this->_mapFirstTime();
        $this->_mapThreeMonths();
        $this->_mapIncome();
        $this->_mapAnzahl();
        $this->_mapBoniLevel();

        $data = $this->_getKrediteAntragData($data);

        $data = $this->_getKrediteAntragSteps($data);

        $data['requestData']['creditLine'] = $data['creditLine'];

        $data['vzweckLabel']    = $this->_getUsage($this->_zweck);
        $data['kreditinstitut'] = strtolower($institut);

        $dataKey = $data['kreditResult'][$key];

        $data['kreditInstitutTitle'] = $dataKey->kreditInstitutTitle;
        $data['companyPicture']      = $dataKey->companyPicture;
        $data['monatlicheRate']      = $dataKey->monatlicheRate;
        $data['gesamtKreditbetrag']  = $dataKey->gesamtKreditbetrag;
        $data['requestData']['lstUuid'] = $data['lstUuid'];
        $data['zweiterKreditnehmer'] = 0;

        $data['zinsen']       = $zins;
        $data['laufzeitName'] = $this->_getLaufzeitName($this->_laufzeit);
        $data['mode']         = strtolower($this->_mode);

        $data['institut']  = strtolower($institut);
        $data['step']      = $this->_step;
        $data['boniLevel'] = $this->_boniLevel;

        if (\Zend\Registry::get('_urlType') == 'INT') {
            $int = true;
        } else {
            $int = false;
        }

        $data['target'] = $this->_buildURL(
            'index', 'antrag', 'kredit', array(), $int, 'kredite.html'
        );

        $data['ok']       = true;
        $data['anrede']   = $this->_sex;
        $data['titel']    = $this->_title;
        $data['vorname']  = $this->_firstName;
        $data['nachname'] = $this->_surName;

        return $data;
    }

    /**
     * maps the surname
     *
     * @return \AppCore\Credit\Antrag
     */
    private function _mapSurname()
    {
        if (isset($this->_requestData['kn1']['nachname'])) {
            $this->_surName = $this->_requestData['kn1']['nachname'];
        } elseif (isset($this->_requestData['nachname'])) {
            $this->_surName = $this->_requestData['nachname'];
        }

        return $this;
    }

    /**
     * maps the firstname
     *
     * @return \AppCore\Credit\Antrag
     */
    private function _mapFirstname()
    {
        if (isset($this->_requestData['kn1']['vorname'])) {
            $this->_firstName = $this->_requestData['kn1']['vorname'];
        } elseif (isset($this->_requestData['vorname'])) {
            $this->_firstName = $this->_requestData['vorname'];
        }

        return $this;
    }

    /**
     * maps the email
     *
     * @return \AppCore\Credit\Antrag
     */
    private function _mapEmail()
    {
        if (isset($this->_requestData['kn1']['email'])) {
            $this->_email = $this->_requestData['kn1']['email'];
        } elseif (isset($this->_requestData['email'])) {
            $this->_email = $this->_requestData['email'];
        }

        return $this;
    }

    /**
     * maps the gender
     *
     * @return \AppCore\Credit\Antrag
     */
    private function _mapSex()
    {
        if (isset($this->_requestData['kn1']['anrede'])) {
            $this->_sex = $this->_requestData['kn1']['anrede'];
        } elseif (isset($this->_requestData['anrede'])) {
            $this->_sex = $this->_requestData['anrede'];
        }

        return $this;
    }

    /**
     * maps the postal code
     *
     * @return \AppCore\Credit\Antrag
     */
    private function _mapPostcode()
    {
        if (isset($this->_requestData['kn1']['PLZ'])) {
            $this->_postcode = $this->_requestData['kn1']['PLZ'];
        } elseif (isset($this->_requestData['PLZ'])) {
            $this->_postcode = $this->_requestData['PLZ'];
        }

        return $this;
    }

    /**
     * maps the title
     *
     * @return \AppCore\Credit\Antrag
     */
    private function _mapTitle()
    {
        if (isset($this->_requestData['kn1']['titel'])) {
            $this->_title = $this->_requestData['kn1']['titel'];
        } elseif (isset($this->_requestData['titel'])) {
            $this->_title = $this->_requestData['titel'];
        }

        return $this;
    }

    /**
     * maps the city
     *
     * @return \AppCore\Credit\Antrag
     */
    private function _mapCity()
    {
        if (isset($this->_requestData['kn1']['ort'])) {
            $this->_city = $this->_requestData['kn1']['ort'];
        } elseif (isset($this->_requestData['ort'])) {
            $this->_city = $this->_requestData['ort'];
        }

        return $this;
    }

    /**
     * maps the street
     *
     * @return \AppCore\Credit\Antrag
     */
    private function _mapStreet()
    {
        if (isset($this->_requestData['kn1']['strasse'])) {
            $this->_street = $this->_requestData['kn1']['strasse'];
        } elseif (isset($this->_requestData['strasse'])) {
            $this->_street = $this->_requestData['strasse'];
        }

        return $this;
    }

    /**
     * maps the housenumber
     *
     * @return \AppCore\Credit\Antrag
     */
    private function _mapHouseNumber()
    {
        if (isset($this->_requestData['kn1']['hausnr'])) {
            $this->_housenumber = $this->_requestData['kn1']['hausnr'];
        } elseif (isset($this->_requestData['hausnr'])) {
            $this->_housenumber = $this->_requestData['hausnr'];
        }

        return $this;
    }

    /**
     * maps the phone number (without prefix)
     *
     * @return \AppCore\Credit\Antrag
     */
    private function _mapPhone()
    {
        if (isset($this->_requestData['kn1']['telefon'])) {
            $this->_phone = $this->_requestData['kn1']['telefon'];
        } elseif (isset($this->_requestData['telefon'])) {
            $this->_phone = $this->_requestData['telefon'];
        }

        return $this;
    }

    /**
     * maps the phone number prefix
     *
     * @return \AppCore\Credit\Antrag
     */
    private function _mapPhonePrefix()
    {
        if (isset($this->_requestData['kn1']['vorwahl'])) {
            $this->_phonePrefix = $this->_requestData['kn1']['vorwahl'];
        } elseif (isset($this->_requestData['vorwahl'])) {
            $this->_phonePrefix = $this->_requestData['vorwahl'];
        }

        return $this;
    }

    /**
     * maps the mobile number (without prefix)
     *
     * @return \AppCore\Credit\Antrag
     */
    private function _mapMobile()
    {
        if (isset($this->_requestData['kn1']['mobilfunk'])) {
            $this->_mobile = $this->_requestData['kn1']['mobilfunk'];
        } elseif (isset($this->_requestData['mobilfunk'])) {
            $this->_mobile = $this->_requestData['mobilfunk'];
        }

        return $this;
    }

    /**
     * maps the mobile number prefix
     *
     * @return \AppCore\Credit\Antrag
     */
    private function _mapMobilePrefix()
    {
        if (isset($this->_requestData['kn1']['vorwahlmobil'])) {
            $this->_mobilePrefix = $this->_requestData['kn1']['vorwahlmobil'];
        } elseif (isset($this->_requestData['vorwahlmobil'])) {
            $this->_mobilePrefix = $this->_requestData['vorwahlmobil'];
        }

        return $this;
    }

    /**
     * maps the birthday (day part)
     *
     * @return \AppCore\Credit\Antrag
     */
    private function _mapBirthDay()
    {
        if (isset($this->_requestData['kn1']['gebdatumTag'])) {
            $this->_birthDay = $this->_requestData['kn1']['gebdatumTag'];
        } elseif (isset($this->_requestData['gebdatumTag'])) {
            $this->_birthDay = $this->_requestData['gebdatumTag'];
        }

        return $this;
    }

    /**
     * maps the birthday (month part)
     *
     * @return \AppCore\Credit\Antrag
     */
    private function _mapBirthMonth()
    {
        if (isset($this->_requestData['kn1']['gebdatumMonat'])) {
            $this->_birthMonth = $this->_requestData['kn1']['gebdatumMonat'];
        } elseif (isset($this->_requestData['gebdatumMonat'])) {
            $this->_birthMonth = $this->_requestData['gebdatumMonat'];
        }

        return $this;
    }

    /**
     * maps the birthday (year part)
     *
     * @return \AppCore\Credit\Antrag
     */
    private function _mapBirthYear()
    {
        if (isset($this->_requestData['kn1']['gebdatumJahr'])) {
            $this->_birthYear = $this->_requestData['kn1']['gebdatumJahr'];
        } elseif (isset($this->_requestData['gebdatumJahr'])) {
            $this->_birthYear = $this->_requestData['gebdatumJahr'];
        }

        return $this;
    }

    /**
     * maps the family state
     *
     * @return \AppCore\Credit\Antrag
     */
    private function _mapFamilyState()
    {
        if (isset($this->_requestData['kn1']['verheiratet'])) {
            $this->_familyState = $this->_requestData['kn1']['verheiratet'];
        } elseif (isset($this->_requestData['verheiratet'])) {
            $this->_familyState = $this->_requestData['verheiratet'];
        }

        return $this;
    }

    /**
     * maps the country
     *
     * @return \AppCore\Credit\Antrag
     */
    private function _mapCountry()
    {
        if (isset($this->_requestData['kn1']['land'])) {
            $this->_country = $this->_requestData['kn1']['land'];
        } elseif (isset($this->_requestData['land'])) {
            $this->_country = $this->_requestData['land'];
        }

        return $this;
    }

    /**
     * maps the profession
     *
     * @return \AppCore\Credit\Antrag
     */
    private function _mapProfession()
    {
        if (isset($this->_requestData['kn1']['berufsgruppe'])) {
            $this->_profession = $this->_requestData['kn1']['berufsgruppe'];
        } elseif (isset($this->_requestData['berufsgruppe'])) {
            $this->_profession = $this->_requestData['berufsgruppe'];
        }

        return $this;
    }

    /**
     * maps the AGB
     *
     * @return \AppCore\Credit\Antrag
     */
    private function _mapAgb()
    {
        if (isset($this->_requestData['kn1']['agbEinv'])) {
            $this->_agbOk = $this->_requestData['kn1']['agbEinv'];
        } elseif (isset($this->_requestData['agbEinv'])) {
            $this->_agbOk = $this->_requestData['agbEinv'];
        }

        return $this;
    }

    /**
     * maps the contact wish
     *
     * @return \AppCore\Credit\Antrag
     */
    private function _mapContact()
    {
        if (isset($this->_requestData['kn1']['datenEinv'])) {
            $this->_contactOk = $this->_requestData['kn1']['datenEinv'];
        } elseif (isset($this->_requestData['datenEinv'])) {
            $this->_contactOk = $this->_requestData['datenEinv'];
        }

        return $this;
    }

    /**
     * maps the Schufa
     *
     * @return \AppCore\Credit\Antrag
     */
    private function _mapSchufa()
    {
        if (isset($this->_requestData['kn1']['schufaEinv'])) {
            $this->_schufaOk = $this->_requestData['kn1']['schufaEinv'];
        } elseif (isset($this->_requestData['schufaEinv'])) {
            $this->_schufaOk = $this->_requestData['schufaEinv'];
        }

        return $this;
    }

    /**
     * maps the first time info (Probezeit)
     *
     * @return \AppCore\Credit\Antrag
     */
    private function _mapFirstTime()
    {
        if (isset($this->_requestData['kn1']['Probezeit'])) {
            $this->_firstTimeOver = $this->_requestData['kn1']['Probezeit'];
        } elseif (isset($this->_requestData['Probezeit'])) {
            $this->_firstTimeOver = $this->_requestData['Probezeit'];
        }

        return $this;
    }

    /**
     * maps the three months info
     *
     * @return \AppCore\Credit\Antrag
     */
    private function _mapThreeMonths()
    {
        if (isset($this->_requestData['kn1']['DreiMonate'])) {
            $this->_threeMonths = $this->_requestData['kn1']['DreiMonate'];
        } elseif (isset($this->_requestData['DreiMonate'])) {
            $this->_threeMonths = $this->_requestData['DreiMonate'];
        }

        return $this;
    }

    /**
     * maps the income
     *
     * @return \AppCore\Credit\Antrag
     */
    private function _mapIncome()
    {
        if (isset($this->_requestData['kn1']['einkommen']['netto'])) {
            $this->_income = $this->_requestData['kn1']['einkommen']['netto'];
        }

        return $this;
    }

    /**
     * maps the amount of people for the credit request
     *
     * @return \AppCore\Credit\Antrag
     */
    private function _mapAnzahl()
    {
        if (isset($this->_requestData['kn1']['anzahl'])) {
            $this->_anzahl = $this->_requestData['kn1']['anzahl'];
        } elseif (isset($this->_requestData['anzahl'])) {
            $this->_anzahl = $this->_requestData['anzahl'];
        }

        return $this;
    }

    /**
     * maps the boni level for the credit request
     *
     * @return \AppCore\Credit\Antrag
     */
    private function _mapBoniLevel()
    {
        if (isset($this->_requestData['kn1']['boniLevel'])) {
            $this->_boniLevel = $this->_requestData['kn1']['boniLevel'];
        } elseif (isset($this->_requestData['boniLevel'])) {
            $this->_boniLevel = $this->_requestData['boniLevel'];
        } else {
            $this->_boniLevel = 'medium';
        }

        return $this;
    }

    /**
     * displays the steps of an kredit request
     *
     * @param array $data an array which holds global data and
     *                    all data to be displayed
     *
     * @return array
     * @access private
     */
    private function _getKrediteAntragSteps(array $data)
    {
        $campaignModel = new \AppCore\Service\Campaigns();

        $pfad         = '';
        $data['type'] = 'clickout';
        $this->_step  = (int) $this->_step;

        if (KREDIT_ANTRAG_STEPS_FIRST < $this->_step) {
            //add the step number for all step except the first one
            $data['type'] .= '-' . $this->_step;
        }

        $istTest = (boolean) $this->_test;
        $dataKn  = ((isset($data['requestData']['kn1']))
                 ? $data['requestData']['kn1']
                 : array());

        if (isset($dataKn['gebdatum'])) {
            $gd = explode('.', $dataKn['gebdatum']);
            if (count($gd) < 3) {
                $gebdatum = array(
                    'tag'   => null,
                    'monat' => null,
                    'jahr'  => null
                );

                $message = 'Datum Invalid: ' . $dataKn['gebdatum'];

                $this->_logger->warn($message);
            } else {
                $gebdatum = array(
                    'tag'   => $gd[0],
                    'monat' => $gd[1],
                    'jahr'  => $gd[2]
                );
            }
        } else {
            $gebdatum = array(
                'tag'   => null,
                'monat' => null,
                'jahr'  => null
            );
        }

        $this->_firstName   = ((isset($dataKn['vorname']))
                            ? $dataKn['vorname']
                            : $this->_firstName);
        $this->_surName     = ((isset($dataKn['nachname']))
                            ? $dataKn['nachname']
                            : $this->_surName);
        $this->_email       = ((isset($dataKn['email']))
                            ? $dataKn['email']
                            : $this->_email);
        $this->_housenumber = ((isset($dataKn['hausnr']))
                            ? $dataKn['hausnr']
                            : $this->_housenumber);
        $this->_postcode    = ((isset($dataKn['PLZ']))
                            ? $dataKn['PLZ']
                            : $this->_postcode);

        //build an data array with all data to be stored
        $requestData = array(
            'product'        => $this->_product,
            'caid'           => $this->_caid,
            'paid'           => $this->_caid,
            'kreditinstitut' => $data['institut'],
            'kreditbetrag'   => $data['kreditbetrag'],
            'laufzeit'       => $data['laufzeit'],
            'test'           => $istTest,
            'IP'             => $this->_ip,
            'sparte'         => $data['sparte'],
            'zweck'          => $data['zweck'],
            'vorname'        => $this->_firstName,
            'nachname'       => $this->_surName,
            'email'          => $this->_email,
            'anrede'         => ((isset($dataKn['anrede']))
                             ? $dataKn['anrede']
                             : $this->_sex),
            'titel'          => ((isset($dataKn['titel']))
                             ? $dataKn['titel']
                             : $this->_title),
            'strasse'        => ((isset($dataKn['strasse']))
                             ? $dataKn['strasse']
                             : $this->_street),
            'hausnr'         => $this->_housenumber,
            'plz'            => $this->_postcode,
            'ort'            => ((isset($dataKn['ort']))
                             ? $dataKn['ort']
                             : $this->_city),
            'vorwahl'        => ((isset($dataKn['vorwahl']))
                             ? $dataKn['vorwahl']
                             : $this->_phonePrefix),
            'telefon'        => ((isset($dataKn['telefon']))
                             ? $dataKn['telefon']
                             : $this->_phone),
            'vorwahlmobil'   => ((isset($dataKn['vorwahlMobil']))
                             ? $dataKn['vorwahlMobil']
                             : $this->_mobilePrefix),
            'mobilfunk'      => ((isset($dataKn['telefonMobil']))
                             ? $dataKn['telefonMobil']
                             : $this->_mobile),
            'gebdatumTag'    => ((isset($dataKn['gebdatum']))
                             ? $gebdatum['tag']
                             : $this->_birthDay),
            'gebdatumMonat'  => ((isset($dataKn['gebdatum']))
                             ? $gebdatum['monat']
                             : $this->_birthMonth),
            'gebdatumJahr'   => ((isset($dataKn['gebdatum']))
                             ? $gebdatum['jahr'] :
                             $this->_birthYear),
            'verheiratet'    => ((isset($dataKn['familie']))
                             ? $dataKn['familie']
                             : $this->_familyState),
            'land'           => ((isset($dataKn['land']))
                             ? $dataKn['land']
                             : $this->_country),
            'berufsgruppe'   => ((isset($dataKn['berufsgruppe']))
                             ? $dataKn['berufsgruppe']
                             : $this->_profession),
            'schufaEinv'     => ((isset($dataKn['schufaEinv']))
                             ? $dataKn['schufaEinv']
                             : $this->_schufaOk),
            'datenEinv'      => $this->_contactOk,
            'agbEinv'        => ((isset($dataKn['agbEinv']))
                             ? $dataKn['agbEinv']
                             : $this->_agbOk),
            'Probezeit'      => ((isset($dataKn['Probezeit']))
                             ? !$dataKn['Probezeit']
                             : $this->_firstTimeOver),
            'DreiMonate'     => $this->_threeMonths,
            'kn1'            => ((isset($dataKn))
                             ? $dataKn
                             : array()),
            'kn2'            => ((isset($data['requestData']['anzahl'])
                             && $data['requestData']['anzahl'] > 1
                             && isset($data['requestData']['kn2']))
                             ? $data['requestData']['kn2']
                             : array()),
            'actualStep'     => $this->_step,
            'requestData'    => ((isset($data['requestData']))
                             ? $data['requestData']
                             : array()),
            'creditLine'     => $data['creditLine'],
            'boniLevel'      => ((isset($dataKn['boniLevel']))
                             ? $dataKn['boniLevel']
                             : 'medium'),
            'anzahl'         => ((isset($data['requestData']['anzahl']))
                             ? $data['requestData']['anzahl']
                             : 1)
        );

        $track = array();

        switch ($this->_step) {
            case 2:
                /* short credit line - may be used in the future ******/
                $data['nextStep'] = KREDIT_ANTRAG_STEPS_LAST;
                $data['file']     = 'antrag4';
                $data['type']     = $data['file'];
                $track[0]         = 4;
                $track[1]         = 'Short';
                break;
            case 3:
                /* long credit line ***********************************/
                $data['nextStep']   = 4;
                $data['file']       = 'antrag3a';
                $data['creditLine'] = 'long';
                $track[0]           = '3a';
                $track[1]           = 'Complete';

                $this->_boniLevel = 'medium';

                /*
                 * check for Bonitaet
                 * conditions for shorter version of long credit line
                 */
                if ($this->_checkForGoodBoni()) {
                    $this->_boniLevel = 'good';

                    //(shorter version)
                    $data['nextStep']   = KREDIT_ANTRAG_STEPS_LAST;
                    $data['file']       = 'antrag4';
                    $data['creditLine'] = 'short';
                    $track[0]           = 4;
                    $track[1]           = 'Short';
                }

                $data['type'] = $data['file'];
                break;
            case 4:
                /*
                 * step 4: long credit line - Person
                 */
                $data['nextStep'] = 5;
                $data['file']     = 'antrag5';
                $data['type']     = $data['file'];
                $track[0]         = 5;
                $track[1]         = 'Complete';
                break;
            case 5:
                /*
                 * step 5: long credit line - Anstellung
                 */
                $data['nextStep'] = 6;
                $data['file']     = 'antrag6';
                $data['type']     = $data['file'];
                $track[0]         = 6;
                $track[1]         = 'Complete';
                break;
            case 6:
                /*
                 * step 6: long credit line - Einkommen
                 */
                $data['nextStep'] = 7;
                $data['file']     = 'antrag7';
                $data['type']     = $data['file'];
                $track[0]         = 7;
                $track[1]         = 'Complete';
                break;
            case 7:
                /*
                 * step 7: long credit line - Kontodaten
                 */
                $data['nextStep'] = 8;
                $data['file']     = 'antrag8';
                $data['type']     = $data['file'];
                $track[0]         = 8;
                $track[1]         = 'Complete';
                break;
            case 8:
                /*
                 * step 8: long credit line - Bestaetigung
                 */
                $data['nextStep'] = KREDIT_ANTRAG_STEPS_LAST;
                $data['file']     = 'antrag9';
                $data['type']     = $data['file'];
                $track[0]         = 9;
                $track[1]         = 'Complete';
                break;
            case KREDIT_ANTRAG_STEPS_LAST:
                /* last step ******************************************/
                $track[0] = KREDIT_ANTRAG_STEPS_LAST;

                switch ($data['creditLine']) {
                    case 'long':
                        /*
                         * goto long credit line
                         */
                        $track[1]                  = 'Complete';
                        $requestData['creditLine'] = 'long';
                        $data['file']              = 'ergebnis-long';
                        break;
                    case 'short':
                        /*
                         * goto short credit line
                         * not used at the moment
                         */
                        $track[1]                  = 'Short';
                        $requestData['creditLine'] = 'short';
                        $data['file']              = 'ergebnis';
                        break;
                    case 'oneStep':
                        // Break intentionally omitted
                    default:
                        $track[1]                  = 'Old';
                        $requestData['creditLine'] = 'oneStep';
                        $data['file']              = 'ergebnis';
                        break;
                }

                $track[2] = 'Ende';

                if (!$istTest) {
                    /*
                     * the request is not marked as test at the moment
                     * -> do more checks
                     */
                    $istTest = $this->_checkForTest();
                }

                $data['type'] = 'sale';
                break;
            case KREDIT_ANTRAG_STEPS_FIRST:
                // Break intentionally omitted
            default:
                /* default - first step *******************************/
                $data['nextStep'] = KREDIT_ANTRAG_STEPS_LAST; /* default */
                $data['file']     = 'antrag1';
                $data['type']     = 'clickout';
                $track[0]         = 1;
                $track[1]         = 'Old';

                switch ($data['creditLine']) {
                    case 'long':
                        /*
                         * goto long credit line
                         */
                        $data['nextStep'] = 4;
                        $data['file']     = 'antrag3';
                        $data['type']     = 'clickout-long';
                        $track[0]         = 3;
                        $track[1]         = 'Complete';
                        break;
                    case 'short':
                        /*
                         * goto short credit line
                         * not used at the moment
                         */
                        $data['nextStep'] = 2;
                        $data['file']     = 'antrag2';
                        $data['type']     = 'clickout-short';
                        $track[0]         = 2;
                        $track[1]         = 'Short';
                        break;
                    case 'oneStep':
                        // Break intentionally omitted
                    default:
                        // nothing to do here
                        break;
                }
                break;
        }

        $aTrack = array(
            'Antrag',
            'Step',
            (string) $track[0],
            'Partner',
            $campaignModel->getName($this->_caid),
            $track[1]
        );

        $data['test']        = (int) $istTest;
        $requestData['test'] = $data['test'];

        /*
         * store and update the customer data
         */
        $returnData = $this->_storeUserRequest($data, $requestData, $istTest);

        switch ($this->_step) {
            case KREDIT_ANTRAG_STEPS_LAST:
                $aTrack [] = $track[2];

                $this->_finish($data, $requestData, $returnData, $istTest);
                break;
            default:
                // nothing to do here
                break;
        }

        $data['file'] = $pfad . $data['file'];
        $data['lstUuid'] = $returnData['reportNr'];
        return $data;
    }

    /**
     * sends emails to portalservice, if the service was not used
     *
     * @param array      $data        an array which holds global data and
     *                                all data to be displayed
     * @param array      $requestData an array with data for stoage and mail
     * @param array|null $returnData  an array with data from storage/data
     *                                transfer to portalservice
     * @param boolean    $istTest     if TRUE, the request is marked as Test
     *
     * @return void
     * @access private
     */
    private function _finish(
        array $data,
        array $requestData,
        $returnData,
        $istTest = false)
    {
        if (is_array($returnData)) {
            $reportNr        = $returnData['reportNr'];
            $idPortalService = $returnData['idPortalService'];
            $postData        = $returnData['postData'];
        } else {
            $reportNr        = null;
            $idPortalService = null;
            $postData        = null;
        }

        $dataToSend = $data;
        unset($dataToSend['kreditResult']);

        $text = \AppCore\Globals::createXML(
            $requestData, $reportNr, $data['creditLine'], $this->_view
        );

        if ($istTest
            || null === $returnData
            || null === $reportNr
        ) {
            $requestData['postData'] = $postData;
        } else {
            if (null === $idPortalService || 0 >= (int) $idPortalService) {
                $this->sendMailOffice($requestData, $text);
            }

            /*
            $requestData['postData'] = $postData;

            // send an control email
            $sent = $this->_sendMailBack($requestData, $text);
            */
        }

        //if (!$sent) {
        //    $this->_logger->warn('Controll-Email not sent');
        //}
    }

    /**
     * stores the user request into the database and updates the customer data,
     * if set
     *
     * @param array   $data        an array which holds global data and
     *                             all data to be displayed
     * @param array   $requestData an array with data for stoage and mail
     * @param boolean $istTest     if TRUE, the request is marked as Test
     *
     * @return array|null
     * @access private
     */
    private function _storeUserRequest(
        array $data,
        array $requestData,
        $istTest = false)
    {
        $requestData['statusTypeId'] = 1;
        if ($istTest) {
            $requestData['statusTypeId'] = 3;
        }
        $requestData['test']           = $istTest;
        $requestData['kreditinstitut'] = $data['institut'];
        $requestData['sparte']         = $this->_sparte;

        //check the fields for customer search
        if (isset($requestData['vorname'])
            && '' != $requestData['vorname']
            && isset($requestData['nachname'])
            && '' != $requestData['nachname']
            && isset($requestData['email'])
            && '' != $requestData['email']
        ) {
            $postData = array_merge($data['requestData'], $requestData);

            //store the Server data
            $postData['SERVER'] = $_SERVER;
            $postData['ENV']    = $_ENV;

            if (SERVER_ONLINE_TEST != APPLICATION_ENV
                && SERVER_ONLINE_TEST2 != APPLICATION_ENV
            ) {
                //does not work while testing
                if (function_exists('apache_response_headers')) {
                    $postData['HEADER'] = apache_response_headers();
                } else {
                    $postData['HEADER']['Connection'] = 'Keep-Alive';
                }

            }
            $postData['UNAME']  = php_uname('n');

            $postData['kn1'] = array_merge(
                ((isset($data['requestData']['kn1']))
                ? $data['requestData']['kn1'] : array()),
                ((isset($postData['kn1']))
                ? $postData['kn1'] : array()),
                ((isset($requestData['kn1']))
                ? $requestData['kn1'] : array())
            );

            $postData['kn2'] = array_merge(
                ((isset($data['requestData']['kn2']))
                ? $data['requestData']['kn2'] : array()),
                ((isset($postData['kn2']))
                ? $postData['kn2'] : array()),
                ((isset($requestData['kn2']))
                ? $requestData['kn2'] : array())
            );

            try {
                //store the request
                $antrag     = new \AppCore\Model\LogCredits();
                $returnData = $antrag->getAntragData($postData);
            } catch (Exception $e) {
                $this->_logger->err($e);

                return null;
            }

            return $returnData;
        } else {
            return null;
        }
    }

    /**
     * return kredit information for a given bank
     *
     * @param array $data an array which holds global data and
     *                    all data to be displayed
     *
     * @return array
     * @access private
     */
    private function _getKrediteAntragData(array $data)
    {
        //TODO: sort the array, to be able to delete this asort
        asort(\AppCore\Globals::$generalStates, SORT_STRING);

        $data['staatsangeh']   = \AppCore\Globals::$generalStates;
        $data['berufsgruppe']  = \AppCore\Globals::getProfession();
        //$data['kn_brancheben'] = \AppCore\Globals::$generalBusiness;

        return $data;
    }

    /**
     * Die Methode erstellt URLs je nach Art der Einbindung
     *
     * @param string  $controller Name des Controllers
     * @param string  $action     Name der Action
     * @param string  $module     Name des Modules, NULL fuer default
     * @param array   $postData   weitere URL-Parameter
     * @param boolean $int        a flag
     *                            TRUE:  the link will be coded like /key/value/
     *                            FALSE: the link will be coded like ?key=value
     * @param string  $url        url-Prefix
     *
     * @access private
     * @return String Fertige URL
     */
    private function _buildURL(
        $controller,
        $action,
        $module = null,
        array $postData = array(),
        $int = true,
        $url = ''
    )
    {
        return \AppCore\Globals::buildURL(
            $controller, $action, $module, $postData, $int, $url
        );
    }

    /**
     * liefert alle m?glichen Laufzeiten
     *
     * @return array
     * @access private
     */
    private function _getLaufzeitList()
    {
        $modelLaufzeit = new \AppCore\Service\Laufzeit();

        return $modelLaufzeit->getList($this->_sparte);
    }

    /**
     * sendet eine E-Mail mit den Daten des Antragstellers
     *
     * @param array   $requestData die Daten des Antragsstellers
     * @param string  $email       die E-Mail-Adresse des Empf?ngers
     * @param string  $text        der Mail-Content im Text-Format
     * @param string  $html        der Mail-Content im HTML-Format
     * @param boolean $ignoreCC    Schalter zum Ignorieren der CC/BCC Parameter
     * @param boolean $secondSend  Schalter zum Kennzeichnen eines
     *                             2. Sendeversuches
     *
     * @return boolean FALSE, if the sending failed, TRUE otherwise
     * @access private
     */
    private function _sendMail(
        array $requestData = array(),
        $email = '',
        $text = '',
        $html = '',
        $secondSend = false)
    {
        //Partner ID is not set
        //-> do not send Email
        if (!isset($requestData['paid']) && !isset($requestData['caid'])) {
            return false;
        }

        $ids           = $this->_loadPaid($requestData['caid']);
        $portalService = new \AppCore\Service\PartnerSites();

        $subject = ((isset($requestData['test']) && $requestData['test'])
                 ? '!!Test!! - ': '')
                 . 'Kredit-Antrag ueber Portal '
                 . $portalService->getAdresse($ids['paid'])
                 . ' fuer Kreditinstitut '
                 . $requestData['kreditinstitut']
                 . (($secondSend) ? ' ( 2. Versuch )': '');

        $cc  = array();
        $bcc = array();

        try {
            return \AppCore\Globals::sendMail(
                $email, $text, $html, $cc, $bcc, $subject
            );
        } catch (Exception $e) {
            $this->_logger->err($e);

            return false;
        }
    }

    /**
     * sendet eine E-Mail mit den Daten des Antragstellers an Portalservice
     *
     * @param array     $requestData die Daten des Antragsstellers
     * @param integer   $reportNr    die ID des Antragsdatensatzes
     * @param string    $creditLine  der Typ der Kredit-Linie
     * @param \Zend\View\View &$view       ein \Zend\View\View-Object zum Rendern der Emails
     * @param boolean   $secondSend  Schalter zum Kennzeichnen eines
     *                               2. Sendeversuches
     *
     * @return boolean FALSE, if the sending failed, TRUE otherwise
     */
    public function sendMailOffice(
        array $requestData = array(),
        $text = '',
        $secondSend = false)
    {
        $email = array(
            'kreditleads@portalservice.de',
            'nicole.marggraf@portalservice.de'
        );

        return $this->_sendMail(
            $requestData,
            $email,
            $text,
            '',
            $secondSend
        );
    }

    /**
     * sendet eine E-Mail mit den Daten des Antragstellers
     *
     * Diese Funktion sendet Emails f?r alle Nicht-Tests als Kontrolle, dass
     * Emails versandt werden
     *
     * @param array     $requestData die Daten des Antragsstellers
     * @param integer   $reportNr    die ID des Antragsdatensatzes
     * @param string    $creditLine  der Typ der Kredit-Linie
     * @param \Zend\View\View &$view       ein \Zend\View\View-Object zum Rendern der Emails
     *
     * @return boolean FALSE, if the sending failed, TRUE otherwise
     */
    /*
    private function _sendMailBack(
        array $requestData = array(),
        $text = '')
    {
        $email = array(
            'debug@geld.de'
        );

        return $this->_sendMail(
            $requestData,
            $email,
            $text,
            '',
            true
        );
    }
    */

    /**
     * sendet eine E-Mail mit den Daten des Antragstellers
     * Diese Funktion sendet Emails f?r alle Tests
     *
     * @param array     $requestData die Daten des Antragsstellers
     * @param integer   $reportNr    die ID des Antragsdatensatzes
     * @param string    $creditLine  der Typ der Kredit-Linie
     * @param \Zend\View\View &$view       ein \Zend\View\View-Object zum Rendern der Emails
     *
     * @return boolean FALSE, if the sending failed, TRUE otherwise
     */
    /*
    private function _sendMailTest(
        array $requestData = array(),
        $text = '')
    {
        $email = array('debug@geld.de');

        return $this->_sendMail(
            $requestData,
            $email,
            $text,
            '',
            true
        );
    }
    */

    /**
     * returns a list of possible usages
     *
     * @return array
     * @access private
     */
    private function _getUsageList()
    {
        $usageModel = new \AppCore\Service\Usage();

        return $usageModel->getList();
    }

    /**
     * liefert den Namen zu einer Laufzeit
     *
     * @param integer $laufzeit ??
     *
     * @return string
     * @access private
     */
    private function _getLaufzeitName($laufzeit = KREDIT_LAUFZEIT_DEFAULT)
    {
        $modelLaufzeit = new \AppCore\Service\Laufzeit();

        return $modelLaufzeit->name($this->_sparte, $laufzeit);
    }

    /**
     * returns he name for a specific usage
     *
     * @param integer $usage the usage id
     *
     * @return string
     * @access private
     */
    private function _getUsage($usage = KREDIT_VERWENDUNGSZWECK_SONSTIGES)
    {
        $usageModel = new \AppCore\Service\Usage();

        return $usageModel->name($usage);
    }

    /**
     * @param integer $product the product Id
     *
     * @return void
     * @access public
     */
    public function setProduct($product)
    {
        $this->_product = (int) $product;

        return $this;
    }

    /**
     * @param integer $step the value for the variable
     *
     * @return void
     * @access public
     */
    public function setStep($step)
    {
        $this->_step = (int) $step;

        return $this;
    }

    /**
     * @param integer $sex the value for the variable
     *
     * @return void
     * @access public
     */
    public function setSex($sex)
    {
        $this->_sex = $sex;

        return $this;
    }

    /**
     * @param integer $title the value for the variable
     *
     * @return void
     * @access public
     */
    public function setTitle($title)
    {
        $this->_title = $title;

        return $this;
    }

    /**
     * @param integer $firstName the value for the variable
     *
     * @return void
     * @access public
     */
    public function setFirstName($firstName)
    {
        $this->_firstName = $firstName;

        return $this;
    }

    /**
     * @param integer $surName the value for the variable
     *
     * @return void
     * @access public
     */
    public function setSurName($surName)
    {
        $this->_surName = $surName;

        return $this;
    }

    /**
     * @param integer $postcode the value for the variable
     *
     * @return void
     * @access public
     */
    public function setPostcode($postcode)
    {
        $this->_postcode = $postcode;

        return $this;
    }

    /**
     * @param integer $city the value for the variable
     *
     * @return void
     * @access public
     */
    public function setCity($city)
    {
        $this->_city = $city;

        return $this;
    }

    /**
     * @param integer $email the value for the variable
     *
     * @return void
     * @access public
     */
    public function setEmail($email)
    {
        $this->_email = $email;

        return $this;
    }

    /**
     * @param integer $street the value for the variable
     *
     * @return void
     * @access public
     */
    public function setStreet($street)
    {
        $this->_street = $street;

        return $this;
    }

    /**
     * @param integer $email the value for the variable
     *
     * @return void
     * @access public
     */
    public function setHouseNumber($houseNumber)
    {
        $this->_housenumber = $houseNumber;

        return $this;
    }

    /**
     * @param integer $phone the value for the variable
     *
     * @return void
     * @access public
     */
    public function setPhone($phone, $prefix)
    {
        $this->_phone       = $phone;
        $this->_phonePrefix = $prefix;

        return $this;
    }

    /**
     * @param integer $mobile the value for the variable
     *
     * @return void
     * @access public
     */
    public function setMobile($mobile, $prefix)
    {
        $this->_mobile       = $mobile;
        $this->_mobilePrefix = $prefix;

        return $this;
    }

    /**
     * @param integer $day   the value for the variable
     * @param integer $month the value for the variable
     * @param integer $year  the value for the variable
     *
     * @return void
     * @access public
     */
    public function setBirthDay($day, $month, $year)
    {
        $this->_birthDay   = (int) $day;
        $this->_birthMonth = (int) $month;
        $this->_birthYear  = (int) $year;

        return $this;
    }

    /**
     * @param integer $familyState the value for the variable
     *
     * @return void
     * @access public
     */
    public function setFamilyState($familyState)
    {
        $this->_familyState = $familyState;

        return $this;
    }

    /**
     * @param integer $country the value for the variable
     *
     * @return void
     * @access public
     */
    public function setCountry($country)
    {
        $this->_country = $country;

        return $this;
    }

    /**
     * @param integer $profession the value for the variable
     *
     * @return void
     * @access public
     */
    public function setProfession($profession)
    {
        $this->_profession = (int) $profession;

        return $this;
    }

    /**
     * @param boolean $schufa the value for the variable
     *
     * @return void
     * @access public
     */
    public function setSchufa($schufa)
    {
        $this->_schufaOk = (boolean) $schufa;

        return $this;
    }

    /**
     * @param boolean $contact the value for the variable
     *
     * @return void
     * @access public
     */
    public function setContakt($contact)
    {
        $this->_contactOk = (boolean) $contact;

        return $this;
    }

    /**
     * @param boolean $agb the value for the variable
     *
     * @return void
     * @access public
     */
    public function setAgb($agb)
    {
        $this->_agbOk = (boolean) $agb;

        return $this;
    }

    /**
     * @param boolean $threeMonths the value for the variable
     *
     * @return void
     * @access public
     */
    public function setThreeMonths($threeMonths)
    {
        $this->_threeMonths = (boolean) $threeMonths;

        return $this;
    }

    /**
     * @param boolean $firstTimeOver the value for the variable
     *
     * @return void
     * @access public
     */
    public function setFirstTimeOver($firstTimeOver)
    {
        $this->_firstTimeOver = (boolean) $firstTimeOver;

        return $this;
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
     * @param \Zend\View\View $view an view object
     *
     * @return void
     * @access public
     */
    public function setIp($ip = '')
    {
        $this->_ip = $ip;

        return $this;
    }

    /**
     * @param \Zend\View\View $view an view object
     *
     * @return void
     * @access public
     */
    public function setRequestData(array $requestData = array())
    {
        $this->_requestData = $requestData;

        /**/
        $data = array();

        foreach ($requestData as $key => $value) {
            $keys = explode('_', $key);

            if (isset($keys[0])
                && in_array($keys[0], array('kn1', 'kn2'))
            ) {
                $anz = count($keys);

                $d = '$data';
                for ($i = 0, $j = $anz; $i < $j; ++$i) {
                    $d .= "['" . $keys[$i] . "']";
                }
                $d .= "='" . (string) $value . "';";

                eval($d);
            } else {
                $data[$key] = $value;
            }
        }

        $this->_requestData = $data;

        return $this;
    }

    /**
     * @param integer $income the monthly income for an person
     *
     * @return void
     * @access public
     */
    public function setIncome($income)
    {
        $this->_income = $income;

        return $this;
    }

    /**
     * @param integer $income the monthly income for an person
     *
     * @return void
     * @access public
     */
    public function setAnzahl($anzahl)
    {
        $this->_anzahl = $anzahl;

        return $this;
    }

    /**
     * checks if the request has a good ranking
     * -> may use the short credit line
     *
     * @return boolean
     */
    private function _checkForGoodBoni()
    {
        if ($this->_anzahl > 1) {
            return true;
        } elseif (!$this->_firstTimeOver //Probezeit ist nicht beendet
        || '' == $this->_profession
        || 0  == $this->_income
        ) {
            return false;
        }

        switch ($this->_profession) {
            case KREDIT_BERUFSGRUPPE_BEAMTE_GEHOBENER_DIENST:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_BEAMTE_HOEHERER_DIENST:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_BEAMTE_MITTLERER_DIENST:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_BEAMTE_EINFACHER_DIENST:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_BERUFSSOLDAT:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_BEAMTE:
                return true;
                break;
            case KREDIT_BERUFSGRUPPE_VORSTAND_GESCHAEFTSFUEHRER:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_LEITENDER_ANGESTELLTER:
                if ($this->_income >= 1500) {
                    return true;
                } else {
                    return false;
                }
                break;
            case KREDIT_BERUFSGRUPPE_RENTNER:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_PENSIONAER:
                if ($this->_income >= 2000) {
                    return true;
                } else {
                    return false;
                }
                break;
            case KREDIT_BERUFSGRUPPE_SELBST_GEWERBETREIBENDER:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_SELBST_FREIBERUFLER:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_SELBST_GESCHAEFTSFUEHRER:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_SELBSTAENDIGE:
                if ($this->_income >= 2500) {
                    return true;
                } else {
                    return false;
                }
                break;
            case KREDIT_BERUFSGRUPPE_ANGESTELLTER:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_FACHARBEITER:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_ARBEITER:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_ANGESTELLTER_OEFFENTLICHER_DIENST:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_ANGESTELLT_IM_AUSLAND:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_ARBEITER_OEFFENTLICHER_DIENST:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_HILFSARBEITER:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_ARBEITER_ANGESTELLTER:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_SOLDAT_AUF_ZEIT:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_SOLDAT:
                // Break intentionally omitted
            case KREDIT_BERUFSGRUPPE_MEISTER:
                if ($this->_income >= 1500) {
                    return true;
                } else {
                    return false;
                }
                break;
            default:
                return false;
                break;
        }
    }

    /**
     * checks, if the request is a test
     *
     * @access private
     * @return boolean
     */
    private function _checkForTest()
    {
        //simple name check (black list)
        $simpleNameCheck = array('test', 'xx', 'xxx');

        if ($this->_surName == 'FormularTest'
            || in_array(strtolower($this->_firstName), $simpleNameCheck)
            || in_array(strtolower($this->_surName), $simpleNameCheck)
        ) {
            return true;
        }

        //more complex name check (bliack list)
        $name = strtolower($this->_firstName) . ' '
              . strtolower($this->_surName);

        $fullNameCheck = array(
            'xx xx',
            'xxx xxx',
            'max mustermann',
            'mungo jerry',
            'herr fuchs',
            'asdf asdf',
            'kkk kkk',
            'asdfasdf asdfasdf',
            'dasasd aas',
            'Mutti Suppe'
        );

        if (in_array($name, $fullNameCheck)) {
            return true;
        }

        //post code
        if ((int) $this->_postcode == 0
            || strlen($this->_postcode) != 5
        ) {
            return true;
        }

        //house number
        if ($this->_housenumber == '0') {
            return true;
        }

        //email
        $emailCheckSimple = array(
            '@testing.unister-gmbh.de',
            '@finanzen.unister-gmbh.de',
            '@test.de',
            '@xx.de',
            '@xxx.de',
            'test@'
        );
        foreach ($emailCheckSimple as $mailcheck) {
            if (strpos($this->_email, $mailcheck) !== false) {
                return true;
            }
        }

        $emailCheckComplete = array(
            '',
            'habe@keine.de',
            'tutnichts@zursache.de',
            'ghghj@ghgh.de',
            'gghgh@hj.de',
            'fgfghh@gffgf.de'
        );
        if (in_array($this->_email, $emailCheckComplete)) {
            return true;
        }

        /*
         * no criteria found, to mark the request as test
         */
        return false;
    }

    /**
     * l?dt die Partner/Campaign-ID
     *
     * @param mixed $value die Partner/Campaign-ID
     *
     * @return void
     */
    private function _loadPaid($value)
    {
        $agent    = '';
        $paid     = null;
        $caid     = null;
        $hostName = null;

        $campaignService = new \AppCore\Service\Campaigns();

        $campaignService->loadCaid(
            $value,
            $this->_requestData,
            $agent,
            $paid,
            $caid,
            $hostName
        );

        return array('caid' => $caid, 'paid' => $paid, 'hostname' => $hostName);
    }
}