<?php
declare(ENCODING = 'iso-8859-1');
namespace Credit\Core\Model;

/**
 * Model
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Models
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: Resources.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * Model
 *
 * @category  Kreditrechner
 * @package   Models
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class Resources extends ModelAbstract
{
    /**
     * Table name
     *
     * @var String
     */
    protected $_name = 'ressource';

    /**
     * Primary key
     *
     * @var String
     */
    protected $_primary = 'RessourceId';

    /**
     * returns a list of possible Resources
     *
     * @return array  a list of all resources
     * @access public
     */
    public function getList()
    {
        $resArray  = $this->fetchAll();
        $resources = array();

        foreach ($resArray as $resource) {
            $resources[$resource->RessourceId] = $resource->Controller;
        }

        return $resources;
    }
}