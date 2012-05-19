<?php
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
 * @version    SVN: $Id$
 */

/**
 * Model
 *
 * @category  CreditCalc
 * @package   Models
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2007-2010 Unister GmbH
 */
class Os extends ServiceAbstract
{
    /**
     * Class Constructor
     *
     * @return \App\Service\Os
     */
    public function __construct()
    {
        $this->_model = new \Browscap\Model\Os();
    }

    /**
     * Loads a row from the database and binds the fields to the object
     * properties
     *
     * @param mixed $os (Optional) the browsers short name e.g. 'IE'
     *
     * @return boolean True if successful
     * @access public
     */
    public function searchByName(
        $osName = null, $version = 0, $bits = null)
    {
        return $this->_model->getCached('os')->searchByName(
            $osName, $version, $bits
        );
    }
    
    public function count($idOs)
    {
        return $this->_model->count($idOs);
    }
    
    public function countByName($osName, $osVersion = 0.0, $bits = 0)
    {
        return $this->_model->countByName($osName, $osVersion, $bits);
    }
    
    public function getAll()
    {
        return $this->_model->getCached('os')->getAll();
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
        return $this->cleanTaggedCache('os');
    }
}