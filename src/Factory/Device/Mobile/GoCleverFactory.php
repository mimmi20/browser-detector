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
class GoCleverFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'tq700'            => 'goclever tq700',
        'terra_101'        => 'goclever a1021',
        'insignia_785_pro' => 'goclever insignia 785 pro',
        'aries_785'        => 'goclever aries 785',
        'aries_101'        => 'goclever aries 101',
        'orion7o'          => 'goclever orion 7o',
        'quantum 4'        => 'goclever quantum 4',
        'quantum_700m'     => 'goclever quantum 700m',
        'tab a93.2'        => 'goclever a93.2',
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

        return $this->loader->load('general goclever device', $useragent);
    }
}
