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
 * @version   SVN: $Id: Rolle.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * Model
 *
 * @category  Kreditrechner
 * @package   Models
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class Rolle extends ModelAbstract
{
    /**
     * Table name
     *
     * @var String
     */
    protected $_name = 'rolle';

    /**
     * Primary key
     *
     * @var String
     */
    protected $_primary = 'RolleId';

    /**
     * liefert die ID einer Sparte
     *
     * @param mixed $value ID oder Name der Sparte
     *
     * @return boolean|integer FALSE, wenn die Sparte nicht existiert,
     *                         ansonsten die ID der Sparte
     * @access protected
     */
    public function getId($value)
    {
        if (!is_string($value) && !is_numeric($value)) {
            //type id in wrong format
            return false;
        }

        if (is_numeric($value) && 0 >= (int) $value) {
            return false;
        }

        $select = $this->select();
        $select->from(
            array('r' => $this->_name),
            array('id' => 'RolleId')
        );

        if (is_numeric($value)) {
            $select->where('r.RolleId = ?', (int) $value);
        } else {
            $value = ucfirst(strtolower((string) $value));
            $select->where('r.Name = ?', $value);
        }

        $select->where(new \Zend\Db\Expr('r.active = 1'));

        $row = $this->fetchAll($select)->current();

        if (isset($row->id) && 0 < (int) $row->id) {
            return (int) $row->id;
        } else {
            return false;
        }
    }

    /**
     * liefert die ID einer Sparte
     *
     * @param mixed $value ID oder Name der Sparte
     *
     * @return boolean|integer FALSE, wenn die Sparte nicht existiert,
     *                         ansonsten die ID der Sparte
     * @access protected
     */
    public function getName($value)
    {
        $id = $this->getId($value);

        if (false === $id) {
            return null;
        }

        $rows = $this->find($id);

        if (null === $rows) {
            return null;
        }

        return $rows->current()->Name;
    }
}