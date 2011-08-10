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
class Campaigns extends ModelAbstract
{
    /**
     * Table name
     *
     * @var String
     */
    protected $_name = 'campaigns';

    /**
     * Primary key
     *
     * @var String
     */
    protected $_primary = 'idCampaigns';

    /**
     * array of already used prepared statements
     *
     * @var array
     * @static
     */
    private static $_prepared = array();

    /**
     * returns the id of an institute
     *
     * @return Zend_Db_Table_Select
     * @access public
     */
    public function getList()
    {
        if (!isset(self::$_prepared['getlist'])) {
            $select = $this->select()->setIntegrityCheck(false);

            $select->from(
                array('ca' => $this->_name)
            );
            
            $select->order(array('active', 'ordering', 'name'));

            self::$_prepared['getlist'] =
                new \Zend\Db\Statement\Pdo($this->_db, $select);
        }

        $stmt = self::$_prepared['getlist'];

        try {
            $stmt->execute();

            /**
             * @var array
             */
            $campaignsList = $stmt->fetchAll(\PDO::FETCH_CLASS);
        } catch (\Zend\Db\Statement\Exception $e) {
            $this->_logger->err($e);

            $campaignsList = array();
        }

        return $campaignsList;
    }

    /**
     * cleans a given campaign id
     *
     * @param string $caid        the campaign id
     * @param array  $requestData the given request data
     * @param string $agent       the user agent
     *
     * @return integer|null
     */
    public function cleanCaid($caid)
    {
        if (!$this->_check($caid)) {
            //campaign id in wrong format
            return null;
        }

        return (int) $caid;
    }

    /**
     * cleans a given campaign id and loads the partner and host information
     *
     * @param string|integer $paid        (input) the campaign id to be loaded
     * @param array          $requestData the given request data
     * @param string         $agent       the user agent
     * @param integer        &$paid       the partner id
     * @param integer        &$caid       the campaign id
     * @param string         &$hostname   the hostname from the campaign
     * @param boolean        $isTest      TRUE, if the Request is a test
     *
     * @return boolean
     */
    public function loadCaid(
        $value,
        &$paid = null,
        &$caid = null,
        &$hostname = null)
    {
        $result = $this->_loadCaid($value);

        if (is_array($result)) {
            $paid     = $result['paid'];
            $caid     = $result['caid'];
            $hostname = $result['hostname'];

            return true;
        }

        return false;
    }

    /**
     * cleans a given campaign id and loads the partner and host information
     *
     * @param string|integer $paid        (input) the campaign id to be loaded
     * @param array          $requestData the given request data
     * @param string         $agent       the user agent
     * @param integer        &$paid       the partner id
     * @param integer        &$caid       the campaign id
     * @param string         &$hostname   the hostname from the campaign
     * @param boolean        $isTest      TRUE, if the Request is a test
     *
     * @return boolean|array
     */
    public function loadCaidArray($value)
    {
        return $this->_loadCaid($value);
    }

    /**
     * checks, if a campaign for the given id exists
     *
     * @param mixed $value der Wert, der geprüft werden soll
     *
     * @return boolean
     */
    public function checkCaid($value)
    {
        if (!($caid = $this->cleanCaid($value))) {
            //campaign id in wrong format
            return false;
        }

        if (false === $this->getId($caid)) {
            return false;
        }

        return true;
    }

    /**
     * cleans a given campaign id and loads the partner and host information
     *
     * @param integer $caid the campaign id to be loaded
     *
     * @return boolean|array
     */
    private function _loadCaid($caid)
    {
        $row = $this->_load($caid);

        if (is_object($row) && $row instanceof \Zend\Db\Table\Row) {
            //the campaign was found -> load the data
            return array(
                'caid'     => (int) $row->idCampaigns,
                'paid'     => (int) $row->idPartnerSites,
                'hostname' => $row->name
            );
        }

        //the campaign was not found
        return false;
    }

    /**
     * loads a campaign rowset
     *
     * @param integer $campaignId
     *
     * @return \Zend\Db\Table\Row|null
     */
    private function _load($campaignId)
    {
        $row = $this->find($this->cleanCaid($campaignId))->current();

        if (is_object($row) && $row instanceof \Zend\Db\Table\Row) {
            return $row;
        } else {
            return null;
        }
    }

