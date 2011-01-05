<?php

/**
 * Unister Tracking Item Profile
 * 
 * For profiling a section in the Application
 * 
 * @package    Unister_Tracking_Tracking
 * @subpackage Item
 * @version    $Id: Profile.php 4125 2010-11-23 16:11:05Z t.mueller $
 */
class Unister_Tracking_Tracking_Item_Profile implements Unister_Tracking_Tracking_Item_Interface
{
    /**
     * The keywords.
     *
     * @var array
     */    
    protected $_keywords = array();
    
    /**
     * The start time of the Profiling (to calculate the duration).
     *
     * @var float
     */    
    protected $_startTime = false;
    
    /**
     * The profiling is in progress.
     *
     * @var boolean
     */    
    protected $_active = false;
    
    /**
     * The keywords.
     *
     * @var array
     */
    protected $_items = array();
    
    /**
     * Options for the Profiling.
     *
     * @var array
     */
    protected $_options = array(
        'duration' => true,
        'memoryUsage' => false,
        'peakMemoryUsage' => false,
    );

    /**
     * The constructor.
     * 
     * Start the Profiling automatically with start().
     *
     * @param array|string $keywords The keywords for the value.
     */
    public function __construct($keywords=array(),$options=array())
    {        
        $this->setKeywords($keywords);
        $this->_options = array_merge($this->_options,$options);
        $this->start();
    }

    /**
     * Set the keywords.
     *
     * @param array|string $keywords The keywords for the value.
     */    
    public function setKeywords($keywords)
    {
        if(!is_array($keywords)) $keywords = array($keywords);
        $this->_keywords = $keywords;
    }
    
     /**
     * Start the Profiling.
     */   
    public function start(){
        $this->_active = true;        
        $this->_startTime = microtime(true);        
    }
    
     /**
     * Check if profiling Active.
     * 
     * @return boolean 
     */   
    public function isActive(){
        return $this->_active;    
    }

     /**
     * Stop the Profiling.
     */    
    public function stop()
    {
        if(!$this->_active) return false;
        $this->_active = false;
        
        $this->_setItems();
        return true;
    }
    
    /**
     * Set the items of the profiling.
     */
    protected function _setItems(){
        if($this->_options['duration']) $this->_setDuration();
        if($this->_options['peakMemoryUsage']) $this->_setPeakMemoryUsage();
        if($this->_options['memoryUsage']) $this->_setMemoryUsage();
    }
    
    /**
     * Set the duration item.
     */
    protected function _setDuration(){
        $keywords = $this->_keywords;
        $keywords[] = 'Duration';
        
        $value = microtime(true) - $this->_startTime;
        
        $this->_items[] = new Unister_Tracking_Tracking_Item_Track(
            $keywords,
            $value,
            true
        );
    }
    
    /**
     * Set the peak memory usage item.
     */
    protected function _setPeakMemoryUsage(){
        $keywords = $this->_keywords;
        $keywords[] = 'PeakMemoryUsageKB';
        
        $value = memory_get_peak_usage(true)/1024;
        
        $this->_items[] = new Unister_Tracking_Tracking_Item_Track(
            $keywords,
            $value,
            true
        );
    }

    /**
     * Set the memory usage item.
     */    
    protected function _setMemoryUsage(){
        $keywords = $this->_keywords;
        $keywords[] = 'MemoryUsageKB';
        
        $value = memory_get_usage(true)/1024;
        
        $this->_items[] = new Unister_Tracking_Tracking_Item_Track(
            $keywords,
            $value,
            true
        );
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
        $res = array();        
        foreach($this->_items as $item){
            if(!($item instanceof Unister_Tracking_Tracking_Item_Interface)) continue;
            
            $res = array_merge($res,$item->getData());
        }
        
        return $res;
    }
  
}
