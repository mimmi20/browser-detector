<?php

/**
 * Unister Tracking Item Track
 * 
 * Track one value with keywords.
 * 
 * All keywords combined limited by 255 chars (+1 per keyword for seperator).
 * 
 * @package    Unister_Tracking_Tracking
 * @subpackage Item
 * @version    $Id$
 */
class Unister_Tracking_Tracking_Item_Track implements Unister_Tracking_Tracking_Item_Interface
{
    /**
     * The keywords.
     *
     * @var array
     */    
    protected $_keywords = array();
    
    /**
     * The value.
     *
     * @var float
     */    
    protected $_value = null;
    
    /**
     * Value is a average value.
     *
     * @var boolean
     */    
    protected $_avg = false;

    /**
     * The constructor.
     *
     * @param array|string $keywords The keywords for the value.
     * @param float $value The value.
     * @param boolean $avg Set if the value is a average value.
     */    
    public function __construct($keywords=array(),$value=null,$avg=false)
    {
        $this->_setKeywords($keywords);
        $this->_value = (float) $value;
        $this->_avg = (boolean) $avg;
    }
    
    /**
     * Set the keywords.
     *
     * @param array|string $keywords The keywords for the value.
     */
    protected function _setKeywords($keywords)
    {
        if(!is_array($keywords)) $keywords = array($keywords);
        $this->_keywords = $keywords;
    }
    
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
    public function getData()
    {
        return array(
            array(
                'keywords' => $this->_keywords,
                'value' => $this->_value,
                'is_avg' => $this->_avg
            )
        );
    }  
}
