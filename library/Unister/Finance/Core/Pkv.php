<?php
/**
 * Funktionen für PKV-Berechnung
 *
 * PHP version 5
 *
 * @category  Geld.de
 * @package   PKV
 * @author    Marko Schreiber <marko.schreiber@unister-gmbh.de>
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2009 Unister GmbH
 * @version   SVN: $Id$
 */

require_once LIB_PATH . 'Unister' . DS . 'Finance' . DS . 'Core' . DS . 'Abstract.php';

/**
 * Funktionen für PKV-Berechnung
 *
 * @category  Geld.de
 * @package   PKV
 * @author    Marko Schreiber <marko.schreiber@unister-gmbh.de>
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2009 Unister GmbH
 */
class Unister_Finance_Core_Pkv extends Unister_Finance_Core_Abstract
{
    /**
     * Class constructor
     *
     * The request and response objects should be registered with the
     * controller, as should be any additional optional arguments; these will be
     * available via {@link getRequest()}, {@link getResponse()}, and
     * {@link getInvokeArgs()}, respectively.
     *
     * When overriding the constructor, please consider this usage as a best
     * practice and ensure that each is registered appropriately; the easiest
     * way to do so is to simply call parent::__construct($request, $response,
     * $invokeArgs).
     *
     * After the request, response, and invokeArgs are set, the
     * {@link $_helper helper broker} is initialized.
     *
     * Finally, {@link init()} is called as the final action of
     * instantiation, and may be safely overridden to perform initialization
     * tasks; as a general rule, override {@link init()} instead of the
     * constructor to customize an action controller's instantiation.
     *
     * @param Zend_Controller_Request_Abstract  $request
     * @param Zend_Controller_Response_Abstract $response
     * @param array                             $invokeArgs Any additional
     *                                                      invocation arguments
     *
     * @return void
     * @access public
     */
    public function __construct($view)
    {
        parent::__construct($view);
        
        $this->_module = new Model_Core_Module($this->_view);
    }

    /**
     * Class destructor
     *
     * @return void
     * @access public
     */
    public function __destruct()
    {
        unset($this->_module);
        
        parent::__destruct();
    }

    /**
     * Enter description here...
     *
     * @param array $data
     * @param array $requestData
     *
     * @return void
     * @access public
     */
    protected function getPkvFaq(array $data, array $requestData)
    {
        $results = '';

        // Ruediger
        $url = PKVCALC_URL . '/?method=getErgebnisByAnfrageSchluesselAndPosition';
        //fetch Information about the selected Tarif Combination
        $response = $this->getCurlContent($url, 60, 60, 1, $requestData);
        $results  = $this->unserializeXml($response);

        $value2 = array();
        if (is_array($results['getErgebnisByAnfrageSchluesselAndPosition']['Tarifkomponenten'])) {
            $keys = array_keys($results['getErgebnisByAnfrageSchluesselAndPosition']['Tarifkomponenten']);

            foreach ($keys as $tarifKey) {
                $tarif = $results['getErgebnisByAnfrageSchluesselAndPosition']['Tarifkomponenten'][$tarifKey];

                if (isset($tarif['key_0']) && isset($tarif['key_0']['Tarif']) && $tarif['key_0']['Tarif'] != '') {
                    $keys2 = array_keys($tarif);

                    if ($tarifKey == 'P') {
                        $tarifKey = 'Pflege';
                    } elseif ($tarifKey == 'GSs') {
                        $tarifKey = 'station&auml;r';
                    } elseif ($tarifKey == 'GAs') {
                        $tarifKey = 'ambulant';
                    } elseif ($tarifKey == 'GDs') {
                        $tarifKey = 'dental';
                    } elseif ($tarifKey == 'KT') {
                        $tarifKey = 'Krankentagegeld';
                    } else {
                        $tarifKey = '';
                    }

                    foreach($keys2 as $key2) {
                        $tarifPart = $tarif[$key2];
                        $tarifName = $tarifPart['Tarif'];

                        if (isset($value2[$tarifName])) {
                            if (!in_array($tarifKey, $value2[$tarifName]['Components'])) {
                                $value2[$tarifName]['Components'][] = $tarifKey;
                            }
                        } else {
                            $value2[$tarifName]['Beitrag']      = $tarifPart['Beitrag'];
                            $value2[$tarifName]['Components'][] = $tarifKey;
                        }
                    }
                } elseif (!isset($tarif['key_0'])) {
                    //var_dump($tarif);
                    $value2[$tarifKey] = $tarif;
                }
            }
        }

        foreach ($value2 as $tarifKey => $tarif) {
            //var_dump($tarif);
            if (is_array($tarif['Components'])) {
                $value2[$tarifKey]['Components'] = implode(', ', $tarif['Components']);
            }
        }

        $url = PKVCALC_URL . '/?method=getKombinationsvergleich';

        //fetch Information about the selected Tarif
        $response        = $this->getCurlContent($url, 60, 60, 1, $requestData);
        $results         = $this->unserializeXml($response);
        $data['pkvinfo'] = $results;
        $this->_view->assign('data', $data);
        $this->_view->assign('Tarifkombination', $value2);
        $this->_view->display('formulare/pkv/calc/pkv_faq.phtml');

        exit();
    }

