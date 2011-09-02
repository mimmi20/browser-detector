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
abstract class KreditAdmin_Class_Statistics_Adapter_AgentAbstract
    extends KreditAdmin_Class_StatisticsAbstract
{
    /**
     * calculates the summary for user agents for statistics
     *
     * @param string  $sparte    the name for the sparte
     * @param string  $type      the type of logging
     * @param integer $summary   the kind of information
     * @param string  $campaigns a comma separated list of campaign ids
     *
     * @return array
     */
    protected function calculateAgent(
        $expression,
        array $group = array(),
        array $order = array(),
        array $fields = array(),
        $sparte = 'Kredit',
        $campaigns = '',
        $where = null
    )
    {
        if (is_numeric($sparte)) {
            $categoriesModel = new \App\Model\Sparten();
            $sparte       = $categoriesModel->getName($sparte);
        }

        $model = new \App\Model\LogAgent();
        $dateStart = $this->_filter->getDateStartIso();
        $dateEnd   = $this->_filter->getDateEndIso();

        $fields[] = new \Zend\Db\Expr($expression);
        $fields[] = $this->_filter->getGroupSet()->getTimespanExpression('la');

        $select = $model->getCalculationSource(
            $expression,
            $this->_filter->getGroupSet()->getTimespanExpression('la'),
            $group,
            $order,
            $fields,
            $campaigns,
            $where,
            $this->_filter->getGroupSet()->getGroupExpression('la'),
            $dateStart,
            $dateEnd
        );

        //$this->concatDateFilter($select);

        return $this->processQuery($select, 'browser', $campaigns, 1);
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
        $expression = '';
        $format     = false;
        $summeAnz   = true;
        $grafisch   = true;

        return parent::createTableWithPercent(
            $result, false, $format, $summeAnz, $grafisch, $expression
        );
    }
}