<?php
declare(ENCODING = 'iso-8859-1');
namespace Credit\Core\Model;

/**
 * Model
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Models
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: Campaigns.php 30 2011-01-06 21:58:02Z tmu $
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
    protected $_primary = 'id_campaign';

    /**
     * array of already used prepared statements
     *
     * @var array
     * @static
     */
    private static $_prepared = array();

    /**
     * cleans a given partner id
     *
     * @param string $caid        the campaign id
     * @param array  $requestData the given request data
     * @param string $agent       the user agent
     *
     * @return string|integer
     */
    public function cleanCaid($caid, $requestData = array(), $agent = '')
    {
        if (is_numeric($caid)) {
            /*
             * partner id is already numeric
             * ->no cleaning needed
             */

            if (0 >= (int) $caid) {
                return 0;
            }

            return (int) $caid;
        }

        if (!is_string($caid)) {
            /*
             * partner id in wrong format
             * ->set to default
             */
            return 0;
        }

        if (!is_array($requestData)) {
            $requestData = array();
        }

        if (!is_string($agent)) {
            /*
             * user agent in wrong format
             */
            $agent = '';
        }

        if (substr($caid, 0, 1) == '_') {
            $caid = substr($caid, 1);
        }

        /*
         * rewrite caid, because of wrong portal implementation in the past
         */
        if ($caid == 'preisvergleichde'
            && isset($requestData['portal'])
            && $requestData['portal'] == 'finanzen.shopping.de'
        ) {
            $caid = 'shoppingde';
        }
        if ($caid == 'geldde'
            && $agent == 'auto.de'
        ) {
            $caid = 'autode';
        }

        /*
         * rewrite caid to test campaign, if test flag is set
         */
        if (isset($requestData['unitest']) && substr($caid, -4) != 'test') {
            $caid .= 'test';
        }

        return $caid;
    }

    /**
     * cleans a given partner id and loads the partner and host information
     *
     * @param string|integer $paid        (input) the partner id to be loaded
     * @param array          $requestData the given request data
     * @param string         $agent       the user agent
     * @param integer        $paid        the partner id
     * @param integer        $caid        the campaign id
     * @param string         $hostname    the hostname from the campaign
     * @param boolean        $isTest      TRUE, if the Request is a test
     *
     * @return boolean
     */
    public function loadCaid(
        $value,
        $requestData = array(),
        $agent = '',
        $paid = null,
        $caid = null,
        $hostname = null,
        $isTest = false)
    {
        if (!is_array($requestData)) {
            $requestData = array();
        }

        if (!is_string($agent)) {
            $agent = '';
        }

        $caid = $this->cleanCaid($value, $requestData, $agent);

        if ($isTest) {
            $campaign = $this->getTestCampaign($caid);

            if (null !== $campaign) {
                $caid = (int) $campaign->id_campaign;
            }
        }

        if (!$this->checkCaid($caid, false)) {
            return false;
        }

        if (is_numeric($caid)) {
            $postfix = 'n';
            $type    = \PDO::PARAM_INT;
        } else {
            $postfix = 'x';
            $type    = \PDO::PARAM_STR;
        }

        if (!isset(self::$_prepared['loadcaid_' . $postfix])) {
            /**
             * @var Zend_Db_Table_Select
             */
            $select = $this->select()->setIntegrityCheck(false);

            $select->from(
                array('c' => $this->_name),
                array(
                    'name' => 'c.name',
                    'pid'  => 'c.p_id',
                    'uid'  => 'c.id_campaign'
                )
            );

            if (is_numeric($caid)) {
                $select->where('`c`.`id_campaign` = :caid');
            } else {
                $select->where('`c`.`p_name` = :caid');
            }

            $select->limit(1);

            self::$_prepared['loadcaid_' . $postfix] =
                new \Zend\Db\Statement\Pdo($this->_db, $select);
        }

        $stmt = self::$_prepared['loadcaid_' . $postfix];
        $stmt->bindParam(':caid', $caid, $type);

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

        if (isset($rows[0])) {
            //the campaign was found -> load the data
            $hostname = $rows[0]->name;
            $paid     = (int) $rows[0]->pid;
            $caid     = (int) $rows[0]->uid;

            return array(
                'caid' => $caid,
                'paid' => $paid,
                'hostname' => $hostname
            );
        } else {
            //the campaign was not found
            return false;
        }
    }

    /**
     * checks, if a campaign for the given id exists
     *
     * @param mixed $value der Wert, der geprüft werden soll
     *
     * @return boolean
     */
    public function checkCaid($value, $needClean = true)
    {
        if (!is_string($value) && !is_numeric($value)) {
            //partner id in wrong format
            return false;
        }

        if (is_numeric($value) && 0 >= (int) $value) {
            return false;
        }

        if ($needClean) {
            $caid = $this->cleanCaid($value, array(), '');

            if (is_int($caid) && 0 >= $caid) {
                return false;
            }
        } else {
            $caid = $value;
        }

        if (is_numeric($caid)) {
            $postfix = 'n';
            $type    = \PDO::PARAM_INT;
        } else {
            $postfix = 'x';
            $type    = \PDO::PARAM_STR;
        }

        if (!isset(self::$_prepared['checkcaid_' . $postfix])) {
            /**
             * @var Zend_Db_Table_Select
             */
            $select = $this->select();
            $select->from(
                array('c' => $this->_name),
                array('count' => new \Zend\Db\Expr('COUNT(*)'))
            );
            if (is_numeric($caid)) {
                $select->where('`c`.`id_campaign` = :caid');
            } else {
                $select->where('`c`.`p_name` = :caid');
            }

            $select->limit(1);

            self::$_prepared['checkcaid_' . $postfix] =
                new \Zend\Db\Statement\Pdo($this->_db, $select);
        }

        $stmt = self::$_prepared['checkcaid_' . $postfix];
        $stmt->bindParam(':caid', $caid, $type);

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

        if (isset($rows[0]) && $rows[0]->count) {
            //Campaign exists
            return true;
        }

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
        if (empty($value)) {
            //partner id in wrong format
            return false;
        }

        if (!is_string($value) && !is_numeric($value)) {
            //partner id in wrong format
            return false;
        }

        if (is_numeric($value) && 0 >= (int) $value) {
            return false;
        }

        $value = $this->cleanCaid($value);

        if (is_numeric($value)) {
            $postfix = 'n';
            $type    = \PDO::PARAM_INT;
        } else {
            $postfix = 'x';
            $value   = ucfirst(strtolower($value));
            $type    = \PDO::PARAM_STR;
        }

        if (!isset(self::$_prepared['getid_' . $postfix])) {
            /**
             * @var Zend_Db_Table_Select
             */
            $select = $this->select();
            $select->from(
                array('c' => $this->_name),
                array('id' => 'id_campaign')
            );

            if (is_numeric($value)) {
                $select->where('`c`.`id_campaign` = :caid');
            } else {
                $select->where('`c`.`p_name` = :caid');
            }

            $select->limit(1);

            self::$_prepared['getid_' . $postfix] =
                new \Zend\Db\Statement\Pdo($this->_db, $select);
        }

        $stmt = self::$_prepared['getid_' . $postfix];
        $stmt->bindParam(':caid', $value, $type);

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
     * @param mixed $value id or name of the campaign
     *
     * @return string ein leerer String, wenn die Kampagne nicht existiert,
     *                ansonsten der Name der Kampagne
     * @access protected
     */
    public function getPortalName($value)
    {
        return $this->_getName($value, false);
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
    public function getCampaignName($value)
    {
        return $this->_getName($value, true);
    }

    /**
     * this function is a alias for {@link getCampaignName}
     *
     * @param mixed $value id or name of the campaign
     *
     * @return string ein leerer String, wenn die Kampagne nicht existiert,
     *                ansonsten der Name der Kampagne
     * @access protected
     */
    public function getName($value)
    {
        return $this->_getName($value, true);
    }

    /**
     * returns the id for a campaign
     *
     * @param mixed   $value id or name of the campaign
     * @param boolean $p     a flag to tell if the name of the campaign or
     *                       the name of the portal should be returned
     *
     * @return string an empty string, if the campaign don't exist,
     *                the name of the campaign/portal otherwise
     * @access protected
     */
    private function _getName($value, $p = true)
    {
        if (!is_string($value) && !is_numeric($value)) {
            //partner id in wrong format
            return '';
        }

        if (is_numeric($value) && 0 >= (int) $value) {
            return '';
        }

        $value = $this->cleanCaid($value);

        if (is_numeric($value)) {
            $postfix = 'n';
            $type    = \PDO::PARAM_INT;
        } else {
            $value = ucfirst(strtolower($value));
            $type  = \PDO::PARAM_STR;

            if ($p) {
                $postfix = 'p';
            } else {
                $postfix = 'x';
            }
        }

        if (!isset(self::$_prepared['getname_' . $postfix])) {
            /**
             * @var Zend_Db_Table_Select
             */
            $select = $this->select();
            $select->from(
                array('c' => $this->_name),
                array('name' => 'p_name')
            );

            if (is_numeric($value)) {
                $select->where('`c`.`id_campaign` = :name');
            } else {
                if ($p) {
                    $select->where('`c`.`p_name` = :name');
                } else {
                    $select->where('`c`.`name` = :name');
                }
            }

            $select->limit(1);

            self::$_prepared['getname_' . $postfix] =
                new \Zend\Db\Statement\Pdo($this->_db, $select);
        }

        $stmt = self::$_prepared['getname_' . $postfix];
        $stmt->bindParam(':name', $value, $type);

        try {
            $stmt->execute();

            /**
             * @var stdClass
             */
            $rows = $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\Zend\Db\Statement\Exception $e) {
            $this->_logger->err($e);

            return '';
        }

        if (!isset($rows[0]) || !isset($rows[0]->name)) {
            return '';
        } else {
            return $rows[0]->name;
        }
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
        if (!is_string($value) && !is_numeric($value)) {
            //partner id in wrong format
            return 'oneStep';
        }

        if (is_numeric($value) && 0 >= (int) $value) {
            return 'oneStep';
        }

        $value = $this->cleanCaid($value);

        if (is_numeric($value)) {
            $postfix = 'n';
            $type    = \PDO::PARAM_INT;
        } else {
            $postfix = 'x';
            $value   = ucfirst(strtolower($value));
            $type    = \PDO::PARAM_STR;
        }

        if (!isset(self::$_prepared['getline_' . $postfix])) {
            /**
             * @var Zend_Db_Table_Select
             */
            $select = $this->select();
            $select->from(
                array('c' => $this->_name),
                array('creditLine')
            );

            if (is_numeric($value)) {
                $select->where('`c`.`id_campaign` = :caid');
            } else {
                $select->where('`c`.`p_name` = :caid');
            }

            $select->limit(1);

            self::$_prepared['getline_' . $postfix] =
                new \Zend\Db\Statement\Pdo($this->_db, $select);
        }

        $stmt = self::$_prepared['getline_' . $postfix];
        $stmt->bindParam(':caid', $value, $type);

        try {
            $stmt->execute();

            /**
             * @var stdClass
             */
            $rows = $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\Zend\Db\Statement\Exception $e) {
            $this->_logger->err($e);

            return 'oneStep'; //default
        }

        if (!isset($rows[0]) || !isset($rows[0]->creditLine)) {
            return 'oneStep'; //default
        } else {
            return $rows[0]->creditLine;
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
                    $parentList->where('p_name = :portal');
                } elseif (is_numeric($portalId)) {
                    $parentList->where('p_id = :portal');
                }
            }

            $parentList->order('p_id', 'p_name');

            if (!$withTests) {
                $parentList->where('p_name not like \'%test\'');
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

        $newCampaignId = $this->getId($portal->p_name);
        $campaign      = $this->find($newCampaignId)->current();

        if (is_object($campaign)) {
            return $campaign;
        } else {
            return null;
        }
    }

    /**
     * returns an \Credit\Core\Service\Portal object for an campaign id
     *
     * @param integer $campaignId
     *
     * @return \Zend\Db\Table\Row
     * @access public
     */
    public function getPortal($campaignId)
    {
        $dbPortale = new \Credit\Core\Service\Portale();

        return $dbPortale->loadByCampaign($campaignId);
    }

    /**
     * returns the default campaign from the portal of a given campaign
     *
     * @param integer $campaignId
     *
     * @return \Zend\Db\Table\Row
     * @access public
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
        if (substr($campaign->p_name, -4) == 'test') {
            return $campaign;
        }

        $defaultCampaign = $this->getDefaultCampaign($campaignId);

        if (null === $defaultCampaign
            || null === $defaultCampaign->id_campaign
        ) {
            return null;
        }

        if (substr($defaultCampaign->p_name, -4) == 'test') {
            return $defaultCampaign;
        }

        $newCampaignId = $this->getId($defaultCampaign->p_name . 'test');

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
     * @return \Zend\Db\Table\Rowset_Abstract Row(s) matching the criteria.
     * @throws Zend_Db_Table_Exception
     */
    public function find($campaignId = null)
    {
        if (!is_numeric($campaignId)) {
            //partner id in wrong format
            $campaignId = 0;
        } elseif (0 >= (int) $campaignId) {
            $campaignId = 0;
        }

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

            $select->where('`c`.`id_campaign` = :caid');

            self::$_prepared['find'] =
                new \Zend\Db\Statement\Pdo($this->_db, $select);
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