    /**
     * Enter description here...
     *
     * @param array $data
     * @param array $requestData
     *
     * @return void
     * @access public
     */
    protected function getPkvBre(array $data, array $requestData)
    {
        $results = '';
        $url     = PKVCALC_URL . '/?method=getBeitragsrueckerstattungsTexte';

        $response        = $this->getCurlContent($url,60,60,1,$requestData);
        $results         = $this->unserializeXml($response);
        $data['BREinfo'] = $results['getBeitragsrueckerstattungsTexte'];

        $this->_view->assign('data',$data);
        $this->_view->display('formulare/pkv/calc/pkv_bre.phtml');
        exit();
    }

    /**
     * Seitennavigation für die PKV-Ergebnisse
     *
     * @param array $rslt
     *
     * @return array
     * @access public
     */
    protected function setPkvResultPageNav(array $rslt)
    {
        $k     = 0;
        $pn    = array();
        $count = count($rslt);
        $num   = ceil($count/20);
        for($i = 1; $i <= $num; $i++) {
             $pn[$i-1]['index'] = $i;
             $pn[$i-1]['id']    = ($k == 0 ? 1 : $k);
            $k                += 20;
        }
        return $pn;
    }

    /**
     * Enter description here...
     *
     * @param array $data
     * @param array $requestData
     *
     * @return array
     * @access public
     */
    protected function setPkvAntrag(array $data, array $requestData)
    {
        $results = '';
        $url = PKVCALC_URL . '/?method=saveRecord';

        if ($requestData['preload']) {
            unset($requestData['preload']);
            //debugster($requestData);
            $response = $this->getCurlContent($url,60,60,1,$requestData);
            $this->_module->decode_array($response);
            $results  = $this->unserializeXml($response);

            if ($results['saveRecord']['status'] == 'Erfolg') {
                $data['pkvsave'] = $this->_module->setFileParams($results['saveRecord']['data']);
            } else {
                $data['pkvsave'] = $results['saveRecord'];
            }

            if (isset($data['pkvsave']['tarif']['TarifkombinationIds']) && is_array($data['pkvsave']['tarif']['TarifkombinationIds'])) {
                $data['pkvsave']['tarif']['TarifkombinationIds'] = implode(',', $data['pkvsave']['tarif']['TarifkombinationIds']);
            }

            //var_dump($data['pkvsave']['tarif']);
            //debugster($data['pkvsave']);
            $this->_view->assign('data', $data['pkvsave']);
            $data['text']   = $this->_view->render('formulare/pkv/calc/pkv_antrag_finalize.phtml');

        } else {
            $targeturl              = _URL . '/' . $data['datei_name'] . '.html';
            $requestData['preload'] = 'on';
            $data['target']         = 'record';
            $data['targeturl']      = $targeturl;

            $this->_view->assign('data', $data);
            $this->_view->assign('requestData', $requestData);

            $data['text'] = $this->_view->render('formulare/pkv/calc/pkv_preloader.phtml');
        }

        return $data;
    }

    /**
     * Enter description here...
     *
     * @param array $data
     * @param array $requestData
     *
     * @return array
     * @access public
     */
    protected function showPkvDocs(array $data, array $requestData)
    {
        $path = _DOCUMENT_URL . $requestData['path'];

        if ($requestData['tp'] == 'pdf') {
            $file = $path . $requestData['file'];
            $filename = $requestData['file'];
            if (is_file($file)) {
                header("Cache-control: private");
                header("Content-Length: ".filesize($file));
                header("Content-disposition: attachment; filename=" . $filename);
                header("Content-type: application/pdf");
                readfile($file);
                die();
            }else{
                echo 'Datei ' . $file . ' konnte nicht geladen werden!'; die();
            }
        }
    }

    /**
     * Enter description here...
     *
     * @param array $data
     * @param array $requestData
     *
     * @return array
     * @access public
     */
    protected function showPkvFazit(array $data, array $requestData)
    {
        $url = PKVCALC_URL . '/?method=getKundenBewertungFazit';

        $response = $this->getCurlContent($url,60,60,1,$requestData);
        $results  = $this->unserializeXml(html_entity_decode($response));

        if ($results['getKundenBewertungFazit']['status'] == 'success') {
            $data['fazit'] = $results['getKundenBewertungFazit']['data'];
        } else {
            $data['fazit'] = '';
        }

        $this->_view->register_modifier('round', 'round');
        $this->_view->assign('data', $data['fazit']);
        $data['text']   = $this->_view->display('formulare/pkv/calc/pkv_fazit.phtml');

        exit();
    }
    /**
     * Enter description here...
     *
     * @param array $data
     * @param array $requestData
     *
     * @return array
     * @access public
     */
    protected function finalizePkvAntrag(array $data, array $requestData)
    {
        $results = '';

        if ($requestData['preload']) {
            unset($requestData['preload']);
            //var_dump($requestData);
            /*
             * get the new block from the database and reformat all data
             */
            $requestData['baustein'] = $requestData['actualBlock'];
            //var_dump($requestData);
            $data = $this->getPkvAntragData($data, $requestData, false);
            //var_dump($data['datensatz']['felder']);

            $this->_view->assign('AntragId', ((isset($data['finalize']['AntragId'])) ? $data['finalize']['AntragId'] : null));
            $this->_view->assign('data', $data);

            unset($requestData['pkvcalc']);

            $this->_view->register_modifier('substring', 'substr');
            $this->_view->register_modifier('stringpos', 'strpos');

            $trackData = $this->_module->getTrackData($data,$requestData);
            $timestamp = time();
            $this->_view->assign('timestamp', $timestamp);
            $this->_view->assign('frmData', $trackData);
            //$this->_view->assign('status', $results['saveAntrag']['status']);
            //$this->_view->assign('message', $results['saveAntrag']['message']);
            $this->_view->assign('vorname', ((isset($data['finalize']['vorname'])) ? $data['finalize']['vorname'] : null));
            $this->_view->assign('nachname', ((isset($data['finalize']['nachname'])) ? $data['finalize']['nachname'] : null));

            $data['text'] = $this->_view->render('formulare/pkv/calc/pkv_danke.phtml');
        } else {
            $targeturl              = _URL . '/' . $data['datei_name'] . '.html';
            $requestData['preload'] = 'on';
            $data['target']         = 'finalize';
            $data['targeturl']      = $targeturl;

            $this->_view->assign('data',$data);
            $this->_view->assign('requestData',$requestData);

            $data['text'] = $this->_view->render('formulare/pkv/calc/pkv_preloader.phtml');
        }

        return $data;
    }

