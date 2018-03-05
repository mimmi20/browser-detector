<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Factory\Device\Mobile;

use BrowserDetector\Factory;
use BrowserDetector\Loader\ExtendedLoaderInterface;
use Stringy\Stringy;

class BlackviewFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'bv8000pro'  => 'blackview bv8000 pro',
        'bv7000 pro' => 'blackview bv7000 pro',
        'bv6000'     => 'blackview bv6000',
        'bv5000'     => 'blackview bv5000',
        'dm550'      => 'blackview dm550',
        'omega_pro'  => 'blackview omega pro',
        'alife p1'   => 'blackview alife p1',
        'crown'      => 'blackview t570',
        ' r6 '       => 'blackview r6',
        ' a8 '       => 'blackview a8',
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

        return $this->loader->load('general blackview device', $useragent);
    }
}
