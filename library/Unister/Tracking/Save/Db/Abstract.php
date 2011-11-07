<?php

/**
 * Unister Tracking
 *
 * Abtsract for db save adapter.
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

abstract class Unister_Tracking_Tracking_Save_Db_Abstract
    implements Unister_Tracking_Tracking_Save_Interface
{
    /**
     * Name of the tracking table.
     *
     * @var string
     */
    protected $_table = 'system_tracking';

    /**
     * The constructor.
     *
     * @param string $table table name
     */
    public function __construct($table = null)
    {
        if ($table !== null) {
            $this->_table = $table;
        }
    }

    /**
     * Prepare the collected data for the database.
     *
     * @param array The data
     * @return array
     */
    protected function _prepareData(array $data)
    {
        $res = array();

        foreach ($data as $item) {
            $item['keywords'] = implode('/', $item['keywords']);
            $item['max']      = $item['value'];
            $item['min']      = $item['value'];
            $item['sum']      = $item['value'];
            $item['count']    = 1;

            unset($item['value']);

            $res[] = $item;
        }

        return $res;
    }

    /**
     * Create the SQL Query.
     *
     * @param array $list The list of tracking data.
     * @return string
     */
    protected function _generateSqlQuery(array $list)
    {
        if (!is_array($list) || count($list) < 1) {
            return null;
        }

        $tablename = $this->_table;

        reset($list);

        // collect keys
        $keys    = array();
        $rowKeys = array_keys($list[0]);
        foreach ($rowKeys as $key) {
            $keys[] = '`' . addslashes($key) . '`';
        }

        reset($list);

        // collect values
        $valuesList = array();
        foreach ($list as $row) {
            if (is_array($row) && count($row) > 0) {
                $values = array();

                foreach ($row as $value) {
                    if (is_float($value)) {
                        $value = str_replace(',','.',$value);
                    }

                    if (is_bool($value)) {
                        $value = $value ? 1 : 0;
                    }

                    $value  = addslashes($value);
                    $values[] = "'".$value."'";
                }

                $valuesList[] = '(' . implode(',', $values) . ')';
            }
        }
        unset($values);

        // bulid query
        $query = 'INSERT INTO `' . $tablename . '` (' . implode(',', $keys)
               . ') VALUES '. implode(',', $valuesList) . '
            ON DUPLICATE KEY UPDATE
                `min`=IF((`min`>VALUES(`min`)),VALUES(`min`),`min`),
                `max`=IF((`max`<VALUES(`max`)),VALUES(`max`),`max`),
                `sum`=`sum`+VALUES(`sum`),
                `count`=`count`+1
            ;';
        unset($valuesList);

        return $query;
    }
}
