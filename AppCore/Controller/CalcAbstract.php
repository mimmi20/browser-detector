<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Controller;

/**
 * Controller-Klasse zum Ausliefern von Javascript-Dateien
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Controller
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id$
 */

use Zend\Controller\Request\AbstractRequest,
    Zend\Controller\Response\AbstractResponse;

/**
 * Controller-Klasse zum Ausliefern von Javascript-Dateien
 *
 * @category  Kreditrechner
 * @package   Controller
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @abstract
 */
abstract class CalcAbstract extends ControllerAbstract
{
    /**
     * Code for the Partner
     *
     * @var string
     */
    protected $_partnerId = '';//partner-ID

    /**
     * Code for an Campaign of an Partner
     *
     * @var string
     */
    protected $_campaignId = '';//campaign-ID

    /**
     * ein File-Cache Object
     *
     * @var Zend_Cache_Core
     */
    protected $_cache = null;

    /**
     * ID der Sparte
     *
     * @var integer
     */
    protected $_sparte = 0;

    /**
     * Name der Sparte
     *
     * @var string
     */
    protected $_categoriesName = '';

    /**
     * ID des Verwendungszweckes
     *
     * @var integer
     */
    protected $_zweck = KREDIT_VERWENDUNGSZWECK_SONSTIGES; //Default: sonstiges

    /**
     * gewuenschter Kreditbetrag
     *
     * @var integer
     */
    protected $_betrag = KREDIT_KREDITBETRAG_DEFAULT;

    /**
     * gewuenschte Laufzeit
     *
     * @var integer
     */
    protected $_laufzeit = KREDIT_LAUFZEIT_DEFAULT;

    /**
     * Name der Institutes
     *
     * @var string
     */
    protected $_institut = '';

    /**
     * Typ der Aktion
     *
     * @var string
     */
    protected $_type = 'pageimpression';

    /**
     * @var boolean
     */
    protected $_bestOnly = false;

    /**
     * @var boolean
     */
    protected $_boni = false;

    /**
     * Typ der Funktion, die ausgefuehrt werden soll
     *
     * @var    string
     * @access protected
     */
    protected $_function = 'calc';

    /**
     * initializes the Controller
     *
     * @return void
     * @access public
     */
    public function init()
    {
        parent::init();
        
        $this->_config = new \Zend\Config\Config($this->getInvokeArg('bootstrap')->getOptions());
    }

    /**
     * (non-PHPdoc)
     *
     * @see    library/Zend/Controller/Zend_Controller_Action#preDispatch()
     * @return void
     * @access public
     */
    public function preDispatch()
    {
        parent::preDispatch();

        $this->_helper->agentLogger();
        $this->_helper->requestLogger();

        /*
         * block access to Calculation Controllers, if this is the Admin Server
         * if a calculation is needed use the needed objects directly
         */
        if ($this->_config->admin->enabled && $this->_config->admin->isAdmin) {
            $this->_helper->header->setErrorHeaders();

            return;
        }

        if ('iframe' != $this->_controller && 'kredit' != $this->_controller) {
            $this->_helper->viewRenderer->setNoRender();
            //$this->_helper->layout->disableLayout();
        }

        //set headers
        if ($this->_response->canSendHeaders()) {
            $this->_response->setHeader('robots', 'noindex,follow', true);
            $this->_response->setHeader(
                'Cache-Control', 'public, max-age=3600', true
            );
        }

        $this->_getDefaultParams();

        $this->_cache = \Zend\Registry::get('_fileCache');
    }

    /**
     * get the needed default params
     *
     * @return void
     */
    private function _getDefaultParams()
    {
        $this->_paid   = (int) $this->_helper->getParam('paid', 0, 'Int');
        $this->_caid   = (int) $this->_helper->getParam('caid', 0, 'Int');
        $this->_sparte = (int) $this->_helper->getParam(
            'sparte',
            KREDIT_SPARTE_KREDIT,
            'Int'
        );
        $this->_zweck  = (int) $this->_helper->getParam(
            'vzweck',
            KREDIT_VERWENDUNGSZWECK_SONSTIGES,
            'Int'
        );
        $this->_betrag = (int) $this->_helper->getParam(
            'kreditbetrag', KREDIT_KREDITBETRAG_DEFAULT, 'Int'
        );

        $this->_partnerId   = strtolower(
            $this->_helper->getParam('partner_id', '', 'Alpha')
        );
        $this->_campaignId = strtolower(
            $this->_helper->getParam('campaign_id', '', 'Alpha')
        );
        $this->_categoriesName = strtolower(
            $this->_helper->getParam('categoriesName', '', 'Alpha')
        );
        $this->_institut = strtolower(
            $this->_helper->getParam('kreditinstitut', '', 'Alpha')
        );
        $this->_mode = strtolower($this->_helper->getParam('mode', 'html', 'Alpha'));

        $this->_laufzeit = (int) $this->_helper->getParam(
            'laufzeit',
            \AppCore\Globals::getDefaultLaufzeit($this->_sparte),
            'Int'
        );

        unset($this->_requestData['module']);
        unset($this->_requestData['controller']);
        unset($this->_requestData['action']);
        unset($this->_requestData['krediturl']);
        unset($this->_requestData['antragurl']);
        unset($this->_requestData['infourl']);

        if (!isset($this->_requestData['IP'])) {
            $this->_requestData['IP'] = $this->_request->getParam('IP');
        }

        if (!isset($this->_requestData['agent'])) {
            $this->_requestData['agent'] = $this->_request->getParam('agent');
        }
    }


    /**
     * indexAction-Methode wird aufgerufen wenn keine Action angegeben wurde
     *
     * @return void
     * @access public
     */
    public function indexAction()
    {
        $this->index();
    }

    /**
     * recreates the credit form for an recalculation
     *
     * @return void
     * @access public
     */
    public function formAction()
    {
        //set headers
        $this->_helper->header->setErrorHeaders();
    }

    /**
     * logs Clicks into the database
     *
     * @return void
     * @access public
     */
    public function validateAction()
    {
        $this->_response->setBody($this->doValidate());
    }

    /**
     * formats the content string for the spefied output
     *
     * @param string  $text the text to format
     *
     * @return string the formated output
     * @access protected
     */
    protected function format($text)
    {
        if (APPLICATION_ENV == SERVER_ONLINE_LIVE) {
            $text = str_replace("\t", ' ', $text);
            $text = preg_replace('/\s\s+/', ' ', $text);
            $text = trim($text);
        }

        return $text;
    }

    /**
     * indexAction for curl or iframe mode
     *
     * @return void
     * @access protected
     */
    protected function index()
    {
        $this->_helper->viewRenderer->setNoRender();

        if (isset($this->_requestData['logClick'])) {
            $this->_helper->header->setErrorHeaders();
            return;
        }

        $output = '';

        switch (true) {
            case 'calc' == $this->_function:
                $this->_type                = 'pageimpression';
                $this->_requestData['type'] = 'pageimpression';

                $output = $this->calculate();

                $this->_helper->calcLogger($this->_type);
                break;
            case 'info' == $this->_function:
                $this->_type                = 'info';
                $this->_requestData['type'] = 'info';

                $output = $this->getInfo();

                $this->_helper->calcLogger($this->_type);
                break;
            case 'antrag' == substr($this->_function, 0, 6):
                $this->_type                = 'clickout';
                $this->_requestData['type'] = 'clickout';

                try {
                    $output = $this->getAntrag();
                } catch (Exception $e) {
                    $this->_logger->err($e);

                    $output = '';
                    $this->_helper->header->setErrorHeaders();
                }
                break;
            default:
                $this->_helper->header->setErrorHeaders();
                break;
        }

        $this->_response->setBody($output);
    }

