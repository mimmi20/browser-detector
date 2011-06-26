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
class Acl extends ModelAbstract
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
     * Gibt eine Liste aller Rollen zurueck
     *
     * @param string $type the role type, possible values are 'Basis' or
     *                     'Benutzer'
     *
     * @return null|\Zend\Db\Table\Rowset Liste der Rollen
     */
    public function getRoles($type = null)
    {
        $select = $this->select()->setIntegrityCheck(false);

        $select->from(
            array('rol' => $this->_name),
            array('RolleId', 'name' => 'Name', 'rolletyp' => 'RolleTyp')
        );

        if (null !== $type) {
            if (in_array($type, array('Basis', 'Benutzer'))) {
                $select->where('rol.RolleTyp = ? ', $type);
            }
        }

        $select->where('rol.active = 1');

        $select->joinLeft(
            array('rxr' => 'rolle_x_rolle'),
            '(rxr.RolleId1 = rol.RolleId)',
            array()
        );
        $select->joinLeft(
            array('rxr_rol' => $this->_name),
            '((rxr.RolleId2 = rxr_rol.RolleId) AND (rxr_rol.active = 1))',
            array('elternrollen' =>
                new \Zend\Db\Expr('IFNULL(GROUP_CONCAT(rxr_rol.Name),"")'))
        );
        $select->group('rol.RolleId');
        try {
            return $this->fetchAll($select);
        } catch (Exception $e) {
            $this->_logger->err($e);

            return null;
        }
    }

    /**
     * Gibt alle Ressourcen inkl. Rollen zureck
     *
     * @return null|\Zend\Db\Table\Rowset Liste der Ressourcen mit den Rollen
     */
    public function getResourcesRoles()
    {
        $select = $this->select()->setIntegrityCheck(false);

        $select->from(
            array('res' => 'ressource'),
            array('ressource' => 'res.Name')
        )
            ->joinLeft(
                array('rxr' => 'ressource_x_rolle'),
                '((res.RessourceId = rxr.RessourceId) AND (res.active = 1))',
                array('recht' => 'Recht')
            )
            ->joinLeft(
                array('rol' => $this->_name),
                '((rol.RolleId = rxr.RolleId) AND (rol.active = 1))',
                array('rolle' => 'Name')
            )
            ->where('NOT rol.Name IS NULL');
        try {
            return $this->fetchAll($select);
        } catch (Exception $e) {
            $this->_logger->err($e);

            return null;
        }
    }

    /**
     * Gibt alle Ressourcen zurueck wo Rollen ausser SuperAdmin zugreifen
     * duerfen
     *
     * @return null|\Zend\Db\Table\Rowset
     */
    public function getAllowedRessources()
    {
        $select = $this->select()->setIntegrityCheck(false);

        $select->from(
            array('res' => 'ressource'),
            array('ressource' => 'res.Name')
        )
            ->joinLeft(
                array('rxr' => 'ressource_x_rolle'),
                '((res.RessourceId = rxr.RessourceId) AND (res.active = 1))',
                array()
            )
            ->joinLeft(
                array('rol' => $this->_name),
                '((rol.RolleId = rxr.RolleId) AND (rol.active = 1))',
                array('rollen' => 'GROUP_CONCAT(rol.Name)')
            )
            ->where('NOT rol.Name IS NULL')
            ->where('rol.Name != \'SuperAdmin\'')
            ->where('rxr.Recht = \'allow\'')
            ->group('res.Name');
        try {
            return $this->fetchAll($select);
        } catch (Exception $e) {
            $this->_logger->err($e);

            return null;
        }
    }

    /**
     * Gibt die Basis-Rollen einer Rolle zurueck
     *
     * @param string $rolename the name of the role to search
     *
     * @return null|\Zend\Db\Table\Rowset
     */
    public function getBaseRolesByRoleName($rolename = null)
    {
        if (empty($rolename) || !is_string($rolename)) {
            return null;
        }

        $select = $this->select()->setIntegrityCheck(false);

        $select->from(
            array('rol1' => $this->_name),
            array()
        )
            ->join(
                array('rxr' => 'rolle_x_rolle'),
                'rxr.RolleId1 = rol1.RolleId',
                array()
            )
            ->join(
                array('rol2' => $this->_name),
                'rol2.RolleId = rxr.RolleId2',
                array('name' => 'Name', 'RolleId')
            )
            ->where('rol1.Name = "' . $rolename . '"')
            ->where('rol1.active = 1')
            ->where('rol2.active = 1');
        try {
            return $this->fetchAll($select);
        } catch (Exception $e) {
            $this->_logger->err($e);

            return null;
        }
    }

    /**
     * Gibt die Rollen zurueck
     *
     * @param string $type the roletype
     *                     possible values are 'Basis' and 'TODO'
     *
     * @return null|\Zend\Db\Table\Rowset
     */
    public function getRolesList($type = 'Basis')
    {
        if (!is_string($type)) {
            return null;
        }

        $allowedTypes = array('Basis', 'Benutzer');

        if (!in_array($type, $allowedTypes)) {
            return null;
        }

        $select = $this->select()->setIntegrityCheck(false);

        $select->from(
            array('rol' => $this->_name),
            array('rol.Name', 'rol.RolleId')
        )
            ->joinLeft(
                array('rxr' => 'rolle_x_rolle'),
                '(rol.RolleId = rxr.RolleId1)',
                array()
            )
            ->where('rol.RolleTyp = ?', $type)
            ->group(array('rol.RolleId'))
            ->order(array('rol.Name'));

        try {
            return $this->fetchAll($select);
        } catch (Exception $e) {
            $this->_logger->err($e);

            return null;
        }
    }
}