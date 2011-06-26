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
 * @version   SVN: $Id$
 */

/**
 * Controller-Klasse zum Ausliefern von Javascript-Dateien
 *
 * @category  Kreditrechner
 * @package   Credit
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class \AppCore\Credit\Output_Iframe
    extends \AppCore\Credit\Output\AbstractOutput
{
    /**
     * @return \AppCore\Credit\Output_Iframe
     */
    public function getOfferLink(\AppCore\Model\CalcResult $result)
    {
        $int = ($this->_urlDirAntrag == \Zend\Registry::get('_home'));

        if ($this->_isinternal) {
            //use interal URL for offer, ignore URL in DB
            $offerLnk       = $this->_baseUrl;
            $offerLnkTeaser = $this->_baseUrl;
        } else {
            //read URL for offer
            $offerLnk       = (string) $result->url;
            $offerLnkTeaser = (string) $result->urlTeaser;

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

        $antragParams = $this->getOfferParams();

        if ($this->_isinternal) {
            $offerLnk = \AppCore\Globals::postToGetUrl(
                $offerLnk, $antragParams, $int
            );

            if ($offerLnkTeaser != '') {
                $antragParams   = $antragParams;
                $offerLnkTeaser = \AppCore\Globals::postToGetUrl(
                    $offerLnkTeaser, $antragParams, $int
                );
            }
        }

        return $this->setOfferLinks(
            $result, $this->_baseUrl, $offerLnk, $offerLnkTeaser
        );
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
        return $baseUrl . 'iframe/kredite/function/antrag'
               . '/campaignId/'     . $this->_caid
               . '/kreditbetrag/'   . $this->_kreditbetrag
               . '/laufzeit/'       . $this->_laufzeit
               . '/vzweck/'         . $this->_zweck
               . '/sparte/'         . $this->_sparteName
               . '/kreditInstitut/' . $this->_institut
               . '/product/'        . $result->product
               . (($teaser) ? '/teaser/1' : '')
               . '/internal/'       . (int) $this->_isinternal
               . ($this->_test ? '/unitest/1' : '');
    }
}