    /**
     * starts an recalculation
     *
     * @return string    The rendered Calculation Content
     * @access protected
     */
    protected function calculate()
    {
        if ($this->_institut) {
            $institut                           = strtolower($this->_institut);
            $this->view->institut               = $institut;
            $this->_requestData['OnlyInstitut'] = $institut;
        } else {
            $this->view->institut = '';
        }

        $this->_bestOnly = (boolean) $this->_helper->getParam('bestOnly', 0, 'Int');
        $this->_boni     = $this->_helper->getParam('boni', null, 'Int');

        //$this->_logger->info($this->_helper->getParam('boni', null, 'Int'));
        //$this->_logger->info($this->_helper->getParam('boni'));

        $this->view->bestOnly = $this->_bestOnly;
        $this->view->boni     = $this->_boni;
        $this->view->hostName = $this->_hostName;

        $noResult = (boolean) $this->_helper->getParam('noResult', 0, 'Int');

        $modelCampaign = new \AppCore\Model\Campaigns();
        $active        = $modelCampaign->checkCaid($this->_caid, false);

        if ($noResult || !$active) {
            /*
             * the request is marked to be not calculated or
             * the given campaign is not activated
             * -> the calculation is skipped
             */
            $ergebnis = array();
        } else {
            $ergebnis = $this->doCalculate();
        }

        if ($this->_mode == 'xml' || $this->_mode == 'fallback') {
            return \AppCore\Globals::serializeXml($ergebnis);
        }

        //var_dump($ergebnis);

        $this->view->ergebnis     = $ergebnis;
        $this->view->kreditbetrag = $this->_betrag;
        $this->view->laufzeitName = $this->_helper->laufzeit->name($this->_laufzeit);
        $this->view->vzweckLabel  = $this->_helper->usage->name($this->_zweck);

        if ($this->_sparte == KREDIT_SPARTE_KREDIT) {
            $alleLaufzeiten = array(12, 24, 36, 48, 60, 72, 84);
        } else {
            $alleLaufzeiten = array(12);
        }

        $alz = array();

        foreach ($alleLaufzeiten as $lz) {
            $alz[$lz] = $this->_helper->laufzeit->name($lz);
        }

        $this->view->alleLaufzeiten = $alz;
        $this->view->url            = \Zend\Registry::get('_urlDir');
        $this->view->sparte         = $this->_categoriesName;
        $this->view->sparteId       = $this->_sparte;
        $this->view->laufzeit       = $this->_laufzeit;
        $this->view->zweck          = $this->_zweck;
        $this->view->betrag         = $this->_betrag;
        $this->view->paid           = $this->_paid;
        $this->view->caid           = $this->_caid;
        $this->view->partnerId      = $this->_partnerId;
        $this->view->campaignId     = $this->_campaignId;
        $this->view->mode           = $this->_mode;
        $this->view->step           = 'calc';

        $calcText = $this->format(
            $this->view->getPortaleFile(
                $this->_partnerId,
                $this->_campaignId,
                $this->_mode,
                'calc' . DS . $this->_categoriesName,
                true
            )
        );

        if ('curl' == $this->_mode
            || 'iframe' == $this->_mode
        ) {
            /*
             * includes the complete Content
             * -> no extra parsing needed
             */
            return $calcText;
        }

        $this->view->calcText = $calcText;

        return $this->view->render($this->_mode . '/calc.phtml');
    }

    /**
     * starts an recalculation
     *
     * @return string    The rendered Calculation Content
     * @access protected
     */
    protected function doCalculate()
    {
        $usages     = $this->getUsageList();
        $laufzeiten = $this->getLaufzeitList();
        $laufzeit   = number_format($this->_laufzeit, 1);

        if ($this->_betrag < KREDIT_BETRAG_MIN
            || $this->_betrag > KREDIT_BETRAG_MAX
            || !array_key_exists($this->_zweck, $usages)
            || !array_key_exists($laufzeit, $laufzeiten)
        ) {
            return array();
        }

        $teaserOnly   = (boolean) $this->_helper->getParam('teaserOnly', 0, 'Int');
        $onlyInstitut = $this->_helper->getParam('OnlyInstitut', '', 'Alpha');
        $onlyProduct  = $this->_helper->getParam('OnlyProduct', 0);

        $calculator = new \AppCore\Credit\Calc();
        $calculator
            ->setView($this->view)
            ->setCaid($this->_caid)
            ->setSparte($this->_sparte)
            ->setLaufzeit($this->_laufzeit)
            ->setZweck($this->_zweck)
            ->setKreditbetrag($this->_betrag)
            ->setMode($this->_mode)
            ->setBestOnly($this->_bestOnly)
            ->setBonus($this->_boni)
            ->setTeaserOnly($teaserOnly)
            ->setOnlyProduct($onlyProduct)
            ->setOnlyInstitut($onlyInstitut)
            ->setTest(
                (isset($this->_requestData['unitest'])
                && $this->_requestData['unitest']) ? true : false
            );

        try {
            return $calculator->calc();
        } catch (Exception $e) {
            $this->_logger->err($e);

            return null;
        }
    }

