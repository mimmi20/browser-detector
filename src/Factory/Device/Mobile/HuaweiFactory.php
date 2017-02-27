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
class HuaweiFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general huawei device';

        if (preg_match('/nexus 6p/i', $useragent)) {
            $deviceCode = 'nexus 6p';
        } elseif (preg_match('/tag\-al00/i', $useragent)) {
            $deviceCode = 'tag-al00';
        } elseif (preg_match('/tag\-l21/i', $useragent)) {
            $deviceCode = 'tag-l21';
        } elseif (preg_match('/tag\-l01/i', $useragent)) {
            $deviceCode = 'tag-l01';
        } elseif (preg_match('/ale\-21/i', $useragent)) {
            $deviceCode = 'ale 21';
        } elseif (preg_match('/ale\-l21/i', $useragent)) {
            $deviceCode = 'ale-l21';
        } elseif (preg_match('/ale\-l02/i', $useragent)) {
            $deviceCode = 'ale-l02';
        } elseif (preg_match('/gra\-l09/i', $useragent)) {
            $deviceCode = 'gra-l09';
        } elseif (preg_match('/GRACE/', $useragent)) {
            $deviceCode = 'grace';
        } elseif (preg_match('/p7\-l10/i', $useragent)) {
            $deviceCode = 'p7-l10';
        } elseif (preg_match('/p7\-l09/i', $useragent)) {
            $deviceCode = 'p7-l09';
        } elseif (preg_match('/(p7 mini|p7mini)/i', $useragent)) {
            $deviceCode = 'p7 mini';
        } elseif (preg_match('/p2\-6011/i', $useragent)) {
            $deviceCode = 'p2-6011';
        } elseif (preg_match('/eva\-l19/i', $useragent)) {
            $deviceCode = 'eva-l19';
        } elseif (preg_match('/eva\-l09/i', $useragent)) {
            $deviceCode = 'eva-l09';
        } elseif (preg_match('/scl\-l01/i', $useragent)) {
            $deviceCode = 'scl-l01';
        } elseif (preg_match('/scl\-l21/i', $useragent)) {
            $deviceCode = 'scl-l21';
        } elseif (preg_match('/scl\-u31/i', $useragent)) {
            $deviceCode = 'scl-u31';
        } elseif (preg_match('/nxt\-l29/i', $useragent)) {
            $deviceCode = 'nxt-l29';
        } elseif (preg_match('/nxt\-al10/i', $useragent)) {
            $deviceCode = 'nxt-al10';
        } elseif (preg_match('/gem\-703l/i', $useragent)) {
            $deviceCode = 'gem-703l';
        } elseif (preg_match('/gem\-702l/i', $useragent)) {
            $deviceCode = 'gem-702l';
        } elseif (preg_match('/gem\-701l/i', $useragent)) {
            $deviceCode = 'gem-701l';
        } elseif (preg_match('/g630\-u251/i', $useragent)) {
            $deviceCode = 'g630-u251';
        } elseif (preg_match('/g630\-u20/i', $useragent)) {
            $deviceCode = 'g630-u20';
        } elseif (preg_match('/g620s\-l01/i', $useragent)) {
            $deviceCode = 'g620s-l01';
        } elseif (preg_match('/g610\-u20/i', $useragent)) {
            $deviceCode = 'g610-u20';
        } elseif (preg_match('/g7\-l11/i', $useragent)) {
            $deviceCode = 'g7-l11';
        } elseif (preg_match('/g7\-l01/i', $useragent)) {
            $deviceCode = 'g7-l01';
        } elseif (preg_match('/g6\-l11/i', $useragent)) {
            $deviceCode = 'g6-l11';
        } elseif (preg_match('/g6\-u10/i', $useragent)) {
            $deviceCode = 'g6-u10';
        } elseif (preg_match('/pe\-tl10/i', $useragent)) {
            $deviceCode = 'pe-tl10';
        } elseif (preg_match('/rio\-l01/i', $useragent)) {
            $deviceCode = 'rio-l01';
        } elseif (preg_match('/cun\-l21/i', $useragent)) {
            $deviceCode = 'cun-l21';
        } elseif (preg_match('/cun\-l03/i', $useragent)) {
            $deviceCode = 'cun-l03';
        } elseif (preg_match('/crr\-l09/i', $useragent)) {
            $deviceCode = 'crr-l09';
        } elseif (preg_match('/chc\-u01/i', $useragent)) {
            $deviceCode = 'chc-u01';
        } elseif (preg_match('/g750\-u10/i', $useragent)) {
            $deviceCode = 'g750-u10';
        } elseif (preg_match('/g750\-t00/i', $useragent)) {
            $deviceCode = 'g750-t00';
        } elseif (preg_match('/g740\-l00/i', $useragent)) {
            $deviceCode = 'g740-l00';
        } elseif (preg_match('/g730\-u27/i', $useragent)) {
            $deviceCode = 'g730-u27';
        } elseif (preg_match('/g730\-u10/i', $useragent)) {
            $deviceCode = 'g730-u10';
        } elseif (preg_match('/vns\-l31/i', $useragent)) {
            $deviceCode = 'vns-l31';
        } elseif (preg_match('/vns\-l21/i', $useragent)) {
            $deviceCode = 'vns-l21';
        } elseif (preg_match('/tit\-u02/i', $useragent)) {
            $deviceCode = 'tit-u02';
        } elseif (preg_match('/y635\-l21/i', $useragent)) {
            $deviceCode = 'y635-l21';
        } elseif (preg_match('/y625\-u51/i', $useragent)) {
            $deviceCode = 'y625-u51';
        } elseif (preg_match('/y625\-u21/i', $useragent)) {
            $deviceCode = 'y625-u21';
        } elseif (preg_match('/y600\-u20/i', $useragent)) {
            $deviceCode = 'y600-u20';
        } elseif (preg_match('/y600\-u00/i', $useragent)) {
            $deviceCode = 'y600-u00';
        } elseif (preg_match('/y560\-l01/i', $useragent)) {
            $deviceCode = 'y560-l01';
        } elseif (preg_match('/y550\-l01/i', $useragent)) {
            $deviceCode = 'y550-l01';
        } elseif (preg_match('/y540\-u01/i', $useragent)) {
            $deviceCode = 'y540-u01';
        } elseif (preg_match('/y530\-u00/i', $useragent)) {
            $deviceCode = 'y530-u00';
        } elseif (preg_match('/y511/i', $useragent)) {
            $deviceCode = 'y511';
        } elseif (preg_match('/y635\-l21/i', $useragent)) {
            $deviceCode = 'y635-l21';
        } elseif (preg_match('/y360\-u61/i', $useragent)) {
            $deviceCode = 'y360-u61';
        } elseif (preg_match('/y360\-u31/i', $useragent)) {
            $deviceCode = 'y360-u31';
        } elseif (preg_match('/y340\-u081/i', $useragent)) {
            $deviceCode = 'y340-u081';
        } elseif (preg_match('/y336\-u02/i', $useragent)) {
            $deviceCode = 'y336-u02';
        } elseif (preg_match('/y330\-u11/i', $useragent)) {
            $deviceCode = 'y330-u11';
        } elseif (preg_match('/y330\-u05/i', $useragent)) {
            $deviceCode = 'y330-u05';
        } elseif (preg_match('/y330\-u01/i', $useragent)) {
            $deviceCode = 'y330-u01';
        } elseif (preg_match('/y320\-u30/i', $useragent)) {
            $deviceCode = 'y320-u30';
        } elseif (preg_match('/y320\-u10/i', $useragent)) {
            $deviceCode = 'y320-u10';
        } elseif (preg_match('/y300/i', $useragent)) {
            $deviceCode = 'y300';
        } elseif (preg_match('/y220\-u10/i', $useragent)) {
            $deviceCode = 'y220-u10';
        } elseif (preg_match('/y210\-0100/i', $useragent)) {
            $deviceCode = 'y210-0100';
        } elseif (preg_match('/w2\-u00/i', $useragent)) {
            $deviceCode = 'w2-u00';
        } elseif (preg_match('/w1\-u00/i', $useragent)) {
            $deviceCode = 'w1-u00';
        } elseif (preg_match('/h30\-u10/i', $useragent)) {
            $deviceCode = 'h30-u10';
        } elseif (preg_match('/kiw\-l21/i', $useragent)) {
            $deviceCode = 'kiw-l21';
        } elseif (preg_match('/lyo\-l21/i', $useragent)) {
            $deviceCode = 'lyo-l21';
        } elseif (preg_match('/vodafone 858/i', $useragent)) {
            $deviceCode = 'vodafone 858';
        } elseif (preg_match('/vodafone 845/i', $useragent)) {
            $deviceCode = 'vodafone 845';
        } elseif (preg_match('/u9510/i', $useragent)) {
            $deviceCode = 'u9510';
        } elseif (preg_match('/u9508/i', $useragent)) {
            $deviceCode = 'u9508';
        } elseif (preg_match('/u9200/i', $useragent)) {
            $deviceCode = 'u9200';
        } elseif (preg_match('/u8950n\-1/i', $useragent)) {
            $deviceCode = 'u8950n-1';
        } elseif (preg_match('/u8950n/i', $useragent)) {
            $deviceCode = 'u8950n';
        } elseif (preg_match('/u8950d/i', $useragent)) {
            $deviceCode = 'u8950d';
        } elseif (preg_match('/u8950\-1/i', $useragent)) {
            $deviceCode = 'u8950-1';
        } elseif (preg_match('/u8950/i', $useragent)) {
            $deviceCode = 'u8950';
        } elseif (preg_match('/u8860/i', $useragent)) {
            $deviceCode = 'u8860';
        } elseif (preg_match('/u8850/i', $useragent)) {
            $deviceCode = 'u8850';
        } elseif (preg_match('/u8825/i', $useragent)) {
            $deviceCode = 'u8825';
        } elseif (preg_match('/u8815/i', $useragent)) {
            $deviceCode = 'u8815';
        } elseif (preg_match('/u8800/i', $useragent)) {
            $deviceCode = 'u8800';
        } elseif (preg_match('/HUAWEI U8666 Build\/HuaweiU8666E/i', $useragent)) {
            $deviceCode = 'u8666';
        } elseif (preg_match('/u8666e/i', $useragent)) {
            $deviceCode = 'u8666e';
        } elseif (preg_match('/u8666/i', $useragent)) {
            $deviceCode = 'u8666';
        } elseif (preg_match('/u8655/i', $useragent)) {
            $deviceCode = 'u8655';
        } elseif (preg_match('/huawei\-u8651t/i', $useragent)) {
            $deviceCode = 'u8651t';
        } elseif (preg_match('/huawei\-u8651s/i', $useragent)) {
            $deviceCode = 'u8651s';
        } elseif (preg_match('/huawei\-u8651/i', $useragent)) {
            $deviceCode = 'u8651';
        } elseif (preg_match('/u8650/i', $useragent)) {
            $deviceCode = 'u8650';
        } elseif (preg_match('/u8600/i', $useragent)) {
            $deviceCode = 'u8600';
        } elseif (preg_match('/u8520/i', $useragent)) {
            $deviceCode = 'u8520';
        } elseif (preg_match('/u8510/i', $useragent)) {
            $deviceCode = 's41hw';
        } elseif (preg_match('/u8500/i', $useragent)) {
            $deviceCode = 'u8500';
        } elseif (preg_match('/u8350/i', $useragent)) {
            $deviceCode = 'u8350';
        } elseif (preg_match('/u8185/i', $useragent)) {
            $deviceCode = 'u8185';
        } elseif (preg_match('/u8180/i', $useragent)) {
            $deviceCode = 'u8180';
        } elseif (preg_match('/(u8110|tsp21)/i', $useragent)) {
            $deviceCode = 'u8110';
        } elseif (preg_match('/u8100/i', $useragent)) {
            $deviceCode = 'u8100';
        } elseif (preg_match('/u7510/i', $useragent)) {
            $deviceCode = 'u7510';
        } elseif (preg_match('/s8600/i', $useragent)) {
            $deviceCode = 's8600';
        } elseif (preg_match('/p6\-u06/i', $useragent)) {
            $deviceCode = 'p6-u06';
        } elseif (preg_match('/p6 s\-u06/i', $useragent)) {
            $deviceCode = 'p6 s-u06';
        } elseif (preg_match('/mt7\-tl10/i', $useragent)) {
            $deviceCode = 'mt7-tl10';
        } elseif (preg_match('/(mt7\-l09|jazz)/i', $useragent)) {
            $deviceCode = 'mt7-l09';
        } elseif (preg_match('/mt2\-l01/i', $useragent)) {
            $deviceCode = 'mt2-l01';
        } elseif (preg_match('/mt1\-u06/i', $useragent)) {
            $deviceCode = 'mt1-u06';
        } elseif (preg_match('/s8\-701w/i', $useragent)) {
            $deviceCode = 's8-701w';
        } elseif (preg_match('/(t1\-701u|t1 7\.0)/i', $useragent)) {
            $deviceCode = 't1-701u';
        } elseif (preg_match('/t1\-a21l/i', $useragent)) {
            $deviceCode = 't1-a21l';
        } elseif (preg_match('/t1\-a21w/i', $useragent)) {
            $deviceCode = 't1-a21w';
        } elseif (preg_match('/m2\-a01l/i', $useragent)) {
            $deviceCode = 'm2-a01l';
        } elseif (preg_match('/fdr\-a01l/i', $useragent)) {
            $deviceCode = 'fdr-a01l';
        } elseif (preg_match('/fdr\-a01w/i', $useragent)) {
            $deviceCode = 'fdr-a01w';
        } elseif (preg_match('/m2\-a01w/i', $useragent)) {
            $deviceCode = 'm2-a01w';
        } elseif (preg_match('/m2\-801w/i', $useragent)) {
            $deviceCode = 'm2-801w';
        } elseif (preg_match('/m2\-801l/i', $useragent)) {
            $deviceCode = 'm2-801l';
        } elseif (preg_match('/ath\-ul01/i', $useragent)) {
            $deviceCode = 'ath-ul01';
        } elseif (preg_match('/mediapad x1 7\.0/i', $useragent)) {
            $deviceCode = 'mediapad x1 7.0';
        } elseif (preg_match('/mediapad t1 8\.0/i', $useragent)) {
            $deviceCode = 's8-701u';
        } elseif (preg_match('/mediapad m1 8\.0/i', $useragent)) {
            $deviceCode = 'mediapad m1 8.0';
        } elseif (preg_match('/mediapad 10 link\+/i', $useragent)) {
            $deviceCode = 'mediapad 10+';
        } elseif (preg_match('/mediapad 10 fhd/i', $useragent)) {
            $deviceCode = 'mediapad 10 fhd';
        } elseif (preg_match('/mediapad 10 link/i', $useragent)) {
            $deviceCode = 'huawei s7-301w';
        } elseif (preg_match('/mediapad 7 lite/i', $useragent)) {
            $deviceCode = 'mediapad 7 lite';
        } elseif (preg_match('/mediapad 7 classic/i', $useragent)) {
            $deviceCode = 'mediapad 7 classic';
        } elseif (preg_match('/mediapad 7 youth/i', $useragent)) {
            $deviceCode = 'mediapad 7 youth';
        } elseif (preg_match('/mediapad/i', $useragent)) {
            $deviceCode = 'huawei s7-301w';
        } elseif (preg_match('/m860/i', $useragent)) {
            $deviceCode = 'm860';
        } elseif (preg_match('/m635/i', $useragent)) {
            $deviceCode = 'm635';
        } elseif (preg_match('/ideos s7 slim/i', $useragent)) {
            $deviceCode = 's7_slim';
        } elseif (preg_match('/ideos s7/i', $useragent)) {
            $deviceCode = 'ideos s7';
        } elseif (preg_match('/ideos /i', $useragent)) {
            $deviceCode = 'bm-swu300';
        } elseif (preg_match('/g510\-0100/i', $useragent)) {
            $deviceCode = 'g510-0100';
        } elseif (preg_match('/g7300/i', $useragent)) {
            $deviceCode = 'g7300';
        } elseif (preg_match('/g6609/i', $useragent)) {
            $deviceCode = 'g6609';
        } elseif (preg_match('/g6600/i', $useragent)) {
            $deviceCode = 'g6600';
        } elseif (preg_match('/g700\-u10/i', $useragent)) {
            $deviceCode = 'g700-u10';
        } elseif (preg_match('/g527\-u081/i', $useragent)) {
            $deviceCode = 'g527-u081';
        } elseif (preg_match('/g525\-u00/i', $useragent)) {
            $deviceCode = 'g525-u00';
        } elseif (preg_match('/g510/i', $useragent)) {
            $deviceCode = 'g510';
        } elseif (preg_match('/hn3\-u01/i', $useragent)) {
            $deviceCode = 'hn3-u01';
        } elseif (preg_match('/hol\-u19/i', $useragent)) {
            $deviceCode = 'hol-u19';
        } elseif (preg_match('/vie\-l09/i', $useragent)) {
            $deviceCode = 'vie-l09';
        } elseif (preg_match('/vie\-al10/i', $useragent)) {
            $deviceCode = 'vie-al10';
        } elseif (preg_match('/frd\-l09/i', $useragent)) {
            $deviceCode = 'frd-l09';
        } elseif (preg_match('/nmo\-l31/i', $useragent)) {
            $deviceCode = 'nmo-l31';
        } elseif (preg_match('/d2\-0082/i', $useragent)) {
            $deviceCode = 'd2-0082';
        } elseif (preg_match('/p8max/i', $useragent)) {
            $deviceCode = 'p8max';
        } elseif (preg_match('/4afrika/i', $useragent)) {
            $deviceCode = '4afrika';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
