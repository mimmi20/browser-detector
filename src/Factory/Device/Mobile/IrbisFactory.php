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

class IrbisFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'tz857' => 'irbis tz857',
        'tz709' => 'irbis tz709',
        'tx68'  => 'irbis tx68',
        'tx22'  => 'irbis tx22',
        'tx18'  => 'irbis tx18',
        'tx17'  => 'irbis tx17',
        'tx08'  => 'irbis tx08',
        'tg97'  => 'irbis tg97',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general irbis device';

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

        return $this->loader->load($this->genericDevice, $useragent);
    }
}
