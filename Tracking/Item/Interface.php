<?php

/**
 * Unister Tracking Items
 * 
 * Interface for tracking items
 * 
 * @package    Unister_Tracking_Tracking
 * @version    $Id: Interface.php 4125 2010-11-23 16:11:05Z t.mueller $
 */
interface Unister_Tracking_Tracking_Item_Interface
{
    
    /**
     * Get the collected data as array.
     * 
     * Return Array
     * array(
     *         array(
     *            'keywords' => array,
     *            'value' => float,
     *            'is_avg' => boolean
     *        )
     * ...
     * 
     * @return array 
     */    
    public function getData();  
}
