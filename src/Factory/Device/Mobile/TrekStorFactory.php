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

class TrekStorFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'surftab theatre 13.3'          => 'trekstor surftab theatre 13.3',
        'surftab breeze 10.1 quad plus' => 'trekstor surftab breeze 10.1 quad plus',
        'breeze 10.1 quad'              => 'trekstor surftab breeze 10.1 quad',
        'surftab breeze 9.6 quad 3g'    => 'trekstor surftab breeze 9.6 quad 3g',
        'surftab breeze 7.0 quad'       => 'trekstor surftab breeze 7.0 quad',
        'xintroni10.1'                  => 'trekstor surftab xintron i 10.1 3g',
        'surftab xintron i 10.1 3g'     => 'trekstor surftab xintron i 10.1 3g',
        'surftab twin 11.6 lc1'         => 'trekstor surftab twin 11.6 lc1',
        'surftab duo w1 10.1'           => 'trekstor surftab duo w1 10.1',
        'wp 4.7'                        => 'trekstor winphone 4.7 hd',
        'vt10416-2'                     => 'trekstor vt10416-2',
        'vt10416-1'                     => 'trekstor vt10416-1',
        'surftab_7.0'                   => 'trekstor st70104-1',
        'st80216'                       => 'trekstor st80216',
        'st80208'                       => 'trekstor st80208',
        'st70408_4'                     => 'trekstor st70408-4',
        'st70408-1'                     => 'trekstor st70408-1',
        'st701041'                      => 'trekstor st70104-1',
        'st70104-1'                     => 'trekstor st70104-1',
        'st70104-2'                     => 'trekstor st70104-2',
        'st10216-3'                     => 'trekstor st10216-3',
        'st10216-2'                     => 'trekstor st10216-2',
        'st10216-1'                     => 'trekstor st10216-1',
        'st10416-1'                     => 'trekstor st10416-1',
        'trekstor_liro_color'           => 'trekstor liro color',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general trekstor device';

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
