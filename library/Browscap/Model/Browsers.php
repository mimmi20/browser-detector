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
class Browsers extends ModelAbstract
{
    /**
     * Table name
     *
     * @var String
     */
    protected $_name = 'browsers';

    /**
     * Primary key
     *
     * @var String
     */
    protected $_primary = 'idBrowsers';
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
     * @param mixed $browserName (Optional) the browsers short name e.g. 'IE'
     *
     * @return boolean True if successful
     * @access public
     */
    public function searchByBrowser(
        $browserName = null, $version = 0, $bits = null)
    {
        if (!is_string($browserName) || is_numeric($browserName)) {
            return false;
        }

        $select = $this->select();
        $select->from(array('b' => $this->_name));

        $select->where('`b`.`browser` = ?', $browserName);
        $select->where('`b`.`version` = ?', $version);
        $select->where('`b`.`bits` = ?', (int) $bits);

        $select->limit(1);

        $browser = $this->fetchAll($select)->current();
        
        if (!$browser) {
            $browser = $this->createRow();
            
            $browser->browser = $browserName;
            $browser->version = $version;
            $browser->bits    = (int) $bits;
            $browser->count   = 0;
            
            $browser->save();
        }
        
        return $browser;
    }
    
    public function count($idBrowsers)
    {
        $browser = $this->find($idBrowsers)->current();
        
        if ($browser) {
            $browser->count += 1;
            $browser->save();
        }
    }
    
    public function countByName($browserName, $browserVersion = 0.0, $bits = 0)
    {
        $browser = $this->searchByBrowser($browserName, $browserVersion, $bits);
        
        $browser->count += 1;
        $browser->save();
        
        return $browser->idBrowsers;
    }
    
    public function getAll()
    {
        $select = $this->select();
        $select->from(
            $this->_name, 
            array(
                'name' => 'browser',
                'count' => new \Zend\Db\Expr('sum(`count`)')
            )
        );
        $select->group('browser');
        
        return $this->fetchAll($select);
    }
    
    public function getResource()
    {
        return 'Browsers';
    }
}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */