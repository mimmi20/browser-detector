<?php
/**
 * Funktionen für Advertising
 *
 * PHP version 5
 *
 * @category  Geld.de
 * @package   Admedia
 * @author    Marko Schreiber <marko.schreiber@unister-gmbh.de>
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2009 Unister GmbH
 * @version   SVN: $Id: Admedia.php 13 2011-01-06 21:27:04Z tmu $
 */
require_once LIB_PATH . 'Unister' . DS . 'Finance' . DS . 'Core' . DS . 'Abstract.php';

/**
 * Funktionen für Advertising
 *
 * @category  Geld.de
 * @package   Admedia
 * @author    Marko Schreiber <marko.schreiber@unister-gmbh.de>
 * @author    Thomas Mueller <thomas.mueller@unister-gmbh.de>
 * @copyright 2007-2009 Unister GmbH
 */
class Unister_Finance_Core_Admedia extends Unister_Finance_Core_Abstract
{
    /**
     * @var    array
     * @access protected
     */
    protected $google_data = array(
        'text'                     => '',
        'googleOnTop'             => '',
        'googleOnBottom'         => '',
        'getGoogleAds'             => '',
        'google_max_num_ads'     => '',
    );

    /**
     * @access public
     */
    public function getAllGoogle($data, $requestData, $params = null)
    {
        if($data['googleads_on'] == '1' || empty($data['nav_id'])){
            if(isset($requestData['searchstr']) || isset($requestData['afs'])){
                if($data['nav_id'] == '3' || $data['cat_id'] == '3' || ($data['nav_id'] == 100 && isset($requestData['lnd']))){
                    //kfz
                    $keyword = urldecode($requestData['searchstr']);
                    $params['OutputFormat'] = 'w8';
                    $params['Search']         = $keyword;
                    $params['special']        = 1;
                    $params['logClient']    = 'kfz';

                    if ($data['nav_id'] == 100 && !isset($requestData['controller'])) {
                        $params['OutputFormat'] = 'w10';
                    } elseif ($data['nav_id'] == 100 && isset($requestData['controller']) && isset($requestData['lnd'])) {
                        $params['OutputFormat'] = 'w6';
                    }
                    //get afs
                    $google_data             = $this->getGoogleSearch($data, $params);
                    //googlead between the header and text
                    // Replace GoogleAds for KFZ Landingpage
                    if ($data['nav_id'] == 100 && isset($requestData['lnd']))
                    {
                        $data['content'] = str_replace('<div id="kfzbox"',$google_data['googleOnTop'] . '<div id="kfzbox"',$data['content']);
                    } elseif ($data['header'] == ' ' || $data['header'] == '') {
                        $data['content'] = str_replace('<h2 class="clearfix"> </h2>', '<!-- AFS -->' . $google_data['googleOnTop'] , $data['content']);
                    } else {
                        $data['content'] = str_replace('</h2>', '</h2><!-- AFS -->' . $google_data['googleOnTop'] , $data['content']);
                    }
                    $data['google_bottom']    = $google_data['googleOnBottom'];
                    $data['getGoogleAds']     = $google_data['getGoogleAds'];
                } else {
                    //afs with search string on regular pages, ignoring google setup for pages
                    $params['searchstr']     = isset($params['searchstr']) ? $params['searchstr'] : urldecode($requestData['searchstr']);

                    if($data['googleads_on_top'] == '1'){

                        $params['OutputFormat'] = isset($params['OutputFormat']) ? $params['OutputFormat'] : 'w10';

                        $google_data = $this->getGoogleSearch($data, $params);
                        //googlead between the header and text
                        if ($data['nav_id'] == 1) {
                            $data['content'] = str_replace('[GOOGLE_MAIN]', $google_data['googleOnTop'], $data['content']);
                        } else {
                            if (trim($data['header']) == '') {
                                $data['content'] = str_replace('<h2 class="clearfix"> </h2>', '<!-- AFS -->' . $google_data['googleOnTop'] , $data['content']);
                            } else {
                                $data['content'] = str_replace('</h2>', '</h2><!-- AFS -->' . $google_data['googleOnTop'] , $data['content']);
                            }
                        }
                        $data['google_top']     = $google_data['googleOnTop'];
                        $data['google_bottom']     = $google_data['googleOnBottom'];
                        $data['getGoogleAds']     = $google_data['getGoogleAds'];
                    } else {
                        $params['OutputFormat'] = isset($params['OutputFormat']) ? $params['OutputFormat'] : 'w5';

                        $google_data             = $this->getGoogleSearch($data, $params);
                        $data['google_bottom']     = $google_data['googleOnTop'];
                        $data['getGoogleAds']     = $google_data['getGoogleAds'];
                    }
                }
            } else {
                empty($data['nav_id']) ? $data['googleads_on_top'] = '1' : false;
                isset($requestData['afc']) && $requestData['afc'] == 'off' ? $data['googleads_on_top'] = '0' : false;
                if ($data['googleads_on_top'] == '1') {
                    if($data['nav_id'] == "1"){
                        $this->google_data                 = $this->showGoogleAds($data,1);
                        $data['google_max_num_ads']        = $this->google_data['google_max_num_ads'];
                        $data['content']                 = str_replace('[GOOGLE_MAIN]', $this->google_data['text'] , $data['content']);
                    } elseif($data['nav_id'] == '239' || $data['nav_id'] == '241' || $data['nav_id'] == '874') {
                        $this->google_data                = $this->showGoogleAds($data,5);
                        $data['google_max_num_ads']        = $this->google_data['google_max_num_ads'];
                        $data['content']                 = str_replace('</h2>', '</h2><!-- AFC -->' . $this->google_data['text'] , $data['content']);
                    } elseif ($data['nav_id'] == 100) {
                        $this->google_data                = $this->showGoogleAds($data,9);
                        $data['google_max_num_ads']        = $this->google_data['google_max_num_ads'];
                        $data['content']                = str_replace('<div id="kfzbox"',$this->google_data['text'] . '<div id="kfzbox"',$data['content']);
                    } else {
                        //googlead between the header and text
                        $this->google_data                  = $this->showGoogleAds($data,2);
                        $data['google_max_num_ads']      = $this->google_data['google_max_num_ads'];
                        $data['content']                   = str_replace("</h2>", "</h2><!-- AFC -->" . $this->google_data['text'] , $data['content']);
                        if(strlen($data['text']) > 1800 && $data['form_id'] != "47"){
                            $this->google_data               = $this->showGoogleAds($data,2);
                            $data['google_max_num_ads'] += $this->google_data['google_max_num_ads'];
                            $data['content']              = $this->isEnoughForGoogle($data, $this->google_data['text']);
                        }
                    }

                    if ($data['datei_name'] == 'kreditkarten') {
                        $this->google_data                  = $this->showGoogleAds($data,6);
                        $data['google_bottom']              = $this->google_data['text'];
                        $data['google_max_num_ads']    += $this->google_data['google_max_num_ads'];
                        $data['google_data']              = $this->google_data['text'];
                    } elseif ($data['nav_id'] == 100) {
                        $this->google_data                = $this->showGoogleAds($data,10);
                        $data['google_bottom']              = $this->google_data['text'];
                        $data['google_max_num_ads']    += $this->google_data['google_max_num_ads'];
                        $data['google_data']              = $this->google_data['text'];
                    } else {
                        $this->google_data                  = $this->showGoogleAds($data,0);
                        $data['google_bottom']              = $this->google_data['text'];
                        $data['google_max_num_ads']    += $this->google_data['google_max_num_ads'];
                    }
                } elseif (isset($requestData['aktion'])) {
                    switch ($requestData['aktion']) {
                    case 'pkv-landing-2':
                                $data['google_afc_channel'] = '2';
                                $this->google_data             = $this->showGoogleAds($data,7);
                                $data['google_bottom']         = $this->google_data['text'];
                                $data['google_max_num_ads'] += $this->google_data['google_max_num_ads'];
                                break;
                    default:     $this->google_data             = $this->showGoogleAds($data,2);
                                $data['google_bottom']         = $this->google_data['text'];
                                $data['google_max_num_ads'] += $this->google_data['google_max_num_ads'];
                                break;
                    }
                } else {
                    $this->google_data             = $this->showGoogleAds($data,4);
                    $data['google_bottom']         = $this->google_data['text'];
                    $data['google_max_num_ads'] += $this->google_data['google_max_num_ads'];
                }

                $data['getGoogleAds'] = $this->getGoogleAds($data);

            }

            //var_dump($data['getGoogleAds']);
        }

        return $data;
    }

    /**
     * @access protected
     */
    protected function showGoogleAds(array $data, $parseID = null)
    {
        $google_ad       = array();
        $google_slider   = "";
        $google_anzeigen = '<h1 class="headWithIcon">Google-Anzeigen<\/h1>';
        
        switch ($parseID) {
        case 1:
            $google_style     = 'googleMainPage';
            $google_max_num_ads = '3';
            $start     = '0';
            $end    = '2';
            #$google_max_num_ads = '5';
            #$start     = '0';
            #$end    = '4';
            //$google_slider         = '<div id="google_slider" class="mainPage" style="display:none;"><\/div>';
            $google_anzeigen     = '<h1 class="headWithBorder" style="font-weight:normal;">Google-Anzeigen<\/h1>';
            break;
        case 2:
            $google_style     = 'googleCnt';
            $google_max_num_ads = '3';
            $start     = '0';
            $end    = '2';
            #$google_max_num_ads = '5';
            #$start     = '0';
            #$end    = '4';
            //$google_slider         = '<div id="google_slider" class="cntPage" style="display:none;"><\/div>';
            $google_anzeigen     = '<div class="ghead">Google-Anzeigen<\/div>';
            break;
        case 3:
            $google_style     = 'googleCnt';
            $google_max_num_ads = '3';
            $start     = '8';
            $end    = '10';
            #$google_max_num_ads = '5'";
            #$start     = '10';
            #$end    = '"12';
            $google_anzeigen     = '<h1 class="headWithBorder">Google-Anzeigen<\/h1>';
            break;
        case 4: //pages only with bottom google_ads
            $google_style     = 'googleDefault';
            $google_max_num_ads = '5';
            $start     = '0';
            $end    = '4';
            #$google_max_num_ads = '7';
            #$start     = '0';
            #$end    = '6';
            break;
        case 5: //display full 10 google ads, especially for 'kreditkarten'
            $google_style     = 'googleCnt';
            $google_max_num_ads = '5';
            $start     = '0';
            $end    = '4';
            #$google_max_num_ads = '7';
            #$start     = '0';
            #$end    = '6';
            //$google_slider         = '<div id="google_slider" class="cntPage" style="display:none;"><\/div>';
            $google_anzeigen     = '<div class="ghead">Google-Anzeigen<\/div>';
            break;
        case 6: //for bottom page 'kreditkarten'
            $google_style     = 'googleDefault';
            $google_max_num_ads = '5';
            $start     = '5';
            $end    = '9';
            #$google_max_num_ads = '7';
            #$start     = '7';
            #$end    = '13';
            $google_slider = '';
            break;
        case 7:
            $google_style     = 'googleCnt';
            $google_max_num_ads = '7';
            $start     = '0';
            $end    = '6';
            $google_anzeigen     = '<div class="ghead">Google-Anzeigen<\/div>';
            break;
        case 8: //display full 10 google ads, especially for 'kfz-vergleich'
            $google_style     = 'googleCnt';
            $google_max_num_ads = '5';
            $start     = '0';
            $end    = '4';
            #$google_max_num_ads = '7';
            #$start     = '0';
            #$end    = '6';
            //$google_slider         = '<div id="google_slider" class="cntPage" style="display:none;"><\/div>';
            $google_anzeigen     = '<div class="ghead">Google-Anzeigen<\/div>';
            break;
        case 9: //kfz top
            $google_style     = 'gAdsC';
            $google_max_num_ads = '3';
            $start     = '0';
            $end    = '2';
            $google_anzeigen     = '<div class="ghead">Sponsoren-Links<\/div>';
            break;
        case 10: //for bottom page 'kfz-vergleich'
            $google_style     = 'gAdsC gAdsCBottom';
            $google_max_num_ads = '5';
            $start     = '5';
            $end    = '9';
            $google_slider = '';
            $google_anzeigen     = '<div class="ghead">Sponsoren-Links<\/div>';
            break;
        case 11: //pages only with bottom google_ads
            $google_style     = 'gAdsCBottom2';
            $google_max_num_ads = '5';
            $start     = '0';
            $end    = '4';
            break;
        case 12: //pages only with bottom google_ads
            $google_style     = 'gAdsCSky';
            $google_max_num_ads = '5';
            $start     = '5';
            $end    = '9';
            break;
        case 13: //pages only with bottom google_ads
            $google_style     = 'gAdsCBottom2';
            $google_max_num_ads = '3';
            $start     = '0';
            $end    = '2';
            break;
        case 14: //pages only with bottom google_ads
            $google_style     = 'gAdsCBottom2';
            $google_max_num_ads = '5';
            $start     = '3';
            $end    = '7';
            break;
        default:
            $google_style     = 'googleDefault';
            $google_max_num_ads = '5';
            $start     = '3';
            $end    = '7';
            break;
        }

        $google_ad['google_max_num_ads'] = $google_max_num_ads;

        $cat = (isset($data['maincategory']['datei_name']) ? '_' . $data['maincategory']['datei_name'] : '_' . $data['datei_name']);

        $google_tracking    = (isset($data['google_tracking']) ? $data['google_tracking'] : 'googleAFC' . $cat);
        $google_ad['text']     = $google_slider
                            . "\n<script type=\"text/javascript\">"
                            . "\n/* <![CDATA[ */\n"
                            . "displayGoogleBlock(" . $start . ", " . $end . ", '" . $google_anzeigen . "', '" . $google_style . "', '" . $google_tracking . "');"
                            . "\n/* ]]> */\n"
                            . "</script>\n";
        return $google_ad;
    }

    #enough for google
    /**
     * @access protected
     */
    protected function isEnoughForGoogle(array $data, $google_ad)
    {
        //get the google code
        preg_match_all("/<p>(.*?)<\/p>/sm", $data['content'], $html_array);

        //this save the original data array
        $prevent_array = $html_array;
        $array_length  = count($html_array[0]);

        if ($array_length > 6) {
            $position  = round($array_length/2);
            $paragraph = $html_array[0][$position];

            if (strpos("<table", $paragraph) != false) {
                $paragraph       = preg_replace("/<p>/", $google_ad . "<p>", $paragraph, 1);
                $data['content'] = preg_replace("#" . preg_quote($prevent_array[0][$position]) . "#",$paragraph, $data['content'], 1);
            }
        }
        
        return $data['content'];
    }

    /**
     * @access protected
     */
    protected function getGoogleAds(array $data)
    {
        if(empty($data['nav_id'])){
            $defaultData = $this->getGoogleData($data);
            $data        = array_merge($data, $defaultData);
        }

        $google_kw_type  = $data['google_key_type'];
        $keyword_number  = rand(1,3);
        $google_keywords = (empty($data['google_key_' . $keyword_number]) ? ((isset($data['keyword'])) ? $data['keyword'] : null) : $data['google_key_' . $keyword_number]);

        $keyword_array = explode(',',$google_keywords);
        if(is_array($keyword_array) && count($keyword_array) > 2){
            //we mix the order of the keywords
            $array_keys = array_rand($keyword_array,3);
            foreach ($array_keys as $key=>$value) {
                    $mixed_array[$key] = trim($keyword_array[$value]);
            }
            $google_keywords = implode(",",$mixed_array);
        }

        $google_page_url = (isset($_SERVER['REDIRECT_URL']) ? _URL . $_SERVER['REDIRECT_URL'] : _URL);
        $google_hints      = $google_keywords;
        $google_keywords   = '';
        $google_kw_type    = '';
        $google_ad_channel    = 'geld';

        $geldanlagen  = array(648/*Geldanlagen*/,2807/*Konten-und-Karten*/);
        $finanzierung = array(239/*Baufinanzierung*/,647/*Kredite*/);
        $versicherung = array(2,3,93,131,746);
        $steuern      = array(241);

        if (in_array($data['nav_id'], $geldanlagen) || (isset($data['cat_id']) && in_array($data['cat_id'],$geldanlagen))) {
           $google_ad_channel = 'geld_geldanlagen';
        } elseif(in_array($data['nav_id'], $finanzierung) || in_array($data['cat_id'], $finanzierung)) {
           $google_ad_channel = 'geld_finanzierung';
        } elseif (in_array($data['nav_id'], $versicherung) || in_array($data['cat_id'], $versicherung) || in_array($data['bezug'], $versicherung)) {
           $google_ad_channel = 'geld_versicherung';
        } elseif (in_array($data['nav_id'], $steuern) || in_array($data['cat_id'], $steuern) || in_array($data['bezug'], $steuern)) {
           $google_ad_channel = 'geld_steuern';
        }

        $this->_view->assign("google_page_url", $google_page_url);
        $this->_view->assign("google_ad_channel", $google_ad_channel);
        $this->_view->assign("google_max_num_ads", $data['google_max_num_ads']);
        $this->_view->assign("google_kw_type", $google_kw_type);
        $this->_view->assign("google_keywords", $google_keywords);
        $this->_view->assign("google_hints", $google_hints);

        return $this->_view->render("admedia/admedia_get_google.phtml");
    }

    /**
     * @access protected
     */
    protected function getGoogleData(array $data)
    {
        $result = $this->_db->query("SELECT * FROM vers WHERE nav_id=1");
        $data   = (($result && $row = $result->fetch(PDO::FETCH_ASSOC)) ? $row : $data['maincategory']);

        return $data;
    }

    /**
     * @access protected
     */
    protected function getGoogleXml(array $inParam)
    {
        require_once 'XML/Serializer.php';
        //require_once 'XML/Unserializer.php';
        require_once 'HTTP/Client.php';
        #require_once 'google_interface.inc.php';

        $params = array();

        //Minimum
        //Request über externen Server (bei internen Tests notwendig)
        #$params['_fingerprint'] = md5($params['Search'].'unAd25');
        #$params['Server'] = 'ads.unister-gmbh.de/unister-gmbh.de/developers/google_interface/googleInterface.php';

        if (isset($inParam['searchstr']) && $inParam['searchstr'] != "") {
            $params['Search'] = html_entity_decode($inParam['searchstr']);
        }

        if (isset($inParam['Search'])) {
            $params['Search'] = $inParam['Search'];
        }

        if (isset($_REQUEST['page'])) {
            $params['Pages'] = $_REQUEST['page'];
        }

        if (isset($inParam['OutputFormat'])) {
            $params['OutputFormat'] = $inParam['OutputFormat'];
        }

        if (isset($inParam['Client'])) {
            $params['Client'] = $inParam['Client'];
        }

        if (isset($inParam['Channel'])) {
            $params['Channel'] = $inParam['Channel'];
        }

        if (isset($inParam['Test'])) {
            $params['Test'] = $inParam['Test'];
        }

        $objGoogle = new Unister_Finance_Core_Google($params);
        $result    = $objGoogle->getData();
        unset($objGoogle);

        //just one?
        if (isset($result['ADS']['AD']['n'])) {
            return $result['ADS'];
        } elseif (isset($result['ADS']['AD'])) {
            return $result['ADS']['AD'];
        } else {
            return;
        }
    }

    /**
     * @access public
     */
    public function showAdmedia($adName, array $data, array $requestData, $tippSky=null)
    {
        //adition nuggad keyword
        if (isset($requestData['aditiontest'])) {
            $keyword = 'showroom';
        } elseif (isset($data['maincategory']['keyword'])) {
            $keyword    = html_entity_decode(strtolower(trim($data['maincategory']['keyword'])));
        } elseif (isset($data['keyword']) && $data['cat_id'] == 0) {
            $keyword    = html_entity_decode(strtolower(trim($data['keyword'])));
        } else {
            $keyword     = 'sonstiges';
        }

        if (!array_key_exists($keyword, $GLOBALS['_GLOBAL_ADSERVER_HOST_SITES'])) {
            $keyword = 'sonstiges';
        }

        if (isset($GLOBALS['_GLOBAL_ADSERVER_HOST_SITES'][$keyword]['addition'][$adName])) {
            $additionID = $GLOBALS['_GLOBAL_ADSERVER_HOST_SITES'][$keyword]['addition'][$adName];
        } else {
            $additionID = '';
        }

        //agof | ivw keyword
        $ivw_keyword = $this->ivwKey($data);

        $this->_view->assign("ivw_keyword", $ivw_keyword);
        $this->_view->assign("additionID", $additionID);

        return $this->_view->render("Index/admedia/admedia_" . $adName . ".phtml");
    }

    /**
     * @access public
     */
    public function nuggadKey(array $data)
    {
        if (isset($data['maincategory']['keyword'])) {
            $nuggadkey    = html_entity_decode(strtolower(trim($data['maincategory']['keyword'])));
        } elseif (isset($data['keyword']) && $data['cat_id'] == 0) {
            $nuggadkey    = html_entity_decode(strtolower(trim($data['keyword'])));
        } else {
            $nuggadkey = 'sonstiges';
        }
        $nuggadkey == 'versicherungsvergleich' ? $nuggadkey = 'startseite' : 0;
        $nuggadkey = $this->rightName($nuggadkey);

        return rawurlencode($nuggadkey);
    }

    /**
     * @access protected
     */
    protected function ivwKey(array $data)
    {
        $ivw = $GLOBALS['_GLOBAL_AGOF_IVW_TAGS'];

        if (isset($ivw[$data['nav_id']]) && $ivw[$data['nav_id']]) {
            $ivwkey = $ivw[$data['nav_id']];
        } elseif (isset($data['bezug']) && isset($ivw[$data['bezug']]) && $ivw[$data['bezug']]) {
            $ivwkey = $ivw[$data['bezug']];
        } elseif (isset($data['maincategory']['bezug']) && isset($ivw[$data['maincategory']['bezug']]) && $ivw[$data['maincategory']['bezug']]) {
            $ivwkey = $ivw[$data['maincategory']['bezug']];
        } elseif (isset($data['maincategory']['nav_id']) && isset($ivw[$data['maincategory']['nav_id']]) && $ivw[$data['maincategory']['nav_id']]) {
            $ivwkey = $ivw[$data['maincategory']['nav_id']];
        } elseif ($data['nav_id'] == 1) {
            $ivwkey = $ivw['versicherungsvergleich'];
        } elseif ($data['datei_name'] == 'suchen') {
            $ivwkey = $ivw['suchen'];
        } else {
            $ivwkey = $ivw['default'];
        }

        return $ivwkey;
    }

    /**
     * @access protected
     */
    protected function rightName($string)
    {
        $sz = array(
            "ä"            =>"ae",
            "Ä"            =>"ae",
            "ö"            =>"oe",
            "Ö"            =>"oe",
            "ü"            =>"ue",
            "Ü"            =>"ue",
            "ß"            =>"ss",
            "&auml;"    =>"ae",
            "&Auml;"    =>"ae",
            "&ouml;"    =>"oe",
            "&Ouml;"    =>"oe",
            "&uuml;"    =>"ue",
            "&Uuml;"    =>"ue",
            "&szlig;"    =>"ss",
#            " "            => "+",
            "|"            => "",
        );
        while(list($key, $value) = each($sz)){
            $string = str_replace($key, $value, trim($string));
        }

        return strtolower($string);
    }//end function
} //end class