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
class ArnovaFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        '101 g4'   => 'arnova 101 g4',
        'an10dg3'  => 'arnova 10d g3',
        'an10bg3'  => 'arnova an10bg3',
        'an9g2i'   => 'arnova 9 g2',
        'an7fg3'   => 'arnova 7f g3',
        'an7dg3'   => 'arnova 7d g3',
        'an7cg2'   => 'arnova 7c g2',
        'an7bg2dt' => 'arnova 7b g2 dt',
        'archm901' => 'arnova archm901',
    ];

    /**
     * @var \BrowserDetector\Loader\LoaderInterface|null
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

        return $this->loader->load('general arnova device', $useragent);
    }
}
