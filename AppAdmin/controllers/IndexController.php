<?php
/**
 * Standart-Controller für das Backend
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Controller
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: IndexController.php 30 2011-01-06 21:58:02Z tmu $
 */

/**
 * Standart-Controller für das Backend
 *
 * @category  Kreditrechner
 * @package   Controller
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class KreditAdmin_IndexController extends KreditCore_Controller_AdminAbstract
{
    /**
     * Standart-Action für das Backend
     *
     * @return void
     */
    public function indexAction()
    {
        //do nothing here
    }

    /**
     * Action zum Erstellen eines Dataset, genutzt für die Unittests
     *
     * @return void
     * @deprecated
     */
    public function createDatasetAction()
    {
        ini_set('max_execution_time', 240);
        $this->_helper->viewRenderer->setNoRender();

        $sql      = 'SELECT `TABLE_NAME` AS `tableName`
                     FROM `information_schema`.`TABLES`
                     WHERE `TABLE_SCHEMA` = \'kredit_geld_de\'';
        $sqlTwo   = 'SELECT `COLUMN_NAME` AS `columnName`
                     FROM `information_schema`.`COLUMNS`
                     WHERE `TABLE_SCHEMA` = \'kredit_geld_de\' AND
                     `TABLE_NAME`=:table';

        $db = \Zend\Db\Db::factory(
            'Pdo_Mysql',
            array(
                'host'     => '192.168.20.103',
                'username' => 'finance',
                'password' => 'finance',
                'dbname'   => 'information_schema'
            )
        );

        $rows = $db->query($sql);

        $doNotRender = array(
            '__tmp_table_products',
            'agents2',
            'agents_backup',
            'zinsHistory_new',
            'zins_new',
            'zinsen_new',
            'users',
            'vers',
            'tarife_festgeld_urls',
            'tarife_girokonten_urls',
            'tarife_kredite',
            'tarife_kredite_zins',
            'tarife_tagesgeld_urls',
            'system_tracking_config',
            'pages',
            'peoples'
        );

        $parseColumns = array(
            'bearbeiter',
            'campaigns',
            'eventtype',
            'institute',
            'interfaces_types',
            'laufzeiten',
            'laufzeit_sparte',
            'navigation',
            'portale',
            'produkt_components',
            'produkte',
            'ressource',
            'ressource_x_rolle',
            'roletype',
            'rolle',
            'rolle_x_rolle',
            'sparten',
            'statustype',
            'types',
            'urls',
            'verwendung',
            'zins',
            'zinsen'
        );

        $filename = DATA_PATH . '/data.xml';
        $content  = '<?xml version="1.0" encoding="UTF-8"?>
<dataset>';

        $stmt      = new \Zend\Db\Statement\Pdo($db, $sqlTwo);
        //$stmtThree = new \Zend\Db\Statement\Pdo($this->_db, $sqlThree);

        foreach ($rows as $row) {
            $tableName = $row['tableName'];

            if (!in_array($tableName, $doNotRender)) {
                $content .= '
    <table name="' . $tableName . '">';

                //

                $stmt->execute(array(':table' => $tableName));
                $rowsTwo = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                $cols = array();

                foreach ($rowsTwo as $rowTwo) {
                    $columnName = $rowTwo['columnName'];

                    $cols[] = $columnName;

                    $content .= '
        <column>' . $columnName . '</column>';
                }

                if (in_array($tableName, $parseColumns)) {
                    $colsSerial = implode(',', $cols);

                    $rowsThree = array();

                    $rowsThree = $this->_db->query(
                        'SELECT ' . $colsSerial . ' FROM ' . $tableName
                    );

                    foreach ($rowsThree as $rowThree) {

                        $content .= '

        <row>';
                        //

                        foreach ($cols as $columnName) {
                            $value = $rowThree->$columnName;

                            if (null === $value) {
                                $content .= '
            <null/>';
                            } else {
                                $from = array('&uuml;', '<', '>', '&');
                                $to = array('ü', '&lt;', '&gt;', '&amp;');

                                $value = str_replace($from, $to, $value);


                                $content .= '
            <value>' . utf8_encode($value) . '</value>';
                            }
                        }

                        $content .= '
        </row>';
                    }
                }

                $content .= '
    </table>';
            }
        }

        $content .= '
</dataset>';

        $f = fopen($filename, 'w');
        fwrite($f, $content);
        fclose($f);

        $this->_redirector->gotoSimple(
            'index',
            'index',
            'kredit-admin'
        );
    }
}