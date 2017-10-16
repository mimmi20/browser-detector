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
use BrowserDetector\Loader\ExtendedLoaderInterface;
use Stringy\Stringy;

/**
 * @author Thomas Müller <mimmi20@live.de>
 */
class MobistelFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'cynus t8' => 'mobistel cynus t8',
        'cynus t6' => 'mobistel cynus t6',
        'cynus t5' => 'mobistel cynus t5',
        'cynus t2' => 'mobistel cynus t2',
        'cynus t1' => 'mobistel cynus t1',
        'cynus_f9' => 'mobistel cynus f9',
        'cynus f6' => 'mobistel cynus f6',
        'cynus f5' => 'mobistel cynus f5',
        'cynus f4' => 'mobistel mt-7521s',
        'cynus f3' => 'mobistel cynus f3',
        'cynus e7' => 'mobistel cynus e7',
        'cynus_e5' => 'mobistel cynus e5',
        'cynus e1' => 'mobistel cynus e1',
    ];

    /**
     * @var \BrowserDetector\Loader\ExtendedLoaderInterface
     */
    private $loader;

    /**
     * @param \BrowserDetector\Loader\ExtendedLoaderInterface $loader
     */
    public function __construct(ExtendedLoaderInterface $loader)
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
    public function detect(string $useragent, Stringy $s): array
    {
        foreach ($this->devices as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        return $this->loader->load('general mobistel device', $useragent);
    }
}