    /**
     * recreates the credit form for an recalculation
     *
     * @return string    The rendered Form Content
     * @access protected
     */
    protected function getForm()
    {
        $this->view->caid     = $this->_campaignId;
        $this->view->paid     = $this->_partnerId;
        $form                 = strtolower(
            $this->_helper->getParam(
                'form',
                'Normal',
                'Alpha'
            ) . 'form'
        );
        $this->view->form     = $form;
        $this->view->sparte   = $this->_categoriesName;
        $this->view->sparteId = $this->_sparte;
        $this->view->laufzeit = $this->_laufzeit;
        $this->view->zweck    = $this->_zweck;
        $this->view->betrag   = $this->_betrag;
        $this->view->mode     = strtolower($this->_mode);

        $this->view->alleLaufzeiten   = $this->getLaufzeitList();
        $this->view->aktuelleLaufzeit = $this->_laufzeit;
        $this->view->alleZwecke       = $this->getUsageList();
        $this->view->aktuellerZweck   = $this->_zweck;
        $this->view->aktuellerBetrag  = $this->_betrag;

        unset($this->_requestData['Agent']);
        unset($this->_requestData['agent']);
        unset($this->_requestData['laufzeit']);
        unset($this->_requestData['vzweck']);
        unset($this->_requestData['kreditbetrag']);
        unset($this->_requestData['target']);
        unset($this->_requestData['screen_wide']);
        unset($this->_requestData['screen_height']);
        unset($this->_requestData['submit']);

        $name                 = 'creditCalc';
        $this->view->formName = $name;

        if ($this->_mode == 'html') {
            $this->view->action = 'javascript:void(0);';
            $this->view->submit = '';
        } elseif ($this->_mode == 'js') {
            $this->view->action = 'javascript:void(0);';//$action;
            $this->view->submit = 'var a=jQuery(\'#kreditbetrag\').val();'
                                . 'if(a!=\'\' && !isNaN(a) && '
                                . '!jQuery(\'#kreditbetrag\').has'
                                . 'Class(\'error\')) {'
                                . 'var u=jQuery(\'#vzweck\').val();'
                                . 'var t=jQuery(\'#laufzeit\').val();'
                                . 'calc(u, t, a);}';
        } else {
            $this->view->action = '';
            $this->view->submit = '';
        }

        $this->view->requestData = $this->_requestData;
        $this->view->formText = $this->format(
            $this->view->getPortaleFile(
                $this->_partnerId,
                $this->_campaignId,
                $this->_mode,
                $form,
                true
            )
        );

        return $this->view->render($this->_controller . '/form.phtml');
    }

    /**
     * get the information about an institute and its credits
     *
     * @return string
     * @access protected
     */
    protected function getAntrag()
    {
        if ($this->_config->sitecache->enable) {
            //Cancel the Caching for this function
            $cache = \Zend\Registry::get('siteCache');
            $cache->cancel();
        }

        $productId = (int) $this->_helper->getParam('product', 0, 'Int');

        if (!$productId) {
            $this->view->antragText = '<!-- no information found -->';
            return $this->view->render($this->_controller . '/antrag.phtml');
        }

        $antragText   = '';
        $productModel = new \AppCore\Service\Products();

        $ok = $productModel->lade(
            $productId, $this->_institut, $this->_categoriesName
        );

        if (!$ok) {
            $this->view->antragText = '<!-- no information found -->';
            return $this->view->render($this->_controller . '/antrag.phtml');
        }

        $this->view->sparte     = $this->_categoriesName;
        $this->view->sparteId   = $this->_sparte;
        $this->view->paid       = $this->_paid;
        $this->view->caid       = $this->_caid;
        $this->view->partnerId  = $this->_partnerId;
        $this->view->campaignId = $this->_campaignId;
        $this->view->mode       = strtolower($this->_mode);

        $this->_institut = strtolower($this->_institut);
        $instituteModel  = new \AppCore\Model\Institute();
        $instituteName   = $instituteModel->getName(
            $instituteModel->getId($this->_institut)
        );

        $this->view->instituteCode = $this->_institut;
        $this->view->institut      = $instituteName;
        $this->view->product       = $productId;
        $this->view->zweck         = $this->_zweck;
        $this->view->betrag        = $this->_betrag;
        $this->view->laufzeit      = $this->_laufzeit;
        $this->view->kreditbetrag  = $this->_betrag;
        $this->view->mode          = $this->_mode;

        $step = (int) $this->_helper->getParam('kredit_antrag', KREDIT_ANTRAG_STEPS_FIRST, 'Int');

        $isTest = (boolean) ($this->_helper->getParam('isTest')
            || (
                (isset($this->_requestData['unitest'])
                && $this->_requestData['unitest']) ? true : false
            )
        );

        $anzahl = (int) $this->_helper->getParam(
            'anzahl',
            0,
            'Int'
        );

        $ip = $this->_helper->getParam('IP', '0.0.0.0', 'Ip');

        try {
            $antragGenerator = new \AppCore\Credit\Antrag();

            $antragGenerator
                ->setCaid($this->_caid)
                ->setSparte($this->_sparte)
                ->setLaufzeit($this->_laufzeit)
                ->setZweck($this->_zweck)
                ->setKreditbetrag($this->_betrag)
                ->setMode($this->_mode)
                ->setProduct($productId)
                ->setStep($step)
                ->setView($this->view)
                ->setIp($ip)
                ->setRequestData($this->_requestData)
                ->setTest((int) $isTest);

            $data = $antragGenerator->antrag();
        } catch (Exception $e) {
            $this->_logger->err($e);

            $data = array();
        }

        $isTest = $isTest || ((isset($data['test']))
                ? (boolean) $data['test']
                : false);

        if (isset($data['requestData']) && is_array($data['requestData'])) {
            $this->_requestData = array_merge(
                $this->_requestData,
                $data['requestData']
            );
        }

        $this->_requestData['boniLevel'] = ((isset($data['boniLevel']))
                                         ? $data['boniLevel']
                                         : 'medium');

        $this->view->requestData  = $this->_requestData;
        $key                      = ((isset($data['key'])) ? $data['key'] : '');
        $this->view->vzweckLabel  = ((isset($data['vzweckLabel']))
                                  ? $data['vzweckLabel']
                                  : '');
        $this->view->laufzeitName = ((isset($data['laufzeitName']))
                                  ? $data['laufzeitName']
                                  : '');
        $this->view->kreditbetrag = $this->_betrag;
        $this->view->nextStep     = ((isset($data['nextStep']))
                                  ? $data['nextStep']
                                  : KREDIT_ANTRAG_STEPS_LAST);
        $this->view->rate         = ((isset($data['rate']))
                                  ? $data['rate']
                                  : 'k.A.');
        $this->view->prozent      = ((isset($data['prozent']))
                                  ? $data['prozent']
                                  : 'k.A.');
        $this->view->anzahl       = $anzahl;

        if (isset($data['kreditResult']) && is_array($data['kreditResult'])) {
            $keys = array_keys($data['kreditResult']);
            if (isset($keys[0])) {
                $key = $keys[0];

                $this->view->kreditResult = $data['kreditResult'][$key];
            } else {
                $this->view->kreditResult = array();
            }
        } else {
            $this->view->kreditResult = array();
        }

        if (isset($data['anrede'])) {
            $this->view->anrede = $data['anrede'];
        }
        if (isset($data['vorname'])) {
            $this->view->vorname = $data['vorname'];
        }
        if (isset($data['nachname'])) {
            $this->view->nachname = $data['nachname'];
        }

        $this->view->berufsgruppe = \AppCore\Globals::getProfession();

        $profession    = (int) $this->_helper->getParam(
            'kn1_berufsgruppe', KREDIT_BERUFSGRUPPE_KEINE, 'Int'
        );
        $professionTwo = (int) $this->_helper->getParam(
            'kn2_berufsgruppe', KREDIT_BERUFSGRUPPE_KEINE, 'Int'
        );
        $this->view->selectedProfession    = $profession;
        $this->view->selectedProfessionTwo = $professionTwo;
        $this->view->branche       = \AppCore\Globals::$generalBranches;
        $this->view->familyState   = \AppCore\Globals::$generalFamily;
        $this->view->nationality   = \AppCore\Globals::$generalStates;
        $this->view->monate        = \AppCore\Globals::$generalMonths;
        $this->view->wohneigentum  = \AppCore\Globals::$generalWohneigentum;
        $this->view->wohnsituation = \AppCore\Globals::$generalWohnsituation;
        $this->view->wohnhaftSeitM = \AppCore\Globals::$generalMonths;
        $this->view->ecCards       = \AppCore\Globals::$generalEcCards;
        $this->view->wohnhaftSeitJ = \AppCore\Globals::wohnhaftSeitJ();

        if (isset($data['kreditResult'][$key])) {
            $this->view->antragData = $data['kreditResult'][$key];

            if ($data['kreditResult'][$key]->teaser
                && $data['kreditResult'][$key]->urlTeaser
            ) {
                $url = $data['kreditResult'][$key]->urlTeaser;
            } else {
                $url = $data['kreditResult'][$key]->url;
            }
            $url = str_replace('#BETRAG#', $this->_betrag, $url);
            $url = str_replace('#LAUFZEIT#', $this->_laufzeit, $url);

            $action = $url;
        } else {
            $action = '';
        }

        $this->view->action = 'javascript:void();';

        if (isset($data['kreditResult'][$key])) {
            $this->view->antragData = $data['kreditResult'][$key];
        }

        if (isset($data['kreditResult'][$key])
            && isset($data['kreditResult'][$key]->internal)
            && !$data['kreditResult'][$key]->internal
        ) {
            $this->view->redirect = $action;
        } else {
            $this->view->step = ((isset($data['file'])) ? $data['file'] : '');

            $antragText = $this->view->getPortaleFile(
                $this->_partnerId,
                $this->_campaignId,
                $this->_mode,
                ((isset($data['file'])) ? 'antrag/' . $data['file'] : ''),
                true
            );

            //$this->_logger->info($antragText);

            $antragText = $this->format($antragText);

            $antragText = str_replace(
                '###HOME_URL###',
                \Zend\Registry::get('_home'),
                $antragText
            );
        }

        $this->view->antragText = $antragText;

        //selbst gesetzte Parameter wieder holen
        $agentId   = $this->_helper->getParam('agentId');
        $spider    = (boolean) $this->_helper->getParam('spider');
        $crawler   = (boolean) $this->_helper->getParam('crawler');
        $requestId = (int) $this->_helper->getParam('requestId');
        $type      = ((isset($data['type'])) ? $data['type'] : 'click');

        \AppCore\Globals::log(
            $requestId,
            $productId,
            $this->_institut,
            $type,
            $this->_betrag,
            $this->_laufzeit,
            $this->_zweck,
            $this->_caid,
            $this->_sparte,
            $agentId,
            $spider,
            $crawler,
            $this->_requestData,
            $isTest
        );

        return $this->view->render($this->_controller . '/antrag.phtml');
    }

