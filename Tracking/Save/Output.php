<?php

/**
 * Unister Tracking
 * 
 * Print the data with print_r()
 * 
 * @package    Unister_Tracking_Tracking
 * @subpackage Save
 * @version    $Id: Output.php 4125 2010-11-23 16:11:05Z t.mueller $
 */

class Unister_Tracking_Tracking_Save_Output implements Unister_Tracking_Tracking_Save_Interface
{    
    /**
     * The constructor.
     */    
    public function __construct(){
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
        print_r($data);
        return true;
    }

}
