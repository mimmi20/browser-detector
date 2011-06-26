<?php
/**
 * Controller-Klasse, zur Verwaltung der eingegangenen Kreditanträge
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
 * Controller-Klasse, zur Verwaltung der eingegangenen Kreditanträge
 *
 * @category  Kreditrechner
 * @package   Controller
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class KreditAdmin_ApplicationListController
    extends KreditCore_Controller_AdminAbstract
{
    /**
     * Display List of Applications
     *
     * @return void
     */
    public function indexAction()
    {
        $modelApplications = new \AppCore\Model\Antraege();

        $pageNumber = $this->_getParam('page', 1, 'Int');

        $select = $modelApplications->select();

        if (null !== $select) {
            $paginatorAdapter = new Zend_Paginator_Adapter_DbSelect(
                $select->order('date DESC')
            );

            $this->createPagination($paginatorAdapter, $pageNumber);
        }

        $this->view->headTitle('Anträge', 'PREPEND');
    }

    /**
     * create a new Application
     *
     * @return void
     */
    public function newAction()
    {
        //TODO need to implement
    }

    /**
     * sends all datasets which were not transmitted vi SOAP to Portalservice
     * and which are not sent already via email to Portalservice
     *
     * when the action is finished it does a redirect to the {@link indexAction}
     *
     * @return void
     */
    public function exportNotSentDatasetsAction()
    {
        if (!$this->_request->isGet() && !$this->_request->isPost()) {
            $this->_helper->header->setNotFoundHeaders();

            return;
        }

        $this->initAjax();

        $antragsModel = new \AppCore\Model\Antraege();

        $select = $antragsModel->select();
        $select->from(
            array('log_credits'),
            array('data', 'knID', 'creditLine')
        );

        $select->where('`test` = 0');
        $select->where('`sparte` = ? ', 'Kredit');
        $select->where('`status` = 99');
        $select->where(
            '((`idPortalService` IS NULL) OR (`idPortalService` < 0))'
        );
        $select->where('((`idPortalService` != ?', 'sent by mail');

        $rows   = $antragsModel->fetchAll($select);
        $antrag = new \AppCore\Credit\Antrag();

        if (APPLICATION_ENV != SERVER_ONLINE_TEST
            && APPLICATION_ENV != SERVER_ONLINE_TEST2
        ) {
            $timerange = ini_get('max_execution_time');
            ini_set('max_execution_time', 600);
        }

        foreach ($rows as $row) {
            $data = unserialize($row->data);

            $requestData = $data['requestData'];

            if ('short' == $row->creditLine) {
                $requestData = array_merge($requestData, $requestData['kn1']);
            }

            $requestData['kreditinstitut'] =
                $data['requestData']['kreditInstitut'];

            if (isset($data['requestData']['kn1'])) {
                unset($requestData['agbeinv']);
                unset($requestData['probezeit']);
            }



            $text = \AppCore\Globals::createXML(
                $requestData, $row->knID, $row->creditLine, $this->view
            );

            $reSendOk = $antrag->sendMailOffice(
                $requestData, $text, true
            );

            if ($reSendOk) {
                $rowToSave = $this->getEditedRow($antragsModel, $row->knID);
                $rowToSave->idPortalService = 'sent by mail';
                $rowToSave->save();

                $this->_logger->info('Dataset ' . $row->knID . ' passed');
            } else {
                $this->_logger->info('Dataset ' . $row->knID . ' failed');
            }
        }

        if (APPLICATION_ENV != SERVER_ONLINE_TEST
            && APPLICATION_ENV != SERVER_ONLINE_TEST2
        ) {
            ini_set('max_execution_time', $timerange);
        }

        /**/
        $this->_redirector->gotoSimple(
            'index',
            'application-list',
            'kredit-admin'
        );
        return;
        /**/
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
            $this->_helper->header->setNotFoundHeaders();

            return;
        }

        $this->initAjax();

        /**/
        //set headers
        if ($this->_response->canSendHeaders()) {
            $this->_response->setHeader(
                'Content-Type', 'text/csv; charset=ISO-8859-1', true
            );
            $this->_response->setHeader('robots', 'noindex,nofollow', true);
            $this->_response->setHeader(
                'Content-Disposition',
                'attachment; filename="kreditantrag_' . date('Y.m.d') .
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
        /**/

        $sparte = ucfirst(
            strtolower($this->_getParam('sparteValue', 'Kredit'))
        );
        if (is_numeric($sparte)) {
            $categoriesModel = new \AppCore\Model\Sparten();
            $sparte       = $categoriesModel->getName($sparte);
        }

        //initialize date filter
        $filter = new KreditAdmin_Class_Statistics_Filter();
        $filter->setDateStart('01.11.2010');
        $filter->setDateEnd(date('d.m.Y'));
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

        $headerFields = $fields;
        $fields[]     = 'data';

        $antragsModel = new \AppCore\Model\Antraege();
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
            $select->where(
                '((`creditLine` = \'long\') OR (`creditLine` = \'short\'))'
            );
            $select->where(
                '((`idPortalService` IS NULL) OR (`idPortalService` < 0))'
            );

            $select->where('`date` >= ?', $filter->getDateStartIso());
            $select->where('`date` <  ?', $filter->getDateEndIso());

            $rows        = $antragsModel->fetchAll($select);
            $contentRows = array();

            foreach ($rows as $row) {
                $simpleRow = $row->toArray();
                unset($simpleRow['data']);

                $data = unserialize($row->data);
                $data = array_merge($simpleRow, $data, $data['requestData']);

                //keine Testanträge übertragen
                if (isset($data['portal'])
                    && strpos($data['portal'], 'slave29') !== false
                ) {
                    continue;
                }

                //$data = array_merge($data, $data['requestData']);
                unset($data['requestData']);
                unset($data['ENV']);
                unset($data['HEADER']);
                unset($data['UNAME']);
                unset($data['SERVER']);
                unset($data['transmittedData']);
                unset($data['transmitStatus']);
                unset($data['agent']);
                unset($data['Agent']);
                unset($data['IP']);
                unset($data['SERVER']);

                /*
                $text = \AppCore\Globals::createXML(
                    $data, $row->knID, $row->creditLine, $this->view
                );
                */

                $data = \AppCore\Globals::combineArrayKeys($data);


                foreach ($data as $key => $value) {
                    if (!in_array($key, $headerFields)) {
                        $headerFields[] = $key;
                    }

                    if (!array_key_exists($key, $simpleRow)) {
                        $simpleRow[$key] = $value;
                    }
                }

                $contentRows[] = $simpleRow;
            }

            $content = '"' . implode('";"', $headerFields) . '"' . "\n";

            foreach ($contentRows as $row) {
                $fieldContent = array();

                foreach ($headerFields as $header) {
                    if (isset($row[$header])) {
                        $fieldContent[] = $row[$header];
                    } else {
                        $fieldContent[] = '';
                    }
                }

                $content .= '"' . implode('";"', $fieldContent) . '"' . "\n";
            }
        }

        $this->getResponse()->setBody($content);
    }
}