    /**
     * Enter description here...
     *
     * @param array $data
     * @param array $requestData
     *
     * @return void
     * @access public
     */
    protected function getPkvBeitragsentwicklung(array $data, array $requestData)
    {
        $results = '';
        // Ruediger
        #$url = 'http://192.168.0.38:8137/pkvcalc/?method=getBeitragsentwicklung';
        #$url = 'http://slave29.pkv.geld.de/?method=getBeitragsentwicklung';
        $url = PKVCALC_URL . '/?method=getBeitragsentwicklung';

        header('Content-Type: image/png', true);
        echo $response = $this->getCurlContent($url, 60, 60, 0, $requestData);
        exit();
      }

      /**
       * Enter description here...
       *
       * @param array $data
       * @param array $requestData
       *
       * @return array
       * @access public
       */
    protected function getPkvAntragData(array $data, array $requestData, $countNext = true)
    {
        if ($countNext) {
            if (isset($requestData['nextBlock'])) {
                $baustein = $requestData['nextBlock'];
            } elseif (isset($requestData['prevBlock'])) {
                $baustein = $requestData['prevBlock'];
            } else {
                $baustein = 0;
            }
        } else {
            $baustein = $requestData['actualBlock'];
        }

        /*
         * store the actual block into the database
         */
        $methodName = 'saveAntragsSchritt';
        $results    = '';
        $url        = PKVCALC_URL . '/?method=' . $methodName;

        //is set an actual Block?
        if (isset($requestData['actualBlock'])) {
            $requestData['baustein'] = $requestData['actualBlock'];
            unset($requestData['actualBlock']);
        } else {
            $requestData['baustein'] = -1;
        }
        //if ($requestData['baustein'] > 0 || $countNext !== true) {
        //    var_dump($requestData);
        //    exit;
        //}

        //store actual Block into database
        $response = $this->getCurlContent($url,60,60,1,$requestData);

        if ($baustein == 1) {
            $methodName = 'saveAntrag';
            $url        = PKVCALC_URL . '/?method=' . $methodName;
            $response   = $this->getCurlContent($url,60,60,1,$requestData);
            $record     = $this->unserializeXml($response);
            if(isset($record['saveAntrag']['AntragId']))
            {
                $trackdata = array();
                $trackdata['record'] = $record['saveAntrag']['AntragId'];
                $trackdata['section'] = 'PKV';
                $this->_view->assign('trackdata', $trackdata);
            }
        }
        /*
         * get the new block from the database and reformat all data
         */
        $methodName = 'getFormularBaustein';
        $results    = '';
        $url        = PKVCALC_URL . '/?method=' . $methodName;

        $requestData['baustein'] = $baustein;

        $response = $this->getCurlContent($url,60,60,1,$requestData);

        //reformat the response string to pass the XML encoding
        $response = str_replace("\n", '', $response);
        $response = str_replace("\t", '', $response);
        $response = str_replace("\r", '', $response);
        $response = str_replace("\f", '', $response);

        //utf-8
        $response = str_replace('Ã¤', '&amp;auml;', $response);
        $response = str_replace('Ã¶', '&amp;ouml;', $response);
        $response = str_replace('Ã¼', '&amp;uuml;', $response);
        $response = str_replace('Ã„', '&amp;Auml;', $response);
        $response = str_replace('Ã–', '&amp;Ouml;', $response);
        $response = str_replace('Ãœ', '&amp;Uuml;', $response);
        $response = str_replace('ÃŸ', '&amp;szlig;', $response);
        //iso
        $response = str_replace('ä', '&amp;auml;', $response);
        $response = str_replace('ö', '&amp;ouml;', $response);
        $response = str_replace('ü', '&amp;uuml;', $response);
        $response = str_replace('Ä', '&amp;Auml;', $response);
        $response = str_replace('Ö', '&amp;Ouml;', $response);
        $response = str_replace('Ü', '&amp;Uuml;', $response);
        $response = str_replace('ß', '&amp;szlig;', $response);
        //encoded
        $response = str_replace('&auml;', '&amp;auml;', $response);
        $response = str_replace('&ouml;', '&amp;ouml;', $response);
        $response = str_replace('&uuml;', '&amp;uuml;', $response);
        $response = str_replace('&Auml;', '&amp;Auml;', $response);
        $response = str_replace('&Ouml;', '&amp;Ouml;', $response);
        $response = str_replace('&Uuml;', '&amp;Uuml;', $response);
        $response = str_replace('&szlig;', '&amp;szlig;', $response);

        $response = str_replace('@', '&#64;', $response);
        //$response = str_replace('.<', '<', $response);
        $response = str_replace('nationalit&amp;auml;t>', 'nationalität>', $response);
        //var_dump($response);
        //var_dump(substr($response, 19900));
        $results = $this->unserializeXml($response);
        //var_dump($results);

        $results = $results[$methodName];
        //var_dump($results);
        $status  = $results['status'];
        unset($results['status']);

        $this->_view->assign('status', $status);

        if ($status == 'success') {
            //no error occured
            $result   = array();

            /*
             * reformat formulardaten
             */
            if (is_array($results['formulardaten'])) {
                foreach ($results['formulardaten'] as $element => $value) {
                    if (preg_match('/^key_([0-9]*)$/',$element,$treffer)) {
                        $element = $treffer[1];
                    }
                    if (is_array($value)) {
                        foreach ($value as $element2 => $value2) {
                            if (preg_match('/^key_([0-9]*)$/',$element2,$treffer)) {
                                $element2                    = $treffer[1];
                                $result[$element][$element2] = $value2;
                            }
                        }
                    }
                }
            }

            unset($results['formulardaten']);
            $data['datensatz'] = $result;

            /*
             * reformat anfragedaten and write parts of it ro versicherungsdaten
             */
            if (is_array($results['anfragedaten'])) {
                foreach ($results['anfragedaten'] as $key => $value) {
                    if ($key == 'geburtsdatum') {
                        //var_dump($value);
                        $datum = explode('-', $value);

                        $results['versicherungsdaten']['geburtstagTag']   = $datum[2];
                        $results['versicherungsdaten']['geburtstagMonat'] = $datum[1];
                        $results['versicherungsdaten']['geburtstagJahr']  = $datum[0];

                        if (isset($requestData['versichern']) && ($requestData['versichern'] == 'e' || $requestData['versichern'] == 'ek')) {
                            $results['versicherungsdaten']['vp_geburtstagTag_Person1']   = $datum[2];
                            $results['versicherungsdaten']['vp_geburtstagMonat_Person1'] = $datum[1];
                            $results['versicherungsdaten']['vp_geburtstagJahr_Person1']  = $datum[0];
                        }
                    } elseif ($key == 'geburtsdatumkind1') {
                        //child 1
                        //var_dump($value);
                        $datum = explode('-', $value);

                        if (isset($requestData['versichern']) && $requestData['versichern'] == 'ek') {
                            $results['versicherungsdaten']['vp_geburtstagTag_Person2']   = $datum[2];
                            $results['versicherungsdaten']['vp_geburtstagMonat_Person2'] = $datum[1];
                            $results['versicherungsdaten']['vp_geburtstagJahr_Person2']  = $datum[0];
                        } elseif (isset($requestData['versichern']) && $requestData['versichern'] == 'k') {
                            $results['versicherungsdaten']['vp_geburtstagTag_Person1']   = $datum[2];
                            $results['versicherungsdaten']['vp_geburtstagMonat_Person1'] = $datum[1];
                            $results['versicherungsdaten']['vp_geburtstagJahr_Person1']  = $datum[0];
                        } else {
                            unset($requestData[$key]);
                        }
                    } elseif ($key == 'geburtsdatumkind2') {
                        //child 2
                        //var_dump($value);
                        $datum = explode('-', $value);

                        if (isset($requestData['versichern']) && $requestData['versichern'] == 'ek') {
                            $results['versicherungsdaten']['vp_geburtstagTag_Person3']   = $datum[2];
                            $results['versicherungsdaten']['vp_geburtstagMonat_Person3'] = $datum[1];
                            $results['versicherungsdaten']['vp_geburtstagJahr_Person3']  = $datum[0];
                        } elseif (isset($requestData['versichern']) && $requestData['versichern'] == 'k') {
                            $results['versicherungsdaten']['vp_geburtstagTag_Person2']   = $datum[2];
                            $results['versicherungsdaten']['vp_geburtstagMonat_Person2'] = $datum[1];
                            $results['versicherungsdaten']['vp_geburtstagJahr_Person2']  = $datum[0];
                        } else {
                            unset($requestData[$key]);
                        }
                    } elseif ($key == 'anrede') {
                        if ($value == 1 || $value == '1' || $value == 'Herr') {
                            $results['versicherungsdaten']['anrede'] = 'herr';

                            if (isset($requestData['versichern']) && ($requestData['versichern'] == 'e' || $requestData['versichern'] == 'ek')) {
                                $results['versicherungsdaten']['vp_geschlecht_Person1'] = 'm';
                            }
                        } else {
                            $results['versicherungsdaten']['anrede'] = 'frau';

                            if (isset($requestData['versichern']) && ($requestData['versichern'] == 'e' || $requestData['versichern'] == 'ek')) {
                                $results['versicherungsdaten']['vp_geschlecht_Person1'] = 'w';
                            }
                        }
                    } elseif ($key == 'geschlechtkind1') {
                        //child 1
                        if (isset($requestData['versichern']) && $requestData['versichern'] == 'ek') {
                            if ($value == 1 || $value == '1' || $value == 'Herr') {
                                $results['versicherungsdaten']['vp_geschlecht_Person2'] = 'm';
                            } else {
                                $results['versicherungsdaten']['vp_geschlecht_Person2'] = 'w';
                            }
                        } elseif (isset($requestData['versichern']) && $requestData['versichern'] == 'k') {
                            if ($value == 1 || $value == '1' || $value == 'Herr') {
                                $results['versicherungsdaten']['vp_geschlecht_Person1'] = 'm';
                            } else {
                                $results['versicherungsdaten']['vp_geschlecht_Person1'] = 'w';
                            }
                        } else {
                            unset($requestData[$key]);
                        }
                    } elseif ($key == 'geschlechtkind2') {
                        //child 2
                        if (isset($requestData['versichern']) && $requestData['versichern'] == 'ek') {
                            if ($value == 1 || $value == '1' || $value == 'Herr') {
                                $results['versicherungsdaten']['vp_geschlecht_Person3'] = 'm';
                            } else {
                                $results['versicherungsdaten']['vp_geschlecht_Person3'] = 'w';
                            }
                        } elseif (isset($requestData['versichern']) && $requestData['versichern'] == 'k') {
                            if ($value == 1 || $value == '1' || $value == 'Herr') {
                                $results['versicherungsdaten']['vp_geschlecht_Person2'] = 'm';
                            } else {
                                $results['versicherungsdaten']['vp_geschlecht_Person2'] = 'w';
                            }
                        } else {
                            unset($requestData[$key]);
                        }
                    } elseif ($key == 'berufsstatus') {
                        /*
                         * WICHTIG:
                         * Service liefert nicht die Zahlen aus dem Formular zurück
                         * sondern dazu in Verbindung stehende Texte
                         */
                        $map = array(
                            'Angestellter'     => 'arbeitnehmer',
                            'Selbststaendiger' => 'selbststaendig',
                            'Beamtenanwaerter' => 'anwaerter',
                            'Arbeiter'         => 'arbeiter',
                            'Freiberufler'     => 'freiberufler',
                            'Beamter'          => 'beamter',
                            'Hausfrau'         => 'hausfrau',
                            'Arbeitsloser'     => 'arbeitslos',
                            'Student'          => 'student',
                            'Schueler'         => 'schueler',
                            'Azubi'            => 'azubi',
                            'Rentner'          => 'rentner'
                        );

                        if (isset($map[$value])) {
                            $status = $map[$value];
                        } else {
                            $status = 'sonstige';
                        }

                        $results['versicherungsdaten']['berufsStatus'] = $status;

                        if (isset($requestData['versichern']) && ($requestData['versichern'] == 'e' || $requestData['versichern'] == 'ek')) {
                            $results['versicherungsdaten']['vp_berufsstatus_Person1'] = $status;
                        }
                    } elseif ($key == 'Tarifkomponenten') {
                        $value  = str_replace('&quot;', '"', $value);
                        $value  = unserialize($value);
                        $value2 = array();

                        if (is_array($value)) {
                            foreach ($value as $tarifKey => $tarif) {
                                if ($tarif['key_0']['Tarif'] != '') {
                                    if ($tarifKey == 'P') {
                                        $tarifKey = 'Pflege';
                                    } elseif ($tarifKey == 'GSs') {
                                        $tarifKey = 'station&auml;r';
                                    } elseif ($tarifKey == 'GAs') {
                                        $tarifKey = 'ambulant';
                                    } elseif ($tarifKey == 'GDs') {
                                        $tarifKey = 'dental';
                                    } elseif ($tarifKey == 'KT') {
                                        $tarifKey = 'Krankentagegeld';
                                    } else {
                                        $tarifKey = '';
                                    }
                                    if (isset($value2[$tarif['key_0']['Tarif']])) {
                                        if (!in_array($tarifKey, $value2[$tarif['key_0']['Tarif']]['Components'])) {
                                            $value2[$tarif['key_0']['Tarif']]['Components'][] = $tarifKey;
                                        }
                                    } else {
                                        $value2[$tarif['key_0']['Tarif']]['Beitrag']      = $tarif['key_0']['Beitrag'];
                                        $value2[$tarif['key_0']['Tarif']]['Components'][] = $tarifKey;
                                    }
                                }
                            }
                        }

                        foreach ($value2 as $tarifKey => $tarif) {
                            $value2[$tarifKey]['Components'] = implode(', ', $tarif['Components']);
                        }

                        $results['versicherungsdaten']['Tarifkomponenten'] = $value2;
                    }
                }
            }

            /*
             * reformat dataset blocks
             */
            $bloecke = $data['datensatz']['bloecke'];
            $this->_view->assign('bloecke', $bloecke);

            unset($data['datensatz']['bloecke']);
            $data['bloecke'] = $bloecke;

            $prevBlock     = null;
            $actualBlock   = 0;
            $nextBlock     = 1;
            $actualBlockID = 1;
            //var_dump($data['datensatz']['felder'][0]['baustein_id']);
            //var_dump($bloecke);
            if ($countNext) {
                foreach ($bloecke as $block) {
                    if ($block['bausteinid'] == $data['datensatz']['felder'][0]['baustein_id']) {
                        $actualBlock     = $block['nummerierung'];
                        $actualBlockName = $block['bezeichnung'];
                        $actualBlockID   = $block['bausteinid'];

                        $nextBlock   = $block['nummerierung'] + 1;

                        if ($nextBlock > count($bloecke)) {
                            $nextBlock = null;
                        }

                        $prevBlock   = $block['nummerierung'] - 1;
                        if ($prevBlock < 0) {
                            $prevBlock = null;
                        }

                        break;
                    }
                }
            } else {
                $nextBlock       = (isset($requestData['prevBlock'])   ? $requestData['prevBlock']   : 1);
                $prevBlock       = (isset($requestData['prevBlock'])   ? $requestData['prevBlock']   : null);
                $actualBlock     = (isset($requestData['actualBlock']) ? $requestData['actualBlock'] : 0);
                $actualBlockName = '';
            }
            //var_dump($bloecke);
            //var_dump($data['datensatz']);
            //var_dump($actualBlock);
            //var_dump($prevBlock);
            $this->_view->assign('prevBlock', $prevBlock);
            $this->_view->assign('actualBlock', $actualBlock);
            $this->_view->assign('nextBlock', $nextBlock);
            $this->_view->assign('actualBlockName', $actualBlockName);
            $this->_view->assign('actualBlockID', $actualBlockID);

            /*
             * reformat dataset
             */
            $datensatz = array();
            foreach ($data['datensatz'] as $key1 => $record) {
                $datensatz[] = $record;
            }

            //var_dump($datensatz);
            $this->_view->assign('data', $data);
            $this->_view->assign('datensatz', $datensatz);

            $berufsStatus = null;

            /*
             * assign all fields to smarty directly
             */
            foreach ($datensatz as $key1 => $record) {
                foreach ($record as $fieldkey => $field) {
                    if ($field['feldname'] == 'nationalität') {
                        $this->_view->assign('nationalitaet', $field);
                    } elseif ($field['feldname'] == 'berufsStatus') {
                        $this->_view->assign($field['feldname'], $field);
                        $berufsStatus = preg_replace('/\#\d+/', '', $field['value']);
                    } else {
                        $this->_view->assign($field['feldname'], $field);
                    }
                }
            }

            /*
             * define actual berufsstatus to make Javascript easier
             */
            //var_dump($results['versicherungsdaten']['berufsStatus']);
            //var_dump($results['anfragedaten']['berufsstatus']);
            if ($berufsStatus === null) {
                $berufsStatus = $results['versicherungsdaten']['berufsStatus'];
            }
            switch ($berufsStatus) {
            case 'angestellt':
            case 'arbeiter':
            case 'arbeitnehmer':
                $berufsStatus = 'arbeitnehmer';
                break;
            case 'freiberufler':
            case 'selbststaendig':
                $berufsStatus = 'selbststaendig';
                break;
            case 'anwaerter':
            case 'beamter':
                $berufsStatus = 'beamter';
                break;
            case 'hausfrau':
            case 'arbeitslos':
                $berufsStatus = 'hausfrau';
                break;
            case 'schueler':
            case 'azubi':
            case 'student':
                $berufsStatus = 'student';
                break;
            case 'sonstige':
                $berufsStatus = 'sonstige';
                break;
            }
            $this->_view->assign('actualBerufsStatus', $berufsStatus);

            if (isset($results['versicherungsdaten']['TarifkombinationIds']) && is_array($results['versicherungsdaten']['TarifkombinationIds'])) {
                $results['versicherungsdaten']['TarifkombinationIds'] = implode(',', $results['versicherungsdaten']['TarifkombinationIds']);
            }

            if (isset($results['kundendaten']) && is_array($results['kundendaten'])) {
                $kundendaten = array_merge($requestData, $results['kundendaten']);
            } else {
                $kundendaten = $requestData;
            }

            /*
             * assign several variables to smarty
             */
            $this->_view->assign('datensatzcount', count($bloecke) - 1);
            $this->_view->assign('versicherungsdaten', $results['versicherungsdaten']);
            $this->_view->assign('kundendaten', $kundendaten);
            $this->_view->assign('anfragedaten', $results['anfragedaten']);
            $this->_view->assign('schluessel', $results['versicherungsdaten']['AnfrageSchluessel']);
            $this->_view->assign('StatusAktiv', $results['versicherungsdaten']['StatusAktiv']);
            $this->_view->assign('StatusEmpfehlung', $results['versicherungsdaten']['StatusEmpfehlung']);
            $this->_view->assign('TarifId', $results['versicherungsdaten']['TarifId']);
            $this->_view->assign('formularId', ((isset($requestData['formularId'])) ? $requestData['formularId'] : null));
            $this->_view->assign('position', $requestData['position']);
            $this->_view->assign('VersichererId', $results['versicherungsdaten']['VersichererId']);
            $this->_view->assign('versichertekinder', $results['anfragedaten']['versichertekinder']);
            $this->_view->assign('versichern', $requestData['versichern']);

            //var_dump($kundendaten);
            $anrede   = ((isset($kundendaten['anrede'])) ? ucfirst($kundendaten['anrede']) : null);
            $titel    = ((isset($kundendaten['titel'])) ? $kundendaten['titel'] : null);
            $vorname  = ((isset($kundendaten['vorname'])) ? ucfirst($kundendaten['vorname']) : null);
            $nachname = ((isset($kundendaten['nachname'])) ? ucfirst($kundendaten['nachname']) : null);

            //var_dump($titel);
            /*
            foreach ($data['bloecke'] as $block) {
                if ($block['bezeichnung'] == 'Vertragsdaten') {
                    $requestData['baustein'] = $block['nummerierung'];
                    break;
                }
            }
            unset($data['bloecke']);

            $data = $this->getPkvAntragData($data, $requestData);
            */
            $data['greeting'] = array(
                'anrede'   => $anrede,
                'vorname'  => $vorname,
                'nachname' => $nachname
            );

            if (!isset($data['greeting']['anrede'])) {
                $data['greeting']['anrede'] = $anrede;
            }

            //var_dump($data['finalize']);
            if ($data['greeting']['anrede'] == 'Herr') {
                $data['greeting']['titel'] = 'Herr';
                $r = 'r';
            } elseif ($data['greeting']['anrede'] == 'Frau') {
                $data['greeting']['titel'] = 'Frau';
                $r = '';
            } else {
                $data['greeting']['titel'] = 'Kundin/Kunde';
                $r = '/r';
            }

            if ($titel != '') {
                $data['greeting']['titel'] .= ' ' . $titel;
            }
            /*
            if ($data['greeting']['vorname'] == '') {
                $data['greeting']['vorname'] = $vorname;
            }

            if ($data['greeting']['nachname'] == '') {
                $data['greeting']['nachname'] = $nachname;
            }
            */
            $data['greeting']['anrede'] = 'Sehr geehrte' . $r . ' ' . $data['greeting']['titel'] . ' ' . ucfirst($data['greeting']['vorname']) . ' ' . ucfirst($data['greeting']['nachname']);
            $data['greeting']['anrede'] = htmlentities(trim($data['greeting']['anrede']), ENT_QUOTES, 'ISO-8859-1');
            $data['greeting']['anrede'] = str_replace('&amp;', '&', $data['greeting']['anrede']);

            $this->_view->assign('greeting', $data['greeting']);
            $this->_view->assign('message', '');
        } elseif (isset($results['message'])) {
            if ($results['message'] == 'ANFRAGESCHLUESSEL_UNGUELTIG') {
                $message = 'Ein Fehler ist aufgetreten. Es wurde ein ung&uuml;ltiger Anfrageschl&uuml;ssel übergeben.';
            } elseif ($results['message'] == 'KEINE_ERGEBNISDATEN_VORHANDEN') {
                $message = 'Ein Fehler ist aufgetreten. Ihre Anfrage wurde vor mehr als 4 Stunden durchgef&uuml;hrt. Die Anfrage wurde inzwischen gel&ouml;scht. Bitte f&uuml;hren Sie eine neue Berechnung aus.';
            } else {
                //unknown error
                $message = 'Ein unerwarteter Fehler ist aufgetreten.';
            }

            $this->_view->assign('message', $message);
        } else {
            //unknown error
            $message = 'Ein unerwarteter Fehler ist aufgetreten.';
            $this->_view->assign('message', $message);
        }

        return $data;
    }

