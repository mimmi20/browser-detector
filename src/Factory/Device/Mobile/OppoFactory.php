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

class OppoFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'n1t'     => 'oppo n1t',
        'x9076'   => 'oppo x9076',
        'x9006'   => 'oppo x9006',
        'r7plusf' => 'oppo r7 plus',
        'r7kf'    => 'oppo r7 lite',
        'r7sf'    => 'oppo r7sf',
        'r7f'     => 'oppo r7f',
        'a37f'    => 'oppo a37f',
        'a33f'    => 'oppo a33f',
        'find7'   => 'oppo find7',
        'x909'    => 'oppo x909',
        'r7sm'    => 'oppo r7sm',
        'r8106'   => 'oppo r8106',
        'u705t'   => 'oppo u705t',
        'r815'    => 'oppo r815',
        'r813t'   => 'oppo r813t',
        'r831k'   => 'oppo r831k',
        '1201'    => 'oppo 1201',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general oppo device';

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
