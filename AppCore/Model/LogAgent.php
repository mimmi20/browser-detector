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
 * @version   SVN: $Id: LogAgent.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * Model
 *
 * @category  Kreditrechner
 * @package   Models
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class LogAgent extends ModelAbstract
{
    /**
     * Table name
     *
     * @var String
     */
    protected $_name = 'log_agent';

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
     * @return array
     */
    public function getCalculationSource(
        $expression,
        $timespan = '',
        array $group = array(),
        array $order = array(),
        array $fields = array(),
        $campaigns = '',
        $where = null,
        $groupset = '',
        $dateStart = '',
        $dateEnd = ''
    )
    {
        $select = $this->select()->setIntegrityCheck(false);

        $fields[] = new \Zend\Db\Expr($expression);
        $fields[] = new \Zend\Db\Expr($timespan);

        $select->from(
            array('la' => $this->_name),
            array()
        );

        if ($dateStart != '' && $dateEnd != '') {
            $select->where(
                new \Zend\Db\Expr(
                    '`la`.`zeit` BETWEEN \'' . $dateStart . '\' AND \'' .
                    $dateEnd . '\''
                )
            );
        }

        $select->join(
            array('b' => 'browser'),
            'b.browserId = la.browserId',
            array()
        );

        if ('-1' != $campaigns) {
            if ('' == $campaigns) {
                $campaigns = '-1';
            }

            $select->where('`la`.`id_campaign` IN (' . $campaigns . ')');
        }
        $select->where('`la`.`from` = \'C\'');

        if ($where !== null) {
            $select->where($where);
        }

        $select->columns(array_unique($fields));
        $select->group($group);
        $select->group($groupset);
        $select->order($order);

        return $select;
    }
}