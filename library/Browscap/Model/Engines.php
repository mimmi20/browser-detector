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
class Engines extends ModelAbstract
{
    /**
     * Table name
     *
     * @var String
     */
    protected $_name = 'engines';

    /**
     * Primary key
     *
     * @var String
     */
    protected $_primary = 'idEngines';

    /**
     * Loads a row from the database and binds the fields to the object
     * properties
     *
     * @param mixed $engine (Optional) the browsers short name e.g. 'IE'
     *
     * @return boolean True if successful
     * @access public
     */
    public function searchByName($engine = null, $version = 0)
    {
        if (!is_string($engine) || is_numeric($engine)) {
            return false;
        }

        $select = $this->select();
        $select->from(array('b' => $this->_name));

        $select->where('`b`.`engine` = ?', $engine);
        $select->where('`b`.`version` = ?', $version);

        $select->limit(1);

        return $this->fetchAll($select)->current();
    }
    
    public function count($idEngines)
    {
        $engine = $this->find($idEngines)->current();
        
        if ($engine) {
            $engine->count += 1;
            $engine->save();
        }
    }
    
    public function countByName($engineName, $engineVersion = 0.0)
    {
        $engine = $this->searchByName($engineName, $engineVersion);
        
        if ($engine) {
            $engine->count += 1;
        } else {
            $engine = $this->createRow();
            
            $engine->engine  = $engineName;
            $engine->version = $engineVersion;
            $engine->count   = 1;
        }
        
        $engine->save();
        
        return $engine->idEngines;
    }
    
    public function getAll()
    {
        $select = $this->select();
        $select->from(
            $this->_name, 
            array(
                'name' => 'engine',
                'count' => new \Zend\Db\Expr('sum(`count`)')
            )
        );
        $select->group('engine');
        
        return $this->fetchAll($select);
    }
    
    public function getResource()
    {
        return 'Engines';
    }
}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */