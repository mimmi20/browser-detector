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
class TplinkFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'neffos y5l'    => 'tp-link neffos y5l',
        'neffos c5 max' => 'tp-link neffos c5 max',
        'neffos c5l'    => 'tp-link neffos c5l',
        'neffos c5'     => 'tp-link neffos c5',
        'tp601a'        => 'tp-link neffos c5l',
        'tp601b'        => 'tp-link neffos c5l',
        'tp601c'        => 'tp-link neffos c5l',
        'tp601e'        => 'tp-link neffos c5l',
    ];

    /**
     * @var \BrowserDetector\Loader\ExtendedLoaderInterface
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
    public function detect(string $useragent, Stringy $s): array
    {
        foreach ($this->devices as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        return $this->loader->load('general tp-link device', $useragent);
    }
}
