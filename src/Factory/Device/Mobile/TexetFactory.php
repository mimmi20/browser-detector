<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2017, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
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
class TexetFactory implements Factory\FactoryInterface
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
        $deviceCode = 'general texet device';

        if (preg_match('/x\-pad ix 7 3g/i', $useragent)) {
            $deviceCode = 'tm-7068';
        } elseif (preg_match('/x\-pad lite 7\.1/i', $useragent)) {
            $deviceCode = 'tm-7066';
        } elseif (preg_match('/x\-pad style 7\.1 3g/i', $useragent)) {
            $deviceCode = 'tm-7058';
        } elseif (preg_match('/x\-navi/i', $useragent)) {
            $deviceCode = 'tm-4672';
        } elseif (preg_match('/tm\-3204r/i', $useragent)) {
            $deviceCode = 'tm-3204r';
        } elseif (preg_match('/tm\-7055hd/i', $useragent)) {
            $deviceCode = 'tm-7055hd';
        } elseif (preg_match('/tm\-7058hd/i', $useragent)) {
            $deviceCode = 'tm-7058hd';
        } elseif (preg_match('/tm\-7058/i', $useragent)) {
            $deviceCode = 'tm-7058';
        } elseif (preg_match('/tm\-5204/i', $useragent)) {
            $deviceCode = 'tm-5204';
        }

        return $this->loader->load($deviceCode, $useragent);
    }
}
