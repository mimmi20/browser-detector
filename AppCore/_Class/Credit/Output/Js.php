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
 * @version   SVN: $Id: Js.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * Controller-Klasse zum Ausliefern von Javascript-Dateien
 *
 * @category  Kreditrechner
 * @package   Credit
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class KreditCore_Class_Credit_Output_Js
    extends KreditCore_Class_Credit_Output_Abstract
{
    /**
     * @return KreditCore_Class_Credit_Output_Js
     */
    public function getOfferLink(\Credit\Core\Model\CalcResult $result)
    {
        $dummy = $this->getOfferLinkWithUrl($result, $this->_baseUrl);

        $offerLnkSecure       = $dummy[0];
        $offerLnkSecureTeaser = $dummy[1];

        return $this->setOfferLinks(
            $result, $this->_baseUrl, $offerLnkSecure, $offerLnkSecureTeaser
        );
    }

    /**
     * creates the URL for the credit request form
     *
     * @param string                      $baseUrl
     * @param \Credit\Core\Model\CalcResult $result
     * @param boolean                     $teaser
     *
     * @return string
     */
    protected function getLink(
        $baseUrl,
        $offerLnk,
        \Credit\Core\Model\CalcResult $result,
        $teaser = false)
    {
        return $baseUrl
               . '?function=antrag'
               . '&showAntrag=1'
               . '&campaignId='     . $this->_caid
               . '&kreditbetrag='   . $this->_kreditbetrag
               . '&laufzeit='       . $this->_laufzeit
               . '&vzweck='         . $this->_zweck
               . '&sparte='         . $this->_sparteName
               . '&kreditInstitut=' . $this->_institut
               . '&product='        . $result->product
               . (($teaser) ? '&teaser=1' : '')
               . '&internal='       . (int) $this->_isinternal
               . ($this->_test ? '&unitest=1' : '');
    }
}