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
class StatEinfach extends ModelAbstract
{
    /**
     * Table name
     *
     * @var String
     */
    protected $_name = 'stat_einfach';

    /**
     * Primary key
     *
     * @var String
     */
    protected $_primary = 'uid';

    /**
     * calculates the summary for statistics
     *
     * @param string  $expression an sql expession for the 'count'-column
     * @param string  $sparte     the name for the sparte
     * @param string  $type       the type of logging
     * @param integer $summary    the kind of information
     * @param string  $campaigns  a comma separated list of campaign ids
     *
     * @return Zend_Db_Table_Select
     */
    public function getCalculationSource(
        $expression,
        $campaigns = '',
        $sparte = '',
        $type = '',
        $fields = array('alias' => 'portal', 'name' => 'portal'),
        $timespan = '',
        $groupset = '',
        $dateStartIso = '',
        $dateEndIso = '',
        $additionalWhere = ''
    )
    {
        $spartenModel = new \AppCore\Service\Sparten();
        $sparte       = $spartenModel->getId($sparte);

        //$typeModel = new \AppCore\Model\Types();
        //$type      = $typeModel->getId($type);

        $select = $this->select(false)->setIntegrityCheck(false);

        $select->from(
            array('se' => 'stat_einfach'),
            array(
                new \Zend\Db\Expr($expression),
                new \Zend\Db\Expr($timespan)
            )
        );

        $select->where('`se`.`s_id` = ?', $sparte);

        $select->where(
            new \Zend\Db\Expr(
                '`se`.`datum` BETWEEN \'' . $dateStartIso .
                '\' AND \'' . $dateEndIso . '\''
            )
        );

        //$this->_logger->info($select->assemble());

        $select->join(
            array('t' => 'types'),
            '`t`.`id_type` = `se`.`id_type`',
            array()
        );

        $this->_concatTypeFilter($select, $type);

        $select->join(
            array('i' => 'institute_for_log'),
            '`i`.`kli_id` = `se`.`kli_id`',
            array()
        );

        $select->where('`i`.`isSpider` = 0');
        $select->where('`i`.`isInactive` = 0');

        if (is_string($additionalWhere) && '' != $additionalWhere) {
            $select->where($additionalWhere);
        }

        $select->join(
            array('ca' => 'campaigns'),
            '`ca`.`id_campaign` = `se`.`id_campaign`',
            array()
        );

        if ('-1' != $campaigns) {
            if ('' == $campaigns) {
                $campaigns = '-1';
            }
            $select->where('`ca`.`id_campaign` IN (' . $campaigns . ')');
        }

        $select->join(
            array('s' => 'sparten'),
            '`s`.`s_id` = `se`.`s_id`',
            array()
        );

        $select->joinLeft(
            array('ii' => 'institute'),
            '`i`.`ki_id` = `ii`.`ki_id`',
            array()
        );

        $this->_concatInstituteFilter($select, $type);

        $select->columns(
            $fields
        );

        return $select;
    }

    /**
     * Add Date Filter Expression to Query
     *
     * @param Zend_Db_Select $select a sql query object
     * @param string         $type   one kind of type
     *
     * @return \\AppCore\\Model\StatEinfach
     */
    private function _concatTypeFilter(Zend_Db_Select $select, $type)
    {
        //$select->where("`a`.`type` like '$type%'");

        switch ($type) {
            case 'sale':
                // Break intentionally omitted
            case 'pageimpression':
                // Break intentionally omitted
            case 'info':
                $select->where('`t`.`name` = \'' . $type . '\'');
                break;
            case 'clickout':
                // Break intentionally omitted
            case 'clickoutsale':
                $select->where(
                    "(`t`.`name` like 'clickout%' OR `t`.`name` IN " .
                    "('antrag2','antrag3'))"
                );
                break;
            case 'antrag':
                $select->where("`t`.`name` like 'antrag%'");
                $select->where("`t`.`name` NOT IN ('antrag2','antrag3')");
                break;
            default:
                // nothing to do here
                break;
        }

        return $this;
    }

    /**
     * Add Date Filter Expression to Query
     *
     * @param Zend_Db_Select $select a sql query object
     * @param string         $type   one kind of type
     *
     * @return \\AppCore\\Model\StatEinfach
     */
    private function _concatInstituteFilter(Zend_Db_Select $select, $type)
    {
        //$select->where("`a`.`type` like '$type%'");

        switch ($type) {
            case 'sale':
                // Break intentionally omitted
            case 'clickout':
                // Break intentionally omitted
            case 'clickoutsale':
                // Break intentionally omitted
            case 'antrag':
                // Break intentionally omitted
            case 'info':
                $select->where('`ii`.`ki_id` IS NOT NULL');
                break;
            default:
                // nothing to do here
                break;
        }

        return $this;
    }
}