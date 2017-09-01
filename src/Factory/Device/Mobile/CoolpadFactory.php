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
class CoolpadFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        '8297w'        => 'coolpad 8297w',
        '8079'         => 'coolpad 8079',
        '8076d'        => 'coolpad 8076d',
        'coolpad 5891' => 'coolpad 5891',
        '5860s'        => 'coolpad 5860s',
        'cp8676_i02'   => 'coolpad cp8676 i02',
        'cp8298_i00'   => 'coolpad cp8298 i00',
        'e561'         => 'coolpad e561',
        'e502'         => 'coolpad e502',
        'e501'         => 'coolpad e501',
        'n930'         => 'coolpad n930',
        'w713'         => 'coolpad w713',
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

        return $this->loader->load('general coolpad device', $useragent);
    }
}
