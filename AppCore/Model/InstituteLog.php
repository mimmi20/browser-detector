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
 * @version   SVN: $Id$
 */

/**
 * Model
 *
 * @category  Kreditrechner
 * @package   Models
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class InstituteLog extends ModelAbstract
{
    /**
     * Table name
     *
     * @var String
     */
    protected $_name = 'institutesForLog';

    /**
     * Primary key
     *
     * @var String
     */
    protected $_primary = 'idInstitutesForLog';

    /**
     * liefert die ID eines Types
     *
     * @param mixed $value ID oder Name des Types
     *
     * @return boolean|integer FALSE, wenn die Sparte nicht existiert,
     *                         ansonsten die ID der Sparte
     * @access protected
     */
    public function getId($value)
    {
        if (!is_string($value) && !is_numeric($value)) {
            return false;
        }

        if (is_numeric($value) && 0 >= (int) $value) {
            return false;
        }

        $select = $this->select();
        $select->from(
            array('i' => $this->_name),
            array('id' => 'i.idInstitutesForLog')
        );
        if (is_numeric($value)) {
            $select->where('i.idInstitutesForLog = ?', (int) $value);
        } else {
            $value = ucfirst(strtolower((string) $value));
            $select->where('i.name = ?', $value);
        }
        $select->limit(1);

        $row = $this->fetchAll($select)->current();

        if (is_object($row) && 0 < (int) $row->id) {
            return (int) $row->id;
        } else {
            return false;
        }
    }

    /**
     * returns the Color for a given Institute
     *
     * @param integer $kiId the Institute ID
     *
     * @return string the color
     * @access public
     */
    public function getInstituteColor($kiId)
    {
        $institut = new \AppCore\Service\Institute();

        return $institut->getColor($kiId);
    }
}