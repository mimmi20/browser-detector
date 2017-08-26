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
use Stringy\Stringy;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class FreetelFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'ftj162d' => 'freetel ftj162d',
        'ftj161b' => 'freetel ftj161b',
        'ftj152d' => 'freetel ftj152d',
        'ftj152c' => 'freetel ftj152c',
        'ftj152b' => 'freetel ftj152b',
        'ftj152a' => 'freetel ftj152a',
        'ft142d'  => 'freetel ft142d',
        'ft142a'  => 'freetel ft142a',
        'ft142'   => 'freetel ft142',
        'ft141b'  => 'freetel ft141b',
    ];

    /**
     * @var \BrowserDetector\Loader\LoaderInterface|null
     */
    private $loader = null;

    /**
     * @param \BrowserDetector\Loader\LoaderInterface $loader
     */
    public function __construct(LoaderInterface $loader)
    {
        $this->loader = $loader;
    }

    /**
     * detects the device name from the given user agent
     *
     * @param string           $useragent
     * @param \Stringy\Stringy $s
     *
     * @return array
     */
    public function detect(string $useragent, Stringy $s = null): array
    {
        foreach ($this->devices as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        return $this->loader->load('general freetel device', $useragent);
    }
}
