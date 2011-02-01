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
class Navigation extends ModelAbstract
{
    /**
     * Table name
     *
     * @var String
     */
    protected $_name = 'navigation';

    /**
     * Primary key
     *
     * @var String
     */
    protected $_primary = 'NavigationId';

    /**
     * creates the Navigation Menu or a sub menu
     *
     * @param integer $resourceId the id for the connected resource
     * @param integer $parentId   the id of the parent navigation point or
     *                            zero if no parent exists
     *
     * @return null|\Zend\Db\Table\Rowset
     * @access public
     */
    public function getNavigation($resourceId, $parentId = 0)
    {
        $select = $this->select()->setIntegrityCheck(false);

        $select->from(
            array('n' => $this->_name),
            array(
                'nav_name' => 'Name',
                'nav_id' => 'NavigationId',
                'parent_id' => 'Navigation_Id',
                'resource_id' => 'RessourceId'
            )
        );
        $select->join(
            array('res' => 'ressource'),
            '((`res`.`RessourceId` = `n`.`RessourceId`) AND
            ' . (($parentId == 0) ? '(`n`.`Navigation_Id` = 0 OR
            `n`.`Navigation_Id` IS NULL)' : '(`n`.`Navigation_Id` = ' .
            $parentId . ')') . ' AND (`n`.`active` = 1))',
            array(
                'res_name'       => 'Name',
                'res_controller' => 'Controller',
                'res_action'     => 'Action'
            )
        );
        $select->join(
            array('rr' => 'ressource_x_rolle'),
            '((`res`.`RessourceId` = `rr`.`RessourceId`) AND
              (`rr`.`Recht` = \'allow\') AND
              (`rr`.`RolleId` IN (' . ((is_array($resourceId))
                                    ? implode(',', $resourceId)
                                    : $resourceId) . ')))',
            array()
        );
        $select->join(
            array('r' => 'rolle'),
            '((`rr`.`RolleId` = `r`.`RolleId`) AND (`r`.`active` = 1))',
            array()
        );
        $select->distinct();
        $select->order(array('n.Navigation_Id', 'n.Reihenfolge'));
        try {
            $result = $this->fetchAll($select);
            return $result;
        } catch (Exception $e) {
            $this->_logger->err($e);

            return null;
        }
    }
}