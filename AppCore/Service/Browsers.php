<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Service;

/**
 * Model
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Models
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: Browsers.php -1   $
 */

/**
 * Model
 *
 * @category  Kreditrechner
 * @package   Models
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class Browsers extends ServiceAbstract
{
    /**
     * Class Constructor
     *
     * @return \AppCore\Service\Browsers
     */
    public function __construct()
    {
        $this->_model = new \AppCore\Model\Browsers();
    }

    /**
     * Loads a row from the database and binds the fields to the object
     * properties
     *
     * @param mixed $browser (Optional) the browsers short name e.g. 'IE'
     *
     * @return boolean True if successful
     * @access public
     */
    public function searchByBrowser(
        $browser = null, $version = 0, $platform = null, $bits = null)
    {
        return $this->_model->getCached('browser')->searchByBrowser(
            $browser, $version, $platform, $bits
        );
    }

    /**
     * cleans the model cache
     *
     * calls the {@link _cleanCache} function with defined tag name
     *
     * @return \AppCore\Service\Browsers
     */
    public function cleanCache()
    {
        return $this->cleanTaggedCache('browser');
    }
}