<?php
declare(ENCODING = 'utf-8');
namespace Browscap\Service;

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Model
 *
 * PHP version 5
 *
 * @category  CreditCalc
 * @package   Models
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: Engines.php 145 2011-12-15 23:23:45Z  $
 */

/**
 * Model
 *
 * @category  CreditCalc
 * @package   Models
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2007-2010 Unister GmbH
 */
class Engines extends ServiceAbstract
{
    /**
     * Class Constructor
     *
     * @return \App\Service\Browsers
     */
    public function __construct()
    {
        $this->_model = new \Browscap\Model\Engines();
    }

    /**
     * Loads a row from the database and binds the fields to the object
     * properties
     *
     * @param mixed $engine (Optional) the browsers short name e.g. 'IE'
     *
     * @return boolean True if successful
     * @access public
     */
    public function searchByName($engine = null, $version = 0)
    {
        return $this->_model->getCached('engine')->searchByName($engine, $version);
    }
    
    public function count($idEngines)
    {
        return $this->_model->count($idEngines);
    }
    
    public function countByName($engineName, $engineVersion = 0.0)
    {
        return $this->_model->countByName($engineName, $engineVersion);
    }
    
    public function getAll()
    {
        return $this->_model->getCached('engine')->getAll();
    }

    /**
     * cleans the model cache
     *
     * calls the {@link _cleanCache} function with defined tag name
     *
     * @return \App\Service\Browsers
     */
    public function cleanCache()
    {
        return $this->cleanTaggedCache('engine');
    }
}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */