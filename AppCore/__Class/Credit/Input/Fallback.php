<?php
/**
 * Controller-Klasse zum Ausliefern von Javascript-Dateien
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Credit
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: Fallback.php 4258 2010-12-15 16:22:14Z t.mueller $
 */

/**
 * Controller-Klasse zum Ausliefern von Javascript-Dateien
 *
 * @category  Kreditrechner
 * @package   Credit
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class \Credit\Core\Credit\Input_Fallback
    extends \Credit\Core\Credit\Input_Abstract
{
    private $_now = null;

    private $_tempTableProducts = '__tmp_table_products';
    private $_tempTableUrls     = '__tmp_table_urlUpdates';

    private $_dbConfig = null;

    /**
     * the class contructor
     *
     * @return \Credit\Core\Credit\Input_Fallback
     */
    public function __construct()
    {
        parent::__construct();

        $this->_now      = date('Y-m-d');
        $this->_dbConfig = $this->_db->getConfig();
    }

    /**
     * calculates the credit results
     *
     * @return array|boolean the result array or FALSE if an error occured
     * @access public
     */
    public function calculate()
    {
        $isKredit = false;

        if (is_numeric($this->_sparte) && $this->_sparte == 1) {
            $isKredit = true;
        } elseif (strtolower($this->_sparte) == 'kredit') {
            $isKredit = true;
        }

        $campaignModel = new \Credit\Core\Service\Campaigns();
        $campaign      = $campaignModel->find($this->_caid)->current();

        /*
         * no campaign
         * ->no results
         */
        if (!is_object($campaign)
            || '\Zend\Db\Table\Row' != get_class($campaign)
        ) {
            return array();
        }

        $defaultCampaign = $campaignModel->getDefaultCampaign($this->_caid);

        $this->_createTables();
        $this->_fillTables($campaign, $defaultCampaign);
        $this->_updateRows((int) $defaultCampaign->id_campaign);
        $this->_updateTeasers();
        $this->_deleteWithoutUrl();

        return $this->getRows();
    }

    /**
     * creates the temporary Table
     *
     * @return \Credit\Core\Credit\Input_Fallback
     */
    private function _createTables()
    {
        /*
         * sqlite does not support temparary tables
         */
        if ('pdo_sqlite' == $this->_dbConfig['type']) {
            $temporary    = ''; //SQLite does not support temporary tables
            $integer      = 'INTEGER';
            $decimal      = 'DOUBLE'; //SQLite does not support DECIMAL fields
            $keys         = '';
            $engine       = ''; //SQLite does not support Engine
            $charset      = ''; //SQLite does not support Charset
        } else {
            $temporary    = 'TEMPORARY';
            $integer      = 'INT';
            $decimal      = 'DECIMAL(10,2)';
            $keys         = ',
                INDEX `product` (`product`),
                INDEX `unused` (`portal`, `product`),
                INDEX `todelete` (`teaser`, `url`),
                INDEX `ordering` (`teaser`, `effZins`, `ordering`, `portal`,
                                  `kreditInstitutTitle`)';
            $engine       = 'ENGINE = MEMORY';
            $charset      = 'DEFAULT CHARSET=latin1';
        }

        $query = 'DROP ' . $temporary . ' TABLE IF EXISTS `'
               . $this->_tempTableProducts . '`';
        $stmt  = new \Zend\Db\Statement\Pdo($this->_db, $query);
        $stmt->execute();

        $query = 'CREATE ' . $temporary . ' TABLE IF NOT EXISTS `'
               . $this->_tempTableProducts . '` (
                `uid` ' . $integer . ' AUTO_INCREMENT,
                `kreditInstitutTitle` VARCHAR(50) NOT NULL DEFAULT \'\',
                `kreditinstitut` VARCHAR(50) NOT NULL DEFAULT \'\',
                `product` ' . $integer . ' NOT NULL DEFAULT -1,
                `kreditName` VARCHAR(75) NOT NULL DEFAULT \'\',
                `kreditAnnahme` VARCHAR(26) NOT NULL DEFAULT \'60\',
                `kreditTestsieger` ' . $integer . ' NOT NULL DEFAULT 0,
                `kreditEntscheidung` VARCHAR(26) DEFAULT \'2 Tage\',
                `kreditEntscheidung_Sort` ' . $decimal . ' NOT NULL DEFAULT 99,
                `boni` ' . $integer . ' NOT NULL DEFAULT 0,
                `ordering` ' . $integer . ' NOT NULL DEFAULT 0,
                `zinsgutschrift` VARCHAR(20) NOT NULL DEFAULT \'j&auml;hrlich\',
                `anlagezeitraum` VARCHAR(75),
                `ecgeb` VARCHAR(75),
                `kreditkartengeb` VARCHAR(100),
                `kontofuehrung` VARCHAR(150),
                `effZins` ' . $decimal . ',
                `effZinsOben` ' . $decimal . ',
                `effZinsUnten` ' . $decimal . ',
                `zinssatzIsCleaned` ' . $integer . ' DEFAULT 0,
                `zinssatzCleaned` ' . $decimal . ',
                `effZinsN` ' . $decimal . ',
                `effZinsR` ' . $decimal . ',
                `showAb` ' . $integer . ' DEFAULT 1,
                `step` ' . $integer . ' DEFAULT 0,
                `min` ' . $integer . ' DEFAULT 0,
                `max` ' . $integer . ' DEFAULT 0,
                `monatlicheRate` ' . $decimal . ' DEFAULT 0,
                `gesamtKreditbetrag` ' . $decimal . ' DEFAULT 0,
                `kreditKosten` ' . $decimal . ' DEFAULT 0,
                `kostenErsterMonat` ' . $decimal . ' DEFAULT 0,
                `internal` ' . $integer . ' DEFAULT 0,
                `url` VARCHAR(255),
                `urlTeaser` VARCHAR(255),
                `pixel` VARCHAR(150),
                `teaser` ' . $integer . ' DEFAULT -1,
                `portal` ' . $integer . ' DEFAULT -1,
                `anzahl` ' . $integer . ' DEFAULT 0,
                `campaignId` ' . $integer . ' DEFAULT -1,
                `teaser_zone` VARCHAR(255) DEFAULT \'\',
                `infoAvailable` ' . $integer . ' DEFAULT 0,
                `usages` VARCHAR(255) DEFAULT \'\',
                PRIMARY KEY (`uid`)' . $keys . '
                )
                ' . $engine . ' ' . $charset . ';';

        try {
            $stmt  = new \Zend\Db\Statement\Pdo($this->_db, $query);
            $stmt->execute();
        } catch (\Zend\Db\Statement\Exception $e) {
            $this->_logger->err($e);

            return $this;
        }

        $query = 'DROP ' . $temporary . ' TABLE
                 IF EXISTS `__tmp_table_urlUpdates`';
        $stmt  = new \Zend\Db\Statement\Pdo($this->_db, $query);
        $stmt->execute();

        $query = 'CREATE ' . $temporary . ' TABLE
                 IF NOT EXISTS '
               . $this->_tempTableUrls . ' (
                `uid` ' . $integer . ' AUTO_INCREMENT,
                `product` ' . $integer . ' NOT NULL DEFAULT -1,
                `internal` ' . $integer . ' DEFAULT 0,
                `teaser` ' . $integer . ' DEFAULT -1,
                `url` VARCHAR(255),
                `urlTeaser` VARCHAR(255),
                `pixel` VARCHAR(150),
                `portal` VARCHAR(255),
                `campaignId` ' . $integer . ' DEFAULT -1,
                `teaserZone` VARCHAR(255) DEFAULT \'\',
                PRIMARY KEY (`uid`)
                )
                ' . $engine . ' ' . $charset . ';';

        try {
            $stmt  = new \Zend\Db\Statement\Pdo($this->_db, $query);
            $stmt->execute();
        } catch (\Zend\Db\Statement\Exception $e) {
            $this->_logger->err($e);
        }

        return $this;
    }

    /**
     * fills the temporary Table with initial data
     *
     * @param \Zend\Db\Table\Row $campaign
     *
     * @return \Credit\Core\Credit\Input_Fallback
     */
    private function _fillTables(\Zend\Db\Table\Row $campaign,
        \Zend\Db\Table\Row $defaultCampaign)
    {
        /*
         * create SQL to fill the tamporary table
         */
        $model  = new \Credit\Core\Model\Institute();
        $select = $model->select()->setIntegrityCheck(false);
        $select->from(
            array('i' => 'institute'),
            array(
                // Name der Bank
                'kreditInstitutTitle' => 'i.ki_title',
                // Code-Name der Bank
                'kreditinstitut' => 'i.ki_name'
            )
        );
        $select->where('i.ki_active = 1');

        $select->join(
            array('p' => 'produkte'),
            'i.ki_id = p.ki_id',
            array(
                // product id
                'product' => 'p.kp_id',
                // Annahmewahrscheinlichkeit
                'kreditAnnahme' => 'p.kp_annahme',
                // hat ein Testsieger-Bild? (ja/nein)
                'kreditTestsieger' => 'p.kp_testsieger',
                // Entscheidungszeitraum als String mit "Tage" am Ende bzw.
                // sofort
                'kreditEntscheidung' => 'p.kp_entscheidung',
                // Entscheidungszeitraum als Zahl fuer die Sortierung
                'kreditEntscheidung_Sort' => 'p.kp_entscheidung_sort',
                // bonitaetsabhaengig? (ja/nein)
                // Produkteinstellung kann vom Zinssatz ueberschrieben werden
                'boni' => new \Zend\Db\Expr(
                    '@boni := (CASE
                     WHEN z.boni IS NULL THEN p.kp_boni
                     WHEN z.boni > 0 THEN 1
                     ELSE 0 END)'
                ),
                // ordering
                'ordering' => 'p.kp_ordering',
                // Zeitraum der Zinsgutschrift als String ("jaehrlich")
                'zinsgutschrift' => 'p.kp_zinsgutschrift',
                'anlagezeitraum' => 'p.kp_anlagezeitraum',
                // Gebuehr fuer EC-Karte (fuer Girokonten)
                'ecgeb' => 'p.kp_ecgeb',
                // Gebuehr fuer Kreditkarte (fuer Girokonten)
                'kreditkartengeb' => 'p.kp_kreditkartengeb',
                // Gebuehr fuer Kontofuehrung (fuer Girokonten)
                'kontofuehrung' => 'p.kp_kontofuehrung',
                // minimaler Anlagebetrag
                'min' => new \Zend\Db\Expr('IFNULL(p.kp_rahmen_min, 0.0)'),
                // maximaler Anlagebetrag
                'max' => new \Zend\Db\Expr('IFNULL(p.kp_rahmen_max, 0.0)'),
                // the product has an info stored inside the database
                'infoAvailable' => new \Zend\Db\Expr(
                    'CASE
                     WHEN p.kp_info IS NULL THEN 0
                     WHEN CHAR_LENGTH(p.kp_info) > 0 THEN 1
                     ELSE 0 END'
                ),
                // erlaubte Verwendungszwecke als kommaseparierte Liste
                'usages' => 'p.kp_usages'
            )
        );
        $select->where('p.kp_active = 1');
        $select->where(
            '((p.kp_rahmen_min <= ' . (int) $this->_kreditbetrag . ') OR
              (p.kp_rahmen_min IS NULL))'
        );
        $select->where(
            '((p.kp_rahmen_max >= ' . (int) $this->_kreditbetrag . ') OR
              (p.kp_rahmen_max IS NULL))'
        );

        //$this->_logger->info($this->_boni);

        if (null !== $this->_boni) {
            $select->where('p.kp_boni = ' . (int) $this->_boni);
        }
        if (substr($campaign->p_name, -4) != 'test') {
            $select->where(
                'FIND_IN_SET(\'' . $this->_zweck . '\', p.kp_usages) ' .
                'IS NOT NULL'
            );
            $select->where(
                'FIND_IN_SET(\'' . $this->_zweck . '\', p.kp_usages) > 0'
            );
        }

        $select->join(
            array('pc' => 'produkt_components'),
            'p.kp_id = pc.kp_id',
            array(
                // Name des Produktes
                'kreditName' => 'pc.description'
            )
        );
        $select->where('pc.active = 1');

        $select->join(
            array('s' => 'sparten'),
            'pc.s_id = s.s_id',
            array()
        );
        $select->where('s.active = 1');
        $select->where('s.s_id = ' . (int) $this->_sparte);

        $select->join(
            array('z' => 'zins'),
            'pc.component_id = z.component_id',
            array(
                // effektiv-Zins
                'effZins' => 'z.zinssatz',
                // obere Grenze eines Zinsbandes
                'effZinsOben' => new \Zend\Db\Expr(
                    'CASE
                     WHEN @boni = 0 THEN z.zinssatz
                     WHEN z.showAb > 0            THEN z.zinssatz
                     WHEN z.zinssatzoben  IS NULL THEN z.zinssatz
                     WHEN z.zinssatzunten IS NULL THEN z.zinssatz
                     WHEN z.zinssatzoben >= z.zinssatzunten THEN z.zinssatzoben
                     ELSE z.zinssatzunten END'
                ),
                // untere Grenze eines Zinsbandes
                'effZinsUnten' => new \Zend\Db\Expr(
                    'CASE
                     WHEN @boni = 0 THEN z.zinssatz
                     WHEN z.showAb > 0            THEN z.zinssatz
                     WHEN z.zinssatzoben  IS NULL THEN z.zinssatz
                     WHEN z.zinssatzunten IS NULL THEN z.zinssatz
                     WHEN z.zinssatzoben >= z.zinssatzunten THEN z.zinssatzunten
                     ELSE z.zinssatzoben END'
                ),
                // bereinigter Zins
                'zinssatzCleaned' => 'z.zinssatz23',
                // Zinssatz ist bereinigt (ja / nein)
                'zinssatzIsCleaned' => new \Zend\Db\Expr(
                    'CASE WHEN z.zinssatz23 IS NULL THEN 0 ELSE 1 END'
                ),
                // negativer Zinssatz (fuer Girokonten)
                'effZinsN' => 'z.zinssatzN',
                // Rueckfallzins (fuer Festgeld/Tagesgeld)
                'effZinsR' => 'z.zinssatzR',
                // Anzeige von "ab .. %" anstelle von ".. - .. %" (ja / nein)
                'showAb' => new \Zend\Db\Expr(
                    'CASE WHEN @boni > 0 THEN z.showAb ELSE 0 END'
                ),
                // untere Betragsgrenze für den Zinssatz
                'step' => 'z.betrag'
            )
        );
        $select->where('z.active = 1');
        $select->where('z.laufzeit = ' . (int) $this->_laufzeit);

        $select->where(
            new \Zend\Db\Expr('(z.start IS NULL) OR (DATE(z.start) <= NOW())')
        );
        $select->where(
            new \Zend\Db\Expr('(z.end IS NULL) OR (DATE(z.end) >= NOW())')
        );

        $select->join(
            array('zi' => 'zinsen'),
            'z.uid = zi.uid_zins',
            array(
                'monatlicheRate' => new \Zend\Db\Expr(
                    'ROUND((@mr := ' . (int) $this->_kreditbetrag .
                    ' * zi.rate), 2)'
                ),
                'gesamtKreditbetrag' => new \Zend\Db\Expr(
                    'ROUND((@gkb := @mr * ' . (int) $this->_laufzeit . '), 2)'
                ),
                'kreditKosten' => new \Zend\Db\Expr(
                    'ROUND((@kk := @gkb - ' . (int) $this->_kreditbetrag .
                    '), 2)'
                ),
                'kostenErsterMonat' => new \Zend\Db\Expr(
                    'ROUND((@kk / ' . (int) $this->_laufzeit . '), 2)'
                )
            )
        );

        $campaignModel = new \Credit\Core\Model\Campaigns();
        $innerSelect   = $campaignModel->select()->setIntegrityCheck(false);
        $innerSelect->from(
            array('ca' => 'campaigns'),
            array(
                'anzahl' => new \Zend\Db\Expr('COUNT(*)'),
                'ca.id_campaign'
            )
        );
        $innerSelect->where('ca.active = 1');
        $innerSelect->where(
            '(ca.id_campaign IS NULL) OR ' .
            '(ca.id_campaign IN (2,' . (int) $defaultCampaign->id_campaign .
            ',' . (int) $this->_caid . '))'
        );

        $innerSelect->join(
            array('u' => 'urls'),
            'ca.id_campaign = u.id_campaign',
            array('u.kp_id')
        );
        if ($this->_teaseronly) {
            $innerSelect->where('u.tku_teaser = 1');
        }
        $innerSelect->group(array('u.kp_id', 'ca.p_name'));
        $innerSelect->order(array('u.kp_id', 'ca.p_name'));

        $select->joinLeft(
            array('pu' => $innerSelect),
            'p.kp_id = pu.kp_id',
            array(
                'anzahl' => 'pu.anzahl',
                'campaignId' => 'pu.id_campaign',
                'portal' => new \Zend\Db\Expr(
                    'CASE
                     WHEN pu.anzahl > 0 THEN pu.id_campaign
                     ELSE -1 END'
                )
            )
        );
        /*
         * do not add a where-condition to pu.campaign_id
         * ->
         * with this it is not possible to use the dafault campaign or the
         * general campaign as fallback for the actual camapign
         */

        $zinsModel  = new \Credit\Core\Model\Zins();
        $zinsSelect = $zinsModel->select()->setIntegrityCheck(false);
        $zinsSelect->from(
            array('zx' => 'zins'),
            array(new \Zend\Db\Expr('MAX(zx.betrag)'))
        );
        $zinsSelect->where('zx.kp_id = p.kp_id');
        $zinsSelect->where('zx.betrag <= ' . (int) $this->_kreditbetrag);
        $zinsSelect->where('zx.laufzeit = ' . (int) $this->_laufzeit);
        $zinsSelect->group('zx.kp_id');

        $select->where(
            new \Zend\Db\Expr('z.betrag = (' . $zinsSelect->assemble() . ')')
        );

        $query = 'INSERT INTO `' . $this->_tempTableProducts . '`
                  (`kreditInstitutTitle`,
                   `kreditinstitut`,
                   `product`,
                   `kreditAnnahme`,
                   `kreditTestsieger`,
                   `kreditEntscheidung`,
                   `kreditEntscheidung_Sort`,
                   `boni`,
                   `ordering`,
                   `zinsgutschrift`,
                   `anlagezeitraum`,
                   `ecgeb`,
                   `kreditkartengeb`,
                   `kontofuehrung`,
                   `min`,
                   `max`,
                   `infoAvailable`,
                   `usages`,
                   `kreditName`,
                   `effZins`,
                   `effZinsOben`,
                   `effZinsUnten`,
                   `zinssatzCleaned`,
                   `zinssatzIsCleaned`,
                   `effZinsN`,
                   `effZinsR`,
                   `showAb`,
                   `step`,
                   `monatlicheRate`,
                   `gesamtKreditbetrag`,
                   `kreditKosten`,
                   `kostenErsterMonat`,
                   `anzahl`,
                   `campaignId`,
                   `portal`
                  )
        ';

        if ((int) $this->_onlyproduct) {
            //nur das gewuenschte Produkt ausgeben
            if (strpos($this->_onlyproduct, ',') !== false) {
                $select->where('p.kp_id IN (' . $this->_onlyproduct . ')');
            } else {
                $select->where('p.kp_id = ' . $this->_onlyproduct);
            }
        } elseif ($this->_onlyinstitut) {
            //nur das gewuenschte Institut ausgeben
            $select->where('i.ki_name = \'' . $this->_onlyinstitut . '\'');
        }

        if ($this->_bestonly) {
            //nur das Institut mit dem besten Zinssatz ausgeben
            $select->limit(1);
        }

        $query .= $select->assemble();

        /*
         * fill the tamporary table
         */
        try {
            $stmt = new \Zend\Db\Statement\Pdo($this->_db, $query);
        } catch(Exception $e) {
            $this->_logger->err($e);
        }

        try {
            $stmt->execute();
        } catch(Exception $e) {
            $this->_logger->err($e);
        }

        /*
         * create SQL to fill the tamporary table
         */
        $urlModel  = new \Credit\Core\Model\Url();
        $urlSelect = $urlModel->select()->setIntegrityCheck(false);
        $urlSelect->from(
            array('u' => 'urls'),
            array(
                'product' => 'u.kp_id',
                'internal' => 'u.tku_internal',
                'teaser' => new \Zend\Db\Expr(
                    'CASE
                     WHEN u.tku_teaser IS NULL OR u.tku_teaser = 0 THEN 0
                     WHEN u.tku_teaser_lz = \'\' THEN 1
                     WHEN FIND_IN_SET(\'' . (int) $this->_laufzeit .
                     '\', tku_teaser_lz) IS NOT NULL AND FIND_IN_SET(\'' .
                    (int) $this->_laufzeit . '\', tku_teaser_lz) > 0 THEN 1
                    ELSE 0 END'
                ),//'u.tku_teaser',
                'pixel' => 'u.tku_pixel',
                'url' => new \Zend\Db\Expr(
                    'CASE
                     WHEN u.tku_teaser IS NULL OR u.tku_teaser = 0 THEN
                     u.tku_url
                     WHEN u.tku_teaser_lz = \'\' THEN u.tku_url_teaser
                     WHEN FIND_IN_SET(\'' . (int) $this->_laufzeit .
                     '\', tku_teaser_lz) IS NOT NULL AND FIND_IN_SET(\'' .
                    (int) $this->_laufzeit . '\', tku_teaser_lz) > 0 THEN
                    u.tku_url_teaser
                    ELSE u.tku_url END'
                ),//'u.tku_url',
                'urlTeaser' => new \Zend\Db\Expr(
                    'CASE
                     WHEN u.tku_teaser IS NULL OR u.tku_teaser = 0 THEN \'\'
                     WHEN u.tku_teaser_lz = \'\' THEN u.tku_url_teaser
                     WHEN FIND_IN_SET(\'' . (int) $this->_laufzeit .
                     '\', tku_teaser_lz) IS NOT NULL AND FIND_IN_SET(\'' .
                    (int) $this->_laufzeit . '\', tku_teaser_lz) > 0 THEN
                    u.tku_url_teaser
                    ELSE \'\' END'
                ),//'u.tku_url_teaser',
                'teaserZone' => new \Zend\Db\Expr(
                    'CASE
                     WHEN u.tku_teaser IS NULL OR u.tku_teaser = 0 THEN \'\'
                     WHEN FIND_IN_SET(\'' . (int) $this->_laufzeit .
                     '\', tku_teaser_lz) IS NOT NULL AND FIND_IN_SET(\'' .
                    (int) $this->_laufzeit . '\', tku_teaser_lz) > 0 THEN
                    u.tku_teaser_lz ELSE \'\' END'
                ),//'tku_teaser_lz'
            )
        );
        $urlSelect->where('u.active = 1');

        $urlSelect->join(
            array('ca' => 'campaigns'),
            'u.id_campaign = ca.id_campaign',
            array(
                'portal' => 'ca.p_name',
                'campaignId' => 'ca.id_campaign'
            )
        );
        $urlSelect->where('ca.active = 1');
        $urlSelect->where(
            '(ca.id_campaign IS NULL) OR ' .
            '(ca.id_campaign IN (2,' . (int) $defaultCampaign->id_campaign .
            ',' . (int) $this->_caid . '))'
        );

        $query = 'INSERT INTO `'
               . $this->_tempTableUrls . '`
                  (`product`,
                   `internal`,
                   `teaser`,
                   `pixel`,
                   `url`,
                   `urlTeaser`,
                   `teaserZone`,
                   `portal`,
                   `campaignId`
                  )
        ';

        //$this->_logger->info($urlSelect->assemble());

        $query .= $urlSelect->assemble();

        /*
         * fill the tamporary table
         */
        $stmt = new \Zend\Db\Statement\Pdo($this->_db, $query);
        $stmt->execute();

        return $this;
    }

    /**
     * updates the urls in the temporary Table
     *
     * @return \Credit\Core\Credit\Input_Fallback
     */
    private function _updateRows($defaultCampaign)
    {
        // define prepared statements
        $queryTwo = 'SELECT COUNT(*) AS anzahl, `u`.`active`
                     FROM (`urls` AS `u` JOIN `campaigns` AS `ca` ON
                     ((`ca`.`active`=1) AND
                      (`ca`.`id_campaign`=`u`.`id_campaign`)))
                     WHERE `u`.`kp_id` = :product AND
                     `ca`.`id_campaign` = :caid GROUP BY `u`.`active`';

        $stmtTwo = new \Zend\Db\Statement\Pdo($this->_db, $queryTwo);
        $stmtTwo->setFetchMode(\Zend\Db\Db::FETCH_OBJ);

        $queryOne = 'DELETE FROM '
                  . $this->_db->quoteIdentifier($this->_tempTableProducts)
                  . ' WHERE `uid` = :uid';
        $stmtOne  = new \Zend\Db\Statement\Pdo($this->_db, $queryOne);

        $queryThree = 'UPDATE '
                    . $this->_db->quoteIdentifier($this->_tempTableProducts)
                    . ' SET `internal`=:internal, `url`=:url,
                           `urlTeaser`=:urlTeaser, `pixel`=:pixel,
                           `teaser`=:teaser, `teaser_zone`=:teaserZone
                       WHERE `uid`= :uid';

        $queryThreeB = 'SELECT * FROM '
                     . $this->_db->quoteIdentifier($this->_tempTableUrls)
                     . ' WHERE product = :product AND campaignId = :caid';

        $stmtThree  = new \Zend\Db\Statement\Pdo($this->_db, $queryThree);
        $stmtThreeB = new \Zend\Db\Statement\Pdo($this->_db, $queryThreeB);

        $query = 'SELECT `uid`,`portal` AS `urlPartner`,
                  `product` AS `productId`,`boni`,`showAb`,`effZins`,
                  `effZinsOben`, `effZinsUnten`, `zinssatzCleaned`, `anzahl`,
                  `campaignId`
                  FROM '
               . $this->_db->quoteIdentifier($this->_tempTableProducts);

        $stmt = new \Zend\Db\Statement\Pdo($this->_db, $query);
        $stmt->execute();
        $stmt->setFetchMode(\Zend\Db\Db::FETCH_OBJ);
        $rows = $stmt->fetchAll();

        foreach ($rows as $row) {
            //$this->_logger->info(print_r($row, true));

            $this->_updateUrlsInSingleRow(
                $row, $stmtOne, $stmtTwo, $stmtThree, $stmtThreeB,
                $defaultCampaign
            );
        }

        return $this;
    }

    /**
     * updates the urls in a single row in the temporary Table
     *
     * @return void
     */
    private function _updateUrlsInSingleRow(
        stdClass $row,
        \Zend\Db\Statement\Pdo $stmtOne,
        \Zend\Db\Statement\Pdo $stmtTwo,
        \Zend\Db\Statement\Pdo $stmtThree,
        \Zend\Db\Statement\Pdo $stmtThreeB,
        $defaultCampaign)
    {
        $productId  = (int) $row->productId;
        $urlPartner = (int) $row->urlPartner;
        $uid        = (int) $row->uid;

        $stmtTwo->bindValue(':product', $productId, \PDO::PARAM_INT);
        $stmtTwo->bindValue(':caid', $urlPartner, \PDO::PARAM_INT);

        $stmtTwo->execute();
            $stmtTwo->setFetchMode(\Zend\Db\Db::FETCH_OBJ);
            $rowsTwo = $stmtTwo->fetchAll();

        //$this->_logger->info(print_r($rowsTwo[0], true));

        if (isset($rowsTwo[0]->anzahl)
            && $rowsTwo[0]->anzahl > 0
            && isset($rowsTwo[0]->active)
            && $rowsTwo[0]->active == 0
        ) {
            $stmtOne->bindValue(':uid', $uid, \PDO::PARAM_INT);

            // Produkte mit deaktivierter Url loeschen
            $stmtOne->execute();

            return;
        }

        if ((int) $defaultCampaign != $row->urlPartner
            && (!isset($rowsTwo[0]->anzahl) || $rowsTwo[0]->anzahl == 0)
        ) {
            $stmtTwo->bindValue(':caid', $defaultCampaign, \PDO::PARAM_INT);
            $stmtTwo->bindValue(':product', $productId, \PDO::PARAM_INT);

            //no Url for this Camapign
            $stmtTwo->execute();
            $stmtTwo->setFetchMode(\Zend\Db\Db::FETCH_OBJ);
            $rowsTwo = $stmtTwo->fetchAll();

            if (isset($rowsTwo[0]->anzahl)
                && $rowsTwo[0]->anzahl > 0
                && $rowsTwo[0]->active == 0
            ) {
                $stmtOne->bindValue(':uid', $uid, \PDO::PARAM_INT);

                // Produkte mit deaktivierter Url loeschen
                $stmtOne->execute();

                return;
            }

            if (!isset($rowsTwo[0]->anzahl)
                || $rowsTwo[0]->anzahl == 0
            ) {
                /*
                 * no Url for this Camapign/Partner
                 * -> use geld.de as default
                 */
                $urlPartner = 2; // geld.de
            } else {
                /*
                 * no Url for this Camapign
                 * -> use default of this partner
                 */
                $urlPartner = (int) $defaultCampaign;
            }
        }

        $stmtThreeB->bindValue(':caid', $urlPartner, \PDO::PARAM_INT);
        $stmtThreeB->bindValue(':product', $productId, \PDO::PARAM_INT);
        $stmtThreeB->execute();

        $stmtThreeB->setFetchMode(\Zend\Db\Db::FETCH_OBJ);
        $rowsObject = $stmtThreeB->fetchAll();

        if (isset($rowsObject[0])) {
            $stmtThree->bindValue(':uid', $uid, \PDO::PARAM_INT);
            $stmtThree->bindValue(
                ':internal', $rowsObject[0]->internal, \PDO::PARAM_INT
            );
            $stmtThree->bindValue(':url', $rowsObject[0]->url, \PDO::PARAM_STR);
            $stmtThree->bindValue(
                ':urlTeaser', $rowsObject[0]->urlTeaser, \PDO::PARAM_STR
            );
            $stmtThree->bindValue(
                ':pixel', $rowsObject[0]->pixel, \PDO::PARAM_STR
            );
            $stmtThree->bindValue(
                ':teaser', $rowsObject[0]->teaser, \PDO::PARAM_INT
            );
            $stmtThree->bindValue(
                ':teaserZone', $rowsObject[0]->teaserZone, \PDO::PARAM_STR
            );

            $stmtThree->execute();
        }

        return $this;
    }

    /**
     * deletes inactive products or products without Url from the
     * temporary Table
     *
     * @return \Credit\Core\Credit\Input_Fallback
     */
    private function _deleteWithoutUrl()
    {
        if (!(int) $this->_onlyproduct && !$this->_onlyinstitut) {
            // nicht aktive Produkte loeschen
            $query = 'DELETE FROM '
                   . $this->_db->quoteIdentifier($this->_tempTableProducts)
                   . ' WHERE `portal` < 0 AND `product`
                      IN (SELECT `u`.`kp_id` FROM `urls` AS `u`
                      WHERE `u`.`id_campaign`=:caid)';

            $stmt = new \Zend\Db\Statement\Pdo($this->_db, $query);
            $stmt->bindValue(':caid', $this->_caid, \PDO::PARAM_INT);
            $stmt->execute();
        }

        // nicht aktive Produkte und Produkte ohne url loeschen
        $query = 'DELETE FROM '
               . $this->_db->quoteIdentifier($this->_tempTableProducts)
               . ' WHERE `teaser` < 0 OR `url` = \'\' OR `url` IS NULL ';

        $stmt = new \Zend\Db\Statement\Pdo($this->_db, $query);
        $stmt->execute();

        return $this;
    }

    /**
     * updates the Teaser field in the temporary Table
     *
     * @return \Credit\Core\Credit\Input_Fallback
     */
    private function _updateTeasers()
    {
        $query = 'SELECT COUNT(*) AS `anzahl` FROM '
               . $this->_db->quoteIdentifier($this->_tempTableProducts)
               . ' WHERE `teaser` > 0';

        $stmt = new \Zend\Db\Statement\Pdo($this->_db, $query);
        $stmt->execute();

        $stmt->setFetchMode(\Zend\Db\Db::FETCH_OBJ);
        $rows = $stmt->fetchAll();

        // no teaser defined
        if (!isset($rows[0]->anzahl) || $rows[0]->anzahl == 0) {
            return $this;
        }

        $queryTwo = 'SELECT DISTINCT `product`, `teaser` FROM '
                  . $this->_db->quoteIdentifier($this->_tempTableProducts)
                  . ' WHERE `teaser` > 0';

        $stmtTwo = new \Zend\Db\Statement\Pdo($this->_db, $queryTwo);
        $stmtTwo->execute();
        $stmtTwo->setFetchMode(\Zend\Db\Db::FETCH_OBJ);
        $rowsTwo = $stmtTwo->fetchAll();

        $queryThree = 'SELECT `u`.`tku_teaser_lz` AS `teaser_zone`
                       FROM `urls` AS `u`
                       WHERE `u`.`kp_id` = :product
                       AND `u`.`id_campaign`= :caid';
        $stmtThree  = new \Zend\Db\Statement\Pdo($this->_db, $queryThree);
        $stmtThree->setFetchMode(\Zend\Db\Db::FETCH_OBJ);

        $queryFour = 'UPDATE '
                   . $this->_db->quoteIdentifier($this->_tempTableProducts)
                   . ' SET `teaser` = :teaser WHERE `product` = :product';
        $stmtFour  = new \Zend\Db\Statement\Pdo($this->_db, $queryFour);

        foreach ($rowsTwo as $row) {
            $this->_updateTeasersInSingleRow($row, $stmtThree, $stmtFour);
        }

        $query = 'SELECT COUNT(*) AS anzahl FROM '
               . $this->_db->quoteIdentifier($this->_tempTableProducts)
               . ' WHERE `teaser` = 1';

        $stmt = new \Zend\Db\Statement\Pdo($this->_db, $query);
        $stmt->execute();
        $stmt->setFetchMode(\Zend\Db\Db::FETCH_OBJ);
        $rows  = $stmt->fetchAll();

        if (isset($rows[0]->anzahl) && $rows[0]->anzahl > 0) {
            // Teaser fuer diese Laufzeit vorhanden, general-Teaser abschalten
            $queryTwo = 'UPDATE '
                      . $this->_db->quoteIdentifier($this->_tempTableProducts)
                      . ' SET `teaser` = 0 WHERE `teaser` > 1';

            $stmtTwo = new \Zend\Db\Statement\Pdo($this->_db, $queryTwo);
            $stmtTwo->execute();
        } else {
            // Teaser auf 1 setzen fuer Rueckwaertskompatibilitaet
            $queryTwo = 'UPDATE '
                      . $this->_db->quoteIdentifier($this->_tempTableProducts)
                      . ' SET `teaser` = 1 WHERE `teaser` > 1';

            $stmtTwo = new \Zend\Db\Statement\Pdo($this->_db, $queryTwo);
            $stmtTwo->execute();
        }

        if ($this->_teaseronly) {
            $queryTwo = 'DELETE FROM '
                      . $this->_db->quoteIdentifier($this->_tempTableProducts)
                      . ' WHERE `teaser` <> 1';

            $stmtTwo = new \Zend\Db\Statement\Pdo($this->_db, $queryTwo);
            $stmtTwo->execute();
        }

        return $this;
    }

    /**
     * updates the Teaser field in the temporary Table
     *
     * @return \Credit\Core\Credit\Input_Fallback
     */
    private function _updateTeasersInSingleRow(
        stdClass $row,
        \Zend\Db\Statement\Pdo $stmtThree,
        \Zend\Db\Statement\Pdo $stmtFour)
    {
        $productId = $row->product;

        $stmtThree->bindValue(':product', $productId, \PDO::PARAM_INT);
        $stmtThree->bindValue(':caid', $this->_caid, \PDO::PARAM_INT);

        $stmtThree->execute();
        $stmtThree->setFetchMode(\Zend\Db\Db::FETCH_OBJ);
        $rowsThree = $stmtThree->fetchAll();

        //no special teaser for this time range
        if (!isset($rowsThree[0]->teaser_zone)
            || $rowsThree[0]->teaser_zone == ''
        ) {
            return;
        }

        if ($rowsThree[0]->teaser_zone != '0') {
            $teasers = explode(',', $rowsThree[0]->teaser_zone);

            if (!in_array($this->_laufzeit, $teasers)) {
                $teaser = 0;
                $stmtFour->bindValue(':product', $productId, \PDO::PARAM_INT);
                $stmtFour->bindValue(':teaser', $teaser, \PDO::PARAM_INT);
                $stmtFour->execute();
            }
        }

        if ($rowsThree[0]->teaser_zone == '0') {
            $teaser = 2;
            $stmtFour->bindValue(':product', $productId, \PDO::PARAM_INT);
            $stmtFour->bindValue(':teaser', $teaser, \PDO::PARAM_INT);
            $stmtFour->execute();
        }
    }
}