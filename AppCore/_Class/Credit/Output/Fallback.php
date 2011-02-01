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
class \AppCore\Credit\Output\Fallback
    extends \AppCore\Credit\Output\AbstractOutput
{
    /**
     * @return \AppCore\Credit\Output\Fallback
     */
    public function getOfferLink(\AppCore\Model\CalcResult $result)
    {
        $baseUrl = rtrim($this->_urlDirAntrag, '/') . '/';

        $dummy   = $this->getOfferLinkWithUrl($result, $baseUrl);

        $offerLnkSecure       = $dummy[0];
        $offerLnkSecureTeaser = $dummy[1];

        //create the redirect link
        return $this->setOfferLinks(
            $result, $this->_baseUrl, $offerLnkSecure, $offerLnkSecureTeaser
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
        /*
        if ($this->_urlAbsolute && $this->_isinternal) {
            return $offerLnk;
        }
        */

        return $baseUrl
               . '?partner_id='     . $this->_campaign
               . '&kreditbetrag='   . $this->_kreditbetrag
               . '&laufzeit='       . $this->_laufzeit
               . '&vzweck='         . $this->_zweck
               . '&sparte='         . $this->_sparteName
               . '&kreditInstitut=' . $this->_institut
               . '&product='        . $result->product
               . (($teaser) ? '&teaser=1' : '')
               . '&internal='       . (int) $this->_isinternal
               . ($this->_test ? '&unitest=1' : '')
               . '&redirect='       . urlencode(utf8_encode($offerLnk));
    }

    /**
     * @return \AppCore\Credit\Output\Fallback
     */
    public function getInfoLink(\AppCore\Model\CalcResult $result)
    {
        $baseUrl = rtrim($this->_urlDirAntrag, '/') . '/';

        if (!$this->_urlAbsolute) {
            $baseUrl .= 'kreditrechner-informationen-zum-anbieter.html';
        }

        $infoParams = $this->getInfoParamsInternal();
        $int        = ($this->_urlDirAntrag == \Zend\Registry::get('_home'));

        $infoParams['offerLnk']       = $result->offerLnk;
        $infoParams['partner_id']     = $this->_caid;
        $infoParams['kreditInstitut'] = $this->_institut;
        $infoParamsTeaser             = array();

        $infoLnk = \AppCore\Globals::postToGetUrl(
            $baseUrl,
            $infoParams,
            $int
        );

        $infoLnkTeaser = '';

        if ($this->_isteaser) {
            $infoParamsTeaser = $this->getInfoParamsInternal();

            $infoParamsTeaser['offerLnk']       = $result->offerLnk_teaser;
            $infoParamsTeaser['partner_id']     = $this->_caid;
            $infoParamsTeaser['kreditInstitut'] = $this->_institut;

            $infoLnkTeaser = \AppCore\Globals::postToGetUrl(
                $baseUrl,
                $infoParamsTeaser,
                $int
            );
        }

        $result->infoLnk = $infoLnk;

        if ($this->_isteaser) {
            $result->infoLnk_teaser = $infoLnkTeaser;
        }

        return $this;
    }

    /**
     * sets the base url
     *
     * @return \AppCore\Credit\Output\AbstractOutput
     */
    protected function getBaseUrl()
    {
        //if ($this->_urlAbsolute && $this->_isinternal) {
        //    $this->_baseUrl = rtrim($this->_urlDirAntrag, '/') . '/';
        //} else {
            $this->_baseUrl  = rtrim($this->_urlDir, '/') . '/';
            $this->_baseUrl .= (substr($this->_urlDir, -5) == '.html'
                             ? '' : 'kredite.html');
        //}

        return $this;
    }
}