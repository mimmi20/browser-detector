<?php

/**
 * Unister Tracking Save
 * 
 * Interface for saving the data.
 * 
 * @package    Unister_Tracking_Tracking
 * @version    $Id: Interface.php 4111 2010-11-18 17:38:16Z t.mueller $
 */
interface Unister_Tracking_Tracking_Save_Interface
{
    
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
    public function save(array $data);  
}
