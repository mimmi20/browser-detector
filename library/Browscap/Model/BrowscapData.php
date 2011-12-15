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
class BrowscapData extends ModelAbstract
{
    /**
     * Table name
     *
     * @var String
     */
    protected $_name = 'browscapdata';

    /**
     * Primary key
     *
     * @var String
     */
    protected $_primary = 'idBrowscapData';
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
     * @param mixed $data (Optional) the browsers short name e.g. 'IE'
     *
     * @return boolean True if successful
     * @access public
     */
    public function searchByBrowser(
        $browser = null, $platform = null, $version = 0, $bits = null)
    {
        if (!is_string($browser) || is_numeric($browser)) {
            return false;
        }

        if (!is_string($platform) || is_numeric($platform)) {
            $platform = 'unknown';
        }

        if (!is_numeric($version)) {
            return false;
        }

        $version = number_format((float) $version, 2);

        $select = $this->select();
        $select->from(array('bd' => $this->_name));

        $select->where('`bd`.`browser` = ?', $browser);
        $select->where('`bd`.`platform` = ?', $platform);
        $select->where('`bd`.`version` = ?', $version);
        
        if (64 == $bits) {
            $select->where('`bd`.`win64` = 1');
        } elseif (32 == $bits) {
            $select->where('`bd`.`win32` = 1');
        } elseif (16 == $bits) {
            $select->where('`bd`.`win16` = 1');
        }

        $select->limit(1);

        $data = $this->fetchAll($select)->current();
        
        if (!$data) {
            $data = $this->createRow();
            
            $data->browser  = $browser;
            $data->platform = $platform;
            $data->version  = $version;
            if (64 == $bits) {
                $data->win64 = 1;
            } elseif (32 == $bits) {
                $data->win32 = 1;
            } elseif (16 == $bits) {
                $data->win16 = 1;
            }
            $data->save();
        }
        
        return $data;
    }
    
    public function count($idBrowserData)
    {
        $browser = $this->find($idBrowserData)->current();
        
        if ($browser) {
            $browser->count += 1;
            $browser->save();
        }
    }
    
    public function getResource()
    {
        return 'BrowscapData';
    }
}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */