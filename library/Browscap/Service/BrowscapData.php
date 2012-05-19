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
class BrowscapData extends ServiceAbstract
{
    /**
     * Class Constructor
     *
     * @return \App\Service\BrowscapData
     */
    public function __construct()
    {
        $this->_model = new \Browscap\Model\BrowscapData();
    }

    /**
     * Loads a row from the database and binds the fields to the object
     * properties
     *
     * @param mixed $data (Optional) the browsers short name e.g. 'IE'
     *
     * @return boolean True if successful
     * @access public
     */
    public function searchByBrowser(
        $browser = null, $platform = null, $version = 0, $bits = null, $wurflkey = null)
    {
        return $this->_model->getCached('browscapdata')->searchByBrowser(
            $browser, $platform, $version, $bits, $wurflkey
        );
    }
    
    public function count($idBrowserData)
    {
        return $this->_model->count($idBrowserData);
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
        return $this->cleanTaggedCache('browscapdata');
    }
}