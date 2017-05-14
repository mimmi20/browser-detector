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
use BrowserDetector\Loader\LoaderInterface;
use Stringy\Stringy;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class SharpFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'sharp-tq-gx30i' => 'tq-gx30i',
        'sh-10d'         => 'sh-10d',
        'sh-01f'         => 'sh-01f',
        'sh8128u'        => 'sh8128u',
        'sh7228u'        => 'sh7228u',
        '306sh'          => '306sh',
        '304sh'          => '304sh',
        'sh80f'          => 'sh80f',
        'sh05c'          => 'sh-05c',
        'is05'           => 'is05',
    ];

    /**
     * @var \BrowserDetector\Loader\LoaderInterface|null
     */
    private $loader = null;

    /**
     * @param \BrowserDetector\Loader\LoaderInterface $loader
     */
    public function __construct(LoaderInterface $loader)
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
    public function detect($useragent, Stringy $s = null)
    {
        foreach ($this->devices as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        return $this->loader->load('general sharp device', $useragent);
    }
}
