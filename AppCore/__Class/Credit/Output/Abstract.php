<?php
/**
 * Controller-Klasse zum Ausliefern von Javascript-Dateien
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Credit
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: Abstract.php 4273 2010-12-16 17:54:02Z t.mueller $
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
abstract class \AppCore\Credit\Output\AbstractOutput
{
    protected $_db = null;

    protected $_kreditbetrag = null;

    protected $_laufzeit = null;

    protected $_zweck = null;

    protected $_caid = null;

    protected $_campaign = null;

    protected $_sparte = null;

    protected $_sparteName = null;

    protected $_teaserOnly = null;

    protected $_bestOnly = null;

    protected $_onlyProduct = null;

    protected $_onlyInstitut = null;

    protected $_institut = null;

    protected $_product = null;

    protected $_isteaser = null;

    protected $_isinternal = null;

    protected $_modeName = null;

    /**
     * if TRUE, the request is a test
     *
     * @var    int (boolean)
     * @access protected
     */
    protected $_test = null;

    protected $_urlDir = '';

    protected $_urlDirAntrag = '';

    protected $_urlDirInfo = '';

    protected $_baseUrl = '';

    protected $_urlAbsolute = false;

    /**
     * the class contructor
     *
     * @return \AppCore\Credit\Output\AbstractOutput
     */
    public function __construct()
    {
        $this->_db           = \Zend\Db\Table\AbstractTable::getDefaultAdapter();
        $this->_urlDir       = \Zend\Registry::get('_urlDir');
        $this->_urlDirAntrag = \Zend\Registry::get('_urlDirAntrag');
        $this->_urlDirInfo   = \Zend\Registry::get('_urlDirInfo');
        $this->_urlAbsolute  = \Zend\Registry::get('_useAbsolteUrl');

        $this->getBaseUrl();
    }

    /**
     * @param integer $value the value for the variable
     *
     * @return \AppCore\Credit\Output\AbstractOutput
     */
    public function setLaufzeit($value)
    {
        $this->_laufzeit = (int) $value;

        return $this;
    }

    /**
     * @return integer
     */
    public function getLaufzeit()
    {
        return $this->_laufzeit;
    }

    /**
     * @param integer $value the value for the variable
     *
     * @return \AppCore\Credit\Output\AbstractOutput
     */
    public function setKreditbetrag($value)
    {
        $this->_kreditbetrag = (int) $value;

        return $this;
    }

    /**
     * @return integer
     */
    public function getKreditbetrag()
    {
        return $this->_kreditbetrag;
    }

    /**
     * @param integer|string $value the value for the variable
     *
     * @return \AppCore\Credit\Output\AbstractOutput
     */
    public function setCaid($value)
    {
        $this->_caid = $value;

        $campaignModel = new \AppCore\Service\Campaigns();

        $this->setCampaign($campaignModel->getCampaignName($value));

        return $this;
    }

    /**
     * @return integer|string
     */
    public function getCaid()
    {
        return $this->_caid;
    }

    /**
     * @param integer|string $value the value for the variable
     *
     * @return \AppCore\Credit\Output\AbstractOutput
     */
    public function setCampaign($value)
    {
        $this->_campaign = $value;

        return $this;
    }

    /**
     * @return integer|string
     */
    public function getCampaign()
    {
        return $this->_campaign;
    }

    /**
     * @param integer $value the value for the variable
     *
     * @return \AppCore\Credit\Output\AbstractOutput
     */
    public function setZweck($value)
    {
        $this->_zweck = (int) $value;

        return $this;
    }

    /**
     * @return integer
     */
    public function getZweck()
    {
        return $this->_zweck;
    }

    /**
     * @param integer|string $value the new sparte
     *
     * @return \AppCore\Credit\Output\AbstractOutput
     */
    public function setSparte($value)
    {
        $this->_sparte = $value;

        $model = new \AppCore\Service\Sparten();
        $name  = $model->getName($value);
        $this->setSparteName($name);

        return $this;
    }

    /**
     * @return integer|string
     */
    public function getSparte()
    {
        return $this->_sparte;
    }

    /**
     * @param integer|string $value the new sparte
     *
     * @return \AppCore\Credit\Output\AbstractOutput
     */
    public function setSparteName($value)
    {
        $this->_sparteName = $value;

        return $this;
    }

    /**
     * @return integer|string
     */
    public function getSparteName()
    {
        return $this->_sparteName;
    }

    /**
     * @param boolean $value the value for the variable
     *
     * @return \AppCore\Credit\Output\AbstractOutput
     */
    public function setTeaserOnly($value)
    {
        $this->_teaserOnly = (boolean) $value;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getTeaserOnly()
    {
        return $this->_teaserOnly;
    }

    /**
     * @param boolean $value the value for the variable
     *
     * @return \AppCore\Credit\Output\AbstractOutput
     */
    public function setBestOnly($value)
    {
        $this->_bestOnly = (boolean) $value;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getBestOnly()
    {
        return $this->_bestOnly;
    }

    /**
     * @param integer $value the product id for the calculation
     *
     * @return \AppCore\Credit\Output\AbstractOutput
     */
    public function setOnlyProduct($value)
    {
        if (is_object($value)) {
            throw new Exception(
                'setOnlyProduct($value) requires Interger input'
            );
        }

        $this->_onlyProduct = (int) $value;

        return $this;
    }

    /**
     * @return integer
     */
    public function getOnlyProduct()
    {
        return $this->_onlyProduct;
    }

    /**
     * @param string $value the value for the variable
     *
     * @return \AppCore\Credit\Output\AbstractOutput
     */
    public function setOnlyInstitut($value)
    {
        $this->_onlyInstitut = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getOnlyInstitut()
    {
        return $this->_onlyInstitut;
    }

    /**
     * @param string $value the value for the variable
     *
     * @return \AppCore\Credit\Output\AbstractOutput
     */
    public function setInstitut($value)
    {
        $this->_institut = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getInstitut()
    {
        return $this->_institut;
    }

    /**
     * @param string $value the value for the variable
     *
     * @return \AppCore\Credit\Output\AbstractOutput
     */
    public function setProduct($value)
    {
        $this->_product = (int) $value;

        return $this;
    }

    /**
     * @return integer
     */
    public function getProduct()
    {
        return $this->_product;
    }

    /**
     * @param boolean $value the value for the variable
     *
     * @return \AppCore\Credit\Output\AbstractOutput
     */
    public function setTeaser($value)
    {
        $this->_isteaser = (boolean) $value;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getTeaser()
    {
        return $this->_isteaser;
    }

    /**
     * @param boolean $value the value for the variable
     *
     * @return \AppCore\Credit\Output\AbstractOutput
     */
    public function setInternal($value)
    {
        $this->_isinternal = (boolean) $value;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getInternal()
    {
        return $this->_isinternal;
    }

    /**
     * @param boolean $value the value for the variable
     *
     * @return \AppCore\Credit\Output\AbstractOutput
     */
    public function setModeName($value)
    {
        $this->_modeName = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getModeName()
    {
        return $this->_modeName;
    }

    /**
     * @param boolean $value the value for the variable
     *
     * @return \AppCore\Credit\Output\AbstractOutput
     */
    public function setTest($test)
    {
        $this->_test = (boolean) $test;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getTest()
    {
        return $this->_test;
    }

    /**
     * return kredit params
     *
     * @param string  $institut not used anymore
     * @param integer $product  the id for the product
     * @param boolean $teaser   if the product should be teased
     *
     * @return array
     */
    protected function getParams()
    {
        $arr = array(
            'kreditbetrag'   => $this->_kreditbetrag,
            'laufzeit'       => $this->_laufzeit,
            'vzweck'         => $this->_zweck,
            'partner_id'     => $this->_campaign,
            'kreditInstitut' => $this->_institut,
            'product'        => $this->_product,
            'mode'           => $this->_modeName,
            'sparte'         => $this->_sparteName
        );

        if ($this->_isteaser) {
            $arr['teaser'] = 1;
        }

        if ($this->_test) {
            $arr['unitest'] = 1;
        }

        return $arr;
    }

    /**
     * return kredit params
     *
     * @param string  $institut not used anymore
     * @param integer $product  the id for the product
     * @param boolean $teaser   if the product should be teased
     *
     * @return array
     */
    protected function getOfferParams()
    {
        $arr = $this->_helper->getParams();

        $arr['showAntrag'] = 1;

        return $arr;
    }

    /**
     * return kredit params
     *
     * @param string  $institut not used anymore
     * @param integer $product  the id for the product
     * @param boolean $teaser   if the product should be teased
     *
     * @return array
     */
    protected function getInfoParamsInternal()
    {
        $arr = $this->_helper->getParams();

        $arr['showAntrag'] = 1;

        return $arr;
    }

    /**
     * return kredit params
     *
     * @param string  $institut not used anymore
     * @param integer $product  the id for the product
     * @param boolean $teaser   if the product should be teased
     *
     * @return string
     */
    protected function cleanUpUrl($offerLnk)
    {
        $offerLnk = str_replace(
            '#BETRAG#',
            $this->_kreditbetrag,
            $offerLnk
        );

        $offerLnk = str_replace(
            '#LAUFZEIT#',
            $this->_laufzeit,
            $offerLnk
        );

        $offerLnk = str_replace(
            array('#timestamp#', '[timestamp]'),
            time(),
            $offerLnk
        );

        return $offerLnk;
    }

    /**
     * @return \AppCore\Credit\Output\AbstractOutput
     */
    public function getOfferLink(\AppCore\Model\CalcResult $result)
    {
        $baseUrl = rtrim(\Zend\Registry::get('_urlDir'), '/') . '/';

        $dummy = $this->getOfferLinkWithUrl($result, $baseUrl);

        $offerLnkSecure       = $dummy[0];
        $offerLnkSecureTeaser = $dummy[1];

        return $this->setOfferLinks(
            $result, $baseUrl, $offerLnkSecure, $offerLnkSecureTeaser
        );
    }

    /**
     * sets the created URLs  to the given object
     *
     * @param \AppCore\Model\CalcResult $result
     * @param string                      $baseUrl
     * @param string                      $offerLnkSecure
     * @param string                      $offerLnkSecureTeaser
     *
     * @return \AppCore\Credit\Output\AbstractOutput
     */
    protected function setOfferLinks(
        \AppCore\Model\CalcResult $result,
        $baseUrl,
        $offerLnkSecure = '',
        $offerLnkSecureTeaser = '')
    {
        //Redirect für Partner setzen (direkter Antrag)
        $result->offerLnk = $this->getLink(
            $baseUrl, $offerLnkSecure, $result, false
        );

        if ($this->_isteaser && $offerLnkSecureTeaser != '') {
            $result->offerLnk_teaser = $this->getLink(
                $baseUrl, $offerLnkSecureTeaser, $result, true
            );
        }

        return $this;
    }

    /**
     * creates the URL for the credit request form
     *
     * @param string                      $baseUrl
     * @param \AppCore\Model\CalcResult $result
     * @param boolean                     $teaser
     *
     * @return string
     */
    protected function getLink(
        $baseUrl,
        $offerLnk,
        \AppCore\Model\CalcResult $result,
        $teaser = false)
    {
        return $baseUrl
               . '?partner_id='     . $this->_campaign
               . '&kreditbetrag='   . $this->_kreditbetrag
               . '&laufzeit='       . $this->_laufzeit
               . '&vzweck='         . $this->_zweck
               . '&sparte='         . $this->_sparteName
               . '&kreditInstitut=' . $this->_institut
               . '&product='        . $result->product
               . (($teaser) ? '&teaser=1' : '')
               . '&internal='       . (int) $this->_isinternal
               . ($this->_test ? '&unitest=1' : '')
               . '&redirect='       . urlencode(utf8_encode($offerLnk));
    }

    /**
     * @return \AppCore\Credit\Output\AbstractOutput
     */
    public function getAntragsParams(\AppCore\Model\CalcResult $result)
    {
        $result->antragParams = $this->getOfferParams();

        return $this;
    }

    /**
     * @return \AppCore\Credit\Output\AbstractOutput
     */
    public function getInfoParams(\AppCore\Model\CalcResult $result)
    {
        $result->infoParams = $this->getInfoParamsInternal();

        return $this;
    }

    /**
     * @return \AppCore\Credit\Output\AbstractOutput
     */
    public function getInfoLink(\AppCore\Model\CalcResult $result)
    {
        //$baseUrl  = rtrim(\Zend\Registry::get('_urlDir'), '/') . '/';
        //$infoLink = $baseUrl . 'kreditrechner-informationen-zum-anbieter.html';
        $infoLink = rtrim($this->_urlDirInfo, '/')
                        . (substr($this->_urlDirInfo, -5) == '.html'
                        ? '' : '/kredite.html');

        $infoParams = $this->getInfoParamsInternal();

        $infoParams['offerLnk']       = $result->offerLnk;
        $infoParams['partner_id']     = $this->_caid;
        $infoParams['kreditInstitut'] = $this->_institut;
        $infoParamsTeaser             = array();

        $infoLnk = \AppCore\Globals::postToGetUrl(
            $infoLink,
            $infoParams
        );

        $infoLnkTeaser = '';

        if ($this->_isteaser) {
            $infoParamsTeaser = $this->getInfoParamsInternal();

            $infoParamsTeaser['offerLnk']       = $result->offerLnk_teaser;
            $infoParamsTeaser['partner_id']     = $this->_caid;
            $infoParamsTeaser['kreditInstitut'] = $this->_institut;

            $infoLnkTeaser = \AppCore\Globals::postToGetUrl(
                $infoLink,
                $infoParamsTeaser
            );
        }

        $result->infoLnk = $infoLnk;

        if ($this->_isteaser) {
            $result->infoLnk_teaser = $infoLnkTeaser;
        }

        return $this;
    }

    /**
     * @return array
     */
    protected function getOfferLinkWithUrl(
        \AppCore\Model\CalcResult $result, $baseUrl)
    {
        $int = (\Zend\Registry::get('_urlDir') == \Zend\Registry::get('_home'));

        if ($this->_isinternal) {
           //interne URL für Angebot verwenden, Link in DB ignorieren
            $offerLnk       = $baseUrl;
            $offerLnkTeaser = $offerLnk;
        } else {
            //URL für Angebot auslesen
            $offerLnk       = (string) $result->url;
            $offerLnkTeaser = (string) $result->url_teaser;

            if ('' == $offerLnkTeaser) {
                $offerLnkTeaser = $offerLnk;
            }
        }

        if (!$this->_isteaser) {
            $offerLnkTeaser = '';
        }

        $offerLnk = $this->cleanUpUrl($offerLnk);

        if ($offerLnkTeaser != '') {
            $offerLnkTeaser = $this->cleanUpUrl($offerLnkTeaser);
        }

        if ($this->_isinternal) {
            $antragParams = $this->getOfferParams();

            $offerLnk = \AppCore\Globals::postToGetUrl(
                $offerLnk, $antragParams, $int
            );

            if ($offerLnkTeaser != '') {
                $antragParams           = $antragParams;
                $antragParams['teaser'] = 1;

                $offerLnkTeaser = \AppCore\Globals::postToGetUrl(
                    $offerLnkTeaser, $antragParams, $int
                );
            }
        }

        $offerLnkSecure       = $offerLnk;
        $offerLnkSecureTeaser = $offerLnkTeaser;

        return array($offerLnkSecure, $offerLnkSecureTeaser);
    }

    /**
     * sets the base url
     *
     * @return \AppCore\Credit\Output\AbstractOutput
     */
    protected function getBaseUrl()
    {
        $this->_baseUrl = rtrim($this->_urlDirAntrag, '/')
                        . (substr($this->_urlDirAntrag, -5) == '.html'
                        ? '' : '/');

        return $this;
    }
}