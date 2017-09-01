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
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class DnsFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        's5701'   => 'dns s5701',
        's4505m'  => 'dns s4505m',
        's4505'   => 'dns s4505',
        's4503q'  => 'dns s4503q',
        's4502m'  => 'dns s4502m',
        's4502'   => 'dns s4502',
        's4501m'  => 'dns s4501m',
        's4008'   => 'dns s4008',
        'mb40ii1' => 'dns mb40ii1',
    ];

    /**
     * @var \BrowserDetector\Loader\ExtendedLoaderInterface|null
     */
    private $loader = null;

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
    public function detect(string $useragent, Stringy $s = null): array
    {
        foreach ($this->devices as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        return $this->loader->load('general dns device', $useragent);
    }
}
