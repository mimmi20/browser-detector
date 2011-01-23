<?php
declare(ENCODING = 'iso-8859-1');
namespace Credit\Core\Service;

/**
 * Service
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Services
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: Portale.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * Service
 *
 * @category  Kreditrechner
 * @package   Services
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class Portale extends ServiceAbstract
{
    /**
     * Class Constructor
     *
     * @return \Credit\Core\Service\Portale
     */
    public function __construct()
    {
        $this->_model = new \Credit\Core\Model\Portale();
    }

    /**
     * Get complete List of Partner that are not childs
     *
     * @return \Zend\Db\Table\Rowset
     * @access public
     */
    public function fetchList()
    {
        return $this->_model->getCached('portal')->fetchList();
    }

    /**
     * Get Child List of a Parent Element
     *
     * TODO: add new column to table "isTest"
     *
     * @param \Zend\Db\Table\Row_Abstract $parent the portal to search the
     *                                           campaigns
     *
     * @return \Zend\Db\Table\Rowset
     * @access public
     */
    public function getChildList($parent, $withTests = true)
    {
        if (is_object($parent) && isset($parent->p_id)) {
            $portalId = $parent->p_id;
        } else {
            $portalId = null;
        }

        $dbCampaigns = new \Credit\Core\Service\Campaigns();
        return $dbCampaigns->getCampaignsFromPortal($portalId, $withTests);
    }

    /**
     * Get Child List of a Parent Element
     *
     * @param string $campaigns a comma separated list of campaign ids
     *
     * @return \Zend\Db\Table\Rowset
     * @access public
     */
    public function getChildListPartly($campaigns = '', $withTests = true)
    {
        $dbCampaigns = new \Credit\Core\Service\Campaigns();
        return $dbCampaigns->getCampaignsFromPortal($campaigns, $withTests);
    }

    /**
     * Get Child List of a Parent Element
     *
     * @return \Zend\Db\Table\Rowset
     * @access public
     */
    public function getChildListComplete($withTests = true)
    {
        $dbCampaigns = new \Credit\Core\Service\Campaigns();
        return $dbCampaigns->getCampaignsFromPortal(null, $withTests);
    }

    /**
     * cleans a given partner id
     *
     * @param string $paid        the partner id
     * @param array  $requestData the given request data
     * @param string $agent       the user agent
     *
     * @return string
     * @access public
     */
    public function cleanPaid($paid, $requestData = array(), $agent = '')
    {
        return $this->_model->getCached('portal')->cleanPaid(
            $paid, $requestData, $agent
        );
    }

    /**
     * checkt die Partner-ID
     *
     * @param mixed $value der Wert, der geprüft werden soll
     *
     * @return boolean
     * @access protected
     */
    public function checkPaid($value)
    {
        $return = $this->_model->getCached('portal')->checkPaid($value);

        if (!$return) {
            $dbCampaigns = new \Credit\Core\Service\Campaigns();
            $return      = $dbCampaigns->checkCaid($value);
        }

        return $return;
    }

    /**
     * Get Child List of a Parent Element
     *
     * @param string $campaign a campaign name
     *
     * @return \Zend\Db\Table\Rowset
     * @access public
     */
    public function loadByCampaign($campaign = '')
    {
        return $this->_model->getCached('portal')->loadByCampaign($campaign);
    }

    /**
     * returns the name of a partner
     *
     * @param integer|string the id/name of the partner
     *
     * @return string
     */
    public function getName($paid)
    {
        return $this->_model->getCached('portal')->getName($paid);
    }

    /**
     * returns the name of a partner
     *
     * @param integer|string the id/name of the partner
     *
     * @return string
     */
    public function getAdresse($paid)
    {
        return $this->_model->getCached('portal')->getAdresse($paid);
    }

    /**
     * returns the id for a campaign
     *
     * @param integer|string $paid the id/name of the partner
     *
     * @return boolean|integer FALSE, if the Campagne don't exist,
     *                         the  ID of the Campagne otherwise
     * @access protected
     */
    public function getId($paid)
    {
        if (empty($paid) || is_array($paid)) {
            //partner id in wrong format
            return false;
        }

        if (!is_string($paid) && !is_numeric($paid)) {
            //partner id in wrong format
            return false;
        }

        if (is_numeric($paid) && 0 >= (int) $paid) {
            return false;
        }

        return $this->_model->getCached('portal')->getId($paid);
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
    public function find($portalId = null)
    {
        return $this->_model->getCached('campaign')->find($portalId);
    }

    /**
     * cleans the model cache
     *
     * calls the {@link _cleanCache} function with defined tag name
     *
     * @return \Credit\Core\Service\Portale
     */
    public function cleanCache()
    {
        return $this->cleanTaggedCache('portal');
    }
}