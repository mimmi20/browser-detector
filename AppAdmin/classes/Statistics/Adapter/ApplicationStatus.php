<?php
/**
 * Klasse zum Erstellen der Statistik
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Statistics
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: ApplicationStatus.php 30 2011-01-06 21:58:02Z tmu $
 * @deprecated
 */

/**
 * Klasse zum Erstellen der Statistik
 *
 * @category  Kreditrechner
 * @package   Statistics
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class KreditAdmin_Class_Statistics_Adapter_ApplicationStatus
    extends KreditAdmin_Class_StatisticsAbstract
{
    /**
     * calculates the details for statistics
     *
     * @param string  $sparte    the name for the sparte
     * @param string  $type      the type of logging
     * @param integer $summary   the kind of information
     * @param string  $campaigns a comma separated list of campaign ids
     * @param string  $datum     a date in the ISO format
     * @param string  $paid      the code name for the portal
     *
     * @return array
     */
    public function calculateDetail(
        $sparte = 'Kredit',
        $type = 'click',
        $summary = 0,
        $campaigns = '',
        $datum = '',
        $paid = '')
    {
        /*
        if (is_numeric($sparte)) {
            $spartenModel = new \AppCore\Model\Sparten();
            $sparte       = $spartenModel->getName($sparte);
        }
        */

        $additionalWhere = '';
        if ($type == 'clickoutsale') {
            $additionalWhere .= '`i`.`isInternal` = 1';
        } elseif ($type == 'clickout') {
            $additionalWhere .= '`i`.`isInternal` = 0';
        }

        $expression = $this->_getExpression($summary);
        $field      = 'portal';

        $model  = new \AppCore\Model\StatEinfach();
        $select = $model->getCalculationSource(
            $expression,
            $campaigns,
            $sparte,
            $type,
            array($field => 'ca.p_name'),
            $this->_filter->getGroupSet()->getTimespanExpression(),
            $this->_filter->getGroupSet()->getGroupExpression(),
            $this->_filter->getDateStartIso(),
            $this->_filter->getDateEndIso(),
            $additionalWhere
        );

        $select->where('`se`.`datum` like \'' . $datum . '%\'');
        $select->where('`ca`.`p_name` = ?', $paid);

        /*
        if ($type == 'clickoutsale') {
            $select->where('ifl.isInternal = 1');
        } elseif ($type == 'clickout') {
            $select->where('ifl.isInternal = 0');
        }

        $select->where('ifl.ki_id IS NOT NULL');
        */

        $select->group('ii.ki_name');
        $select->order(new \Zend\Db\Expr('`count` DESC'));

        $this->concatGroupFilter($select);

        $select->order(array('timespan', $field));

        return $this->processQueryDetail($select);
    }

    /**
     * @param integer $summary
     *
     * @return string
     */
    private function _getExpression($summary)
    {
        switch ($summary) {
            case 1:
                $expression = 'IFNULL(SUM(`se`.`sum`), 0) as `count`';
                break;
            case 4:
                $expression = 'CASE WHEN SUM(`se`.`anzahl`) IS NULL OR
                                         SUM(`se`.`anzahl`) = 0 THEN 0
                                    WHEN SUM(`se`.`sum`)/SUM(`se`.`anzahl`)
                                    IS NULL THEN 0
                                    ELSE SUM(`se`.`sum`)/SUM(`se`.`anzahl`)
                               END AS `count`';
                break;
            case 2:
                $expression = 'CASE WHEN SUM(`se`.`anzahl`) IS NULL OR
                                         SUM(`se`.`anzahl`) = 0 THEN 0
                                    WHEN SUM(`se`.`lz`)/SUM(`se`.`anzahl`)
                                    IS NULL THEN 0
                                    ELSE SUM(`se`.`lz`)/SUM(`se`.`anzahl`)
                               END AS `count`';
                break;
            case 3:
                $expression = 'IFNULL(SUM(`se`.`pr`), 0) as `count`';
                break;
            default:
                $expression = 'IFNULL(SUM(`se`.`anzahl`), 0) as `count`';
                break;
        }

        return $expression;
    }

    /**
     * Encode ResultSet for the View
     *
     * @param array   $result ??
     * @param integer $type   ??
     *
     * @return Json
     */
    public function createTable(
        array $result,
        $percent = false,
        $format = true,
        $summeAnz = true,
        $grafisch = false,
        $expression = '')
    {
        return parent::createTableWithPercent(
            $result,
            $percent,
            $format,
            $summeAnz,
            $grafisch,
            $expression
        );
    }
}