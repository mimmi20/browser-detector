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
class GeodbName extends ModelAbstract
{
    /**
     * Table name
     *
     * @var String
     */
    protected $_name = 'geodb_namen';

    /**
     * Primary key
     *
     * @var String
     */
    protected $_primary = 'nameId';

    /**
     * get a list of cities for an (maybe partly) given name and a postcode
     *
     * @param string $name the name
     * @param string $plz  the postcode
     *
     * @return array
     */
    public function getNamesByPlz($name, $plz)
    {
        if (!is_string($name) || !is_string($plz)) {
            return array();
        }

        $plz = substr((string) $plz, 0, 5);

        $select = $this->select()->setIntegrityCheck(false);
        $select->from(
            array('nametab' => $this->_name),
            array('name' => 'nametab.text_val')
        )
            ->join(
                array('plztab' => 'geodb_plz'),
                'plztab.loc_id=nametab.loc_id',
                array()
            )
            ->where('plztab.text_val = ?', $plz);

        if (strlen($name) > 0) {
            $select->where(
                //utf-8 für Namen erzwingen
                new \Zend\Db\Expr(
                    'nametab.text_val like _utf8\'' . $name . '%\''
                )
            );
        }

        $select->order(array('plztab.text_val', 'nametab.text_val'))
            ->limit(50);

        $rows = $this->fetchAll($select);

        $data = array();
        foreach ($rows as $row) {
            $data[] = array(
                'name' => $this->_encode($row->name)
            );
        }

        return $data;
    }

    /**
     * encodes an value from iso to utf-8
     *
     * @param string  $item     the string to decode
     * @param boolean $entities (Optional) an flag,
     *                          if TRUE the string will be encoded with
     *                          html_entitiy_decode
     *
     * @return string
     */
    private function _encode($item, $entities = true)
    {
        return \AppCore\Globals::encode($item, $entities);
    }
}