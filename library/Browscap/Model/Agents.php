<?php
declare(ENCODING = 'utf-8');
namespace Browscap\Model;

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
 * @version   SVN: $Id$
 */

/**
 * Model
 *
 * @category  CreditCalc
 * @package   Models
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2007-2010 Unister GmbH
 */
class Agents extends ModelAbstract
{
    /**
     * Table name
     *
     * @var String
     */
    protected $_name = 'agents';

    /**
     * Primary key
     *
     * @var String
     */
    protected $_primary = 'idAgents';
    /*
    CREATE TABLE `browsers` (
        `idBrowsers` INT(10) NULL AUTO_INCREMENT,
        `browser` VARCHAR(250) NULL,
        `version` DECIMAL(10,2) UNSIGNED NULL,
        `bits` INT UNSIGNED NULL,
        `count` BIGINT UNSIGNED NULL,
        PRIMARY KEY (`idBrowsers`),
        INDEX `count` (`count`),
        UNIQUE INDEX `browser_version_bits` (`browser`, `version`, `bits`)
    )
    COLLATE='utf8_general_ci'
    ENGINE=InnoDB
    ROW_FORMAT=DEFAULT
    */

    /**
     * Loads a row from the database and binds the fields to the object
     * properties
     *
     * @param mixed $agent (Optional) the browsers short name e.g. 'IE'
     *
     * @return boolean True if successful
     * @access public
     */
    public function searchByAgent($userAgent)
    {
        if (!is_string($userAgent)) {
            return false;
        }

        $select = $this->select();
        $select->from(array('a' => $this->_name));

        $select->where('`a`.`agent` = ?', $userAgent);

        $select->limit(1);

        $agent = $this->fetchAll($select)->current();
        
        if (!$agent) {
            $agent = $this->createRow();
            
            $agent->agent = $userAgent;
            $agent->save();
        }
        
        return $agent;
    }
    
    public function count($idAgents)
    {
        $agent = $this->find($idAgents)->current();
        
        if ($agent) {
            $agent->count += 1;
            $agent->save();
        }
    }
    
    public function countByAgent($userAgent)
    {
        $agent = $this->searchByAgent($userAgent);
        
        if ($agent) {
            $agent->count += 1;
        } else {
            $agent = $this->createRow();
            
            $agent->agent = $userAgent;
            $agent->count = 1;
        }
        
        $agent->save();
    }
    
    public function getResource()
    {
        return 'Agents';
    }
}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */