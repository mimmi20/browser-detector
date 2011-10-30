<?php
/**
 * Funktionen für Module
 *
 * PHP version 5
 *
 * @category  Geld.de
 * @package   Module
 * @author    Marko Schreiber <marko.schreiber@unister-gmbh.de>
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2008 Unister GmbH
 * @version   SVN: $Id$
 */

require_once LIB_PATH . 'Unister' . DS . 'Finance' . DS . 'Core' . DS . 'Abstract.php';

/**
 * Funktionen für Module
 *
 * @category  Geld.de
 * @package   Module
 * @author    Marko Schreiber <marko.schreiber@unister-gmbh.de>
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2008 Unister GmbH
 */
class Unister_Finance_Core_Module extends Unister_Finance_Core_Abstract
{
    //public $content = '';
    public $style   = '';
    public $header  = null;    //nicht genutzt
    public $count   = 0;       //nicht genutzt
    public $failure = array();
    public $regex   = '/^[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)*@([0-9a-zA-Z][0-9a-zA-Z-]*[0-9A-Za-z]\.)+([A-Za-z]{2,4})$/';
    public $array   = array(); //nicht genutzt

    protected $_DATUM_TAGE = array(
        "1"  => "01",
        "2"  => "02",
        "3"  => "03",
        "4"  => "04",
        "5"  => "05",
        "6"  => "06",
        "7"  => "07",
        "8"  => "08",
        "9"  => "09",
        "10" => "10",
        "11" => "11",
        "12" => "12",
        "13" => "13",
        "14" => "14",
        "15" => "15",
        "16" => "16",
        "17" => "17",
        "18" => "18",
        "19" => "19",
        "20" => "20",
        "21" => "21",
        "22" => "22",
        "23" => "23",
        "24" => "24",
        "25" => "25",
        "26" => "26",
        "27" => "27",
        "28" => "28",
        "29" => "29",
        "30" => "30",
        "31" => "31",
    );

    protected $_DATUM_TAGE_2 = array(
        "01"  => "01",
        "02"  => "02",
        "03"  => "03",
        "04"  => "04",
        "05"  => "05",
        "06"  => "06",
        "07"  => "07",
        "08"  => "08",
        "09"  => "09",
        "10" => "10",
        "11" => "11",
        "12" => "12",
        "13" => "13",
        "14" => "14",
        "15" => "15",
        "16" => "16",
        "17" => "17",
        "18" => "18",
        "19" => "19",
        "20" => "20",
        "21" => "21",
        "22" => "22",
        "23" => "23",
        "24" => "24",
        "25" => "25",
        "26" => "26",
        "27" => "27",
        "28" => "28",
        "29" => "29",
        "30" => "30",
        "31" => "31",
    );

    //MONATE
    protected $_DATUM_MONATE = array(
        "1"  => "01",
        "2"  => "02",
        "3"  => "03",
        "4"  => "04",
        "5"  => "05",
        "6"  => "06",
        "7"  => "07",
        "8"  => "08",
        "9"  => "09",
        "10" => "10",
        "11" => "11",
        "12" => "12",
    );

    protected $_DATUM_MONATE_2 = array(
        "01" => "01",
        "02" => "02",
        "03" => "03",
        "04" => "04",
        "05" => "05",
        "06" => "06",
        "07" => "07",
        "08" => "08",
        "09" => "09",
        "10" => "10",
        "11" => "11",
        "12" => "12",
    );

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
     * @param Zend_View $view
     *
     * @return void
     * @access public
     */
    public function __construct(Zend_View $view)
    {
        parent::__construct();

        $this->_db   = Zend_Registry::get('db');
        $this->_view = $view;
    }

    /**
     * Class destructor
     *
     * @return void
     * @access public
     */
    public function __destruct()
    {
        unset($this->_view);
        unset($this->_db);

        parent::__destruct();
    }

    /**
     * Enter description here...
     *
     * @return string
     * @access public
     */
    public function detectDomain()
    {
        $ip2loc = $this->getCurlContent("http://api.hostip.info/get_html.php?ip=" . $_SERVER['REMOTE_ADDR'], 5, 5);
        $ip2loc = explode(" ", $ip2loc);
        $domain = substr($ip2loc[2], 1, 2);

        if (count($ip2loc) > 1 && array_key_exists($domain, $GLOBALS['_GLOBAL_ALLG_STAATSANGEH'])) {
            $tdomain = $domain;
        } else {
            $tdomain = "unknown";
        }

        return $tdomain;
    }

    /**
     * Enter description here...
     *
     * @param array $data
     * @param array $requestData
     *
     * @return boolean
     * @access public
     */
    public function trackGoogleCampaign(array $data, array $requestData)
    {
        /* update table 'log_google_landings' */
        $result = $this->_db->query("SELECT * FROM `log_google_landings`"
                                . " WHERE searchstr LIKE '" . strtolower(trim($requestData['searchstr'])) . "'"
                                . " AND datei_name LIKE '" . $data['datei_name'] . "'");
        $rowData = null;

        if ($result && $row = $result->fetch(PDO::FETCH_ASSOC)) {
            $rowData = $row;
        }

        if ($rowData === null) {
            $this->_db->insert(
                          "INSERT INTO `log_google_landings` ("
                        . " `track_id`,"
                        . " `searchstr`,"
                        . " `datei_name`"
                        . ")"
                        . "VALUES(0,'"
                        . strtolower(trim($requestData['searchstr'])) . "','"
                        . $data['datei_name'] . "'"
                        . ")");
        }

        return true;
    }

