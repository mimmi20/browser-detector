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
     * @param string $details the detail level of the output
     *
     * @return void
     */
    public function calcResult($details = 'full')
    {
        return $this->_getResult($details);
    }

    /**
     * Default-Methode für Services
     *
     * wird als Alias für die Funktion {@link getService} verwendet
     *
     * @param string $details  The name of the module
     *
     * @return void
     */
    public function direct($details = 'full')
    {
        return $this->_getResult($details);
    }
    
    /**
     * TODO:
     *
     * @return void
     */
    private function _getResult($details = 'full')
    {
        $_SESSION->messages = array();
        $changed            = false;
        
        if (null === $this->getActionController()) {
            throw new \Exception('no action controller');
        }
		
		$allowedDetails = array(
			'full', 'short', 'id'
		);
		
		if (!is_string($details) || !in_array($details, $allowedDetails)) {
			$details = 'full';
		}
        
        $noResult = (boolean) $this->getActionController()->getHelper('getParam')->getParamFromName('noResult', 0, 'Int', $changed);
        $caid     = (int) $this->getActionController()->getHelper('getParam')->getParamFromName('caid', 1, 'Int', $changed);
        $sparte   = (int) $this->getActionController()->getHelper('getParam')->getParamFromName('sparte', 1, 'Int', $changed);
        $loanPeriod = number_format($this->getActionController()->getHelper('getParam')->getParamFromName('laufzeit', 48, null, $changed), 1);
        $loanAmount   = (int) $this->getActionController()->getHelper('getParam')->getParamFromName('betrag', 10000, 'Int', $changed);
        $usage    = (int) $this->getActionController()->getHelper('getParam')->getParamFromName('zweck', 8, 'Int', $changed);
		
		$this->getActionController()->view->laufzeit = $loanPeriod;
        
        $result            = array();
        $_SESSION->changed = $changed;
        
        if (!isset($_SESSION->result) 
			|| !is_array($_SESSION->result) 
			|| !isset($_SESSION->result['status'])
			|| 'ok' != $_SESSION->result['status']
			|| true //$changed
		) {
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
            } elseif ($loanAmount < KREDIT_BETRAG_MIN) {
                /*
                 * the requested loan amount is lower than the defined minimum
                 * -> the calculation is skipped
                 */
                $reason = 'amount is lower than minimum';
                $result = array();
            } elseif ($loanAmount > KREDIT_BETRAG_MAX) {
                /*
                 * the requested loan amount is greater than the defined maximum
                 * -> the calculation is skipped
                 */
                $reason = 'amount is larger than maximum';
                $result = array();
            } elseif (!array_key_exists($usage, $this->getActionController()->getHelper('usages')->getList())) {
                /*
                 * the requested usage is not supported
                 * -> the calculation is skipped
                 */
                $reason = 'usage is not unknown/not supported';
                $result = array();
            } elseif (!array_key_exists($loanPeriod, $this->getActionController()->getHelper('laufzeit')->getList($sparte))) {
                /*
                 * the requested loan period is not supported
                 * -> the calculation is skipped
                 */
                $reason = 'loan period is unknown/not supported';
                $result = array();
            } else {
                $result = $this->_doCalculate($caid, $sparte, $loanPeriod, $loanAmount, $usage, $details);
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
            
			// save the result into the session, only the calculation did not fail
			if ('ok' == $result['status']) {
				$_SESSION->result = $result;
			}
			
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
    private function _doCalculate($caid, $sparte, $loanPeriod, $loanAmount, $usage, $details = 'full')
    {
        $result = array(
            'result' => array(),
            'reason' => 'no result, parameters may be missing',
            'status' => 'fail'
        );

        $calculator = new \AppCore\Credit\Calculator();
        $calculator
            ->setCaid($caid)
            ->setView($this->getActionController()->view)
            ->setSparte($sparte)
            ->setLaufzeit($loanPeriod)
            ->setZweck($usage)
            ->setKreditbetrag($loanAmount)
			->setDetails($details)
            ->setBestOnly((boolean) $this->getActionController()->getHelper('getParam')->getParamFromName('bestOnly', 0, 'Int'))
            ->setBonus($this->getActionController()->getHelper('getParam')->getParamFromName('boni', null, 'Int'))
            ->setTeaserOnly((boolean) $this->getActionController()->getHelper('getParam')->getParamFromName('teaserOnly', 0, 'Int'))
            ->setOnlyProduct($this->getActionController()->getHelper('getParam')->getParamFromName('product'))
            ->setOnlyInstitut(strtolower($this->getActionController()->getHelper('getParam')->getParamFromName('institut')))
            ->setTest((boolean) $this->getActionController()->getHelper('getParam')->getParamFromName('isTest', 0, 'Int'));

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