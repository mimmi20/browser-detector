<?php

/**
 * Unister Tracking
 *
 * To profile and track in an application
 *
 * @package    Unister_Tracking_Tracking
 * @version    $Id: Tracking.php 4111 2010-11-18 17:38:16Z t.mueller $
 */

require_once(dirname(__FILE__).'/Tracking/Exception.php');
require_once(dirname(__FILE__).'/Tracking/Item/Interface.php');
require_once(dirname(__FILE__).'/Tracking/Save/Interface.php');
require_once(dirname(__FILE__).'/Tracking/Item/Track.php');
require_once(dirname(__FILE__).'/Tracking/Item/Profile.php');

/**
 * Unister Tracking
 *
 * To profile and track in an application
 *
 * @package    Unister_Tracking_Tracking
 * @version    $Id: Tracking.php 4111 2010-11-18 17:38:16Z t.mueller $
 */
class Unister_Tracking_Tracking
{

    /**
     * The items of the Tracking (profile,track).
     *
     * @var array
     */
    protected $_items = array();

    /**
     * Default keywords, will be set by default before the normal keyword.
     *
     * @var array
     */
    protected $_defaultKeywords = array();

    /**
     * If true, the tracker is on.
     *
     * @var boolean
     */
    protected $_enabled = false;

    /**
     * The instace of the object.
     *
     * @var Unister_Tracking_Tracking
     */
    static protected $_instance = null;

    /**
     * The constructor.
     *
     * @param boolean $enabled Switchs Tracker ON or OFF
     */
    protected function __construct($enabled=true){
        $this->setEnabled($enabled);
    }

