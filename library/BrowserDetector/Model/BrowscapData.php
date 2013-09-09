<?php
namespace Browscap\Model;

/**
 * PHP version 5.3
 *
 * LICENSE:
 *
 * Copyright (c) 2013, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 *
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without 
 * modification, are permitted provided that the following conditions are met:
 *
 * * Redistributions of source code must retain the above copyright notice, 
 *   this list of conditions and the following disclaimer.
 * * Redistributions in binary form must reproduce the above copyright notice, 
 *   this list of conditions and the following disclaimer in the documentation 
 *   and/or other materials provided with the distribution.
 * * Neither the name of the authors nor the names of its contributors may be 
 *   used to endorse or promote products derived from this software without 
 *   specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" 
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE 
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE 
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE 
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR 
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF 
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS 
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN 
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) 
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE 
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category  Browscap
 * @package   Browscap
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
 * @version   SVN: $Id$
 */

/**
 * Model
 *
 * @category  Browscap
 * @package   Browscap
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @license   http://opensource.org/licenses/BSD-3-Clause New BSD License
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