    /**
     * get the information about an institute and its credits
     *
     * @return void
     * @access protected
     */
    protected function getInfo()
    {
        $this->view->sparte     = $this->_categoriesName;
        $this->view->sparteId   = $this->_sparte;
        $this->view->paid       = $this->_paid;
        $this->view->caid       = $this->_caid;
        $this->view->partnerId  = $this->_partnerId;
        $this->view->campaignId = $this->_campaignId;
        $this->view->product    = (int) $this->_helper->getParam('product', 0, 'Int');
        $this->view->mode       = strtolower($this->_mode);

        $infoObj = new \AppCore\Credit\Info();
        $infoObj->setLaufzeit($this->_laufzeit);
        $infoObj->setMode($this->_mode);
        if (is_object($this->view)) {
            $infoObj->setView($this->view);
        }
        $infoObj->setSparte($this->_categoriesName);
        $infoObj->setProduct($this->view->product);
        $ergebnis = $infoObj->info(true, null);

        $this->view->infoText = $this->format($ergebnis);

        return $this->view->render($this->_controller . '/info.phtml');
    }

    /**
     * logs Clicks into the database
     *
     * @return string
     * @access protected
     */
    protected function doValidate()
    {
        $this->_request->setParamSources(array('_GET', '_POST'));
        $this->_helper->getParams();

        $field = $this->_helper->getParam('field', '', 'Alnum');

        if (!$field || !isset($this->_requestData[$field])) {
            //das angefragte Feld ist nicht vorhanden
            $this->_helper->header->setErrorHeaders();

            return;
        }

        if ($this->_config->sitecache->enable) {
            //Cancel the Caching for this function
            $cache = \Zend\Registry::get('siteCache');
            $cache->cancel();
        }

        $validator = array('NotEmpty');

        switch ($field) {
            case 'strasse':
                $strassenValidator = new \\AppCore\\Class\Validate\Alpha();
                $validator[]       = $strassenValidator;
                break;
            case 'plz':
                // Break intentionally omitted
            case 'PLZ':
                $plzValidator = new \\AppCore\\Class\Validate\Plz();
                $validator[]  = 'Int';
                $validator[]  = $plzValidator;
                break;
            case 'vorwahl':
                // Break intentionally omitted
            case 'telefon':
                // Break intentionally omitted
            case 'vorwahlmobil':
                // Break intentionally omitted
            case 'mobilfunk':
                // Break intentionally omitted
            case 'berufsgruppe':
                $validator[] = 'Int';
                break;
            case 'ort':
                $ortValidator = new \\AppCore\\Class\Validate\Ort();
                $validator[]  = $ortValidator;
                break;
            case 'email':
                $validator[] = 'EmailAddress';
                break;
            case 'gebdatum':
                $dateValidat = new \\AppCore\\Class\Validate\Birthday('d.m.Y');
                $validator[] = $dateValidat;
                break;
            case 'besch_bis':
                $dateValidator = new \\AppCore\\Class\Validate\Date('d.m.Y');
                $validator[]   = $dateValidator;
                break;
            default:
                $validator[] = 'Alpha';
                break;
        }

        $fieldValue = $this->_helper->getParam($field, '', $validator);
        $antwort    = false;

        if ($fieldValue != '') {
            $antwort = true;
        }

        $callback = $this->_helper->getParam('callback', '', 'Alnum');

        return $callback . '(' . json_encode($antwort) . ');';
    }

