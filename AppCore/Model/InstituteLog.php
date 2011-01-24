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
 * @version   SVN: $Id: InstituteLog.php 30 2011-01-06 21:58:02Z tmu $
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
    protected $_name = 'institute_for_log';

    /**
     * Primary key
     *
     * @var String
     */
    protected $_primary = 'kli_id';

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
            array('id' => 'kli_id')
        );
        if (is_numeric($value)) {
            $select->where('i.kli_id = ?', (int) $value);
        } else {
            $value = ucfirst(strtolower((string) $value));
            $select->where('i.kli_name = ?', $value);
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