<?php
/**
 * Funktionen für Kreditrechner
 *
 * PHP version 5
 *
 * @category  Preisvergleich.de
 * @package   Kreditrechner
 * @author    Marko Schreiber <marko.schreiber@unister-gmbh.de>
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2008 Unister GmbH
 * @version   SVN: $Id: Kredit.php 13 2011-01-06 21:27:04Z tmu $
 */

require_once LIB_PATH . 'Unister' . DS . 'Finance' . DS . 'Core' . DS . 'Abstract.php';

/**
 * Funktionen für Kreditrechner
 *
 * @category  Preisvergleich.de
 * @package   Kreditrechner
 * @author    Marko Schreiber <marko.schreiber@unister-gmbh.de>
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2008 Unister GmbH
 */
class Unister_Finance_Core_Kredit extends Unister_Finance_Core_Abstract
{
    protected $post = false;

    /**
     * Fetches Data from www.geld.de
     *
     * @param array $data
     * @param array $requestData the given GET or POST parameters
     *
     * @return array
     * @access public
     */
    public function getKredite(array $data, array $requestData)
    {
        if (!isset($requestData['laufzeit'])) {
            $requestData['laufzeit'] = 36;
        }

        if (!isset($requestData['vzweck'])) {
            $requestData['vzweck'] = 8;
        }

        if (!isset($requestData['kreditbetrag']) || (int) $requestData['kreditbetrag'] <= 0) {
            $requestData['kreditbetrag'] = 10000;
        }

        if (!isset($requestData['boni']) || !in_array($requestData['boni'], array('0', '1', 'ja', 'nein'))) {
            $requestData['boni'] = '0';
        }

        if (!isset($requestData['partner_id'])) {
            $requestData['partner_id'] = 'geldde';
            $requestData['paid'] = 'geldde';
        }
        $requestData['ccstart']    = 1;
        $requestData['nav_id']     = $data['nav_id'];
        $requestData['datei_name'] = 'kredite';
        $requestData['krediturl']  = HOME_URL . 'kredite.html';
        
        //Formular
        $url      = KREDIT_URL . "/Kredit/Normalform/";
        $XML_Data = $this->getCurlContent($url, 60, 60, $this->post, $requestData);
        $XML_Data = $this->rewriteURL($XML_Data);
        
        $data['text'] .= $XML_Data;
        
        //Ergebnisübersicht
        $url      = KREDIT_URL . "/Kredit/Calc/";
        $XML_Data = $this->getCurlContent($url, 60, 60, $this->post, $requestData);
        $XML_Data = $this->rewriteURL($XML_Data);
        
        $data['text'] .= $XML_Data;
        //$data['text'] .= $XML_Data;
        //var_dump($data['files']);
        return $data;
    }

    /**
     * logs Clicks into the geld.de-database
     *
     * @param array  $requestData the given GET or POST parameters
     * @param string $nav_id      (optinal) the Page ID
     * @param string $params      (optinal) the Request Uri
     *
     * @return void
     * @access public
     */
    public function logClick(array $requestData, $nav_id = null, $params = null)
    {
        $requestData['log_click']  = 1;
        $requestData['ccstart']    = 1;
        $requestData['nav_id']     = $nav_id;
        $requestData['datei_name'] = 'kredite';

        $response = $this->getCurlContent(KREDIT_URL . "/Kredit/Log/", 5, 5, $this->post, $requestData);
    }

    /**
     * fetches Kredit-Info from geld.de
     *
     * @param array $data
     * @param array $requestData the given GET or POST parameters
     *
     * @return void
     * @access public
     */
    public function getInfo(array $data, array $requestData)
    {
        $requestData['ccrq']       = 'info';
        $requestData['datei_name'] = 'kredite';
        $requestData['lnktype']    = 'info';

        $XML_Data = $this->getCurlContent(KREDIT_URL . "/Kredit/Info/", 30, 30, $this->post, $requestData);
        $XML_Data = $this->rewriteURL($XML_Data);

        if (!$this->requestOK($XML_Data)) {
            $XML_Data_unserialize = '';
        } elseif ($this->requestNoResult($XML_Data)) {
            $XML_Data_unserialize = array();
        } elseif (strpos($XML_Data, '<Information>doNotParse</Information>') !== false) {
            $XML_Data_unserialize = str_replace('&amp;', '&', str_replace('<Information>doNotParse</Information>', '', $XML_Data));
        } else {
            $XML_Data             = str_replace('&amp;', '&', $XML_Data);
            $XML_Data_unserialize = $this->_module->unserializeXml($XML_Data);
        }

        $requestData['lnktype'] = 'info';
        $this->logClick($requestData, $requestData['nav_id'], null);

        echo $XML_Data_unserialize;
        exit;
    }

    /**
     * fetches Kredit-Info from geld.de
     *
     * @param array $data
     * @param array $requestData the given GET or POST parameters
     *
     * @return void
     * @access public
     */
    public function getAntrag(array $data, array $requestData)
    {
        $requestData['ccstart']    = 1;
        $requestData['datei_name'] = 'kredite';
        $requestData['lnktype']    = 'antrag';

        unset($requestData['0']);
        unset($requestData['redirect']);
        unset($requestData['ccrq']);

        $XML_Data = $this->getCurlContent(KREDIT_URL . "/Kredit/Antrag/", 30, 30, $this->post, $requestData);
        $XML_Data = $this->rewriteURL($XML_Data);
        if (!$this->requestOK($XML_Data)) {
            $XML_Data_unserialize = '';
        } elseif ($this->requestNoResult($XML_Data)) {
            $XML_Data_unserialize = array();
        } elseif (strpos($XML_Data, '<Information>doNotParse</Information>') !== false) {
            $XML_Data_unserialize = str_replace('&amp;', '&', str_replace('<Information>doNotParse</Information>', '', $XML_Data));
        } else {
            $XML_Data             = str_replace('&amp;', '&', $XML_Data);
            $XML_Data_unserialize = $this->_module->unserializeXml($XML_Data);
        }

        $requestData['lnktype'] = 'antrag';
        $this->logClick($requestData, $requestData['nav_id'], null);

        //var_dump($response);
        echo $XML_Data_unserialize;
        exit;
    }

    /**
     * @access public
     */
    public function rewriteURL($url)
    {
        return $url;
    }

    /**
     * @access public
     */
    public static function microtimeFloat()
    {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }

    /**
     * checks if an Error occured during an Curl Request
     *
     * @param string $XML_Data an Curl-Response String
     *
     * @return boolean
     * @access protected
     */
    protected function requestOK($XML_Data)
    {
        if (strpos($XML_Data, 'Couldn\'t resolve host') !== false ||
            strpos($XML_Data, 'couldn\'t connect to host') !== false ||
            strpos($XML_Data, 'Operation timed out') !== false) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * checks if the Curl Response is an empty XML structure
     *
     * @param string $XML_Data an Curl-Response String
     *
     * @return boolean
     * @access protected
     */
    protected function requestNoResult($XML_Data)
    {
        if (strpos($XML_Data, '<result/>') !== false) {
            return true;
        } else {
            return false;
        }
    }
} #END CLASS