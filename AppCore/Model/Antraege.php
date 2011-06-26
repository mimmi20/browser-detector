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
class Antraege extends ModelAbstract
{
    /**
     * Table name
     *
     * @var String
     */
    protected $_name = 'log_credits';

    /**
     * Primary key
     *
     * @var String
     */
    protected $_primary = 'knID';

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
        $campaigns = '',
        $sparte = '',
        $fields = array('alias' => 'portal', 'name' => 'portal'),
        $timespan = '',
        /*$groupset = '',*/
        $dateStartIso = '',
        $dateEndIso = '',
        $additionalWhere = ''
    )
    {
        $spartenModel = new \AppCore\Service\Sparten();
        $sparte       = $spartenModel->getName($sparte);

        $select = $this->select(false)->setIntegrityCheck(false);

        $select->from(
            array('lc' => 'log_credits'),
            array(
                new Zend_Db_Expr('COUNT(*) AS `count`'),
                new Zend_Db_Expr($timespan)
            )
        );

        $select->where('`lc`.`sparte` = ?', $sparte);

        $select->where(
            new Zend_Db_Expr(
                '`lc`.`date` BETWEEN \'' . $dateStartIso .
                '\' AND \'' . $dateEndIso . '\''
            )
        );

        $select->where('`lc`.`test` = 0');
        $select->where('((`lc`.`status` IS NULL) OR (`lc`.`status` = 99))');

        if (is_string($additionalWhere) && '' != $additionalWhere) {
            $select->where($additionalWhere);
        }

        if ('-1' != $campaigns) {
            if ('' == $campaigns) {
                $campaigns = '-1';
            }

            $campaignModel = new \AppCore\Service\Campaigns();

            $campaigns = explode(',', $campaigns);
            $campaignNames = array();

            foreach ($campaigns as $campaignId) {
                $campaignName = $campaignModel->getShortName($campaignId);

                if ($campaignName) {
                    $campaignNames[] = $campaignName;
                }

                /*
                 * @TODO: convert this information when the old calculator is
                 * switched off
                 *
                 * required to show the requests from the old calculator
                 */
                $campaignName = $campaignModel->getPortalName($campaignId);

                if ($campaignName) {
                    $campaignNames[] = $campaignName;
                }
            }

            $select->where('`lc`.`portal` IN (\'' . implode('\',\'', $campaignNames) . '\')');
        }

        $select->columns(
            $fields
        );

        return $select;
    }
}