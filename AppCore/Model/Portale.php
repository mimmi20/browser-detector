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
class Portale extends ModelAbstract
{
    /**
     * Table name
     *
     * @var String
     */
    protected $_name = 'portale';

    /**
     * Primary key
     *
     * @var String
     */
    protected $_primary = 'p_id';

    /**
     * array of already used prepared statements
     *
     * @var array
     * @static
     */
    private static $_prepared = array();

    /**
     * Get complete List of Partner that are not childs
     *
     * @return \Zend\Db\Table\Rowset
     */
    public function fetchList()
    {
        if (!isset(self::$_prepared['fetchlist'])) {
            /**
             * @var Zend_Db_Table_Select
             */
            $select = $this->select()->order('p_name');

            self::$_prepared['fetchlist'] =
                new \Zend\Db\Statement\Pdo($this->_db, $select);
        }

        $stmt = self::$_prepared['fetchlist'];

        try {
            $stmt->execute();

            /**
             * @var stdClass
             */
            $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Zend\Db\Statement\Exception $e) {
            $this->_logger->err($e);

            $rows = array();
        }

        $options = array(
            'data'  => $rows
        );

        $rowSet = new \Zend\Db\Table\Rowset($options);
        $rowSet->setTable($this);

        while ($rowSet->valid()) {
            $rowSet->current();
            $rowSet->next();
        }

        return $rowSet->rewind();
    }

    /**
     * cleans a given partner id
     *
     * @param string $paid        the partner id
     * @param array  $requestData the given request data
     * @param string $agent       the user agent
     *
     * @return string|integer
     */
    public function cleanPaid($paid, $requestData = array(), $agent = '')
    {
        if (is_numeric($paid)) {
            //partner id is already numeric
            //->no cleaning needed

            if (0 >= (int) $paid) {
                return 0;
            }

            return (int) $paid;
        }

        if (!is_string($paid) || '' == $paid) {
            //partner id in wrong format
            //->set to default
            return 0;
        }

        if (!is_string($agent)) {
            //user agent in wrong format
            $agent = '';
        }

        if (substr($paid, 0, 1) == '_') {
            $paid = substr($paid, 1);
        }

        if ($paid == 'preisvergleichde'
            && isset($requestData['portal'])
            && $requestData['portal'] == 'finanzen.shopping.de'
        ) {
            $paid = 'shoppingde';
        }

        if ($paid == 'geldde'
            && $agent == 'auto.de'
        ) {
            $paid = 'autode';
        }

        return $paid;
    }

    /**
     * checks the portal id
     *
     * @param string|integer $value the portal id that needs to be checked
     *
     * @return boolean
     */
    public function checkPaid($value)
    {
        if (!is_string($value) && !is_numeric($value)) {
            //partner id in wrong format
            return false;
        }

        $value = $this->cleanPaid($value);

        if (is_int($value) && 0 >= $value) {
            return false;
        }

        if (is_numeric($value)) {
            $postfix = 'n';
            $type    = \PDO::PARAM_INT;
        } else {
            $postfix = 'x';
            $type    = \PDO::PARAM_STR;
        }

        if (!isset(self::$_prepared['checkpaid_' . $postfix])) {
            /**
             * @var Zend_Db_Table_Select
             */
            $select = $this->select();
            $select->from(
                array('po' => $this->_name),
                array('count' => new \Zend\Db\Expr('COUNT(*)'))
            );

            if (is_numeric($value)) {
                $select->where('po.p_id = :paid');
            } else {
                $select->where('po.p_name = :paid');
            }

            $select->limit(1);

            self::$_prepared['checkpaid_' . $postfix] =
                new \Zend\Db\Statement\Pdo($this->_db, $select);
        }

        $stmt = self::$_prepared['checkpaid_' . $postfix];
        $stmt->bindParam(':paid', $value, $type);

        try {
            $stmt->execute();

            /**
             * @var stdClass
             */
            $rows = $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\Zend\Db\Statement\Exception $e) {
            $this->_logger->err($e);

            return false;
        }

        if (isset($rows[0]) && is_object($rows[0]) && $rows[0]->count) {
            return true;
        }

        return false;
    }

    /**
     * Get Child List of a Parent Element
     *
     * TODO: add new column to table 'isTest'
     *
     * @param \Zend\Db\Table\Row_Abstract $parent    the portal to search the
     *                                              campaigns
     * @param boolean                    $withTests if TRUE, the testing
     *                                              campaigns are included into
     *                                              the result
     *
     * @return \Zend\Db\Table\Rowset
     */
    public function getChildList($parent, $withTests = true)
    {
        if (is_object($parent) && isset($parent->p_id)) {
            $portalId = (int) $parent->p_id;
        } else {
            $portalId = null;
        }

        $dbCampaigns = new \AppCore\Service\Campaigns();

        return $dbCampaigns->getCampaignsFromPortal($portalId, $withTests);
    }

    /**
     * Get Child List of a Parent Element
     *
     * @param string  $campaigns a comma separated list of campaign ids
     * @param boolean $withTests if TRUE, the testing campaigns are included
     *                           into the result
     *
     * @return \Zend\Db\Table\Rowset
     */
    public function getChildListPartly($campaigns = '', $withTests = true)
    {
        $dbCampaigns = new \AppCore\Service\Campaigns();

        return $dbCampaigns->getCampaignsFromPortal($campaigns, $withTests);
    }

