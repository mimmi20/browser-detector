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

class ThlFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        't6c'      => 'thl t6c',
        't9'       => 'thl t9',
        'w200'     => 'thl w200',
        'w100'     => 'thl w100',
        ' w8'      => 'thl w8',
        'thl w7'   => 'thl w7',
        't6s'      => 'thl t6s',
        '5000'     => 'thl 5000',
        '4400'     => 'thl 4400',
        'thl 2015' => 'thl 2015',
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

        return $this->loader->load('general thl device', $useragent);
    }
}
