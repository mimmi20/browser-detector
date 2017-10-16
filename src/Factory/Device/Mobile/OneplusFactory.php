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
class OneplusFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'a5000' => 'oneplus a5000',
        'e1001' => 'oneplus e1001',
        'a3003' => 'oneplus a3003',
        'a0001' => 'oneplus a0001',
        'a3000' => 'oneplus a3000',
        'a2001' => 'oneplus a2001',
        'a2003' => 'oneplus a2003',
        'a2005' => 'oneplus a2005',
        'e1003' => 'oneplus e1003',
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

        return $this->loader->load('general oneplus device', $useragent);
    }
}
