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

class ItelFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'it1702'   => 'itel it1702',
        'it1701'   => 'itel it1701',
        'it1508'   => 'itel it1508',
        '1505-a02' => 'itel 1505-a02',
        'it1503'   => 'itel it1503',
        'it1502'   => 'itel it1502',
        'it1501'   => 'itel it1501',
        'it1500'   => 'itel it1500',
        'it1452'   => 'itel it1452',
        'it1451'   => 'itel it1451',
        'it1407'   => 'itel it1407',
        'it1403+'  => 'itel it1403+',
        'it1403'   => 'itel it1403',
        'it1400'   => 'itel it1400',
        'it1351e'  => 'itel it1351e',
        'it1351'   => 'itel it1351',
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

        return $this->loader->load('general itel device', $useragent);
    }
}
