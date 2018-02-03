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

class KarbonnFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'titanium octane' => 'karbonn titanium octane',
        'titanium s202'   => 'karbonn titanium s202',
        'titanium s5 ultra'   => 'karbonn titanium s5 ultra',
        'karbonna26'      => 'karbonn a26',
        'karbonn_a2'      => 'karbonn a2',
        'k595'            => 'karbonn k595',
        'k222s'           => 'karbonn k222s',
        'k84'             => 'karbonn k84',
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

        return $this->loader->load('general karbonn device', $useragent);
    }
}
