<?php
/**
 * File for Class ControllerTestCase
 *
 * @category   Kreditrechner
 * @package    Test
 * @subpackage
 * @author     Unister GmbH - Andreas Hoffmann - <andreas.hoffmann@unister-gmbh.de>
 * @version    $Id: ControllerTestCase.php 217 2011-12-15 23:37:07Z tmu $
 * @copyright  2010 Unister GmbH
 * @since      08.06.2010
 */

/**
 * @see Zend/Application.php
 */
require_once LIB_PATH . DS . 'Zend' . DS . 'Application' . DS . 'Application.php';

/**
 * @see Zend/Test/PHPUnit/ControllerTestCase.php
 */
require_once LIB_PATH . DS . 'Zend' . DS . 'Test' . DS . 'PHPUnit' . DS . 'ControllerTestCase.php';

/**
 * Class ControllerTestCase
 *
 * Bootstraps application for Zend Controller test cases
 *
 * @category   Test
 * @package
 * @subpackage
 * @copyright 2010 Unister-Gmbh
 */
class ControllerTestCase extends \Zend\Test\PHPUnit\ControllerTestCase
{
    /**
     * Application Instance
     *
     * @var Zend_Application
     */
    protected $_application;

    /**
     * View Renderer to use in Test Cases
     *
     * @var Zend_Controller_Action_Helper_ViewRenderer
     */
    protected $_viewRenderer;

    /**
     * Database Connection
     *
     * @var Zend_Test_PHPUnit_Db_Connection
     */
    protected $_dbConnection;

    /**
     * @var Zend_Test_PHPUnit_Db_Connection
     */
    private $_connectionMock;

    protected $databaseTester = null;

   /**
     * Setup Testing and MVC Enviroment by Bootstraping the Application
     * This is called before any Test
     *
     * @return ControllerTestCase
     */
    protected function setUp()
    {
        //Zend_Session::$_unitTestEnabled = true;

        $this->_application = new \Zend\Application\Application(
            APPLICATION_ENV,
            APPLICATION_PATH . DS . 'configs' . DS . 'application.ini'
        );

        $this->bootstrap = $this->_application->bootstrap();
        ini_set('memory_limit', '3072M');
        $layout = \Zend\Layout\Layout::getMvcInstance();
        $this->_viewRenderer = $layout->getView();

        //$this->_loadFixture();

        //$this->getDatabaseTester()->setSetUpOperation($this->getSetUpOperation());
        //$this->getDatabaseTester()->setDataSet($this->getDataSet());
        //$this->getDatabaseTester()->onSetUp();

        return $this;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        //$this->getDatabaseTester()->setTearDownOperation($this->getTearDownOperation());
        //$this->getDatabaseTester()->setDataSet($this->getDataSet());
        //$this->getDatabaseTester()->onTearDown();

        /**
         * Destroy the tester after the test is run to keep DB connections
         * from piling up.
         */
        //$this->databaseTester = null;

        //$this->closeConnection($this->_connectionMock);

        $db = \Zend\Db\Table\AbstractTable::getDefaultAdapter();
        if (null !== $db) {
            $db->closeConnection();
        }

        if (\Zend\Registry::isRegistered('log')) {
            $log = \Zend\Registry::get('log');
            //$log->err('teardown');

            //force the shutdown of all Log_Writers
            $log->__destruct();
        }

        \Zend\Controller\Front::getInstance()->resetInstance();
        \Zend\Controller\Front::getInstance()->throwExceptions(true);

        \Zend\Layout\Layout::resetMvcInstance();

        \Zend\Db\Table\AbstractTable::setDefaultAdapter(null);
        \Zend\Db\Table\AbstractTable::setDefaultMetadataCache(null);

        $this->resetRequest();
        $this->resetResponse();

        $this->request->setPost(array());
        $this->request->setQuery(array());

        \Zend\Loader\Autoloader::resetInstance();
        restore_error_handler();

        \Zend\Registry::_unsetInstance();
        
        unset($_SESSION);
        $_SESSION = array();
    }

    /**
     * Setup Testing Database
     */
    protected function getConnection()
    {
        $config = new \Zend\Config\Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);

        if (null === $this->_dbConnection) {
            $connection = \Zend\Db\Db::factory($config->resources->multidb->main->adapter, $config->resources->multidb->main->params);

            //$this->_dbConnection = new Zend_Test_PHPUnit_Db_Connection($connection, 'zend_test_schema');

            $this->_connectionMock = $this->createZendDbConnection($connection, 'zfunittests');
            \Zend\Db\Table\AbstractTable::setDefaultAdapter($this->_connectionMock->getConnection());
        }

        if ('pdo_sqlite' == $config->resources->multidb->main->adapter) {
            //use only if database adapter is 'sqlite'
            $this->createTables();
        }
//var_dump($this->_dbConnection->getConnection()->listTables());exit;
        if (!$this->_connectionMock->getConnection()->listTables()) {
            $this->markTestSkipped('Db Connection not possible!');
            return;
        }