    /**
     * liefert alle möglichen Laufzeiten
     *
     * @return array
     * @access protected
     */
    protected function getLaufzeitList()
    {
        $modelLaufzeit = new \AppCore\Model\Laufzeit();

        return $modelLaufzeit->getList($this->_sparte);
    }

    /**
     * returns a list of possible usages
     *
     * @return array
     * @access protected
     */
    protected function getUsageList()
    {
        $usageModel = new \AppCore\Model\Usage();

        return $usageModel->getList();
    }

    /**
     * liefert den Namen zu einer Laufzeit
     *
     * @param integer $laufzeit the Laufzeit
     *
     * @return string
     * @access protected
     */
    protected function getLaufzeitName($laufzeit = KREDIT_LAUFZEIT_DEFAULT)
    {
        $modelLaufzeit = new \AppCore\Model\Laufzeit();

        return $modelLaufzeit->name($this->_sparte, $laufzeit);
    }

    /**
     * returns he name for a specific usage
     *
     * @param integer $usage the usage id
     *
     * @return string
     * @access protected
     */
    protected function getUsage($usage = KREDIT_VERWENDUNGSZWECK_SONSTIGES)
    {
        $usageModel = new \AppCore\Model\Usage();

        return $usageModel->name($usage);
    }

    /**
     * initialze Session
     *
     * loads the session options, defines session save handler and starts a new
     * session
     *
     * @access protected
     * @return void
     */
    protected function initSession()
    {
        //Session
        Zend_Session::setOptions($this->_config->session->toArray());
        Zend_Session::setSaveHandler(
            new KreditCore_Class_Session_SaveHandler_Db(
                \Zend\Db\Table\AbstractTable::getDefaultAdapter(),
                $this->_config->sessionparams->toArray()
            )
        );
        Zend_Session::start();

        //TODO: length of session id depends on session config
        if (strlen(session_id()) != 32) {
            Zend_Session::regenerateId();
        }

        $session = new Zend_Session_Namespace('KREDIT');
        \Zend\Registry::set('session', $session);
    }

    /**
     * sets the campaign id and the partner id
     *
     * @return KreditCore_Controller_CalcAbstract
     */
    protected function getCampaignId()
    {
        $this->_caid = (int) $this->_helper->getCampaignId();

        $this->_requestData['paid'] = $this->_caid;
        $this->_paid                = $this->_caid;

        return $this;
    }
}