    /**
     * Enter description here...
     *
     * @return string
     * @access public
     */
    public function searchGoogleCampaign(array $requestData = array())
    {
        $result = $this->_db->query("SELECT datei_name FROM `log_google_landings`"
                                . " WHERE searchstr LIKE '" . strtolower(trim($requestData['searchstr'])) . "' LIMIT 0,1");

        if ($result && $row = $result->fetch(PDO::FETCH_OBJ)) {
            $return = $row->datei_name;
        } else {
            $return = "suchen";
        }

        return $return;
    }

    /**
     * track any data in db
     *
     * @param string $data
     * @param string $requestData
     *
     * @return boolean
     * @access public
     */
    function trackPolicenVerkauf($table, $email)
    {
        $this->_db->insert(
                      "INSERT INTO `" . $table . "` (`pv_id`,`pv_email`)"
                    . "VALUES(0,'" . $email . "');"
                    , __line__ . "<br>" . __file__
                    );

        return true;
    }

    /**
     * Enter description here...
     *
     * @param array $data
     *
     * @return string
     * @access public
     */
    public function setFormName(array $data)
    {
        $frmName = $data['alt_header'] != '' ? $data['alt_header'] : $data['keyword'];
        return $frmName;
    }

    /**
     * Enter description here...
     *
     * @return string
     * @access public
     */
    public function topicOfMonth()
    {
        $result = $this->_db->query(  "SELECT *"
                                . " FROM topic_of_month AS a"
                                . " INNER JOIN pages AS b"
                                . " ON a.tom_nav_id = b.nav_id"
                                . " WHERE a.tom_active = 1");

        $content = '';

        if (!empty($result)) {
            $row = $result->fetch(PDO::FETCH_ASSOC);

            if ($row['bezug'] != "0" && $result2 = $this->_db->query("SELECT * FROM pages WHERE nav_id='" . $row['bezug'] . "'")) {
                $row['parent'] = $result2->fetch(PDO::FETCH_ASSOC);
            }

            $row['categoryImage'] = $this->getCategoryImage($cnt->getMainCategory($row));
            $this->_view->assign("topic", $row);

            $content = $this->_view->render("content/topicOfTheMonth.phtml");
        }

        return $content;
    }

    /**
     * Enter description here...
     *
     * @param array $data
     *
     * @return string
     * @access public
     */
    public function getCategoryImage(array $data)
    {
        if ($data['is_nav'] == 1) {
            $img = $data['nav_id'];
        } elseif ($data['cat_id'] == 2 && $data['is_nav'] == 0) {
            $img = '2';
        } else {
            $img = $data['bezug'];

            if (isset($data['parent']['is_nav']) && $data['parent']['is_nav'] == "0") {
                $row = $data['parent'];

                do {
                    $result = $this->_db->query("SELECT * FROM pages WHERE nav_id=" . $row['bezug'] . "");
                    $row    = $result->fetch(PDO::FETCH_ASSOC);
                } while (is_array($row) && $row['is_nav'] != "1");

                $img = $row['nav_id'];
            }
        }

        return $img;
    }

    /**
     * Enter description here...
     *
     * @param array $data
     *
     * @return string
     * @access public
     */
    public function getStartblock(array $data)
    {
        if ($data['cat_id'] == 0 || $data['is_nav'] == 1) {
            $result = $this->_db->query(  "SELECT *"
                                    . " FROM topic_of_month"
                                    . " WHERE tom_nav_id = " . $data['nav_id']);


            if (isset($data['startblock_text']) && (!$result || !$result->rowCount())) {
                $content = $data['startblock_text'];
                $return  = $content;
            } else {
                $return = '';
            }

            return $return;
        } else {
            return '';
        }
    }

    /**
     * Enter description here...
     *
     * @param $data
     *
     * @return string
     * @access public
     */
    public function analysis(array $data)
    {
        $header = null;
        $style  = null;

        switch ($data['nav_id']) {
        /*
        case "1":
            $header = ": Immer die richtige Versicherung";
            break;
        */
        default :
            $style = "Small";
            break;
        }

        $this->_view->assign("style", $style);
        $this->_view->assign("header", $header);
        $content = $this->_view->render("content/analysis.phtml");

        return $content;
    }

    /**
     * get all info sheet like faq, allgemeines, test, lexikon
     *
     * @return string
     * @access public
     */
    public function wissen()
    {
        $array = array(
            "Allgemeines"     => "-allgemeines",
            "FAQ"             => "-faq",
            "Test"             => "-test",
            "Lexikon"         => "-lexikon",
        );

        foreach ($array as $key=>$value) {
            $i      = 0;
            $result = $this->_db->query("SELECT datei_name, keyword FROM pages WHERE datei_name LIKE '%" . $value . "' ORDER BY keyword");

            while ($result && $row = $result->fetch(PDO::FETCH_ASSOC)){
                $row['keyword'] = str_replace(" " . $key . "", "", $row['keyword']);
                $dataArray[$key][$row['datei_name'] . ".html"] = $row['keyword'];
                $count[$key] = ++$i;
            }
        }

        $this->_view->assign("data", $dataArray);
        $this->_view->assign("item_count", $count);

        return $this->_view->render("content/wissen.phtml");
    }

