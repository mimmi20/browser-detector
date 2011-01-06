<?php

/**
 * Unister Tracking Save
 * 
 * Interface for saving the data.
 * 
 * @package    Unister_Tracking_Tracking
 * @version    $Id$
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