    /**
       * Enter description here...
       *
       * @param array $data
       * @param array $requestData
       *
       * @return array
       * @access public
       */
    protected function getPkvAntrag(array $data, array $requestData)
    {
        unset($requestData['preload']);
        //var_dump($requestData);
        $data = $this->getPkvAntragData($data, $requestData, true);
        unset($data['bloecke']);

        //register needed php functions to smarty
        $this->_view->register_modifier('substring', 'substr');
        $this->_view->register_modifier('stringpos', 'strpos');

        $data['text'] = $this->_view->render('formulare/pkv/calc/pkv_antrag.phtml');

        return $data;
    }

    /**
     * Enter description here...
     *
     * @param array $data
     *
     * @return string
     * @access public
     */
    protected function sendPkvMail(array $data)
    {
        include_once 'Mail.php';
        include_once 'Mail/mime.php';

        $status = 'bad';
        $mail   = $this->_module->mailOnBlacklist($data['email']);

        if ($mail === true) {
            //assign to mailtext template
            $this->_view->assign('data', $data);

            $subject = "GELD.de Private Krankenversicherung - Online Antrag";
            $text    = $this->_view->render("formulare/pkv/pkv_mailtxt_antrag.phtml");
            $html    = $this->_view->render("formulare/pkv/pkv_mailhtml_antrag.phtml");

            //email header information
            $recipients['To']   = $data['input']['email'];
            $headers['Bcc']     = 'marko.schreiber@unister-gmbh.de';
            $headers['From']    = 'info@geld.de';
            $headers['Subject'] = $subject;

            //mime to send html mails
            $crlf = "\n"; //by using Mail, the type of line end to use
            $mime = new Mail_mime($crlf);
            $mime->setTXTBody($text);
            $mime->setHTMLBody($html);

            //build the message and header lines
            $body    = $mime->get();
            $headers = $mime->headers($headers);

            //smtp params
            $params["host"]     = 'mail.geld.de';
            $params["port"]     = 25;
            $params["auth"]     = true;
            $params["username"] = 'info@geld.de';
            $params["password"] = 'info';

            $objMail = Mail::factory('smtp',$params);

            if ($objMail->send($recipients,$headers,stripcslashes($body)) == true) {
                $status = "ok";
            }

            //debugster($data);
        }

        return $status;
    }

