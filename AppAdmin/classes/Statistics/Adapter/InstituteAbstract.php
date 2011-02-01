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
 * @version   SVN: $Id$
 */

/**
 * Klasse zum Erstellen der Statistik
 *
 * @category  Kreditrechner
 * @package   Statistics
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @abstract
 */
abstract class KreditAdmin_Class_Statistics_Adapter_InstituteAbstract
    extends KreditAdmin_Class_StatisticsAbstract
{
    /**
     * calculates the summary for statistics
     *
     * @param string  $expression an sql expession for the 'count'-column
     * @param integer $sparte     the id for the sparte
     * @param string  $type       the type of logging
     * @param integer $summary    the kind of information
     * @param string  $campaigns  a comma separated list of campaign ids
     *
     * @return array
     */
    protected function calculateInstitute(
        $expression, $sparte = 1, $type = 'click', $summary = 0,
        $campaigns = '')
    {
        /*
        if (is_numeric($sparte)) {
            $spartenModel = new \AppCore\Model\Sparten();
            $sparte       = $spartenModel->getName($sparte);
        }
        /**/

        $additionalWhere = '';
        if ($type == 'clickoutsale') {
            $additionalWhere = '`i`.`isInternal` = 1';
        } elseif ($type == 'clickout') {
            $additionalWhere = '`i`.`isInternal` = 0';
        }

        $field = 'institute';

        $model  = new \AppCore\Model\StatEinfach();
        $select = $model->getCalculationSource(
            $expression,
            $campaigns,
            $sparte,
            $type,
            array(
                $field  => new \Zend\Db\Expr("ifnull(`ii`.`ki_name`,'')"),
                'color' => new \Zend\Db\Expr("ifnull(`ii`.`color`,'ccc')")
            ),
            $this->_filter->getGroupSet()->getTimespanExpression(),
            $this->_filter->getGroupSet()->getGroupExpression(),
            $this->_filter->getDateStartIso(),
            $this->_filter->getDateEndIso(),
            $additionalWhere
        );

        $this->concatGroupFilter($select, $field);

        $select->order(array('timespan', $field));

        //$this->_logger->info($select->assemble());

        return $this->processQuery(
            $select, $field, $type, $sparte, $summary, $expression,
            $campaigns, 2
        );
    }

    /**
     * Encode ResultSet for the View
     *
     * @param array   $result ??
     *
     * @return Json
     */
    public function createTable(
        array $result,
        $format = true,
        $summeAnz = true,
        $grafisch = false,
        $expression = ''
    )
    {
        return parent::createTableWithPercent(
            $result, false, $format, $summeAnz, $grafisch, $expression
        );
    }
}