       return $this->_connectionMock;
    }

    /**
     * Returns the test dataset.
     *
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getDataSet()
    {
        return $this->createXMLDataSet(__DIR__.'/_files/dataSet.xml');
    }

    protected function createTables()
    {
        $adapter = $this->_connectionMock->getConnection();

        $tableList = $adapter->listTables();

        foreach ($tableList as $table) {
            $adapter->query("DROP TABLE $table");
        }

        $adapter->query("CREATE TABLE agents (
  uid INTEGER PRIMARY KEY ASC,
  browserId INTEGER default NULL,
  agent text NOT NULL,
  OS varchar(20) default NULL,
  Browser varchar(50) default NULL,
  Version varchar(10) default NULL,
  win16 INTEGER NOT NULL default '0',
  win32 INTEGER NOT NULL default '0',
  win64 INTEGER NOT NULL default '0',
  Frames INTEGER NOT NULL default '0',
  IFrames INTEGER NOT NULL default '0',
  Tables INTEGER NOT NULL default '0',
  Cookies INTEGER NOT NULL default '0',
  BackgroundSounds INTEGER NOT NULL default '0',
  CDF INTEGER NOT NULL default '0',
  VBScript INTEGER NOT NULL default '0',
  JavaApplets INTEGER NOT NULL default '0',
  JavaScript INTEGER NOT NULL default '0',
  ActiveXControls INTEGER NOT NULL default '0',
  CssVersion INTEGER NOT NULL default '0',
  supportsCSS INTEGER NOT NULL default '0',
  isBanned INTEGER NOT NULL default '0',
  isMobileDevice INTEGER NOT NULL default '0',
  isSyndicationReader INTEGER NOT NULL default '0',
  Crawler INTEGER NOT NULL default '0',
  AOL INTEGER NOT NULL default '0',
  aolVersion INTEGER NOT NULL default '0',
  found INTEGER NOT NULL default '0',
  created timestamp NOT NULL default CURRENT_TIMESTAMP,
  createdBy INTEGER default NULL
) ;");
        $adapter->query("CREATE TABLE agents_list (
  uid INTEGER PRIMARY KEY ASC,
  browserId INTEGER default NULL,
  agent text NOT NULL,
  createDate timestamp NOT NULL default CURRENT_TIMESTAMP
) ;");
        $adapter->query("CREATE TABLE bearbeiter (
  BearbeiterId INTEGER PRIMARY KEY ASC,
  Benutzername varchar(30) NOT NULL,
  Passwort varchar(34) NOT NULL,
  Nachname varchar(30) NOT NULL,
  Vorname varchar(30) NOT NULL,
  AnzeigeName varchar(30) NOT NULL,
  AnzeigeBild varchar(254) NOT NULL,
  EMail varchar(254) NOT NULL,
  Login INTEGER NOT NULL default '0',
  Rolle varchar(30) NOT NULL,
  RolleId INTEGER NOT NULL,
  Filter text,
  createDate timestamp NOT NULL default CURRENT_TIMESTAMP,
  createdBy INTEGER default NULL
) ;");
        $adapter->query("CREATE TABLE blz_liste (
  uid INTEGER PRIMARY KEY ASC,
  blz char(8) NOT NULL,
  name_voll varchar(255) NOT NULL
) ;");
        $adapter->query("CREATE TABLE browser (
  browserId INTEGER PRIMARY KEY ASC,
  Browser varchar(255) NOT NULL,
  Platform varchar(255) NOT NULL,
  Version DOUBLE NOT NULL default '0.00',
  Win16 INTEGER NOT NULL default '0',
  Win32 INTEGER NOT NULL default '0',
  Win64 INTEGER NOT NULL default '0',
  Frames INTEGER NOT NULL default '0',
  IFrames INTEGER NOT NULL default '0',
  Tables INTEGER NOT NULL default '0',
  Cookies INTEGER NOT NULL default '0',
  BackgroundSounds INTEGER NOT NULL default '0',
  CDF INTEGER NOT NULL default '0',
  VBScript INTEGER NOT NULL default '0',
  JavaApplets INTEGER NOT NULL default '0',
  JavaScript INTEGER NOT NULL default '0',
  ActiveXControls INTEGER NOT NULL default '0',
  CssVersion DOUBLE NOT NULL default '0.00',
  supportsCSS INTEGER NOT NULL default '0',
  isBanned INTEGER NOT NULL default '0',
  isMobileDevice INTEGER NOT NULL default '0',
  isSyndicationReader INTEGER NOT NULL default '0',
  Crawler INTEGER NOT NULL default '0',
  AOL INTEGER NOT NULL default '0',
  aolVersion DOUBLE NOT NULL default '0.00',
  color varchar(6) NOT NULL default 'ddd',
  createDate timestamp NOT NULL default CURRENT_TIMESTAMP,
  createdBy INTEGER default NULL
) ;");
        $adapter->query("CREATE TABLE campaigns (
  idCampaigns INTEGER PRIMARY KEY ASC,
  p_id INTEGER NOT NULL default '1' ,
  name varchar(100) NOT NULL ,
  name varchar(50) default NULL ,
  active INTEGER NOT NULL default '1',
  color varchar(6) NOT NULL default '999',
  externalLinks varchar(7) NOT NULL default 'auto',
  creditLine varchar(7) NOT NULL default 'oneStep',
  loadInfo varchar(3) NOT NULL default 'yes',
  createDate timestamp NOT NULL default CURRENT_TIMESTAMP,
  createdBy INTEGER default NULL,
  aliasPortalService varchar(255) NOT NULL ,
  aliasPortalServiceShort varchar(255) NOT NULL ,
  idCampaignMain INTEGER default NULL ,
  idCampaignTest INTEGER default NULL
) ;");
        $adapter->query("CREATE TABLE event (
  EventId INTEGER PRIMARY KEY ASC,
  EventTypeId smallint(3) NOT NULL default '0',
  InsertAt timestamp NOT NULL default CURRENT_TIMESTAMP,
  Desc text NOT NULL,
  CloseEventId INTEGER default NULL
) ;");
        $adapter->query("CREATE TABLE eventtype (
  EventTypeId INTEGER PRIMARY KEY ASC,
  Name varchar(50) NOT NULL default '',
  Icon varchar(50) NOT NULL default '',
  Color varchar(6) NOT NULL default 'ffffff',
  IsClosing INTEGER NOT NULL default '0'
) ;");
        $adapter->query("CREATE TABLE exception (
  ExceptionId INTEGER PRIMARY KEY ASC,
  Throw timestamp NOT NULL default CURRENT_TIMESTAMP,
  Message text NOT NULL,
  Trace text NOT NULL,
  ApplicationId int(5) default NULL,
  SessionId int(5) default NULL,
  Enviroment varchar(50) NOT NULL,
  Request text,
  level varchar(250) NOT NULL default 'Exception'
) ;");
        $adapter->query("CREATE TABLE geodb_locations (
  loc_id INTEGER PRIMARY KEY ASC,
  loc_type INTEGER NOT NULL
) ;");
        $adapter->query("CREATE TABLE geodb_namen (
  nameId INTEGER PRIMARY KEY ASC,
  loc_id INTEGER,
  text_type INTEGER NOT NULL,
  text_val varchar(255) NOT NULL,
  text_locale varchar(5) default NULL,
  is_native_lang smallint(1) default NULL,
  is_default_name smallint(1) default NULL,
  valid_since date default NULL,
  date_type_since INTEGER default NULL,
  valid_until date NOT NULL,
  date_type_until INTEGER NOT NULL
) ;");
        $adapter->query("CREATE TABLE geodb_plz (
  plzId INTEGER PRIMARY KEY ASC,
  loc_id INTEGER,
  text_type INTEGER NOT NULL,
  text_val int(5) NOT NULL,
  valid_since date default NULL,
  date_type_since INTEGER default NULL,
  valid_until date NOT NULL,
  date_type_until INTEGER NOT NULL
) ;");
        $adapter->query("CREATE TABLE institute (
  idInstitutes INTEGER PRIMARY KEY ASC,
  active INTEGER NOT NULL default '1' ,
  ki_ordering INTEGER NOT NULL default '0',
  codename varchar(50) NOT NULL ,
  name TEXT NOT NULL ,
  ki_created timestamp NULL default CURRENT_TIMESTAMP,
  color varchar(6) NOT NULL default 'ddd'
) ;");
        $adapter->query("CREATE TABLE institutesForLog (
  idInstitutesForLog INTEGER PRIMARY KEY ASC,
  idInstitutes INTEGER default NULL ,
  name varchar(50) NOT NULL ,
  created timestamp NULL default CURRENT_TIMESTAMP,
  isInternal INTEGER NOT NULL default '0',
  isTeaser INTEGER NOT NULL default '0',
  isSpider INTEGER NOT NULL default '0',
  isInactive INTEGER NOT NULL default '0'
) ;");
        $adapter->query("CREATE TABLE interfaces_types (
  interface_id INTEGER PRIMARY KEY ASC,
  name TEXT NOT NULL,
  active INTEGER NOT NULL default '1'
) ;");
        $adapter->query("CREATE TABLE kredit_statistik (
  log_id INTEGER PRIMARY KEY ASC,
  betrag INTEGER NOT NULL,
  loanPeriod INTEGER default NULL,
  idInstitutesForLog INTEGER default NULL ,
  idCampaigns INTEGER default NULL ,
  zweck INTEGER default NULL,
  id_type INTEGER default NULL ,
  idCategories INTEGER default NULL ,
  zeit char(13) default NULL,
  anzahl INTEGER NOT NULL default '0'
) ;");
        $adapter->query("CREATE TABLE kunde (
  KundeId INTEGER PRIMARY KEY ASC,
  Anrede varchar(9) default NULL,
  Titel varchar(20) default NULL,
  Nachname varchar(254) default NULL,
  Vorname varchar(254) default NULL,
  Strasse varchar(254) default NULL,
  Hausnummer varchar(10) default NULL,
  Plz varchar(7) default NULL,
  Ort varchar(254) default NULL,
  TelefonVorwahl varchar(100) default NULL,
  TelefonNummer varchar(100) default NULL,
  TelefonMobilVorwahl varchar(100) default NULL,
  TelefonMobilNummer varchar(100) default NULL,
  Fax varchar(100) default NULL,
  EMail1 varchar(254) default NULL,
  EMail2 varchar(254) default NULL,
  Internet1 varchar(254) default NULL,
  Internet2 varchar(254) default NULL,
  BerufsStatus varchar(50) default 'Unbekannt',
  BerufsBezeichnung varchar(254) default NULL,
  OeffentlicherDienst varTEXT default 'ka',
  Firma varchar(254) default NULL,
  GeburtsDatum date default NULL,
  GeburtsDatumKind1 date default NULL,
  GeburtsDatumKind2 date default NULL,
  Staatsangehoerigkeit varchar(254) default NULL,
  GeschlechtKind1 varTEXT default NULL,
  GeschlechtKind2 varTEXT default NULL,
  FamilienStand varchar(50) default 'unbekannt',
  AnzahlKinder INTEGER default NULL,
  HatBankverbindung INTEGER default NULL,
  Bankleitzahl int(8) default NULL,
  Kontonummer varchar(254) default NULL,
  Bankname varchar(254) default NULL,
  Kontoinhaber varchar(254) default NULL,
  HatSchufa INTEGER default '0',
  HatKreditkarte INTEGER default '0',
  KreditkartenNummer varchar(254) default NULL,
  KreditkartenDatum date default NULL,
  KreditkartenInhaber varchar(254) default NULL,
  KreditkartenTyp varTEXT default 'KEIN',
  Hash varchar(32) default NULL,
  created timestamp NOT NULL default CURRENT_TIMESTAMP
) ;");
        $adapter->query("CREATE TABLE periodCategories (
  uid INTEGER PRIMARY KEY ASC,
  idLoanPeriods INTEGER default NULL ,
  idCategories INTEGER default NULL
) ;");
        $adapter->query("CREATE TABLE loanPeriods (
  idLoanPeriods INTEGER PRIMARY KEY ASC,
  name TEXT NOT NULL ,
  value double NOT NULL
) ;");
        $adapter->query("CREATE TABLE log_agent (
  uid INTEGER PRIMARY KEY ASC,
  agent_id INTEGER NOT NULL ,
  browserId INTEGER default NULL ,
  idCampaigns INTEGER default NULL ,
  `from` char(1) NOT NULL default 'C',
  zeit char(13) default NULL,
  anzahl INTEGER NOT NULL default '0'
) ;");
        $adapter->query("CREATE TABLE log_betrag (
  uid INTEGER PRIMARY KEY ASC,
  betrag INTEGER NOT NULL,
  anzahl INTEGER NOT NULL default '0',
  p_id INTEGER default NULL,
  zeit char(13) NOT NULL
) ;");
        $adapter->query("CREATE TABLE log_credits (
  knID INTEGER PRIMARY KEY ASC,
  portal varchar(20) NOT NULL,
  institut varchar(30) NOT NULL,
  referenz_id varchar(15) NOT NULL,
  kundenKontonr varchar(15) NOT NULL,
  datum char(20) NOT NULL,
  date timestamp NOT NULL default CURRENT_TIMESTAMP,
  anrede varchar(9) NOT NULL default 'unbekannt',
  name text NOT NULL,
  name2 text,
  adresse text NOT NULL,
  adresse2 text,
  kontakt text NOT NULL ,
  kontakt2 text ,
  telefon text,
  telefon2 text,
  mobil text,
  mobil2 text,
  staatsangeh varchar(5) NOT NULL,
  staatsangeh2 varchar(5) default NULL,
  kreditbetrag INTEGER default NULL,
  loanPeriod INTEGER default NULL,
  einnahmen varchar(50) NOT NULL,
  ausgaben varchar(50) NOT NULL,
  sonstiges longtext,
  status varchar(50) default NULL,
  ablehnungsgrund text,
  fehlercode INTEGER default NULL,
  fehlermeldung varchar(255) default NULL,
  data text,
  test INTEGER NOT NULL default '0',
  user_ip char(16) NOT NULL default '00.00.00.00' ,
  processID varchar(20) default NULL,
  Category varchar(30) NOT NULL default 'Kredit',
  KundeId INTEGER default NULL,
  statusTypeId INTEGER default NULL,
  schufaOk INTEGER default '1',
  schufaOk2 INTEGER default NULL,
  beraterOK INTEGER default '1',
  datenschutzOK INTEGER default '1',
  probezeitDreiMonate INTEGER default NULL,
  probezeitDreiMonate2 INTEGER default NULL,
  dreiMonate INTEGER default NULL,
  dreiMonate2 INTEGER default NULL,
  idPortalService char(36) default NULL,
  creditLine varchar(6) NOT NULL default 'oneStep',
  mehrAntrag INTEGER NOT NULL default '0'
) ;");
        $adapter->query("CREATE TABLE log_credits_click (
  log_id INTEGER PRIMARY KEY ASC,
  log_stat_id INTEGER default NULL,
  date timestamp NOT NULL default CURRENT_TIMESTAMP,
  user_ip char(16) NOT NULL default '00.00.00.00',
  user_port INTEGER NOT NULL default '0',
  server_ip char(16) NOT NULL default '00.00.00.00',
  server_port INTEGER NOT NULL default '0',
  client_ip char(16) NOT NULL default '00.00.00.00',
  client_agent text NOT NULL,
  params text,
  u INTEGER NOT NULL default '1'
) ;");
        $adapter->query("CREATE TABLE log_institut (
  uid INTEGER PRIMARY KEY ASC,
  institut INTEGER default NULL,
  p_id INTEGER default NULL,
  zeit char(13) default NULL,
  anzahl INTEGER NOT NULL default '0'
) ;");
        $adapter->query("CREATE TABLE log_loanPeriod (
  uid INTEGER PRIMARY KEY ASC,
  loanPeriod INTEGER NOT NULL,
  anzahl INTEGER NOT NULL default '0',
  p_id INTEGER default NULL,
  zeit char(13) NOT NULL
) ;");
        $adapter->query("CREATE TABLE log_portal (
  uid INTEGER PRIMARY KEY ASC,
  p_id INTEGER default NULL,
  zeit char(13) default NULL,
  anzahl INTEGER NOT NULL default '0'
) ;");
        $adapter->query("CREATE TABLE log_requests (
  log_id INTEGER PRIMARY KEY ASC,
  requestId INTEGER default NULL,
  date timestamp NOT NULL default CURRENT_TIMESTAMP,
  idCampaigns INTEGER default NULL,
  id_type INTEGER default NULL,
  idCategories INTEGER default NULL,
  betrag INTEGER default NULL,
  loanPeriod INTEGER default NULL,
  idInstitutesForLog INTEGER default NULL,
  zweck INTEGER default NULL,
  server_ip char(16) NOT NULL default '00.00.00.00',
  client_ip char(16) NOT NULL default '00.00.00.00',
  client_agent_id INTEGER default NULL,
  server_agent_id INTEGER default NULL,
  client_referrer text,
  server_referrer text
) ;");
        $adapter->query("CREATE TABLE log_category (
  uid INTEGER PRIMARY KEY ASC,
  Category INTEGER default NULL,
  p_id INTEGER default NULL,
  zeit char(13) default NULL,
  anzahl INTEGER NOT NULL default '0'
) ;");
        $adapter->query("CREATE TABLE log_zweck (
  uid INTEGER PRIMARY KEY ASC,
  zweck INTEGER NOT NULL,
  p_id INTEGER default NULL,
  zeit char(13) default NULL,
  anzahl INTEGER NOT NULL default '0'
) ;");
        $adapter->query("CREATE TABLE navigation (
  idNavigation INTEGER PRIMARY KEY ASC,
  idParentNavigation INTEGER default NULL,
  Name varchar(200) NOT NULL,
  RessourceId INTEGER NOT NULL,
  active INTEGER NOT NULL default '0',
  ordering int(3) NOT NULL,
  createDate timestamp NOT NULL default CURRENT_TIMESTAMP,
  createdBy INTEGER default NULL
) ;");
        $adapter->query("CREATE TABLE partnerSites (
  p_id INTEGER PRIMARY KEY ASC,
  name varchar(50) NOT NULL ,
  active INTEGER NOT NULL default '1',
  name varchar(50) NOT NULL,
  adresse varchar(250) default NULL ,
  color varchar(6) NOT NULL default 'ddd',
  email varchar(255) NOT NULL,
  telefon varchar(255) NOT NULL
) ;");
        $adapter->query("CREATE TABLE productComponents (
  idProductComponents INTEGER PRIMARY KEY ASC,
  idProducts INTEGER default NULL ,
  idCategories INTEGER NOT NULL default '1' ,
  active INTEGER NOT NULL default '1' ,
  description text,
  instituteName TEXT ,
  createDate timestamp NULL default CURRENT_TIMESTAMP,
  createdBy INTEGER default NULL
) ;");
        $adapter->query("CREATE TABLE produkt_interfaces (
  uid INTEGER PRIMARY KEY ASC,
  idProducts INTEGER NOT NULL,
  interface_id INTEGER NOT NULL default '1',
  active INTEGER NOT NULL default '1'
) ;");
        $adapter->query("CREATE TABLE produkt_category (
  uid INTEGER PRIMARY KEY ASC,
  idProducts INTEGER default NULL ,
  idCategories INTEGER default NULL
) ;");
        $adapter->query("CREATE TABLE Products (
  idProducts INTEGER PRIMARY KEY ASC,
  idInstitutes INTEGER NOT NULL ,
  idCategories INTEGER NOT NULL default '1' ,
  active INTEGER NOT NULL default '1',
  ordering INTEGER NOT NULL default '0',
  kp_desc text ,
  kname TEXT NOT NULL ,
  min INTEGER default NULL,
  max INTEGER default NULL,
  created timestamp NULL default CURRENT_TIMESTAMP,
  annahme varchar(50) NOT NULL default '60',
  entscheidung varchar(50) NOT NULL default '2 Tage',
  entscheidungSorted DOUBLE NOT NULL default '99',
  testsieger INTEGER NOT NULL default '0',
  usages varchar(50) NOT NULL default '1,2,3,4,5,6,7,8',
  boni INTEGER NOT NULL default '0' ,
  zinsgutschrift varchar(50) NOT NULL default 'j&auml;hrlich',
  anlagezeitraum TEXT,
  ecgeb TEXT,
  kreditkartengeb TEXT,
  kontofuehrung TEXT,
  provisionClick DOUBLE NOT NULL default '0.01',
  provisionSale DOUBLE NOT NULL default '0.10',
  info text
) ;");
        $adapter->query("CREATE TABLE request (
  uid INTEGER PRIMARY KEY ASC,
  host text,
  agent_id INTEGER default NULL,
  agent text,
  accept text,
  language text,
  encoding text,
  charset text,
  cookie text,
  IP varchar(255) default NULL,
  uri text,
  referrer text,
  SessionId varchar(32) default NULL,
  data text,
  datum timestamp NULL default CURRENT_TIMESTAMP,
  isTest INTEGER NOT NULL default '0'
) ;");
        $adapter->query("CREATE TABLE ressource (
  RessourceId INTEGER PRIMARY KEY ASC,
  Name varchar(200) NOT NULL,
  Controller varchar(100) NOT NULL,
  Action varchar(100) NOT NULL,
  DatumUpdate timestamp NOT NULL default CURRENT_TIMESTAMP,
  active INTEGER NOT NULL default '1'
) ;");
        $adapter->query("CREATE TABLE ressource_x_rolle (
  RessourceId INTEGER NOT NULL,
  RolleId INTEGER default NULL,
  Recht varchar(6) NOT NULL default 'notset',
  uid INTEGER PRIMARY KEY ASC
) ;");
        $adapter->query("CREATE TABLE roletype (
  idRoleType INTEGER PRIMARY KEY ASC,
  Name varchar(100) NOT NULL
) ;");
        $adapter->query("CREATE TABLE rolle (
  RolleId INTEGER PRIMARY KEY ASC,
  Name varchar(30) NOT NULL,
  RolleTyp varchar(8) NOT NULL default 'Benutzer',
  active INTEGER NOT NULL default '1'
) ;");
        $adapter->query("CREATE TABLE rolle_x_rolle (
  uid INTEGER PRIMARY KEY ASC,
  RolleId1 INTEGER default NULL,
  RolleId2 INTEGER default NULL
) ;");
        $adapter->query("CREATE TABLE session (
  SessionId varchar(32) NOT NULL ,
  beginn INTEGER NOT NULL default '0' ,
  ablauf INTEGER NOT NULL default '0' ,
  daten text NOT NULL
) ;");
        $adapter->query("CREATE TABLE categories (
  idCategories INTEGER PRIMARY KEY ASC,
  Code char(2) NOT NULL,
  name varchar(50) NOT NULL,
  defaultLoanPeriods INTEGER default NULL,
  LEAD_Id INTEGER default NULL,
  active INTEGER NOT NULL default '1'
) ;");
        $adapter->query("CREATE TABLE stat (
  uid INTEGER PRIMARY KEY ASC,
  datum char(13) NOT NULL,
  idCategories INTEGER default NULL ,
  idInstitutesForLog INTEGER default NULL ,
  clicks INTEGER NOT NULL default '0',
  sum_clicks INTEGER NOT NULL default '0',
  lz_clicks INTEGER NOT NULL default '0',
  pr_clicks DOUBLE NOT NULL default '0.00',
  pageimpression INTEGER NOT NULL default '0',
  sum_pageimpression INTEGER NOT NULL default '0',
  lz_pageimpression INTEGER NOT NULL default '0',
  pr_pageimpression DOUBLE NOT NULL default '0.00',
  p_geldde INTEGER NOT NULL default '0',
  p_preisvergleichde INTEGER NOT NULL default '0',
  p_kreditde INTEGER NOT NULL default '0',
  p_versicherungende INTEGER NOT NULL default '0',
  p_shoppingde INTEGER NOT NULL default '0',
  p_boersennewsde INTEGER NOT NULL default '0',
  p_autode INTEGER NOT NULL default '0',
  p_andere INTEGER NOT NULL default '0',
  info INTEGER NOT NULL default '0',
  sum_info INTEGER NOT NULL default '0',
  lz_info INTEGER NOT NULL default '0',
  pr_info DOUBLE NOT NULL default '0.00',
  i_geldde INTEGER NOT NULL default '0',
  i_preisvergleichde INTEGER NOT NULL default '0',
  i_kreditde INTEGER NOT NULL default '0',
  i_versicherungende INTEGER NOT NULL default '0',
  i_shoppingde INTEGER NOT NULL default '0',
  i_boersennewsde INTEGER NOT NULL default '0',
  i_autode INTEGER NOT NULL default '0',
  i_andere INTEGER NOT NULL default '0',
  clickout INTEGER NOT NULL default '0',
  sum_clickout INTEGER NOT NULL default '0',
  lz_clickout INTEGER NOT NULL default '0',
  pr_clickout DOUBLE NOT NULL default '0.00',
  c_geldde INTEGER NOT NULL default '0',
  sum_c_geldde INTEGER NOT NULL default '0',
  lz_c_geldde INTEGER NOT NULL default '0',
  pr_c_geldde DOUBLE NOT NULL default '0.00',
  c_preisvergleichde INTEGER NOT NULL default '0',
  sum_c_preisvergleichde INTEGER NOT NULL default '0',
  lz_c_preisvergleichde INTEGER NOT NULL default '0',
  pr_c_preisvergleichde DOUBLE NOT NULL default '0.00',
  c_kreditde INTEGER NOT NULL default '0',
  sum_c_kreditde INTEGER NOT NULL default '0',
  lz_c_kreditde INTEGER NOT NULL default '0',
  pr_c_kreditde DOUBLE NOT NULL default '0.00',
  c_versicherungende INTEGER NOT NULL default '0',
  sum_c_versicherungende INTEGER NOT NULL default '0',
  lz_c_versicherungende INTEGER NOT NULL default '0',
  pr_c_versicherungende DOUBLE NOT NULL default '0.00',
  c_shoppingde INTEGER NOT NULL default '0',
  sum_c_shoppingde INTEGER NOT NULL default '0',
  lz_c_shoppingde INTEGER NOT NULL default '0',
  pr_c_shoppingde DOUBLE NOT NULL default '0.00',
  c_boersennewsde INTEGER NOT NULL default '0',
  sum_c_boersennewsde INTEGER NOT NULL default '0',
  lz_c_boersennewsde INTEGER NOT NULL default '0',
  pr_c_boersennewsde DOUBLE NOT NULL default '0.00',
  c_autode INTEGER NOT NULL default '0',
  sum_c_autode INTEGER NOT NULL default '0',
  lz_c_autode INTEGER NOT NULL default '0',
  pr_c_autode DOUBLE NOT NULL default '0.00',
  c_andere INTEGER NOT NULL default '0',
  sum_c_andere INTEGER NOT NULL default '0',
  lz_c_andere INTEGER NOT NULL default '0',
  pr_c_andere DOUBLE NOT NULL default '0.00',
  sale INTEGER NOT NULL default '0',
  sum_sale INTEGER NOT NULL default '0',
  lz_sale INTEGER NOT NULL default '0',
  pr_sale DOUBLE NOT NULL default '0.00',
  s_geldde INTEGER NOT NULL default '0',
  sum_s_geldde INTEGER NOT NULL default '0',
  lz_s_geldde INTEGER NOT NULL default '0',
  pr_s_geldde DOUBLE NOT NULL default '0.00',
  s_preisvergleichde INTEGER NOT NULL default '0',
  sum_s_preisvergleichde INTEGER NOT NULL default '0',
  lz_s_preisvergleichde INTEGER NOT NULL default '0',
  pr_s_preisvergleichde DOUBLE NOT NULL default '0.00',
  s_kreditde INTEGER NOT NULL default '0',
  sum_s_kreditde INTEGER NOT NULL default '0',
  lz_s_kreditde INTEGER NOT NULL default '0',
  pr_s_kreditde DOUBLE NOT NULL default '0.00',
  s_versicherungende INTEGER NOT NULL default '0',
  sum_s_versicherungende INTEGER NOT NULL default '0',
  lz_s_versicherungende INTEGER NOT NULL default '0',
  pr_s_versicherungende DOUBLE NOT NULL default '0.00',
  s_shoppingde INTEGER NOT NULL default '0',
  sum_s_shoppingde INTEGER NOT NULL default '0',
  lz_s_shoppingde INTEGER NOT NULL default '0',
  pr_s_shoppingde DOUBLE NOT NULL default '0.00',
  s_boersennewsde INTEGER NOT NULL default '0',
  sum_s_boersennewsde INTEGER NOT NULL default '0',
  lz_s_boersennewsde INTEGER NOT NULL default '0',
  pr_s_boersennewsde DOUBLE NOT NULL default '0.00',
  s_autode INTEGER NOT NULL default '0',
  sum_s_autode INTEGER NOT NULL default '0',
  lz_s_autode INTEGER NOT NULL default '0',
  pr_s_autode DOUBLE NOT NULL default '0.00',
  s_andere INTEGER NOT NULL default '0',
  sum_s_andere INTEGER NOT NULL default '0',
  lz_s_andere INTEGER NOT NULL default '0',
  pr_s_andere DOUBLE NOT NULL default '0.00',
  andere INTEGER NOT NULL default '0',
  sum_andere INTEGER NOT NULL default '0',
  lz_andere INTEGER NOT NULL default '0',
  pr_andere DOUBLE NOT NULL default '0.00'
) ;");
        $adapter->query("CREATE TABLE stat_einfach (
  uid INTEGER PRIMARY KEY ASC,
  datum char(13) NOT NULL,
  id_type INTEGER default NULL ,
  idInstitutesForLog INTEGER default NULL ,
  idCampaigns INTEGER default NULL ,
  idCategories INTEGER default NULL ,
  anzahl INTEGER NOT NULL default '0',
  sum INTEGER NOT NULL default '0',
  lz INTEGER NOT NULL default '0',
  pr DOUBLE NOT NULL default '0.00'
) ;");
        $adapter->query("CREATE TABLE statustype (
  statusTypeId INTEGER PRIMARY KEY ASC,
  Name varchar(100) NOT NULL
) ;");
        $adapter->query("CREATE TABLE system_tracking (
  keywords varchar(255) NOT NULL,
  sum DOUBLE NOT NULL,
  min DOUBLE NOT NULL,
  max DOUBLE NOT NULL,
  count INTEGER NOT NULL,
  is_avg INTEGER NOT NULL
) ;");
        $adapter->query("CREATE TABLE system_tracking_config (
  update_interval INTEGER NOT NULL
) ;");
        $adapter->query("CREATE TABLE tarife_kredite_zins (
  tkz_id INTEGER PRIMARY KEY ASC,
  tkz_name varchar(50) NOT NULL,
  tkz_step double NOT NULL default '500',
  tkz_category varchar(50) NOT NULL default 'Kredit',
  tkz6 double default NULL,
  tkz12 double default NULL,
  tkz18 double default NULL,
  tkz24 double default NULL,
  tkz30 double default NULL,
  tkz36 double default NULL,
  tkz42 double default NULL,
  tkz48 double default NULL,
  tkz54 double default NULL,
  tkz60 double default NULL,
  tkz66 double default NULL,
  tkz72 double default NULL,
  tkz84 double default NULL,
  tkz85 double default NULL,
  tkz90 double default NULL,
  tkz96 double default NULL,
  tkz102 double default NULL,
  tkz108 double default NULL,
  tkz114 double default NULL,
  tkz120 double default NULL,
  zinssatzN double default NULL ,
  zinssatzR double default NULL
) ;");
        $adapter->query("CREATE TABLE types (
  id_type INTEGER PRIMARY KEY ASC,
  name varchar(100) NOT NULL,
  doLock INTEGER NOT NULL default '0'
) ;");
        $adapter->query("CREATE TABLE urls (
  idUrls INTEGER PRIMARY KEY ASC,
  idProducts INTEGER NOT NULL ,
  p_id INTEGER default NULL ,
  idCampaigns INTEGER default NULL ,
  url text NOT NULL ,
  urlTeaser text ,
  pixel text ,
  pixel_teaser text ,
  teaser INTEGER NOT NULL default '0' ,
  internal INTEGER NOT NULL default '0' ,
  teaserLz varchar(50) NOT NULL default '0' ,
  active INTEGER NOT NULL default '1'
) ;");
        $adapter->query("CREATE TABLE verwendung (
  verwendung_id INTEGER PRIMARY KEY ASC,
  name TEXT NOT NULL,
  ordering INTEGER NOT NULL default '9999'
) ;");
        $adapter->query("CREATE TABLE zins (
  uid INTEGER PRIMARY KEY ASC,
  idProducts INTEGER NOT NULL ,
  idProductComponents INTEGER default NULL ,
  betrag INTEGER NOT NULL default '500' ,
  loanPeriod INTEGER default NULL ,
  zinssatz DOUBLE default NULL ,
  zinssatzoben DOUBLE default NULL,
  zinssatzunten DOUBLE default NULL,
  zinssatz23 DOUBLE default NULL ,
  zinssatzN DOUBLE default NULL ,
  zinssatzR DOUBLE default NULL ,
  active INTEGER NOT NULL default '1',
  start timestamp NOT NULL default CURRENT_TIMESTAMP,
  end date default NULL,
  showAb INTEGER NOT NULL default '1'
) ;");
        $adapter->query("CREATE TABLE zinsHistory (
  uid INTEGER PRIMARY KEY ASC,
  uid_zins INTEGER default NULL ,
  idProducts INTEGER default NULL ,
  idProductComponents INTEGER default NULL ,
  betrag INTEGER default NULL ,
  loanPeriod INTEGER default NULL ,
  zinssatz DOUBLE default NULL ,
  zinssatzoben DOUBLE default NULL ,
  zinssatzunten DOUBLE default NULL ,
  zinssatz23 DOUBLE default NULL ,
  zinssatzN DOUBLE default NULL ,
  zinssatzR DOUBLE default NULL ,
  active INTEGER NOT NULL default '1' ,
  start INTEGER default NULL ,
  startDate datetime default NULL ,
  end INTEGER default NULL ,
  endDate datetime default NULL ,
  showAb INTEGER NOT NULL default '1'
) ;");
        $adapter->query("CREATE TABLE zinsen (
  uid INTEGER PRIMARY KEY ASC,
  uid_zins INTEGER default NULL ,
  idProducts INTEGER default NULL ,
  betrag INTEGER default NULL ,
  loanPeriod INTEGER default NULL ,
  zins DOUBLE default NULL ,
  rate DOUBLE default NULL ,
  rate2 DOUBLE NOT NULL default '0.0000000000'
) ;");
        $adapter->query("CREATE TABLE creditolo_mailing (
  uid INTEGER PRIMARY KEY ASC,
  KundeId INTEGER default NULL,
  mailkey TEXT NOT NULL,
  email TEXT NOT NULL,
  anrede TEXT NOT NULL default 'Herr',
  name varchar(100) NOT NULL,
  betrag INTEGER NOT NULL,
  sent INTEGER NOT NULL default '0'
) ;");
    }
    /**
     * Creates a new Zend Database Connection using the given Adapter and database schema name.
     *
     * @param  \Zend\Db\Db_Adapter_Abstract $connection
     * @param  string $schema
     * @return Zend_Test_PHPUnit_Db_Connection
     */
    protected function createZendDbConnection(\Zend\Db\Db_Adapter_Abstract $connection, $schema)
    {
        return new Zend_Test_PHPUnit_Db_Connection($connection, $schema);
    }

    /**
     * Convenience function to get access to the database connection.
     *
     * @return \Zend\Db\Db_Adapter_Abstract
     */
    protected function getAdapter()
    {
        return $this->getConnection()->getConnection();
    }

    /**
     * Returns the database operation executed in test setup.
     *
     * @return PHPUnit_Extensions_Database_Operation_DatabaseOperation
     */
    protected function getSetUpOperation()
    {
        return new PHPUnit_Extensions_Database_Operation_Composite(array(
            new Zend_Test_PHPUnit_Db_Operation_Truncate(),
            new Zend_Test_PHPUnit_Db_Operation_Insert(),
        ));
    }

    /**
     * Returns the database operation executed in test cleanup.
     *
     * @return PHPUnit_Extensions_Database_Operation_DatabaseOperation
     */
    protected function getTearDownOperation()
    {
        return PHPUnit_Extensions_Database_Operation_Factory::NONE();
    }

    /**
     * Create a dataset based on multiple \Zend\Db\Db_Table instances
     *
     * @param  array $tables
     * @return Zend_Test_PHPUnit_Db_DataSet_DbTableDataSet
     */
    protected function createDbTableDataSet(array $tables=array())
    {
        $dataSet = new Zend_Test_PHPUnit_Db_DataSet_DbTableDataSet();
        foreach($tables AS $table) {
            $dataSet->addTable($table);
        }
        return $dataSet;
    }

    /**
     * Create a table based on one \Zend\Db\Db_Table instance
     *
     * @param \Zend\Db\Table\AbstractTable $table
     * @param string $where
     * @param string $order
     * @param string $count
     * @param string $offset
     * @return Zend_Test_PHPUnit_Db_DataSet_DbTable
     */
    protected function createDbTable(\Zend\Db\Table\AbstractTable $table, $where=null, $order=null, $count=null, $offset=null)
    {
        return new Zend_Test_PHPUnit_Db_DataSet_DbTable($table, $where, $order, $count, $offset);
    }

    /**
     * Create a data table based on a \Zend\Db\Db_Table_Rowset instance
     *
     * @param  \Zend\Db\Db_Table_Rowset_Abstract $rowset
     * @param  string
     * @return Zend_Test_PHPUnit_Db_DataSet_DbRowset
     */
    protected function createDbRowset(\Zend\Db\Db_Table_Rowset_Abstract $rowset, $tableName = null)
    {
        return new Zend_Test_PHPUnit_Db_DataSet_DbRowset($rowset, $tableName);
    }

    /**
     * Creates a new XMLDataSet with the given $xmlFile. (absolute path.)
     *
     * @param string $xmlFile
     * @return PHPUnit_Extensions_Database_DataSet_XmlDataSet
     */
    protected function createXMLDataSet($xmlFile)
    {
        require_once 'PHPUnit/Extensions/Database/DataSet/XmlDataSet.php';
        return new PHPUnit_Extensions_Database_DataSet_XmlDataSet($xmlFile);
    }

    /**
     * Gets the IDatabaseTester for this testCase. If the IDatabaseTester is
     * not set yet, this method calls newDatabaseTester() to obtain a new
     * instance.
     *
     * @return PHPUnit_Extensions_Database_ITester
     */
    protected function getDatabaseTester()
    {
        if (empty($this->databaseTester)) {
            $this->databaseTester = $this->newDatabaseTester();
        }

        return $this->databaseTester;
    }

    /**
     * Creates a IDatabaseTester for this testCase.
     *
     * @return PHPUnit_Extensions_Database_ITester
     */
    protected function newDatabaseTester()
    {
        return new PHPUnit_Extensions_Database_DefaultTester($this->getConnection());
    }

    /**
     * Closes the specified connection.
     *
     * @param PHPUnit_Extensions_Database_DB_IDatabaseConnection $connection
     */
    protected function closeConnection(PHPUnit_Extensions_Database_DB_IDatabaseConnection $connection)
    {
        $this->getDatabaseTester()->closeConnection($connection);
    }

}