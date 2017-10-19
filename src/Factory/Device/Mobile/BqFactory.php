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
class BqFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'edison 3'      => 'bq edison 3',
        'aquaris x5'    => 'bq aquaris x5',
        'aquaris e5 hd' => 'bq aquaris e5 hd',
        'aquaris e5' => 'bq aquaris e5',
        'aquaris m10'   => 'bq aquaris m10',
        'aquaris m5'    => 'bq aquaris m5',
        'aquaris m4.5'  => 'bq aquaris m4.5',
        'aquaris_m4.5'  => 'bq aquaris m4.5',
        'aquaris 5 hd'  => 'bq aquaris 5 hd',
        ' m10 '         => 'bq aquaris m10',
        '7056g'         => 'bq 7056g',
        'bqs-4007'      => 'bq bqs-4007',
        'bqs-4005'      => 'bq bqs-4005',
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

        return $this->loader->load('general bq device', $useragent);
    }
}
