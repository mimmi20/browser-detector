<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Model;

/**
 * Model
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Models
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: Usages.php -1   $
 */

/**
 * Model
 *
 * @category  Kreditrechner
 * @package   Models
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class Usages extends ModelAbstract
{
    /**
     * Table name
     *
     * @var String
     */
    protected $_name = 'usages';

    /**
     * Primary key
     *
     * @var String
     */
    protected $_primary = 'idUsages';

    /**
     * liefert alle möglichen Laufzeiten für eine Sparte
     *
     * @param string $sparte the name of the sparte
     *
     * @return array
     * @access public
     */
    public function getList()
    {
        $list = array() ;

        $select = $this->select();
        $select->from(
            array($this->_name),
            array('name', 'value' => 'idUsages')
        );
        $select->order(array('name', 'value'));

        $rows = $this->fetchAll($select);

        foreach ($rows as $row) {
            $list[$row->value] = $row->name;
        }

        return $list;
    }

    /**
     * liefert den Namen zu einer Laufzeit
     *
     * @param integer $usage the id/number of the usage
     *
     * @return string
     * @access public
     */
    public function name($usage = 8)
    {
        if (!is_numeric($usage)) {
            return '';
        }

        if (is_numeric($usage) && 0 >= (int) $usage) {
            return '';
        }

        $select = $this->select();
        $select->from(
            array('u' => $this->_name),
            array('name')
        );
        $select->where('idUsages = ? ', $usage);
        $select->order(array('idUsages'));
        $select->limit(1);

        $row = $this->fetchAll($select)->current();

        if (is_object($row) && '' != $row->name) {
            return $row->name;
        }

        return '';
    }

    /**
     * checkt den Verwendungszeck
     *
     * @param integer $value der Wert, der geprüft werden soll
     *
     * @return boolean
     * @access protected
     */
    public function check($value)
    {
        if (!is_numeric($value) ) {
            return false;
        }

        if (is_numeric($value) && 0 >= (int) $value) {
            return false;
        }

        $value  = (int) $value;

        $select = $this->select();
        $select->from(
            array('u' => $this->_name),
            array('count' => new \Zend\Db\Expr('COUNT(*)'))
        );
        $select->where('u.idUsages = ?', $value);
        $select->limit(1);

        $row = $this->fetchAll($select)->current();

        if (is_object($row) && (int) $row->count) {
            return true;
        }

        return false;
    }
}