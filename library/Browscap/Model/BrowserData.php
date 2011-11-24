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
 * @version   SVN: $Id: Browsers.php -1   $
 */

/**
 * Model
 *
 * @category  CreditCalc
 * @package   Models
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2007-2010 Unister GmbH
 */
class BrowserData extends ModelAbstract
{
    /**
     * Table name
     *
     * @var String
     */
    protected $_name = 'browserdata';

    /**
     * Primary key
     *
     * @var String
     */
    protected $_primary = 'idBrowserData';

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
        $browser = null, $version = 0, $bits = null)
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

        $select->where('`b`.`name` = ?', $browser);
        $select->where('`b`.`version` = ?', $version);
        $select->where('`b`.`bits` = ?', (int) $bits);

        $select->limit(1);

        return $this->fetchAll($select)->current();
    }
    
    public function count($idBrowsers)
    {
        $browser = $this->find($idBrowsers)->current();
        
        if ($browser) {
            $browser->count += 1;
            $browser->save();
        }
    }
    
    public function countByName($browserName, $browserVersion = 0.0, $bits = 0, array $data)
    {
        $browser = $this->searchByBrowser($browserName, $browserVersion, $bits);
        
        if ($browser) {
            $browser->count += 1;
        } else {
            $browser = $this->createRow();
            
            $browser->name    = $browserName;
            $browser->version = $browserVersion;
            $browser->bits    = $bits;
            $browser->data    = \Zend\Json\Json::encode($data);
            $browser->count   = 1;
        }
        
        $browser->save();
        
        return $browser->idBrowserData;
    }
    
    public function getAll()
    {
        $select = $this->select();
        $select->from(
            $this->_name, 
            array(
                'name' => 'name',
                'count' => new \Zend\Db\Expr('sum(`count`)')
            )
        );
        $select->group('name');
        
        return $this->fetchAll($select);
    }
    
    public function getResource()
    {
        return 'BrowserData';
    }
}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */