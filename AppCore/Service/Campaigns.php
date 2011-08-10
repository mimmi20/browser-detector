<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Service;

/**
 * Service
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Services
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id$
 */

/**
 * Service
 *
 * @category  Kreditrechner
 * @package   Services
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class Campaigns extends ServiceAbstract
{
    /**
     * Class Constructor
     *
     * @return \\AppCore\\Service\Campaigns
     */
    public function __construct()
    {
        $this->_model = new \AppCore\Model\Campaigns();
    }

    /**
     * returns the id of an institute
     *
     * @return Zend_Db_Table_Select
     * @access public
     */
    public function getList()
    {
        return $this->_model->getCached('campaign')->getList();
    }

    /**
     * cleans a given partner id
     *
     * @param string $caid        the campaign id
     * @param array  $requestData the given request data
     * @param string $agent       the user agent
     *
     * @return string
     * @access public
     */
    public function cleanCaid($caid)
    {
        return $this->_model->getCached('campaign')->cleanCaid($caid);
    }

    /**
     * cleans a given partner id and loads the partner and host information
     *
     * @param string|integer $paid        (input) the partner id to be loaded
     * @param array          $requestData the given request data
     * @param string         $agent       the user agent
     * @param integer        &$paid       the partner id
     * @param integer        &$caid       the campaign id
     * @param string         &$hostname   the hostname from the campaign
     * @param boolean        $isTest      TRUE, if the Request is a test
     *
     * @return boolean
     * @access public
     */
    public function loadCaid(
        $value,
        &$paid = null,
        &$caid = null,
        &$hostname = null)
    {
        $result = $this->_model->getCached('campaign')->loadCaidArray($value);

        if (is_array($result)) {
            $paid     = $result['paid'];
            $caid     = $result['caid'];
            $hostname = $result['hostname'];

            return true;
        }

        return false;
    }

    /**
     * checks, if a campaign for the given id exists
     *
     * @param integer $caid der Wert, der geprüft werden soll
     *
     * @return boolean
     * @access protected
     */
    public function checkCaid($caid)
    {
        return $this->_model->getCached('campaign')->checkCaid($caid);
    }

    /**
     * returns the id for a campaign
     *
     * @param integer $caid id or name of the campaign
     *
     * @return boolean|integer FALSE, wenn die Sparte nicht existiert,
     *                         ansonsten die ID der Sparte
     * @access protected
     */
    public function getId($caid)
    {
        return $this->_model->getCached('campaign')->getId($caid);
    }

    /**
     * returns the id for a campaign
     *
     * @param mixed $value id or name of the campaign
     *
     * @return boolean|integer FALSE, wenn die Sparte nicht existiert,
     *                         ansonsten die ID der Sparte
     * @access protected
     */
    public function getIdFromName($value)
    {
        return $this->_model->getCached('campaign')->getIdFromName($value);
    }

    /**
     * returns the id for a campaign
     *
     * @param mixed $value id or name of the campaign
     *
     * @return string ein leerer String, wenn die Kampagne nicht existiert,
     *                ansonsten der Name der Kampagne
     * @access protected
     */
    public function getCampaignName($value)
    {
        return $this->_model->getCached('campaign')->getCampaignName($value);
    }

    /**
     * returns the name for a campaign
     *
     * @param mixed $value id or name of the campaign
     *
     * @return string ein leerer String, wenn die Kampagne nicht existiert,
     *                ansonsten der Name der Kampagne
     * @access protected
     */
    public function getName($value)
    {
        return $this->_model->getCached('campaign')->getCampaignName($value);
    }

    /**
     * returns the id for a campaign
     *
     * @param mixed $value id or name of the campaign
     *
     * @return string ein leerer String, wenn die Kampagne nicht existiert,
     *                ansonsten der Name des Portals
     * @access protected
     */
    public function getPortalName($value)
    {
        return $this->_model->getCached('campaign')->getPortalName($value);
    }

    /**
     * returns the id for a campaign
     *
     * @param mixed $value id or name of the campaign
     *
     * @return string ein leerer String, wenn die Kampagne nicht existiert,
     *                ansonsten der Name der Kampagne
     * @access protected
     */
    public function getLine($value)
    {
        return $this->_model->getCached('campaign')->getLine($value);
    }

    /**
     * returns the default campaign from the portal of a given campaign
     *
     * @param integer $campaignId
     *
     * @return \Zend\Db\Table\Row
     * @access public
     */
    public function getDefaultCampaign($campaignId)
    {
        $portal = $this->getPortal($campaignId);

        if (null === $portal) {
            return null;
        }

        $newCampaignId = $this->getIdFromName($portal->name);
        $campaign      = $this->find($newCampaignId)->current();

        if (is_object($campaign)) {
            return $campaign;
        } else {
            return null;
        }
    }

    /**
     * returns an \AppCore\Model\Portal object for an campaign id
     *
     * @param integer $campaignId
     *
     * @return \AppCore\Service\PartnerSites
     * @access public
     */
    public function getPortal($campaignId)
    {
        $dbPortale = new \AppCore\Service\PartnerSites();

        return $dbPortale->loadByCampaign($campaignId);
    }

    /**
     * returns the default campaign from the portal of a given campaign
     *
     * @param integer $campaignId
     *
     * @return \AppCore\Model\Campaign
     * @access public
     */
    public function getTestCampaign($campaignId)
    {
        return $this->_model->getCached('campaign')
            ->getTestCampaign($campaignId);
    }

    /**
     * Get Child List of a Parent Element
     *
     * @param array|integer $portalId  the portal ID to search the campaigns
     * @param boolean       $withTests If TRUE, also the test campaigns are
     *                                 included in the result
     *
     * @return \Zend\Db\Table\Rowset
     * @access public
     */
    public function getCampaignsFromPortal($portalId, $withTests = true)
    {
        return $this->_model->getCached('campaign')->getCampaignsFromPortal(
            $portalId, $withTests
        );
    }

    /**
     * Fetches rows by primary key.  The argument specifies one or more primary
     * key value(s).  To find multiple rows by primary key, the argument must
     * be an array.
     *
     * This method accepts a variable number of arguments.  If the table has a
     * multi-column primary key, the number of arguments must be the same as
     * the number of columns in the primary key.  To find multiple rows in a
     * table with a multi-column primary key, each argument must be an array
     * with the same number of elements.
     *
     * The find() method always returns a Rowset object, even if only one row
     * was found.
     *
     * @param  mixed $key The value(s) of the primary keys.
     * @return \Zend\Db\Table\Rowset_Abstract Row(s) matching the criteria.
     * @throws Zend_Db_Table_Exception
     */
    public function find($campaignId = null)
    {
        return $this->_model->getCached('campaign')->find($campaignId);
    }

    /**
     * cleans the model cache
     *
     * calls the {@link _cleanCache} function with defined tag name
     *
     * @return \AppCore\Service\Campaigns
     */
    public function cleanCache()
    {
        return $this->cleanTaggedCache('campaign');
    }

    /**
     * checks, if a campaign for the given id is activated
     *
     * @param integer $caid der Wert, der geprüft werden soll
     *
     * @return boolean
     */
    public function isActive($caid)
    {
        return $this->_model->getCached('campaign')->isActive($caid);
    }
}