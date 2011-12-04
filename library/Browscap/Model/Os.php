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
class Os extends ModelAbstract
{
    /**
     * Table name
     *
     * @var String
     */
    protected $_name = 'os';

    /**
     * Primary key
     *
     * @var String
     */
    protected $_primary = 'idOs';

    /**
     * Loads a row from the database and binds the fields to the object
     * properties
     *
     * @param mixed $os (Optional) the browsers short name e.g. 'IE'
     *
     * @return boolean True if successful
     * @access public
     */
    public function searchByName(
        $osName = null, $version = 0, $bits = null)
    {
        if (!is_string($osName) || is_numeric($osName)) {
            return false;
        }

        $select = $this->select();
        $select->from(array('b' => $this->_name));

        $select->where('`b`.`os` = ?', $osName);
        $select->where('`b`.`version` = ?', $version);
        $select->where('`b`.`bits` = ?', (int) $bits);

        $select->limit(1);

        $os = $this->fetchAll($select)->current();
        
        if (!$os) {
            $os = $this->createRow();
            
            $os->os      = $osName;
            $os->version = $version;
            $os->osFull  = $osName . ' ' . $version;
            $os->bits    = $bits;
            $os->count   = 0;
            
            $os->save();
        }
        
        return $os;
    }
    
    public function count($idOs)
    {
        $os = $this->find($idOs)->current();
        
        if ($os) {
            $os->count += 1;
            $os->save();
        }
    }
    
    public function countByName($osName, $osVersion = 0.0, $bits = 0)
    {
        $os = $this->searchByName($osName, $osVersion, $bits);
        
        $os->count += 1;
        $os->save();
        
        return $os->idOs;
    }
    
    public function getAll()
    {
        $select = $this->select();
        $select->from(
            $this->_name, 
            array(
                'name' => 'os',
                'count' => new \Zend\Db\Expr('sum(`count`)')
            )
        );
        $select->group('os');
        
        return $this->fetchAll($select);
    }
    
    public function getResource()
    {
        return 'Os';
    }
}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */