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
 * @version   SVN: $Id: Browser.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * Model
 *
 * @category  Kreditrechner
 * @package   Models
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class Browser extends ModelAbstract
{
    /**
     * Table name
     *
     * @var String
     */
    protected $_name = 'browser';

    /**
     * Primary key
     *
     * @var String
     */
    protected $_primary = 'browserId';

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
        if (!is_string($browser) || is_numeric($browser)) {
            return false;
        }

        if (!is_numeric($version)) {
            return false;
        }

        $version = number_format((float) $version, 2);

        $select = $this->select();
        $select->from(array('b' => $this->_name));

        $select->where('`b`.`Browser` = ?', $browser);
        $select->where('`b`.`Version` = ?', $version);
        $select->where('`b`.`Platform` = ?', $platform);

        if ($bits == 64) {
            $select->where('`b`.`Win64` = 1');
        } elseif ($bits == 32) {
            $select->where('`b`.`Win32` = 1');
        } elseif ($bits == 16) {
            $select->where('`b`.`Win16` = 1');
        }

        $select->limit(1);

        return $this->fetchAll($select)->current();
    }
}