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
 * @version   SVN: $Id: Types.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * Model
 *
 * @category  Kreditrechner
 * @package   Models
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class Types extends ModelAbstract
{
    /**
     * Table name
     *
     * @var String
     */
    protected $_name = 'types';

    /**
     * Primary key
     *
     * @var String
     */
    protected $_primary = 'id_type';

    /**
     * liefert die ID eines Types
     *
     * @param mixed $value ID oder Name des Types
     *
     * @return boolean|integer FALSE, wenn die Sparte nicht existiert,
     *                         ansonsten die ID der Sparte
     * @access protected
     */
    public function getId($value = null)
    {
        if (empty($value)) {
            //type id in wrong format
            return false;
        }

        if (!is_string($value) && !is_numeric($value)) {
            //type id in wrong format
            return false;
        }

        if (is_numeric($value) && 0 >= (int) $value) {
            return false;
        }

        $select = $this->select();
        $select->from(
            array('t' => $this->_name),
            array('id' => 'id_type')
        );
        if (is_numeric($value)) {
            $select->where('t.id_type = ?', (int) $value);
        } else {
            $value = ucfirst(strtolower((string) $value));
            $select->where('t.name = ?', $value);
        }

        $row = $this->fetchAll($select)->current();

        if (is_object($row)
            && isset($row->id)
            && 0 < (int) $row->id
        ) {
            return (int) $row->id;
        } else {
            return false;
        }
    }
}