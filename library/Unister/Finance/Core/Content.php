<?php
/**
 * Funktionen für Content
 *
 * PHP version 5
 *
 * @category  Geld.de
 * @package   Content
 * @author    Marko Schreiber <marko.schreiber@unister-gmbh.de>
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2009 Unister GmbH
 * @version   SVN: $Id: Content.php 13 2011-01-06 21:27:04Z tmu $
 */
require_once LIB_PATH . 'Unister' . DS . 'Finance' . DS . 'Core' . DS . 'Abstract.php';
/**
 * Funktionen für Content
 *
 * @category  Geld.de
 * @package   Content
 * @author    Marko Schreiber <marko.schreiber@unister-gmbh.de>
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2009 Unister GmbH
 */
class Unister_Finance_Core_Content extends Unister_Finance_Core_Abstract
{
    /**
     * Class constructor
     *
     * The request and response objects should be registered with the
     * controller, as should be any additional optional arguments; these will be
     * available via {@link getRequest()}, {@link getResponse()}, and
     * {@link getInvokeArgs()}, respectively.
     *
     * When overriding the constructor, please consider this usage as a best
     * practice and ensure that each is registered appropriately; the easiest
     * way to do so is to simply call parent::__construct($request, $response,
     * $invokeArgs).
     *
     * After the request, response, and invokeArgs are set, the
     * {@link $_helper helper broker} is initialized.
     *
     * Finally, {@link init()} is called as the final action of
     * instantiation, and may be safely overridden to perform initialization
     * tasks; as a general rule, override {@link init()} instead of the
     * constructor to customize an action controller's instantiation.
     *
     * @param Zend_Controller_Request_Abstract  $request
     * @param Zend_Controller_Response_Abstract $response
     * @param array                             $invokeArgs Any additional
     *                                                      invocation arguments
     *
     * @return void
     * @access public
     */
    public function __construct()
    {
        parent::__construct();
        
        //$this->_module = new Model_Core_Module($this->_view);        //$this->_db = Zend_Registry::get('db');        //$this->_view = $view;
    }

    /**
     * Class destructor
     *
     * @return void
     * @access public
     */
    public function __destruct()
    {
        //unset($this->_module);        //unset($this->_db);        //unset($this->_view);
        
        parent::__destruct();
    }

    /**
     * returns the site title
     *
     * @param array $data
     * @param array $requestData
     *
     * @return string
     * @access public
     */
    public function getSiteTitle(array $data, array $requestData)
    {
/*        $link_array    = array('-faq-', '-allgemeines-', '-test-', '-tipp-',  '-lexikon-', '-policenverkauf');

        foreach ($link_array as $value) {
            if (substr_count($data['datei_name'], $value)) {
                $data['keyword'] = $data['parent']['keyword'];
                break;
            }
        }
*/
        //parsing the insurance name into site title
        if (isset($requestData['recommend'])) {
            $data['keyword'] = 'Empfehlung - ' . str_replace('-', ' ', $data['keyword']) . '';
        } elseif ($data['datei_name'] == 'sitemap') {
            $data['keyword'] = 'Sitemap ';
        } elseif ($data['datei_name'] == 'partner') {
            $titel = 'Partnerprogramm f&uuml;r Versicherungen und Finanzen auf ' . _DOMAIN_NAME . '';
        } elseif ($data['datei_name'] == 'suchen') {
            $titel = 'Suchergebnisse f&uuml;r ' . $requestData['searchstr'];
        } elseif (isset($data['keyword'])) {
            $titel = $data['keyword'] . ' - kostenlose Informationen und Vergleiche bei ' . _DOMAIN_NAME . '';
        } else {
            $titel = 'Kostenlose Informationen und Vergleiche bei ' . _DOMAIN_NAME . '';
        }

        return $titel;
    }

