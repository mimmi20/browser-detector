<?php
/**
 * Controller-Klasse für die Statistik
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Controller
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id$
 */

/**
 * Controller-Klasse für die Statistik
 *
 * @category  Kreditrechner
 * @package   Controller
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class KreditAdmin_StatisticsController
    extends KreditCore_Controller_AdminAbstract
{

    /**
     * @var KreditAdmin_Class_Statistics_Adapter_ApplicationStatus
     */
    private $_statisticAppStatus;

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

        $this->loadJs();

        $this->_statisticAppStatus =
            new KreditAdmin_Class_Statistics_Adapter_ApplicationStatus();

        $this->_fillMandantFilter();
    }

    /**
     * Index Action
     *
     * @return void
     */
    public function indexAction()
    {
        $form = new KreditAdmin_Form_StatistikFilter();

        if ($this->_getParam('submit') == 'Senden') {
            if ($form->isValid($this->_request->getParams())) {
                $filter = $form->getValues();

                $this->view->statistiken = array(
                    'anzahl'        => 'Anzahl Anträge',
                    'jahresbeitrag' => 'Jahresbeitrag',
                    'provision'     => 'Provision',
                );

                $rit = \\AppCore\\Model\Interface::getInterfacesTarifs(
                    $filter['date_start'], $filter['date_end']
                );

                $interfacesTarifs = array();
                foreach ($rit as $value) {
                    $interfacesTarifs[$value['name']][] = array(
                        'tarif_name' => $value['tarif_name'],
                        'id_tarif'   => $value['id_tarif'],
                    );
                }

                $statisticsTarifsCount = $this->calculateTarifsCount(
                    $interfacesTarifs
                );

                $statistics          = $this->getStatistics($filter);
                $statisticsSubtotals = $this->calculateSubtotals($statistics);
                $statisticsTotals    = $this->calculateTotals($filter);

                $this->view->statsTable          = $statistics;
                $this->view->subTotalsTable      = $statisticsSubtotals;
                $this->view->subTotalsCountTable = $statisticsTarifsCount;
                $this->view->totalsTable         = $statisticsTotals;

                $statsVerteilungPortale       = $this->getStatisticsVerteilungPortale($filter);
                $statsVerteilungPortaleTotals = $this->getStatisticsVerteilungPortaleTotals($statsVerteilungPortale);

                $this->view->statVerteilungTable       = $statsVerteilungPortale;
                $this->view->statVerteilungTotalsTable = $statsVerteilungPortaleTotals;

                $statBerechnungenVerteilungPortale                  = $this->getStatisticsBerechnungenVerteilungPortale($filter);
                $this->view->statBerechnungenVerteilungPortaleTable = $statBerechnungenVerteilungPortale;


                $this->view->statBerechnungenVPTotals = $this->getStatisticsBerechnungenVerteilungPortaleTotals($statBerechnungenVerteilungPortale);

                $partnerModel = new \App\Model\Partner();
                $this->view->partnerTable = $partnerModel->fetchAll()->toArray();

                $this->view->tarifsTable = $interfacesTarifs;
            }
        }

        $this->view->headTitle('Statistik', 'PREPEND');

        $this->getResponse()->insert('options', '');

        $this->view->filterform = $form;
    }

    /**
     * neue grafische Statistik
     *
     * @return void
     */
    public function newAction()
    {
        $this->_setDefaultFilter();

        $sparte                  = $this->_getParam('sparteValue', 'Kredit');
        $this->view->sparteValue = $sparte;

        $this->view->headTitle('neue Statistik', 'PREPEND');

        $this->getResponse()->insert(
            'options', $this->view->render('statistics/options.phtml')
        );
    }

    /**
     * Overview Action
     *
     * @return void
     */
    public function overviewAction()
    {
        //$this->_helper->layout->disableLayout();

        $sparte = ucfirst(
            strtolower(
                $this->_getParam('sparteValue', 'Kredit')
            )
        );
        $detailValue = strtolower($this->_getParam('detailValue', 'click'));

        $modelSparte = new \App\Model\Sparten();
        $s           = $modelSparte->find($sparte);
        $sparte      = '';

        if (null !== $s) {
            $s      = $s->current();

            if (is_object($s)) {
                $sparte = $s->name;
            }
        }

        $this->view->sparte = $sparte;
        $this->view->type   = $detailValue;
    }

    /**
     * neue Overview Action
     *
     * @return void
     */
    public function overviewNewAction()
    {
        //$this->_helper->layout->disableLayout();

        $sparte = ucfirst(
            strtolower($this->_getParam('sparteValue', 'Kredit'))
        );
        $detailValue = strtolower($this->_getParam('detailValue', 'click'));

        $this->view->sparte = $sparte;
        $this->view->type   = $detailValue;
    }

    /**
     * Action für Ajax-Requests aus der Tabellen-Statistik
     *
     * @return void
     */
    public function overviewdetailAction()
    {
        $this->initAjax();

        $sparte = ucfirst(
            strtolower($this->_getParam('sparteValue', 'Kredit'))
        );
        $detailValue = strtolower($this->_getParam('detailValue', 'click'));
        $type        = $this->_getParam('type', '');
        $campaigns   = $this->_getParam('campaigns', '');

        if ($type != '' && $campaigns != '') {

            $campaigns = str_replace(',,', ',', $campaigns);

            if (substr($campaigns, 0, 1) == ',') {
                $campaigns = substr($campaigns, 1);
            }

            if (substr($campaigns, -1) == ',') {
                $campaigns = substr($campaigns, 0, strlen($campaigns) - 1);
            }

            /*
             * Berechnung
             */
            if ($campaigns == '') {
                $jsonResult = '[]';
            } else {
                $class      = 'KreditAdmin_Class_Statistics_Adapter_' . $type;
                $calculator = new $class();

                $filter = $this->_setFilter($calculator);

                $calculator->setFilter($filter);
                $resultSet  = $calculator->calculate(
                    $sparte, $detailValue, $type, $campaigns
                );
                $resultSet  = $calculator->createTable($resultSet);
                $jsonResult = $calculator->encodeResult($resultSet);
            }
        } else {
            $jsonResult = '[]';
        }

        $this->getResponse()->setBody($jsonResult);
    }

    /**
     * Action für Ajax-Requests aus der grafischen Statistik zum Anzeigen von
     * Ereignissen
     *
     * @return void
     */
    public function getEventsAction()
    {
        $this->initAjax();

        $filter = $this->_setFilter();

        $events = new KreditAdmin_Class_Statistics_Event();
        $events->setFilter($filter);

        $this->getResponse()->setBody($events->getEncodedList());
    }

    /**
     * Action für Ajax-Requests aus der grafischen Statistik zum Anzeigen von
     * Details zu einem Punkt in der Statistik
     *
     * @return void
     */
    public function getDetailsAction()
    {
        $this->initAjax();

        $detailValue = strtolower($this->_getParam('detailValue', 'click'));

        if ($detailValue == 'info'
            || $detailValue == 'clickout'
            || $detailValue == 'sale'
            || $detailValue == 'other'
        ) {
            $sparte = ucfirst(
                strtolower($this->_getParam('sparteValue', 'Kredit'))
            );
            $datum = $this->_getParam('date', '');
            $paid  = $this->_getParam('portal', '');

            $filter = $this->_setFilter();

            //Set same Filter for other Statistic objects
            $this->_statisticAppStatus->setFilter($filter);

            $campaigns = $this->_getParam('campaigns', '');
            $campaigns = str_replace(',,', ',', $campaigns);
            if (substr($campaigns, 0, 1) == ',') {
                $campaigns = substr($campaigns, 1);
            }
            if (substr($campaigns, -1) == ',') {
                $campaigns = substr($campaigns, 0, strlen($campaigns) - 1);
            }

            $model = new \App\Model\Campaigns();
            $paid  = $model->getPortalName($paid);

            $date          = new \Zend\Date\Date($datum / 1000, \Zend\Date\Date::TIMESTAMP);
            $curDateString = $date->toString(
                $filter->getGroupSet()->getDateCompareFormat()
            );

            /*
             * Berechnung
             */
            $resultSet = $this->_statisticAppStatus->calculateDetail(
                $sparte, $detailValue, $detailValue, $campaigns, $curDateString,
                $paid
            );
            $details   = Zend_Json::encode($resultSet);
        } else {
            $details = '[]';
        }

        $this->getResponse()->setBody($details);
    }

    /**
     * Action für Ajax-Requests aus der grafischen Statistik zum Anzeigen von
     * Details zu einem Punkt in der Statistik
     *
     * @return void
     */
    public function exportCsvAction()
    {
        if (!$this->_request->isGet() && !$this->_request->isPost()) {
            $this->broker('header')->setErrorHeaders();

            return;
        }

        $this->initAjax();

        //set headers
        if ($this->_response->canSendHeaders()) {
            $this->_response->setHeader(
                'Content-Type', 'text/csv; charset=ISO-8859-1', true
            );
            $this->_response->setHeader('robots', 'noindex,nofollow', true);
            $this->_response->setHeader(
                'Content-Disposition',
                'attachment; filename="kreditstatistik_' . date('Y.m.d') .
                '.csv"',
                true
            );
            $this->_response->setHeader('Expires', gmdate(DATE_RFC1123), true);

            if (isset($_SERVER['HTTPS'])
                && ($_SERVER['HTTPS'])
                && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)
            ) {
                // for IE, see http://support.microsoft.com/kb/812935
                $this->_response->setHeader('Cache-Control', '', true);
                $this->_response->setHeader('Pragma', '', true);
            } else {
                $this->_response->setHeader('Pragma', 'no-cache', true);
                $this->_response->setHeader(
                    'Cache-Control',
                    'no-cache, no-store, must-revalidate, post-check=0, ' .
                    'pre-check=0',
                    true
                );
            }
        }

        $sparte = ucfirst(
            strtolower($this->_getParam('sparteValue', 'Kredit'))
        );
        if (is_numeric($sparte)) {
            $categoriesModel = new \App\Model\Sparten();
            $sparte       = $categoriesModel->getName($sparte);
        }

        //initialize date filter
        $filter = $this->_statisticAppStatus->getFilter();
        $filter->setDateStart($this->_getParam('filterDateStart'));
        $filter->setDateEnd($this->_getParam('filterDateEnd'));
        $filter->sanitize();

        //sanitize campaigns
        $campaigns = $this->_getParam('campaigns', '');
        $campaigns = str_replace(',,', ',', $campaigns);
        $campaigns = trim($campaigns, ',');

        $fields = array(
            'knID', 'portal', 'institut', 'date', 'anrede', 'name', 'adresse',
            'kontakt', 'telefon', 'mobil', 'kreditbetrag', 'laufzeit', 'sparte',
            'KundeId', 'idPortalService', 'creditLine', 'mehrAntrag'
        );

        $content = '"' . implode('";"', $fields) . '"' . "\n";

        $antragsModel = new \App\Model\Antraege();
        $select = $antragsModel->select();

        if (null !== $select) {
            $select->setIntegrityCheck(false);
            $select->from(
                array('log_credits'),
                $fields
            );

            $select->where('`test` = 0');
            $select->where('`sparte` = ? ', $sparte);
            $select->where('((`status` IS NULL) OR (`status`=99))');

            $select->where('`date` >= ?', $filter->getDateStartIso());
            $select->where('`date` <  ?', $filter->getDateEndIso());

            $rows = $antragsModel->fetchAll($select);
            foreach ($rows as $row) {
                $content .= '"' . implode('";"', $row->toArray()) . '"' . "\n";
            }
        }

        $this->getResponse()->setBody($content);
    }

    /*
     * =========================================================================
     * </actions>
     * =========================================================================
     */

    /**
     * Handle Filter Dates in the View
     *
     * @return void
     */
    private function _setDefaultFilter()
    {
        $filter = $this->_statisticAppStatus->getFilter();
        $this->view->filterDateStart = $filter->getDateStartString();
        $this->view->filterDateEnd   = $filter->getDateEndString();
        $this->view->groupValue      = $filter->getGroupValue();
        $this->view->categories         = $this->_statisticAppStatus->getSparten();

        //Whitelist all Mandants until we should be able to filter by Id's
        $this->_statisticAppStatus->getWhitelist()->addAllMandants();

        //Don't show default Mandant
        $this->_statisticAppStatus->getWhitelist()->dispableDefaultMandant();
    }

    /**
     * Fill Mandant Selects
     *
     * @return void
     */
    private function _fillMandantFilter()
    {
        $mandantHandler      = $this->_statisticAppStatus->getWhitelist();
        $this->view->portals = $mandantHandler->getPortaleFull();
    }


    /**
     * Get Kampagnen Array for Portal Ids
     *
     * @return array
     */
    public function jsonGetChildrenAction()
    {
        $this->initAjax();

        $campaigns = $this->_getParam('mandant', -1);

        $campaigns = str_replace(',,', ',', $campaigns);
        if (substr($campaigns, 0, 1) == ',') {
            $campaigns = substr($campaigns, 1);
        }
        if (substr($campaigns, -1) == ',') {
            $campaigns = substr($campaigns, 0, strlen($campaigns) - 1);
        }

        $childArray = array();

        $mandantHandler = $this->_statisticAppStatus->getWhitelist();

        $childRows = $mandantHandler->getKampagnenList($campaigns, false);

        foreach ($childRows as $actualChild) {
            $childArray[$actualChild->name] = $actualChild->toArray();
        }

        $this->getResponse()->setBody(Zend_Json::encode($childArray));
    }

    /**
     * Action für Ajax-Requests aus der grafischen Statistik zum Anzeigen von
     * Ereignissen
     *
     * @return void
     */
    private function _setFilter($calculator = null)
    {
        $time = $this->_getParam('timeRange', 10);

        if (null === $calculator) {
            $filter = $this->_statisticAppStatus->getFilter();
        } else {
            $filter = $calculator->getFilter();
        }
        $filter->setDateStart($this->_getParam('filterDateStart'));
        $filter->setDateEnd($this->_getParam('filterDateEnd'));
        $filter->setGroupValue($time);
        $filter->sanitize();

        return $filter;
    }
}