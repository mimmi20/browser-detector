<?php


namespace BrowserDetector\Factory\Device\Mobile;

use BrowserDetector\Factory;
use BrowserDetector\Loader\LoaderInterface;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class NokiaFactory implements Factory\FactoryInterface
{
    /**
     * @var \Psr\Cache\CacheItemPoolInterface|null
     */
    private $cache = null;

    /**
     * @var \BrowserDetector\Loader\LoaderInterface|null
     */
    private $loader = null;

    /**
     * @param \Psr\Cache\CacheItemPoolInterface       $cache
     * @param \BrowserDetector\Loader\LoaderInterface $loader
     */
    public function __construct(CacheItemPoolInterface $cache, LoaderInterface $loader)
    {
        $this->cache  = $cache;
        $this->loader = $loader;
    }

    /**
     * detects the device name from the given user agent
     *
     * @param string $useragent
     *
     * @return array
     */
    public function detect($useragent)
    {
        $deviceCode = 'general nokia device';

        if (preg_match('/genm14/i', $useragent)) {
            $deviceCode = 'xl2';
        } elseif (preg_match('/nokia_xl/i', $useragent)) {
            $deviceCode = 'xl';
        } elseif (preg_match('/(lumia 650|id336)/i', $useragent)) {
            $deviceCode = 'lumia 650';
        } elseif (preg_match('/lumia 510/i', $useragent)) {
            $deviceCode = 'lumia 510';
        } elseif (preg_match('/(rm\-1113|lumia 640 lte)/i', $useragent)) {
            $deviceCode = 'rm-1113';
        } elseif (preg_match('/rm\-1090/i', $useragent)) {
            $deviceCode = 'rm-1090';
        } elseif (preg_match('/rm\-1089/i', $useragent)) {
            $deviceCode = 'rm-1089';
        } elseif (preg_match('/rm\-1072/i', $useragent)) {
            $deviceCode = 'rm-1072';
        } elseif (preg_match('/rm\-1073/i', $useragent)) {
            $deviceCode = 'rm-1073';
        } elseif (preg_match('/rm\-1074/i', $useragent)) {
            $deviceCode = 'rm-1074';
        } elseif (preg_match('/rm\-1076/i', $useragent)) {
            $deviceCode = 'rm-1076';
        } elseif (preg_match('/rm\-1077/i', $useragent)) {
            $deviceCode = 'rm-1077';
        } elseif (preg_match('/(rm\-1075|lumia 640 dual sim)/i', $useragent)) {
            $deviceCode = 'rm-1075';
        } elseif (preg_match('/rm\-1062/i', $useragent)) {
            $deviceCode = 'rm-1062';
        } elseif (preg_match('/rm\-1063/i', $useragent)) {
            $deviceCode = 'rm-1063';
        } elseif (preg_match('/rm\-1064/i', $useragent)) {
            $deviceCode = 'rm-1064';
        } elseif (preg_match('/rm\-1065/i', $useragent)) {
            $deviceCode = 'rm-1065';
        } elseif (preg_match('/rm\-1066/i', $useragent)) {
            $deviceCode = 'rm-1066';
        } elseif (preg_match('/rm\-1067/i', $useragent)) {
            $deviceCode = 'rm-1067';
        } elseif (preg_match('/rm\-1045/i', $useragent)) {
            $deviceCode = 'rm-1045';
        } elseif (preg_match('/rm\-1038/i', $useragent)) {
            $deviceCode = 'rm-1038';
        } elseif (preg_match('/(rm\-1031|lumia 532)/i', $useragent)) {
            $deviceCode = 'rm-1031';
        } elseif (preg_match('/rm\-1010/i', $useragent)) {
            $deviceCode = 'rm-1010';
        } elseif (preg_match('/rm\-994/i', $useragent)) {
            $deviceCode = 'rm-994';
        } elseif (preg_match('/rm\-978/i', $useragent)) {
            $deviceCode = 'rm-978';
        } elseif (preg_match('/rm\-976/i', $useragent)) {
            $deviceCode = 'rm-976';
        } elseif (preg_match('/rm\-974/i', $useragent)) {
            $deviceCode = 'rm-974';
        } elseif (preg_match('/rm\-914/i', $useragent)) {
            $deviceCode = 'lumia 520 rm-914';
        } elseif (preg_match('/rm\-846/i', $useragent)) {
            $deviceCode = 'rm-846';
        } elseif (preg_match('/rm\-997/i', $useragent)) {
            $deviceCode = 'rm-997';
        } elseif (preg_match('/lumia 521/i', $useragent)) {
            $deviceCode = 'lumia 521';
        } elseif (preg_match('/lumia 520/i', $useragent)) {
            $deviceCode = 'lumia 520';
        } elseif (preg_match('/lumia 530/i', $useragent)) {
            $deviceCode = 'lumia 530';
        } elseif (preg_match('/lumia 535/i', $useragent)) {
            $deviceCode = 'lumia 535';
        } elseif (preg_match('/lumia 540/i', $useragent)) {
            $deviceCode = 'lumia 540';
        } elseif (preg_match('/lumia 550/i', $useragent)) {
            $deviceCode = 'lumia 550';
        } elseif (preg_match('/lumia 610/i', $useragent)) {
            $deviceCode = 'lumia 610';
        } elseif (preg_match('/lumia 620/i', $useragent)) {
            $deviceCode = 'lumia 620';
        } elseif (preg_match('/lumia 625/i', $useragent)) {
            $deviceCode = 'lumia 625';
        } elseif (preg_match('/lumia 630/i', $useragent)) {
            $deviceCode = 'lumia 630';
        } elseif (preg_match('/lumia 635/i', $useragent)) {
            $deviceCode = 'lumia 635';
        } elseif (preg_match('/lumia 640 xl/i', $useragent)) {
            $deviceCode = 'lumia 640 xl';
        } elseif (preg_match('/lumia 640/i', $useragent)) {
            $deviceCode = 'lumia 640';
        } elseif (preg_match('/lumia 710/i', $useragent)) {
            $deviceCode = 'lumia 710';
        } elseif (preg_match('/lumia 720/i', $useragent)) {
            $deviceCode = 'lumia 720';
        } elseif (preg_match('/lumia 730/i', $useragent)) {
            $deviceCode = 'lumia 730';
        } elseif (preg_match('/lumia 735/i', $useragent)) {
            $deviceCode = 'lumia 735';
        } elseif (preg_match('/lumia 800/i', $useragent)) {
            $deviceCode = 'lumia 800';
        } elseif (preg_match('/lumia 820/i', $useragent)) {
            $deviceCode = 'lumia 820';
        } elseif (preg_match('/lumia 830/i', $useragent)) {
            $deviceCode = 'lumia 830';
        } elseif (preg_match('/lumia 900/i', $useragent)) {
            $deviceCode = 'lumia 900';
        } elseif (preg_match('/lumia 920/i', $useragent)) {
            $deviceCode = 'lumia 920';
        } elseif (preg_match('/(lumia|nokia) 925/i', $useragent)) {
            $deviceCode = 'lumia 925';
        } elseif (preg_match('/lumia 928/i', $useragent)) {
            $deviceCode = 'lumia 928';
        } elseif (preg_match('/lumia 930/i', $useragent)) {
            $deviceCode = 'lumia 930';
        } elseif (preg_match('/lumia 950 xl/i', $useragent)) {
            $deviceCode = 'lumia 950 xl';
        } elseif (preg_match('/lumia 950/i', $useragent)) {
            $deviceCode = 'lumia 950';
        } elseif (preg_match('/(lumia 1020|nokia; 909|arm; 909)/i', $useragent)) {
            $deviceCode = 'lumia 1020';
        } elseif (preg_match('/lumia 1320/i', $useragent)) {
            $deviceCode = 'lumia 1320';
        } elseif (preg_match('/lumia 1520/i', $useragent)) {
            $deviceCode = 'lumia 1520';
        } elseif (preg_match('/lumia 435/i', $useragent)) {
            $deviceCode = 'lumia 435';
        } elseif (preg_match('/lumia/i', $useragent)) {
            $deviceCode = 'lumia';
        } elseif (preg_match('/ N1 /', $useragent)) {
            $deviceCode = 'n1';
        } elseif (preg_match('/nokian81/i', $useragent)) {
            $deviceCode = 'n81';
        } elseif (preg_match('/nokian82/i', $useragent)) {
            $deviceCode = 'n82';
        } elseif (preg_match('/nokian85/i', $useragent)) {
            $deviceCode = 'n85';
        } elseif (preg_match('/nokian86/i', $useragent)) {
            $deviceCode = 'n86';
        } elseif (preg_match('/nokian8\-00/i', $useragent)) {
            $deviceCode = 'n8-00';
        } elseif (preg_match('/nokian8/i', $useragent)) {
            $deviceCode = 'n8';
        } elseif (preg_match('/nokian90/i', $useragent)) {
            $deviceCode = 'n90';
        } elseif (preg_match('/nokian91/i', $useragent)) {
            $deviceCode = 'n91';
        } elseif (preg_match('/nokian95/i', $useragent)) {
            $deviceCode = 'n95';
        } elseif (preg_match('/nokian96/i', $useragent)) {
            $deviceCode = 'n96';
        } elseif (preg_match('/nokian97/i', $useragent)) {
            $deviceCode = 'n97';
        } elseif (preg_match('/nokian900/i', $useragent)) {
            $deviceCode = 'n900';
        } elseif (preg_match('/nokian9/i', $useragent)) {
            $deviceCode = 'n9';
        } elseif (preg_match('/nokia ?n70/i', $useragent)) {
            $deviceCode = 'n70';
        } elseif (preg_match('/nokia n78/i', $useragent)) {
            $deviceCode = 'n78';
        } elseif (preg_match('/nokia ?n79/i', $useragent)) {
            $deviceCode = 'n79';
        } elseif (preg_match('/NokiaX2DS/i', $useragent)) {
            $deviceCode = 'x2ds';
        } elseif (preg_match('/NokiaX2\-00/i', $useragent)) {
            $deviceCode = 'x2-00';
        } elseif (preg_match('/NokiaX2\-01/i', $useragent)) {
            $deviceCode = 'x2-01';
        } elseif (preg_match('/NokiaX2\-02/i', $useragent)) {
            $deviceCode = 'x2-02';
        } elseif (preg_match('/NokiaX2\-05/i', $useragent)) {
            $deviceCode = 'x2-05';
        } elseif (preg_match('/NokiaX2/i', $useragent)) {
            $deviceCode = 'x2';
        } elseif (preg_match('/NokiaX3\-02/i', $useragent)) {
            $deviceCode = 'x3-02';
        } elseif (preg_match('/NokiaX3\-00/i', $useragent)) {
            $deviceCode = 'x3-00';
        } elseif (preg_match('/NokiaX3/i', $useragent)) {
            $deviceCode = 'x3';
        } elseif (preg_match('/NokiaX6\-00/i', $useragent)) {
            $deviceCode = 'x6-00';
        } elseif (preg_match('/NokiaX6/i', $useragent)) {
            $deviceCode = 'x6';
        } elseif (preg_match('/NokiaX7\-00/i', $useragent)) {
            $deviceCode = 'x7-00';
        } elseif (preg_match('/NokiaX7/i', $useragent)) {
            $deviceCode = 'x7';
        } elseif (preg_match('/NokiaE7\-00/i', $useragent)) {
            $deviceCode = 'e7-00';
        } elseif (preg_match('/NokiaE71\-1/i', $useragent)) {
            $deviceCode = 'e71-1';
        } elseif (preg_match('/NokiaE71/i', $useragent)) {
            $deviceCode = 'e71';
        } elseif (preg_match('/NokiaE72/i', $useragent)) {
            $deviceCode = 'e72';
        } elseif (preg_match('/NokiaE75/i', $useragent)) {
            $deviceCode = 'e75';
        } elseif (preg_match('/NokiaE7/i', $useragent)) {
            $deviceCode = 'e7';
        } elseif (preg_match('/NokiaE6\-00/i', $useragent)) {
            $deviceCode = 'e6-00';
        } elseif (preg_match('/NokiaE62/i', $useragent)) {
            $deviceCode = 'e62';
        } elseif (preg_match('/NokiaE63/i', $useragent)) {
            $deviceCode = 'e63';
        } elseif (preg_match('/NokiaE66/i', $useragent)) {
            $deviceCode = 'e66';
        } elseif (preg_match('/NokiaE6/i', $useragent)) {
            $deviceCode = 'e6';
        } elseif (preg_match('/NokiaE5\-00/i', $useragent)) {
            $deviceCode = 'e5-00';
        } elseif (preg_match('/NokiaE50/i', $useragent)) {
            $deviceCode = 'e50';
        } elseif (preg_match('/NokiaE51/i', $useragent)) {
            $deviceCode = 'e51';
        } elseif (preg_match('/NokiaE52/i', $useragent)) {
            $deviceCode = 'e52';
        } elseif (preg_match('/NokiaE55/i', $useragent)) {
            $deviceCode = 'e55';
        } elseif (preg_match('/NokiaE56/i', $useragent)) {
            $deviceCode = 'e56';
        } elseif (preg_match('/NokiaE5/i', $useragent)) {
            $deviceCode = 'e5';
        } elseif (preg_match('/NokiaE90/i', $useragent)) {
            $deviceCode = 'e90';
        } elseif (preg_match('/NokiaC7\-00/i', $useragent)) {
            $deviceCode = 'c7-00';
        } elseif (preg_match('/NokiaC7/i', $useragent)) {
            $deviceCode = 'nokia c7';
        } elseif (preg_match('/NokiaC6\-00/i', $useragent)) {
            $deviceCode = 'c6-00';
        } elseif (preg_match('/NokiaC6\-01/i', $useragent)) {
            $deviceCode = 'c6-01';
        } elseif (preg_match('/NokiaC6/i', $useragent)) {
            $deviceCode = 'c6';
        } elseif (preg_match('/NokiaC5\-00/i', $useragent)) {
            $deviceCode = 'c5-00';
        } elseif (preg_match('/NokiaC5\-03/i', $useragent)) {
            $deviceCode = 'c5-03';
        } elseif (preg_match('/NokiaC5\-05/i', $useragent)) {
            $deviceCode = 'c5-05';
        } elseif (preg_match('/NokiaC5/i', $useragent)) {
            $deviceCode = 'c5';
        } elseif (preg_match('/NokiaC3\-00/i', $useragent)) {
            $deviceCode = 'c3-00';
        } elseif (preg_match('/NokiaC3\-01/i', $useragent)) {
            $deviceCode = 'c3-01';
        } elseif (preg_match('/NokiaC3/i', $useragent)) {
            $deviceCode = 'c3';
        } elseif (preg_match('/NokiaC2\-01/i', $useragent)) {
            $deviceCode = 'c2-01';
        } elseif (preg_match('/NokiaC2\-02/i', $useragent)) {
            $deviceCode = 'c2-02';
        } elseif (preg_match('/NokiaC2\-03/i', $useragent)) {
            $deviceCode = 'c2-03';
        } elseif (preg_match('/NokiaC2\-05/i', $useragent)) {
            $deviceCode = 'c2-05';
        } elseif (preg_match('/NokiaC2\-06/i', $useragent)) {
            $deviceCode = 'c2-06';
        } elseif (preg_match('/NokiaC2/i', $useragent)) {
            $deviceCode = 'nokia c2';
        } elseif (preg_match('/NokiaC1\-01/i', $useragent)) {
            $deviceCode = 'c1-01';
        } elseif (preg_match('/NokiaC1/i', $useragent)) {
            $deviceCode = 'c1';
        } elseif (preg_match('/Nokia9500/i', $useragent)) {
            $deviceCode = '9500';
        } elseif (preg_match('/Nokia7510/i', $useragent)) {
            $deviceCode = '7510';
        } elseif (preg_match('/Nokia7230/i', $useragent)) {
            $deviceCode = '7230';
        } elseif (preg_match('/Nokia6730c/i', $useragent)) {
            $deviceCode = '6730 classic';
        } elseif (preg_match('/Nokia6720c/i', $useragent)) {
            $deviceCode = '6720 classic';
        } elseif (preg_match('/Nokia6710s/i', $useragent)) {
            $deviceCode = '6710 slide';
        } elseif (preg_match('/Nokia6700s/i', $useragent)) {
            $deviceCode = '6700s';
        } elseif (preg_match('/Nokia6700c/i', $useragent)) {
            $deviceCode = '6700 classic';
        } elseif (preg_match('/Nokia6630/i', $useragent)) {
            $deviceCode = '6630';
        } elseif (preg_match('/Nokia6610I/i', $useragent)) {
            $deviceCode = '6610i';
        } elseif (preg_match('/Nokia6555/i', $useragent)) {
            $deviceCode = '6555';
        } elseif (preg_match('/Nokia6500s/i', $useragent)) {
            $deviceCode = '6500 slide';
        } elseif (preg_match('/Nokia6500c/i', $useragent)) {
            $deviceCode = '6500 classic';
        } elseif (preg_match('/Nokia6303iclassic/i', $useragent)) {
            $deviceCode = '6303i classic';
        } elseif (preg_match('/Nokia6303classic/i', $useragent)) {
            $deviceCode = '6303 classic';
        } elseif (preg_match('/Nokia6300/i', $useragent)) {
            $deviceCode = '6300';
        } elseif (preg_match('/Nokia6220c/i', $useragent)) {
            $deviceCode = '6220 classic';
        } elseif (preg_match('/Nokia6210/i', $useragent)) {
            $deviceCode = '6210';
        } elseif (preg_match('/Nokia6131/i', $useragent)) {
            $deviceCode = '6131';
        } elseif (preg_match('/Nokia6120c/i', $useragent)) {
            $deviceCode = '6120c';
        } elseif (preg_match('/Nokia5800d/i', $useragent)) {
            $deviceCode = '5800 xpressmusic';
        } elseif (preg_match('/Nokia5800/i', $useragent)) {
            $deviceCode = '5800';
        } elseif (preg_match('/Nokia5530c/i', $useragent)) {
            $deviceCode = 'nokia 5530 classic';
        } elseif (preg_match('/Nokia5530/i', $useragent)) {
            $deviceCode = 'nokia 5530 classic';
        } elseif (preg_match('/Nokia5330c/i', $useragent)) {
            $deviceCode = '5330 classic';
        } elseif (preg_match('/Nokia5310/i', $useragent)) {
            $deviceCode = '5310 xpressmusic';
        } elseif (preg_match('/Nokia5250/i', $useragent)) {
            $deviceCode = '5250';
        } elseif (preg_match('/Nokia5233/i', $useragent)) {
            $deviceCode = '5233';
        } elseif (preg_match('/Nokia5230/i', $useragent)) {
            $deviceCode = '5230';
        } elseif (preg_match('/Nokia5228/i', $useragent)) {
            $deviceCode = '5228';
        } elseif (preg_match('/Nokia5220XpressMusic/i', $useragent)) {
            $deviceCode = '5220 xpressmusic';
        } elseif (preg_match('/5130c\-2/i', $useragent)) {
            $deviceCode = '5130c-2';
        } elseif (preg_match('/Nokia5130c/i', $useragent)) {
            $deviceCode = '5130 classic';
        } elseif (preg_match('/Nokia3710/i', $useragent)) {
            $deviceCode = '3710';
        } elseif (preg_match('/Nokia301\.1/i', $useragent)) {
            $deviceCode = '301.1';
        } elseif (preg_match('/Nokia301/i', $useragent)) {
            $deviceCode = '301';
        } elseif (preg_match('/Nokia2760/i', $useragent)) {
            $deviceCode = '2760';
        } elseif (preg_match('/Nokia2730c/i', $useragent)) {
            $deviceCode = '2730 classic';
        } elseif (preg_match('/Nokia2720a/i', $useragent)) {
            $deviceCode = '2720a';
        } elseif (preg_match('/Nokia2700c/i', $useragent)) {
            $deviceCode = '2700 classic';
        } elseif (preg_match('/nokia2630/i', $useragent)) {
            $deviceCode = '2630';
        } elseif (preg_match('/nokia2330c/i', $useragent)) {
            $deviceCode = '2330 classic';
        } elseif (preg_match('/nokia2323c/i', $useragent)) {
            $deviceCode = '2323c';
        } elseif (preg_match('/nokia2320c/i', $useragent)) {
            $deviceCode = '2320c';
        } elseif (preg_match('/nokia808pureview/i', $useragent)) {
            $deviceCode = '808 pureview';
        } elseif (preg_match('/nokia701/i', $useragent)) {
            $deviceCode = '701';
        } elseif (preg_match('/nokia700/i', $useragent)) {
            $deviceCode = '700';
        } elseif (preg_match('/nokia603/i', $useragent)) {
            $deviceCode = '603';
        } elseif (preg_match('/nokia515/i', $useragent)) {
            $deviceCode = '515';
        } elseif (preg_match('/nokia501/i', $useragent)) {
            $deviceCode = '501';
        } elseif (preg_match('/(nokia500|nokiaasha500)/i', $useragent)) {
            $deviceCode = '500';
        } elseif (preg_match('/nokia311/i', $useragent)) {
            $deviceCode = '311';
        } elseif (preg_match('/nokia309/i', $useragent)) {
            $deviceCode = '309';
        } elseif (preg_match('/nokia308/i', $useragent)) {
            $deviceCode = '308';
        } elseif (preg_match('/nokia306/i', $useragent)) {
            $deviceCode = '306';
        } elseif (preg_match('/nokia305/i', $useragent)) {
            $deviceCode = '305';
        } elseif (preg_match('/nokia303/i', $useragent)) {
            $deviceCode = '303';
        } elseif (preg_match('/nokia302/i', $useragent)) {
            $deviceCode = '302';
        } elseif (preg_match('/nokia300/i', $useragent)) {
            $deviceCode = '300';
        } elseif (preg_match('/nokia220/i', $useragent)) {
            $deviceCode = '220';
        } elseif (preg_match('/nokia210/i', $useragent)) {
            $deviceCode = '210';
        } elseif (preg_match('/nokia206/i', $useragent)) {
            $deviceCode = '206';
        } elseif (preg_match('/nokia205/i', $useragent)) {
            $deviceCode = '205';
        } elseif (preg_match('/nokia203/i', $useragent)) {
            $deviceCode = '203';
        } elseif (preg_match('/nokia201/i', $useragent)) {
            $deviceCode = '201';
        } elseif (preg_match('/nokia200/i', $useragent)) {
            $deviceCode = '200';
        } elseif (preg_match('/nokia113/i', $useragent)) {
            $deviceCode = '113';
        } elseif (preg_match('/nokia112/i', $useragent)) {
            $deviceCode = '112';
        } elseif (preg_match('/nokia110/i', $useragent)) {
            $deviceCode = '110';
        } elseif (preg_match('/nokia109/i', $useragent)) {
            $deviceCode = '109';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
