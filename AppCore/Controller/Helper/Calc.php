<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Controller\Helper;

/**
 * Service-Finder für alle Kredit-Services
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Controller-Helper
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: CalcLogger.php 31 2011-06-26 22:02:43Z tmu $
 */

/**
 * Service-Finder für alle Kredit-Services
 *
 * @category  Kreditrechner
 * @package   Controller-Helper
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @abstract
 */
class Calc extends \Zend\Controller\Action\Helper\AbstractHelper
{
    /**
     * loads the service class
     *
     * @param string $requestType The type of the request
     *
     * @return void
     */
    public function calc()
    {
        return $this->_getResult();
    }

    /**
     * Default-Methode für Services
     *
     * wird als Alias für die Funktion {@link getService} verwendet
     *
     * @param string $service The name of the Service
     * @param string $module  The name of the module
     *
     * @return void
     */
    public function direct()
    {
        return $this->_getResult();
    }
    
    /**
     * TODO:
     *
     * @return void
     */
    private function _getResult()
    {
        $_SESSION->messages = array();
        $changed            = false;
        
        $noResult = (boolean) $this->getActionController()->getHelper('GetParam')->direct('noResult', 0, 'Int', $changed);
        $caid     = (int) $this->getActionController()->getHelper('GetParam')->direct('caid', 1, 'Int', $changed);
        $sparte   = (int) $this->getActionController()->getHelper('GetParam')->direct('sparte', 1, 'Int', $changed);
        $laufzeit = number_format($this->getActionController()->getHelper('GetParam')->direct('laufzeit', 48, null, $changed), 1);
        $betrag   = (int) $this->getActionController()->getHelper('GetParam')->direct('betrag', 10000, 'Int', $changed);
        $zweck    = (int) $this->getActionController()->getHelper('GetParam')->direct('zweck', 8, 'Int', $changed);
        
        $result            = array();
        $_SESSION->changed = $changed;
        
        if (!isset($_SESSION->result) || !is_array($_SESSION->result) || $changed) {
            $modelCampaign = new \AppCore\Service\Campaigns();
            $status        = 'fail';
        
            if ($noResult) {
                /*
                 * the request is marked to be not calculated
                 * -> the calculation is skipped
                 */
                $reason = 'request blocked';
                $result = array();
            } elseif (!$modelCampaign->checkCaid($caid)) {
                /*
                 *the given campaign does not exist
                 * -> the calculation is skipped
                 */
                $reason = 'no valid campaign';
                $result = array();
            } elseif (!$modelCampaign->isActive($caid)) {
                /*
                 * the given campaign is not activated
                 * -> the calculation is skipped
                 */
                $reason = 'campaign is deactivated';
                $result = array();
            } else {
                $result = $this->_doCalculate($caid, $sparte, $laufzeit, $betrag, $zweck);
                $reason = $result['reason'];
                
                if (is_array($result['result']) && 0 < count($result['result'])) {
                    $status = 'ok';
                    $reason = '';
                }
            }

            $result = array_merge(
                array(
                    'status' => $status,
                    'reason' => $reason
                ), 
                $result
            );
            
            $_SESSION->result = $result;
            $_SESSION->messages[] = 'result not from session';
        } else {
            $result = $_SESSION->result;
            $_SESSION->messages[] = 'result from session';
        }
        
        return $result;
    }
    

    /**
     * starts an recalculation
     *
     * @return string    The rendered Calculation Content
     * @access protected
     */
    private function _doCalculate($caid, $sparte, $laufzeit, $betrag, $zweck)
    {
        $usages     = $this->_helper->usages->getList();
        $laufzeiten = $this->_helper->laufzeit->getList($sparte);
        
        $result = array(
            'result' => array(),
            'reason' => 'no result, parameters may be missing',
            'status' => 'fail'
        );
        
        if ($betrag < KREDIT_BETRAG_MIN) {
            $result['reason'] = 'amount is lower than minimum';
            
            return $result;
        }
        
        if ($betrag > KREDIT_BETRAG_MAX) {
            $result['reason'] = 'amount is larger than maximum';
            
            return $result;
        }
        
        if (!array_key_exists($zweck, $usages)) {
            $result['reason'] = 'usage is not unknown/not supported';
            
            return $result;
        }
        
        if (!array_key_exists($laufzeit, $laufzeiten)) {
            $result['reason'] = 'time range is unknown/not supported';
            
            return $result;
        }

        $calculator = new \AppCore\Credit\Calculator();
        $calculator
            ->setCaid($caid)
            ->setView($this->view)
            ->setSparte($sparte)
            ->setLaufzeit($laufzeit)
            ->setZweck($zweck)
            ->setKreditbetrag($betrag)
            ->setBestOnly((boolean) $this->getActionController()->getHelper('GetParam')->direct('bestOnly', 0, 'Int'))
            ->setBonus($this->getActionController()->getHelper('GetParam')->direct('boni', null, 'Int'))
            ->setTeaserOnly((boolean) $this->getActionController()->getHelper('GetParam')->direct('teaserOnly', 0, 'Int'))
            ->setOnlyProduct($this->getActionController()->getHelper('GetParam')->direct('product'))
            ->setOnlyInstitut(strtolower($this->getActionController()->getHelper('GetParam')->direct('institut')))
            ->setTest((boolean) $this->getActionController()->getHelper('GetParam')->direct('isTest', 0, 'Int'));

        try {
            $result = array_merge($result, $calculator->calc());
            
            if (!count($result['result'])) {
                $result['reason'] = 'no matching result';
            } else {
                $result['reason'] = '';
                $result['status'] = 'ok';
            }
        } catch (Exception $e) {
            $this->_logger->err($e);

            $result['reason'] = 'an Exception was thrown while calculating';
        }
        
        return $result;
    }
}