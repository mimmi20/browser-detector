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
class JaytechFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'tpc-xte10d'  => 'jaytech tpc-xte10d',
        'tpc-x10f1'   => 'jaytech tpc-x10f1',
        'tpc-xte7d'   => 'jaytech tpc-xte7d',
        'tpc-pa10.1m' => 'jaytech pa10.1m',
        'tpc-736'     => 'jaytech tpc-736',
        'tpc-pa9702'  => 'jaytech tpc-pa9702',
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

        return $this->loader->load('general jaytech device', $useragent);
    }
}
