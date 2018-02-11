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

class BluFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'studio xl 2'     => 'blu studio xl 2',
        'studio g'        => 'blu studio g',
        'vivo iv'         => 'blu vivo iv',
        'studio 7.0'      => 'blu studio 7.0',
        'studio 5.5'      => 'blu studio 5.5',
        'studio 5.0 s ii' => 'blu studio 5.0 s ii',
        'win hd w510u'    => 'blu win hd w510u',
        'win hd lte'      => 'blu win hd lte',
        'win jr w410a'    => 'blu win jr w410a',
        'win jr lte'      => 'blu win jr lte',
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

        return $this->loader->load('general blu device', $useragent);
    }
}
