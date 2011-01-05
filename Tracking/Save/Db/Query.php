<?php

/**
 * Unister Tracking
 *
 * Get the SQL-Query out.
 *
 * @package    Unister_Tracking_Tracking
 * @subpackage Save
 * @version    $Id: Query.php 4125 2010-11-23 16:11:05Z t.mueller $
 */

class Unister_Tracking_Tracking_Save_Db_Query extends Unister_Tracking_Tracking_Save_Db_Abstract
{

    /**
     * The constructor.
     *
     * @param Zend_Db_Adapter_Abstract $db DB adapter
     * @param string $table table name
     */
    public function __construct($table=null){
        parent::__construct($table);
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

        echo $this->_generateSqlQuery($data)."\n";
    }

}
