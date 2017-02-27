<?php


namespace BrowserDetector\Version;

use Psr\Cache\CacheItemPoolInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class WindowsRt implements VersionCacheFactoryInterface
{
    /**
     * @var \Psr\Cache\CacheItemPoolInterface|null
     */
    private $cache = null;

    /**
     * @param \Psr\Cache\CacheItemPoolInterface $cache
     */
    public function __construct(CacheItemPoolInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * returns the version of the operating system/platform
     *
     * @param string $useragent
     *
     * @return \BrowserDetector\Version\Version
     */
    public function detectVersion($useragent)
    {
        $doMatch = preg_match('/Windows NT ([\d\.]+)/', $useragent, $matches);

        if ($doMatch) {
            switch ($matches[1]) {
                case '6.4':
                case '10.0':
                    $version = '10';
                    break;
                case '6.3':
                    $version = '8.1';
                    break;
                case '6.2':
                    $version = '8';
                    break;
                case '6.1':
                    $version = '7';
                    break;
                case '6.0':
                    $version = 'Vista';
                    break;
                case '5.3':
                case '5.2':
                case '5.1':
                    $version = 'XP';
                    break;
                case '5.0':
                case '5.01':
                    $version = '2000';
                    break;
                case '4.1':
                case '4.0':
                    $version = 'NT';
                    break;
                default:
                    $version = '0.0';
                    break;
            }

            return VersionFactory::set($version);
        }

        $doMatch = preg_match('/Windows ([\d\.a-zA-Z]+)/', $useragent, $matches);

        if ($doMatch) {
            switch ($matches[1]) {
                case '6.4':
                case '10.0':
                    $version = '10';
                    break;
                case '6.3':
                    $version = '8.1';
                    break;
                case '6.2':
                    $version = '8';
                    break;
                case '6.1':
                case '7':
                    $version = '7';
                    break;
                case '6.0':
                    $version = 'Vista';
                    break;
                case '2003':
                    $version = 'Server 2003';
                    break;
                case '5.3':
                case '5.2':
                case '5.1':
                case 'XP':
                    $version = 'XP';
                    break;
                case 'ME':
                    $version = 'ME';
                    break;
                case '2000':
                case '5.0':
                case '5.01':
                    $version = '2000';
                    break;
                case '3.1':
                    $version = '3.1';
                    break;
                case '95':
                    $version = '95';
                    break;
                case '98':
                    $version = '98';
                    break;
                case '4.1':
                case '4.0':
                case 'NT':
                    $version = 'NT';
                    break;
                default:
                    $version = '0.0';
                    break;
            }

            return VersionFactory::set($version);
        }

        return new Version(0);
    }
}
