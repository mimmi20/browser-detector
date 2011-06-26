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
abstract class KreditAdmin_Class_Statistics_Adapter_CampaignAbstract
    extends KreditAdmin_Class_StatisticsAbstract
{
    /**
     * calculates the quotes for statistics
     *
     * @param integer $sparte    the id for the sparte
     * @param string  $type      the type of logging
     * @param integer $summary   the kind of information
     * @param string  $campaigns a comma separated list of campaign ids
     *
     * @return array
     */
    public function quote(
        $sparte = 1, $type = 'clickout', $summary = 0, $campaigns = '')
    {
        if ($type == 'sale') {
            $cType = 'clickout';
        } else {
            $cType = 'pageimpression';
        }
        $clicks  = $this->calculate($sparte, $cType, $summary, $campaigns);
        $details = $this->calculate($sparte, $type, $summary, $campaigns);

        $quote = array();

        foreach ($details as $partner => $detail) {
            $detailData = $detail['data'];

            foreach ($detailData as $timestamp => $dCount) {
                $q = 0.0;

                if (isset($clicks[$partner]['data'][$timestamp])
                    && $clicks[$partner]['data'][$timestamp] > 0
                ) {

                    $cCount = $clicks[$partner]['data'][$timestamp];

                    if ($cCount > 0) {
                        $q = $dCount / $cCount;
                    }
                }

                $quote[$partner]['data'][$timestamp] = $q;
            }

            $quote[$partner]['name']   = ((isset($detail['name']))
                                       ? $detail['name']
                                       : '');
            $quote[$partner]['color']  = ((isset($detail['color']))
                                       ? $detail['color']
                                       : 'ddd');
            $quote[$partner]['parent'] = ((isset($detail['parent']))
                                       ? $detail['parent']
                                       : '');
        }

        return $quote;
    }
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
    protected function calculateCampaign(
        $expression, $sparte = 1, $type = 'click', $campaigns = '')
    {
        /*
        if (is_numeric($sparte)) {
            $categoriesModel = new \AppCore\Model\Sparten();
            $sparte       = $categoriesModel->getName($sparte);
        }
        */

        $field = 'portal';

        $model  = new \AppCore\Model\StatEinfach();
        $select = $model->getCalculationSource(
            $expression,
            $campaigns,
            $sparte,
            $type,
            array(
                $field => new \Zend\Db\Expr("ifnull(`ca`.`name`,'')")
            ),
            $this->_filter->getGroupSet()->getTimespanExpression(),
            $this->_filter->getGroupSet()->getGroupExpression(),
            $this->_filter->getDateStartIso(),
            $this->_filter->getDateEndIso()
        );

        $this->concatGroupFilter($select, $field);

        $select->order(array('timespan', $field));

        return $this->processQuery($select, $field, $campaigns, 0);
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