    /**
     * Initialize the object and get in instance.
     *
     * @return Unister_Tracking_Tracking
     */
    static public function getInstance()
    {
        if (self::$_instance === null){
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * Switchs Tracker ON or OFF
     *
     * @param boolean $enabled Switchs Tracker ON or OFF.
     */
    public function setEnabled($enabled)
    {
        $this->_enabled = (boolean) $enabled;
    }

    /**
     * Set the default keywords, what will be set by default before the normal keyword.
     *
     * @param array $keywords The default keywords.
     */
    public function setDefaultKeywords($keywords)
    {
        $this->_defaultKeywords = (array) $keywords;
    }

    /**
     * Checks if the tracker is enabled.
     *
     * @return boolean TRUE = ON, FALSE = OFF
     */
    public function isEnabled()
    {
        return $this->_enabled;
    }

    /**
     * Delete the whole collected data.
     */
    public function clear()
    {
        $this->_items = array();
    }

    /**
     * Create a new profile and profiling untile stopProfile() are called.
     *
     * @param array|string $keywords The keywords for the profile.
     * @param boolean|array $useDefault Use the default keywords for the profile.
     * @return Unister_Tracking_Tracking_Item_Profile
     */
    public function startProfile($keywords=array(),$useDefault=true,$options=array())
    {
        if (!$this->_enabled) return null;
        $this->_prepareKeywords($keywords,$useDefault);
        $hash = $this->_generateHash($keywords);

        $this->_items[$hash] = new Unister_Tracking_Tracking_Item_Profile(
            $keywords,$options
        );

        return $this->_items[$hash];
    }

    /**
     * Stop the profiling of a profile.
     *
     * @param array|string $keywords The keywords for the profile.
     * @param boolean|array $useDefault Use the default keywords for the profile.
     * @return Unister_Tracking_Tracking_Item_Profile
     */
    public function stopProfile($keywords=array(),$useDefault=true)
    {
        if (!$this->_enabled) {
            return null;
        }

        $this->_prepareKeywords($keywords, $useDefault);
        $hash = $this->_generateHash($keywords);

        if (isset($this->_items[$hash])
            && $this->_items[$hash] instanceof Unister_Tracking_Tracking_Item_Profile
        ) {
            $obj = $this->_items[$hash];
            $obj->stop();
            unset($this->_items[$hash]);
            $this->_items[] = $obj;

            return $obj;
        }

        return null;
    }

    /**
     * Get a profile.
     *
     * @param array|string $keywords The keywords for the profile.
     * @param boolean|array $useDefault Use the default keywords for the profile.
     * @return Unister_Tracking_Tracking_Item_Profile
     */
    public function getProfile($keywords=array(),$useDefault=true)
    {
        if (!$this->_enabled) return null;
        $this->_prepareKeywords($keywords,$useDefault);
        $hash = $this->_generateHash($keywords);

        if($this->_items[$hash] instanceof Unister_Tracking_Tracking_Item_Profile){
            return $this->_items[$hash];
        }

        return null;
    }

    /**
     * Cancel a profile, data will not being tracked.
     *
     * @param array|string $keywords The keywords for the profile.
     * @param boolean|array $useDefault Use the default keywords for the profile.
     */
    public function cancelProfile($keywords=array(),$useDefault=true)
    {
        if (!$this->_enabled) return null;
        $this->_prepareKeywords($keywords,$useDefault);
        $hash = $this->_generateHash($keywords);

        if($this->_items[$hash] instanceof Unister_Tracking_Tracking_Item_Profile){
            unset($this->_items[$hash]);
        }

        return null;
    }

    /**
     * Add a item to tracking.
     *
     * @param Unister_Tracking_Tracking_Item_Interface $item Item of Unister_Tracking_Tracking_Item_Interface.
     * @return boolean Adding successful.
     */
    public function add($item){
        if (!$this->_enabled) return null;
        if(!($item instanceof Unister_Tracking_Tracking_Item_Interface)){
            trigger_error(
                '$item is not a Unister_Tracking_Tracking_Item_Interface',
                E_USER_WARNING
            );
            return false;
        }

        $this->_items[] = $item;
        return true;
    }

    /**
     * Track a value.
     *
     * @param array|string $keywords The keywords for the value.
     * @param boolean|array $useDefault Use the default keywords for the value.
     * @param float $value The value.
     * @param boolean $avg Set if the value is a average value.
     * @return Unister_Tracking_Tracking_Item_Track
     */
    public function track($keywords=array(),$useDefault=true,$value=1,$avg=false)
    {
        if (!$this->_enabled) return null;
        $this->_prepareKeywords($keywords,$useDefault);

        return $this->_track($keywords,$value,$avg);
    }

    /**
     * Stop all Profiles.
     */
    public function finish()
    {
        if (!$this->_enabled) return null;

        foreach($this->_items as $item){
            if($item instanceof Unister_Tracking_Tracking_Item_Profile){
                if($item->isActive()) $item->stop();
            }
        }
    }

    /**
     * Register a shutdown function.
     *
     * @param Unister_Tracking_Tracking_Save_Interface $adapter The default save adapter
     */
    public function registerShutdown($adapter){
        if(!($adapter instanceof Unister_Tracking_Tracking_Save_Interface)){
            throw new Unister_Tracking_Tracking_Exception('Adapter has no Unister_Tracking_Tracking_Save_Interface');
        }

        register_shutdown_function(array($this,'shutdown'),$adapter);
    }

    /**
     * The shutdown function.
     *
     * @param Unister_Tracking_Tracking_Save_Interface $adapter The default save adapter
     * @return boolean
     */
    public function shutdown($adapter){
        if (!$this->_enabled) return null;

        try{
            $this->finish();
            return $this->save($adapter);
        }catch(Exception $e){
            return false;
        }
    }

    /**
     * Prepare the keywords.
     *
     * Set default keywords and convert it to an array.
     *
     * @param array|string $keywords The keywords for the value.
     * @param boolean $useDefault Use the default keywords for the value.
     */
    protected function _prepareKeywords(&$keywords,$useDefault)
    {
        if(!is_array($keywords)) $keywords = array($keywords);

        if(is_array($useDefault)){
            $keywords = array_merge($useDefault,$keywords);
        }else{
            if($useDefault)
                $keywords = array_merge($this->_defaultKeywords,$keywords);
        }
    }

    /**
     * Internal function to track a value.
     *
     * @param array|string $keywords The keywords for the value.
     * @param float $value The value.
     * @param boolean $avg Set if the value is a average value.
     * @return Unister_Tracking_Tracking_Item_Track
     */
    protected function _track($keywords,$value=1,$avg=false)
    {
        $item = new Unister_Tracking_Tracking_Item_Track(
            $keywords,
            $value,
            $avg
        );

        $this->_items[] = $item;

        return $item;
    }

    /**
     * Track default values.
     *
     * Defaults are: Load
     */
    public function trackDefaults()
    {
        if (!$this->_enabled) return false;

        $this->_track('Load',$this->getLoad(),true);
    }

    /**
     * Generate a hash.
     *
     * @param mixed $value
     * @return string
     */
    protected function _generateHash($value)
    {
        $value = serialize($value);
        return md5($value).'_'.sprintf('%u',crc32($value));
    }

    /**
     * Get the current Load of the machine
     *
     * @return string
     */
    public function getLoad()
    {
        $load = sys_getloadavg();
        return $load[0];
    }

    /**
     * Save the collected Data.
     *
     * @param Unister_Tracking_Tracking_Save_Interface $adapter The Adapter.
     * @return boolean
     */
    public function save($adapter)
    {
        if (!$this->_enabled) return null;

        if(!($adapter instanceof Unister_Tracking_Tracking_Save_Interface)){
            trigger_error('Adapter has no Unister_Tracking_Tracking_Save_Interface',E_USER_WARNING);
            return false;
        }

        return $adapter->save($this->_getData());
    }

    /**
     * Get the collected data.
     *
     * @return array
     */
    protected function _getData()
    {
        if (!$this->_enabled) return null;

        $res = array();
        foreach($this->_items as $item){
            if(!($item instanceof Unister_Tracking_Tracking_Item_Interface)) continue;

            $res = array_merge($res,$item->getData());
        }

        return $res;
    }

}
