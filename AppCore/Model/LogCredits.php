<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Model;

/**
 * Model
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Models
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id$
 */

/**
 * Model
 *
 * @category  Kreditrechner
 * @package   Models
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class LogCredits extends ModelAbstract
{
    /**
     * Name of the table in the db schema relating to child class
     *
     * @var    string
     * @access protected
     */
    protected $_name = 'log_credits';

    /**
     * Name of the primary key field in the table
     *
     * @var    string
     * @access protected
     */
    protected $_primary = 'knID';

    /**
     * trims an items
     *
     * @param string|array &$item the item to be trimmed
     * @return void
     */
    private function _trimData(&$item)
    {
        if (is_array($item)) {
            array_walk($item, array($this, '_trimData'));
        } else {
            $item = trim($item);
        }
    }

    /**
     * maps the $postData, stores them to database and transmit them via SOAP
     * tpo Portalservice
     *
     * @param array $postData
     *
     * @return null|array
     */
    public function getAntragData(array $postData)
    {
        if (!isset($postData['product']) || 0 >= (int) $postData['product']) {
            return null;
        }

        array_walk($postData, array($this, '_trimData'));

        $postData['kreditinstitut'] = null;
        $postData['sparte']         = null;

        $modelProduct = new \AppCore\Service\Products();
        $ok = $modelProduct->lade(
            $postData['product'],
            $postData['kreditinstitut'],
            $postData['sparte']
        );

        if (!$ok || !$postData['kreditinstitut']) {
            return null;
        }

        $portalModel = new \AppCore\Service\Campaigns();
        $paid        = null;
        $hostname    = null;
        $istTest     = (isset($postData['test']) && $postData['test']);

        $portalModel->loadCaid(
            $postData['paid'],
            array(),
            '',
            $paid,
            $postData['paid'],
            $hostname,
            $istTest
        );

        $paid    = $portalModel->find($postData['caid'])->current()->name;
        $dataSet = new stdClass();

        $dataSet->portal   = $paid;
        $dataSet->institut = $postData['kreditinstitut'];
        $dataSet->date     = date('Y-m-d H:i:s');
        $dataSet->anrede   = $postData['anrede'];
        $dataSet->name     = $postData['vorname'] . ' ' . $postData['nachname'];
        $dataSet->adresse  = $postData['strasse'] . ' '  . $postData['hausnr']
                           . ' ' . $postData['plz']  . ' ' . $postData['ort'];
        $dataSet->kontakt  = $postData['email'];
        $dataSet->telefon  = $postData['vorwahl'] . ' ' . $postData['telefon'];

        $dataSet->staatsangeh  = $postData['land'];
        $dataSet->kreditbetrag = $postData['kreditbetrag'];
        $dataSet->laufzeit     = $postData['laufzeit'];
        $dataSet->test         = (int) $istTest;

        if (isset($postData['IP'])) {
            $dataSet->user_ip = $postData['IP'];
        } else {
            $dataSet->user_ip = '';
        }

        $dataSet->sparte       = $postData['sparte'];
        $dataSet->statusTypeId = (int) $postData['statusTypeId'];

        $dataSet->schufaOk  = ((isset($postData['schufaEinv']))
                            ? (int) ((boolean) $postData['schufaEinv'])
                            : 0);
        $dataSet->schufaOk2 = ((isset($postData['schufaEinv1']))
                            ? (int) ((boolean) $postData['schufaEinv1'])
                            : 0);

        $dataSet->beraterOK     = (int) ((boolean) $postData['datenEinv']);
        $dataSet->datenschutzOK = (int) ((boolean) $postData['agbEinv']);

        $dataSet->probezeitDreiMonate  = ((isset($postData['Probezeit']))
                                    ? (int) ((boolean) $postData['Probezeit'])
                                    : 0);
        $dataSet->probezeitDreiMonate2 = ((isset($postData['Probezeit1']))
                                    ? (int) ((boolean) $postData['Probezeit1'])
                                    : 0);

        $dataSet->dreiMonate  = (int) ((boolean) $postData['DreiMonate']);
        $dataSet->dreiMonate2 = ((isset($postData['DreiMonate1']))
                              ? (int) ((boolean) $postData['DreiMonate1'])
                              : 0);

        $dataSet->mehrAntrag  = ((isset($postData['kn1']['mehrantrag']))
                              ? (int) ((boolean) $postData['kn1']['mehrantrag'])
                              : 0);

        $modelSparte = new \AppCore\Model\Sparten();
        $select = $modelSparte->select()->setIntegrityCheck(false);
        $select->from(
            array('s' => 'categories'),
            array('uid' => 'idCategories', 'code' => 'Code')
        );
        $select->where('name = ?', $postData['sparte']);

        $row = $modelSparte->fetchAll($select)->current();

        //$categoriesId = substr('00' . $row->uid, -2) . '-';
        //$processId = $row->code . '-';

        $usageModel = new \AppCore\Service\Usage();
        $verwendung = $usageModel->name($postData['zweck']);

        $modelInstitut = new \AppCore\Model\Institute();
        $select        = $modelInstitut->select();
        $select->from(
            array('i' => 'institute'),
            array('uid' => 'idInstitutes', 'title' => 'name')
        );
        $select->where('codename = ?', $postData['kreditinstitut']);

        $row           = $modelInstitut->fetchAll($select)->current();
        $instituteName = $row->title;

        /*
        $processId .= substr('000' . $row->uid, -3) . '-' . $categoriesId;

        $modelAntrag = new \AppCore\Model\Antraege();
        $select      = $modelAntrag->select()->setIntegrityCheck(false);
        $select->from(
            array('log_credits'),
            array('uid' => 'knID')
        );
        $select->order('knID DESC');
        $select->limit(1);
        $row = $modelAntrag->fetchAll($select)->current();

        $processId .= ((isset($row->uid)) ? (int) $row->uid : 0) + 1;

        $dataSet->processID = $processId;
        */

        $kundeModel = new \AppCore\Model\Kunde();
        $suche      = $kundeModel->search($postData);
        $customerId = null;

        if (count($suche) && isset($suche[0])) {
            /*
             * Kunde hat schon angefragt
             * Datensatz laden, um an ID des Datensatzes zu kommen
             */
            $customerId = $suche[0]['KundeId'];
        }

        //Eingaben auf Kunden �bertragen
        $kunde = $kundeModel->mapInput($postData, $customerId);
        try {
            $kunde->save();

            $dataSet->KundeId = $kunde->KundeId;
        } catch (Exception $e) {
            $this->_logger->err($e);

            $dataSet->KundeId = null;
        }

        if (isset($postData['creditLine'])) {
            $dataSet->creditLine = $postData['creditLine'];
        }

        $dataSet->status = $postData['actualStep'];
        $dataSet->data   = serialize($postData);

        $dataSet->idPortalService = null;

        /*
         * Senden des Antrages an Portal-Service
         * keine Tests senden
         */
        if (isset($postData['actualStep'])
            && $postData['actualStep'] == KREDIT_ANTRAG_STEPS_LAST
        ) {
            $postData = $this->_send(
                $postData, $kunde, $istTest, $verwendung, $instituteName
            );

            if (isset($postData['idPortalService'])) {
                $dataSet->idPortalService = $postData['idPortalService'];
            } else {
                $dataSet->idPortalService = null;
            }
        }

        $dataSet->status = $postData['actualStep'];
        $dataSet->data   = serialize($postData);

//      /*bei kurzer Antragstrecke*/
        if (!isset($postData['lstUuid'])) {
            $postData['lstUuid'] = '';
        }

        //$dataSet->save();
//        $dataSet->knID = null;
        try {
            if ($postData['lstUuid'] !== ''
                && (int)$postData['actualStep'] > 5
            ) {
                $select = $this->select();
                $select->from($this->_name)
                    ->where('referenz_id = ?', $postData['lstUuid'])
                    ->limit(1);

                $dataRow       = $this->fetchAll($select)->toArray();
                $referenzId    = $dataRow[0]['referenz_id'];
                $reportNr      = md5($dataRow[0]['knID']);
                $dataSet->knID = $dataRow[0]['knID'];

                $where = $this->getAdapter()->quoteInto('referenz_id = ?',
                         $referenzId);

                $this->update((array) $dataSet, $where);
            } else {
                $id = $this->insert((array) $dataSet);

                $reportNr             = md5($id);
                $dataSet->referenz_id = $reportNr;
                $this->update((array) $dataSet, 'knID=' . $id);
            }
        } catch (Exception $e) {
            $this->_logger->err($e);

            $reportNr = null;
        }

        return array(
            'reportNr'        => $reportNr,
            'idPortalService' => $dataSet->idPortalService,
            'postData'        => $postData
        );
    }

    /**
     * sends the data to portalservice
     *
     * @param array             $postData the data to send
     * @param \Zend\Db\Table\Row $kunde
     * @param boolean           $istTest
     *
     * @return array the given data with added values returned from
     *               portalservice
     */
    private function _send(
        array $postData, \Zend\Db\Table\Row $kunde, $istTest,
        $verwendung, $instituteName)
    {
        $config = \Zend\Registry::get('_config');

        $postData['idPortalService'] = null;

        if (!$config->interfaces->enabled) {
            $postData['transmitStatus'] = 'Interface not enabled';

            return $postData;
        }

        $portal = '';

        if (!$istTest && isset($postData['creditLine'])) {
            $campaignModel = new \AppCore\Service\Campaigns();
            $campaignId    = $campaignModel->getId($postData['paid']);
            $campaign      = $campaignModel->find($campaignId)->current();

            if ($postData['creditLine'] == 'long'
            ) {
                $portal = $campaign->aliasPortalService;
            } else {
                $portal = $campaign->aliasPortalServiceShort;
            }
        }

        if ('' == $portal) {
            /*
             * es wurde kein Portal-Alias festgelegt
             * -> als Test senden
             */
            $portal = 'TESTPORTAL';
        }

        try {
            /*
             * Kunden bei Portal-Service anlegen
             */
            $interface = new KreditCore_Class_Interface_PortalService(
                $portal, $kunde
            );

            /*
             * Fehler beim Erstellen des Kunden bei Portalservice
             * -> Abbruch, da fuer weitere Schritte der Kunde angelegt sein muss
             */
            if (null === $interface->addCustomer()->getCustomerId()) {
                $postData['transmitStatus'] = 'creating Customer failed';

                return $postData;
            }

            //Telefonnummern sammeln
            $phones = array();

            if (isset($postData['vorwahl'])
                && isset($postData['telefon'])
            ) {
                $phones[] = array(
                    $postData['vorwahl'],
                    $postData['telefon']
                );
            }

            if (isset($postData['kn1']['vorwahl'])
                && isset($postData['kn1']['telefon'])
                && strlen($postData['kn1']['vorwahl']) > 0
                && strlen($postData['kn1']['telefon']) > 0
                && $postData['kn1']['vorwahl'] != $postData['vorwahl']
                && $postData['kn1']['telefon'] != $postData['telefon']
            ) {
                $phones[] = array(
                    $postData['kn1']['vorwahl'],
                    $postData['kn1']['telefon']
                );
            }

            if (isset($postData['kn1']['vorwahlAbends'])
                && isset($postData['kn1']['telefonAbends'])
                && strlen($postData['kn1']['vorwahlAbends']) > 0
                && strlen($postData['kn1']['telefonAbends']) > 0
            ) {
                $phones[] = array(
                    $postData['kn1']['vorwahlAbends'],
                    $postData['kn1']['telefonAbends']
                );
            }

            if (isset($postData['kn1']['vorwahlMobil'])
                && isset($postData['kn1']['telefonMobil'])
                && strlen($postData['kn1']['vorwahlMobil']) > 0
                && strlen($postData['kn1']['telefonMobil']) > 0
            ) {
                $phones[] = array(
                    $postData['kn1']['vorwahlMobil'],
                    $postData['kn1']['telefonMobil']
                );
            }

            //Telefonnummern �bertragen
            foreach ($phones as $phonenumber) {
                $telefon = $phonenumber[0] . ' ' . $phonenumber[1];

                $interface->addCustomerPhoneNumber($telefon);
            }

            //sonstige Kundeneingaben zusammenstellen
            $transferData = array(
                'kn1'          => $postData['kn1'],
                'kn2'          => $postData['kn2'],
                'laufzeit'     => $postData['laufzeit'],
                'kreditbetrag' => $postData['kreditbetrag'],
                'zweck'        => $verwendung,
                'bank'         => $instituteName,
                'sparte'       => $postData['sparte']
            );

            if (isset($postData['creditLine'])) {
                if ($postData['creditLine'] == 'long') {
                    $transferData['zusatzzeile'] = 'lange Strecke';
                } else {
                    $transferData['zusatzzeile'] = 'kurze Strecke';
                }
            } else {
                $transferData['zusatzzeile'] = 'alte Strecke';
            }

            //sonstige Daten �bertragen
            $e = $interface->addExtensionData($transferData);

            /*
             * Zeit, an der der Kunden angerufen werden m�chte
             * da nicht abgefragt, auf 01.01.1970 setzen
             */
            $time = 0;

            //Kunden-Datensatz schliessen
            $interface->finishCustomer($time, $istTest);

            $postData['idPortalService'] = $interface->getCustomerId();
            $postData['transmittedData'] = $interface->getTransmittedData();
            $postData['transmitStatus']  = 'ok';
        } catch (Zend_Soap_Client_Exception $e) {
            $this->_logger->err($e);

            $postData['idPortalService'] = '-1';
            $postData['transmittedData'] = array();
            $postData['transmitStatus']  = 'fail: ' . $e->getMessage();
        } catch (\Zend\Exception $e) {
            $this->_logger->err($e);

            $postData['idPortalService'] = '-2';
            $postData['transmittedData'] = array();
            $postData['transmitStatus']  = 'fail: ' . $e->getMessage();
        } catch (SoapFault $e) {
            $this->_logger->err($e);

            $postData['idPortalService'] = '-3';
            $postData['transmittedData'] = array();
            $postData['transmitStatus']  = 'fail: ' . $e->getMessage();
        } catch (Exception $e) {
            $this->_logger->err($e);

            $postData['idPortalService'] = '-4';
            $postData['transmittedData'] = array();
            $postData['transmitStatus']  = 'fail: ' . $e->getMessage();
        }

        return $postData;
    }
}