    /**
     * Get Child List of a Parent Element
     *
     * @param boolean $withTests if TRUE, the testing campaigns are included
     *                           into the result
     *
     * @return \Zend\Db\Table\Rowset
     */
    public function getChildListComplete($withTests = true)
    {
        $dbCampaigns = new \AppCore\Service\Campaigns();

        return $dbCampaigns->getCampaignsFromPortal(null, $withTests);
    }

    /**
     * Get Child List of a Parent Element
     *
     * @param string $campaign a campaign name
     *
     * @return \Zend\Db\Table\Row|null
     */
    public function loadByCampaign($campaign = '')
    {
        $dbCampaigns = new \AppCore\Service\Campaigns();
        $campaignId  = $dbCampaigns->getId($campaign);

        if (!$campaignId) {
            return null;
        }

        $campaign = $dbCampaigns->find($campaignId)->current();
        if (!is_object($campaign) || null === $campaign->p_id) {
            return null;
        }

        $portalId = $campaign->p_id;

        /**
         * @var \Zend\Db\Table\Row
         */
        $portal = $this->find($portalId)->current();

        if (is_object($portal)) {
            return $portal;
        } else {
            return null;
        }
    }

    /**
     * returns the name of a partner
     *
     * @param integer|string the id/name of the partner
     *
     * @return string|null
     */
    public function getName($paid)
    {
        $oPartner = $this->_load($paid);

        if (null === $oPartner) {
            return null;
        }

        return $oPartner->p_name;
    }

    /**
     * returns the name of a partner
     *
     * @param integer|string the id/name of the partner
     *
     * @return string|null
     */
    public function getAdresse($paid)
    {
        $oPartner = $this->_load($paid);

        if (null === $oPartner) {
            return null;
        }

        return $oPartner->adresse;
    }

    /**
     * returns the name of a partner
     *
     * @param integer|string the id/name of the partner
     *
     * @return \Zend\Db\Table\Row|null
     */
    private function _load($paid)
    {
        if (!$this->checkPaid($paid)) {
            return null;
        }

        $paid = $this->getId($paid);

        if (false === $paid) {
            return null;
        }

        $portal = $this->find($paid)->current();

        if (is_object($portal)) {
            return $portal;
        } else {
            return null;
        }
    }

    /**
     * returns the id for a campaign
     *
     * @param integer|string $paid id or name of the campaign
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

        $paid = $this->cleanPaid($paid);

        if (is_numeric($paid)) {
            $postfix = 'n';
            $paid    = (int) $paid;
            $type    = \PDO::PARAM_INT;
        } else {
            $postfix = 'x';
            $paid    = strtolower($paid);
            $type    = \PDO::PARAM_STR;
        }

        if (!isset(self::$_prepared['getid_' . $postfix])) {
            /**
             * @var Zend_Db_Table_Select
             */
            $select = $this->select();
            $select->from(
                array('p' => $this->_name),
                array('id' => 'p_id')
            );

            if (is_numeric($paid)) {
                $select->where('p.p_id = :paid');
            } else {
                $select->where('p.p_name = :paid');

            }

            $select->limit(1);

            self::$_prepared['getid_' . $postfix] =
                new \Zend\Db\Statement\Pdo($this->_db, $select);
        }

        $stmt = self::$_prepared['getid_' . $postfix];
        $stmt->bindParam(':paid', $paid, $type);
        $stmt->setFetchMode(\Zend\Db\Db::FETCH_OBJ);

        try {
            $stmt->execute();

            /**
             * @var stdClass
             */
            $rows = $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\Zend\Db\Statement\Exception $e) {
            $this->_logger->err($e);

            return false;
        }

        if (!isset($rows[0]) || !isset($rows[0]->id)) {
            return false;
        } else {
            return (int) $rows[0]->id;
        }
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
        if (!is_numeric($portalId)) {
            //partner id in wrong format
            $portalId = 0;
        } elseif (0 >= (int) $portalId) {
            $portalId = 0;
        }

        $portalId = $this->cleanPaid($portalId);

        if (!is_numeric($portalId)) {
            $portalId = 0;
        }

        if (!isset(self::$_prepared['find'])) {
            /**
             * @var Zend_Db_Table_Select
             */
            $select = $this->select();
            $select->from(
                array('p' => $this->_name)
            );

            $select->where('p.p_id = :paid');

            self::$_prepared['find'] =
                new \Zend\Db\Statement\Pdo($this->_db, $select);
        }

        $stmt = self::$_prepared['find'];
        $stmt->bindParam(':paid', $portalId, \PDO::PARAM_INT);

        try {
            $stmt->execute();

            /**
             * @var stdClass
             */
            $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Zend\Db\Statement\Exception $e) {
            $this->_logger->err($e);

            $rows = array();
        }

        $options = array(
            'data'  => $rows
        );

        $rowSet = new \Zend\Db\Table\Rowset($options);
        $rowSet->setTable($this);

        while ($rowSet->valid()) {
            $rowSet->current();
            $rowSet->next();
        }

        return $rowSet->rewind();
    }
}