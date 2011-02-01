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
 * @version   SVN: $Id$
 */

/**
 * Model
 *
 * @category  Kreditrechner
 * @package   Models
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class Resources extends ServiceAbstract
{
    /**
     * Class Constructor
     *
     * @return \\AppCore\\Service\Resources
     */
    public function __construct()
    {
        $this->_model = new \AppCore\Model\Resources();
    }

    /**
     * returns a list of possible Resources
     *
     * @return array  a list of all resources
     * @access public
     */
    public function getList()
    {
        return $this->_model->getCached('resources')->getList();
    }

    /**
     * cleans the model cache
     *
     * calls the {@link _cleanCache} function with defined tag name
     *
     * @return \\AppCore\\Service\Resources
     */
    public function cleanCache()
    {
        return $this->cleanTaggedCache('resources');
    }
}