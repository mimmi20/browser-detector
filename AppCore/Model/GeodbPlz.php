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
 * @version   SVN: $Id: GeodbPlz.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * Model
 *
 * @category  Kreditrechner
 * @package   Models
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class GeodbPlz extends ModelAbstract
{
    /**
     * Table name
     *
     * @var String
     */
    protected $_name = 'geodb_plz';

    /**
     * Primary key
     *
     * @var String
     */
    protected $_primary = 'plzId';

    /**
     * get a list of postcodes and cities for an (maybe partly) given postcode
     *
     * @param string $plz the postcode
     *
     * @return array
     */
    public function getPlzNames($plz)
    {
        if (!is_string($plz)) {
            return array();
        }

        $plz = substr((string) $plz, 0, 5);

        $select = $this->select()->setIntegrityCheck(false);
        $select->from(
            array('plztab' => $this->_name),
            array('plz' => 'plztab.text_val')
        )
            ->join(
                array('nametab' => 'geodb_namen'),
                'plztab.loc_id=nametab.loc_id',
                array('name' => 'nametab.text_val')
            );

        if (strlen($plz) > 0) {
            $select->where(
                //utf-8 für Namen erzwingen
                new \Zend\Db\Expr('plztab.text_val like \'' . $plz . '%\'')
            );
        }

        $select->order(array('plztab.text_val', 'nametab.text_val'))
            ->limit(50);

        $rows = $this->fetchAll($select);

        $data = array();
        foreach ($rows as $row) {
            $data[] = array(
                'id'   => $this->_decode($row->plz, false),
                'name' => $this->_decode($row->name, true)
            );
        }

        return $data;
    }

    /**
     * decodes an value from utf-8 to iso
     *
     * @param string  $item     the string to decode
     * @param boolean $entities an flag,
     *                          if TRUE the string will be encoded with
     *                          htmlentities
     *
     * @return string
     */
    private function _decode($item, $entities = true)
    {
        return \AppCore\Globals::decode($item, $entities);
    }
}