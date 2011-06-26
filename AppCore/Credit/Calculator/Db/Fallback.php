<?php
declare(ENCODING = 'iso-8859-1');
namespace AppCore\Credit\Calculator\Db;

/**
 * Controller-Klasse zum Ausliefern von Javascript-Dateien
 *
 * PHP version 5
 *
 * @category  Kreditrechner
 * @package   Credit
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: Fallback.php 24 2011-02-01 20:55:24Z tmu $
 */
 
use AppCore\Credit\Calculator;

/**
 * Controller-Klasse zum Ausliefern von Javascript-Dateien
 *
 * @category  Kreditrechner
 * @package   Credit
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 */
class Fallback extends Calculator\Db
{
    private $_now = null;

    private $_tempTableProducts = '__tmp_table_products';
    private $_tempTableUrls     = '__tmp_table_urlUpdates';

    private $_dbConfig = null;

    /**
     * the class contructor
     *
     * @return \AppCore\Credit\Input\Fallback
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

        if ($this->_sparte == 1) {
            $isKredit = true;
        }

        $this->_createTables();
        $this->_fillTables();
        
        if (!$this->getRowsCount()) {var_dump('not filled');
            return array();
        }
        
        $this->_updateRows();
        
        if (!$this->getRowsCount()) {var_dump('cleared while updating');
            return array();
        }
        
        $this->_updateTeasers();
        
        if (!$this->getRowsCount()) {var_dump('cleared while updating teasers');
            return array();
        }
        
        $this->_deleteWithoutUrl();
        
        if (!$this->getRowsCount()) {var_dump('cleared while updating urls');
            return array();
        }

        return $this->getRows();
    }

    /**
     * creates the temporary Table
     *
     * @return \AppCore\Credit\Input\Fallback
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
                `kreditentscheidungSorted` ' . $decimal . ' NOT NULL DEFAULT 99,
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
                `usages` VARCHAR(255) DEFAULT \'\',
                `infoAvailable` ' . $integer . ' DEFAULT 0,
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
var_dump($this->getRows());
        return $this;
    }

    /**
     * fills the temporary Table with initial data
     *
     * @return \AppCore\Credit\Input\Fallback
     */
    private function _fillTables()
    {
        /*
         * create SQL to fill the tamporary table
         */
        $model  = new \AppCore\Model\Institutes();
        $select = $model->select()->setIntegrityCheck(false);
        $select->from(
            array('i' => 'institutes'),
            array(
                // Name der Bank
                'kreditInstitutTitle' => 'i.name',
                // Code-Name der Bank
                'kreditinstitut' => 'i.codename'
            )
        );
        $select->where('i.active = 1');

        $select->join(
            array('p' => 'Products'),
            'i.idInstitutes = p.idInstitutes',
            array(
                // product id
                'product' => 'p.idProducts',
                // Annahmewahrscheinlichkeit
                'kreditAnnahme' => 'p.annahme',
                // hat ein Testsieger-Bild? (ja/nein)
                'kreditTestsieger' => 'p.testsieger',
                // Entscheidungszeitraum als String mit "Tage" am Ende bzw.
                // sofort
                'kreditEntscheidung' => 'p.entscheidung',
                // Entscheidungszeitraum als Zahl fuer die Sortierung
                'kreditentscheidungSorted' => 'p.entscheidungSorted',
                // bonitaetsabhaengig? (ja/nein)
                // Productsinstellung kann vom Zinssatz ueberschrieben werden
                'boni' => new \Zend\Db\Expr(
                    '@boni := (CASE
                     WHEN z.boni IS NULL THEN p.boni
                     WHEN z.boni > 0 THEN 1
                     ELSE 0 END)'
                ),
                // ordering
                'ordering' => 'p.ordering',
                // Zeitraum der Zinsgutschrift als String ("jaehrlich")
                'zinsgutschrift' => 'p.zinsgutschrift',
                'anlagezeitraum' => 'p.anlagezeitraum',
                // Gebuehr fuer EC-Karte (fuer Girokonten)
                'ecgeb' => 'p.ecgeb',
                // Gebuehr fuer Kreditkarte (fuer Girokonten)
                'kreditkartengeb' => 'p.kreditkartengeb',
                // Gebuehr fuer Kontofuehrung (fuer Girokonten)
                'kontofuehrung' => 'p.kontofuehrung',
                // minimaler Anlagebetrag
                'min' => new \Zend\Db\Expr('IFNULL(p.min, 0.0)'),
                // maximaler Anlagebetrag
                'max' => new \Zend\Db\Expr('IFNULL(p.max, 0.0)'),
                // erlaubte Verwendungszwecke als kommaseparierte Liste
                'usages' => 'p.usages'
            )
        );
        $select->where('p.active = 1');
        $select->where(
            '((p.min <= ' . (int) $this->_kreditbetrag . ') OR
              (p.min IS NULL))'
        );
        $select->where(
            '((p.max >= ' . (int) $this->_kreditbetrag . ') OR
              (p.max IS NULL))'
        );

        //$this->_logger->info($this->_boni);

        if (null !== $this->_boni) {
            $select->where('p.boni = ' . (int) $this->_boni);
        }

        $select->join(
            array('pi' => 'productInformation'),
            'p.idProducts = pi.idProducts',
            array(
                // the product has an info stored inside the database
                'infoAvailable' => new \Zend\Db\Expr(
                    'CASE
                     WHEN pi.info IS NULL THEN 0
                     WHEN CHAR_LENGTH(pi.info) > 0 THEN 1
                     ELSE 0 END'
                ),
            )
        );
        $select->where('pi.active = 1');

        $select->join(
            array('pc' => 'produkt_components'),
            'p.idProducts = pc.idProducts',
            array(
                // Name des Productss
                'kreditName' => 'pc.description'
            )
        );
        $select->where('pc.active = 1');

        $select->join(
            array('s' => 'categories'),
            'pc.idCategories = s.idCategories',
            array()
        );
        $select->where('s.active = 1');
        $select->where('s.idCategories = ' . (int) $this->_sparte);

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

        $campaignModel = new \AppCore\Model\Campaigns();
        $innerSelect   = $campaignModel->select()->setIntegrityCheck(false);
        $innerSelect->from(
            array('ca' => 'campaigns'),
            array(
                'anzahl' => new \Zend\Db\Expr('COUNT(*)'),
                'ca.idCampaigns'
            )
        );
        $innerSelect->where('ca.active = 1');
        $innerSelect->where(
            '(ca.idCampaigns IS NULL) OR ' .
            '(ca.idCampaigns IN (1,' . (int) $this->_caid . '))'
        );

        $innerSelect->join(
            array('u' => 'urls'),
            'ca.idCampaigns = u.idCampaigns',
            array('u.idProducts')
        );
        if ($this->_teaseronly) {
            $innerSelect->where('u.teaser = 1');
        }
        $innerSelect->group(array('u.idProducts', 'ca.name'));
        $innerSelect->order(array('u.idProducts', 'ca.name'));

        $select->joinLeft(
            array('pu' => $innerSelect),
            'p.idProducts = pu.idProducts',
            array(
                'anzahl' => 'pu.anzahl',
                'campaignId' => 'pu.idCampaigns',
                'portal' => new \Zend\Db\Expr(
                    'CASE
                     WHEN pu.anzahl > 0 THEN pu.idCampaigns
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

        $zinsModel  = new \AppCore\Model\Zins();
        $zinsSelect = $zinsModel->select()->setIntegrityCheck(false);
        $zinsSelect->from(
            array('zx' => 'zins'),
            array(new \Zend\Db\Expr('MAX(zx.betrag)'))
        );
        $zinsSelect->where('zx.idProducts = p.idProducts');
        $zinsSelect->where('zx.betrag <= ' . (int) $this->_kreditbetrag);
        $zinsSelect->where('zx.laufzeit = ' . (int) $this->_laufzeit);
        $zinsSelect->group('zx.idProducts');

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
                   `kreditentscheidungSorted`,
                   `boni`,
                   `ordering`,
                   `zinsgutschrift`,
                   `anlagezeitraum`,
                   `ecgeb`,
                   `kreditkartengeb`,
                   `kontofuehrung`,
                   `min`,
                   `max`,
                   `usages`,
                   `infoAvailable`,
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
                $select->where('p.idProducts IN (' . $this->_onlyproduct . ')');
            } else {
                $select->where('p.idProducts = ' . $this->_onlyproduct);
            }
        } elseif ($this->_onlyinstitut) {
            //nur das gewuenschte Institut ausgeben
            $select->where('i.codename = \'' . $this->_onlyinstitut . '\'');
        }

        if ($this->_bestonly) {
            //nur das Institut mit dem besten Zinssatz ausgeben
            $select->limit(1);
        }

        $query .= $select->assemble();
        //var_dump($query);

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
        $urlModel  = new \AppCore\Model\Url();
        $urlSelect = $urlModel->select()->setIntegrityCheck(false);
        $urlSelect->from(
            array('u' => 'urls'),
            array(
                'product' => 'u.idProducts',
                'internal' => 'u.internal',
                'teaser' => new \Zend\Db\Expr(
                    'CASE
                     WHEN u.teaser IS NULL OR u.teaser = 0 THEN 0
                     WHEN u.teaserLz = \'\' THEN 1
                     WHEN FIND_IN_SET(\'' . (int) $this->_laufzeit .
                     '\', teaserLz) IS NOT NULL AND FIND_IN_SET(\'' .
                    (int) $this->_laufzeit . '\', teaserLz) > 0 THEN 1
                    ELSE 0 END'
                ),//'u.teaser',
                'pixel' => 'u.pixel',
                'url' => new \Zend\Db\Expr(
                    'CASE
                     WHEN u.teaser IS NULL OR u.teaser = 0 THEN
                     u.url
                     WHEN u.teaserLz = \'\' THEN u.urlTeaser
                     WHEN FIND_IN_SET(\'' . (int) $this->_laufzeit .
                     '\', teaserLz) IS NOT NULL AND FIND_IN_SET(\'' .
                    (int) $this->_laufzeit . '\', teaserLz) > 0 THEN
                    u.urlTeaser
                    ELSE u.url END'
                ),//'u.url',
                'urlTeaser' => new \Zend\Db\Expr(
                    'CASE
                     WHEN u.teaser IS NULL OR u.teaser = 0 THEN \'\'
                     WHEN u.teaserLz = \'\' THEN u.urlTeaser
                     WHEN FIND_IN_SET(\'' . (int) $this->_laufzeit .
                     '\', teaserLz) IS NOT NULL AND FIND_IN_SET(\'' .
                    (int) $this->_laufzeit . '\', teaserLz) > 0 THEN
                    u.urlTeaser
                    ELSE \'\' END'
                ),//'u.urlTeaser',
                'teaserZone' => new \Zend\Db\Expr(
                    'CASE
                     WHEN u.teaser IS NULL OR u.teaser = 0 THEN \'\'
                     WHEN FIND_IN_SET(\'' . (int) $this->_laufzeit .
                     '\', teaserLz) IS NOT NULL AND FIND_IN_SET(\'' .
                    (int) $this->_laufzeit . '\', teaserLz) > 0 THEN
                    u.teaserLz ELSE \'\' END'
                ),//'teaserLz'
            )
        );
        $urlSelect->where('u.active = 1');

        $urlSelect->join(
            array('ca' => 'campaigns'),
            'u.idCampaigns = ca.idCampaigns',
            array(
                'portal' => 'ca.name',
                'campaignId' => 'ca.idCampaigns'
            )
        );
        $urlSelect->where('ca.active = 1');
        $urlSelect->where(
            '(ca.idCampaigns IS NULL) OR ' .
            '(ca.idCampaigns IN (1,' . (int) $this->_caid . '))'
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
        
        //var_dump(count($this->getRows()->toArray()));
var_dump($this->getRows());
        return $this;
    }

    /**
     * updates the urls in the temporary Table
     *
     * @return \AppCore\Credit\Input\Fallback
     */
    private function _updateRows()
    {
        // define prepared statements
        $queryTwo = 'SELECT COUNT(*) AS anzahl, `u`.`active`
                     FROM (`urls` AS `u` JOIN `campaigns` AS `ca` ON
                     ((`ca`.`active`=1) AND
                      (`ca`.`idCampaigns`=`u`.`idCampaigns`)))
                     WHERE `u`.`idProducts` = :product AND
                     `ca`.`idCampaigns` = :caid GROUP BY `u`.`active`';

        $stmtTwo = new \Zend\Db\Statement\Pdo($this->_db, $queryTwo);
        $stmtTwo->setFetchMode(\Zend\Db\Db::FETCH_OBJ);

        $queryOne = 'DELETE FROM '
                  . $this->_db->quoteIdentifier($this->_tempTableProducts)
                  . ' WHERE `uid` = :uid';
        $stmtOne  = new \Zend\Db\Statement\Pdo($this->_db, $queryOne);
var_dump($this->getRows());
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
        
        //var_dump('bb', count($this->getRows()->toArray()));

        foreach ($rows as $row) {
            //$this->_logger->info(print_r($row, true));

            $this->_updateUrlsInSingleRow(
                $row, $stmtOne, $stmtTwo, $stmtThree, $stmtThreeB
            );
        }
        
        //var_dump('cc', count($this->getRows()->toArray()));
var_dump($this->getRows());
        return $this;
    }

    /**
     * updates the urls in a single row in the temporary Table
     *
     * @return void
     */
    private function _updateUrlsInSingleRow(
        \stdClass $row,
        \Zend\Db\Statement\Pdo $stmtOne,
        \Zend\Db\Statement\Pdo $stmtTwo,
        \Zend\Db\Statement\Pdo $stmtThree,
        \Zend\Db\Statement\Pdo $stmtThreeB)
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

            // Products mit deaktivierter Url loeschen
            $stmtOne->execute();

            return;
        }

        if ((!isset($rowsTwo[0]->anzahl) || $rowsTwo[0]->anzahl == 0)) {
            $stmtTwo->bindValue(':caid', 1, \PDO::PARAM_INT);
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

                // Products mit deaktivierter Url loeschen
                $stmtOne->execute();

                return;
            }

            $urlPartner = 1; // general
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
     * @return \AppCore\Credit\Input\Fallback
     */
    private function _deleteWithoutUrl()
    {
        /*
        if (!(int) $this->_onlyproduct && !$this->_onlyinstitut) {
            // nicht aktive Products loeschen
            $query = 'DELETE FROM '
                   . $this->_db->quoteIdentifier($this->_tempTableProducts)
                   . ' WHERE `portal` < 0 AND `product`
                      IN (SELECT `u`.`idProducts` FROM `urls` AS `u`
                      WHERE `u`.`idCampaigns`=:caid)';

            $stmt = new \Zend\Db\Statement\Pdo($this->_db, $query);
            $stmt->bindValue(':caid', $this->_caid, \PDO::PARAM_INT);
            $stmt->execute();
        }
        /**/

        // nicht aktive Products und Products ohne url loeschen
        /*
        $query = 'DELETE FROM '
               . $this->_db->quoteIdentifier($this->_tempTableProducts)
               . ' WHERE `teaser` < 0 OR `url` = \'\' OR `url` IS NULL ';

        $stmt = new \Zend\Db\Statement\Pdo($this->_db, $query);
        $stmt->execute();
        /**/
        
        //var_dump('dd', count($this->getRows()->toArray()));

        return $this;
    }

    /**
     * updates the Teaser field in the temporary Table
     *
     * @return \AppCore\Credit\Input\Fallback
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

        $queryThree = 'SELECT `u`.`teaserLz` AS `teaser_zone`
                       FROM `urls` AS `u`
                       WHERE `u`.`idProducts` = :product
                       AND `u`.`idCampaigns`= :caid';
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
        
        //var_dump('ee', count($this->getRows()->toArray()));
var_dump($this->getRows());
        return $this;
    }

    /**
     * updates the Teaser field in the temporary Table
     *
     * @return \AppCore\Credit\Input\Fallback
     */
    private function _updateTeasersInSingleRow(
        \stdClass $row,
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