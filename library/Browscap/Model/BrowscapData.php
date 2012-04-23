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
        $browser = null, $platform = null, $version = 0, $bits = null, $wurflkey = null)
    {
        if (!is_string($browser) || is_numeric($browser)) {
            return false;
        }

        if (!is_string($platform) || is_numeric($platform)) {
            $platform = 'unknown';
        }

        $select = $this->select();
        $select->from(array('bd' => $this->_name));

        $select->where('`bd`.`browser` = ?', (string) $browser);
        $select->where('`bd`.`platform` = ?', (string) $platform);
        $select->where('`bd`.`version` = ?', (string) $version);
        
        if (64 == $bits) {
            $select->where('`bd`.`win64` = 1');
        } elseif (32 == $bits) {
            $select->where('`bd`.`win32` = 1');
        } elseif (16 == $bits) {
            $select->where('`bd`.`win16` = 1');
        }
        
        if (null !== $wurflkey) {
            $select->where('`bd`.`wurflkey` = ?', (string) $wurflkey);
        }

        $select->limit(1);
        $data = $this->fetchRow($select);
        
        if (!$data) {
            $data = $this->createRow();
            
            $data->browser  = (string) $browser;
            $data->platform = (string) $platform;
            $data->version  = (string) $version;
            if (64 == $bits) {
                $data->win64 = 1;
            } elseif (32 == $bits) {
                $data->win32 = 1;
            } elseif (16 == $bits) {
                $data->win16 = 1;
            }
            $data->wurflkey = (string) $wurflkey;
            
            $data->save();
        }
        
        return $data;
    }
    
    public function count($idBrowscapData)
    {
        $browser = $this->find($idBrowscapData)->current();
        
        if ($browser) {
            $this->update(array('count' => $browser->count + 1), 'idBrowscapData = ' . (int) $browser->idBrowscapData);
        }
    }
    
    public function getResource()
    {
        return 'BrowscapData';
    }
}
