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
class AlcatelFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general alcatel device';

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)8008d/i', $useragent)) {
            $deviceCode = 'ot-8008d';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)8000d/i', $useragent)) {
            $deviceCode = 'ot-8000d';
        } elseif (preg_match('/7049d/i', $useragent)) {
            $deviceCode = 'ot-7049d';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)7047d/i', $useragent)) {
            $deviceCode = 'ot-7047d';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)7041x/i', $useragent)) {
            $deviceCode = 'ot-7041x';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)7041d/i', $useragent)) {
            $deviceCode = 'ot-7041d';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)7025d/i', $useragent)) {
            $deviceCode = 'ot-7025d';
        } elseif (preg_match('/6050a/i', $useragent)) {
            $deviceCode = 'ot-6050a';
        } elseif (preg_match('/6043d/i', $useragent)) {
            $deviceCode = 'ot-6043d';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)6040d/i', $useragent)) {
            $deviceCode = 'ot-6040d';
        } elseif (preg_match('/6036y/i', $useragent)) {
            $deviceCode = 'ot-6036y';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)6035r/i', $useragent)) {
            $deviceCode = 'ot-6035r';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)6034r/i', $useragent)) {
            $deviceCode = 'ot-6034r';
        } elseif (preg_match('/4034d/i', $useragent)) {
            $deviceCode = 'ot-4034d';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)6033x/i', $useragent)) {
            $deviceCode = 'ot-6033x';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)6032/i', $useragent)) {
            $deviceCode = 'ot-6032';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)6030x/i', $useragent)) {
            $deviceCode = 'ot-6030x';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)6030d/i', $useragent)) {
            $deviceCode = 'ot-6030d';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)6015x/i', $useragent)) {
            $deviceCode = 'ot-6015x';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)6012d/i', $useragent)) {
            $deviceCode = 'ot-6012d';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)6010x/i', $useragent)) {
            $deviceCode = 'ot-6010x';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)6010d/i', $useragent)) {
            $deviceCode = 'ot-6010d';
        } elseif (preg_match('/5042d/i', $useragent)) {
            $deviceCode = 'ot-5042d';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)5036d/i', $useragent)) {
            $deviceCode = 'ot-5036d';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)5035d/i', $useragent)) {
            $deviceCode = 'ot-5035d';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)5020d/i', $useragent)) {
            $deviceCode = 'ot-5020d';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)4037t/i', $useragent)) {
            $deviceCode = 'ot-4037t';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)4030x/i', $useragent)) {
            $deviceCode = 'ot-4030x';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)4030d/i', $useragent)) {
            $deviceCode = 'ot-4030d';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)4015x/i', $useragent)) {
            $deviceCode = 'ot-4015x';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)4015d/i', $useragent)) {
            $deviceCode = 'ot-4015d';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)4012x/i', $useragent)) {
            $deviceCode = 'ot-4012x';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)4012a/i', $useragent)) {
            $deviceCode = 'ot-4012a';
        } elseif (preg_match('/3075A/', $useragent)) {
            $deviceCode = 'ot-3075a';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)997d/i', $useragent)) {
            $deviceCode = 'ot-997d';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)995/i', $useragent)) {
            $deviceCode = 'ot-995';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)992d/i', $useragent)) {
            $deviceCode = 'ot-992d';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)991t/i', $useragent)) {
            $deviceCode = 'ot-991t';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)991d/i', $useragent)) {
            $deviceCode = 'ot-991d';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)991/i', $useragent)) {
            $deviceCode = 'ot-991';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)990/i', $useragent)) {
            $deviceCode = 'ot-990';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)985d/i', $useragent)) {
            $deviceCode = 'ot-985d';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)980/i', $useragent)) {
            $deviceCode = 'ot-980';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)918d/i', $useragent)) {
            $deviceCode = 'ot-918d';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)918/i', $useragent)) {
            $deviceCode = 'ot-918';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)908/i', $useragent)) {
            $deviceCode = 'ot-908';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)903d/i', $useragent)) {
            $deviceCode = 'ot-903d';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)890d/i', $useragent)) {
            $deviceCode = 'one touch 890d';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)890/i', $useragent)) {
            $deviceCode = 'ot-890';
        } elseif (preg_match('/OT871A/', $useragent)) {
            $deviceCode = 'ot-871a';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)818/i', $useragent)) {
            $deviceCode = 'ot-818';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)710d/i', $useragent)) {
            $deviceCode = 'ot-710d';
        } elseif (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)216/i', $useragent)) {
            $deviceCode = 'ot-216';
        } elseif (preg_match('/Vodafone 975N/', $useragent)) {
            $deviceCode = '975n';
        } elseif (preg_match('/(V860|Vodafone Smart II)/', $useragent)) {
            $deviceCode = 'v860';
        } elseif (preg_match('/P321/', $useragent)) {
            $deviceCode = 'ot-p321';
        } elseif (preg_match('/P320X/', $useragent)) {
            $deviceCode = 'ot-p320x';
        } elseif (preg_match('/P310X/', $useragent)) {
            $deviceCode = 'ot-p310x';
        } elseif (preg_match('/P310A/', $useragent)) {
            $deviceCode = 'ot-p310a';
        } elseif (preg_match('/ONE TOUCH TAB 8HD/', $useragent)) {
            $deviceCode = 'ot-tab8hd';
        } elseif (preg_match('/ONE TOUCH TAB 7HD/', $useragent)) {
            $deviceCode = 'ot-tab7hd';
        } elseif (preg_match('/ALCATEL ONE TOUCH Fierce/', $useragent)) {
            $deviceCode = 'fierce';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