    /**
     * Enter description here...
     *
     * @return array
     * @access public
     */
    public function pkvDates()
    {
        $pkv = array();
        /* geburtsjahre pkv */
        $date    = date("Y");
        $datemin = $date - 71; /* max 50 Jahre */
        $datemax = $date - 15; /* min 16 Jahre */
        /* nur bis 18 */
        $datemin_child = $date - 18; /* max 18 Jahre */
        $datemax_child = $date + 1;

        for ($datemin; $datemin < $datemax; $datemin++) {
            $pkv['years'][$datemin] = strval($datemin);
        }
        for ($datemin_child; $datemin_child < $datemax_child; $datemin_child++) {
            $pkv['childyears'][$datemin_child] = strval($datemin_child);
        }

        $pkv['days']   = $GLOBALS['_GLOBAL_DATUM_TAGE_2'];
        $pkv['months'] = $GLOBALS['_GLOBAL_DATUM_MONATE_2'];

        return $pkv;
    }

    /**
       * Enter description here...
       *
       * @param array $data
       * @param array $requestData
       *
       * @return array
       * @access public
       */
    protected function getPkvFeedback(array $data, array $requestData)
    {
        $results = '';

        if (!isset($requestData['pkvfeedback']) || $requestData['pkvfeedback'] != 'save') {
            // Ruediger
            #$url = 'http://192.168.0.38:8137/pkvcalc/?method=getTarife';
            #$url = 'http://slave29.pkv.geld.de/?method=getTarife';
            $url = PKVCALC_URL . '/?method=getTarife';

            // Thomas
            //$url = 'http://192.168.0.38:8090/pkvcalc/?method=create';

            $response = $this->getCurlContent($url,60,60,1,$requestData);
            $results  = $this->unserializeXml($response);

            $versicherungen = array();
            $tarife         = array();

            foreach ($results['getTarife'] as $tarif) {
                if (is_numeric($tarif['softfairversichererid'])) {
                    if (!array_key_exists($tarif['softfairversichererid'], $versicherungen)) {
                        $versicherungen[$tarif['softfairversichererid']] = $tarif['namelang'];
                    }

                    if (!array_key_exists($tarif['softfairversichererid'], $tarife) ||
                        !array_key_exists($tarif['softfairtarifid'], $tarife[$tarif['softfairversichererid']])) {

                        $tarife[$tarif['softfairversichererid']][$tarif['softfairtarifid']] = $tarif['tarifname'];
                    }
                }
            }

            if(isset($requestData['did']))
            {
                $kundenDaten = unserialize(base64_decode($requestData['did']));
                $kundenDaten = $this->_module->prepareCostumerData($kundenDaten);
            }

            $this->_view->assign('data',$kundenDaten);
            $this->_view->assign('datensatzId', $requestData['did']);
            $this->_view->assign('tarife', $tarife);
            $this->_view->assign('versicherungen', $versicherungen);
            $data['text']   = $this->_view->render('formulare/pkv/feedback/pkv_feedback.phtml');


            $data['head']   = '<h1 class="cntHead">Online Umfrage zur Privaten Krankenversicherung</h1>';
            $data['header'] = '';
        } else {
            // Ruediger
//            $url = 'http://192.168.0.38:8137/pkvcalc/?method=saveTarifBewertung';

            // by rüdiger
               $kundenDaten = unserialize(base64_decode($requestData['datensatzId']));

            $tarifId                             = $requestData['versicherungTarif'];
            $datensatzId                        = $kundenDaten['datensatz_id'];
            $bewertung['VersichererId']         = $requestData['versicherungCompany'];
            $bewertung['PreisLeistungRating']     = $requestData['PreisLeistung'];
            $bewertung['PreisLeistungComment']     = $requestData['PreisLeistung_comment'];
            $bewertung['KompetenzRating']         = $requestData['Kompetenz'];
            $bewertung['KompetenzComment']         = $requestData['Kompetenz_comment'];
            $bewertung['ServiceRating']         = $requestData['Service'];
            $bewertung['ServiceComment']         = $requestData['Service_comment'];
            $bewertung['BeitragRating']         = $requestData['Beitrag'];
            $bewertung['BeitragComment']         = $requestData['Beitrag_comment'];
            $bewertung['AufwandRating']         = $requestData['Aufwand'];
            $bewertung['AufwandComment']        = $requestData['Aufwand_comment'];
            $bewertung['RechnungenRating']         = $requestData['Rechnungen'];
            $bewertung['RechnungenComment']     = $requestData['Rechnungen_comment'];
            $bewertung['Dauer']                 = $requestData['Dauer'];
            $bewertung['DauerComment']             = $requestData['Dauer_comment'];
            $bewertung['Empfehlung']             = $requestData['Empfehlung'];
            $bewertung['EmpfehlungComment']     = $requestData['Empfehlung_comment'];
            $bewertung['Fazit']                 = $requestData['Fazit'];

            $bewertungId                         = $this->_module->saveTarifBewertung($tarifId,$datensatzId,$bewertung);

            // Speichere Email, wenn id gesetzt, dann wurde noch kein Gutschein verschickt
            $id = $this->_module->speichereGutscheinEmail($kundenDaten['email']);

            // setzte Flag, ob Gutschein verschickt werden soll
            $kundenDaten['gutschein'] = ($id > 0) ? 1 : 0;
            $kundenDaten['geschlecht'] = ($kundenDaten['geschlecht'] == 'weiblich') ? 'w' : 'm';

            $data['header'] = '';
            if (isset($kundenDaten['datensatz_id'])) {
                $kundenDaten = $this->_module->prepareCostumerData($kundenDaten);
                $this->_view->assign('data',$kundenDaten);
               $data['text'] = $this->_view->render('formulare/pkv/feedback/pkv_feedback_danke_ok.phtml');
            } else {
               $data['text'] = $this->_view->render('formulare/pkv/feedback/pkv_feedback_danke_bad.phtml');
            }
       }

        return $data;
    }

    /**
     * Unsubscribe the PKV Email Reminder
     *
     * @return array
     * @access public
     */
    public function unsubscribeEMailReminder($requestData)
    {
        $url = PKVCALC_URL . '/?method=unsubscribeEMailReminder';
        $response = $this->getCurlContent($url,60,60,1,$requestData);
        $result  = $this->unserializeXml($response);
        if(isset($result["unsubscribeEMailReminder"]['response']) && $result["unsubscribeEMailReminder"]['response'] != '0'){
            return $result["unsubscribeEMailReminder"]['response'];
        } else {
            return false;
        }
    }
} #END CLASS