    /**
     * checks, if a campaign id is a positive number or a string
     *
     * @param mixed $caid the value to check
     *
     * @return boolean
     */
    private function _check($caid)
    {
        if (!is_numeric($caid)) {
            //campaign id in wrong format
            return false;
        }

        if (0 >= (int) $caid) {
            //negative numbers are not allowed
            return false;
        }

        if (!$caid) {
            /*
             * campaign id in wrong format
             */
            return false;
        }

        return true;
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
        $row = $this->_load($caid);

        if (is_object($row) && $row instanceof \Zend\Db\Table\Row) {
            //the campaign was found -> load the data
            return (boolean) $row->active;
        }

        //the campaign was not found
        return false;
    }

    /**
     * returns the id for a campaign
     *
     * @param integer|string $value id or name of the campaign
     *
     * @return boolean|integer FALSE, if the Campagne don't exist,
     *                         the  ID of the Campagne otherwise
     */
    public function getId($value = null)
    {
        $value = $this->cleanCaid($value);

        if (!isset(self::$_prepared['getid'])) {
            /**
             * @var Zend_Db_Table_Select
             */
            $select = $this->select();
            $select->from(
                array('c' => $this->_name),
                array('id' => 'idCampaigns')
            );

            $select->where('`c`.`idCampaigns` = :caid');
            $select->limit(1);

            self::$_prepared['getid'] =
                new \Zend\Db\Statement\Pdo($this->_db, $select->assemble());
        }

        $stmt = self::$_prepared['getid'];
        $stmt->bindParam(':caid', $value, \PDO::PARAM_INT);

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
     * returns the id for a campaign
     *
     * @param integer|string $value id or name of the campaign
     *
     * @return boolean|integer FALSE, if the Campagne don't exist,
     *                         the  ID of the Campagne otherwise
     */
    public function getIdFromName($value = null)
    {
        if (!isset(self::$_prepared['getidfromname'])) {
            /**
             * @var Zend_Db_Table_Select
             */
            $select = $this->select();
            $select->from(
                array('c' => $this->_name),
                array('id' => 'idCampaigns')
            );

            $select->where('`c`.`name` = :caid');
            $select->limit(1);

            self::$_prepared['getidfromname'] =
                new \Zend\Db\Statement\Pdo($this->_db, $select->assemble());
        }

        $stmt = self::$_prepared['getidfromname'];
        $stmt->bindParam(':caid', $value, \PDO::PARAM_STR);

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
     * returns the id for a campaign
     *
     * @param mixed $campaignId id or name of the campaign
     *
     * @return string ein leerer String, wenn die Kampagne nicht existiert,
     *                ansonsten der Name der Kampagne
     * @access protected
     */
    public function getPortalName($campaignId)
    {
        $portal = $this->getPortal($campaignId);
        
        return $prtal->getName();
    }

    /**
     * returns the name for a campaign
     *
     * @param integer $caid id or name of the campaign
     *
     * @return string an empty String, if the campaign does not exist,
     *                the campaign name otherwise
     */
    public function getCampaignName($caid)
    {
        $row = $this->_load($caid);

        if (is_object($row) && $row instanceof \Zend\Db\Table\Row) {
            //the campaign was found -> load the data
            return $row->name;
        }
        
        return null;
    }

    /**
     * returns the id for a campaign
     *
     * @param integer $caid id or name of the campaign
     *
     * @return string ein leerer String, wenn die Kampagne nicht existiert,
     *                ansonsten der Name der Kampagne
     * @access protected
     */
    public function getLine($caid)
    {
        $row = $this->_load($caid);

        if (!is_object($row) || !isset($row->creditLine)) {
            return 'oneStep'; //default
        } else {
            return $row->creditLine;
        }
    }

    /**
     * returns the color for a campaign
     *
     * @param integer $caid id or name of the campaign
     *
     * @return string the string 'ddd', if the campaign does not exist,
     *                the name of the campaign color otherwise
     */
    public function getColor($caid)
    {
        $row = $this->_load($caid);

        if (!is_object($row) || !isset($row->color)) {
            return 'ddd'; //default
        } else {
            return $row->color;
        }
    }

    /**
     * Get Child List of a Parent Element
     *
     * TODO: add new column to table 'isTest'
     *
     * @param array|integer $portalId  the portal ID to search the campaigns
     * @param boolean       $withTests If TRUE, also the test campaigns are
     *                                 included in the result
     *
     * @return \Zend\Db\Table\Rowset|null
     * @access public
     */
    public function getCampaignsFromPortal($portalId, $withTests = true)
    {
        $type    = \PDO::PARAM_STR;
        $postfix = 'x';

        if (null !== $portalId) {
            if (is_array($portalId)) {
                $postfix  = 'a';
                $portalId = implode(',', $portalId);
            } elseif (is_string($portalId)
                && strpos($portalId, ',') !== false
            ) {
                $postfix = 's';
            } elseif (is_string($portalId)) {
                $postfix = 'e';
            } elseif (is_numeric($portalId)) {
                $postfix  = 'n';
                $type     = \PDO::PARAM_INT;
                $portalId = (int) $portalId;
            }
        }

        if (!$withTests) {
            $postfix .= 'o';
        }

        if (!isset(self::$_prepared['getfromportal_' . $postfix])) {
            /**
             * @var Zend_Db_Table_Select
             */
            $parentList = $this->select();

            if (null !== $portalId) {
                if (is_array($portalId)) {
                    $parentList->where('p_id IN (:portal)');
                } elseif (is_string($portalId)
                    && strpos($portalId, ',') !== false
                ) {
                    $parentList->where('p_id IN (:portal)');
                } elseif (is_string($portalId)) {
                    $parentList->where('name = :portal');
                } elseif (is_numeric($portalId)) {
                    $parentList->where('p_id = :portal');
                }
            }

            $parentList->order('p_id', 'name');

            if (!$withTests) {
                $parentList->where('name not like \'%test\'');
            }

            self::$_prepared['getfromportal_' . $postfix] =
                new \Zend\Db\Statement\Pdo($this->_db, $parentList->assemble());
        }

        $stmt = self::$_prepared['getfromportal_' . $postfix];

        if ($postfix != 'x' && $postfix != 'xo') {
            $stmt->bindParam(':portal', $portalId, $type);
        }

        try {
            $stmt->execute();

            /**
             * @var array
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
     * returns an \AppCore\Service\Portal object for an campaign id
     *
     * @param integer $campaignId
     *
     * @return \Zend\Db\Table\Row
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
     * @return \Zend\Db\Table\Row
     */
    public function getTestCampaign($campaignId)
    {
        //Campaign-ID ist ungueltig
        if (!is_numeric($campaignId) || 0 == $campaignId) {
            return null;
        }

        $campaign = $this->find($campaignId)->current();

        if (!is_object($campaign)) {
            //aktuelle Kampagne existiert nicht
            return null;
        }

        //aktuelle Kampagne ist eine Test-Kampagne
        if (substr($campaign->name, -4) == 'test') {
            return $campaign;
        }

        $defaultCampaign = $this->getDefaultCampaign($campaignId);

        if (null === $defaultCampaign
            || null === $defaultCampaign->idCampaigns
        ) {
            return null;
        }

        if (substr($defaultCampaign->name, -4) == 'test') {
            return $defaultCampaign;
        }

        $newCampaignId = $this->getId($defaultCampaign->name . 'test');

        if (false === $newCampaignId) {//keine Test-Kampagne vorhanden
            return null;
        } else {
            $row = $this->find($newCampaignId)->current();

            if (is_object($row)) {
                return $row;
            } else {
                return null;
            }
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
     * @return \Zend\Db\Table\Rowset\Abstract Row(s) matching the criteria.
     * @throws \Zend\Db\Table\Exception
     */
    public function find($campaignId = null)
    {
        $campaignId = (int) $this->getId($campaignId);

        $campaignId = $this->cleanCaid($campaignId);

        if (!is_numeric($campaignId)) {
            $campaignId = 0;
        }

        if (!isset(self::$_prepared['find'])) {
            /**
             * @var Zend_Db_Table_Select
             */
            $select = $this->select();
            $select->from(
                array('c' => $this->_name)
            );

            $select->where('`c`.`idCampaigns` = :caid');

            self::$_prepared['find'] =
                new \Zend\Db\Statement\Pdo($this->_db, $select->assemble());
        }

        $stmt = self::$_prepared['find'];
        $stmt->bindParam(':caid', $campaignId, \PDO::PARAM_INT);

        try {
            $stmt->execute();

            /**
             * @var array
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