    /**
     * Enter description here...
     *
     * @param array  $data
     * @param string $theme
     * @param array  $requestData
     *
     * @return string
     * @access public
     */
    public function getLinkList(array $data, $theme, array $requestData)
    {
        $content     = '';
        $header     = '';
        $bezug         = substr_count($data['datei_name'], $theme . '-') ? $data['bezug'] : $data['nav_id'];
        //$where        = ' bezug = ' . $bezug;
        //$order         = " ORDER BY createdate DESC";
        $t          = 0;

        if ($theme == "-lexikon" || $data['datei_name'] == "banken-uebersicht") {
            $limit = '';
        } else {
            $limit = isset($requestData['lmt']) ? ' LIMIT ' . intval($requestData['lmt']) . ',10' : ' LIMIT 0,10';
        }

        $sql = 'SELECT * FROM pages WHERE bezug = :bezug ORDER BY createdate DESC ' . $limit;

        $stmt = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY, PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true));
        $stmt->bindParam(':bezug', $bezug);
        //$stmt->bindParam(':order', $order);
        //$stmt->bindParam(':limit', $limit);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //$result = $this->_db->query('SELECT * FROM pages' . $where . $order . $limit);

        if ($theme == "-lexikon" || $data['datei_name'] == "banken-uebersicht") {
            $lexikon  = $this->makeLexikon($rows,$data,$requestData);
            $content .= $lexikon['html'];
            $pageNav  = $lexikon['pageNav'];
        } else {
            $pageNav  = $this->makePageNav($data,$requestData,$bezug);
            $content .= '<p><ul>';

            foreach ($rows as $row) {
                $array[]  = $row['datei_name'];
                $newsItem = $this->makeNewsOverview($data, $row, $requestData);

                $aNews[$row['createdate']][$t++] = $newsItem;
            }

            $color = 0;

            if (isset($aNews)) {
                krsort($aNews);

                foreach ($aNews as $keys => $values) {
                    foreach ($values as $key => $value) {
                        $colorClass = (++$color % 2) ? "secondLi" : "firstLi";
                        $content   .= str_replace('colorClass',$colorClass,$value['html']);
                    }
                }
            }

            $content .= "</ul></p>";
        }

        if (!empty($array)) {
            $header =  preg_match('/'.$theme.'/',$data['parent']['datei_name']) ? '<div class="h3">' . $data['parent']['keyword'] . ' auf einen Blick!</div>' : '<div class="h3">' . $data['keyword'] . ' auf einen Blick!</div>';
        }

        $content = $theme != "-lexikon" ? $header . $pageNav . $content . $pageNav : $header . $pageNav . $content;

        return $content;
    }

    /**
     * Enter description here...
     *
     * @param array  $data
     * @param string $theme
     * @param array  $requestData
     *
     * @return string
     * @access public
     */
    public function getLinkListOnly(array $data, $theme, array $requestData)
    {
        $list = $this->getLinkList($data, $theme, $requestData);
        $this->_view->assign('data',$data);
        $this->_view->assign('list',$list);
        $this->_view->display('content/linklist_only.phtml');
        exit();
    }

    /**
     * Enter description here...
     *
     * @param array  $data
     * @param array  $requestData
     * @param string $bezug
     *
     * @return string
     * @access public
     */
    public function makePageNav(array $data, array $requestData, $bezug)
    {
        $pageNav = '';

        $stmt = $this->_db->prepare('SELECT * FROM pages WHERE bezug = :bezug', array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY, PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true));
        $stmt->bindParam(':bezug', $bezug);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($result)) {
            $req   = isset($requestData['list']) ? array('list' => $requestData['list']): array();
            $count = $stmt->rowCount();

            if ($count > 10) {
                $page = isset($requestData['lmt']) ? $requestData['lmt']/10+1 : 1;
                $k    = 10;

                for ($j = 0; $j <= ($count); $j ++) {
                    if ($j == $k || $j == ($count)) {
                        $req['lmt'] = ($k - 10);
                        $pageNav   .= $page == ($k / 10) ? " | <span>" . ($k / 10) . "</span>" : ' | <a href="' . $this->postToGetUrl(_URL  . $data['datei_name'] . '.html',$req) . '">' . ($k/10) . '</a>';

                        $k += 10;
                    }
                }
            }
        }

        if ($pageNav != '') {
            $pageNav = '<div class="pagenav"><span>Seite</span> ' . $pageNav . '</div>';
        }

        return $pageNav;
    }

    /**
     * Enter description here...
     *
     * @param array $data
     * @param array $row
     * @param array $requestData
     *
     * @return array
     * @access public
     */
    public function makeNewsOverview(array $data, array $row, array $requestData)
    {
        if (isset($requestData['list']) && $requestData['list'] == 'only')
        {
            $requestData['show'] = 1;
        }
        $item               = array('html' => '');
        $item['link']        = $this->postToGetUrl(_URL . '/' . $row['datei_name'] . '.html',$requestData);
        $item['date']         = strftime("%d.%m.%Y", $this->makeTimestamp($row['createdate']));
        $item['headline']     = $row['header'];
        $item['more']        = ' <a href="' . $item['link'] . '">mehr...</a>';
        $item['text']         = '<p>' . $this->truncate(strip_tags($row['text']),200,$item['more'],false) . '</p>';

        if ($data['datei_name'] == $row['datei_name'] && isset($requestData['show']) && $requestData['show'] == 1) {
            $item['html'] = '<li class="colorClass"><strong>' . $item['headline'] . '</strong><br />' . $row['text'] . '</li>';
        } elseif (isset($requestData['list']) && $requestData['list'] == 'only') {
            $item['html'] = '<li class="colorClass"><a href="' . $item['link'] . '"><strong>' . $item['headline'] . '</strong></a></li>';
        } elseif ($data['datei_name'] == $row['datei_name']) {
            $item['html'] = '<li class="colorClass"><strong>' . $item['headline'] . '</strong></span><br />' . $item['text'] . '</li>';
        } else {
            $item['html'] = '<li class="colorClass"><a href="' . $item['link'] . '"><strong>' . $item['headline'] . '</strong></a><br />' . $item['text'] . '</li>';
        }

        return $item;
    }

    /**
     * Enter description here...
     *
     * @param array   $data
     * @param integer $start
     * @param integer $end
     * @param string  $cnttype
     * @param string  $category
     * @param string  $newstype
     *
     * @return string
     * @access public
     */
    public function showLatestNews(array $data, $start, $end, $cnttype, $category = null, $newstype = null)
    {
        $crossLinks = '';
        $cnt   = new Model_Core_Content($this->_view);
        $limit = " LIMIT " . $start . "," . $end;
        $nt    = $newstype ? $newstype : 'allgemeines';

        if ($category != null) {
            $select = "SELECT createdate,datei_name,header,text,bezug"
                    . " FROM  pages"
                    . " WHERE datei_name LIKE '" . $data['datei_name'] . "-" . $nt . "-%'"
                    . " ORDER BY createdate DESC"
                    . $limit;

            /*
            if ($showcrosslinks) {
                $crossLinks = $this->showCrossLinks($data, 0, 10);
                srand ((float)microtime() * 1000000);
                !empty($crossLinks) ? shuffle($crossLinks) : 0;
                $this->_view->assign('crosslinks', $crossLinks);
            }
            /**/
        } else {
            $select = "SELECT createdate,datei_name,header,text,bezug"
                    . " FROM news AS a"
                    . " INNER JOIN pages AS b"
                    . " ON a.news_id = b.nav_id"
                    #. " GROUP BY a.category"
                    . " ORDER BY b.createdate DESC"
                    . $limit;
        }

        $result = $this->_db->query($select);
        $i      = 0;
        $news   = array();

        $rows = $result->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $row) {
            $news[$i]         = $row;
            srand ((double)microtime()*1000000);
            $news[$i]['rdm']  = rand(1, 73);
            $news[$i]['text'] = strip_tags($news[$i]['text']);
            $parent           = $cnt->getParentCategory($row);

            $news[$i]['maincategory'] = $cnt->getMainCategory($parent);

            $i++;
        }

        $this->_view->assign('news', $news);
        $cnt = $this->_view->render('news/news' . $cnttype . '.phtml');

        return $cnt;
    }

    /**
     * Enter description here...
     *
     * @param array   $data
     * @param integer $start
     * @param integer $end
     *
     * @return array
     * @access public
     */
     public function showCrossLinks(array $data, $start, $end)
    {
        $cnt   = new App_Model_Core_Content($this->_view);
        $limit = " LIMIT " . $start . "," . $end;
        $i     = 0;

        $data['cat_id'] == 0 ? $where = " WHERE cat_id = " . $data['nav_id'] : $where = " WHERE cat_id = " . $data['cat_id'];

        $result = $this->_db->query("SELECT keyword,datei_name,header,bezug"
                                . " FROM pages"
                                . $where
                                . " AND datei_name LIKE '%-allgemeines-%'"
                                . " AND datei_name NOT LIKE '" . $data['datei_name'] . "-allgemeines-%'"
                                . " GROUP BY bezug"
                                . " ORDER BY createdate"
                                . $limit);

        $lnk = array();

        while ($result && $row = $result->fetch(PDO::FETCH_ASSOC)) {
            $lnk[$i] = $row;
            $parent  = $cnt->getParentCategory($row);

            $lnk[$i++]['maincategory'] = $cnt->getMainCategory($parent);
        }

        unset($cnt);

        return $lnk;
    }

    /**
     * Enter description here...
     *
     * @return array
     * @access public
     */
    public function makeBankOverview()
    {
        $result = $this->_db->query("SELECT * FROM blz_liste ORDER BY name_voll ASC");

        $array = array();

        while ($result && $row = $result->fetch(PDO::FETCH_ASSOC)) {
            $first_char = substr($row['name_voll'], 0, 1);

            $array[$first_char][$row['name_voll']] = $row['blz'];
        }

        return $array;
    }

    /**
     * Enter description here...
     *
     * @param mixed $result mysql-reference
     * @param array $data
     * @param array $req
     *
     * @return unknown
     * @access public
     */
    public function makeLexikon(array $rows, array $data, $req)
    {
        $lexikon         = array();
        $lexikon['html'] = '';
        $a_to_z          = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");

        if ($data['datei_name'] == "banken-uebersicht") {
            $lexikon_array          = $this->makeBankOverview();
            $lexikon['pageNav']     = '<div class="pagenav"><span>&Uuml;bersicht:</span>';
        } else {
            $lexikon_array          = $this->makeLexikonArray($rows);
            $lexikon['pageNav']     = '<div class="pagenav"><span>Lexikon:</span>';
        }

        $aKey  = array_keys($lexikon_array);
        $dlist = (isset($req['dlist']) && $req['dlist'] != '') ? $req['dlist'] : $aKey[count($aKey)-1];

        //generate the list A-Z
        if (count($lexikon_array) > 0) {
            for ($i = 0, $count = count($a_to_z); $i < $count; $i++) {
                if (empty($lexikon_array[$a_to_z[$i]])) {
                    $lexikon['pageNav'] .= " <span>" . $a_to_z[$i] . '</span>';
                } else {
                    $item = $a_to_z[$i] == $dlist ? '<span style="color:#c00;">' . $a_to_z[$i] . '</span>' : $item = $a_to_z[$i];

                    $lexikon['pageNav'] .= ' <a href="' . _URL . '/' . $data['datei_name'] . '.html?dlist=' . $a_to_z[$i] . '">'. $item . '</a>';
                }
            }

            $lexikon['pageNav'] .= '</div>';

            //generate the list of articles
            if ($data['datei_name'] == "banken-uebersicht") {
                $lexikon['html'] .= "<p><ul>";

                foreach ($lexikon_array[$dlist] as $key => $value) {
                    $array[]          = $key;
                    $lexikon['html'] .= '<li>' . $key . '<br /><span style="color:#999;">Blz:</span> <span style="color:#7DC035;">' . $value . '</span></li>';
                }

                $lexikon['html'] .= '</ul></p><br /><br />';
            } else {
                $lexikon['html'] .= '<p><ul>';

                foreach ($lexikon_array[$dlist] as $key => $value) {
                    $array[]          = $key;
                    $lexikon['html'] .= $key == $data['datei_name'] ? '<li>' . $value . '</li>' : '<li><a href="' . _URL . '/' . $key . '.html?dlist=' . $dlist . '">'. $value . '</a></li>';
                }

                $lexikon['html'] .= '</ul></p><br /><br />';
            }
        }

        return $lexikon;
    }

    /**
     * Enter description here...
     *
     * @param mixed $result mysql-reference
     *
     * @return array
     * @access public
     */
    public function makeLexikonArray($rows)
    {
        $array = array();

        foreach ($rows as $row) {
            $first_char = substr($row['keyword'], 0, 1);

            $array[$first_char][$row['datei_name']] = $row['keyword'];
        }

        return $array;
    }

    /**
     * Enter description here...
     *
     * @param array $data
     *
     * @return array
     * @access public
     */
    public function getServiceBoxes(array $data)
    {
        $theme      = false;
        $themeArray    = array("-faq", "-allgemeines", "-test", "-tipp",  "-lexikon", "-policenverkauf");

        foreach ($themeArray as $value) {
            if (strpos($data['datei_name'], $value)) {
                $theme              = true;
                $data['datei_name'] = substr($data['datei_name'], 0, strpos($data['datei_name'], $value));
                break;
            }
        }

        if ($theme)    {
            $data['xtraModule'] =  $this->serviceBox($data);
        } elseif (preg_match_all("/\[BOX([0-9]+)\]/", $data['text'],$boxID)) {
            foreach ($boxID[1] as $key=>$value) {
                $sb           = $this->serviceBox($data, $value);
                $data['text'] = str_replace('[BOX'.$value.']', $sb, $data['text']);
            }
        } else {
            if (isset($data['xtraModule'])) {
                $data['xtraModule'] .= $this->serviceBox($data);
            } else {
                $data['xtraModule'] = $this->serviceBox($data);
            }
        }

        return $data;
    }

    /**
     * get the service boxes who was to the formulars linked
     *
     * @param array   $data
     * @param integer $boxID (optional)
     *
     * @access public
     * @return string
     */
    public function serviceBox(array $data, $boxID = null)
    {
        $intension = '';
        $where     = "WHERE category LIKE '" . $data['datei_name'] . "' ORDER BY box_id ASC";
        $clear     = '';

        if ($boxID) {
            $where = "WHERE box_id = " . $boxID;
            $clear = 'clear';
        }

        $sql1  = 'SELECT * FROM service_boxen ' . $where;
        $stmt1 = $this->_db->prepare($sql1, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY, PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true));
        //$stmt1->bindParam(':textid', $textIDs[0]);
        $stmt1->execute();
        $rows1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
        //$result = $this->_db->query("SELECT * FROM service_boxen " . $where . "");

        if (isset($rows1[0])) {
            $rows = $rows1[0];
        } else {
            $rows = false;
        }

        if ($rows) {
            $textIDs = explode(";", $rows['text_ids']);

            if (is_array($textIDs)) {
                $and = " text_id = " . implode(" OR text_id = ", $textIDs);

                $sql2  = 'SELECT * FROM service_texte WHERE ' . $and;
                $stmt2 = $this->_db->prepare($sql2, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY, PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true));
                //$stmt2->bindParam(':textid', $textIDs[0]);
                $stmt2->execute();
                $rows2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                //$result2 = $this->_db->query("SELECT * FROM service_texte WHERE text_id = " . $textIDs[0] . $and);

                //array mit intensionen die keine pkvoffer bekommen
                foreach ($rows2 as $row) {
                    $this->style = ($this->style == " nextLnk" ? '' : " nextLnk");

                    $intension    .= '<div class="intension' . $this->style . '">'
                                .  '<img src="' . IMAGE_URL . 'info/' . $row['icon'] . '" align="left" border="0" />'
                                .  '<a href="' . _URL . '/' . $row['textlink'] . '.html">'
                                .  $row['text']
                                .  '</a></div>';
                }

                $intension = '<div class="intensionIntro ' . $clear . '">' . $rows['header'] . '</div>' . $intension;
            }
        }

        return $intension;
    }

    /**
     * Enter description here...
     *
     * @param string $name
     *
     * @return string
     * @access public
     */
    public function getMiniFormulares($name)
    {
        if (file_exists(VIEW_PATH . 'scripts'. DS . 'formulare_mini' . DS . 'formular_mini_' . $name . '.phtml')) {
            return $this->_view->render("formulare_mini/formular_mini_" . $name . ".phtml");
        } else {
            return false;
        }
    }

    /**
     * Enter description here...
     *
     * @param array  $data
     * @param string $theme
     * @param string $name
     *
     * @return string
     * @access public
     */
    public function getInfoBox(array $data, $theme, $name)
    {
        //link to the wissen/faq site : link to default test site
        $link       = ($name == "Test" ? "versicherungsvergleich-test" : "wissen");
        $insurance  = "Versicherung";
        $theme_name = $name;

        $result = $this->_db->query("SELECT COUNT(*) FROM pages WHERE datei_name LIKE '" . $data['datei_name'] . $theme . "'");

        if ($result && $row = $result->fetch(PDO::FETCH_ASSOC)) {
            $link         = $data['datei_name'] . $theme;
            $name        .= " - " . str_replace($name,"", $data['keyword']);
            $insurance     = $data['keyword'];
        } else {
            $result = $this->_db->query("SELECT * FROM pages WHERE datei_name LIKE '" . $data['maincategory']['datei_name'] . $theme . "'");

            if ($result && $row = $result->fetch(PDO::FETCH_ASSOC)) {
                $link         = $row['datei_name'];
                $name        .= " - " . str_replace($name, "", $row['keyword']);
                $insurance     = $row['keyword'];
            }
        }

        $this->_view->assign("LINK", $link);
        $this->_view->assign("NAME", $name);
        $this->_view->assign("INSURANCE", $insurance);
        $this->_view->assign("THEMENAME", $theme_name);

        return $this->_view->render("content/infoBox.phtml");
    }

    /**
     * Enter description here...
     *
     * @param string $domain
     *
     * @return string
     * @access public
     */
    public function showKfzCalc($domain)
    {
        $request = '';
        $request .= (isset($_REQUEST['controller']) ? "/" . $_REQUEST['controller'] : "/Vergleich");
        $request .= (isset($_REQUEST['action']) ? "/" . $_REQUEST['action'] . "/" : "/Schritt1/");

        $kfz_track_id = (isset($_REQUEST['nl_paid']) ? 'kfz_track_id=' . $_REQUEST['nl_paid'] . '&' : '');
        $request .= "?" . $kfz_track_id . "kfzurl=" . urlencode("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REDIRECT_URL']);

        if (!isset($_REQUEST['RecordId']))
        {
            if (isset($_REQUEST['SessID']))
            {
                $request .= "&SessID=" . $_REQUEST['SessID'] . "";
            } else {
                $sessid   = $this->getCurlContent(KF_URL . "/Vergleich/SessionId/", 40, 60);
                $request .= "&SessID=" . $sessid;
            }
        }

        $reqArray1 = explode('&',urldecode($_SERVER['QUERY_STRING']));

        foreach ($reqArray1 as $ra1)
        {
            $reqArray2 = explode('=', $ra1);
            $request .= (isset($reqArray2[1]) ? '&'.$reqArray2[0].'='.urlencode($reqArray2[1]) : '');
        }
        $url  = KF_URL . "/" . $request;
        $calc = $this->getCurlContent($url, 40, 60);

        if (strlen($calc) > 100)
        {
            $calc = '<a name="vergleich"></a>' . $calc;
        } else {
            $calc = '<!-- ' . urlencode($calc) . ' -->' . "\n" . '<p style="color:#c00;">Es ist ein Fehler aufgetreten. Bitte versuchen Sie es sp&auml;ter noch einmal.<br /><br />' . "\n" . 'Vielen Dank f&uuml;r Ihr Verst&auml;ndnis.</p>';
        }

        return $calc;
    }

    /**
     * Enter description here...
     *
     * @param string $domain
     *
     * @return string
     * @access public
     */
    public function showRiester($domain)
    {
        /*
        if ($_SERVER['HTTP_HOST'] == 'www.geld.de') {
            $protokoll = 'https://';
        } else {
            $protokoll = 'http://';
        }
        */

        $protokoll = 'http://';

        $request  = '';
        $request .= (isset($_REQUEST['controller']) ? "/" . $_REQUEST['controller'] : "/Vergleich");
        $request .= (isset($_REQUEST['action']) ? "/" . $_REQUEST['action'] . "/" : "/Eingabe/");

        $riester_track_id = (isset($_REQUEST['nl_paid']) ? '$riester_track_id=' . $_REQUEST['nl_paid'] . '&' : '');
        $request .= "?" . $riester_track_id . "riesterurl=" . urlencode($protokoll . $_SERVER['HTTP_HOST'] . $_SERVER['REDIRECT_URL']);

        $reqArray1 = explode('&',urldecode($_SERVER['QUERY_STRING']));
        $ajax      = false;

        if ($_REQUEST['action'] == 'ShowAntrag' || $_REQUEST['action'] == 'Download') {
            $ajax = true;
        }

        foreach ($reqArray1 as $ra1) {
            $reqArray2 = explode('=', $ra1);
            if (!$ajax && $reqArray2[0] == 'action' && $reqArray2[1] == 'Berufe') {
                $ajax = true;
            }
            $request  .= (isset($reqArray2[1]) ? '&'.$reqArray2[0].'='.urlencode($reqArray2[1]) : '');
        }
        $url  = RIESTER_URL . $request;
        //var_dump($url);
        $calc = $this->getCurlContent($url, 180, 180);
        //var_dump($calc);
        //debugster($calc);
        if (strlen($calc) > 100) {
            $calc = '<a name="vergleich"></a>' . $calc;
        } else {
            $calc = '<!-- ' . urlencode($calc) . ' -->' . "\n" . '<p style="color:#c00;">Es ist ein Fehler aufgetreten. Bitte versuchen Sie es sp&auml;ter noch einmal.<br /><br />' . "\n" . 'Vielen Dank f&uuml;r Ihr Verst&auml;ndnis.<\/p>';
        }

        return $calc;
    }

    /**
     * @access protected
     */
    protected function parse($mvalues)
    {
        for ($i=0; $i < count($mvalues); $i++) {
            $mol[$mvalues[$i]["tag"]] = $mvalues[$i]["value"];
        }
        return $mol;
    }

    /**
     * Enter description here...
     *
     * @param array $data
     * @param array $requestData
     *
     * @return void
     * @access public
     */
    public function array_walk_recursive2(&$input, $funcname, $userdata = '')
    {

        if(!function_exists('array_walk_recursive')) {
            if (!method_exists($this, $funcname)) {
                return false;
            }

            if (!is_array($input)) {
                return false;
            }

            foreach ($input as $key=>$value) {
                if (is_array($input[$key])) {
                    if (isset($this)) {
                        eval('$this->' . __function__ . '($input[$key], $funcname, $userdata);');
                    } else {
                        if (@get_class($this)) {
                            eval(get_class() . '::' . __function__ . '($input[$key], $funcname, $userdata);');
                        } else {
                            eval(__function__ . '($input[$key], $funcname, $userdata);');
                        }
                    }
                } else {
                    $saved_value = $value;

                    if (is_array($funcname)) {
                        $f = '';

                        for ($a = 0; $a < count($funcname); $a++) {
                            if(is_object($funcname[$a])) {
                                $f .= get_class($funcname[$a]);
                            } else {
                                if ($a > 0) {
                                    $f .= '::';
                                }
                                $f .= $funcname[$a];
                            }
                        }
                        $f .= '($value, $key' . (!empty($userdata) ? ', $userdata' : '') . ');';
                        eval($f);
                    } else {
                        if(!empty($userdata)) {
                            eval('$this->'.'($value, $key, $userdata);');
                        } else {
                            eval('$this->'.$funcname.'($value, $key);');
                        }
                    }

                    if ($value != $saved_value) {
                        $input[$key] = $value;
                    }
                }
            }

            return true;
        } elseif (is_array($input)) {
            array_walk_recursive($input, array($this, $funcname), $userdata);
            return true;
        }
    }

    /**
     * Enter description here...
     *
     * @param array $data
     * @param array $requestData
     *
     * @return array
     * @access public
     */
    public function setFileParams(array $data)
    {
        $i = 0;
        $files = array();
        foreach($data['dokumente']['files'] as $key => $value)
        {
            $files[$i]['url']  = $data['dokumente']['path'] . $value;
            $files[$i]['name'] = substr($value, 4, strpos($value, '.') - 4);
            $i++;
        }
        $data['dokumente']['files'] = $files;
        return $data;
    }

    /**
     * Enter description here...
     *
     * @param array $arr
     *
     * @return array
     * @access public
     */
    public function formArray(array $arr)
    {
        //$i   = 0;
        $new = array();

        if (is_array($arr)) {
            foreach ($arr as $key => $value) {
                if (strlen($value) > 0) {
                    $key = str_replace('key_', '', $key);
                    $new[$key] = $value;
                }
            }
        }

        return $new;
    }

    /**
     * Enter description here...
     *
     * @return array
     * @access public
     */
    function getDefaultDates()
    {
        $dd = array();

        $dd['day']      = $this->_DATUM_TAGE;
        $dd['month']    = $this->_DATUM_MONATE_2;
        $dd['curmonth'] = date("m");

        /* versicherungsbeginn jahr */
        $year    = date("Y");
        $yearmin = $year - 105; /* max 105 Jahre */
        $yearmax = $year + 1; /* kein min */

        for ($yearmin; $yearmin < $yearmax; $yearmin++) {
            $dd['year'][$yearmin] = $yearmin;
        }

        $dd['versjahr'][substr($year, 2)] = $year;
        $dd['versjahr'][substr(strval($year + 1), 2)] = strval($year + 1);

        if ($dd['curmonth'] == '12') {
            $year = $year + 1;
        }

        return $dd;
    }

    /**
     * Enter description here...
     *
     * @return array
     * @access public
     */
    public function loadRss()
    {
        /*
        require_once 'XML/RSS.php';

        $rss = new XML_RSS("http://blog.blindwerk.de/?feed=rss", "iso-8859-1");
        $rss->parse();
        $ntv = $rss->getItems();

        return $ntv;
        */
    }

    /**
     * email blacklist
     *
     * @param string $mail
     *
     * @return boolean
     * @access public
     */
    public function mailOnBlacklist($mail)
    {
        /* email blacklist from thomas_kroehs_kfz DB */
        #$db = new database(DB_SERVER_KROEHS,"thomas_kroehs_kfz","thomas_kroehs","XSSfRIFJ");
        #$result = $db->query("SELECT * FROM thomas_kroehs_kfz.email_blacklist WHERE email LIKE '%" . $mail . "%'");

        #if ($result && $result->rowCount()) {
        #    $return = false;
        #} else {
        #    $return = true;
        #}

        #unset($db);
        #return $return;
    }

    /**
     * extra smarty truncate
     *
     * @param string  $string
     * @param integer $length
     * @param string  $etc
     * @param boolean $break_words
     *
     * @return string
     * @access public
     */
    public function truncate($string, $length = 80, $etc = '...', $break_words = false)
    {
        if ($length == 0) {
            return '';
        }

        if (strlen($string) > $length) {
            $length -= strlen($etc);

            if (!$break_words) {
                $string = preg_replace('/\s+?(\S+)?$/', '', substr($string, 0, $length+1));
            }
            return substr($string, 0, $length) . $etc;
        } else {
            return $string;
        }
    }

    /**
     * Enter description here...
     *
     * @param string $string
     *
     * @return string
     * @access public
     */
    public function prepareLink($string)
    {
        $sz = array(
                "?"         => "ae",
                "?"         => "ae",
                "?"         => "oe",
                "?"         => "oe",
                "?"         => "ue",
                "?"         => "ue",
                "?"         => "ss",
                "\""     => "",
                "?"         => "",
                ":"         => "",
                "."         => "",
                ","         => "",
                "%"        => "",
                "/ "     => "",
                " "         => "-",
                );

        while (list($key, $value) = each($sz)) {
            $string = str_replace($key, $value, trim($string));
        }

        $string = str_replace("---", "-", trim($string));
        return strtolower($string);
    }

    /**
     * Enter description here...
     *
     * @return string
     * @access public
     */
    public function setSplitTest()
    {
        $minute = date('i');
        $split  = ($minute % 2) ? '1' : '2';
        return $split;
    }

    /**
     * Enter description here...
     *
     * @param string $string
     *
     * @return integer
     * @access public
     */
    public function makeTimestamp($string)
    {
        if (empty($string)) {
            $string = "now";
        }

        $time = strtotime($string);

        if (is_numeric($time) && $time != -1) {
            return $time;
        }

        // is mysql timestamp format of YYYYMMDDHHMMSS?
        if (preg_match('/^\d{14}$/', $string)) {
            $time = mktime(substr($string,8,2),substr($string,10,2),substr($string,12,2),substr($string,4,2),substr($string,6,2),substr($string,0,4));
            return $time;
        }

        // couldn't recognize it, try to return a time
        $time = (int) $string;
        if ($time > 0) {
            return $time;
        } else {
            return time();
        }
    }

    /**
     * @access public
     */
    public function speichereGutscheinEmail($email)
    {
        $sql = "INSERT IGNORE INTO Gutschein_Email_Temp (email) VALUES ('$email');";
        $id  = $this->_db->insert($sql);
        return $id;
    }

    /**
     * @access public
     */
    public function prepareCostumerData(array $kundenDaten)
    {
        if(strlen($kundenDaten['geschlecht']) > 4)
        {
            $kundenDaten['geschlecht'] = ($kundenDaten['geschlecht'] == 'weiblich') ? 'w' : 'm';
        }

        if($kundenDaten['geschlecht'] == 'm'){
            $kundenDaten['titel']     = 'Herr';
            $r     = 'r';
        }elseif($kundenDaten['geschlecht'] == 'w'){
            $kundenDaten['titel']     = 'Frau';
            $r     = '';
        }else{
            $kundenDaten['titel']     = '';
            $r     = '/r';
        }
        $kundenDaten['anrede']     = 'Sehr geehrte' . $r . ' ' . $kundenDaten['titel'] . ' ' . ucfirst($kundenDaten['vorname']) . ' ' . ucfirst($kundenDaten['name']);

        return $kundenDaten;
    }

    /**
     * @access public
     */
    public function strtoupperfirst($str)
    {
        $str = explode(' ', strtolower($str));
        //var_dump($str);
        for($i = 0; $i < count($str); $i++){
            $str[$i] = strtoupper(substr($str[$i], 0, 1)) . substr($str[$i], 1);
        }
        return implode(' ', $str);
    }
} #END CLASS