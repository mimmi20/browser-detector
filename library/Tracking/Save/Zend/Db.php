<?php

/**
 * Unister Tracking
 *
 * Save the data in the Database with a Zend_Db_Adapter
 *
 * @package    Unister_Tracking_Tracking
 * @subpackage Save
 * @version    $Id$
 */

/*

CREATE TABLE `system_tracking` (
  `keywords` varchar(255) collate utf8_bin NOT NULL,
  `sum` float NOT NULL,
  `min` float NOT NULL,
  `max` float NOT NULL,
  `count` int(11) unsigned NOT NULL,
  `is_avg` tinyint(4) unsigned NOT NULL,
  PRIMARY KEY  (`keywords`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8 COLLATE=utf8_bin

CREATE TABLE `system_tracking_config` (
  `update_interval` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin

INSERT INTO `system_tracking_config` (
`update_interval`
) VALUES ('60');

*/

class Unister_Tracking_Tracking_Save_Zend_Db extends Unister_Tracking_Tracking_Save_Db_Abstract
{
    /**
     * The database connection.
     *
     * @var Zend_Db_Adapter_Abstract
     */
    protected $_db = null;

    /**
     * The constructor.
     *
     * @param Zend_Db_Adapter_Abstract $db DB adapter
     * @param string $table table name
     */
    public function __construct($db,$table=null){
        parent::__construct($table);

        if(!($db instanceof Zend_Db_Adapter_Abstract)){
            throw new Unister_Tracking_Tracking_Exception('$db is not a Zend_Db_Adapter_Abstract');
        }

        $this->_db = $db;
    }

    /**
     * Save the collected data.
     *
     * $data = Array
     * array(
     *         array(
     *            'keywords' => array,
     *            'value' => float,
     *            'is_avg' => boolean
     *        )
     * ...
     *
     * @param array $data The collected data.
     * @return boolean Saving successful
     */
    public function save(array $data)
    {
        $data = $this->_prepareData($data);

        if (!is_array($data) || count($data) < 1) {
            return false;
        }

        return (boolean) $this->_db->query(
            $this->_generateSqlQuery($data)
        );
    }

}