    /**
     * returns navigation
     *
     * @param array $maincategory
     *
     * @return unknown
     * @access public
     */
    public function getCurrentLevels(array $row, array $data)
    {
        $current = '';
        if($row['nav_id'] == $data['cat_id'] ||
        $row['nav_id'] == $data['bezug'] ||
        $row['nav_id'] == $data['nav_id']) {
            $current = 'current';
        }
        return $current;
    }

    /**
     * returns navigation
     *
     * @param array $maincategory
     *
     * @return unknown
     * @access public
     */
    public function checkCurrent(array $row, array $data)
    {
        $inCurrent = '';
        if($row['cat_id'] == $data['cat_id'] ||
        $row['cat_id'] == $data['nav_id'] ||
        $row['nav_id'] == $data['cat_id'] ||
        $row['nav_id'] == $data['nav_id']) {
            $inCurrent = 'inCurrent';
        }
        return $inCurrent;
    }

    /**
     * returns the parent category
     *
     * @param array $data
     *
     * @return array|false
     * @access public
     */
    public function getParentCategory(array $data)
    {
        $config = Zend_Registry::get('_config');
        $db     = Zend_Db::factory($config->database->type, $config->database->toArray());
        $result = $db->query('SELECT * FROM pages WHERE nav_id=\'' . $data['bezug'] . '\'');

        if ($result && $row = $result->fetch(PDO::FETCH_ASSOC)) {
            $return = $row;
        } else {
            $return = false;
        }

        unset ($db);

        return $return;
    }

    /**
     * returns the main category
     *
     * @param array $data
     *
     * @return array
     * @access public
     */
    public function getMainCategory(array $data)
    {
        if (isset($data['parent']) && $data['is_nav'] != '1') {
            if (isset($data['parent']['nav_id'])) {
                $row['bezug'] = $data['parent']['nav_id'];
            } else {
                $row['bezug'] = '1';
            }                        $config = Zend_Registry::get('_config');
            $db     = Zend_Db::factory($config->database->type, $config->database->toArray());

            do {
                $result = $db->query('SELECT * FROM pages WHERE nav_id = \'' . $row['bezug'] . '\'');

                if (!$result || !($row = $result->fetch(PDO::FETCH_ASSOC))) {
                    $row = false;
                }
            } while (is_array($row) && $row['is_nav'] != '1' && $row['bezug'] != '0');

            if (is_array($row)) {
                $data = $row;
            }                        unset($db);
        }

        return $data;
    }

    /**
     * returns the BreadCrumb
     *
     * @param array $data
     *
     * @return string
     * @access public
     */
    public function getBreadCrumb(array $data)
    {
        $breadcrumb = '';
        $path       = '<a class="pathlnk" href="' . _URL . '/">' . _DOMAIN_NAME . '</a>';

        if (isset($data['keyword']) && $data['keyword'] == 'empfehlung') {
            $path .= 'Empfehlung - ' . str_replace('-', ' ', $data['keyword']) . '';
        } elseif (isset($data['keyword']) && $data['keyword'] == 'sitemap') {
            $path .= 'Sitemap';
        }

        if (isset($data['nav_id']) && isset($data['cat_id'])) {
            $row = $data;            $config = Zend_Registry::get('_config');
            $db     = Zend_Db::factory($config->database->type, $config->database->toArray());

            do {
                if ($row['nav_id'] != $data['nav_id']) {
                    $breadcrumb = '<a class="pathlnk" href="' . _URL . '/' . $row['datei_name'] . '.html" title="' . $row['keyword'] . '">' . $row['keyword'] . '</a>' . $breadcrumb;
                }

                $result = $db->query('SELECT * FROM pages WHERE nav_id = \'' . $row['bezug'] . '\'');
            } while ($result && $row = $result->fetch(PDO::FETCH_ASSOC));            unset($db);

            $keyword = preg_split('/ - /', $data['keyword']);
            $keyword = $keyword[count($keyword)-1];
            $path     .= $breadcrumb . $keyword;
        }

        if (strlen($path) > 300) {
            $path = strrev($path);
            $path = substr($path, (strpos($path, '>a/<')));
            $path = strrev($path) . '...';
        }

        return $path;
    }
}//end class